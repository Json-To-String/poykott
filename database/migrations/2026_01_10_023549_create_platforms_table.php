<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('platforms', function (Blueprint $table): void {
            $table->id();

            // Note: string can take on default values up to 255 characters
            // but text is used for longer entries
            $table->string('name');
            $table->string('employees')->nullable();
            $table->integer('founded')->nullable();
            $table->text('primary_use_case')->nullable();
            $table->string('target_users')->nullable();
            // Financials Overview
            $table->string('funding')->nullable();
            $table->string('revenue_2024')->nullable();
            $table->string('growth_rate')->nullable();
            // Implementation
            $table->string('setup_complexity')->nullable();
            $table->string('ci_cd_integration')->nullable();
            $table->string('edge_deployment')->nullable();
            $table->string('custom_domains_ssl')->nullable();
            // Pricing
            $table->string('free_tier')->nullable(); // POC Availability
            $table->string('team_plan')->nullable();
            $table->string('enterprise_plan')->nullable();
            // Security and Compliance
            $table->text('certifications')->nullable();
            $table->string('sso_rbac')->nullable();
            $table->string('data_residency')->nullable();
            // Functionalities
            $table->string('serverless_functions')->nullable();
            $table->string('preview_environments')->nullable();
            $table->string('edge_caching')->nullable();
            $table->string('backend_integration')->nullable();
            $table->string('performance_monitoring')->nullable();
            // Comparative Score
            $table->integer('ease_of_setup')->nullable();
            $table->integer('performance')->nullable();
            $table->integer('pricing')->nullable();
            $table->integer('enterprise_readiness')->nullable();
            $table->integer('developer_experience')->nullable();
            $table->text('israel_presence')->nullable();
            $table->integer('total_score')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('platforms');
    }
};
