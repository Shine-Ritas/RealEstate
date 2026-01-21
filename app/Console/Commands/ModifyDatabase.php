<?php

namespace App\Console\Commands;

use App\Models\Property;
use Illuminate\Console\Command;

class ModifyDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'modify:db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $prefix = config('control.property_prefix');
        $properties = Property::all();
        $start = 1;
        foreach ($properties as $property) {
            $property->property_code = $prefix . str_pad($start, 7, '0', STR_PAD_LEFT);
            $start++;
            $property->save();
            $this->info("Property code: " . $property->property_code);
        }
    }
}
