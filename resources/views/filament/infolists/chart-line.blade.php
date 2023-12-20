<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
</script>
@php
$id = uniqid();
@endphp

<canvas id="{{$id}}" style="width:100%;max-width:700px"></canvas>

<script>
const yValues_{{$id}} = [{{ $getState() }}];
const xValues_{{$id}} = new Array(yValues_{{$id}}.length).fill(1).map( (_, i) => i+1 )

new Chart("{{$id}}", {
  type: "line",
  data: {
    labels: xValues_{{$id}},
    datasets: [{
      data: yValues_{{$id}},
      // borderColor: "white",
      backgroundColor: '#9BD0F5',
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
            ticks: {
                beginAtZero: true,
                maxTicksLimit: 10              
            }
        }]
    },
    responsive: true,
    
  }
});
</script>