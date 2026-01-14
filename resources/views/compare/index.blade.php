@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-10">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold">Find Your Alternative</h1>
        <p class="text-muted mt-2">Search for a company to discover and compare alternatives.</p>
    </div>

    <form method="get" action="{{ route('compare.index') }}" class="max-w-xl mx-auto">
        <div class="flex gap-2">
            <input name="q" value="{{ old('q', $q ?? '') }}" placeholder="Search for a company..." class="flex-1 px-4 py-3 border rounded-lg" />
            <button class="px-4 py-3 bg-blue-600 text-white rounded-lg">Search</button>
        </div>
    </form>

    <div class="max-w-2xl mx-auto mt-6">
        @if (count($companies) === 0)
            <div class="p-4 text-center text-gray-600">No results{{ isset($q) && $q !== '' ? ' for "' . e($q) . '"' : '' }}.</div>
        @else
            <ul class="divide-y">
                @foreach ($companies as $c)
                <li class="py-3 flex items-center justify-between">
                    <div>
                        <a href="{{ route('compare.show', $c['slug']) }}" class="font-medium text-lg">{{ $c['name'] }}</a>
                        <div class="text-sm text-gray-600">{{ $c['description'] }}</div>
                    </div>
                    <div>
                        <a href="{{ route('compare.show', $c['slug']) }}" class="text-sm text-blue-600">Compare →</a>
                    </div>
                </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endsection
