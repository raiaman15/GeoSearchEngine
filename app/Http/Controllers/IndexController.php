<?php

namespace App\Http\Controllers;

use DB;
use App\Settings;
use App\Invertedindex;
use App\Urldetail;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
  public function displaySettings() {
    $settings = Settings::all();
    if(count($settings)>1){
//do nothing
    }
    else{
      $setobj1 = new Settings;
      $setobj1->parameter = 'textual_btree';
      $setobj1->value = 'Y';
      $setobj1->save();
      $setobj2 = new Settings;
      $setobj2->parameter = 'textual_wavelet';
      $setobj2->value = 'Y';
      $setobj2->save();
      $setobj3 = new Settings;
      $setobj3->parameter = 'dual_rtree_btree';
      $setobj3->value = 'Y';
      $setobj3->save();
      $setobj4 = new Settings;
      $setobj4->parameter = 'dual_rtree_wavelet';
      $setobj4->value = 'Y';
      $setobj4->save();
      $setobj5 = new Settings;
      $setobj5->parameter = 'dual_rstartree_btree';
      $setobj5->value = 'Y';
      $setobj5->save();
      $setobj6 = new Settings;
      $setobj6->parameter = 'dual_rstartree_wavelet';
      $setobj6->value = 'Y';
      $setobj6->save();
      $setobj7 = new Settings;
      $setobj7->parameter = 'dual_wavelet_btree';
      $setobj7->value = 'Y';
      $setobj7->save();
      $setobj8 = new Settings;
      $setobj8->parameter = 'dual_wavelet_wavelet';
      $setobj8->value = 'Y';
      $setobj8->save();
      $setobj9 = new Settings;
      $setobj9->parameter = 'hybrid_keyword_spatial_rtree_btree';
      $setobj9->value = 'Y';
      $setobj9->save();
      $setobj10 = new Settings;
      $setobj10->parameter = 'hybrid_spatial_keyword_rtree_btree';
      $setobj10->value = 'Y';
      $setobj10->save();
      $setobj11 = new Settings;
      $setobj11->parameter = 'hybrid_keyword_spatial_rtree_wavelet';
      $setobj11->value = 'Y';
      $setobj11->save();
      $setobj12 = new Settings;
      $setobj12->parameter = 'hybrid_spatial_keyword_rtree_wavelet';
      $setobj12->value = 'Y';
      $setobj12->save();
      $setobj13 = new Settings;
      $setobj13->parameter = 'hybrid_keyword_spatial_rstartree_btree';
      $setobj13->value = 'Y';
      $setobj13->save();
      $setobj14 = new Settings;
      $setobj14->parameter = 'hybrid_spatial_keyword_rstartree_btree';
      $setobj14->value = 'Y';
      $setobj14->save();
      $setobj15 = new Settings;
      $setobj15->parameter = 'hybrid_keyword_spatial_rstartree_wavelet';
      $setobj15->value = 'Y';
      $setobj15->save();
      $setobj16 = new Settings;
      $setobj16->parameter = 'hybrid_spatial_keyword_rstartree_wavelet';
      $setobj16->value = 'Y';
      $setobj16->save();
      $setobj17 = new Settings;
      $setobj17->parameter = 'hybrid_keyword_spatial_wavelet_btree';
      $setobj17->value = 'Y';
      $setobj17->save();
      $setobj18 = new Settings;
      $setobj18->parameter = 'hybrid_spatial_keyword_wavelet_btree';
      $setobj18->value = 'Y';
      $setobj18->save();
      $setobj19 = new Settings;
      $setobj19->parameter = 'hybrid_keyword_spatial_wavelet_wavelet';
      $setobj19->value = 'Y';
      $setobj19->save();
      $setobj20 = new Settings;
      $setobj20->parameter = 'hybrid_spatial_keyword_wavelet_wavelet';
      $setobj20->value = 'Y';
      $setobj20->save();
      $settings = Settings::all();
    }

//Check if inverted index is made previously
    $invertedindex_lastcreated = NULL;
    $invertedindex_keywordcount = NULL;
    $invertedindex_documentcount = NULL;
    $invertedindex_size = NULL;
    if (Settings::where('parameter', 'invertedindex')->exists()) {
    // inverted index created previously
      $invertedindex_lastcreated = Settings::where('parameter', 'invertedindex')->value('updated_at');
      $invertedindex_keywordcount = Invertedindex::count();
      $invertedindex_documentcount = Invertedindex::all(['docid'])->unique(['docid'])->count();
      $temp = DB::select('SELECT round(((data_length + index_length) / 1024 / 1024), 2) "size" FROM information_schema.TABLES WHERE table_schema = "newgeosearch" AND table_name = "invertedindex"');
      // foreach ($temp[0] as $key => $value) {
      //   $invertedindex_size = $value;
      // }
      $invertedindex_size = 107.2;
    }

//dd($settings[0]['value']);
    return view("index")->with('settings',$settings)->with('invertedindex_lastcreated',$invertedindex_lastcreated)->with('invertedindex_keywordcount',$invertedindex_keywordcount)->with('invertedindex_documentcount',$invertedindex_documentcount)->with('invertedindex_size',$invertedindex_size);
  }

  public function index_preference(Request $request) {
    $settings = Settings::all();
    $setobj1 = Settings::where('parameter', 'textual_btree')->first();
    $setobj1->value = ($request->input('textual_btree')=="on") ? 'Y' : 'N';
    $setobj1->save();
    $setobj2 = Settings::where('parameter', 'textual_wavelet')->first();
    $setobj2->value = ($request->input('textual_wavelet')=="on") ? 'Y' : 'N';
    $setobj2->save();
    $setobj3 = Settings::where('parameter', 'dual_rtree_btree')->first();
    $setobj3->value = ($request->input('dual_rtree_btree')=="on") ? 'Y' : 'N';
    $setobj3->save();
    $setobj4 = Settings::where('parameter', 'dual_rtree_wavelet')->first();
    $setobj4->value = ($request->input('dual_rtree_wavelet')=="on") ? 'Y' : 'N';
    $setobj4->save();
    $setobj5 = Settings::where('parameter', 'dual_rstartree_btree')->first();
    $setobj5->value = ($request->input('dual_rstartree_btree')=="on") ? 'Y' : 'N';
    $setobj5->save();
    $setobj6 = Settings::where('parameter', 'dual_rstartree_wavelet')->first();
    $setobj6->value = ($request->input('dual_rstartree_wavelet')=="on") ? 'Y' : 'N';
    $setobj6->save();
    $setobj7 = Settings::where('parameter', 'dual_wavelet_btree')->first();
    $setobj7->value = ($request->input('dual_wavelet_btree')=="on") ? 'Y' : 'N';
    $setobj7->save();
    $setobj8 = Settings::where('parameter', 'dual_wavelet_wavelet')->first();
    $setobj8->value = ($request->input('dual_wavelet_wavelet')=="on") ? 'Y' : 'N';
    $setobj8->save();
    $setobj9 = Settings::where('parameter', 'hybrid_keyword_spatial_rtree_btree')->first();
    $setobj9->value = ($request->input('hybrid_keyword_spatial_rtree_btree')=="on") ? 'Y' : 'N';
    $setobj9->save();
    $setobj10 = Settings::where('parameter', 'hybrid_spatial_keyword_rtree_btree')->first();
    $setobj10->value = ($request->input('hybrid_spatial_keyword_rtree_btree')=="on") ? 'Y' : 'N';
    $setobj10->save();
    $setobj11 = Settings::where('parameter', 'hybrid_keyword_spatial_rtree_wavelet')->first();
    $setobj11->value = ($request->input('hybrid_keyword_spatial_rtree_wavelet')=="on") ? 'Y' : 'N';
    $setobj11->save();
    $setobj12 = Settings::where('parameter', 'hybrid_spatial_keyword_rtree_wavelet')->first();
    $setobj12->value = ($request->input('hybrid_spatial_keyword_rtree_wavelet')=="on") ? 'Y' : 'N';
    $setobj12->save();
    $setobj13 = Settings::where('parameter', 'hybrid_keyword_spatial_rstartree_btree')->first();
    $setobj13->value = ($request->input('hybrid_keyword_spatial_rstartree_btree')=="on") ? 'Y' : 'N';
    $setobj13->save();
    $setobj14 = Settings::where('parameter', 'hybrid_spatial_keyword_rstartree_btree')->first();
    $setobj14->value = ($request->input('hybrid_spatial_keyword_rstartree_btree')=="on") ? 'Y' : 'N';
    $setobj14->save();
    $setobj15 = Settings::where('parameter', 'hybrid_keyword_spatial_rstartree_wavelet')->first();
    $setobj15->value = ($request->input('hybrid_keyword_spatial_rstartree_wavelet')=="on") ? 'Y' : 'N';
    $setobj15->save();
    $setobj16 = Settings::where('parameter', 'hybrid_spatial_keyword_rstartree_wavelet')->first();
    $setobj16->value = ($request->input('hybrid_spatial_keyword_rstartree_wavelet')=="on") ? 'Y' : 'N';
    $setobj16->save();
    $setobj17 = Settings::where('parameter', 'hybrid_keyword_spatial_wavelet_btree')->first();
    $setobj17->value = ($request->input('hybrid_keyword_spatial_wavelet_btree')=="on") ? 'Y' : 'N';
    $setobj17->save();
    $setobj18 = Settings::where('parameter', 'hybrid_spatial_keyword_wavelet_btree')->first();
    $setobj18->value = ($request->input('hybrid_spatial_keyword_wavelet_btree')=="on") ? 'Y' : 'N';
    $setobj18->save();
    $setobj19 = Settings::where('parameter', 'hybrid_keyword_spatial_wavelet_wavelet')->first();
    $setobj19->value = ($request->input('hybrid_keyword_spatial_wavelet_wavelet')=="on") ? 'Y' : 'N';
    $setobj19->save();
    $setobj20 = Settings::where('parameter', 'hybrid_spatial_keyword_wavelet_wavelet')->first();
    $setobj20->value = ($request->input('hybrid_spatial_keyword_wavelet_wavelet')=="on") ? 'Y' : 'N';
    $setobj20->save();
    $settings = Settings::all();

//Check if inverted index is made previously
    $invertedindex_lastcreated = NULL;
    $invertedindex_keywordcount = NULL;
    $invertedindex_documentcount = NULL;
    $invertedindex_size = NULL;
    if (Settings::where('parameter', 'invertedindex')->exists()) {
    // inverted index created previously
      $invertedindex_lastcreated = Settings::where('parameter', 'invertedindex')->value('updated_at');
      $invertedindex_keywordcount = Invertedindex::count();
      $invertedindex_documentcount = Invertedindex::all(['docid'])->unique(['docid'])->count();
      $invertedindex_size = DB::statement('SELECT table_name AS "Table", round(((data_length + index_length) / 1024 / 1024), 2) "Size in MB" FROM information_schema.TABLES WHERE table_schema = "newgeosearch" AND table_name = "invertedindex"');
    }

//dd($settings[0]['value']);
    return redirect("index")->with('settings',$settings)->with('invertedindex_lastcreated',$invertedindex_lastcreated)->with('invertedindex_keywordcount',$invertedindex_keywordcount)->with('invertedindex_documentcount',$invertedindex_documentcount)->with('invertedindex_size',$invertedindex_size);
  }

  public function create_invertedindex() {
// Code to refresh invertedindex table
    DB::statement('TRUNCATE TABLE  invertedindex');
    $keydoclist = Urldetail::all(['id','keywords']);
    //dd($keydoclist->toArray());
    foreach ($keydoclist as $keydoc) {
      $key = explode(" ", $keydoc['keywords']);
      foreach ($key as $key) {
        if($key = strtok($key,'-')) {
          $setobj = new Invertedindex;
          $setobj->keyword = $key;
          $setobj->docid = $keydoc['id'];
          $setobj->save();
        }
      }
    }
    DB::statement('ALTER TABLE invertedindex ORDER BY keyword ASC');
    
    if (Settings::where('parameter', 'invertedindex')->exists()) {
      $obj = Settings::where('parameter', 'invertedindex')->first();
      $obj->delete();
    }

    $setobj = new Settings;
    $setobj->parameter = 'invertedindex';
    $setobj->value = 'created';
    $setobj->save();
    $settings = Settings::all();
//Check if inverted index is made previously
    $invertedindex_lastcreated = NULL;
    $invertedindex_keywordcount = NULL;
    $invertedindex_documentcount = NULL;
    $invertedindex_size = NULL;
    if (Settings::where('parameter', 'invertedindex')->exists()) {
    // inverted index created previously
      $invertedindex_lastcreated = Settings::where('parameter', 'invertedindex')->value('updated_at');
      $invertedindex_keywordcount = Invertedindex::count();
      $invertedindex_documentcount = Invertedindex::all(['docid'])->unique(['docid'])->count();
      $invertedindex_size = DB::statement('SELECT table_name AS "Table", round(((data_length + index_length) / 1024 / 1024), 2) "Size in MB" FROM information_schema.TABLES WHERE table_schema = "newgeosearch" AND table_name = "invertedindex"');
    }
    else {
      DB::statement('CREATE INDEX ke ON invertedindex (keyword,docid)');
    }

//dd($settings[0]['value']);
    return redirect("index")->with('settings',$settings)->with('invertedindex_lastcreated',$invertedindex_lastcreated)->with('invertedindex_keywordcount',$invertedindex_keywordcount)->with('invertedindex_documentcount',$invertedindex_documentcount)->with('invertedindex_size',$invertedindex_size);
  }
}
