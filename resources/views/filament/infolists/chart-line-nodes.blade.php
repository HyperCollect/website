<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/hammerjs@2.0.8"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@0.7.7"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/hammerjs@2.0.8"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@2.0.1"></script>
@php
$id = uniqid();
@endphp
<style>
.chartbutton{
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 10px 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  border-radius: 10px;
}
</style>
<canvas id="{{$id}}" style="width:80%;max-width:700px"></canvas>
<button class="chartbutton" onclick="window.nodedegreechart.resetZoom()">Reset Zoom</button>

<script>
const yValues_{{$id}} = [{{ $getState() }}];
const xValues_{{$id}} = new Array(yValues_{{$id}}.length).fill(1).map( (_, i) => i+1 )

var nodedegreechart = new Chart("{{$id}}", {
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
        zoom: {
          zoom: {
            wheel: {
                enabled: true,
            },
            pinch: {
                enabled: true
            },
            mode: 'xy',
          }
        },
        legend: {
            display: false
        },
        decimation: {
          enabled: true,
          // algorithm: 'min',
          // samples: 100,
          // threshold: 2000
        }
    },
    animation: false,
  }
    // responsive: true,
});
</script>