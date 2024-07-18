@php
$id1 = uniqid();
$id2 = uniqid();
$id3 = uniqid();
@endphp
<x-filament-panels::page>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
<script src="https://cdn.jsdelivr.net/npm/hammerjs@2.0.8"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@2.0.1"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <div class="container">
        <h1>Selected Records</h1>
        <script>
            @dump($selectedRecords)
            let names = [
                @foreach($selectedRecords as $record)
                    "{{ $record->name }}",
                @endforeach
            ];
            let dnodeshists = [
            @foreach($selectedRecords as $record)
                {{ $record->dnodeshist }},
            @endforeach
        ];
        let dedgeshists = [
            @foreach($selectedRecords as $record)
                {{ $record->dedgeshist }},
            @endforeach
        ];
        //console.log(dedgeshists);
        </script>
        <style>
            .chartbutton{
              background-color: #4CAF50; /* Green */
              border: none;
              color: white;
              padding: 5px 15px;
              text-align: center;
              text-decoration: none;
              display: inline-block;
              font-size: 16px;
              border-radius: 10px;
              display: inline-block;
              margin-left: auto;
              margin-right: auto;
            }
            .chartbutton:hover {
              background-color: #3e8e41; /* Green */
            }
            .blockCanvas{
              display: flex;
              flex-direction: column;
              align-items: center;
            }

            .mycanvas{
              width: 100%;
            }

            @media screen and (max-width: 650px) {
              .chartbutton {
                display: none;
              }
            }
            </style>

            <div class="blockCanvas">
              <!-- <p id="title_{{$id1}}" style="display:none;">Test title</p> -->
              <canvas id="{{$id1}}" class="mycanvas"></canvas>
              <div id="buttons_{{$id1}}">
                <!-- <button class="chartbutton" onclick="toggleChart{{$id1}}()">Toggle Chart</button> -->
                <button class="chartbutton" onclick="resetZoom{{$id1}}()">Reset Zoom</button>
                <button class="chartbutton" onclick="toggleZoom{{$id1}}()">Toggle Zoom</button>
                <button class="chartbutton" onclick="downloadAsPng{{$id1}}()">Download as PNG</button>
              </div>
            </div>
            <script>
            // function toggleChart{{$id1}}() {
            //   var x = document.getElementById("{{$id1}}");
            //   var y = document.getElementById("title_{{$id1}}");
            //   if (x.style.display === "none") {
            //     x.style.display = "block";
            //     y.style.display = "none";
            //   } else {
            //     x.style.display = "none";
            //     y.style.display = "block";
            //     var chart = window.chart_{{$id1}};
            //     y.innerHTML = chart.data.datasets[0].label;
            //   }
            // }
            function resetZoom{{$id1}}() {
              var chart = window.chart_{{$id1}};
              chart.resetZoom();
            }
            function toggleZoom{{$id1}}() {
              var chart = window.chart_{{$id1}};
              chart.options.plugins.zoom.zoom.wheel.enabled = !chart.options.plugins.zoom.zoom.wheel.enabled;
              chart.update();
              if (chart.options.plugins.zoom.zoom.wheel.enabled) {
                topRightAlert('Zoom enabled');
              } else {
                topRightAlert('Zoom disabled');
              }
              // topRightAlert('Zoom ' + zoomStatus(chart));
            }
            function downloadAsPng{{$id1}}() {
              var imagelink = document.createElement('a');
              var canvas = document.getElementById("{{$id1}}");
              imagelink.href = canvas.toDataURL("image/png");
              imagelink.download = "{{$id1}}.png";
              imagelink.click();
            }
            const zoomOptions_{{$id1}} = {
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
            // const zoomStatus = (chart) => (zoomOptions_{{$id1}}.zoom.wheel.enabled ? 'enabled' : 'disabled') + ' (' + chart.getZoomLevel() + 'x)';
            </script>

            <!-- COMMON TO EVERY CHART-->
            <script>


            function topRightAlert(title) {
              Swal.fire({
                position: "top-end",
                icon: "success",
                title: title,
                showConfirmButton: false,
                timer: 1000,
                toast: true,
              });
            }

            </script>


            <script>
            const yValues_{{$id1}} = dnodeshists;
            let b{{$id1}} = [];

            for(let i = 0; i < yValues_{{$id1}}.length; i++){
                const a{{$id1}} = yValues_{{$id1}}[i];

                //Convert objetct to array
                const k{{$id1}} = Object.keys(a{{$id1}})//.map((key) => [Number(key), a[key]]);
                const v{{$id1}} = Object.values(a{{$id1}})//.map((key) => [Number(key), a[key]]);

                b{{$id1}}[i] = {
                    label: 'Node degree distribution ' + names[i],
                    data: k{{$id1}}.map((key, index) => {
                            return {x: k{{$id1}}[index], y: v{{$id1}}[index]}
                        }),
                    spanGaps: true,
                    pointRadius: 0,
                };
            }
            // const xValues_{{$id1}} = new Array(yValues_{{$id1}}.length).fill(1).map( (_, i) => i+1 )

            // convert object to array
            var chart_{{$id1}} = new Chart("{{$id1}}", {
              type: "bar",
              data: {
                // labels: xValues_{{$id1}},
                datasets: b{{$id1}},
                // {
                //   label: 'Node degree distribution',
                //   data: b{{$id1}},
                //   spanGaps: true,
                //   pointRadius: 0,
                //   type: 'line',
                // },
              },
              options: {
                scales: {
                  y: {
                      title: {
                          display: true,
                          text: 'Count',
                          font: {
                              size: 20
                          }
                      },
                  },
                  x: {
                      title: {
                          display: true,
                          text: 'Node degree',
                          font: {
                              size: 20
                          }
                      },
                      ticks: {
                        maxTicksLimit: 20,
                      },
                  }
                },
                plugins: {
                    // Container for zoom options
                    zoom: zoomOptions_{{$id1}},
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
            });
            </script>
            <div class="blockCanvas">
              <canvas id="{{$id2}}" class="mycanvas"></canvas>
              <div id="buttons_{{$id2}}">
                <button class="chartbutton" onclick="resetZoom{{$id2}}()">Reset Zoom</button>
                <button class="chartbutton" onclick="toggleZoom{{$id2}}()">Toggle Zoom</button>
                <button class="chartbutton" onclick="downloadAsPng{{$id2}}()">Download as PNG</button>
              </div>
            </div>

            <script>
            function resetZoom{{$id2}}() {
              var chart = window.chart_{{$id2}};
              chart.resetZoom();
            }
            function toggleZoom{{$id2}}() {
              var chart = window.chart_{{$id2}};
              chart.options.plugins.zoom.zoom.wheel.enabled = !chart.options.plugins.zoom.zoom.wheel.enabled;
              chart.update();
              if (chart.options.plugins.zoom.zoom.wheel.enabled) {
                topRightAlert('Zoom enabled');
              } else {
                topRightAlert('Zoom disabled');
              }
              // topRightAlert('Zoom ' + zoomStatus(chart));
            }
            function downloadAsPng{{$id2}}() {
              var imagelink = document.createElement('a');
              var canvas = document.getElementById("{{$id2}}");
              imagelink.href = canvas.toDataURL("image/png");
              imagelink.download = "{{$id2}}.png";
              imagelink.click();
            }
            const zoomOptions_{{$id2}} = {
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
            // const zoomStatus = (chart) => (zoomOptions_{{$id2}}.zoom.wheel.enabled ? 'enabled' : 'disabled') + ' (' + chart.getZoomLevel() + 'x)';
            </script>
            <script>
            const array_{{$id2}} = dnodeshists;
            let b = [];
            // const xValues_{{$id2}} = new Array(yValues_{{$id2}}.length).fill(1).map( (_, i) => i+1 )
            for(let i = 0; i < array_{{$id2}}.length; i++){
                const a = array_{{$id2}}[i];

                // convert object to array
                const k = Object.keys(a)//.map((key) => [Number(key), a[key]]);
                const v = Object.values(a)//.map((key) => [Number(key), a[key]]);

                b[i] = {
                    label: "Node degree distribution - log log scale " + names[i],
                    data: k.map((key, index) => {
                        return {x: k[index], y: v[index]}
                    }),
                    borderWidth: 1,
                };
            }


            var chart_{{$id2}} = new Chart("{{$id2}}", {
              type: "scatter",
              data: {
                // labels: xValues_{{$id2}},
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
                    zoom: zoomOptions_{{$id2}},
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
            <div class="blockCanvas">
              <canvas id="{{$id3}}" class="mycanvas"></canvas>
              <div id="buttons_{{$id3}}">
                <button class="chartbutton" onclick="resetZoom{{$id3}}()">Reset Zoom</button>
                <button class="chartbutton" onclick="toggleZoom{{$id3}}()">Toggle Zoom</button>
                <button class="chartbutton" onclick="downloadAsPng{{$id3}}()">Download as PNG</button>
              </div>
            </div>
            <script>
            function resetZoom{{$id3}}() {
              var chart = window.chart_{{$id3}};
              chart.resetZoom();
            }
            function toggleZoom{{$id3}}() {
              var chart = window.chart_{{$id3}};
              chart.options.plugins.zoom.zoom.wheel.enabled = !chart.options.plugins.zoom.zoom.wheel.enabled;
              chart.update();
              if (chart.options.plugins.zoom.zoom.wheel.enabled) {
                topRightAlert('Zoom enabled');
              } else {
                topRightAlert('Zoom disabled');
              }
              // topRightAlert('Zoom ' + zoomStatus(chart));
            }
            function downloadAsPng{{$id3}}() {
              var imagelink = document.createElement('a');
              var canvas = document.getElementById("{{$id3}}");
              imagelink.href = canvas.toDataURL("image/png");
              imagelink.download = "{{$id3}}.png";
              imagelink.click();
            }
            const zoomOptions_{{$id3}} = {
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
            // const zoomStatus = (chart) => (zoomOptions_{{$id3}}.zoom.wheel.enabled ? 'enabled' : 'disabled') + ' (' + chart.getZoomLevel() + 'x)';
            </script>
            <script>
            const yValues_{{$id3}} = dedgeshists;
            let b{{$id3}} = [];

            for(let i = 0; i < yValues_{{$id3}}.length; i++){
                // const xValues_{{$id3}} = new Array(yValues_{{$id3}}.length).fill(1).map( (_, i) => i+1 )
                const a{{$id3}} = yValues_{{$id3}}[i];

                // convert object to array
                const k{{$id3}} = Object.keys(a{{$id3}});//.map((key) => [Number(key), a[key]]);
                const v{{$id3}} = Object.values(a{{$id3}});//.map((key) => [Number(key), a[key]]);

                b{{$id3}}[i] = {
                    label: 'Hedges size distribution ' + names[i],
                    data: k{{$id3}}.map((key, index) => {
                        return {x: k{{$id3}}[index], y: v{{$id3}}[index]}
                    }),
                    spanGaps: true,
                    pointRadius: 0,
                }
            }

            var chart_{{$id3}} = new Chart("{{$id3}}", {
              type: "bar",
              data: {
                // labels: xValues_{{$id3}},
                datasets: b{{$id3}},
              },
              options: {
                scales: {
                  y: {
                      title: {
                          display: true,
                          text: 'Count',
                          font: {
                              size: 20
                          }
                      },
                  },
                  x: {
                      title: {
                          display: true,
                          text: 'Size of hyperedges',
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
                    zoom: zoomOptions_{{$id3}},
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

    </div>
</x-filament-panels::page>
