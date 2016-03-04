<?php

namespace App\Http\Controllers;

set_time_limit(0); //Never timeout
ini_set('memory_limit', '4096M');

use DB;
use App\Urldetail;
use App\Cache;
use App\Invertedindex;
use App\Library\BTree;
use App\Library\BOperation;
use App\Library\WaveletTree;
use App\Library\WaveletOperation;
use App\Library\RNode;
use App\Library\RTree;
use App\Library\ROperation;
use App\Library\RStarOperation;
use App\Library\SpatialWaveletNode;
use App\Library\SpatialWaveletTree;
use App\Library\SpatialWaveletOperation;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function convert($size)
    {
        $unit=array('b','kb','mb','gb','tb','pb');
        return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
    }
    public function search(Request $request) 
    {
        $result_ts = NULL; $result_ls = NULL; $result_al = NULL;
        if(null !== $request->input('text_technique')) 
        {
            $text_technique = $request->input('text_technique');
        }
        else
        {
$text_technique = 'text_b_tree'; //Default b-tree used for text search
} 

if(null !== $request->input('location_technique'))
{
    $location_technique = $request->input('location_technique');
}
else
{
$location_technique = 'location_wavelet'; //Default wavelet-tree used for location search
} 

//Location Search
if($result_ls = $this->query_getlocation($request->input('query'))) {
    if($location_technique === 'location_r_tree') {$result_al = $this->search_location_rtree($request->input('query'),$result_ls);}
    if($location_technique === 'location_rstar_tree') {$result_al = $this->search_location_rstartree($request->input('query'),$result_ls);}
    if($location_technique === 'location_wavelet') {$result_al = $this->search_location_wavelettree($request->input('query'),$result_ls);}
}

//Text Search text_technique selection based
if($text_technique === 'text_b_tree') {$result_ts = $this->search_text_btree($request->input('query'));}
if($text_technique === 'text_wavelet') {$result_ts = $this->search_text_wavelettree($request->input('query'));}

//Making search log
DB::insert('INSERT IGNORE INTO searchlogtable (ip, keyword, textual_search_indexing_technique, textual_search_space_kb, textual_search_time, location_search_indexing_technique, location_search_space_kb, location_search_time) values (?, ?, ?, ?, ?, ?, ? ,?)', [$request->input('client_IP'), $request->input('query'), $request->input('text_technique'), ($result_ts[4]/1024), $result_ts[3], $result_ls?$request->input('location_technique'):'none', ($result_al[11]/1024), $result_al[10]]);

//Check if record exists in cache
$exist_in_cache = Cache::where('search_query', $request->input('query'))->orderBy('occurrence', 'desc')->take(1000)->get();
if($exist_in_cache->count()>0) {
    return view("search_result")->with('results',$exist_in_cache)->with('location',$result_ls)->with('actuallocation',$result_al)->with('query',$request->input('query'))->with('text_technique',$request->input('text_technique'))->with('location_technique',$request->input('location_technique'));
}

//Insert the result into database cache
foreach ($result_ts[0] as $doc) {
    $cache_record = new Cache;
    $urldetail_record = Urldetail::where('id', '=', $doc)->firstOrFail();
    $cache_record->search_query = $request->input('query');
    $cache_record->doc_title = $urldetail_record->title;
    $cache_record->doc_url = $urldetail_record->url;
    $occurrence = 0;
    $keywords = array();
    $search_query = explode(' ',strtolower($request->input('query')));
    $temp = explode(' ',$urldetail_record->keywords);
    foreach ($temp as $key) {
        $keyparts = explode('-', $key);
        array_push($keywords, $keyparts[0]);
        if (in_array($keyparts[0], $search_query)){$occurrence+=$keyparts[1];}
    }
    $keywords = implode(" ",$keywords);
    $cache_record->doc_keywords = $keywords;
    $cache_record->occurrence = $occurrence;
    $cache_record->save();
}
//Retrieving from cache for easy filters
$exist = Cache::where('search_query', $request->input('query'))->orderBy('occurrence', 'desc')->take(100)->get();
return view("search_result")->with('results',$exist)->with('location',$result_ls)->with('actuallocation',$result_al)->with('query',$request->input('query'))->with('text_technique',$request->input('text_technique'))->with('location_technique',$request->input('location_technique'));
}

