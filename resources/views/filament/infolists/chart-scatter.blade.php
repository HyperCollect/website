<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/hammerjs@2.0.8"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@0.7.7"></script> -->
@php
$id = uniqid();
@endphp

<canvas id="{{$id}}" style="width:100%;max-width:700px"></canvas>

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
// Note: changes to the plugin code is not reflected to the chart, because the plugin is loaded at chart construction time and editor changes only trigger an chart.update().
// const plugin = {
//   id: 'customCanvasBackgroundColor',
//   beforeDraw: (chart, args, options) => {
//     const {ctx} = chart;
//     ctx.save();
//     ctx.globalCompositeOperation = 'destination-over';
//     ctx.fillStyle = options.color || '#99ffff';
//     ctx.fillRect(0, 0, chart.width, chart.height);
//     ctx.restore();
//   }
// };

new Chart("{{$id}}", {
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
    legend: {display: false},
    scales: {
        x: {
                display: false
            },
        yAxes: [{
            ticks: {
                beginAtZero: true
            },
            type: 'logarithmic',
            scaleLabel: {
                display: true,
                labelString: 'number of nodes',
                fontSize: 18,
            },
        }],
        xAxes: [{
            ticks: {
                beginAtZero: true,
                maxTicksLimit: 10              
            },
            type: 'logarithmic',
            scaleLabel: {
                display: true,
                labelString: 'Degree',
                fontSize: 18,
            },
        }]
    },
    plugins: {
      customCanvasBackgroundColor: {
        color: 'white',
      },
      zoom: {
        // Container for pan options
        pan: {
            enabled: true,
            mode: 'xy'
        },

        // Container for zoom options
        zoom: {
            // Boolean to enable zooming
            enabled: true,
            mode: 'xy',

        }
      }
    }
  },
  plugins: [plugin]
});
</script>