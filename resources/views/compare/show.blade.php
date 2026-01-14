@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <a href="{{ route('compare.index') }}" class="text-sm text-gray-600">← Back to search</a>

    <h1 class="text-2xl font-bold mt-4">Comparing alternatives for {{ $data['company']['name'] }}</h1>

    <div class="mt-6 overflow-x-auto bg-white shadow rounded">
        <table class="min-w-full divide-y">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left">Name</th>
                    <th class="px-4 py-2 text-left">Total Score</th>
                    <th class="px-4 py-2 text-left">Founded</th>
                    <th class="px-4 py-2 text-left">Employees</th>
                    <th class="px-4 py-2 text-left">Primary Use Case</th>
                    <th class="px-4 py-2 text-left">Presence</th>
                    <th class="px-4 py-2 text-left">Details</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach ($data['alternatives'] as $alt)
                <tr>
                    <td class="px-4 py-2 font-medium">{{ $alt['name'] }}</td>
                    <td class="px-4 py-2">{{ $alt['totalScore'] }}%</td>
                    <td class="px-4 py-2">{{ $alt['financials']['founded'] ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $alt['financials']['employees'] ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $alt['financials']['primaryUseCase'] ?? '-' }}</td>
                    <td class="px-4 py-2">{{ Str::limit($alt['presence'] ?? '', 80) }}</td>
                    <td class="px-4 py-2"><a href="{{ route('compare.details', ['slug' => $data['company']['slug'], 'alternative' => Str::slug($alt['name'])]) }}" class="text-blue-600">View</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
