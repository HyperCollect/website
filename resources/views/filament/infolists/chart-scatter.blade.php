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
const array_{{$id}} = [{{ $getState() }}];
let b = [];
// const xValues_{{$id}} = new Array(yValues_{{$id}}.length).fill(1).map( (_, i) => i+1 )
for(let i = 0; i < array_{{$id}}.length; i++){
    const a = array_{{$id}}[i];

    // convert object to array
    const k = Object.keys(a)//.map((key) => [Number(key), a[key]]);
    const v = Object.values(a)//.map((key) => [Number(key), a[key]]);

    b[i] = {
        label: "Node degree distribution - log log scale n°" + String(i),
        data: k.map((key, index) => {
            return {x: k[index], y: v[index]}
        }),
        borderColor: "black",
        borderWidth: 1,
    };
}


var chart_{{$id}} = new Chart("{{$id}}", {
  type: "scatter",
  data: {
    // labels: xValues_{{$id}},
    datasets: b,
  },
  options: {
    scales: {
        x: {
          title: {
              display: true,
              text: 'Node degree',
              font: {
                  size: 20
              }
          },
          ticks: {
            maxTicksLimit: 10,
          },
          type: 'logarithmic',
        },
        y: {
          title: {
              display: true,
              text: 'Frequency',
              font: {
                  size: 20
              }
          },
          type: 'logarithmic',
        },
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
    },
    animation: false,
  },
  responsive: true,
});
</script>
