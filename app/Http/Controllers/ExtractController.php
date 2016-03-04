<?php

namespace App\Http\Controllers;

set_time_limit(0); //Never timeout
ini_set('memory_limit', '1024M');

define('HDOM_TYPE_ELEMENT', 1);
define('HDOM_TYPE_COMMENT', 2);
define('HDOM_TYPE_TEXT',  3);
define('HDOM_TYPE_ENDTAG',  4);
define('HDOM_TYPE_ROOT',  5);
define('HDOM_TYPE_UNKNOWN', 6);
define('HDOM_QUOTE_DOUBLE', 0);
define('HDOM_QUOTE_SINGLE', 1);
define('HDOM_QUOTE_NO',  3);
define('HDOM_INFO_BEGIN',   0);
define('HDOM_INFO_END',  1);
define('HDOM_INFO_QUOTE',   2);
define('HDOM_INFO_SPACE',   3);
define('HDOM_INFO_TEXT',  4);
define('HDOM_INFO_INNER',   5);
define('HDOM_INFO_OUTER',   6);
define('HDOM_INFO_ENDSPACE',7);
define('DEFAULT_TARGET_CHARSET', 'UTF-8');
define('DEFAULT_BR_TEXT', "\r\n");
define('DEFAULT_SPAN_TEXT', " ");
define('MAX_FILE_SIZE', 600000);

