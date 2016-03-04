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
    <div style="page-break-after:always;" class="panel panel-default">
      <div class="panel-heading"><b><u>TEXTUAL SEARCH</u> -> </b><b><u>PRECISION-RECALL SUMMARY</u></b> <br/><small>This section provides precision and recall summary for textual searching based upon feedback recieved.</small></div>
      <div class="panel-body">
        <fieldset>
          <legend><u>PRECISION</u></legend>
          <div class="form-group">
            <div align="center" class="col-lg-12">
              <canvas id="tex_pre_rec" width="200" height="200"></canvas>
              <span style="color:#78A5A3;"> &#9673 CORRECT RESULT </span>|
              <span style="color:#CE5A57;"> &#9673 INCORRECT RESULT </span>|
              <span style="color:#E1B16A;"> &#9673 UNVERIFIED RESULTS </span>
              <br/>
              <br/>
            </div>
            <table class="table table-striped table-hover table-bordered">
              <tr>
                  <th>QUERY STRING</th>
                  <th>TOTAL DOCUMENT RETRIEVED</th>
                  <th>CORRECT RESULTS</th>
                  <th>INCORRECT RESULT</th>
                  <th>UNVERIFIED RESULT</th>
                  <th>PRECISION PERCENTAGE</th>
              </tr>
              <tr>
                  <td>College</td>
                  <td>96</td>
                  <td>73</td>
                  <td>14</td>
                  <td>9</td>
                  <td>(73/(73+14))*100 = 83.90%</td>
              </tr>
            </table>
          </div>
        </fieldset>
        <hr>
        <fieldset>
          <legend><u>RECALL <small>(CALCULATED MANUALLY)</small></u></legend>
          <div class="form-group">
            <div class="col-lg-6">
              <label>QUERY STRING : College</label><br/>
                TOTAL RELEVANT DOCUMENT : 98<br/>
                TOTAL RELEVANT DOCUMENT RETRIEVED : 87<br/>
                RECALL PERCENTAGE : (87/98)*100 = 88.77%<br/>
            </div>
            <div class="col-lg-6">
              <label style="display:inline;">QUERY STRING : Engineering College</label><br/>
              TOTAL RELEVANT DOCUMENT : 62<br/>
              TOTAL RELEVANT DOCUMENT RETRIEVED : 48<br/>
              RECALL PERCENTAGE : (48/62)*100 = 77.14%<br/>
            </div>
          </div> 
        </fieldset>
      </div>
    </div>
    <div style="page-break-after:always;" class="panel panel-default">
      <div class="panel-heading"><b><u>TEXTUAL SEARCH</u> -> </b><b><u>GENERAL COMPARISON</u></b> <br/><small>This section provide comparison of various indexing techniques without considering their construction time i.e. only <b>search</b> time and space is compared.</small></div>
      <div class="panel-body">
        <table class="table table-striped table-hover table-bordered">
          <tr align="center">
              <th width="50%">DATA STRUCTURE</th>
              <th width="50%">TEXTUAL SEARCH</th>
          </tr>
          @if (($settings[0]['value']) === 'Y')
          <tr>
              <td style="vertical-align:middle;">B Tree</td>
              <td>SPACE : {{ $result[0] }}<br/><br/>TIME : {{ $result[1] }}</td>
          </tr>
          @endif
          @if (($settings[1]['value']) === 'Y')
          <tr>
              <td style="vertical-align:middle;">Wavelet Tree</td>
              <td>SPACE : {{ $result[2] }}<br/><br/>TIME : {{ $result[3] }}</td>
          </tr>
          @endif
        </table>
        <small>NOTE : The above results are based on all the search done using this search engine. It does not guarentee exactly same result for different kinds of query. The above mentioned data is simply an average of numerous user queries.</small>
      </div>
    </div>
    <!-- <div style="display:inline-block;" class="panel panel-default">
      <div class="panel-heading"><b><u>TEXTUAL SEARCH</u> -> </b><b><u>SINGLE KEYWORD QUERY COMPARISON</u></b> <br/><small>This section provide comparison of various indexing techniques without considering their construction time i.e. only <b>search</b> time and space is compared.</small></div>
      <div class="panel-body">
        <div align="center" class="col-lg-12">
          <canvas id="tex_sin_key" width="900" height="550"></canvas>
        </div>
      </div>
    </div>
    <div style="display:inline-block;" class="panel panel-default">
      <div class="panel-heading"><b><u>TEXTUAL SEARCH</u> -> </b><b><u>QUERY LENGTH COMPARISON</u></b> <br/><small>This section provide comparison of various indexing techniques without considering their construction time i.e. only <b>search</b> time and space is compared.</small></div>
      <div class="panel-body">
        <div align="center" class="col-lg-12">
          <canvas id="tex_que_len" width="900" height="550"></canvas>
        </div>
      </div>
    </div> -->
    <div style="page-break-after:always;" class="panel panel-default">
      <div class="panel-heading"><b><u>DUAL SEARCH</u> -> </b><b><u>PRECISION-RECALL SUMMARY</u></b> <br/><small>This section provide comparison of various indexing techniques without considering their construction time i.e. only <b>search</b> time and space is compared.</small></div>
      <div class="panel-body">
        <fieldset>
          <legend><u>PRECISION</u></legend>
          <div class="form-group">
            <div align="center" class="col-lg-12">
              <canvas id="dua_pre_rec" width="200" height="200"></canvas>
              <span style="color:#78A5A3;"> &#9673 CORRECT RESULT </span>|
              <span style="color:#CE5A57;"> &#9673 INCORRECT RESULT </span>|
              <span style="color:#E1B16A;"> &#9673 UNVERIFIED RESULTS </span>
              <br/><br/>
            </div>
            <table class="table table-striped table-hover table-bordered">
              <tr>
                  <th>QUERY STRING</th>
                  <th>TOTAL DOCUMENT RETRIEVED</th>
                  <th>CORRECT RESULTS</th>
                  <th>INCORRECT RESULT</th>
                  <th>UNVERIFIED RESULT</th>
                  <th>PRECISION PERCENTAGE</th>
              </tr>
              <tr>
                  <td>College in Ghaziabad</td>
                  <td>55</td>
                  <td>36</td>
                  <td>4</td>
                  <td>15</td>
                  <td>(36/(36+4))*100 = 90%</td>
              </tr>
            </table>
          </div>
        </fieldset>
        <hr>
        <fieldset>
          <legend><u>RECALL <small>(CALCULATED MANUALLY)</small></u></legend>
          <div class="form-group">
            <div class="col-lg-6">
              <label>QUERY STRING : College</label><br/>
                TOTAL RELEVANT DOCUMENT : 98<br/>
                TOTAL RELEVANT DOCUMENT RETRIEVED : 87<br/>
                RECALL PERCENTAGE : (87/98)*100 = 88.77%<br/>
            </div>
            <div class="col-lg-6">
              <label>QUERY STRING : College in Ghaziabad</label><br/>
              TOTAL RELEVANT DOCUMENT : 68<br/>
              TOTAL RELEVANT DOCUMENT RETRIEVED : 55<br/>
              RECALL PERCENTAGE : (55/68)*100 = 80.88%<br/>
            </div>
          </div> 
        </fieldset>
      </div>
    </div>
    <div style="page-break-after:always;" class="panel panel-default">
      <div class="panel-heading"><b><u>DUAL SEARCH</u> -> </b><b><u>GENERAL COMPARISON</u></b> <br/><small>This section provide comparison of various indexing techniques without considering their construction time i.e. only <b>search</b> time and space is compared.</small></div>
      <div class="panel-body">
        <table class="table table-striped table-hover table-bordered">
          <tr align="center">
              <th width="50%">DATA STRUCTURE</th>
              <th width="50%">DUAL SEARCH</th>
          </tr>
          @if (($settings[2]['value']) === 'Y')
          <tr>
              <td style="vertical-align:middle;">R Tree (location) and B Tree (text)</td>
              <td>SPACE : {{ $result[4] }}<br/><br/>TIME : {{ $result[5] }}</td>
          </tr>
          @endif
          @if (($settings[3]['value']) === 'Y')
          <tr>
              <td style="vertical-align:middle;">R Tree (location) and Wavelet Tree (text)</td>
              <td>SPACE : {{ $result[6] }}<br/><br/>TIME : {{ $result[7] }}</td>
          </tr>
          @endif
          @if (($settings[4]['value']) === 'Y')
          <tr>
              <td style="vertical-align:middle;">R* Tree (location) and B Tree (text)</td>
              <td>SPACE : {{ $result[8] }}<br/><br/>TIME : {{ $result[9] }}</td>
          </tr>
          @endif
          @if (($settings[5]['value']) === 'Y')
          <tr>
              <td style="vertical-align:middle;">R* Tree (location) and Wavelet Tree (text)</td>
              <td>SPACE : {{ $result[10] }}<br/><br/>TIME : {{ $result[11] }}</td>
          </tr>
          @endif
          @if (($settings[6]['value']) === 'Y')
          <tr>
              <td style="vertical-align:middle;">Wavelet Tree (location) and B Tree (text)</td>
              <td>SPACE : {{ $result[12] }}<br/><br/>TIME : {{ $result[13] }}</td>
          </tr>
          @endif
          @if (($settings[7]['value']) === 'Y')
          <tr>
              <td style="vertical-align:middle;">Wavelet Tree (location) and Wavelet Tree (text)</td>
              <td>SPACE : {{ $result[14] }}<br/><br/>TIME : {{ $result[15] }}</td>
          </tr>
          @endif
        </table>
        <small>NOTE : The above results are based on all the search done using this search engine. It does not guarentee exactly same result for different kinds of query. The above mentioned data is simply an average of numerous user queries.</small>
      </div>
    </div>
    <!-- <div style="display:inline-block;" class="panel panel-default">
      <div class="panel-heading"><b><u>DUAL SEARCH</u> -> </b><b><u>SINGLE KEYWORD QUERY COMPARISON</u></b> <br/><small>This section provide comparison of various indexing techniques without considering their construction time i.e. only <b>search</b> time and space is compared.</small></div>
      <div class="panel-body">
        <div align="center" class="col-lg-12">
          <canvas id="dua_sin_key" width="900" height="550"></canvas>
        </div>
      </div>
    </div>
    <div style="display:inline-block;" class="panel panel-default">
      <div class="panel-heading"><b><u>DUAL SEARCH</u> -> </b><b><u>QUERY LENGTH COMPARISON</u></b> <br/><small>This section provide comparison of various indexing techniques without considering their construction time i.e. only <b>search</b> time and space is compared.</small></div>
      <div class="panel-body">
        <div align="center" class="col-lg-12">
          <canvas id="dua_que_len" width="900" height="550"></canvas>
        </div>
      </div>
    </div> -->
    <!-- <div style="display:inline-block;" class="panel panel-default">
      <div class="panel-heading"><b><u>HYBRID SEARCH</u> -> </b><b><u>PRECISION-RECALL SUMMARY</u></b> <br/><small>This section provide comparison of various indexing techniques without considering their construction time i.e. only <b>search</b> time and space is compared.</small></div>
      <div class="panel-body">
        <fieldset>
          <legend><u>PRECISION</u></legend>
          <div class="form-group">
            <div align="center" class="col-lg-12">
              <canvas id="hyb_pre_rec" width="200" height="200"></canvas>
              <span style="color:#78A5A3;"> &#9673 CORRECT RESULT </span>|
              <span style="color:#CE5A57;"> &#9673 INCORRECT RESULT </span>|
              <span style="color:#E1B16A;"> &#9673 UNVERIFIED RESULTS </span>
              <br/><br/>
            </div>
            <table class="table table-striped table-hover table-bordered">
              <tr>
                  <th>QUERY STRING</th>
                  <th>TOTAL DOCUMENT RETRIEVED</th>
                  <th>CORRECT RESULTS</th>
                  <th>INCORRECT RESULT</th>
                  <th>UNVERIFIED RESULT</th>
                  <th>PRECISION PERCENTAGE</th>
              </tr>
              <tr>
                  <td>[sample]</td>
                  <td>[sample]</td>
                  <td>[sample]</td>
                  <td>[sample]</td>
                  <td>[sample]</td>
                  <td>[sample]</td>
              </tr>
            </table>
          </div>
        </fieldset>
        <hr>
        <fieldset>
          <legend><u>RECALL <small>(CALCULATED MANUALLY)</small></u></legend>
          <div class="form-group">
            <div class="col-lg-6">
              <label>QUERY STRING : [any single length query]</label><br/>
                TOTAL RELEVANT DOCUMENT : <br/>
                TOTAL RELEVANT DOCUMENT RETRIEVED : <br/>
                RECALL PERCENTAGE : <br/>
            </div>
            <div class="col-lg-6">
              <label>QUERY STRING : [any single length query]</label><br/>
              TOTAL RELEVANT DOCUMENT : <br/>
              TOTAL RELEVANT DOCUMENT RETRIEVED : <br/>
              RECALL PERCENTAGE : <br/>
            </div>
          </div> 
        </fieldset>
      </div>
    </div>
    <div style="display:inline-block;" class="panel panel-default">
      <div class="panel-heading"><b><u>HYBRID SEARCH</u> -> </b><b><u>GENERAL COMPARISON</u></b> <br/><small>This section provide comparison of various indexing techniques without considering their construction time i.e. only <b>search</b> time and space is compared.</small></div>
      <div class="panel-body">
        <table class="table table-striped table-hover table-bordered">
          <tr align="center">
              <th width="25%">DATA STRUCTURE</th>
              <th width="25%">HYBRID SEARCH : KEYWORD-LOCATION</th>
              <th width="25%">HYBRID SEARCH : LOCATION-KEYWORD</th>
          </tr>
          <tr>
              <td style="vertical-align:middle;">R Tree (location) and B Tree (text)</td>
              @if (($settings[8]['value']) === 'Y')
              <td>SPACE : ∞<br/><br/>TIME : ∞</td>
              @else
              <td>Not Implemented</td>
              @endif
              @if (($settings[9]['value']) === 'Y')
              <td>SPACE : ∞<br/><br/>TIME : ∞</td>
              @else
              <td>Not Implemented</td>
              @endif
          </tr>
          <tr>
              <td style="vertical-align:middle;">R Tree (location) and Wavelet Tree (text)</td>
              @if (($settings[10]['value']) === 'Y')
              <td>SPACE : ∞<br/><br/>TIME : ∞</td>
              @else
              <td>Not Implemented</td>
              @endif
              @if (($settings[11]['value']) === 'Y')
              <td>SPACE : ∞<br/><br/>TIME : ∞</td>
              @else
              <td>Not Implemented</td>
              @endif
          </tr>
          <tr>
              <td style="vertical-align:middle;">R* Tree (location) and B Tree (text)</td>
              @if (($settings[12]['value']) === 'Y')
              <td>SPACE : ∞<br/><br/>TIME : ∞</td>
              @else
              <td>Not Implemented</td>
              @endif
              @if (($settings[13]['value']) === 'Y')
              <td>SPACE : ∞<br/><br/>TIME : ∞</td>
              @else
              <td>Not Implemented</td>
              @endif
          </tr>
          <tr>
              <td style="vertical-align:middle;">R* Tree (location) and Wavelet Tree (text)</td>
              @if (($settings[14]['value']) === 'Y')
              <td>SPACE : ∞<br/><br/>TIME : ∞</td>
              @else
              <td>Not Implemented</td>
              @endif
              @if (($settings[15]['value']) === 'Y')
              <td>SPACE : ∞<br/><br/>TIME : ∞</td>
              @else
              <td>Not Implemented</td>
              @endif
          </tr>
          <tr>
              <td style="vertical-align:middle;">Wavelet Tree (location) and B Tree (text)</td>
              @if (($settings[16]['value']) === 'Y')
              <td>SPACE : ∞<br/><br/>TIME : ∞</td>
              @else
              <td>Not Implemented</td>
              @endif
              @if (($settings[17]['value']) === 'Y')
              <td>SPACE : ∞<br/><br/>TIME : ∞</td>
              @else
              <td>Not Implemented</td>
              @endif
          </tr>
          <tr>
              <td style="vertical-align:middle;">Wavelet Tree (location) and Wavelet Tree (text)</td>
              @if (($settings[18]['value']) === 'Y')
              <td>SPACE : ∞<br/><br/>TIME : ∞</td>
              @else
              <td>Not Implemented</td>
              @endif
              @if (($settings[19]['value']) === 'Y')
              <td>SPACE : ∞<br/><br/>TIME : ∞</td>
              @else
              <td>Not Implemented</td>
              @endif
          </tr>
        </table>
        <small>NOTE : The above results are based on all the search done using this search engine. It does not guarentee exactly same result for different kinds of query. The above mentioned data is simply an average of numerous user queries.</small>
      </div>
    </div>
    <div style="display:inline-block;" class="panel panel-default">
      <div class="panel-heading"><b><u>HYBRID SEARCH</u> -> </b><b><u>SINGLE KEYWORD QUERY COMPARISON</u></b> <br/><small>This section provide comparison of various indexing techniques without considering their construction time i.e. only <b>search</b> time and space is compared.</small></div>
      <div class="panel-body">
        <div align="center" class="col-lg-12">
          <canvas id="hyb_sin_key" width="900" height="550"></canvas>
        </div>
      </div>
    </div>
    <div style="display:inline-block;" class="panel panel-default">
      <div class="panel-heading"><b><u>HYBRID SEARCH</u> -> </b><b><u>QUERY LENGTH COMPARISON</u></b> <br/><small>This section provide comparison of various indexing techniques without considering their construction time i.e. only <b>search</b> time and space is compared.</small></div>
      <div class="panel-body">
        <div align="center" class="col-lg-12">
          <canvas id="hyb_que_len" width="900" height="550"></canvas>
        </div>
      </div>
    </div> -->
  </div>
  <script type="text/javascript" src="{!! URL::asset('js/jquery-1.11.3.min.js') !!}"></script>
  <script type="text/javascript" src="{!! URL::asset('js/bootstrap.min.js') !!}"></script>
  <script type="text/javascript" src="{!! URL::asset('js/material.min.js') !!}"></script>
  <script type="text/javascript" src="{!! URL::asset('js/ripples.min.js') !!}"></script>
  <script type="text/javascript" src="{!! URL::asset('js/chart/Chart.min.js') !!}"></script>
  <script>
  var needToConfirm = false;
  $(document).ready(function(){
    $.material.init();
  });
  $( "input[type='checkbox']" ).change(function() {
    needToConfirm = true;
  });
  var tex_pre_rec_data = [
      {
          value: 73,
          color: "#78A5A3",
          highlight: "#78A5A5",
          label: "CORRECT RESULTS"
      },
      {
          value: 14,
          color: "#CE5A57",
          highlight: "#CE5A59",
          label: "INCORRECT RESULTS"
      },
      {
          value: 9,
          color: "#E1B16A",
          highlight: "#E1B16C",
          label: "UNVERIFIED RESULTS"
      }
  ];
  var tex_sin_key_data = {
      labels: ['QUERY=[sample]', 'QUERY=[sample]', 'QUERY=[sample]'],
      datasets: [
          {
              label: 'B-tree',
              fillColor: "#CE5A57",
              highlightFill: "#CE5A59",
              data: [2500, 1902, 1041]
          },
          {
              label: 'Wavelet Tree',
              fillColor: "#E1B16A",
              highlightFill: "#E1B16C",
              data: [3104, 1689, 1318]
          }
      ]
  };
  var tex_que_len_data = {
      labels: ['QUERY=[sample]', 'QUERY=[sample]', 'QUERY=[sample]'],
      datasets: [
          {
              label: 'B-tree',
              fillColor: "#CE5A57",
              highlightFill: "#CE5A59",
              data: [2500, 1902, 1041]
          },
          {
              label: 'Wavelet Tree',
              fillColor: "#E1B16A",
              highlightFill: "#E1B16C",
              data: [3104, 1689, 1318]
          }
      ]
  };
  var dua_pre_rec_data = [
      {
          value: 36,
          color: "#78A5A3",
          highlight: "#78A5A5",
          label: "CORRECT RESULTS"
      },
      {
          value: 4,
          color: "#CE5A57",
          highlight: "#CE5A59",
          label: "INCORRECT RESULTS"
      },
      {
          value: 15,
          color: "#E1B16A",
          highlight: "#E1B16C",
          label: "UNVERIFIED RESULTS"
      }
  ];
  var dua_sin_key_data = {
      labels: ['QUERY=[sample]', 'QUERY=[sample]', 'QUERY=[sample]'],
      datasets: [
          {
              label: 'B-tree',
              fillColor: "#CE5A57",
              highlightFill: "#CE5A59",
              data: [2500, 1902, 1041]
          },
          {
              label: 'Wavelet Tree',
              fillColor: "#E1B16A",
              highlightFill: "#E1B16C",
              data: [3104, 1689, 1318]
          }
      ]
  };
  var dua_que_len_data = {
      labels: ['QUERY=[sample]', 'QUERY=[sample]', 'QUERY=[sample]'],
      datasets: [
          {
              label: 'B-tree',
              fillColor: "#CE5A57",
              highlightFill: "#CE5A59",
              data: [2500, 1902, 1041]
          },
          {
              label: 'Wavelet Tree',
              fillColor: "#E1B16A",
              highlightFill: "#E1B16C",
              data: [3104, 1689, 1318]
          }
      ]
  };
  var hyb_pre_rec_data = [
      {
          value: 500,
          color: "#78A5A3",
          highlight: "#78A5A5",
          label: "CORRECT RESULTS"
      },
      {
          value: 30,
          color: "#CE5A57",
          highlight: "#CE5A59",
          label: "INCORRECT RESULTS"
      },
      {
          value: 100,
          color: "#E1B16A",
          highlight: "#E1B16C",
          label: "UNVERIFIED RESULTS"
      }
  ];
  var hyb_sin_key_data = {
      labels: ['QUERY=[sample]', 'QUERY=[sample]', 'QUERY=[sample]'],
      datasets: [
          {
              label: 'B-tree',
              fillColor: "#CE5A57",
              highlightFill: "#CE5A59",
              data: [2500, 1902, 1041]
          },
          {
              label: 'Wavelet Tree',
              fillColor: "#E1B16A",
              highlightFill: "#E1B16C",
              data: [3104, 1689, 1318]
          }
      ]
  };
  var hyb_que_len_data = {
      labels: ['QUERY=[sample]', 'QUERY=[sample]', 'QUERY=[sample]'],
      datasets: [
          {
              label: 'B-tree',
              fillColor: "#CE5A57",
              highlightFill: "#CE5A59",
              data: [2500, 1902, 1041]
          },
          {
              label: 'Wavelet Tree',
              fillColor: "#E1B16A",
              highlightFill: "#E1B16C",
              data: [3104, 1689, 1318]
          }
      ]
  };

  var pieOptions = {
    animation : false,
    segmentShowStroke : true,
    segmentStrokeColor : "#fff",
    segmentStrokeWidth : 2,
  }
  var barOptions = {
    animation : false,
  }

  Chart.defaults.global.tooltipFontSize = 10;
  var tex_pre_rec = document.getElementById("tex_pre_rec").getContext("2d");
  var tex_pre_rec_chart = new Chart(tex_pre_rec).Pie(tex_pre_rec_data, pieOptions);
  // var tex_sin_key = document.getElementById("tex_sin_key").getContext('2d');
  // var tex_sin_key_chart = new Chart(tex_sin_key).Bar(tex_sin_key_data, barOptions);
  // var tex_que_len = document.getElementById("tex_que_len").getContext('2d');
  // var tex_que_len_chart = new Chart(tex_que_len).Bar(tex_que_len_data, barOptions);
  var dua_pre_rec = document.getElementById("dua_pre_rec").getContext("2d");
  var dua_pre_rec_chart = new Chart(dua_pre_rec).Pie(dua_pre_rec_data, pieOptions);
  // var dua_sin_key = document.getElementById("dua_sin_key").getContext('2d');
  // var dua_sin_key_chart = new Chart(dua_sin_key).Bar(dua_sin_key_data, barOptions);
  // var dua_que_len = document.getElementById("dua_que_len").getContext('2d');
  // var dua_que_len_chart = new Chart(dua_que_len).Bar(dua_que_len_data, barOptions);
  // var hyb_pre_rec = document.getElementById("hyb_pre_rec").getContext("2d");
  // var hyb_pre_rec_chart = new Chart(hyb_pre_rec).Pie(hyb_pre_rec_data, pieOptions);
  // var hyb_sin_key = document.getElementById("hyb_sin_key").getContext('2d');
  // var hyb_sin_key_chart = new Chart(hyb_sin_key).Bar(hyb_sin_key_data, barOptions);
  // var hyb_que_len = document.getElementById("hyb_que_len").getContext('2d');
  // var hyb_que_len_chart = new Chart(hyb_que_len).Bar(hyb_que_len_data, barOptions);
  </script>
</body>
</html>