<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use ZipArchive;

class BackupProperties extends Command
{
    protected $signature = 'app:backup-properties';

    protected $description = 'Backup property tables into single SQL and zip storage public';

    public function handle()
    {
        $date = now()->format('Y-m-d_H-i-s');
        $backupDir = storage_path('app/backups');

        File::ensureDirectoryExists($backupDir);

        // 1️⃣ Backup tables into ONE SQL file
        $this->backupDatabase($backupDir, $date);

        // 2️⃣ Backup storage/public separately
        $this->backupStoragePublic($backupDir, $date);

        $this->info('Backup completed successfully ✅');
    }

    /**
     * Backup all property tables into a single SQL file
     */
    protected function backupDatabase(string $backupDir, string $date)
    {
        $tables = [
            'properties',
            'property_contacts',
            'property_details',
            'property_images',
            'social_links',
            'property_location_elements',
            'property_facilities',
        ];

        $sql = "-- Property Backup\n";
        $sql .= "-- Generated at {$date}\n\n";
        $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

        foreach ($tables as $table) {
            $rows = DB::table($table)->get();

            if ($rows->isEmpty()) {
                continue;
            }

            $sql .= "-- Table: {$table}\n";
            $sql .= "TRUNCATE TABLE `{$table}`;\n";

            foreach ($rows as $row) {
                $columns = array_map(
                    fn ($col) => "`{$col}`",
                    array_keys((array) $row)
                );

                $values = array_map(
                    fn ($val) => is_null($val)
                        ? 'NULL'
                        : DB::getPdo()->quote($val),
                    array_values((array) $row)
                );

                $sql .= "INSERT INTO `{$table}` (" . implode(',', $columns) . ")
                         VALUES (" . implode(',', $values) . ");\n";
            }

            $sql .= "\n";
        }

        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

        File::put(
            "{$backupDir}/properties_backup_{$date}.sql",
            $sql
        );

        $this->info('Database backup created');
    }

    /**
     * Zip storage/app/public separately
     */
    protected function backupStoragePublic(string $backupDir, string $date)
    {
        $source = storage_path('app/public');
        $zipPath = "{$backupDir}/storage_public_{$date}.zip";

        $zip = new ZipArchive();
        $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        foreach (File::allFiles($source) as $file) {
            $zip->addFile(
                $file->getRealPath(),
                'public/' . $file->getRelativePathname()
            );
        }

        $zip->close();

        $this->info('Storage public backup created');
    }
}
