<?php

namespace App\Console\Commands;

use App\Models\Content;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ExportLangaugeContent extends Command
{
    protected $signature = 'export:language';

    protected $description = 'Export contents into language files';

    public function handle()
    {
        $basePath = base_path('lang');
        $languages = ['en', 'th', 'my', 'zh'];

        $contents = Content::all();

        foreach ($languages as $lang) {

            $langPath = $basePath.'/'.$lang;

            // Ensure language directory exists
            if (! File::exists($langPath)) {
                File::makeDirectory($langPath, 0755, true);
            }

            $data = [];

            foreach ($contents as $content) {
                if (! empty($content->{$lang})) {
                    $data[$content->key] = $content->{$lang};
                }
            }

            $fileContent = "<?php\n\nreturn ".var_export($data, true).";\n";

            File::put($langPath.'/guest.php', $fileContent);

            $this->info("Exported: lang/{$lang}/guest.php");
        }

        $this->info('Language export completed successfully.');
    }
}
