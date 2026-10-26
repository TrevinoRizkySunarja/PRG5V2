<x-library-layout :title="$pageTitle">
    <h1>{{ $pageTitle }}</h1>
    <p>Vind een gamingmuis, headset of toetsenbord voor jouw setup.</p>
    <form method="GET" action="{{ route('products.index') }}" class="my-6 flex flex-wrap items-end gap-4 rounded-lg bg-slate-100 p-4" aria-label="Producten zoeken en filteren">
        <div class="min-w-0 flex-1 basis-48">
            <label for="q" class="mb-2 block font-bold">Zoek op naam of beschrijving</label>
            <input id="q" name="q" type="search" class="w-full rounded border-slate-500" maxlength="100" value="{{ $filters['q'] ?? '' }}" placeholder="Bijvoorbeeld: draadloos">
        </div>
        <div class="min-w-0 flex-1 basis-48">
            <label for="brand" class="mb-2 block font-bold">Merk</label>
            <select id="brand" name="brand" class="w-full rounded border-slate-500">
                <option value="">Alle merken</option>
                @foreach ($brands as $brand)
                    <option value="{{ $brand }}" @selected(($filters['brand'] ?? '') === $brand)>{{ $brand }}</option>
                @endforeach
            </select>
        </div>
        <div class="min-w-0 flex-1 basis-48">
            <label for="category" class="mb-2 block font-bold">Productsoort</label>
            <select id="category" name="category" class="w-full rounded border-slate-500">
                <option value="">Alle productsoorten</option>
                @foreach ($categories as $category)
                    <option value="{{ $category }}" @selected(($filters['category'] ?? '') === $category)>{{ $category }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="rounded bg-sky-800 px-4 py-2.5 font-bold text-white hover:bg-sky-900">Zoeken</button>
        <a href="{{ route('products.index') }}">Filters wissen</a>
    </form>
    @if ($errors->any())
        <div role="alert" class="rounded border border-red-300 bg-red-50 p-4 text-red-800">
            <p>Controleer je zoekopdracht:</p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <p>{{ $products->total() }} {{ $products->total() === 1 ? 'product gevonden' : 'producten gevonden' }}.</p>
    <p class="text-sm text-slate-600">Democatalogus: prijzen zijn voorbeeldbedragen, geen actuele winkelprijzen.</p>
    <div class="my-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($products as $product)
            <x-library-card :title="$product->title" :subtitle="$product->brand . ' · ' . $product->category" :href="route('products.show', $product)">
                <p>{{ $product->description }}</p>
                <p class="text-xl font-bold">€ {{ number_format((float) $product->price, 2, ',', '.') }}</p>
            </x-library-card>
        @empty
            <p>Geen producten gevonden. Probeer een andere zoekterm of wis de filters.</p>
        @endforelse
    </div>
    {{ $products->links() }}
    <p><a href="{{ route('home') }}">Terug naar home</a></p>
</x-library-layout>
