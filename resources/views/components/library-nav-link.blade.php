@props(['active' => false])

<a {{ $attributes->class([
    'inline-block rounded px-3 py-2',
    'bg-sky-400 font-bold text-slate-900' => $active,
    'text-slate-200 hover:bg-slate-700' => ! $active,
]) }}
    @if ($active) aria-current="page" @endif>
    {{ $slot }}
</a>
