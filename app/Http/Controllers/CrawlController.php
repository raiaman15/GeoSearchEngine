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
use App\Library\simple_html_dom;
use App\Library\simple_html_dom_node;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CrawlController extends Controller
{    
  private $crawled_urls = array();
  private $found_urls = array();
  private $urlset = array();        // stores url found withing given domain
  private $urlsettitle = array();   // stores <a> tag content of each url ( of $urlset)

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

  public function initiate(Request $request) {
    // Time before crawling
    $ti=microtime(true);
    // level 0 crawling : Adding the requested URL
    array_push($this->urlset,$request->input('url'));
    array_push($this->urlsettitle,$request->input('url'));
    // level 1 crawling
    $this->crawl_site($request->input('url'));
    // level 2 crawling
    // Only for very high speed internet : more than 100 Mbps
    // for ($i=0; $i < count($this->urlset); $i++) { 
    //   $this->crawl_site($this->urlset[$i]);
    // }
    //
    //Saving in database
    for ($i=0; $i < count($this->urlset); $i++) {
      $exist = Urllist::where('url', $this->urlset[$i])->first();
      if($exist)
      {
        if(strcmp($exist->urltext,$this->urlsettitle[$i])<0)
          $exist->urltext=$this->urlsettitle[$i];
          $exist->save();
        continue;
      }
      $urlobj = new Urllist;
      $urlobj->parent = $request->input('url');
      $urlobj->url = $this->urlset[$i];
      $urlobj->urltext = $this->urlsettitle[$i];
      $urlobj->processed = FALSE;
      $urlobj->save();
    }
    $info = array();
    array_push($info,count($this->urlset)); // $info[0] have count of url in $urlset
    array_push($info,$request->input('url')); // $info[1] have parent domain detail
    // Time after crawling
    $tf=microtime(true);
    // Difference in time
    array_push($info,($tf-$ti)); // $info[1] have parent domain detail
    return view("success_crawl")->with('url',$this->urlset)->with('title',$this->urlsettitle)->with('info',$info);
  }

  public function rel2abs($rel, $base){
    if (parse_url($rel, PHP_URL_SCHEME) != ''){
      return $rel;
    }
    if (!empty($rel[0])=='#' || !empty($rel[0])=='?'){
      return $base.$rel;
    }
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

  public function crawl_site($u){
    echo "<small style='color:green;'>Processing <b>".$u."</b>";
    $uen=urlencode($u);
    if((array_key_exists($uen,$this->crawled_urls)==0 || $this->crawled_urls[$uen] < date("YmdHis",strtotime('-25 seconds', time())))){
      try
      {

        $html = $this->file_get_html($u);
        if (method_exists($html,"find")) { 
          if ($html->find('html')) {
            $crawled_urls[$uen]=date("YmdHis");
            foreach($html->find("a") as $li){
              $url=$this->perfect_url($li->href,$u);
              $enurl=urlencode($url);
              if($url!='' && substr($url,0,4)!="mail" && substr($url,0,4)!="java" && array_key_exists($enurl,$this->found_urls)==0){
                $this->found_urls[$enurl]=1;
                array_push($this->urlset,$url);
                array_push($this->urlsettitle,$li->plaintext);
              }
            }
          } 
        }
        
        echo "__success!</small>";
      }
      catch(\Exception $e)
      {echo "__failed!</small>";}
    }
  }
}