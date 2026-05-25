<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Needs Your Attention
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Items waiting on you right now
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach ($this->getItems() as $item)
                <a href="{{ $item['url'] }}"
                   class="block p-4 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-{{ $item['colour'] }}-400 hover:shadow-md transition">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            <div class="p-2 rounded-md bg-{{ $item['colour'] }}-50 dark:bg-{{ $item['colour'] }}-900/30">
                                <x-filament::icon
                                    :icon="$item['icon']"
                                    class="w-5 h-5 text-{{ $item['colour'] }}-600 dark:text-{{ $item['colour'] }}-400"
                                />
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-gray-900 dark:text-white leading-none">
                                    {{ $item['count'] }}
                                </div>
                                <div class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                    {{ $item['label'] }}
                                </div>
                            </div>
                        </div>
                        @if ($item['count'] > 0)
                            <span class="text-xs font-medium text-{{ $item['colour'] }}-600 dark:text-{{ $item['colour'] }}-400">
                                {{ $item['cta'] }} →
                            </span>
                        @else
                            <span class="text-xs text-gray-400">
                                All clear ✓
                            </span>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
