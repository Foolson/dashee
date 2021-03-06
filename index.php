<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dash</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
      .container{
        margin-top: 40px;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">CPU</h3>
            </div>
            <div class="panel-body">
              <div id="cpu_graph" style="min-height:250px"  ></div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Memory</h3>
            </div>
            <div class="panel-body">
              <div id="ram_graph" style="min-height:250px"  ></div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Storage</h3>
            </div>
            <div class="panel-body">
              <div id="storage_graph" style="min-height:250px"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Services</h3>
            </div>
            <div class="panel-body">
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Processes</h3>
            </div>
            <div class="panel-body">
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Log</h3>
            </div>
            <div class="panel-body">
              <span id="test"></span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.pie.min.js"></script>
    <script type="text/javascript">
      setInterval(function(){
        $(document).ready(function(){
          $.getJSON("core/shell.php?module=memory",function(data){
            $.plot($("#ram_graph"),[
              {label: "ram", data: [[0,data.ram.percent]]},
              {label: "swap", data: [[1,data.swap.percent]]}
            ],
            {
              bars: {
                show: true,
                lineWidth: 0
              },
              yaxis: {
                min: 0,
                max: 100
              },
              xaxis: {
                show: false
              }
            }
          );
          });
          $.getJSON("core/shell.php?module=cpu",function(data){
            var cpuData = [];
            var count = 0;
            $.each(data.cpu.core,function(key, value){
              cpuData.push({label: key, data: [[count,value]]});
              count = count + 1;
            });
            cpuData.push({label: "total", data: [[count,data.cpu.total]]});
            $.plot($("#cpu_graph"),cpuData,
            {
              bars: {
                show: true,
                lineWidth: 0
              },
              yaxis: {
                min: 0,
                max:100
              },
              xaxis: {
                show: false
              }
            }
            );
          });
          $.getJSON("core/shell.php?module=storage",function(data){
            $.plot($("#storage_graph"),[
              {label: "used "+data.storage.root.used+"MB", data: [[0,data.storage.root.used]]},
              {label: "free "+data.storage.root.free+"MB", data: [[0,data.storage.root.free]]}
            ],
            {
              series: {
              pie: {
                show: true,
                lineWidth: 0
              }}
            }
            );
          });
          $.get( "core/shell.php?module=log", function( data ) {
            $('span#test').replaceWith("<pre>"+data+"</pre>");
          });
        });
      }, 2000);
    </script>
  </body>
</html>
