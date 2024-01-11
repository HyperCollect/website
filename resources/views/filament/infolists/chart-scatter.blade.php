@php
$id = uniqid();
@endphp
<canvas id="{{$id}}" style="width:80%;max-width:700px"></canvas>
<button class="chartbutton" onclick="window.nodedegreescatterchart.resetZoom()">Reset Zoom</button>

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

var nodedegreescatterchart = new Chart("{{$id}}", {
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
  },
});
</script>