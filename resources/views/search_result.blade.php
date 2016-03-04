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
      <link href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
      <script src="http://maps.googleapis.com/maps/api/js"></script>
      <style>
      a[href^="http://maps.google.com/maps"]{display:none !important}
      a[href^="https://maps.google.com/maps"]{display:none !important}

      .gmnoprint a, .gmnoprint span, .gm-style-cc {
          display:none;
      }
      .gmnoprint div {
          background:none !important;
      }
      </style>
      <script>
      <?php if($actuallocation==NULL) $actuallocation=$location; ?>
      //Location
      var x=new google.maps.LatLng({{$location[2]}},{{$location[3]}});
      var tl=new google.maps.LatLng({{$location[7]}},{{$location[4]}});
      var tr=new google.maps.LatLng({{$location[7]}},{{$location[6]}});
      var br=new google.maps.LatLng({{$location[5]}},{{$location[6]}});
      var bl=new google.maps.LatLng({{$location[5]}},{{$location[4]}});
      //Actual Query Location
      var y=new google.maps.LatLng({{$actuallocation[2]}},{{$actuallocation[3]}});
      var qtl=new google.maps.LatLng({{$actuallocation[7]}},{{$actuallocation[4]}});
      var qtr=new google.maps.LatLng({{$actuallocation[7]}},{{$actuallocation[6]}});
      var qbr=new google.maps.LatLng({{$actuallocation[5]}},{{$actuallocation[6]}});
      var qbl=new google.maps.LatLng({{$actuallocation[5]}},{{$actuallocation[4]}});

      <?php
        $dx = $actuallocation[6] - $actuallocation[4];
        $dy = $actuallocation[7] - $actuallocation[5];
        $d = sqrt(($dx * $dx)+($dy * $dy));
        if ($d<1) {$d=1;} else if ($d>50) {$d=-1;} else {$d=0;} 
      ?>

      function initialize()
      {
      var mapProp = {
        center:y,
        zoom:{{$d + ($actuallocation[0]+1)*2}},
        disableDefaultUI: true,
        mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        
      var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

      var myBound1=[tl,tr,br,bl,tl];
      var boundary1=new google.maps.Polygon({
        paths:myBound1,
        strokeColor:"#000000",
        strokeOpacity:0.8,
        strokeWeight:2,
        fillColor:"#000000",
        fillOpacity:0.4
        });

      var myBound2=[qtl,qtr,qbr,qbl,qtl];
      var boundary2=new google.maps.Polygon({
        paths:myBound2,
        strokeColor:"#FF0000",
        strokeOpacity:0.8,
        strokeWeight:2,
        fillColor:"#FF0000",
        fillOpacity:0.4
        });

        boundary1.setMap(map);
        boundary2.setMap(map);
      }
      google.maps.event.addDomListener(window, 'load', initialize);
      </script>
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
        <form class="form-horizontal" method="post" action="search_process">
            <fieldset>
                <div class="form-group" style="padding:0;margin:0;">
                    <div class="col-lg-12">
                        <input style="text-align:center;" type="text" class="form-control" name="query" value="{{$query}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="client_IP" value="{{ validate_ip(get_ip_address())?get_ip_address():'!'.get_ip_address() }}">
                    </div>
                </div>
                <div class="form-group" style="padding:0;margin:0;">
                  <label class="col-lg-2 control-label">Text</label>
                  <div class="col-lg-4">
                    <div class="radio radio-primary">
                      <label>
                        <input type="radio" name="text_technique" id="text_b_tree" value="text_b_tree" @if ($text_technique=='text_b_tree') checked @endif>
                        B-Tree
                      </label>
                    
                      <label>
                        <input type="radio" name="text_technique" id="text_wavelet" value="text_wavelet" @if ($text_technique=='text_wavelet') checked @endif>
                        Wavelet-Tree
                      </label>
                    </div>
                  </div>
                  <label class="col-lg-2 control-label">Location</label>
                  <div class="col-lg-4">
                    <div class="radio radio-primary">
                      <label>
                        <input type="radio" name="location_technique" id="location_r_tree" value="location_r_tree" @if ($location_technique=='location_r_tree') checked @endif>
                        R-Tree
                      </label>
                    
                      <label>
                        <input type="radio" name="location_technique" id="location_rstar_tree" value="location_rstar_tree" @if ($location_technique=='location_rstar_tree') checked @endif>
                        R*-Tree
                      </label>
                    
                      <label>
                        <input type="radio" name="location_technique" id="location_wavelet" value="location_wavelet" @if ($location_technique=='location_wavelet') checked @endif>
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
  <div class="row" style="padding:0;">
    <!-- <div class="col-lg-12" >
      <div class="alert alert-dismissible alert-material-green-200">
        <button type="button" class="close" data-dismiss="alert">×</button>
        Text search [____] [____kilobytes] [____ seconds] | Location search [____] [____kilobytes] [____ seconds]<br/>
      </div>
    </div> -->
    @if (!is_null($location))
    <div class="col-lg-8" align="justify">
      <table id="result" class="stripe" cellspacing="0" width="100%" border="1">
        @if (!($results->count()>0))
        <tr><td colspan="2" align="center"><small>No result found for your query.</small></td></tr>
        @else
          <thead>
            <tr style="display:none">
                <th></th>
                <th></th>
            </tr>
          </thead>
          <tbody>
          @foreach ($results as $result)
          <tr>
            <td align="center" style="vertical-align:middle;"><img src="http://www.google.com/s2/favicons?domain={{$result->doc_url}}"></td>
            <td>
            <a href="{{$result->doc_url}}" target="_blank">
              {{$result->doc_title}}
            <br/>
              <small>{{$result->doc_url}}</small>
            <br/>
              {{'['.$result->doc_keywords.']'}}
            </a>
            </td>
          </tr>
          @endforeach
          </tbody>
        @endif
      </table>      
    </div>
    <div class="col-lg-4" align="justify">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">LOCATION : {{$location[1]}}</h3>
        </div>
        <div class="panel-body" style="padding:0;">
          <div id="googleMap" style="width:100%;height:300px;"></div>
        </div>
        <div class="panel-footer" style="padding:0;">
          <a style="margin:5px;min-width:20px;max-width:20px;min-height:20px;max-height:20px;background-color:#0000FF">&nbsp;&nbsp;&nbsp;&nbsp;</a> <small>LOCATION</small><br/>
          <a style="margin:5px;min-width:20px;max-width:20px;min-height:20px;max-height:20px;background-color:#FF0000">&nbsp;&nbsp;&nbsp;&nbsp;</a> <small>ACTUAL QUERY LOCATION</small>
        </div>
      </div>
    </div>
    @else
    <div class="col-lg-12" align="justify">
      <table id="result" class="stripe" cellspacing="0" width="100%" border="1">
        @if (!($results->count()>0))
        <tr><td align="center"><small>No result found for your query.</small></td></tr>
        @else
          <thead>
            <tr style="display:none">
                <th>Logo</th>
                <th>Title</th>
            </tr>
          </thead>
          <tbody>
          @foreach ($results as $result)
          <tr>
            <td align="center" style="vertical-align:middle;"><img src="http://www.google.com/s2/favicons?domain={{$result->doc_url}}"></td>
            <td>
            <a href="{{$result->doc_url}}" target="_blank">
              {{$result->doc_title}}
            <br/>
              <small>{{$result->doc_url}}</small>
            <br/>
              {{'['.$result->doc_keywords.']'}}
            </a>
            </td>
          </tr>
          @endforeach
          </tbody>
        @endif
      </table> 
    </div>
    @endif
  </div>
</div>

<script type="text/javascript" src="{!! URL::asset('js/jquery-1.11.3.min.js') !!}"></script>
<script type="text/javascript" src="{!! URL::asset('js/bootstrap.min.js') !!}"></script>
<script type="text/javascript" src="{!! URL::asset('js/material.min.js') !!}"></script>
<script type="text/javascript" src="{!! URL::asset('js/ripples.min.js') !!}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function(){
    $.material.init();
    $('#result').DataTable();
});
$('#result').dataTable( {
  "searching": false,
  "lengthChange": false,
  "ordering": false
} );
</script>
</body>
</html>