//Linear search for location (used for 'in' Query)
public function query_getlocation($query) {
    $word = array();
    $word = explode(' ',strtolower($query));
    $data = NULL;
    foreach ($word as $keyword) {
        if(!ctype_alnum($keyword)) continue;
//upto level 5 code 
        $location = DB::table('locations')->where('name_0', $keyword)->orWhere('name_1', $keyword)->orWhere('name_2', $keyword)->orWhere('name_3', $keyword)->orWhere('name_4', $keyword)->orWhere('name_5', $keyword)->first();
//upto level 4 code
//$location = DB::table('locations')->where('name_0', $keyword)->orWhere('name_1', $keyword)->orWhere('name_2', $keyword)->orWhere('name_3', $keyword)->orWhere('name_4', $keyword)->first();
//upto level 3 code
//$location = DB::table('locations')->where('name_0', $keyword)->orWhere('name_1', $keyword)->orWhere('name_2', $keyword)->orWhere('name_3', $keyword)->first();
//upto level 2 code
//$location = DB::table('locations')->where('name_0', $keyword)->orWhere('name_1', $keyword)->orWhere('name_2', $keyword)->first();
//upto level 1 code
//$location = DB::table('locations')->where('name_0', $keyword)->orWhere('name_1', $keyword)->first();
        if(isset($location))
            if(!is_null($location))
            {
                if(isset($location->name_0))
                {
                    if($keyword==$location->name_0)
                        {$data = array(0,$location->name_0,$location->lat,$location->lon,$location->xmin,$location->ymin,$location->xmax,$location->ymax);}
                }

                if(isset($location->name_1))
                {
                    if($keyword==$location->name_1)
                        {$data = array(1,$location->name_1,$location->lat,$location->lon,$location->xmin,$location->ymin,$location->xmax,$location->ymax,$location->name_0);}
                }

                if(isset($location->name_2))
                {
                    if($keyword==$location->name_2)
                        {$data = array(2,$location->name_2,$location->lat,$location->lon,$location->xmin,$location->ymin,$location->xmax,$location->ymax,$location->name_1);}
                }

                if(isset($location->name_3))
                {
                    if($keyword==$location->name_3)
                        {$data = array(3,$location->name_3,$location->lat,$location->lon,$location->xmin,$location->ymin,$location->xmax,$location->ymax,$location->name_2);}
                }

                if(isset($location->name_4))
                {
                    if($keyword==$location->name_4)
                        {$data = array(4,$location->name_4,$location->lat,$location->lon,$location->xmin,$location->ymin,$location->xmax,$location->ymax,$location->name_3);}
                }

                if(isset($location->name_5)) 
                {
                    if($keyword==$location->name_5)
                        {$data = array(5,$location->name_5,$location->lat,$location->lon,$location->xmin,$location->ymin,$location->xmax,$location->ymax,$location->name_4);}
                }
            }
        }
        return $data;
    }

//R search for location (used for 'near' Query)
    public function search_location_rtree($query,$location) {
        $data=NULL;
        $rtree = new RTree();
        $rtreeop = new ROperation();
        $start_creation_time = microtime(true);
        $start_creation_memory = memory_get_usage(false);
        try {
            $keyword = $query;
            $level = $location[0];
            $loc = $location[1];
            $querylat = $location[2];
            $querylon = $location[3];
            $queryl2 = $location[4];
            $queryl1 = $location[5];
            $queryu2 = $location[6];
            $queryu1 = $location[7];
            if($level !== 0) {$supname = $location[8];}
            if($level == 0) {
                $super = array(-180, 180, -90, 90);
            }
            else {
                $levelup = DB::table('locations')->where('name_'.($level-1), $supname)->where('name_'.($level), NULL)->first();
//$levelup = $this->query_getlocation($supname);
                $supxmin = $levelup->xmin;
                $supymin = $levelup->ymin;
                $supxmax = $levelup->xmax;
                $supymax = $levelup->ymax;
                $super = array($supxmin, $supxmax, $supymin, $supymax);
            }
// insert the boundaries in the rtree
            $rtree->insert($super);

            $stop_creation_time = microtime(true);
            $stop_creation_memory = memory_get_usage(false);
            /*rtree creation ends*/

            /*searching starts*/
            $start_search_time = microtime(true);
            $start_search_memory = memory_get_usage(false);
            $temp = $rtree->currentNode();
            $key = array($queryl2, $queryu2, $queryl1, $queryu1);

// find the region intersecting
            $region = $rtreeop->search($temp, $key, 3);
            /*searching ends*/
            $stop_search_time = microtime(true);
            $stop_search_memory = memory_get_usage(false);

            $creation_time = $stop_creation_time - $start_creation_time;
            $creation_memory = $stop_creation_memory - $start_creation_memory;
            $search_time = $stop_search_time - $start_search_time;
            $search_memory = $stop_search_memory - $start_search_memory;
            $data=array($location[0],$location[1],$location[2],$location[3],$region[0],$region[2],$region[1],$region[3],$creation_time,$creation_memory,$search_time,$search_memory);
// $foundminx = $region[0];
// $foundmaxx = $region[1];
// $foundminy = $region[2];
// $foundmaxy = $region[3];
        }
        catch(Exception $e) {
// do nothing
        }
        return $data;
    }

