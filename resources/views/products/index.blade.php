<x-library-layout :title="$pageTitle">
    <h1>{{ $pageTitle }}</h1>
    <p>Een bibliotheek voor gamingmuizen, headsets en toetsenborden.</p>

    <h2>Merken</h2>
    <ul>
        @foreach ($brands as $brand)
            <li><a href="{{ route('brands', ['brand' => $brand]) }}">{{ $brand }}</a></li>
        @endforeach
    </ul>

    <h2>Productsoorten</h2>
    <ul>
        @foreach ($categories as $category)
            <li>{{ $category }}</li>
        @endforeach
    </ul>
    <h2>Voorbeeldproducten</h2>
    <ul>
        <li><a href="{{ route('products.show', ['product' => 1]) }}">Bekijk product 1</a></li>
        <li><a href="{{ route('products.show', ['product' => 24]) }}">Bekijk product 24</a></li>
    </ul>
    <p><a href="{{ route('home') }}">Terug naar home</a></p>
</x-library-layout>
