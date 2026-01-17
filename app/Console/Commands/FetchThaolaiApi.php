<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class FetchThaolaiApi extends Command
{
    protected $signature = 'thaolai:api 
                            {--max-lat=14.330920808224132 : Maximum latitude}
                            {--min-lat=13.221229745578954 : Minimum latitude}
                            {--max-lon=102.37060546875001 : Maximum longitude}
                            {--min-lon=99.67895507812501 : Minimum longitude}
                            {--limit=300 : Limit of results}';

    protected $description = 'Fetch property data from Thaolai API and store JSON in storage folder';

    public function handle(): int
    {
        $maxLat = $this->option('max-lat');
        $minLat = $this->option('min-lat');
        $maxLon = $this->option('max-lon');
        $minLon = $this->option('min-lon');
        $limit = $this->option('limit');

        $url = "https://thaolai.com/service/api/v1/assets/data_map";
        $params = [
            'maxLat' => $maxLat,
            'minLat' => $minLat,
            'maxLon' => $maxLon,
            'minLon' => $minLon,
            'limit' => $limit,
        ];

        $this->info("🌐 Fetching data from Thaolai API...");
        $this->line("URL: {$url}");
        $this->line("Parameters: " . json_encode($params, JSON_PRETTY_PRINT));

        try {
            $response = Http::timeout(60)->get($url, $params);

            // Check if request was successful (status 200-299)
            if ($response->status() !== 200) {
                $this->error("❌ API request failed with status: " . $response->status());
                $this->error("Response: " . $response->body());
                return Command::FAILURE;
            }

            $data = $response->json();

            if (!$data) {
                $this->error("❌ Invalid JSON response from API");
                return Command::FAILURE;
            }

            $filename = "thaolai_api_.json";
            $storagePath = "api_data/{$filename}";

            // Save to storage/app/api_data/
            Storage::disk('public')->put($storagePath, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            $fullPath = Storage::disk('public')->path($storagePath);

            $this->info("✅ API data fetched successfully!");
            $this->line("📊 Status: " . ($data['status'] ?? 'unknown'));
            $this->line("📈 Count: " . ($data['data']['count'] ?? 0) . " properties");
            $this->line("💾 Saved to: {$fullPath}");

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error("❌ Error fetching API data: " . $e->getMessage());
            $this->error($e->getTraceAsString());
            return Command::FAILURE;
        }
    }
}
