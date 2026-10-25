# Les 2 — Development Environment

Bron: [Laracasts — Laravel From Scratch 2026, aflevering 2](https://laracasts.com/series/laravel-from-scratch-2026/episodes/2)

Project: **Gaming Products Library** (Logitech, Corsair, HyperX en Razer; muizen, headsets en toetsenborden).

## Doel

Begrijpen welke tools nodig zijn om het bestaande Laravel-project lokaal in PhpStorm te ontwikkelen en te starten. Deze les bouwt nog geen catalogus, database of reviewsysteem.

## Tools in het kort

| Tool | Functie |
| --- | --- |
| PHP | Voert de Laravel-backend uit. |
| Composer | Installeert en beheert PHP-dependencies uit `composer.json` en `composer.lock`. |
| Laravel / Artisan | Het framework en de CLI voor onder andere routes en de ontwikkelserver. |
| Node.js en npm | Beheren de frontend-dependencies. |
| Vite | Bouwt en serveert frontend-assets tijdens ontwikkeling. |
| PhpStorm | De code-editor/IDE. |

Het repository bevat al een Laravel-app met `artisan`, `composer.json`, `package.json` en `routes/web.php`. Maak daarom **geen tweede Laravel-project** aan voor deze les.

## Zelf uitvoeren in PhpStorm

Open de bestaande lokale map:

`C:\Users\serve\Development\P5V2\Programmeren-5`

Controleer in de terminal:

```powershell
php -v
composer --version
node -v
npm -v
php artisan --version
php artisan route:list
```

Als dependencies nog ontbreken, installeer ze in deze projectmap:

```powershell
composer install
npm install
```

Als er nog geen lokaal `.env`-bestand bestaat:

```powershell
Copy-Item .env.example .env
php artisan key:generate
```

Gebruik in `.env` een lokale ontwikkelconfiguratie. Commit nooit `.env` met secrets. Controleer database-instellingen voordat je migraties uitvoert.

Start de Laravel-server:

```powershell
php artisan serve
```

Open in een **tweede** terminal, wanneer je frontend-assets nodig hebt:

```powershell
npm run dev
```

Open het adres dat Artisan daadwerkelijk in de terminal toont. Test bijvoorbeeld de homepage en `/products`; de bestaande routes zijn zichtbaar met `php artisan route:list`.

## Pseudocode

```text
OPEN bestaand project in PhpStorm
CHECK PHP, Composer, Node en npm
CHECK Artisan en bestaande routes
IF dependencies ontbreken:
    INSTALL dependencies
IF .env ontbreekt:
    COPY voorbeeldconfiguratie en genereer app-key
START lokale server
OPEN het getoonde adres
CHECK homepage
```

## Mondeling: wat moet je kunnen uitleggen?

1. Waarom heeft Laravel PHP en Composer nodig?
2. Wat is het verschil tussen `composer install` en `npm install`?
3. Wat doet `php artisan serve`?
4. Waarom staat `.env` normaal niet op GitHub?
5. Waarom kan een route in `route:list` staan terwijl je in je browser toch een 404 krijgt? (Bijvoorbeeld een verkeerd serveradres of project.)

## Status

Deze lesdocumentatie is in GitHub toegevoegd. **De Windows-ontwikkelomgeving is niet vanaf GitHub te controleren**: de genoemde terminalcommando's en browsertests moeten nog op de eigen computer worden uitgevoerd. Er zijn geen bestaande Laravel-bestanden of dependency-versies gewijzigd.

Volgende Laracasts-aflevering: **3 — Routing 101**. Het repository bevat hiervoor al werk en een `LES3.md`; controleer dat voordat je verder bouwt.
