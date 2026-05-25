<x-filament-widgets::widget>
    <div style="
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: var(--bt-radius, 12px);
        padding: 24px;
    ">
        <div style="margin-bottom: 20px;">
            <h2 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0;">
                Needs Your Attention
            </h2>
            <p style="font-size: 0.875rem; color: #6b7280; margin: 4px 0 0;">
                Items waiting on you right now
            </p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px;">
            @foreach ($this->getItems() as $item)
                @php
                    $palette = match($item['colour']) {
                        'amber' => ['bg' => '#fffbeb', 'fg' => '#b45309', 'border' => '#fcd34d'],
                        'sky'   => ['bg' => '#f0f9ff', 'fg' => '#0369a1', 'border' => '#7dd3fc'],
                        'rose'  => ['bg' => '#fff1f2', 'fg' => '#be123c', 'border' => '#fda4af'],
                        default => ['bg' => '#f3f4f6', 'fg' => '#374151', 'border' => '#d1d5db'],
                    };
                @endphp

                <a href="{{ $item['url'] }}" style="
                    display: block;
                    padding: 16px;
                    border: 1px solid #e5e7eb;
                    border-radius: 10px;
                    text-decoration: none;
                    color: inherit;
                    transition: all 0.15s ease;
                "
                onmouseover="this.style.borderColor='{{ $palette['border'] }}'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.06)';"
                onmouseout="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">

                    <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 12px;">
                        <div style="display: flex; align-items: center; gap: 12px; min-width: 0;">
                            <div style="
                                flex-shrink: 0;
                                width: 40px;
                                height: 40px;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                border-radius: 8px;
                                background: {{ $palette['bg'] }};
                                color: {{ $palette['fg'] }};
                            ">
                                <x-filament::icon :icon="$item['icon']" style="width: 20px; height: 20px;" />
                            </div>
                            <div style="min-width: 0;">
                                <div style="font-size: 1.5rem; font-weight: 700; color: #111827; line-height: 1;">
                                    {{ $item['count'] }}
                                </div>
                                <div style="font-size: 0.875rem; color: #4b5563; margin-top: 4px;">
                                    {{ $item['label'] }}
                                </div>
                            </div>
                        </div>

                        <div style="flex-shrink: 0; padding-top: 4px;">
                            @if ($item['count'] > 0)
                                <span style="font-size: 0.75rem; font-weight: 600; color: {{ $palette['fg'] }};">
                                    {{ $item['cta'] }} →
                                </span>
                            @else
                                <span style="font-size: 0.75rem; color: #9ca3af;">
                                    All clear ✓
                                </span>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</x-filament-widgets::widget>
