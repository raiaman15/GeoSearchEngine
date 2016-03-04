<?php
//Getting client's IP address
function get_ip_address() {
    $ip_keys = array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR');
    foreach ($ip_keys as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                // trim for safety measures
                $ip = trim($ip);
                // attempt to validate IP
                if (validate_ip($ip)) {
                    return $ip;
                }
            }
        }
    }
    return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : false;
}
//Validating IP address
function validate_ip($ip)
{
    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
        return false;
    }
    return true;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>GeoSearch</title>
    <link href='https://fonts.googleapis.com/css?family=Fauna+One' rel='stylesheet' type='text/css'>
    <!-- Bootstrap -->
    <link href="{!! URL::asset('css/bootstrap.min.css') !!}" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
      <!-- Material theme -->
      <link href="{!! URL::asset('css/material-fullpalette.min.css') !!}" rel="stylesheet" type="text/css">
      <link href="{!! URL::asset('css/ripples.min.css') !!}" rel="stylesheet" type="text/css">
  </head>
  <body style="font-family: 'Fauna One', serif;">
    <div class="navbar navbar-material-red-300" style="margin:0;">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-material-red-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/"><b style="font-size:24pt;">GeoSearch<small style="font-size:10pt;color:black;"> [BACKEND]</small></b></a>
      </div>
      <div class="navbar-collapse collapse navbar-material-red-collapse">
        <ul class="nav navbar-nav navbar-right">
          <li><a href="{{route('crawl')}}">Crawl</a></li>
          <li><a href="{{route('extract')}}">Extract</a></li>
          <li><a href="{{route('index')}}">Index</a></li>
          <li><a href="{{route('report')}}">Report</a></li>
          <li><a href="{{route('search')}}">Search</a></li>
        </ul>
      </div>
    </div>
<div class="container-fluid">
<div class="panel panel-default">
    <div class="panel-body">
        <form class="form-horizontal" id="search" method="post" action="search_process">
            <fieldset>
                <div class="form-group" style="padding:0;margin:0;">
                    <div class="col-lg-12">
                        <input style="text-align:center;" type="text" class="form-control" name="query" placeholder="YOUR QUERY HERE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="client_IP" value="{{ validate_ip(get_ip_address())?get_ip_address():'UNDETERMINED' }}">
                    </div>
                </div>
                <div class="form-group" style="padding:0;margin:0;">
                  <label class="col-lg-2 control-label">Text</label>
                  <div class="col-lg-4">
                    <div class="radio radio-primary">
                      <label>
                        <input type="radio" name="text_technique" id="text_b_tree" value="text_b_tree" checked>
                        B-Tree
                      </label>
                    
                      <label>
                        <input type="radio" name="text_technique" id="text_wavelet" value="text_wavelet">
                        Wavelet-Tree
                      </label>
                    </div>
                  </div>
                  <label class="col-lg-2 control-label">Location</label>
                  <div class="col-lg-4">
                    <div class="radio radio-primary">
                      <label>
                        <input type="radio" name="location_technique" id="location_r_tree" value="location_r_tree" checked>
                        R-Tree
                      </label>
                    
                      <label>
                        <input type="radio" name="location_technique" id="location_rstar_tree" value="location_rstar_tree">
                        R*-Tree
                      </label>
                    
                      <label>
                        <input type="radio" name="location_technique" id="location_wavelet" value="location_wavelet">
                        Wavelet-Tree
                      </label>
                    </div>
                  </div>
                </div>
                <script>
                  $('#search').keydown(function() {
                  var key = e.which;
                  if (key == 13) {
                  // As ASCII code for ENTER key is "13"
                  $('#search').submit();
                  }
                  });
                </script>
            </fieldset>
        </form>
    </div>
</div>
</div>
<script type="text/javascript" src="{!! URL::asset('js/jquery-1.11.3.min.js') !!}"></script>
<script type="text/javascript" src="{!! URL::asset('js/bootstrap.min.js') !!}"></script>
<script type="text/javascript" src="{!! URL::asset('js/material.min.js') !!}"></script>
<script type="text/javascript" src="{!! URL::asset('js/ripples.min.js') !!}"></script>
<script>
$(document).ready(function(){
    $.material.init();
});
</script>
</body>
</html>