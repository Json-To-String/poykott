<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportPlatformsCommand extends Command
{
    protected $signature = 'platforms:import {path : Path to CSV or JSON file}';

    protected $description = 'Import platform comparison records from a CSV or JSON file and upsert by name';

    public function handle(): int
    {
        $path = (string) $this->argument('path');
        if (! file_exists($path)) {
            $this->error("File not found: {$path}");

            return self::FAILURE;
        }

        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        if (! in_array($ext, ['csv', 'json'])) {
            $this->warn('Unsupported format. Please provide a .csv or .json file.');

            return self::FAILURE;
        }

        $records = $ext === 'csv' ? $this->readCsv($path) : $this->readJson($path);
        if ($records === []) {
            $this->warn('No records parsed from file.');

            return self::SUCCESS;
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
            $this->warn('No platform records to upsert after normalization.');

            return self::SUCCESS;
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
            $this->info('Processed ' . $count . ' platform records (sqlite fallback).');
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

            $this->info('Upserted ' . count($payloads) . ' platform records.');
        }

        return self::SUCCESS;
    }

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

        if (isset($headers[0])) {
            $headers[0] = preg_replace('/^\xEF\xBB\xBF/', '', (string) $headers[0]);
        }

        $normalized = array_map(function ($h): string|array {
            $h = trim((string) $h);
            $h = strtolower($h);

            return str_replace([' ', '/'], ['_', '_'], $h);
        }, $headers);

        $map = [
            'backend_integrations' => 'backend_integration',
        ];
        $normalized = array_map(function ($h) use ($map): string {
            return $map[$h] ?? $h;
        }, $normalized);

        $rows = [];
        while (($data = fgetcsv($handle)) !== false) {
            if (count($data) < count($normalized)) {
                $data = array_pad($data, count($normalized), null);
            }
            $assoc = array_combine($normalized, $data);
            $rows[] = $assoc;
        }

        fclose($handle);

        return $rows;
    }

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
