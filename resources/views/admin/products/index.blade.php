<x-library-layout title="Adminbeheer | Gaming Products Library">
    <h1>Adminbeheer producten</h1>
    <p>Maak producten actief of niet actief. Alleen een admin kan deze pagina en de POST-actie gebruiken.</p>

    <div class="overflow-x-auto">
        <table class="my-6 w-full border-collapse text-left">
            <thead class="bg-slate-100">
                <tr>
                    <th scope="col" class="p-3">Product</th>
                    <th scope="col" class="p-3">Eigenaar</th>
                    <th scope="col" class="p-3">Status</th>
                    <th scope="col" class="p-3">Actie (POST)</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr class="border-b border-slate-200">
                        <td class="p-3"><a href="{{ route('products.show', $product) }}">{{ $product->title }}</a><span class="block text-sm text-slate-600">{{ $product->brand }} · {{ $product->category }}</span></td>
                        <td class="p-3">{{ $product->user?->name ?? 'Democatalogus' }}</td>
                        <td class="p-3">{{ $product->is_active ? 'Actief' : 'Niet actief' }}</td>
                        <td class="p-3">
                            <form method="POST" action="{{ route('admin.products.toggle-status', $product) }}">
                                @csrf
                                <button type="submit" class="rounded px-4 py-2 font-semibold text-white {{ $product->is_active ? 'bg-red-700' : 'bg-green-800' }}">
                                    {{ $product->is_active ? 'Deactiveren' : 'Activeren' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="p-3">Er zijn nog geen producten.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $products->links() }}
    <p><a href="{{ route('dashboard') }}">Terug naar dashboard</a></p>
</x-library-layout>
