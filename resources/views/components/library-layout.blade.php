@props(['title' => 'Gaming Products Library'])

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="library-body">
    <a href="#main-content" class="library-skip-link">Ga naar de inhoud</a>
    <header class="library-header">
        <div class="library-container">
            <a class="library-brand" href="{{ route('home') }}">Gaming Products Library</a>
            @include('partials.library-navigation')
        </div>
    </header>

    <main id="main-content" class="library-container library-content">
        {{ $slot }}
    </main>

    <footer class="library-container library-footer">
        Gaming Products Library · Logitech, Corsair, HyperX en Razer
    </footer>
</body>
</html>
