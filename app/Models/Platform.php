<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    protected $fillable = [
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

    protected function casts(): array
    {
        return [
            'founded' => 'integer',
            'ease_of_setup' => 'integer',
            'performance' => 'integer',
            'pricing' => 'integer',
            'enterprise_readiness' => 'integer',
            'developer_experience' => 'integer',
            'total_score' => 'integer',
        ];
    }
}
