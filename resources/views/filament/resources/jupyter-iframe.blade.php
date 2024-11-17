<x-filament::page>
    <div id="iframe-div" style="display: none">
        <iframe id="jupyter-iframe" src=""></iframe>
    </div>

    {{$this->table}}
    <script>
        document.addEventListener('click', function (event) {
            const button = event.target.closest('[data-url]');
            if(button){
                event.preventDefault();
                const url = button.getAttribute('data-url');
                let iframe = document.getElementById('jupyter-iframe');
                let iframe_div = document.getElementById('iframe-div');

                iframe_div.style.width = "100%";
                iframe_div.style.height = "100vh";
                iframe_div.style.margin = "0";
                iframe_div.style.padding = "0";
                iframe_div.style.overflow = "hidden";
                iframe_div.style.display = "block";

                iframe.src = url;
                iframe.frameborder = "0";
                iframe.style.width = "100%";
                iframe.style.height = "100%";
                iframe.style.border = "none";
            }
        });
    </script>
</x-filament::page>
