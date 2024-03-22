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
const a{{$id}} = [{{ $getState() }}];
const k{{$id}} = Object.keys(a{{$id}})//.map((key) => [Number(key), a[key]]);
const v{{$id}} = Object.values(a{{$id}})//.map((key) => [Number(key), a[key]]);
// normalization
// const max = Math.max(...v{{$id}});
// const min = Math.min(...v{{$id}});
// // const v2{{$id}} = v{{$id}}.map((x) => (x - min) / (max - min));
const total{{$id}} = v{{$id}}.reduce((a, b) => a + b, 0);
const v2{{$id}} = v{{$id}}.map((x) => x / total{{$id}});

const b{{$id}} = k{{$id}}.map((key, index) => {
    return {x: (parseInt(k{{$id}}[index])+1).toString(), y: v2{{$id}}[index]}
})

const footer_{{$id}} = (tooltipItems) => {
  return 'Original count: ' + v{{$id}}[tooltipItems[0].dataIndex];
};

var chart_{{$id}} = new Chart("{{$id}}", {
  type: "line",
  data: {
    // labels: xValues_{{$id}},
    datasets: [{
      label: 'Motifs size distribution',
      data: b{{$id}},
      spanGaps: true,
      // pointRadius: 4,
      pointHoverRadius: 6,
      backgroundColor: 'rgba(84, 130, 64, 1)',
      borderColor: 'rgba(84, 130, 64, 1)',
      borderDash: [5, 5],
    }]
  },
  options: {
    scales: {
      y: {
          title: {
              display: true,
              text: 'Size (normalized)',
              font: {
                  size: 20
              }
          },
      },
      x: {
          title: {
              display: true,
              text: 'Motif id',
              font: {
                  size: 20
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
        },
        tooltip: {
          callbacks: {
            footer: footer_{{$id}},
          }
      }
    },
    animation: false,
  },
  responsive: true,
});
</script>