use App\Urllist;
use App\Urldetail;
use App\Library\simple_html_dom;
use App\Library\simple_html_dom_node;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class ExtractController extends Controller
{   

  public function file_get_html($url, $use_include_path = false, $context=null, $offset = -1, $maxLen=-1, $lowercase = true, $forceTagsClosed=true, $target_charset = DEFAULT_TARGET_CHARSET, $stripRN=true, $defaultBRText=DEFAULT_BR_TEXT, $defaultSpanText=DEFAULT_SPAN_TEXT)
  {
    // We DO force the tags to be terminated.
    $dom = new simple_html_dom(null, $lowercase, $forceTagsClosed, $target_charset, $stripRN, $defaultBRText, $defaultSpanText);
    // For sourceforge users: uncomment the next line and comment the retreive_url_contents line 2 lines down if it is not already done.
    $contents = file_get_contents($url, $use_include_path, $context, $offset);
    
    // Paperg - use our own mechanism for getting the contents as we want to control the timeout.
    //$contents = retrieve_url_contents($url);
    if (empty($contents) || strlen($contents) > MAX_FILE_SIZE)
    {
      return false;
    }
    // The second parameter can force the selectors to all be lowercase.
    $dom->load($contents, $lowercase, $stripRN);
    return $dom;
  }

//This function sends the data to bind with the 'extract' view
  public function displayUrlList() {
    $urllist = Urllist::where('processed', '=', FALSE)->paginate(4);
    return view("extract")->with('urllist',$urllist);
  }

//This function converts relative URL to absolute URL
  public function rel2abs($rel, $base){
    if (parse_url($rel, PHP_URL_SCHEME) != '')
    {return $rel;}
    if (!empty($rel[0])=='#' || !empty($rel[0])=='?')
    {return $base.$rel;}
    extract(parse_url($base));
    if (isset($path)){$path = preg_replace('#/[^/]*$#', '', $path);}
    else $path = '';
    if (!empty($rel[0]) == '/'){
      $path = '';
    }
    $abs = "$host$path/$rel";
    $re = array('#(/.?/)#', '#/(?!..)[^/]+/../#');
    for($n=1; $n>0;$abs=preg_replace($re,'/', $abs,-1,$n)){}
      $abs=str_replace("../","",$abs);
    return $scheme.'://'.$abs;
  }

//This function adds path/domail/host etc. to make the URL perfect
  public function perfect_url($u,$b){
    $bp=parse_url($b);
    if (isset($bp['path'])){
      if(($bp['path']!="/" && $bp['path']!="") || $bp['path']=='' ){
        if($bp['scheme']==""){
          $scheme="http";
        }else{
          $scheme=$bp['scheme'];
        }
        $b=$scheme."://".$bp['host']."/";
      }
    }
    if(substr($u,0,2)=="//"){
      $u="http:".$u;
    }
    if(substr($u,0,4)!="http"){
      $u=$this->rel2abs($u,$b);
    }
    return $u;
  }

//This function extracts keywords from various parts of webpage
  public function extract_keywords($string){
//List of stop words (words to ignore) 
    $stopWords = array("able","about","above","abroad","according","accordingly","across","actually","adj","after","afterwards","again","against","ago","ahead","ain't","all","allow","allows","almost","alone","along","alongside","already","also","although","always","am","amid","amidst","among","amongst","an","and","another","any","anybody","anyhow","anyone","anything","anyway","anyways","anywhere","apart","appear","appreciate","appropriate","are","aren't","around","as","a's","aside","ask","asking","associated","at","available","away","awfully","back","backward","backwards","be","became","because","become","becomes","becoming","been","before","beforehand","begin","behind","being","believe","below","beside","besides","best","better","between","beyond","both","brief","but","by","came","can","cannot","cant","can't","caption","cause","causes","certain","certainly","changes","clearly","c'mon","co","co.","com","come","comes","concerning","consequently","consider","considering","contain","containing","contains","corresponding","could","couldn't","course","c's","currently","dare","daren't","day","definitely","described","despite","did","didn't","different","directly","do","does","doesn't","doing","done","don't","down","downwards","during","each","edu","eg","eight","eighty","either","else","elsewhere","end","ending","enough","entirely","especially","et","etc","even","ever","evermore","every","everybody","everyone","everything","everywhere","ex","exactly","example","except","fairly","far","farther","few","fewer","fifth","first","five","followed","following","follows","for","forever","former","formerly","forth","forward","found","four","from","further","furthermore","get","gets","getting","given","gives","go","goes","going","gone","got","gotten","greetings","had","hadn't","half","happens","hardly","has","hasn't","have","haven't","having","he","he'd","he'll","hello","help","hence","her","here","hereafter","hereby","herein","here's","hereupon","hers","herself","he's","hi","him","himself","his","hither","home","hopefully","how","howbeit","however","hundred","i'd","ie","if","ignored","i'll","i'm","immediate","in","inasmuch","inc","inc.","indeed","indicate","indicated","indicates","inner","inside","insofar","instead","into","inward","is","isn't","it","it'd","it'll","its","it's","itself","i've","just","k","keep","keeps","kept","khan","know","known","knows","last","lately","later","latter","latterly","least","less","lest","let","let's","like","liked","likely","likewise","little","look","looking","looks","low","lower","ltd","made","mainly","make","makes","many","may","maybe","mayn't","me","mean","meantime","meanwhile","merely","might","mightn't","mine","minus","miss","more","moreover","most","mostly","mr","mrs","much","must","mustn't","my","myself","name","namely","nd","near","nearly","necessary","need","needn't","needs","neither","never","neverf","neverless","nevertheless","new","next","nine","ninety","no","nobody","non","none","nonetheless","noone","no-one","nor","normally","not","nothing","notwithstanding","novel","now","nowhere","obviously","of","off","often","oh","ok","okay","old","on","once","one","ones","one's","only","onto","opposite","or","other","others","otherwise","ought","oughtn't","our","ours","ourselves","out","outside","over","overall","own","page","particular","particularly","past","per","perhaps","placed","please","plus","possible","presumably","probably","provided","provides","que","quite","qv","rather","rd","re","really","reasonably","recent","recently","regarding","regardless","regards","relatively","respectively","right","round","said","same","saw","say","saying","says","second","secondly","see","seeing","seem","seemed","seeming","seems","seen","self","selves","sensible","sent","serious","seriously","seven","several","shall","shan't","she","she'd","she'll","she's","should","shouldn't","since","six","so","social","some","somebody","someday","somehow","someone","something","sometime","sometimes","somewhat","somewhere","soon","sorry","specified","specify","specifying","still","sub","such","sup","sure","take","taken","taking","tell","tends","th","than","thank","thanks","thanx","that","that'll","thats","that's","that've","the","their","theirs","them","themselves","then","thence","there","thereafter","thereby","there'd","therefore","therein","there'll","there're","theres","there's","thereupon","there've","these","they","they'd","they'll","they're","they've","thing","things","think","third","thirty","this","thorough","thoroughly","those","though","three","through","throughout","thru","thus","till","to","together","too","took","toward","towards","tried","tries","truly","try","trying","t's","twice","two","un","under","underneath","undoing","unfortunately","unless","unlike","unlikely","until","unto","up","upon","upwards","us","use","used","useful","uses","using","usually","v","value","various","versus","very","via","video","viz","vs","want","wants","was","wasn't","way","we","we'd","welcome","well","we'll","went","were","we're","weren't","we've","what","whatever","what'll","what's","what've","when","whence","whenever","where","whereafter","whereas","whereby","wherein","where's","whereupon","wherever","whether","which","whichever","while","whilst","whither","who","who'd","whoever","whole","who'll","whom","whomever","who's","whose","why","will","willing","wish","with","within","without","wonder","won't","would","wouldn't","yes","yet","you","you'd","you'll","your","you're","yours","yourself","yourselves","you've","zero");

    $string = trim($string); // trim the string
    $string = preg_replace("/&#?[a-z0-9]+;/i","",$string); // remove html special charecter
    $string = preg_replace("/[^a-zA-Z0-9\s]/", "", $string); // only take alphanumerical characters, but keep the spaces...
    $string = strtolower($string); // make it lowercase
    $string = preg_replace('!\s+!', ' ', $string); //multiple whitespaces removed to single
    $string = str_replace(range(0,9),'',$string);

    preg_match_all('/\b.*?\b/i', $string, $matchWords);
    $matchWords = $matchWords[0];

    foreach ( $matchWords as $key=>$item ) {
      if ( $item == '' || $item == ' ' || in_array(strtolower($item), $stopWords) || strlen($item) <= 3 ) {
        unset($matchWords[$key]);
      }
    }   
    $wordCountArr = array();
    if ( is_array($matchWords) ) {
      foreach ( $matchWords as $key => $val ) {
        $val = strtolower($val);
        if ( isset($wordCountArr[$val]) ) {
          $wordCountArr[$val]++;
        } else {
          $wordCountArr[$val] = 1;
        }
      }
    }
//Sorting according to frequency of occurrence, descending order
    arsort($wordCountArr);
//Making a set of 10 most frequent keywords
    $wordCountArr = array_slice($wordCountArr, 0, 10);
    $return_keywords = array();
    foreach ($wordCountArr as $key => $val) {
      array_push($return_keywords,$key.'-'.$val);
    }
    return $return_keywords;
  }

//This function finds the location to which the webpage corresponds by using extracted keywords
  public function findLocation($keyword)
  {
    $data = NULL;
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
        if($keyword==$location->name_0)
          {$data = array($location->name_0,$location->lat,$location->lon);}
        if(isset($location->name_1))
        if($keyword==$location->name_1)
          {$data = array($location->name_1,$location->lat,$location->lon);}
        if(isset($location->name_2))
        if($keyword==$location->name_2)
          {$data = array($location->name_2,$location->lat,$location->lon);}
        if(isset($location->name_3))
        if($keyword==$location->name_3)
          {$data = array($location->name_3,$location->lat,$location->lon);}
        if(isset($location->name_4))
        if($keyword==$location->name_4)
          {$data = array($location->name_4,$location->lat,$location->lon);}
        if(isset($location->name_5))
        if($keyword==$location->name_5)
          {$data = array($location->name_5,$location->lat,$location->lon);}
      }
    return $data;
  }

