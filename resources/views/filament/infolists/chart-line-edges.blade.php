@php
$id = uniqid();
@endphp

<div class="blockCanvas">
  <canvas id="{{$id}}" class="mycanvas"></canvas>
  <div id="buttons_{{$id}}">
    <button class="chartbutton" onclick="resetZoom{{$id}}()">Reset Zoom</button>
    <button class="chartbutton" onclick="toggleZoom{{$id}}()">Toggle Zoom</button>
    <button class="chartbutton" onclick="downloadAsPng{{$id}}()">Download as PNG</button>
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
<script>
const yValues_{{$id}} = [{{ $getState() }}];
const xValues_{{$id}} = new Array(yValues_{{$id}}.length).fill(1).map( (_, i) => i+1 )

var chart_{{$id}} = new Chart("{{$id}}", {
  type: "line",
  data: {
    labels: xValues_{{$id}},
    datasets: [{
      label: 'Hedges size distribution',
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
              text: 'Size',
              font: {
                  size: 17
              }
          },
      },
      x: {
          title: {
              display: true,
              text: 'Number of hyperedges',
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
  responsive: true,
});
</script>