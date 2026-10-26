@props(['title', 'subtitle' => null, 'href' => null])

<article {{ $attributes->class(['min-w-0 break-words rounded-lg border border-slate-300 p-5']) }}>
    @if ($subtitle)
        <p class="text-sm text-slate-600">{{ $subtitle }}</p>
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
