# Gaming Products Library

Laravel-project voor een bibliotheek met gamingmuizen, headsets en toetsenborden.
De bestaande Breeze-authenticatie verzorgt registratie, login en profielbeheer.
De vormgeving gebruikt Tailwind-utilities in Blade-componenten; `app.css` bevat alleen
de drie Tailwind-directives.

## Versienummers en commits

De huidige versie staat in `VERSION`. De startversie voor deze afspraak is **V.2.0.0**.
Iedere volgende commit werkt `VERSION` bij en begint met `V.<versie>`, gevolgd door
een korte Nederlandse beschrijving, bijvoorbeeld `V.2.0.1 - Verbeter het zoekformulier`.

Kies de verhoging op basis van de inhoud en omvang van de wijziging:

- Klein: een beperkte fix of aanpassing, bijvoorbeeld `2.0.0` naar `2.0.1`.
- Middelgroot: een nieuwe functie of duidelijke uitbreiding, bijvoorbeeld `2.0.1` naar `2.1.0`.
- Groot: een omvangrijke uitbreiding of herwerking met meerdere toegevoegde en gewijzigde
  bestanden, bijvoorbeeld `2.1.0` naar `3.0.0`.

Bij een verhoging van het middelste getal wordt het laatste getal nul. Bij een verhoging
van het eerste getal worden beide overige getallen nul. Beoordeel de samenhang en omvang
van de code; alleen het aantal bestanden bepaalt niet de versie. Deze projectafspraak
baseert de versie op wijzigingsomvang en vereist geen brekende wijziging voor een hoofdversie.
Pas bestaande gepushte commits niet achteraf aan om ze te hernummeren.

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

## Catalogus vullen

```sh
php artisan migrate --seed
```

Dit voegt twaalf demo-producten toe. Opnieuw seeden maakt geen duplicaten en overschrijft
geen aangepaste producten of bestaande gebruikers. Registreer zelf een account via Breeze.
De bedragen zijn demonstratiedata, geen actuele winkelprijzen.

De catalogus ondersteunt zoeken in titel en beschrijving, gecombineerde merk- en
productsoortfilters, paginering en detailpagina's met een 404 bij een ontbrekend product.
De zeven resource-routes bestaan; aanmaken, bewerken en verwijderen via formulieren zijn
nog niet uitgewerkt en geven voorlopig HTTP 501. De publieke interface biedt deze acties niet aan.

Als CSS ontbreekt na het stoppen van Vite: verwijder het verouderde `public/hot`-bestand
en voer `npm run build` uit. Tijdens ontwikkeling maakt `npm run dev` dit bestand opnieuw.

## Datamodel na les 5

```mermaid
erDiagram
    products {
        bigint id PK
        varchar title "max 100"
        text description
        varchar brand "max 50, index"
        varchar category "max 50, index"
        decimal price "10,2"
        timestamp created_at
        timestamp updated_at
    }
    users {
        bigint id PK
        varchar name
        varchar email UK
        timestamp email_verified_at "nullable"
        varchar password "hash"
        varchar remember_token "nullable"
        timestamp created_at
        timestamp updated_at
    }
```

Dit toont de twee domeintabellen die nu bestaan; er is nog geen relatie tussen users en
products. Brand en category zijn in deze fase tekstvelden. De combinatie brand + title
is uniek. Laravel-tabellen voor sessies, wachtwoordherstel, cache en queues zijn hier weggelaten.
Normalisatie van merken/productsoorten, eigenaarschap en reviews horen bij het vervolg.
