<?php

namespace App\Console\Commands;

use App\Actions\CreateOrUpdateAlternativeByNameAction;
use App\Actions\CreateOrUpdateCompanyByNameAction;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ImportAlternativesFromCsvCommand extends Command
{
    protected $signature = 'import:alternatives-csv {path} {--approve} {--delimiter=,}';

    protected $description = 'Import alternatives from a CSV file. Headers may use dot notation for nested JSON fields (e.g. financials.founded)';

    public function handle(
        CreateOrUpdateAlternativeByNameAction $createOrUpdateAlternativeByNameAction,
        CreateOrUpdateCompanyByNameAction $createOrUpdateCompanyByNameAction
    ): int {
        $path = $this->argument('path');
        $delimiter = $this->option('delimiter') ?: ',';

        if (! file_exists($path)) {
            $this->error("File not found: {$path}");

            return 1;
        }

        $handle = fopen($path, 'r');
        if (! $handle) {
            $this->error('Unable to open file');

            return 1;
        }

        $headers = fgetcsv($handle, 0, $delimiter);
        if ($headers === [] || $headers === false) {
            $this->error('Empty or invalid CSV file');

            return 1;
        }

        $headers = array_map(fn ($h) => Str::of($h)->trim()->lower()->toString(), $headers);

        $rowCount = 0;
        $bar = $this->output->createProgressBar();
        $bar->start();

        while (($data = fgetcsv($handle, 0, $delimiter)) !== false) {
            $row = array_combine($headers, array_map(fn ($v) => $v === '' ? null : $v, $data));

            $name = data_get($row, 'name') ?: data_get($row, 'alternative_name');
            if (! $name) {
                continue;
            }

            $details = [];
            $optionalFields = [];
            $forcedFields = [];
            $image = null;
            $companyName = null;

            foreach ($row as $key => $value) {
                if (is_null($value)) {
                    continue;
                }

                if (in_array($key, ['name', 'description', 'url', 'notes', 'total_score', 'approved_at'])) {
                    // top-level fields we can safely mass assign
                    if ($key === 'total_score') {
                        // always update total_score if provided
                        $forcedFields['total_score'] = (int) $value;
                    } elseif ($key === 'approved_at') {
                        $forcedFields['approved_at'] = $value;
                    } else {
                        $optionalFields[$key] = $value;
                    }
                } elseif ($key === 'image_url') {
                    $image = $value;
                } elseif ($key === 'company') {
                    $companyName = $value;
                } elseif (str_contains($key, '.')) {
                    // nested -> place into details as nested array
                    data_set($details, $key, $value);
                } else {
                    // unknown top-level -> include in details root
                    $details[$key] = $value;
                }
            }

            if ($this->option('approve')) {
                $forcedFields['approved_at'] = now();
            }

            if (! empty($details)) {
                $optionalFields['details'] = $details;
            }

            // Use the existing action to create or update consistently
            $alternative = $createOrUpdateAlternativeByNameAction->execute(
                alternativeName: $name,
                forcedFields: $forcedFields,
                optionalFields: $optionalFields
            );

            // If details were provided, merge them into existing details to avoid overwriting
            if (! empty($optionalFields['details'])) {
                $current = $alternative->details ?? [];
                $merged = array_replace_recursive($current, $optionalFields['details']);
                $alternative->update(['details' => $merged]);
                // reload the model
                $alternative->refresh();
            }

            // Attach company if provided
            if ($companyName = data_get($row, 'company', $companyName)) {
                $companyUrl = data_get($row, 'company_url') ?: '';
                $company = $createOrUpdateCompanyByNameAction->execute(
                    companyName: $companyName,
                    forcedFields: ['approved_at' => now()],
                    optionalFields: ['url' => $companyUrl]
                );
                $alternative->companies()->syncWithoutDetaching($company->id);
            }

            // Add image if provided
            if ($image = data_get($row, 'image_url')) {
                $alternative->addTempMedia($image);
            }

            $rowCount++;
            $bar->advance();
        }

        $bar->finish();
        fclose($handle);

        $this->info("\nImported {$rowCount} alternatives.");

        return 0;
    }
}
