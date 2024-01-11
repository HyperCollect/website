@php
$id = uniqid();
@endphp

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