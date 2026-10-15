<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Gaming Products Library</title>
</head>
<body>
    <h1>Gaming Products Library</h1>
    <p>Ontdek gamingmuizen, headsets en toetsenborden van Logitech, Corsair, HyperX en Razer.</p>

    <nav aria-label="Hoofdnavigatie">
        <ul>
            <li><a href="{{ route('products.index') }}">Producten</a></li>
            <li><a href="{{ route('about') }}">Over de bibliotheek</a></li>
            <li><a href="{{ route('contact') }}">Contact</a></li>
            <li><a href="{{ route('brands') }}">Alle merken</a></li>
        </ul>
    </nav>

    <h2>Voorbeeldproducten</h2>
    <ul>
        <li><a href="{{ route('products.show', ['product' => 1]) }}">Bekijk product 1</a></li>
        <li><a href="{{ route('products.show', ['product' => 24]) }}">Bekijk product 24</a></li>
    </ul>
</body>
</html>
