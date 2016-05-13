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
<body style="font-family: 'Fauna One', serif;" onunload="if(needToConfirm == true) alert('The changes you made are still not saved.');">
  <div class="navbar navbar-material-red-300">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-material-red-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/"><b style="font-size:24pt;">GeoSearch<small style="font-size:10pt;color:black;"> [BACKEND]</small></b></a>
    </div>
    <div class="navbar-collapse collapse navbar-material-red-collapse">
      <form class="navbar-form navbar-left" method="post" action="search">
      <input type="text" class="form-control col-lg-8" name="query" placeholder="Quick search here...">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      </form>
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
      <div class="panel-heading">This section would form the document-keyword list table of all the elements present in the table <i>'urldetails'</i></div>
      <div class="panel-body">
        <form class="form-horizontal" method="get" action="create_invertedindex">
          <fieldset>
            <legend>Create Document-Keyword List</legend>
            <div class="form-group">
              <label class="col-lg-3 control-label" style="text-align:center; vertical-align:middle;"><u><big>Create Document-Keyword List</big></u><br>Make new document-keyword list with current crawled information.<br/>
              <button type="submit" value="submit" onclick="needToConfirm = false;" class="btn btn-primary">Create</button>
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              </label>
              <div class="col-lg-2">
                <label>Last Created</label>
                <div>@if ($invertedindex_lastcreated === NULL) NOT CREATED @else {{date('Y-m-d H:i',strtotime('+5 hour +30 minutes',strtotime($invertedindex_lastcreated)))}} @endif</div>
              </div>
              <div class="col-lg-2">
                <label>Keyword count</label>
                <div>@if ($invertedindex_keywordcount === NULL) NOT CREATED @else {{$invertedindex_keywordcount}} @endif</div>
              </div>
              <div class="col-lg-2">
                <label>Document count</label>
                <div>@if ($invertedindex_documentcount === NULL) NOT CREATED @else {{$invertedindex_documentcount}} @endif</div>
              </div>
              <div class="col-lg-2">
                <label>Size</label>
                <div>@if ($invertedindex_size === NULL) NOT CREATED @else {{$invertedindex_size}} MB @endif</div>
              </div>
            </div> 
          </fieldset>
        </form>
      </div>
    </div>
  </div>
  <div class="container-fluid">
    <div class="panel panel-default">
      <div class="panel-heading">This section provides preference of indexing method for all the elements present in the table <i>'invertedindex'</i></div>
      <div class="panel-body">
        <form class="form-horizontal" method="post" action="index_preference">
          <fieldset>
            <legend>Preference</legend>
            <div class="form-group">
              <label class="col-lg-12 control-label" style="text-align:center; vertical-align:middle;"><u><big>Indexing Technique</big></u><br>Make your preference.<br/>
              <button type="submit" value="submit" onclick="needToConfirm = false;" class="btn btn-primary">Save</button>
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <hr/>
              </label>
              <div class="col-lg-3">
                <label>Textual Search</label>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" class="forchange" name="textual_btree" @if (($settings[0]['value']) === 'Y') checked @endif> B tree
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" class="forchange" name="textual_wavelet" @if (($settings[1]['value']) === 'Y') checked @endif> Wavelet tree
                  </label>
                </div>
              </div>
              <div class="col-lg-4">
                <label>Dual Search</label>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" class="forchange" name="dual_rtree_btree" @if (($settings[2]['value']) === 'Y') checked @endif> R tree (location) and B tree (text)
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" class="forchange" name="dual_rtree_wavelet" @if (($settings[3]['value']) === 'Y') checked @endif> R tree (location) and Wavelet tree (text)
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" class="forchange" name="dual_rstartree_btree" @if (($settings[4]['value']) === 'Y') checked @endif> R* (location) tree and B tree (text)
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" class="forchange" name="dual_rstartree_wavelet" @if (($settings[5]['value']) === 'Y') checked @endif> R* (location) tree and Wavelet tree (text)
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" class="forchange" name="dual_wavelet_btree" @if (($settings[6]['value']) === 'Y') checked @endif> Wavelet tree (location) and B tree (text)
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" class="forchange" name="dual_wavelet_wavelet" @if (($settings[7]['value']) === 'Y') checked @endif> Wavelet tree (location) and Wavelet tree (text)
                  </label>
                </div>
              </div>
              <div class="col-lg-5">
                <label>Hybrid Search</label>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" class="forchange" name="hybrid_keyword_spatial_rtree_btree" @if (($settings[8]['value']) === 'Y') checked @endif> Keyword Spatial : R tree (location) and B tree (text)
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" class="forchange" name="hybrid_spatial_keyword_rtree_btree" @if (($settings[9]['value']) === 'Y') checked @endif> Spatial Keyword : R tree (location) and B tree (text)
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" class="forchange" name="hybrid_keyword_spatial_rtree_wavelet" @if (($settings[10]['value']) === 'Y') checked @endif> Keyword Spatial : R tree (location) and Wavelet tree (text)
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" class="forchange" name="hybrid_spatial_keyword_rtree_wavelet" @if (($settings[11]['value']) === 'Y') checked @endif> Spatial Keyword : R tree (location) and Wavelet tree (text)
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" class="forchange" name="hybrid_keyword_spatial_rstartree_btree" @if (($settings[12]['value']) === 'Y') checked @endif> Keyword Spatial : R* tree (location) and B tree (text)
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" class="forchange" name="hybrid_spatial_keyword_rstartree_btree" @if (($settings[13]['value']) === 'Y') checked @endif> Spatial Keyword : R* tree (location) and B tree (text)
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" class="forchange" name="hybrid_keyword_spatial_rstartree_wavelet" @if (($settings[14]['value']) === 'Y') checked @endif> Keyword Spatial : R* tree (location) and B tree (text)
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" class="forchange" name="hybrid_spatial_keyword_rstartree_wavelet" @if (($settings[15]['value']) === 'Y') checked @endif> Spatial Keyword : R* tree (location) and B tree (text)
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" class="forchange" name="hybrid_keyword_spatial_wavelet_btree" @if (($settings[16]['value']) === 'Y') checked @endif> Keyword Spatial : Wavelet tree (location) and B tree (text)
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" class="forchange" name="hybrid_spatial_keyword_wavelet_btree" @if (($settings[17]['value']) === 'Y') checked @endif> Spatial Keyword : Wavelet tree (location) and B tree (text)
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" class="forchange" name="hybrid_keyword_spatial_wavelet_wavelet" @if (($settings[18]['value']) === 'Y') checked @endif> Keyword Spatial : Wavelet tree (location) and Wavelet tree (text)
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" class="forchange" name="hybrid_spatial_keyword_wavelet_wavelet" @if (($settings[19]['value']) === 'Y') checked @endif> Spatial Keyword : Wavelet tree (location) and Wavelet tree (text)
                  </label>
                </div>
              </div>
            </div>
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
  var needToConfirm = false;
  $(document).ready(function(){
    $.material.init();
  });
  $( "input[type='checkbox']" ).change(function() {
    needToConfirm = true;
  });
  
  </script>
</body>
</html>