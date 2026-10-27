<x-library-layout :title="'Bewerk ' . $product->title . ' | Gaming Products Library'">
    <h1>Product bewerken</h1>

    <form method="POST" action="{{ route('products.update', $product) }}">
        @csrf
        @method('PATCH')
        @include('products._form', ['submitLabel' => 'Wijzigingen opslaan'])
    </form>
</x-library-layout>
