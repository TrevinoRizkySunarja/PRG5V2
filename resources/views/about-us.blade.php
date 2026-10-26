<x-library-layout :title="'Over ' . $company">
    <h1>Over {{ $company }}</h1>
    <p>Ontdek gamingproducten voor jouw setup. Bekijk hun beschrijving, merk, productsoort en richtprijs.</p>
    <h2>Merken in de bibliotheek</h2>
    <div class="my-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($brands as $brand)
            <x-library-card :title="$brand" subtitle="Gamingmerk" :href="route('brands', ['brand' => $brand])">
                <p>Ontdek de producten van {{ $brand }}.</p>
            </x-library-card>
        @endforeach
    </div>
    <h2>Productsoorten</h2>
    <ul>
        @foreach ($categories as $category)
            <li>{{ $category }}</li>
        @endforeach
    </ul>
    <p>Dit is een studieproject, geen webshop. Je kunt hier geen bestelling plaatsen.</p>
    <p><a href="{{ route('home') }}">Terug naar home</a></p>
</x-library-layout>
