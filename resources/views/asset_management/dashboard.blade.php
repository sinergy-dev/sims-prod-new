@extends('template.main_sneat')
@section('tittle')
  Dashboard
@endsection
@section('pageName')
  Dashboard Asset Management
@endsection
@section('head_css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<style type="text/css">
  .form-group{
    margin-bottom: 15px;
  }
</style>
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <section class="content">
    <div class="row mb-4">
      <div class="col-lg-3 col-xs-12">
        <div class="card card-border-shadow-primary h-100">
          <div class="card-body">
            <div class="d-flex align-items-center mb-2">
              <div class="avatar me-4">
                <span class="avatar-initial rounded bg-label-primary"><i class="icon-base bx bx-table icon"></i></span>
              </div>
              <h4 class="counter mb-0" id="countAll">0</h4>
            </div>
            <p class="mb-2">Total Assets</p>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-xs-12">
        <div class="card card-border-shadow-primary h-100">
          <div class="card-body">
            <div class="d-flex align-items-center mb-2">
              <div class="avatar me-4">
                <span class="avatar-initial rounded bg-label-primary"><i class="icon-base bx bx-cog icon"></i></span>
              </div>
              <h4 class="counter mb-0" id="countInstalled">0</h4>
            </div>
            <p class="mb-2">Installed</p>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-xs-12">
        <div class="card card-border-shadow-primary h-100">
          <div class="card-body">
            <div class="d-flex align-items-center mb-2">
              <div class="avatar me-4">
                <span class="avatar-initial rounded bg-label-primary"><i class="icon-base bx bx-card icon"></i></span>
              </div>
              <h4 class="counter mb-0" id="countAvailable">0</h4>
            </div>
            <p class="mb-2">Available</p>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-xs-12">
        <div class="card card-border-shadow-primary h-100">
          <div class="card-body">
            <div class="d-flex align-items-center mb-2">
              <div class="avatar me-4">
                <span class="avatar-initial rounded bg-label-primary"><i class="icon-base bx bx-list-ul icon"></i></span>
              </div>
              <h4 class="counter mb-0" id="countTemporary">0</h4>
            </div>
            <p class="mb-2">Temporary</p>
          </div>
        </div>
      </div>
    </div>
    
    <div class="row mb-4">
      <div class="col-md-3 col-xs-12">
        <div class="card card-primary">
          <div class="card-header">
            <h6 class="card-title"><i class="fa fa-filter"></i> Filter</h6>
          </div>
          <div class="card-body">
            <div class="form-group">
              <label>Asset Owner</label>
              <select class="form-control" id="selectFilterAssetOwner" name="selectFilterAssetOwner" style="width: 100%!important;">
                <option></option>
              </select>
            </div>
            <div class="form-group">
              <label>Category</label>
              <select class="form-control" id="selectFilterCategory" name="selectFilterCategory" style="width: 100%!important;">
                <option></option>
              </select>
            </div>
            <div class="form-group">
              <label>Client</label>
              <select class="form-control" id="selectFilterClient" name="selectFilterClient" style="width: 100%!important;"><option></option></select>
            </div>
            <div class="form-group">
              <label>PID</label>
              <select class="form-control" id="selectFilterPID" name="selectFilterPID" style="width: 100%!important;">
                <option></option>
              </select>
            </div>
            <div class="form-group">
              <label>Year</label>
              <select class="form-control" id="selectYear" name="selectYear" style="width:100%!important">
                @php
                    $currentYear = date('Y'); // Keep it as a string to match possible string values from DB
                @endphp
                <option value="">Select Year</option>
                @foreach($year as $data)
                    <option value="{{ $data->year }}" {{ (string) $data->year === (string) $currentYear ? 'selected' : '' }}>
                        {{ $data->year }}
                    </option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="card-footer">
            <div class="d-grid gap-2">
              <button class="btn btn-sm btn-lg btn-primary" onclick="filterAsset()">Filter</button>
              <button class="btn btn-sm btn-lg btn-danger" onclick="filterResetAsset()">Reset Filter</button>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-9 col-xs-12">
        <div class="row mb-4">
          <div class="col-lg-6 col-xs-12">
            <div class="card card-primary">
              <div class="card-header with-border">
                <h6 class="card-title">Asset Owner</h6>
              </div>
              <div class="card-body">
                <div class="row mb-4">
                  <div class="col-md-12 col-xs-12">
                    <div class="chart-responsive">
                      <canvas id="doughnutChartAssetOwner" height="300" width="400" style="width: 400px; height: 300px;"></canvas>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6 col-xs-12">
            <div class="card card-primary">
              <div class="card-header with-border">
                <h6 class="card-title">Category</h6>
              </div>

              <div class="card-body">
                <div class="row mb-4">
                  <div class="col-md-12 col-xs-12">
                    <div class="chart-responsive">
                      <canvas id="doughnutChartCategory" height="300" width="400" style="width: 400px; height: 300px;"></canvas>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row mb-4">
          <div class="col-lg-6 col-xs-12">
            <div class="card card-primary">
              <div class="card-header with-border">
                <h6 class="card-title">Vendor</h6>
              </div>

              <div class="card-body">
                <div class="chart-responsive">
                  <canvas id="doughnutChartVendor" height="300" width="400" style="width: 400px; height: 300px;"></canvas>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6 col-xs-12">
            <div class="card card-primary">
              <div class="card-header with-border">
                <h6 class="card-title">Client</h6>
              </div>

              <div class="card-body">
                <div class="row mb-4">
                  <div class="col-md-12 col-xs-12">
                    <div class="chart-responsive">
                      <canvas id="doughnutChartClient" height="300" width="400" style="width: 400px; height: 300px;"></canvas>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row mb-4">
          <div class="col-md-12 l-xs-12">
            <div class="card card-info">
              <div class="card-header with-border">
                <h6 class="card-title">Recent Activities</h6>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table id="tb_LogActivity" class="table" style="width:100%;word-wrap: break-word;"></table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

     <!--  <div class="col-lg-4 col-xs-12">
        <div class="card card-info">
          <div class="card-header with-border">
            <h6 class="card-title">Recent Activities</h6>
          </div>
          <div class="card-body">
            <div class="table-responsive" style="scrollbar-width:thin">
              <ul id="tb_LogActivity" style="min-height: fit-content;max-height: 1150px;scr">
              </ul>
            </div>
          </div>
        </div>
      </div> -->
    </div>
  </section>
</div>
@endsection
@section('scriptImport')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>
  <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
@endsection
@section('script')
  <script type="text/javascript">
    let chartAssetOwner = document.getElementById("doughnutChartAssetOwner");
    let chartCategory = document.getElementById("doughnutChartCategory");
    let chartVendor = document.getElementById("doughnutChartVendor");
    let chartClient = document.getElementById("doughnutChartClient");
    var arrColorVendor = [], arrColorClient = [], arrColorAsset = [], arrColorCategory = [], arrColor = []

    // $.ajax({
    //   url:"{{url('asset/getChartCategory')}}",
    //   type:"GET",
    //   success:function(result){
    //     const dataCategory = {
    //       labels: result[0].name,
    //       datasets: [{
    //         data: result[0].chart,
    //         backgroundColor: [
    //           '#0c2636',
    //           '#184d6e',
    //           '#31788c',
    //           '#44a6c2'
    //         ],
    //         hoverOffset: 4
    //       }]
    //     };

    //     var doughnutChartCategory = new Chart(chartCategory, {
    //       type:"doughnut",
    //       data: dataCategory,
    //       options: {
    //         responsive: true,
    //         legend: {
    //           position: 'top',
    //           display:false
    //         },
    //         tooltips: {
    //           callbacks: {
    //             label: function(tooltipItem, data) {
    //                 var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
    //                 var dataLabel = data.labels[tooltipItem.index];
    //                 var value = tooltipItem.yLabel;
    //                 return dataLabel + ' - ' + data['datasets'][0]['data'][tooltipItem['index']].toFixed(2) + '%';
    //             }
    //           }
    //         },
    //       },
    //     })

    //     return doughnutChartCategory
    //   }
    // })

    $(document).ready(function () {
      $("#selectYear").select2({
        multiple:true
      });
      $("#selectYear").val(new Date().getFullYear()).trigger("change");
      let assetOwner = $("#selectFilterAssetOwner").val() ?? "";
      let category = $("#selectFilterCategory").val() ?? "";
      let client = $("#selectFilterClient").val() ?? "";
      let pid = $("#selectFilterPID").val() ?? "";
      initGetDataChartVendor()
      initGetDataChartCategory()
      initGetDataChartClient()
      initGetDataChartAssetOwner()
      initGetCountDashboard('year[]='+$("#selectYear").val(),assetOwner,category,client,pid)

      $("#tb_LogActivity").DataTable({
        "aaSorting": [],
        "ajax":{
          "type":"GET",
          "url":"{{url('asset/getLog')}}?year[]="+$("#selectYear").val()
        },
        "columns": [
          { 
            title:"No",
            render: function (data, type, row, meta){
              return meta.row + 1;
            },
            width:"10%"
          },
          {
            title:"Date",
            data:"date_add",
            width:"25%"
          },
          {
            title:"Operator",
            data:"operator",
            width:"25%" 
          },
          {
            title:"Description",
            data:"activity",
            width:"40%"
          }
        ]
      })
    });

    $.ajax({
      url:"{{url('asset/getColor')}}",
      type:"GET",
      success:function(result){
        $.each(result.colors,function(item,value){
          if (value.hex != "000000" && value.hex != "0000FF") {
            arrColorVendor.push("#"+value.hex)
            arrColorClient.push("#"+value.hex)
            arrColorAsset.push("#"+value.hex)
            arrColorCategory.push("#"+value.hex)
          }
        })

        arrColorVendor    = arrColorVendor
        arrColorClient    = arrColorClient
        arrColorAsset     = arrColorAsset
        arrColorCategory  = arrColorCategory

      },
      async: false
    })

    function initGetDataChartVendor(argument) {
      $.ajax({
        url:"{{url('asset/getChartVendor')}}",
        type:"GET",
        data:{
          year:$("#selectYear").val(),
          assetOwner:$("#selectFilterAssetOwner").val(),
          client:$("#selectFilterClient").val(),
          category:$("#selectFilterCategory").val(),
          pid:$("#selectFilterPID").val(),
        },
        beforeSend:function(){
          $('.layout-container').block({
            message: '<div class=""spinner-border text-white"" role=""status""></div>',
            timeout: 1000,
            css: {
              backgroundColor: 'transparent',
              border: '0'
            },
            overlayCSS: {
              opacity: 0.5
            }
          });
        },
        success:function(response){
          InitiateChartVendor(arrColorVendor,response,"doughnutChartVendor")
        }
      })
    }
    
    function initGetDataChartCategory(argument) {
      $.ajax({
        url:"{{url('asset/getChartCategory')}}",
        type:"GET",
        data:{
          year:$("#selectYear").val(),
          assetOwner:$("#selectFilterAssetOwner").val(),
          client:$("#selectFilterClient").val(),
          category:$("#selectFilterCategory").val(),
          pid:$("#selectFilterPID").val(),
        },
        beforeSend:function(){
          $('.layout-container').block({
            message: '<div class=""spinner-border text-white"" role=""status""></div>',
            timeout: 1000,
            css: {
              backgroundColor: 'transparent',
              border: '0'
            },
            overlayCSS: {
              opacity: 0.5
            }
          });
        },
        success:function(response){
          if (response.length == 0) {
            InitiateChartCategory(arrColorCategory,[{label:"-",value:0}],"doughnutChartCategory")     
          }else{
            InitiateChartCategory(arrColorCategory,response,"doughnutChartCategory")     
          }
        }
      })
    }
    
    function initGetDataChartClient(argument) {
      $.ajax({
        url:"{{url('asset/getChartClient')}}",
        type:"GET",
        data:{
          year:$("#selectYear").val(),
          assetOwner:$("#selectFilterAssetOwner").val(),
          client:$("#selectFilterClient").val(),
          category:$("#selectFilterCategory").val(),
          pid:$("#selectFilterPID").val(),
        },
        beforeSend:function(){
          $('.layout-container').block({
            message: '<div class=""spinner-border text-white"" role=""status""></div>',
            timeout: 1000,
            css: {
              backgroundColor: 'transparent',
              border: '0'
            },
            overlayCSS: {
              opacity: 0.5
            }
          });
        },
        success:function(response){
          if (response.length == 0) {
            InitiateChartClient(arrColorClient,[{label:"-",value:0}],"doughnutChartClient")     
          }else{
            InitiateChartClient(arrColorClient,response,"doughnutChartClient")     
          }
        }
      })
    }
    
    function initGetDataChartAssetOwner(argument) {
      $.ajax({
        url:"{{url('asset/getChartAssetOwner')}}",
        type:"GET",
        data:{
          year:$("#selectYear").val(),
          assetOwner:$("#selectFilterAssetOwner").val(),
          client:$("#selectFilterClient").val(),
          category:$("#selectFilterCategory").val(),
          pid:$("#selectFilterPID").val(),
        },
        delay:200,
        beforeSend:function(){
          $('.layout-container').block({
            message: '<div class=""spinner-border text-white"" role=""status""></div>',
            timeout: 1000,
            css: {
              backgroundColor: 'transparent',
              border: '0'
            },
            overlayCSS: {
              opacity: 0.5
            }
          });
        },
        success:function(response){
          console.log(response.length)
          if (response.length == 0) {
            InitiateChartAssetOwner(arrColorAsset,[{label:"-",value:0}],"doughnutChartAssetOwner")     
          }else{
            InitiateChartAssetOwner(arrColorAsset,response,"doughnutChartAssetOwner")     
          }
        }
      })
    }

    let initiateVendorChart = ''
    function InitiateChartVendor(arrColor,result,nameChart){
      Chart.defaults.global.defaultFontFamily = 'Lucida Sans, sans-serif';

      if (initiateVendorChart) {
        initiateVendorChart.destroy()
      }
      // // Sort the data array by value in descending order
      const sortedData = [...result].sort((a, b) => b.value - a.value)

      // Get the top 5 data points
      const top5Data = sortedData.slice(0, 10);

      // Create a map of labels to their index in the sorted array
      const labelMap = top5Data.reduce((acc, data) => {
          acc[data.label] = true;
          return acc;
      }, {});

      // Prepare labels, only showing top 5
      const labels = result.map(data => labelMap[data.label] ? data.label + '_visible' : data.label + '_unvisible');

      // Prepare values for the chart
      const values = result.map(data => data.value);

      //prepare value countValue for the chart
      const countValue = result.map(data => data.countValue);

      let backgroundColor = ""

      if (result[0].label == '-') {
        backgroundColor = "#f2f2f2" 
      }else{
        backgroundColor = arrColorVendor.slice(0, result.length)
      }

      const dataVendor = { 
        labels: labels,
        datasets: [{
          data: values,
          backgroundColor:backgroundColor,
          hoverOffset: 4
        }]
      };

      var options = {
        legend: {
          position: 'right',
          display:true,
          labels:{
            generateLabels: function(chart) {
              var data = chart.data;
              const filteredData = data.labels.filter(data => data.split("_")[1] !== 'unvisible');

              console.log(countValue)

              return filteredData.map(function(label, i) {
                var meta = chart.getDatasetMeta(0);
                var ds = data.datasets[0];
                var arc = meta.data[i];
                var custom = arc && arc.custom || {};
                var getValueAtIndexOrDefault = Chart.helpers.getValueAtIndexOrDefault;
                var arcOpts = chart.options.elements.arc;
                var fill = custom.backgroundColor ? custom.backgroundColor : getValueAtIndexOrDefault(ds.backgroundColor, i, arcOpts.backgroundColor);
                var stroke = custom.borderColor ? custom.borderColor : getValueAtIndexOrDefault(ds.borderColor, i, arcOpts.borderColor);
                var bw = custom.borderWidth ? custom.borderWidth : getValueAtIndexOrDefault(ds.borderWidth, i, arcOpts.borderWidth);

                // We get the value of the current label
                var value = chart.config.data.datasets[arc._datasetIndex].data[arc._index];

                return {
                  // Instead of `text: label,`
                  // We add the value to the string
                  text: label.split("_")[0].split(" ")[0] + " : " + value + "%" + "(" + countValue[i] + ")",
                  fillStyle: fill,
                  strokeStyle: stroke,
                  lineWidth: bw,
                  hidden: isNaN(ds.data[i]) || meta.data[i].hidden,
                  index: i
                };
              });
                
            }
          },
          font: {
            size: 4,
            family: 'Arial'
          },
        },
        tooltips: {
          callbacks: {
            label: function(tooltipItem, data) {
                var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                var dataLabel = data.labels[tooltipItem.index];
                var value = tooltipItem.yLabel;
                return dataLabel.split("_")[0] + ' - ' + data['datasets'][0]['data'][tooltipItem['index']].toFixed(2) + '%';
            }
          }
        },
      };

      var nameChart = new Chart(chartVendor, {
        type:"doughnut",
        data: dataVendor,
        options: options
      })

      return initiateVendorChart = nameChart
    } 

    let initiateClientChart = ''
    function InitiateChartClient(arrColorClient,result,nameChart){
      Chart.defaults.global.defaultFontFamily = 'Lucida Sans, sans-serif';

      if (initiateClientChart) {
        initiateClientChart.destroy()
      }
      // // Sort the data array by value in descending order
      const sortedData = [...result].sort((a, b) => b.value - a.value)

      // Get the top 5 data points
      const top5Data = sortedData.slice(0, 10);

      // Create a map of labels to their index in the sorted array
      const labelMap = top5Data.reduce((acc, data) => {
          acc[data.label] = true;
          return acc;
      }, {});

      // Prepare labels, only showing top 5
      const labels = result.map(data => labelMap[data.label] ? data.label + '_visible' : data.label + '_unvisible');

      // Prepare values for the chart
      const values = result.map(data => data.value);

      //prepare value countValue for the chart
      const countValue = result.map(data => data.countValue);

      let backgroundColor = ""

      if (result[0].label == '-') {
        backgroundColor = "#f2f2f2" 
      }else{
        backgroundColor = arrColorClient.slice(0, result.length)
      }

      const dataClient = {
        labels: labels,
        datasets: [{
          data: values,
          backgroundColor:backgroundColor,
          hoverOffset: 4
        }]
      };

      var nameChart = new Chart(chartClient, {
        type:"doughnut",
        data: dataClient,
        options: {
          responsive: true,
          legend: {
            position:'right',
            display: true,
            labels: {
              generateLabels: function(chart) {
                var data = chart.data;

                const filteredData = data.labels.filter(data => data.split("_")[1] !== 'unvisible');

                return filteredData.map(function(label, i) {
                  var meta = chart.getDatasetMeta(0);
                  var ds = data.datasets[0];
                  var arc = meta.data[i];
                  var custom = arc && arc.custom || {};
                  var getValueAtIndexOrDefault = Chart.helpers.getValueAtIndexOrDefault;
                  var arcOpts = chart.options.elements.arc;
                  var fill = custom.backgroundColor ? custom.backgroundColor : getValueAtIndexOrDefault(ds.backgroundColor, i, arcOpts.backgroundColor);
                  var stroke = custom.borderColor ? custom.borderColor : getValueAtIndexOrDefault(ds.borderColor, i, arcOpts.borderColor);
                  var bw = custom.borderWidth ? custom.borderWidth : getValueAtIndexOrDefault(ds.borderWidth, i, arcOpts.borderWidth);

                  // We get the value of the current label
                  var value = chart.config.data.datasets[arc._datasetIndex].data[arc._index];

                  return {
                    // Instead of `text: label,`
                    // We add the value to the string
                    text: label.split("_")[0] + " : " + value + "%"+"("+countValue[i]+")",
                    fillStyle: fill,
                    strokeStyle: stroke,
                    lineWidth: bw,
                    hidden: isNaN(ds.data[i]) || meta.data[i].hidden,
                    index: i
                  };
                });
              }
            },
            font: {
              size: 4,
              family: 'Arial'
            },
          },
          tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                    var dataLabel = data.labels[tooltipItem.index];
                    var value = tooltipItem.yLabel;
                    return dataLabel.split("_")[0]  + ' - ' + data['datasets'][0]['data'][tooltipItem['index']].toFixed(2) + '%';
                }
            }
          },
        },
        centerText: {
          display: true,
          text: ""
        }
      })

      return initiateClientChart = nameChart
    }

    let initiateAssetOwnerChart = ''
    function InitiateChartAssetOwner(arrColorAsset,result,nameChart){
      Chart.defaults.global.defaultFontFamily = 'Lucida Sans, sans-serif';

      if (initiateAssetOwnerChart) {
        initiateAssetOwnerChart.destroy()
      }
      // // Sort the data array by value in descending order
      const sortedData = [...result].sort((a, b) => b.value - a.value)

      // Get the top 5 data points
      const top5Data = sortedData.slice(0, 10);

      // Create a map of labels to their index in the sorted array
      const labelMap = top5Data.reduce((acc, data) => {
          acc[data.label] = true;
          return acc;
      }, {});

      // Prepare labels, only showing top 5
      const labels = result.map(data => labelMap[data.label] ? data.label + '_visible' : data.label + '_unvisible');

      // Prepare values for the chart
      const values = result.map(data => data.value);

      //prepare countValue for the chart
      const countValue = result.map(data => data.countValue);

      let backgroundColor = ""

      if (result[0].label == '-') {
        backgroundColor = "#f2f2f2" 
      }else{
        backgroundColor = arrColorAsset.slice(0, result.length)
      }

      const dataAssetOwner = {
        labels: labels,
        datasets:[{
          data: values,
          backgroundColor:backgroundColor,
          hoverOffset: 4
        }] 
      };

      var nameChart = new Chart(chartAssetOwner, {
        type:"doughnut",
        data: dataAssetOwner,
        options: {
          responsive: true,
          legend: {
            position:'right',
            display: true,
            labels: {
              generateLabels: function(chart) {
                var data = chart.data;

                const filteredData = data.labels.filter(data => data.split("_")[1] !== 'unvisible');

                return filteredData.map(function(label, i) {
                  var meta = chart.getDatasetMeta(0);
                  var ds = data.datasets[0];
                  var arc = meta.data[i];
                  var custom = arc && arc.custom || {};
                  var getValueAtIndexOrDefault = Chart.helpers.getValueAtIndexOrDefault;
                  var arcOpts = chart.options.elements.arc;
                  var fill = custom.backgroundColor ? custom.backgroundColor : getValueAtIndexOrDefault(ds.backgroundColor, i, arcOpts.backgroundColor);
                  var stroke = custom.borderColor ? custom.borderColor : getValueAtIndexOrDefault(ds.borderColor, i, arcOpts.borderColor);
                  var bw = custom.borderWidth ? custom.borderWidth : getValueAtIndexOrDefault(ds.borderWidth, i, arcOpts.borderWidth);

                  // We get the value of the current label
                  var value = chart.config.data.datasets[arc._datasetIndex].data[arc._index];

                  return {
                    // Instead of `text: label,`
                    // We add the value to the string
                    text: label.split("_")[0] + " : " + value + "%" + "("+countValue[i]+")",
                    fillStyle: fill,
                    strokeStyle: stroke,
                    lineWidth: bw,
                    hidden: isNaN(ds.data[i]) || meta.data[i].hidden,
                    index: i
                  };
                });
              }
            },
            font: {
              size: 4,
              family: 'Arial'
            },
          },
          tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                    var dataLabel = data.labels[tooltipItem.index];
                    var value = tooltipItem.yLabel;
                    return dataLabel.split("_")[0]  + ' - ' + data['datasets'][0]['data'][tooltipItem['index']].toFixed(2) + '%';
                }
            }
          },
        },
        centerText: {
          display: true,
          text: ""
        }
      })

      return initiateAssetOwnerChart = nameChart
    }

    let initiateCategoryChart = ''
    function InitiateChartCategory(arrColorCategory,result,nameChart){
      Chart.defaults.global.defaultFontFamily = 'Lucida Sans, sans-serif';

      if (initiateCategoryChart) {
        initiateCategoryChart.destroy()
      }
      // // Sort the data array by value in descending order
      const sortedData = [...result].sort((a, b) => b.value - a.value)

      // Get the top 5 data points
      const top5Data = sortedData.slice(0, 10);

      // Create a map of labels to their index in the sorted array
      const labelMap = top5Data.reduce((acc, data) => {
          acc[data.label] = true;
          return acc;
      }, {});

      // Prepare labels, only showing top 5
      const labels = result.map(data => labelMap[data.label] ? data.label + '_visible' : data.label + '_unvisible');

      // Prepare values for the chart
      const values = result.map(data => data.value);

      //Prepare countValue for the chart
      const countValue = result.map(data => data.countValue);

      let backgroundColor = ""

      if (result[0].label == '-') {
        backgroundColor = "#f2f2f2" 
      }else{
        backgroundColor = arrColorCategory.slice(0, result.length)
      }

      const dataCategory = {
        labels: labels,
        datasets: [{
          data: values,
          backgroundColor:backgroundColor,
          hoverOffset: 4
        }]
      };

      var nameChart = new Chart(chartCategory, {
        type:"doughnut",
        data: dataCategory,
        options: {
          responsive: true,
          legend: {
            position:'right',
            display: true,
            labels: {
              generateLabels: function(chart) {
                var data = chart.data;

                const filteredData = data.labels.filter(data => data.split("_")[1] !== 'unvisible');

                return filteredData.map(function(label, i) {
                  var meta = chart.getDatasetMeta(0);
                  var ds = data.datasets[0];
                  var arc = meta.data[i];
                  var custom = arc && arc.custom || {};
                  var getValueAtIndexOrDefault = Chart.helpers.getValueAtIndexOrDefault;
                  var arcOpts = chart.options.elements.arc;
                  var fill = custom.backgroundColor ? custom.backgroundColor : getValueAtIndexOrDefault(ds.backgroundColor, i, arcOpts.backgroundColor);
                  var stroke = custom.borderColor ? custom.borderColor : getValueAtIndexOrDefault(ds.borderColor, i, arcOpts.borderColor);
                  var bw = custom.borderWidth ? custom.borderWidth : getValueAtIndexOrDefault(ds.borderWidth, i, arcOpts.borderWidth);

                  // We get the value of the current label
                  var value = chart.config.data.datasets[arc._datasetIndex].data[arc._index];

                  return {
                    // Instead of `text: label,`
                    // We add the value to the string
                    text: label.split("_")[0] + " : " + value + "%" + "(" + countValue[i] + ")",
                    fillStyle: fill,
                    strokeStyle: stroke,
                    lineWidth: bw,
                    hidden: isNaN(ds.data[i]) || meta.data[i].hidden,
                    index: i
                  };
                });
              }
            },
            font: {
              size: 4,
              family: 'Arial'
            },
          },
          tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                    var dataLabel = data.labels[tooltipItem.index];
                    var value = tooltipItem.yLabel;
                    return dataLabel.split("_")[0]  + ' - ' + data['datasets'][0]['data'][tooltipItem['index']].toFixed(2) + '%';
                }
            }
          },
        },
        centerText: {
          display: true,
          text: ""
        }
      })

      return initiateCategoryChart = nameChart
    }
    // $.ajax({
    //   type:"GET",
    //   url:"{{'/asset/getLog'}}",
    //   success:function(result){
    //     var append = ""

    //     $.each(result,function(item,value){
    //       append = append + '<li style="padding:10px">'
    //         append = append + '('+ value.date_add +') - '+ value.operator + ' ' + value.activity
    //       append = append + '</li>'
    //     })

    //     // $("#tb_LogActivity").append(append)
    //   }
    // })

    function initGetCountDashboard(year,assetOwner,category,client,pid) {
      $.ajax({
        url:"{{url('asset/getCountDashboard')}}?"+year+"&assetOwner="+ assetOwner +"&category="+ category + "&client="+ client +"&pid=" + pid,
        type:"GET",
        success:function(response){
          $("#countAll").text(response.countAll)
          if ($("#countAll").next().text() != "Total Assets") {
            // $("#countAll").after("<p>Total Assets</p>")
          }

          $("#countInstalled").text(response.countInstalled)
          if ($("#countInstalled").next().text() != "Installed") {
            // $("#countInstalled").after("<p>Installed</p>")
          }
          
          $("#countAvailable").text(response.countAvailable)
          if ($("#countAvailable").next().text() != "Available") {
            // $("#countAvailable").after("<p>Available</p>")
          }

          $("#countTemporary").text(response.countTemporary)
          if ($("#countTemporary").next().text() != "Temporary") {
            // $("#countTemporary").after("<p>Temporary</p>")
          }
          
          $('.counter').each(function () {
            var size = $(this).text().split(".")[1] ? $(this).text().split(".")[1].length : 0;
            $(this).prop('Counter', 0).animate({
              Counter: $(this).text()
            }, {
              duration: 1000,
              step: function (func) {
                 $(this).text(parseFloat(func).toFixed(size));
              }
            });
          });
        }
      })
    }
    
    //select2 filter
    initFilterAssetOwner()
    initFilterCategory()
    initFilterClient()
    initFilterPID()

    function initFilterAssetOwner(argument) {
      $("#selectFilterAssetOwner").empty("")

      $("#selectFilterAssetOwner").select2({
        ajax : {
          url: '{{url("asset/getAssetOwner")}}',
          processResults: function (data) {
            // Transforms the top-level key of the response object from 'items' to 'results'
            return {
              results: data
            };
          },
        },
        placeholder:"Select Asset Owner",
        allowClear:true
      })
    }
    
    function initFilterCategory(argument) {
      $("#selectFilterCategory").empty("")

      $("#selectFilterCategory").select2({
        ajax:{
          url: '{{url("asset/getCategory")}}',
          processResults: function (data) {
            // Transforms the top-level key of the response object from 'items' to 'results'
            return {
              results: data
            };
          },
        },
        placeholder:"Select Category",
        allowClear:true
      })
    }
    
    function initFilterClient(argument) {
      $("#selectFilterClient").empty("")

      $("#selectFilterClient").select2({
        ajax: {
          url: '{{url("asset/getClient")}}',
          processResults: function (data) {
            // Transforms the top-level key of the response object from 'items' to 'results'
            return {
              results: data
            };
          },
        },
        placeholder: 'Select Client',
        allowClear:true
      }).on("select2:select",function(e){
        $("#selectFilterPID").empty("")

        let client = e.params.data.id

        $("#selectFilterPID").select2({
          ajax: {
            url: '{{url("asset/getPidByClient")}}',
            data: function (params) {
              return {
                client:client,
              };
            },
            processResults: function (data) {
              // Transforms the top-level key of the response object from 'items' to 'results'
              return {
                results: data
              };
            },
          },
          placeholder: 'Select PID',
          allowClear:true
        })
      })
    }

    function initFilterPID(argument) {
      $("#selectFilterPID").empty("")

      $("#selectFilterPID").select2({
        ajax: {
          url: '{{url("asset/getPidForFilter")}}',
          processResults: function (data) {
            // Transforms the top-level key of the response object from 'items' to 'results'
            return {
              results: data
            };
          },
        },
        placeholder: 'Select PID',
        allowClear:true
      })
    }

    function initFilterYear(argument) {
      let currentYear = new Date().getFullYear();
      $("#selectYear").val(currentYear).trigger("change");
    }
    
    function filterAsset(argument) {
      let year = 'year[]=';
      let assetOwner = $("#selectFilterAssetOwner").val() ?? "";
      let category = $("#selectFilterCategory").val() ?? "";
      let client = $("#selectFilterClient").val() ?? "";
      let pid = $("#selectFilterPID").val() ?? "";

      $.each($("#selectYear").val(),function(key,value){
        if (year == 'year[]=') {
          year = year + value
        }else{
          year = year + '&year[]=' + value
        }

        if(value == ''){
          localStorage.removeItem("arrFilterBack")
        }
      })

      $('#tb_LogActivity').DataTable().ajax.url("{{url('asset/getLog')}}?"+year+"&assetOwner="+ assetOwner +"&category="+ category + "&client="+ client +"&pid=" + pid).load();

      initGetDataChartVendor()
      initGetDataChartCategory()
      initGetDataChartClient()
      initGetDataChartAssetOwner()
      initGetCountDashboard(year,assetOwner,category,client,pid)
    }

    function filterResetAsset(argument) {
      initFilterYear()
      initFilterAssetOwner()
      initFilterCategory()
      initFilterClient()
      initFilterPID()

      let year = new Date().getFullYear();
      let assetOwner = $("#selectFilterAssetOwner").val() ?? "";
      let category = $("#selectFilterCategory").val() ?? "";
      let client = $("#selectFilterClient").val() ?? "";
      let pid = $("#selectFilterPID").val() ?? "";
      
      $('#tb_LogActivity').DataTable().ajax.url("{{url('asset/getLog')}}?year[]="+year+"&assetOwner="+ assetOwner +"&category="+ category + "&client="+ client +"&pid=" + pid).load();

      initGetDataChartVendor()
      initGetDataChartCategory()
      initGetDataChartClient()
      initGetDataChartAssetOwner()
      initGetCountDashboard('year[]='+year,assetOwner,category,client,pid)
    }
  </script>
@endsection