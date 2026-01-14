Importing alternatives from CSV
===============================

Place a CSV file anywhere on the server and run the Artisan command:

```bash
php artisan import:alternatives-csv path/to/file.csv --approve
```

Options:
- `--approve` — set `approved_at` to now for imported records
- `--delimiter` — CSV delimiter (default is `,`)

CSV headers:
- Top-level standard headers: `name`, `description`, `url`, `notes`, `total_score`, `approved_at`, `image_url`, `company`
- Nested fields: use dot notation to populate the `details` JSON column, e.g. `financials.founded`, `implementation.setup_complexity`, `security.certifications`

Recommended additional detail keys (CSV header names):
- `ease_of_setup` — Ease of setup (string or rating)
- `performance` — Performance notes or rating
- `enterprise_readiness` — Enterprise readiness notes or rating
- `developer_experience` — Developer experience notes or rating

Example headers:
```
name,description,url,company,total_score,financials.founded,financials.revenue,pricing.free_tier,image_url
```

Behavior:
- Existing alternatives are updated using the project's `CreateOrUpdateAlternativeByNameAction` (name matching is case-insensitive).
- Nested columns are stored into the `details` JSON column.
 - When importing, provided `details` are merged into any existing `details` (incoming keys overwrite existing keys but existing keys not provided are preserved).
- If `company` is provided the command will find or create the company and associate it with the alternative.
- If `image_url` is provided the media is added as temp media (project media migration will handle finalization).
