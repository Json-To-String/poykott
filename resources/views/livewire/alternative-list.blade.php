<div>
    <style>
        @media print {
            .no-print { display: none !important; }
            .sticky { position: static !important; }
            table { font-size: 10pt; }
            th, td { padding: 4px !important; }
        }
        .compact th, .compact td { padding: 6px 8px; font-size: 13px; }
        .expanded th, .expanded td { padding: 12px 16px; font-size: 15px; }
    </style>
    <!-- Searching/Filtering box -->
    <section class="no-print">
        {{--
            <div class="flex justify-end mb-2">
            <a
            href="#"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium shadow-sm"
            >
            + Add New Alternative
            </a>
            </div>
        --}}
        <div class="mb-6 rounded-lg border border-slate-200 bg-white p-4">
            <div class="flex w-full flex-col gap-4 sm:flex-row sm:gap-2">
                <div class="relative w-full">
                    <label for="search-input" class="sr-only">Search...</label>

                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <!-- Spinner -->
                        <svg
                            wire:loading.delay
                            wire:target="search"
                            class="h-4 w-4 animate-spin text-blue-600"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                        >
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z" />
                        </svg>
                    </div>

                    <input
                        id="search-input"
                        wire:model.live="search"
                        type="text"
                        placeholder="Search..."
                        class="w-full rounded-md border py-2 pl-9 pr-3 focus:border-blue-300 focus:outline-none focus:ring"
                    />
                </div>

                <div class="flex items-center gap-2 sm:ml-2">
                    <button wire:click="toggleCompact" class="inline-flex items-center gap-2 rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 no-print">
                        @if ($compact)
                            Expanded view
                        @else
                            Compact view
                        @endif
                    </button>
                </div>

                <!-- Filter select -->
                {{--
                    <label for="filter-select" class="sr-only">Filter by</label>
                    <select
                    id="filter-select"
                    wire:model.live="filter"
                    class="w-full rounded-md border px-4 py-2 focus:border-blue-300 focus:outline-none focus:ring sm:w-1/6"
                    >
                    <option value="">Filter by</option>
                    @foreach ($this->alternativesTags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }} ({{ $tag->alternatives_count }})</option>
                    @endforeach
                    </select>
                --}}

                <!-- Order select -->
                {{--
                    <label for="order-select" class="sr-only">Order by</label>
                    <select
                    id="order-select"
                    wire:model.live="order"
                    class="w-full rounded-md border px-4 py-2 focus:border-blue-300 focus:outline-none focus:ring sm:w-1/6"
                    >
                    <option value="">Order by</option>
                    <option value="asc">Ascending</option>
                    <option value="desc">Descending</option>
                    </select>
                --}}
            </div>
        </div>
    </section>

    <!-- Companies grid -->
    <section>
        @if ($matchedCompany)
            <div class="mb-4 rounded-md bg-blue-50 p-4" role="status" aria-live="polite">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg
                            class="h-5 w-5 text-blue-400"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            aria-hidden="true"
                            focusable="false"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h.01a1 1 0 100-2H10V9z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">
                            <a
                                href="{{ route('companies.show', $matchedCompany) }}"
                                class="font-bold text-blue-900 hover:underline"
                            >
                                {{ $matchedCompany->name }}
                            </a>

                            is an Israeli company. Following are the alternatives.
                        </h3>
                    </div>
                </div>
            </div>
        @endif

        <div id="company-list" class="overflow-auto rounded-lg border border-slate-200 bg-white p-4">
            @if ($alternatives->isEmpty())
                <div class="py-10 text-center text-xl text-gray-500">
                    Your search did not match any alternatives. Please
                    <a href="{{ route('contact.get') }}" class="text-blue-600 hover:text-blue-700">contact us</a>
                    for suggestions.
                </div>
            @else
                <div class="min-w-full overflow-x-auto {{ $compact ? 'compact' : 'expanded' }}">
                    <table class="w-full table-fixed border-collapse text-sm">
                        <thead class="sticky top-0 z-10 bg-slate-50">
                            <tr class="border-b text-left text-xs font-semibold text-slate-700 uppercase tracking-wide">
                                <th class="px-2 py-2">Name</th>
                                <th class="px-2 py-2 w-28">Score</th>
                                <th class="px-2 py-2">Description</th>
                                <th class="px-2 py-2">Ease</th>
                                <th class="px-2 py-2">Performance</th>
                                <th class="px-2 py-2">Pricing</th>
                                <th class="px-2 py-2">Enterprise</th>
                                <th class="px-2 py-2">Developer Exp.</th>
                                <th class="px-2 py-2">Alternative to</th>
                                <th class="px-2 py-2 no-print">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach ($alternatives as $alt)
                                <tr class="odd:bg-white even:bg-slate-50 hover:bg-slate-100">
                                    <td class="px-2 py-1 align-top">
                                        <a href="{{ route('alternatives.show', $alt) }}" class="font-medium text-slate-900 hover:underline">{{ $alt->name }}</a>
                                    </td>

                                    <td class="px-2 py-1 align-top w-28">
                                        @php $score = (int) ($alt->total_score ?? 0); $pct = max(0, min(100, $score)); @endphp
                                        <div class="mb-1 flex items-center gap-2">
                                            <div class="h-2 w-full rounded bg-slate-200">
                                                <div class="h-2 rounded bg-emerald-600" style="width: {{ $pct }}%"></div>
                                            </div>
                                            <div class="text-xs text-slate-700">{{ $score ?: '-' }}</div>
                                        </div>
                                    </td>

                                    <td class="px-2 py-1 text-slate-700">{{ Str::limit($alt->description, $compact ? 110 : 300) }}</td>

                                    <td class="px-2 py-1">{{ data_get($alt->details, 'ease_of_setup', '-') }}</td>

                                    <td class="px-2 py-1">{{ data_get($alt->details, 'performance', '-') }}</td>

                                    <td class="px-2 py-1">{{ data_get($alt->details, 'pricing.free_tier', '-') }}</td>

                                    <td class="px-2 py-1">{{ data_get($alt->details, 'enterprise_readiness', '-') }}</td>

                                    <td class="px-2 py-1">{{ data_get($alt->details, 'developer_experience', '-') }}</td>

                                    <td class="px-2 py-1">
                                        @if ($alt->companies->isNotEmpty())
                                            <div class="flex flex-wrap gap-1">
                                                @foreach ($alt->companies as $company)
                                                    <span class="inline-flex items-center rounded border border-gray-200 bg-gray-50 px-2 py-0.5 text-xs text-gray-700">{{ $company->name }}</span>
                                                @endforeach
                                            </div>
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td class="px-2 py-1 no-print">
                                        <a href="{{ route('alternatives.show', $alt) }}" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-2 py-1 text-xs font-medium text-gray-800 hover:bg-gray-50">Details</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        <div class="mt-2">
            {{ $alternatives->links() }}
        </div>
    </section>
</div>
