<x-app-layout>
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-semibold mb-4">Platform Comparison</h1>

    <div class="overflow-x-auto bg-white shadow rounded">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employees</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Founded</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Primary Use Case</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Target Users</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Funding</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue 2024</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Growth Rate</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Setup Complexity</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CI/CD</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Edge Deployment</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Custom Domains + SSL</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Free Tier</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Team Plan</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enterprise Plan</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Certifications</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SSO/RBAC</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data Residency</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Serverless</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preview Envs</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Edge Caching</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Backend Integration</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Perf Monitoring</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ease of Setup</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Performance</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pricing</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enterprise Readiness</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dev Experience</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Israel Presence</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Score</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($platforms as $p)
                <tr>
                    <td class="px-4 py-2 font-medium text-gray-900">{{ $p->name }}</td>
                    <td class="px-4 py-2">{{ $p->employees }}</td>
                    <td class="px-4 py-2">{{ $p->founded }}</td>
                    <td class="px-4 py-2">{{ Str::limit($p->primary_use_case, 80) }}</td>
                    <td class="px-4 py-2">{{ $p->target_users }}</td>
                    <td class="px-4 py-2">{{ $p->funding }}</td>
                    <td class="px-4 py-2">{{ $p->revenue_2024 }}</td>
                    <td class="px-4 py-2">{{ $p->growth_rate }}</td>
                    <td class="px-4 py-2">{{ $p->setup_complexity }}</td>
                    <td class="px-4 py-2">{{ $p->ci_cd_integration }}</td>
                    <td class="px-4 py-2">{{ $p->edge_deployment }}</td>
                    <td class="px-4 py-2">{{ $p->custom_domains_ssl }}</td>
                    <td class="px-4 py-2">{{ $p->free_tier }}</td>
                    <td class="px-4 py-2">{{ $p->team_plan }}</td>
                    <td class="px-4 py-2">{{ $p->enterprise_plan }}</td>
                    <td class="px-4 py-2">{{ Str::limit($p->certifications, 80) }}</td>
                    <td class="px-4 py-2">{{ $p->sso_rbac }}</td>
                    <td class="px-4 py-2">{{ $p->data_residency }}</td>
                    <td class="px-4 py-2">{{ $p->serverless_functions }}</td>
                    <td class="px-4 py-2">{{ $p->preview_environments }}</td>
                    <td class="px-4 py-2">{{ $p->edge_caching }}</td>
                    <td class="px-4 py-2">{{ $p->backend_integration }}</td>
                    <td class="px-4 py-2">{{ $p->performance_monitoring }}</td>
                    <td class="px-4 py-2 text-center">{{ $p->ease_of_setup }}</td>
                    <td class="px-4 py-2 text-center">{{ $p->performance }}</td>
                    <td class="px-4 py-2 text-center">{{ $p->pricing }}</td>
                    <td class="px-4 py-2 text-center">{{ $p->enterprise_readiness }}</td>
                    <td class="px-4 py-2 text-center">{{ $p->developer_experience }}</td>
                    <td class="px-4 py-2">{{ Str::limit($p->israel_presence, 80) }}</td>
                    <td class="px-4 py-2 font-semibold text-right">{{ $p->total_score }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $platforms->links() }}
    </div>
</div>
</x-app-layout>