//This function does the URL processing
  public function processUrl(Request $request) {
// Time before extracting
      $ti=microtime(true);
      $keywords='';
   try
   {
//Forming keyword array using webpage's information
      $html = ''; $html = $this->file_get_html($request->input('url'));
      $meta = ''; $meta = get_meta_tags($request->input('url'));
      $metakeywords = ''; if(isset($meta['keywords'])) {$metakeywords = $meta['keywords'];}
      $metadescription = ''; if(isset($meta['description'])) {$metadescription = $meta['description'];}
      $urltext = ''; if($request->input('urltext')) {$urltext = $request->input('urltext');}
      $title = ''; $heading1 = ''; $heading2 = ''; $heading3 = ''; $para = '';
// first check if $html->find exists
      if (method_exists($html,"find")) {
// then check if the html element exists to avoid trying to parse non-html
        if ($html->find('html')) {
// and only then start searching
          foreach($html->find('title') as $titlepart) 
          {$title = $title . ' ' .$titlepart->plaintext;}
          foreach($html->find('h1') as $headingpart) 
          {$heading1 = $heading1 . ' ' .$headingpart->plaintext;}
          foreach($html->find('h2') as $headingpart) 
          {$heading2 = $heading2 . ' ' .$headingpart->plaintext;}
          foreach($html->find('h3') as $headingpart) 
          {$heading3 = $heading3 . ' ' .$headingpart->plaintext;}
          foreach($html->find('p') as $parapart) 
          {$para = $para . ' ' .$parapart->plaintext;}
        }
      }

//Weights meta keyword:5 title:4 meta description:3 urltext:3 h1:3 h2:2 h3:1 p:1
      $temp = $metakeywords.' '.$metakeywords.' '.$metakeywords.' '.$metakeywords.' '.$metakeywords.' '.$title.' '.$title.' '.$title.' '.$title.' '.$metadescription.' '.$metadescription.' '.$metadescription.' '.$urltext.' '.$urltext.' '.$urltext.' '.$heading1.' '.$heading1.' '.$heading1.' '.$heading2.' '.$heading2.' '.$heading3.' '.$para;
      $words = $this->extract_keywords($temp);
      $keywords = implode('  ', $words);
      $keywords = preg_replace("/\s+/", " ", $keywords);

// For getting location data from images (NOT USING DUE TO HIGH INTERNET BANDWIDTH CONSUMPTION) ; for future use.
// foreach($html->find('img') as $image) 
//   if (substr_count($image->src, '.jpg')||substr_count($image->src, '.JPG')||substr_count($image->src, '.jpeg')||substr_count($image->src, '.JPEG')||substr_count($image->src, '.tif')||substr_count($image->src, '.TIF')||substr_count($image->src, '.tiff')||substr_count($image->src, '.TIFF'))
//   {
//     echo "<br>".$image->src;
//       //Making perfect URL
//     $url=$this->perfect_url($image->src,$request->input('url'));
//     try
//     {
//       $exif = exif_read_data($url, 'IFD0');
//       echo $exif===false ? "No header data found.<br />\n" : "Image contains headers<br />\n";

//       $exif = exif_read_data($url, 0, true);
//       var_dump($exif);
//     }
//     catch(\Exception $e)
//     {
//       // do nothing...
//     }
//       // foreach ($exif as $key => $section) {
//       //     foreach ($section as $name => $val) {
//       //         echo "$key.$name: $val<br />\n";
//       //     }
//       // }
// }

//Getting webpage location via ip (limit is 150 per minute)
        $temp = parse_url($request->input('url'));
        $urldomain=$temp['host'];
        $json = file_get_contents('http://ip-api.com/json/'.$urldomain);
        $json = json_decode($json);
        $iplatitude = 0; $iplatitude = $json->{'lat'};
        $iplongitude = 0; $iplongitude = $json->{'lon'};

//Getting location based on keywords
//array_reverse is used so that the element at top (having max. number of repetition) dominates
        $location=NULL;
        $latitude=$iplatitude;
        $longitude=$iplongitude;
        $temp = array_reverse($words);
        foreach ($temp as $word => $value) 
        { 
          $num = array('-1','-2','-3','-4','-5','-6','-7','-8','-9','-0');
          $word = str_replace($num, '', $value);
          if ((strcmp($word, '') !== 0)&&(strcmp($word, ' ') !== 0))
          {
            $loc = $this->findLocation($word);
            if(!is_null($loc))
            {
              //if(((($iplatitude-$loc[1])*($iplatitude-$loc[1]))+(($iplongitude-$loc[2])*($iplongitude-$loc[2]))) < ((($iplatitude-$latitude)*($iplatitude-$latitude))+(($iplongitude-$longitude)*($iplongitude-$longitude))))
              {
                $location = $loc[0];
                $latitude = $loc[1];
                $longitude = $loc[2];
              }
            }
          }
        }
//Checking if URL is already processed
      $exist = Urldetail::where('url', urlencode($request->input('url')))->orWhere('urllistid', $request->input('id'))->first();
      if(!$exist)
          {$exist = Urldetail::where('url', $request->input('url'))->orWhere('urllistid', $request->input('id'))->first();}
      if(!$exist)
      {
        $urldetailobj = new Urldetail;
        $urldetailobj->urllistid = $request->input('id');
        $urldetailobj->url = $request->input('url');
        $urldetailobj->title = $title;
        $urldetailobj->h1 = $heading1;
        $urldetailobj->metadesc = $metadescription;
        $urldetailobj->location = $location;
        $urldetailobj->latitude = $latitude;
        $urldetailobj->longitude = $longitude;
        $urldetailobj->keywords = $keywords;
//Saving object to database
        $urldetailobj->save();

//Confirming that url is processed
        $exist_urllist = Urllist::where('url', urlencode($request->input('url')))->orWhere('id', $request->input('id'))->first();
        if(!$exist_urllist)
          {$exist_urllist = Urllist::where('url', $request->input('url'))->orWhere('id', $request->input('id'))->first();}
        $exist_urllist->processed=TRUE;
        $exist_urllist->save();
      }
      else
      {
//Confirming that url is processed
        $exist_urllist = Urllist::where('url', urlencode($request->input('url')))->orWhere('id', $request->input('id'))->first();
        if(!$exist_urllist)
          {$exist_urllist = Urllist::where('url', $request->input('url'))->orWhere('id', $request->input('id'))->first();}
        $exist_urllist->processed=TRUE;
        $exist_urllist->save();
      }
   }
    catch(\Exception $e)
    {
//Deleting this faulty url
      //var_dump($e);
      $exist_urllist = Urllist::where('url', '=', urlencode($request->input('url')))->orWhere('id', $request->input('id'))->first();
      if(!$exist_urllist)
          {$exist_urllist = Urllist::where('url', $request->input('url'))->orWhere('id', $request->input('id'))->first();}
      if($exist_urllist) {
        $exist_urllist->delete();
      }
      echo "<div class='alert alert-material-red-200' style='margin:0;' role='alert'><small>URL <b>".$request->input('url')." </b> FAILED and DELETED.<br/>REASON : ".$e->getMessage()."</small></div>";
      $urllist = Urllist::where('processed', '=', FALSE)->paginate(4);
      return view("extract")->with('urllist',$urllist);
    }

// Time after extracting
      $tf=microtime(true);
      $exist = Urldetail::where('url', htmlentities($request->input('url')))->first();
      if(!$exist)
          {$exist = Urldetail::where('url', $request->input('url'))->first();}
      if($keywords) echo "<div class='alert alert-material-green-200' style='margin:0;' role='alert'><small>URL : <b>".$request->input('url')." </b><br/>Keywords : <b> ".$keywords." </b><br/>Location : <b> ".$exist->location." </b>. Time taken : <b>".($tf-$ti)."</b> seconds. </small></div>";
      $urllist = Urllist::where('processed', '=', FALSE)->paginate(4);
      return view("extract")->with('urllist',$urllist);
    }
  }