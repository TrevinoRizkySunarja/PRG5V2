@props(['title', 'subtitle' => null, 'href' => null])

<article {{ $attributes->class(['library-card']) }}>
    @if ($subtitle)
        <p class="library-card-subtitle">{{ $subtitle }}</p>
    @endif
    <h2>
        @if ($href)
            <a href="{{ $href }}">{{ $title }}</a>
        @else
            {{ $title }}
        @endif
    </h2>
    {{ $slot }}
</article>
