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
    <div class="panel-heading">The URL provided below will be looked upon for various URLs used within it.</div>
    <div class="panel-body">
        <form class="form-horizontal" method="post" action="crawl_url">
            <fieldset>
                <div class="form-group">
                    <label class="col-lg-2 control-label">Crawl</label>
                    <div class="col-lg-10">
                        <!--Validation works in Modern browsers except Safari-->
                        <input type="text" class="form-control" name="url" placeholder="Enter the URL here" required>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        <button type="submit" value="submit" class="btn btn-primary">Start</button>
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
$(document).ready(function(){
    $.material.init();
});
</script>
</body>
</html>