//R* search for location (used for 'near' Query)
    public function search_location_rstartree($query,$location) {
        $rtree = new RTree();
        $rstartreeop = new RStarOperation();
        $start_creation_time = microtime(true);
        $start_creation_memory = memory_get_usage(false);
        try {
            $keyword = $query;
            $level = $location[0];
            $loc = $location[1];
            $querylat = $location[2];
            $querylon = $location[3];
            $queryl2 = $location[4];
            $queryl1 = $location[5];
            $queryu2 = $location[6];
            $queryu1 = $location[7];
            if($level !== 0) {$supname = $location[8];}
            if($level == 0) {
                $super = array(-180, 180, -90, 90);
            }
            else {
                $levelup = DB::table('locations')->where('name_'.($level-1), $supname)->where('name_'.($level), NULL)->first();
//$levelup = $this->query_getlocation($supname);
                $supxmin = $levelup->xmin;
                $supymin = $levelup->ymin;
                $supxmax = $levelup->xmax;
                $supymax = $levelup->ymax;
                $super = array($supxmin, $supxmax, $supymin, $supymax);
            }
// insert the boundaries in the rtree
            $rtree->insert($super);

            $stop_creation_time = microtime(true);
            $stop_creation_memory = memory_get_usage(false);
            /*rtree creation ends*/

            /*searching starts*/
            $start_search_time = microtime(true);
            $start_search_memory = memory_get_usage(false);
            $temp = $rtree->currentNode();
            $key = array($queryl2, $queryu2, $queryl1, $queryu1);

// find the region intersecting
            $region = $rstartreeop->search($temp, $key, 5);
            /*searching starts*/
            $stop_search_time = microtime(true);
            $stop_search_memory = memory_get_usage(false);

            $creation_time = $stop_creation_time - $start_creation_time;
            $creation_memory = $stop_creation_memory - $start_creation_memory;
            $search_time = $stop_search_time - $start_search_time;
            $search_memory = $stop_search_memory - $start_search_memory;
            $data=array($location[0],$location[1],$location[2],$location[3],$region[0],$region[2],$region[1],$region[3],$creation_time,$creation_memory,$search_time,$search_memory);
// $foundminx = $region[0];
// $foundmaxx = $region[1];
// $foundminy = $region[2];
// $foundmaxy = $region[3];
        }

        catch(Exception $e) {
// do  nothing
        }
        return $data;
    }

