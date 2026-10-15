<x-library-layout :title="'Product ' . $productId">
    <h1>Product {{ $productId }}</h1>
    <p>Productgegevens worden later toegevoegd.</p>
    <p><a href="{{ route('products.index') }}">Alle producten</a></p>
    <p><a href="{{ route('home') }}">Terug naar home</a></p>
</x-library-layout>
