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
    @auth
        @if ($product->user_id !== null && (int) $product->user_id === auth()->id())
            <div class="my-6 flex flex-wrap items-center gap-4">
                <a class="rounded bg-sky-800 px-4 py-2 font-bold !text-white" href="{{ route('products.edit', $product) }}">Product bewerken</a>
                <form method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('Weet je zeker dat je dit product wilt verwijderen?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="rounded bg-red-700 px-4 py-2 font-bold text-white">Product verwijderen</button>
                </form>
            </div>
        @endif
    @endauth

    <section class="my-8 border-t border-slate-300 pt-6" aria-labelledby="reviews-heading">
        <h2 id="reviews-heading">Reviews ({{ $reviews->total() }})</h2>
        <ul class="my-4 space-y-4 !list-none !pl-0">
            @forelse ($reviews as $review)
                <li class="rounded-lg border border-slate-300 p-4">
                    <h3 class="font-bold">{{ $review->title }}</h3>
                    <p class="text-sm text-slate-600">{{ $review->user->name }} · {{ $review->rating }} van 5 sterren</p>
                    <p class="whitespace-pre-line">{{ $review->content }}</p>
                    @auth
                        @if ((int) $review->user_id === auth()->id())
                            <form method="POST" action="{{ route('reviews.destroy', $review) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-700 underline">Eigen review verwijderen</button>
                            </form>
                        @endif
                    @endauth
                </li>
            @empty
                <li>Dit product heeft nog geen reviews.</li>
            @endforelse
        </ul>
        {{ $reviews->links() }}

        @auth
            <h2 class="mt-8">Schrijf een review</h2>
            @if ($errors->any())
                <div role="alert" class="rounded border border-red-300 bg-red-50 p-4 text-red-800">
                    <p>Controleer je review:</p>
                    <ul class="list-disc pl-6">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('products.reviews.store', $product) }}" class="my-4 space-y-4">
                @csrf
                <div>
                    <label class="mb-2 block font-bold" for="review-title">Titel</label>
                    <input class="w-full rounded border-slate-400" id="review-title" name="title" required maxlength="100" value="{{ old('title') }}">
                </div>
                <div>
                    <label class="mb-2 block font-bold" for="rating">Beoordeling</label>
                    <select class="rounded border-slate-400" id="rating" name="rating" required>
                        @for ($rating = 5; $rating >= 1; $rating--)
                            <option value="{{ $rating }}" @selected((int) old('rating', 5) === $rating)>{{ $rating }} sterren</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="mb-2 block font-bold" for="content">Jouw ervaring</label>
                    <textarea class="w-full rounded border-slate-400" id="content" name="content" rows="4" minlength="5" maxlength="2000" required>{{ old('content') }}</textarea>
                </div>
                <button type="submit" class="rounded bg-sky-800 px-4 py-2 font-bold text-white">Review plaatsen</button>
            </form>
        @endauth
        @guest
            <p><a href="{{ route('login') }}">Log in</a> om een review te plaatsen.</p>
        @endguest
    </section>
    <p><a href="{{ route('products.index') }}">Alle producten</a></p>
    <p><a href="{{ route('home') }}">Terug naar home</a></p>
</x-library-layout>
