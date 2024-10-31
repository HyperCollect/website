<x-filament::page>
    <div id="iframe-div" style="width: 100%; height: 100vh; margin: 0; padding: 0; overflow: hidden;">
        <iframe id="jupyter-iframe" src="" frameborder="0" style="width: 100%; height: 100%; border: none;"></iframe>
    </div>

    {{$this->table}}
    <script>
        /*function updateIframe(url){
            console.log(url);

            //document.getElementById('jupyter-iframe')
        }*/

        document.addEventListener('click', function (event) {
            if (event.target.matches('[data-url]')) {
                event.preventDefault();
                const url = event.target.getAttribute('data-url');
                console.log("Updating iframe with URL:", url);
                document.getElementById('jupyter-iframe').src = url;
            }
        });
    </script>
</x-filament::page>
