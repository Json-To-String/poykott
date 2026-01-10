<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvPath = base_path('resources/data/platforms.csv');
        $jsonPath = base_path('resources/data/platforms.json');

        $records = [];

        if (file_exists($csvPath)) {
            $records = $this->readCsv($csvPath);
        } elseif (file_exists($jsonPath)) {
            $records = $this->readJson($jsonPath);
        } else {
            $this->command?->warn('No data file found: provide resources/data/platforms.csv or platforms.json');

            return;
        }

        if ($records === []) {
            $this->command?->warn('No platform records to seed.');

            return;
        }

        $now = now();

        $columns = [
            'name',
            'employees',
            'founded',
            'primary_use_case',
            'target_users',
            'funding',
            'revenue_2024',
            'growth_rate',
            'setup_complexity',
            'ci_cd_integration',
            'edge_deployment',
            'custom_domains_ssl',
            'free_tier',
            'team_plan',
            'enterprise_plan',
            'certifications',
            'sso_rbac',
            'data_residency',
            'serverless_functions',
            'preview_environments',
            'edge_caching',
            'backend_integration',
            'performance_monitoring',
            'ease_of_setup',
            'performance',
            'pricing',
            'enterprise_readiness',
            'developer_experience',
            'israel_presence',
            'total_score',
        ];

        $intFields = [
            'founded',
            'ease_of_setup',
            'performance',
            'pricing',
            'enterprise_readiness',
            'developer_experience',
            'total_score',
        ];

        $payloads = [];
        foreach ($records as $item) {
            if (! is_array($item)) {
                continue;
            }
            $row = array_intersect_key($item, array_flip($columns));

            foreach ($intFields as $key) {
                if (array_key_exists($key, $row) && $row[$key] !== null && $row[$key] !== '') {
                    $row[$key] = (int) $row[$key];
                }
            }

            $row['created_at'] = $now;
            $row['updated_at'] = $now;

            if (! empty($row['name'])) {
                $payloads[] = $row;
            }
        }

        if ($payloads === []) {
            $this->command?->warn('No platform records to seed after normalization.');

            return;
        }

        $driver = DB::connection()->getDriverName();
        if ($driver === 'sqlite') {
            $count = 0;
            foreach ($payloads as $row) {
                $name = $row['name'] ?? null;
                if (! $name) {
                    continue;
                }
                $exists = DB::table('platforms')->where('name', $name)->exists();
                if ($exists) {
                    $update = $row;
                    unset($update['name'], $update['created_at']);
                    DB::table('platforms')->where('name', $name)->update($update);
                } else {
                    DB::table('platforms')->insert($row);
                }
                $count++;
            }
            $this->command?->info('PlatformSeeder: processed ' . $count . ' platform records (sqlite fallback).');
        } else {
            DB::table('platforms')->upsert(
                $payloads,
                ['name'],
                [
                    'employees',
                    'founded',
                    'primary_use_case',
                    'target_users',
                    'funding',
                    'revenue_2024',
                    'growth_rate',
                    'setup_complexity',
                    'ci_cd_integration',
                    'edge_deployment',
                    'custom_domains_ssl',
                    'free_tier',
                    'team_plan',
                    'enterprise_plan',
                    'certifications',
                    'sso_rbac',
                    'data_residency',
                    'serverless_functions',
                    'preview_environments',
                    'edge_caching',
                    'backend_integration',
                    'performance_monitoring',
                    'ease_of_setup',
                    'performance',
                    'pricing',
                    'enterprise_readiness',
                    'developer_experience',
                    'israel_presence',
                    'total_score',
                    'updated_at',
                ]
            );
            $this->command?->info('PlatformSeeder: upserted ' . count($payloads) . ' platform records.');
        }
    }

    /**
     * Read CSV file into associative arrays keyed by header.
     */
    private function readCsv(string $path): array
    {
        $handle = fopen($path, 'r');
        if ($handle === false) {
            return [];
        }

        $headers = fgetcsv($handle);
        if ($headers === false) {
            fclose($handle);

            return [];
        }

        // Remove BOM from first header if present
        if (isset($headers[0])) {
            $headers[0] = preg_replace('/^\xEF\xBB\xBF/', '', (string) $headers[0]);
        }

        // Normalize headers (lowercase, spaces to underscores)
        $normalized = array_map(function ($h): string|array {
            $h = trim((string) $h);
            $h = strtolower($h);

            return str_replace([' ', '/'], ['_', '_'], $h);
        }, $headers);

        // Map common synonyms to canonical column names
        $map = [
            'backend_integrations' => 'backend_integration',
        ];
        $normalized = array_map(function ($h) use ($map): string {
            return $map[$h] ?? $h;
        }, $normalized);

        $rows = [];
        while (($data = fgetcsv($handle)) !== false) {
            // Allow short/long rows by padding to header count
            if (count($data) < count($normalized)) {
                $data = array_pad($data, count($normalized), null);
            }
            $assoc = array_combine($normalized, $data);
            $rows[] = $assoc;
        }

        fclose($handle);

        return $rows;
    }

    /**
     * Read JSON array file.
     */
    private function readJson(string $path): array
    {
        $json = @file_get_contents($path);
        if ($json === false) {
            return [];
        }
        $items = json_decode($json, true);

        return is_array($items) ? $items : [];
    }
}
