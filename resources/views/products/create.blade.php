<x-library-layout title="Product toevoegen | Gaming Products Library">
    <h1>Product toevoegen</h1>
    <p>Voeg een gamingmuis, headset of toetsenbord toe aan je bibliotheek.</p>

    <form method="POST" action="{{ route('products.store') }}">
        @csrf
        @include('products._form', ['submitLabel' => 'Product opslaan'])
    </form>
</x-library-layout>
