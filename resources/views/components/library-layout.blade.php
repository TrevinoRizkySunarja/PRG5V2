@props(['title' => 'Gaming Products Library'])

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 font-sans text-slate-900 [&_a:focus-visible]:outline [&_a:focus-visible]:outline-2 [&_a:focus-visible]:outline-offset-4 [&_a:focus-visible]:outline-sky-500 [&_button:focus-visible]:outline [&_button:focus-visible]:outline-2 [&_button:focus-visible]:outline-offset-4 [&_button:focus-visible]:outline-sky-500">
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-2 focus:z-10 focus:bg-white focus:p-3">Ga naar de inhoud</a>
    <header class="bg-slate-900 py-6 text-slate-50">
        <div class="mx-auto max-w-6xl px-4">
            <a class="mb-4 inline-block text-2xl font-bold" href="{{ route('home') }}">Gaming Products Library</a>
            @include('partials.library-navigation')
        </div>
    </header>

    <main id="main-content" class="mx-4 mt-8 max-w-6xl rounded-lg bg-white p-4 sm:p-8 xl:mx-auto [&_h1]:mb-4 [&_h1]:text-3xl [&_h1]:font-bold [&_h2]:mb-2 [&_h2]:text-xl [&_h2]:font-bold [&>h2]:mt-6 [&_p]:my-3 [&_p]:leading-relaxed [&_ul]:list-disc [&_ul]:pl-6 [&_li]:my-2 [&_a]:text-sky-800 [&_a]:underline [&_a]:underline-offset-4">
        {{ $slot }}
    </main>

    <footer class="mx-auto max-w-6xl px-4 py-6 text-sm text-slate-600">
        Gaming Products Library · Logitech, Corsair, HyperX en Razer
    </footer>
</body>
</html>
