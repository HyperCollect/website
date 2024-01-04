<x-filament-panels::page>
<style>
.mylink {
  color: green;
  background-color: transparent;
  text-decoration: none;
}
.tablecontainer {
        /* background-color: #18181b; */
        border-radius: 15px;
        padding: 20px;
        border: 1px solid #222224;
}

html {
  box-sizing: border-box;
}

*, *:before, *:after {
  box-sizing: inherit;
}

.column {
  float: left;
  width: 33.3%;
  margin-bottom: 16px;
  padding: 0 8px;
}

.about-section {
  padding: 20px;
  text-align: center;
  /* background-color: #474e5d; */
  /* color: white; */
  border: 1px solid #222224;
  border-radius: 15px;
  margin: 8px;
}
.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  margin: 8px;
  border: 1px solid #222224;
  border-radius: 15px;
}

.container {
  padding: 0 16px;
  text-align: center;
}

.container::after, .row::after {
  content: "";
  clear: both;
  display: table;
}

.title {
  color: grey;
}

.button {
  border: none;
  outline: 0;
  display: inline-block;
  padding: 8px;
  /* color: white; */
  background-color: #2b9d0475;
  text-align: center;
  cursor: pointer;
  width: 100%;
  border-radius: 15px;
  border: 1px solid #222224;
  margin-bottom: 5px;
}

.button:hover {
  background-color: #555;
}

.avatar {
  width: 75%;
  border-radius: 50%;
  margin: auto;
  /* width: 100%; */
}

.loghi {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-left: auto;
    margin-right: auto;
    width: 33.3%;
    margin-bottom: 16px;
    padding: 0 8px;

    /* margin-bottom: 20px; */
}
@media screen and (max-width: 650px) {
  .column {
    width: 100%;
    display: block;
  }
  .loghi {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-left: auto;
    margin-right: auto;
    margin-bottom: 16px;
    padding: 0 8px;
  }
}
</style>

<div class="tablecontainer">
    <div class="about-section">
        <div class="row loghi">
                <img src="assets/imgs/logoISIS.png" style="width:50%">
                <img src="assets/imgs/logoUnisa.png" style="width:50%">
        </div>
        <div class="row loghi">
            <img src="assets/imgs/logoInformatica.png" style="width:75%">
        </div>
        <p>Hypergraph Repository is a web application that allows users to upload and share hypergraphs.</p>
        <p>It is developed and maintained by <a href="https://www.isislab.it/" target="_blank" class="mylink">ISISLab</a> at the University of Salerno.</p>
        <p><a href="https://github.com/HypergraphRepository/datasets" target="_blank" class="mylink">Check our dataset repository</a></p>
    </div>

    <h2 style="text-align:center">Our Team</h2>
    <div class="row">
        <div class="column">
            <div class="card">
            <img src="assets/imgs/ddevin.png" class="avatar" >
            <div class="container">
                <h2>Daniele De Vinco</h2>
                <p class="title">2°year Ph.D.</p>
                <p>@ Università di Salerno · Italy</p>
                <p>ddevinco@unisa.it</p>
                <p><button class="button" onclick="location.href='mailto:ddevinco@unisa.it';">Contact</button></p>
                <button class="button"><a href="https://ddevin96.github.io/ddevin/" target="_blank">Personal Page</a></button>
            </div>
            </div>
        </div>

        <div class="column">
            <div class="card">
            <img src="assets/imgs/alessant.png" class="avatar">
            <div class="container">
                <h2>Alessia Antelmi</h2>
                <p class="title">Researcher (RTD-A)</p>
                <p>@ Università di Torino · Italy</p>
                <p>alessia.antelmi@unito.it</p>
                <p><button class="button" onclick="location.href='mailto:alessia.antelmi@unito.it';">Contact</button></p>
                <button class="button"><a href="https://alessant.github.io/" target="_blank">Personal Page</button></p>
            </div>
            </div>
        </div>

        <div class="column">
            <div class="card">
            <img src="assets/imgs/cspagn.png" class="avatar">
            <div class="container">
                <h2>Carmine Spagnuolo</h2>
                <p class="title">Researcher (RTD-B)</p>
                <p>@ Università di Salerno · Italy</p>
                <p>cspagnuolo@unisa.it</p>
                <p><button class="button" onclick="location.href='mailto:cspagnuolo@unisa.it';">Contact</button></p>
                <button class="button"><a href="https://spagnuolocarmine.github.io/" target="_blank">Personal Page</button></p>
            </div>
            </div>
        </div>
    </div>
</div>

</x-filament-panels::page>
