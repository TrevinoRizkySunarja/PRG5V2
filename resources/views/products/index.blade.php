<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle }}</title>
</head>
<body>
    <h1>{{ $pageTitle }}</h1>
    <p>Een bibliotheek voor gamingmuizen, headsets en toetsenborden.</p>

    <h2>Merken</h2>
    <ul>
        <li>Logitech</li>
        <li>Corsair</li>
        <li>HyperX</li>
        <li>Razer</li>
    </ul>

    <h2>Productsoorten</h2>
    <ul>
        <li>Muizen</li>
        <li>Headsets</li>
        <li>Toetsenborden</li>
    </ul>
    <h2>Voorbeeldproducten</h2>
    <ul>
        <li><a href="{{ route('products.show', ['product' => 1]) }}">Bekijk product 1</a></li>
        <li><a href="{{ route('products.show', ['product' => 24]) }}">Bekijk product 24</a></li>
    </ul>
    <p><a href="{{ route('home') }}">Terug naar home</a></p>
</body>
</html>
