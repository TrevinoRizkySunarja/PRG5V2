<nav class="library-navigation" aria-label="Hoofdnavigatie">
    <div class="library-nav-group">
        <x-library-nav-link :href="route('home')" :active="request()->routeIs('home')">Home</x-library-nav-link>
        <x-library-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">Producten</x-library-nav-link>
        <x-library-nav-link :href="route('brands')" :active="request()->routeIs('brands')">Merken</x-library-nav-link>
        <x-library-nav-link :href="route('about')" :active="request()->routeIs('about')">Over de bibliotheek</x-library-nav-link>
        <x-library-nav-link :href="route('contact')" :active="request()->routeIs('contact')">Contact</x-library-nav-link>
    </div>

    <div class="library-nav-group">
        @guest
            <x-library-nav-link :href="route('login')">Inloggen</x-library-nav-link>
            <x-library-nav-link :href="route('register')">Registreren</x-library-nav-link>
        @endguest

        @auth
            <x-library-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-library-nav-link>
            <x-library-nav-link :href="route('profile.edit')">{{ auth()->user()->name }}</x-library-nav-link>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="library-nav-link">Uitloggen</button>
            </form>
        @endauth
    </div>
</nav>
