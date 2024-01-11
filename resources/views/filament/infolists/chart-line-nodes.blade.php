<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/hammerjs@2.0.8"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@0.7.7"></script> -->
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
  /* margin-left: auto;
  margin-right: auto;  */
}
.chartbutton:hover {
  background-color: #3e8e41; /* Green */
}
.block{
  display: flex;
  flex-direction: column;
  align-items: center;
}
</style>

<div class="block">
  <canvas id="{{$id}}" style="width:80%;max-width:700px"></canvas>
  <div id="buttons_{{$id}}">
    <button class="chartbutton" onclick="resetZoom{{$id}}()">Reset Zoom</button>
    <button class="chartbutton" onclick="toggleZoom{{$id}}()">Toggle Zoom</button>
  </div>
</div>
<script>
function resetZoom{{$id}}() {
  var chart = window.chart_{{$id}};
  chart.resetZoom();
}
function toggleZoom{{$id}}() {
  var chart = window.chart_{{$id}};
  chart.options.plugins.zoom.zoom.wheel.enabled = !chart.options.plugins.zoom.zoom.wheel.enabled;
  chart.update();
  topRightAlert('Zoom ' + zoomStatus(chart));
}
</script>

<!-- COMMON TO EVERY CHART-->
<script>
const zoomOptions = {
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
const zoomStatus = (chart) => (zoomOptions.zoom.wheel.enabled ? 'enabled' : 'disabled') + ' (' + chart.getZoomLevel() + 'x)';

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
      data: yValues_{{$id}},
      spanGaps: true,
      pointRadius: 0,
    }]
  },
  options: {
    scales: {
      y: {
          title: {
              display: true,
              text: 'Degree',
              font: {
                  size: 15
              }
          },
      },
      x: {
          title: {
              display: true,
              text: 'Number of nodes',
              font: {
                  size: 15
              }
          },
          ticks: {
            maxTicksLimit: 10,
          }
      }
    },
    plugins: {
        // Container for zoom options
        zoom: zoomOptions,
        title: {
          display: false,
          position: 'bottom',
          text: (ctx) => 'Zoom: ' + zoomStatus(ctx.chart)
        },
        legend: {
            display: false
        },
        decimation: {
          enabled: true,
        }
    },
    animation: false,
  },
  responsive: true,
});
</script>