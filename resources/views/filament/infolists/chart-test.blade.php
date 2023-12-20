<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
</script>
@php
$id = uniqid();
@endphp

<canvas id="{{$id}}" style="width:100%;max-width:700px"></canvas>

<script>
const yValues_{{$id}} = [{{ $getState() }}];
const xValues_{{$id}} = new Array(yValues_{{$id}}.length).fill(1).map( (_, i) => i+1 )

// Note: changes to the plugin code is not reflected to the chart, because the plugin is loaded at chart construction time and editor changes only trigger an chart.update().
const plugin = {
  id: 'customCanvasBackgroundColor',
  beforeDraw: (chart, args, options) => {
    const {ctx} = chart;
    ctx.save();
    ctx.globalCompositeOperation = 'destination-over';
    ctx.fillStyle = options.color || '#99ffff';
    ctx.fillRect(0, 0, chart.width, chart.height);
    ctx.restore();
  }
};

new Chart("{{$id}}", {
  type: "line",
  data: {
    labels: xValues_{{$id}},
    datasets: [{
      data: yValues_{{$id}},
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
            }
        }],
        xAxes: [{
            display: false
        }]
    },
    plugins: {
      customCanvasBackgroundColor: {
        color: 'white',
      }
    }
  },
  plugins: [plugin]
});
</script>