//Wavelet search for location (used for 'near' Query)
    public function search_location_wavelettree($query,$location) {
        $keydir = "none";
        if(strpos($query, 'north')!==false){$keydir = "north";}
        if(strpos($query, 'south')!==false){$keydir = "south";}
        if(strpos($query, 'east')!==false){$keydir = "east";}
        if(strpos($query, 'west')!==false){$keydir = "west";}
        if(strpos($query, 'right')!==false){$keydir = "east";}
        if(strpos($query, 'left')!==false){$keydir = "west";}
        if(strpos($query, 'top')!==false){$keydir = "north";}
        if(strpos($query, 'bottom')!==false){$keydir = "south";}
        $data=NULL;
        $swtreelat = new SpatialWaveletTree();
        $swtreelon = new SpatialWaveletTree();
        $swtreeop = new SpatialWaveletOperation();
        /* create dictionary starts*/
        $start_creation_time = microtime(true);
        $start_creation_memory = memory_get_usage(false);
        try {
            $keyword = $query;
            $level = $location[0];
            $loc = $location[1];
            $querylat = $location[2];
            $querylon = $location[3];
            $queryl2 = $location[4];
            $queryl1 = $location[5];
            $queryu2 = $location[6];
            $queryu1 = $location[7];
            if($level !== 0) {$supname = $location[8];}
            $positions = array();
            $loc1 = array();
            $loc2 = array();
            $list;
            if(isset($level)) {
                if($level == 0) {
                    $distlat = $queryu1 - $queryl1;
                    $distlon = $queryu2 - $queryl2;
                    $supxmax = $querylon + $distlon;
                    $supxmin = $querylon - $distlon;
                    $supymax = $querylat + $distlat;
                    $supymin = $querylat - $distlat;
                    if($supxmin < -180.00)
                        $supxmin = -180.00;
                    if($supxmax > 180.00)
                        $supxmax = 180.00;
                    $super = array($supxmin, $supxmax, $supymin, $supymax);
                }
                else {
                    $levelup = DB::table('locations')->where('name_'.($level-1), $supname)->where('name_'.($level), NULL)->first();
                    $supxmin = $levelup->xmin;
                    $supymin = $levelup->ymin;
                    $supxmax = $levelup->xmax;
                    $supymax = $levelup->ymax;
                    $super = array($supxmin, $supxmax, $supymin, $supymax);
                }
                if($keydir!=="none") {
                    if($keydir == "east")
                        $supxmin = $queryu2;
                    if($keydir == "west")
                        $supxmax = $queryl2;
                    if($keydir == "north")
                        $supymin = $queryu1;
                    if($keydir == "south")
                        $supymax = $queryl1;
                    if($keydir == "north east") {
                        $supxmin = $queryu2;
                        $supymin = $queryu1;
                    }
                    if($keydir == "south west") {
                        $supxmin = $queryu2;
                        $supymax = $queryl1;
                    }
                    if($keydir == "south east") {
                        $supxmax = $queryl2;
                        $supymin = $queryu1;
                    }
                    if($keydir == "north west") {
                        $supxmax = $queryl2;
                        $supymax = $queryl1;
                    }
                    $super = array($supxmin, $supxmax, $supymin, $supymax);     
                }
                // if($keydir!=="none") {
                //     if($keydir == "east")
                //         $supxmin = ($queryu2+$queryl2)/2;
                //     if($keydir == "west")
                //         $supxmax = ($queryu2+$queryl2)/2;
                //     if($keydir == "north")
                //         $supymin = ($queryu1+$queryl1)/2;
                //     if($keydir == "south")
                //         $supymax = ($queryu1+$queryl1)/2;
                //     if($keydir == "north east") {
                //         $supxmin = ($queryu2+$queryl2)/2;
                //         $supymin = ($queryu1+$queryl1)/2;
                //     }
                //     if($keydir == "south west") {
                //         $supxmin = ($queryu2+$queryl2)/2;
                //         $supymax = ($queryu1+$queryl1)/2;
                //     }
                //     if($keydir == "south east") {
                //         $supxmax = ($queryu2+$queryl2)/2;
                //         $supymin = ($queryu1+$queryl1)/2;
                //     }
                //     if($keydir == "north west") {
                //         $supxmax = ($queryu2+$queryl2)/2;
                //         $supymax = ($queryu1+$queryl1)/2;
                //     }
                //     $super = array($supxmin, $supxmax, $supymin, $supymax);     
                // }
                if($level < 5){$next =DB::table('locations')->where('name_'.$level, $loc)->whereNotNull('name_'.($level+1))->count();}
                else $next = 0;
                if($next == 0 && $level != 5) {
                    if($level <= 3){$list = DB::table('locations')->where('xmin','<=', $supxmax)->where('xmax','>=', $supxmin)->where('ymin','<=', $supymax)->where('ymax','>=', $supymin)->whereNotNull('name_'.($level).'')->whereNull('name_'.($level+1).'')->get();}
                    if($level == 4){$list = DB::table('locations')->where('xmin','<=', $supxmax)->where('xmax','>=', $supxmin)->where('ymin','<=', $supymax)->where('ymax','>=', $supymin)->whereNotNull('name_'.($level).'')->whereNull('name_'.($level+1).'')->get();}
                    if($level == 5){$list = DB::table('locations')->where('xmin','<=', $supxmax)->where('xmax','>=', $supxmin)->where('ymin','<=', $supymax)->where('ymax','>=', $supymin)->whereNotNull('name_'.($level).'')->whereNull('name_'.($level+1).'')->get();}
                }
                else {
                    if($level <= 3){$list = DB::table('locations')->where('xmin','<=', $supxmax)->where('xmax','>=', $supxmin)->where('ymin','<=', $supymax)->where('ymax','>=', $supymin)->whereNotNull('name_'.($level+1).'')->whereNull('name_'.($level+2).'')->get();}
                    if($level == 4){$list = DB::table('locations')->where('xmin','<=', $supxmax)->where('xmax','>=', $supxmin)->where('ymin','<=', $supymax)->where('ymax','>=', $supymin)->whereNotNull('name_'.($level+1).'')->whereNull('name_'.($level+2).'')->get();}
                    if($level == 5){$list = DB::table('locations')->where('xmin','<=', $supxmax)->where('xmax','>=', $supxmin)->where('ymin','<=', $supymax)->where('ymax','>=', $supymin)->whereNotNull('name_'.($level+1).'')->whereNull('name_'.($level+2).'')->get();}
                }

                $glat; $glon; $slat; $slon; $minu1; $minu2;
                $count = 0;
                foreach ($list as $row) {
                    $l1 = $row->ymin * 1.0;
                    $u1 = $row->ymax * 1.0;
                    $l2 = $row->xmin * 1.0;
                    $u2 = $row->xmax * 1.0;
                    if($count == 0) {
                        $glat = $u1; $glon = $u2; $slat = $l1; $slon = $l2;
                        $minu1 = $u1;
                        $minu2 = $u2;
                    }
                    else {
                        if($glat < $u1)
                            $glat = $u1;
                        if($glon < $u2)
                            $glon = $u2;
                        if($slat > $l1)
                            $slat = $l1;
                        if($slon > $l2)
                            $slon = $l2;
                        if($minu1 > $u1)
                            $minu1 = $u1;
                        if($minu2 > $u2)
                            $minu2 = $u2;
                    }
                    if($level==0){$locname = $row->name_0;}
                    if($level==1){$locname = $row->name_1;}
                    if($level==2){$locname = $row->name_2;}
                    if($level==3){$locname = $row->name_3;}
                    if($level==4){$locname = $row->name_4;}
                    if($level==5){$locname = $row->name_5;}

                    $locid = $row->id;
                    $loc1[$count] = array($locid, $l1, $u1, $locname);
                    $loc2[$count] = array($locid, $l2, $u2, $locname);
                    $count++;
                }
                /* create dictionary ends*/

                /*wavelet creation starts*/
                $A = array();
                $B = array();
                $C = array();
                $D = array();
                $n = count($loc1);
                $range = ($glat + $minu1)/2;
                $i = 0;
                foreach($loc1 as $k=>$v) {
                    $C[$i] = $v[0];
                    $D[$i] = $v[3];
                    $val = $v[2];
                    $A[$i] = $val;
                    if($val <= $range)
                        $B[$i] = 0;
                    else $B[$i] = 1;
                    $i++;
                }
                $swtreelat->insert($A, $B, $C, $D);

                $n = count($loc2);
                $range = ($glon + $minu2)/2;
                $i = 0;
                foreach($loc2 as $k=>$v) {
                    $C[$i] = $v[0];
                    $val = $v[2];
                    $A[$i] = $val;
                    if($val <= $range)
                        $B[$i] = 0;
                    else $B[$i] = 1;
                    $i++;
                }
                $swtreelon->insert($A, $B, $C);

                $stop_creation_time = microtime(true);
                $stop_creation_memory = memory_get_usage(false);
                /*wavelet creation ends*/

                /*searching starts*/
                $start_search_time = microtime(true);
                $start_search_memory = memory_get_usage(false);
                $x = array(); $y =array();
                foreach($loc1 as $k=>$llu) {
// echo $llu[1]." ".$llu[2]." ".$loc2[$k][1]." ".$loc2[$k][2]."<br>";
                    if($queryu1 >= $llu[1] && $queryl1 <= $llu[2] ) {
                        $temp = $swtreelat->currentNode();
                        $tpos = $k;
                        array_push($x, $swtreeop->display($temp, $tpos));
                    }
                }

                foreach($loc2 as $k=>$llu) {
                    if($queryu2 >= $llu[1] && $queryl2 <= $llu[2] ) {
                        $temp = $swtreelon->currentNode();
                        $tpos = $k;
                        array_push($y, $swtreeop->display($temp, $tpos));
                    }
                }
                asort($x); asort($y);
                $z = array_unique(array_intersect($x, $y));
                $regionxmin=180;$regionymin=180;$regionxmax=-180;$regionymax=-180;
                foreach ($z as $key => $value) {
                    $record = DB::table('locations')->where('id',$value)->first();
                    if($record->xmin<$regionxmin) {$regionxmin=$record->xmin;}
                    if($record->ymin<$regionymin) {$regionymin=$record->ymin;}
                    if($record->xmax>$regionxmax) {$regionxmax=$record->xmax;}
                    if($record->ymax>$regionymax) {$regionymax=$record->ymax;}
                }
                /*searching ends*/
                $stop_search_time = microtime(true);
                $stop_search_memory = memory_get_usage(false);

                $creation_time = $stop_creation_time - $start_creation_time;
                $creation_memory = $stop_creation_memory - $start_creation_memory;
                $search_time = $stop_search_time - $start_search_time;
                $search_memory = $stop_search_memory - $start_search_memory;
                $data=array($location[0],$location[1],$location[2],$location[3],$regionxmin,$regionymin,$regionxmax,$regionymax,$creation_time,$creation_memory,$search_time,$search_memory);
            }
        }
        catch(Exception $e) {
// do nothing
        }
//Make data
        return $data;
    }

    public function search_text_wavelettree($query) {
        $keyword = $query;
        $keys = explode(' ', $keyword);
        $wtree = new WaveletTree();
        $wtreeop = new WaveletOperation();
        $keydoclist = Invertedindex::all();
        $groupedkeydoclist = $keydoclist->toArray();

        $keyarray = array();
        $doc = array();
        foreach($groupedkeydoclist as $d) {  
            array_push($keyarray, $d['keyword']);
            array_push($doc, $d['docid']); 
        }

        /*wavelet creation starts*/
        $start_creation_time = microtime(true);
        $start_creation_memory = memory_get_usage(false);
        $A = array();
        $B = array();
        $n = count($doc);
        $docn = collect($doc)->unique()->count();
        for($i = 0; $i<$n; $i++) {
            $val = $doc[$i];
            $A[$i] = $val;
            if($val <=$docn/2)
                $B[$i] = 0;
            else $B[$i] = 1;
        }
        $x = $wtree->insert($A, $B);
        $stop_creation_time = microtime(true);
        $stop_creation_memory = memory_get_usage(false);
        /*wavelet creation ends*/

        /*searching starts*/
// Time before searching
        $start_search_time = microtime(true);
        $start_search_memory = memory_get_usage(false);
        $x = array();
        foreach($keys as $keyword) {
            $keyword = strtolower($keyword);
            foreach($keyarray as $k=>$kd) {
                if($keyword == $kd) {
                    $temp = $wtree->currentNode();
                    $tpos = $k;
                    $va = $wtreeop->display($temp, $tpos);
                    array_push($x, $va);
                }
            }
        }
        $temp = array();
        foreach ($x as $key => $value) {
            array_push($temp, $value);
        }
        $result = collect($temp)->unique();
// Time after searching
        $stop_search_time = microtime(true);
        $stop_search_memory = memory_get_usage(false);

        $creation_time = $stop_creation_time - $start_creation_time;
        $creation_memory = $stop_creation_memory - $start_creation_memory;
        $search_time = $stop_search_time - $start_search_time;
        $search_memory = $stop_search_memory - $start_search_memory;
        return array($result->toArray(),$creation_time,$creation_memory,$search_time,$search_memory);
    }

    public function search_text_btree($query) {
        $keyword = $query;
        $keys = explode(' ', $keyword);
        $btree = new BTree();
        $btreeop = new BOperation();
        $keydoclist = Invertedindex::all();
        $groupedkeydoclist = $keydoclist->groupBy('keyword')->toArray();

        /*btree creation starts*/
        $start_creation_time = microtime(true);
        $start_creation_memory = memory_get_usage(false);
        foreach($groupedkeydoclist as $w=>$d) {
            $item = array($w, $d);
            $btree->insert($item);
        }
        $stop_creation_time = memory_get_usage(true);
        $stop_creation_memory = memory_get_usage(false);
        /*btree creation ends*/

        /*searching starts*/
// Time before searching
        $start_search_time = microtime(true);
        $start_search_memory = memory_get_usage(false);
        $x = array();
        foreach($keys as $keyword) {
            $keyword = strtolower($keyword);
            $temp = $btree->currentNode();
            $d = $btreeop->search($temp, $keyword);
            if($d)
                foreach($d as $w) {
                    array_push($x, $w['docid']);
                }
            }
            $result = collect($x)->unique();
// Time after searching
            $stop_search_time = microtime(true);
            $stop_search_memory = memory_get_usage(false);

            $creation_time = $stop_creation_time - $start_creation_time;
            $creation_memory = $stop_creation_memory - $start_creation_memory;
            $search_time = $stop_search_time - $start_search_time;
            $search_memory = $stop_search_memory - $start_search_memory;
            return array($result->toArray(),$creation_time,$creation_memory,$search_time,$search_memory);
        }
    }
