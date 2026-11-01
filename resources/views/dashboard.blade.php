<x-library-layout title="Mijn producten | Gaming Products Library">
    <h1>Mijn producten</h1>
    <p>Welkom, {{ auth()->user()->name }}. Hier beheer je alleen de producten waarvan jij eigenaar bent.</p>
    <p>Inlogdagen voor reviewvoorwaarde: {{ $loginDays }}/5. Je mag een review plaatsen na inloggen op vijf verschillende dagen.</p>
    <p><a class="inline-block rounded bg-sky-800 px-4 py-2 font-bold !text-white" href="{{ route('products.create') }}">Nieuw product toevoegen</a></p>

    <ul class="my-6 space-y-3">
        @forelse ($products as $product)
            <li class="flex flex-wrap items-center justify-between gap-3 rounded border border-slate-200 p-4">
                <div>
                    <strong>{{ $product->title }}</strong>
                    <span class="block text-sm text-slate-600">{{ $product->is_active ? 'Actief' : 'Niet actief (verborgen voor bezoekers)' }}</span>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('products.show', $product) }}">Bekijken</a>
                    <a href="{{ route('products.edit', $product) }}">Bewerken</a>
                </div>
            </li>
        @empty
            <li>Je hebt nog geen eigen producten toegevoegd.</li>
        @endforelse
    </ul>
    {{ $products->links() }}
    <p><a href="{{ route('profile.edit') }}">Mijn profiel aanpassen</a></p>
</x-library-layout>
