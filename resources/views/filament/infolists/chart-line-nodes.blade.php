<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/hammerjs@2.0.8"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@2.0.1"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@php
$id = uniqid();
@endphp
<style>
.chartbutton{
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 5px 15px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  border-radius: 10px;
  display: inline-block;
  margin-left: auto;
  margin-right: auto;
}
.chartbutton:hover {
  background-color: #3e8e41; /* Green */
}
.blockCanvas{
  display: flex;
  flex-direction: column;
  align-items: center;
}

.mycanvas{
  width: 100%;
}

@media screen and (max-width: 650px) {
  .chartbutton {
    display: none;
  }
}
</style>

<div class="blockCanvas">
  <!-- <p id="title_{{$id}}" style="display:none;">Test title</p> -->
  <canvas id="{{$id}}" class="mycanvas"></canvas>
  <div id="buttons_{{$id}}">
    <!-- <button class="chartbutton" onclick="toggleChart{{$id}}()">Toggle Chart</button> -->
    <button class="chartbutton" onclick="resetZoom{{$id}}()">Reset Zoom</button>
    <button class="chartbutton" onclick="toggleZoom{{$id}}()">Toggle Zoom</button>
    <button class="chartbutton" onclick="downloadAsPng{{$id}}()">Download as PNG</button>
  </div>
</div>
<script>
// function toggleChart{{$id}}() {
//   var x = document.getElementById("{{$id}}");
//   var y = document.getElementById("title_{{$id}}");
//   if (x.style.display === "none") {
//     x.style.display = "block";
//     y.style.display = "none";
//   } else {
//     x.style.display = "none";
//     y.style.display = "block";
//     var chart = window.chart_{{$id}};
//     y.innerHTML = chart.data.datasets[0].label;
//   }
// }
function resetZoom{{$id}}() {
  var chart = window.chart_{{$id}};
  chart.resetZoom();
}
function toggleZoom{{$id}}() {
  var chart = window.chart_{{$id}};
  chart.options.plugins.zoom.zoom.wheel.enabled = !chart.options.plugins.zoom.zoom.wheel.enabled;
  chart.update();
  if (chart.options.plugins.zoom.zoom.wheel.enabled) {
    topRightAlert('Zoom enabled');
  } else {
    topRightAlert('Zoom disabled');
  }
  // topRightAlert('Zoom ' + zoomStatus(chart));
}
function downloadAsPng{{$id}}() {
  var imagelink = document.createElement('a');
  var canvas = document.getElementById("{{$id}}");
  imagelink.href = canvas.toDataURL("image/png");
  imagelink.download = "{{$id}}.png";
  imagelink.click();
}
const zoomOptions_{{$id}} = {
  // limits: {
  //   y: {min: 0, max: 200, minRange: 50}
  // },
  pan: {
    enabled: true,
    mode: 'xy',
  },
  zoom: {
    wheel: {
      enabled: true,
    },
    pinch: {
      enabled: true,
    },
    mode: 'xy',
  }
};
// const zoomStatus = (chart) => (zoomOptions_{{$id}}.zoom.wheel.enabled ? 'enabled' : 'disabled') + ' (' + chart.getZoomLevel() + 'x)';
</script>

<!-- COMMON TO EVERY CHART-->
<script>


function topRightAlert(title) {
  Swal.fire({
    position: "top-end",
    icon: "success",
    title: title,
    showConfirmButton: false,
    timer: 1000,
    toast: true,
  });
}

</script>


<script>
const yValues_{{$id}} = [{{ $getState() }}];
const xValues_{{$id}} = new Array(yValues_{{$id}}.length).fill(1).map( (_, i) => i+1 )

var chart_{{$id}} = new Chart("{{$id}}", {
  type: "line",
  data: {
    labels: xValues_{{$id}},
    datasets: [{
      label: 'Node degree distribution',
      data: yValues_{{$id}},
      spanGaps: true,
      pointRadius: 0,
      // showLine: false // disable for a single dataset
    }]
  },
  options: {
    scales: {
      y: {
          title: {
              display: true,
              text: 'Degree',
              font: {
                  size: 17
              }
          },
      },
      x: {
          title: {
              display: true,
              text: 'Number of nodes',
              font: {
                  size: 17
              }
          },
          ticks: {
            maxTicksLimit: 10,
          }
      }
    },
    plugins: {
        // Container for zoom options
        zoom: zoomOptions_{{$id}},
        title: {
          display: false,
          position: 'bottom',
          // text: (ctx) => 'Zoom: ' + zoomStatus(ctx.chart)
        },
        legend: {
            display: true,
            labels: {
              font: {
                size: 20
              }
            }
        },
        decimation: {
          enabled: true,
        }
    },
    animation: false,
  },
});
</script>