@if ($errors->any())
    <div role="alert" class="mb-6 rounded border border-red-300 bg-red-50 p-4 text-red-800">
        <p>Controleer de ingevulde velden:</p>
        <ul class="list-disc pl-6">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="my-4">
    <label class="mb-2 block font-bold" for="title">Productnaam</label>
    <input class="w-full rounded border-slate-400" id="title" name="title" maxlength="100" required value="{{ old('title', $product->title) }}">
</div>

<div class="my-4">
    <label class="mb-2 block font-bold" for="description">Beschrijving</label>
    <textarea class="w-full rounded border-slate-400" id="description" name="description" rows="5" maxlength="2000" required>{{ old('description', $product->description) }}</textarea>
</div>

<div class="my-4 grid gap-4 sm:grid-cols-2">
    <div>
        <label class="mb-2 block font-bold" for="brand">Merk</label>
        <select class="w-full rounded border-slate-400" id="brand" name="brand" required>
            <option value="">Kies een merk</option>
            @foreach (config('library.brands') as $brand)
                <option value="{{ $brand }}" @selected(old('brand', $product->brand) === $brand)>{{ $brand }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="mb-2 block font-bold" for="category">Productsoort</label>
        <select class="w-full rounded border-slate-400" id="category" name="category" required>
            <option value="">Kies een productsoort</option>
            @foreach (config('library.categories') as $category)
                <option value="{{ $category }}" @selected(old('category', $product->category) === $category)>{{ $category }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="my-4">
    <label class="mb-2 block font-bold" for="price">Richtprijs in euro (€)</label>
    <input class="w-full rounded border-slate-400 sm:w-56" id="price" name="price" type="number" min="0.01" max="99999999.99" step="0.01" required value="{{ old('price', $product->price) }}">
</div>

<button type="submit" class="rounded bg-sky-800 px-5 py-3 font-bold text-white hover:bg-sky-900">{{ $submitLabel }}</button>
<a class="ml-4" href="{{ $product->exists ? route('products.show', $product) : route('products.index') }}">Annuleren</a>
