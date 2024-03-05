<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\MarkdownConverter;
use League\CommonMark\GithubFlavoredMarkdownConverter;

class FAQ extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.f-a-q';

    protected static ?int $navigationSort = 101;

    // setup the markdown parser
    public function __construct()
    {
        $config = [];

        $environment = new Environment($config);
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new GithubFlavoredMarkdownExtension());
        // $output = (new GithubFlavoredMarkdownConverter())->convert('~~This is strikethrough~~. This is not.')->getContent();
        $this->markdown = new GithubFlavoredMarkdownConverter([
            // 'html_input' => 'strip',
            // 'allow_unsafe_links' => false,
        ]);
        
        // echo $converter->convert('# Hello World!');
        // $this->markdown = new MarkdownConverter($environment);
        // $this->markdown = new GithubFlavoredMarkdownConverter($environment);
    }

    public function getMarkdown(): MarkdownConverter
    {
        return $this->markdown;
    }

    public function getMarkdownContent(): string
    {
        return $this->getMarkdown()->convert(
            
            '# Hello'
        );
    }

    // get the markdown content of the passed string
    public function getMarkdownContentFromString(string $content)
    {
        return $this->getMarkdown()->convertToHTML($content)->getContent();
    }

    public function getMarkdownContentFromFile(string $file)
    {
        return $this->getMarkdown()->convertToHTML(file_get_contents($file))->getContent();
    }
    
}
