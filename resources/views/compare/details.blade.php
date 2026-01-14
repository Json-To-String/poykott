@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <a href="{{ route('compare.show', $company['slug']) }}" class="text-sm text-gray-600">← Back to comparison</a>

    <div class="mt-4 bg-white shadow rounded p-6">
        <div class="flex items-center gap-4">
            @if (!empty($alternative['logo']))
                <img src="{{ $alternative['logo'] }}" alt="{{ $alternative['name'] }}" class="h-16 w-16 object-contain" />
            @endif
            <div>
                <h1 class="text-2xl font-bold">{{ $alternative['name'] }}</h1>
                @if (!empty($alternative['website']))
                    <a href="{{ $alternative['website'] }}" target="_blank" class="text-blue-600 text-sm">Visit website</a>
                @endif
            </div>
        </div>

        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="font-semibold mb-2">Financials</h3>
                <ul class="text-sm text-gray-700 space-y-1">
                    <li><strong>Founded:</strong> {{ $alternative['financials']['founded'] ?? '-' }}</li>
                    <li><strong>Employees:</strong> {{ $alternative['financials']['employees'] ?? '-' }}</li>
                    <li><strong>Primary use case:</strong> {{ $alternative['financials']['primaryUseCase'] ?? '-' }}</li>
                    <li><strong>Target users:</strong> {{ $alternative['financials']['targetUsers'] ?? '-' }}</li>
                </ul>
            </div>

            <div>
                <h3 class="font-semibold mb-2">Functionality & Setup</h3>
                <ul class="text-sm text-gray-700 space-y-1">
                    <li><strong>Setup complexity:</strong> {{ $alternative['implementation']['setupComplexity'] ?? '-' }}</li>
                    <li><strong>CI/CD:</strong> {{ $alternative['implementation']['cicdIntegration'] ?? '-' }}</li>
                    <li><strong>Serverless:</strong> {{ $alternative['functionalities']['serverlessFunctions'] ?? '-' }}</li>
                    <li><strong>Preview envs:</strong> {{ $alternative['functionalities']['previewEnvironments'] ?? '-' }}</li>
                </ul>
            </div>

            <div class="md:col-span-2">
                <h3 class="font-semibold mb-2">Presence & Notes</h3>
                <p class="text-sm text-gray-700">{{ $alternative['presence'] ?? '-' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
