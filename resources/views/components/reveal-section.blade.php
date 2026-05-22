@props([
    'tag'     => 'section',
    'class'   => '',
    'delay'   => 0,       {{-- ms offset before the section sequence starts --}}
    'order'   => null,    {{-- optional numeric hint (not used at runtime, just docs) --}}
])
{{--
    x-reveal-section — PPT-style Staggered Reveal Blade Component
    ─────────────────────────────────────────────────────────────
    Usage:
        <x-reveal-section tag="section" class="ht-section" :delay="100">
            <h2 data-reveal="heading">…</h2>
            <p  data-reveal="sub">…</p>
            <div data-reveal="body">…</div>
        </x-reveal-section>

    Children marked with [data-reveal] are orchestrated in this order:
        heading  → delay 0
        sub      → delay +120ms
        body     → delay +240ms
        cta      → delay +360ms
        card-*   → delay +80ms × index (stagger)

    The IntersectionObserver in welcome.blade.php handles activation.
    It adds `.ppt-in` to each child in sequence.
--}}

<{{ $tag }}
    {{ $attributes->merge([
        'class'          => 'ppt-section ' . $class,
        'data-ppt-delay' => $delay,
    ]) }}
>
    {{ $slot }}
</{{ $tag }}>
