<?php

namespace App\Console\Commands;

use App\Models\JupyterNotebook;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ImportJupyterFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:jupyter-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import existing Jupyter files into the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $path = '/app/notebooks';

        $files = File::files($path);
        $fileNamesInDirectory = [];

        foreach($files as $file){
            if($file->getExtension() === 'ipynb'){
                $fileNamesInDirectory[] = $file->getFilename();
                JupyterNotebook::firstOrCreate([
                    'name' => $file->getFilename(),
                    'path' => $file-> getPathname(),
                ]);
            }
        }
        JupyterNotebook::whereNotIn('name', $fileNamesInDirectory)->delete();
        $this->info('Jupyter files imported successfully.');
    }
}
