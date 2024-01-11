@php
$id = uniqid();
@endphp

<canvas id="{{$id}}" style="width:80%;max-width:700px"></canvas>
<button class="chartbutton" onclick="window.edgesizechart.resetZoom()">Reset Zoom</button>

<script>
const yValues_{{$id}} = [{{ $getState() }}];
const xValues_{{$id}} = new Array(yValues_{{$id}}.length).fill(1).map( (_, i) => i+1 )

edgesizechart = new Chart("{{$id}}", {
  type: "line",
  data: {
    labels: xValues_{{$id}},
    datasets: [{
      data: yValues_{{$id}},
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
        }
    },
    animation: false,
  }
});
</script>