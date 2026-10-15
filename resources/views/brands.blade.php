<x-library-layout :title="$brand . ' | Gaming Products Library'">
    <h1>{{ $brand }}</h1>
    <p>Kies een merk uit de gamingbibliotheek.</p>
    <ul>
        <li><a href="{{ route('brands') }}">Alle merken</a></li>
        <li><a href="{{ route('brands', ['brand' => 'Logitech']) }}">Logitech</a></li>
        <li><a href="{{ route('brands', ['brand' => 'Corsair']) }}">Corsair</a></li>
        <li><a href="{{ route('brands', ['brand' => 'HyperX']) }}">HyperX</a></li>
        <li><a href="{{ route('brands', ['brand' => 'Razer']) }}">Razer</a></li>
    </ul>
    <p><a href="{{ route('home') }}">Terug naar home</a></p>
</x-library-layout>
