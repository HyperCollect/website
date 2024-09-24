<x-filament-panels::page>

<!-- <?php
    $markdown = app(\App\Filament\Pages\FAQ::class)->getMarkdownContentFromString(
        "# Work in progress\n\nThis page is still **under construction**. Please check back later.");
    echo $markdown;
?> -->
<!-- <x-markdown>
# xmarkdown
## xmarkdown
**xmarkdown**
</x-markdown> -->

<!-- @markdown
# markdown
## markdown
**markdown**
@endmarkdown -->
<style>
.logo {
    font-size: 1.5rem;
    font-weight: bold;
    color: #40b736;
}
 
.nav-links {
    list-style: none;
    display: flex;
}
 
.nav-links li {
    margin-right: 20px;
}
 
.nav-links a {
    color: rgb(0, 0, 0);
    padding: 10px;
    font-weight: bold;
    text-decoration: none;
}
 
.nav-links a:hover {
    background-color:  #ff7c4d;
    border-radius: 4px;
    color: white;
}
 
/* About Section */
 
.about {
    background: rgb(224, 251, 222);
    background: linear-gradient(360deg, rgb(245, 255, 245) 0%, rgb(255, 124, 77) 100%); 

    padding: 100px 0 20px 0;
    text-align: center;
}
 
.about h1 {
    font-size: 2.5rem;
    margin-bottom: 20px;
}
 
.about p {
    font-size: 1rem;
    color: #323030;
    max-width: 800px;
    margin: 0 auto;
}
 
.about-info {
    margin: 2rem 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: left;
}
 
.about-img {
    width: 20rem;
    height: 20rem;
 
}
 
.about-img img {
    width: 100%;
    height: 100%;
    border-radius: 5px;
    object-fit: contain;
}
 
.about-info p {
    font-size: 1.3rem;
    margin: 0 2rem;
    text-align: justify;
}

.button {
  border: none;
  outline: 0;
  padding: 8px;
  background-color: #ffa280;
  text-align: center;
  cursor: pointer;
  width: 15rem;
  border-radius: 15px;
  border: 1px solid #222224;
  margin-bottom: 5px;
  font-size: 1rem;
}
 
button:hover {
    background-color: #ff7c4d;
}
 
/* Team Section */
 
.team {
    padding: 30px 0;
    text-align: center;
}
 
.team h1 {
    font-size: 2.5rem;
    margin-bottom: 20px;
}
 
.team-cards {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 15px;
    margin-top: 20px;
}
 
.card {
    background-color: white;
    border-radius: 6px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.5);
    overflow: hidden;
    transition: transform 0.2s, box-shadow 0.2s;
    width: 18rem;
    height: 25rem;
    margin-top: 10px;
}
 
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 12px rgba(0, 0, 0, 0.5);
}
 
.card-img {
    width: 18rem;
    height: 12rem;
}
 
.card-img img {
    width: 100%;
    height: 100%;
    object-fit: fill;
}
 
.card-info button {
    margin: 2rem 1rem;
}
 
.card-name {
    font-size: 2rem;
    margin: 10px 0;
}
 
.card-role {
    font-size: 1rem;
    color: #888;
    margin: 5px 0;
}
 
.card-email {
    font-size: 1rem;
    color: #555;
}
</style>

<section class="about">
    <h1>HypergraphRepository</h1>
    <p style="font-weight: bold">
        An awesome hypergraph repository
        </p>
    <p>HypergraphRepository is a web application that allows users to see benchmark about hypergraphs.</p>
    <p>Work in progress..</p>

    <div>
    
    <button class="button" onclick="goTo()" target="_blank">Cite us!</button>
    </div>
    <!-- <div id="content"></div>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script>
    document.getElementById('content').innerHTML =
        marked.parse('# Marked in the browser\n\nRendered by **marked**.\n\n## hello\n');
    </script> -->
</section>

<script>
    var goTo = () => {
        window.location.href = "https://link.springer.com/chapter/10.1007/978-3-031-59205-8_11#citeas";
    }
</script>

</x-filament-panels::page>