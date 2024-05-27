<x-filament-panels::page>

<?php
    $markdown = app(\App\Filament\Pages\FAQ::class)->getMarkdownContentFromString(
        "# Work in progress\n\nThis page is still **under construction**. Please check back later.");
    echo $markdown;
?>
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

</x-filament-panels::page>