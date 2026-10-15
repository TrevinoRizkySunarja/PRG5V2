@props(['active' => false])

<a {{ $attributes->merge(['class' => $active ? 'library-nav-link is-active' : 'library-nav-link']) }}
    @if ($active) aria-current="page" @endif>
    {{ $slot }}
</a>
