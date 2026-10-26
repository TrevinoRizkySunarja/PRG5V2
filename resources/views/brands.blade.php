<x-library-layout :title="$brand . ' | Gaming Products Library'">
    <h1>{{ $brand }}</h1>
    <p>Kies een merk uit de gamingbibliotheek.</p>
    <p><a href="{{ route('products.index', $brand === 'Alle merken' ? [] : ['brand' => $brand]) }}">Bekijk {{ $brand === 'Alle merken' ? 'alle producten' : 'producten van ' . $brand }}</a></p>
    <ul>
        <li><a href="{{ route('brands') }}">Alle merken</a></li>
        @foreach ($brands as $availableBrand)
            <li><a href="{{ route('brands', ['brand' => $availableBrand]) }}">{{ $availableBrand }}</a></li>
        @endforeach
    </ul>
    <p><a href="{{ route('home') }}">Terug naar home</a></p>
</x-library-layout>
