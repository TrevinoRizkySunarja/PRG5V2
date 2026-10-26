# Gaming Products Library

Laravel-project voor een bibliotheek met gamingmuizen, headsets en toetsenborden.
De bestaande Breeze-authenticatie verzorgt registratie, login en profielbeheer.

## Lokaal starten

Vereist: PHP 8.4 of hoger voor de vastgelegde ontwikkeldependencies, Composer en Node.js.

```sh
composer install
npm ci
```

Kopieer `.env.example` naar `.env` als je nog geen `.env` hebt. Bewaar bestaande instellingen.

```sh
php artisan key:generate
php artisan migrate
npm run build
php artisan serve
```

Open het adres dat Artisan toont. Bij gebruik van Herd open je het eigen `.test`-adres.
Voor het aanpassen van CSS/JavaScript kun je `npm run dev` gebruiken.

## Controleren

```sh
php artisan test
npm run build
php artisan route:list
```

Tests gebruiken een aparte SQLite-database in het geheugen. `.env`, `vendor`, `node_modules`
en lokale databasebestanden horen niet in Git.

## Projectkeuzes en planning

- Als bezoeker wil ik gamingproducten bekijken en een detailpagina openen.
- Als bezoeker wil ik op tekst zoeken en op merk/productsoort filteren om passende producten te vinden.
- Als gebruiker wil ik inloggen en mijn eigen profiel beheren via Breeze.
- Vervolg: als eigenaar wil ik mijn producten beheren; als gebruiker wil ik reviews plaatsen.

Les 1-2: eigen pagina's en MVC. Les 3: routes en controllers. Les 4: gedeelde layout,
partials en componenten. Les 5: productschema, Eloquent en databasegegevens tonen.
Relaties, eigenaarschap, reviews, rollen en aanvullende eindopdrachtregels zijn vervolgwerk
voor de latere lessen; deze planning is geen claim dat die onderdelen al af zijn.
