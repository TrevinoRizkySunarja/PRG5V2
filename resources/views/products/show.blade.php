<x-library-layout :title="$product->title . ' | Gaming Products Library'">
    <p class="text-sm text-slate-600">{{ $product->brand }} · {{ $product->category }}</p>
    <h1>{{ $product->title }}</h1>
    <p>{{ $product->description }}</p>
    <dl class="my-6 grid gap-4 sm:grid-cols-2 [&_dt]:font-bold">
        <div><dt>Productnummer</dt><dd>{{ $product->id }}</dd></div>
        <div><dt>Merk</dt><dd><a href="{{ route('products.index', ['brand' => $product->brand]) }}">{{ $product->brand }}</a></dd></div>
        <div><dt>Productsoort</dt><dd><a href="{{ route('products.index', ['category' => $product->category]) }}">{{ $product->category }}</a></dd></div>
        <div><dt>Richtprijs (demo)</dt><dd>€ {{ number_format((float) $product->price, 2, ',', '.') }}</dd></div>
    </dl>
    <p>Deze democatalogus toont voorbeeldprijzen. Je kunt hier geen bestelling plaatsen.</p>
    <p><a href="{{ route('products.index') }}">Alle producten</a></p>
    <p><a href="{{ route('home') }}">Terug naar home</a></p>
</x-library-layout>
