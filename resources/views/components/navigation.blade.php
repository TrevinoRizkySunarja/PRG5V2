@props(['title' => 'Gaming Products Library'])

{{-- Bestaande dashboard- en testpagina's gebruiken deze componentnaam. --}}
<x-library-layout :title="$title">
    {{ $slot }}
</x-library-layout>
