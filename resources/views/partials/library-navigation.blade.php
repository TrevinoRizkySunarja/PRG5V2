<nav class="flex flex-wrap items-center justify-between gap-4" aria-label="Hoofdnavigatie">
    <div class="flex flex-wrap items-center gap-2">
        <x-library-nav-link :href="route('home')" :active="request()->routeIs('home')">Home</x-library-nav-link>
        <x-library-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">Producten</x-library-nav-link>
        <x-library-nav-link :href="route('brands')" :active="request()->routeIs('brands')">Merken</x-library-nav-link>
        <x-library-nav-link :href="route('about')" :active="request()->routeIs('about')">Over de bibliotheek</x-library-nav-link>
        <x-library-nav-link :href="route('contact')" :active="request()->routeIs('contact')">Contact</x-library-nav-link>
    </div>

    <div class="flex flex-wrap items-center gap-2">
        @guest
            <x-library-nav-link :href="route('login')" :active="request()->routeIs('login')">Inloggen</x-library-nav-link>
            <x-library-nav-link :href="route('register')" :active="request()->routeIs('register')">Registreren</x-library-nav-link>
        @endguest

        @auth
            <x-library-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-library-nav-link>
            <x-library-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.*')">{{ auth()->user()->name }}</x-library-nav-link>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="inline-block rounded px-3 py-2 text-slate-200 hover:bg-slate-700">Uitloggen</button>
            </form>
        @endauth
    </div>
</nav>
