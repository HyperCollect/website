<x-filament-panels::page>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
<script src="https://cdn.jsdelivr.net/npm/hammerjs@2.0.8"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@2.0.1"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@php
$id = uniqid();

    $names = $selectedRecords->pluck('name')->toArray();
    $dnodeshists = $selectedRecords->pluck('dnodeshist')->toArray();
    $dedgeshists = $selectedRecords->pluck('dedgeshist')->toArray();
@endphp
    <div class="container">
        <script>
            let names = @json($names);
            let dnodeshists =@json($dnodeshists);
            let dedgeshists = @json($dedgeshists);
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
              <!-- <p id="title_{{$id}}" style="display:none;">Test title</p> -->
              <canvas id="{{$id}}" class="mycanvas"></canvas>
              <div id="buttons_{{$id}}">
                <!-- <button class="chartbutton" onclick="toggleChart{{$id}}()">Toggle Chart</button> -->
                <button class="chartbutton" onclick="resetZoom{{$id}}()">Reset Zoom</button>
                <button class="chartbutton" onclick="toggleZoom{{$id}}()">Toggle Zoom</button>
                <button class="chartbutton" onclick="downloadAsPng{{$id}}()">Download as PNG</button>
              </div>
            </div>
            <script>
            // function toggleChart{{$id}}() {
            //   var x = document.getElementById("{{$id}}");
            //   var y = document.getElementById("title_{{$id}}");
            //   if (x.style.display === "none") {
            //     x.style.display = "block";
            //     y.style.display = "none";
            //   } else {
            //     x.style.display = "none";
            //     y.style.display = "block";
            //     var chart = window.chart_{{$id}};
            //     y.innerHTML = chart.data.datasets[0].label;
            //   }
            // }
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
            const yValues_{{$id}} = dnodeshists;
            let b{{$id}} = [];

            for(let i = 0; i < yValues_{{$id}}.length; i++){
                const a{{$id}} = yValues_{{$id}}[i];

                let clean_a{{$id}} = a{{$id}}.split('{').join('').split('}').join('');
                let objClean = clean_a{{$id}}.split(',').reduce((acc, pair)=>{
                    let [key, value] = pair.split(':').map(item => item.trim());
                    acc[key] = value;
                    return acc;
                }, {});

                //Convert objetct to array
                const k{{$id}} = Object.keys(objClean)//.map((key) => [Number(key), a[key]]);
                const v{{$id}} = Object.values(objClean)//.map((key) => [Number(key), a[key]]);

                //console.log('postelaboration: ', v{{$id}});

                b{{$id}}[i] = {
                    label: 'Node degree distribution ' + names[i],
                    data: k{{$id}}.map((key, index) => {
                            return {x: k{{$id}}[index], y: v{{$id}}[index]}
                        }),
                    spanGaps: true,
                    pointRadius: 0,
                };

            }
            // const xValues_{{$id}} = new Array(yValues_{{$id}}.length).fill(1).map( (_, i) => i+1 )

            // convert object to array
            var chart_{{$id}} = new Chart("{{$id}}", {
              type: "bar",
              data: {
                // labels: xValues_{{$id}},
                datasets: b{{$id}},
                // {
                //   label: 'Node degree distribution',
                //   data: b{{$id}},
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
            });
            </script>
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
            const array_{{$id}} = dnodeshists;
            let b = [];
            // const xValues_{{$id}} = new Array(yValues_{{$id}}.length).fill(1).map( (_, i) => i+1 )
            for(let i = 0; i < array_{{$id}}.length; i++){
                const a = array_{{$id}}[i];

                let clean_a{{$id}} = a.split('{').join('').split('}').join('');
                let objClean = clean_a{{$id}}.split(',').reduce((acc, pair)=>{
                    let [key, value] = pair.split(':').map(item => item.trim());
                    acc[key] = value;
                    return acc;
                }, {});
                // convert object to array
                const k = Object.keys(objClean)//.map((key) => [Number(key), a[key]]);
                const v = Object.values(objClean)//.map((key) => [Number(key), a[key]]);

                b[i] = {
                    label: "Node degree distribution - log log scale " + names[i],
                    data: k.map((key, index) => {
                        return {x: k[index], y: v[index]}
                    }),
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
            const yValues_{{$id}} = dedgeshists;
            let b{{$id}} = [];

            for(let i = 0; i < yValues_{{$id}}.length; i++){
                // const xValues_{{$id}} = new Array(yValues_{{$id}}.length).fill(1).map( (_, i) => i+1 )
                const a{{$id}} = yValues_{{$id}}[i];

                let clean_a{{$id}} = a{{$id}}.split('{').join('').split('}').join('');
                let objClean = clean_a{{$id}}.split(',').reduce((acc, pair)=>{
                    let [key, value] = pair.split(':').map(item => item.trim());
                    acc[key] = value;
                    return acc;
                }, {});

                // convert object to array
                const k{{$id}} = Object.keys(objClean);//.map((key) => [Number(key), a[key]]);
                const v{{$id}} = Object.values(objClean);//.map((key) => [Number(key), a[key]]);

                b{{$id}}[i] = {
                    label: 'Hedges size distribution ' + names[i],
                    data: k{{$id}}.map((key, index) => {
                        return {x: k{{$id}}[index], y: v{{$id}}[index]}
                    }),
                    spanGaps: true,
                    pointRadius: 0,
                }
            }

            var chart_{{$id}} = new Chart("{{$id}}", {
              type: "bar",
              data: {
                // labels: xValues_{{$id}},
                datasets: b{{$id}},
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


    </div>
</x-filament-panels::page>
