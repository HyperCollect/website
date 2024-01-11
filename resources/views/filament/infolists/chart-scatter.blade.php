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
const array_{{$id}} = [{{ $getState() }}];
// const xValues_{{$id}} = new Array(yValues_{{$id}}.length).fill(1).map( (_, i) => i+1 )

const a = array_{{$id}}[0]

// convert object to array
const k = Object.keys(a)//.map((key) => [Number(key), a[key]]);
const v = Object.values(a)//.map((key) => [Number(key), a[key]]);

const b = k.map((key, index) => {
    return {x: k[index], y: v[index]}
})

var chart_{{$id}} = new Chart("{{$id}}", {
  type: "scatter",
  data: {
    // labels: xValues_{{$id}},
    datasets: [{
      data: b,
      // data: [
      //   {x: 1, y: 1}
      // ],
      borderColor: "black",
      // backgroundColor: '#9BD0F5',
      borderWidth: 1,
    }]
  },
  options: {
    scales: {
        x: {
          title: {
              display: true,
              text: 'Degree',
              font: {
                  size: 15
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
              text: 'Number of nodes',
              font: {
                  size: 15
              }
          },
          type: 'logarithmic',
        },
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
    },
    animation: false,
  },
  responsive: true,
});
</script>