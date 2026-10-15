<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product {{ $productId }} | Gaming Products Library</title>
</head>
<body>
    <h1>Product {{ $productId }}</h1>
    <p>Productgegevens worden later toegevoegd.</p>
    <p><a href="{{ route('products.index') }}">Alle producten</a></p>
    <p><a href="{{ route('home') }}">Terug naar home</a></p>
</body>
</html>
