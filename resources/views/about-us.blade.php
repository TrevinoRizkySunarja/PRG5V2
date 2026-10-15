<x-library-layout :title="'Over ' . $company">
    <h1>Over {{ $company }}</h1>
    <p>Deze library bestaat uit gamingmuizen, headsets en keyboards van Logitech, Corsair, HyperX en Razer.</p>
    <p><a href="{{ route('home') }}">Terug naar home</a></p>
</x-library-layout>
