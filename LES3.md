# Les 3: routes en controllers

Bron: les3-routing-controllers en Oefening data meegeven en resource routes uit de les-3-ZIP.
Deze uitwerking is met AI-hulp gemaakt. Bewaar de chat, controleer de code en beschrijf je eigen bijdrage eerlijk.

## 1. Openen en testen in PhpStorm

Open C:\Users\serve\Development\P5V2\Programmeren-5.
Start in de terminal `php artisan serve` en houd deze terminal open.
Gebruik het adres dat de terminal toont, meestal http://127.0.0.1:8000.

| Adres | Verwacht resultaat |
| --- | --- |
| / | Eigen homepagina met links |
| /home | Doorverwijzing naar / |
| /contact | Contactinformatie van het studieproject |
| /about-us | Titel met de company-variabele uit PageController |
| /products | Productpagina met pageTitle uit ProductController |
| /products/1 | Product 1 |
| /products/24 | Product 24 |
| /brands | Alle merken: standaardwaarde voor optionele parameter |
| /brands/Logitech | Logitech: waarde uit de URL |
| /brands/Razer | Razer: andere waarde uit dezelfde route |

Er is nog geen productdatabase: het ID en de merknaam worden alleen doorgegeven en getoond.
De merkpagina zoekt of filtert nog geen producten. Een willekeurige merknaam wordt ook getoond.
De bestaande Laravel-welkomstpagina blijft beschikbaar op /welcome.

## 2. Wat doet welk bestand?

- routes/web.php koppelt een HTTP-methode en URL aan een controlleractie.
- PageController handelt home, over ons, contact en de optionele merknaam af.
- ProductController is nu een resourcecontroller met zeven standaardmethoden.
- resources/views bevat de HTML-pagina's met de extensie .blade.php.
- `view('products.show', ['productId' => $product])` zoekt products/show.blade.php op en geeft data mee.
- `{{ $productId }}` toont die waarde met HTML-escaping. Gebruik geen ongefilterde HTML-uitvoer voor URL-invoer.

Lees de code van de route /products/24 naar ProductController::show en daarna naar de view.
Leg uit waarom het routeveld `{product}` en de methodeparameter `$product` bij elkaar horen.
Een eigen model, databasequery, formulier, review of inlogsysteem toevoegen hoort niet bij deze oefening.
De bestaande Breeze-bestanden zijn behouden.

## 3. Named route en URL wijzigen

De homepagina gebruikt `route('products.show', ['product' => 24])`.
`products.show` is de routenaam; `products` in de URL is het pad.
`Route::resource('products', ProductController::class)` maakt de namen automatisch aan.

Probeer zelf in routes/web.php tijdelijk:

```php
Route::resource('catalogus', ProductController::class)
    ->parameters(['catalogus' => 'product'])
    ->names('products');
```

Vervang hiervoor de bestaande resource-regel; voeg geen tweede resource-regel toe.
Vernieuw home en klik opnieuw op product 24. De link wordt /catalogus/24 zonder de view te wijzigen.
De expliciete namen en parameter behouden de koppeling met de bestaande links en controller.
Het oude pad /products/24 is in deze proef niet meer geregistreerd en geeft dan 404.
Zet na je proef de oorspronkelijke resource-regel terug.

## 4. Optionele parameter

`/brands/{brand?}` accepteert een URL met of zonder merknaam.
`brands(string $brand = 'Alle merken')` levert de standaardwaarde als de parameter ontbreekt.
Bezoek beide varianten en verklaar zowel het vraagteken als de standaardwaarde.

## 5. HTTP-methoden en resource routes

| Methode en pad | Controlleractie | Routenaam | Doel |
| --- | --- | --- | --- |
| GET /products | index | products.index | Overzicht tonen |
| GET /products/create | create | products.create | Aanmaakformulier tonen |
| POST /products | store | products.store | Nieuw product opslaan |
| GET /products/{product} | show | products.show | Een product tonen |
| GET /products/{product}/edit | edit | products.edit | Bewerkformulier tonen |
| PUT/PATCH /products/{product} | update | products.update | Product bijwerken |
| DELETE /products/{product} | destroy | products.destroy | Product verwijderen |

GET haalt op; POST verstuurt nieuwe gegevens; PUT vervangt en PATCH wijzigt gedeeltelijk; DELETE verwijdert.
HEAD vraagt alleen de headers op; OPTIONS vraagt welke communicatie wordt ondersteund.
Laravel ondersteunt ook `match` voor enkele methoden en `any` voor alle methoden.
Een browseradres openen doet een GET, dus daarmee roep je geen store, update of destroy aan.

Alle zeven resource-acties bestaan, maar alleen index en show zijn uitgewerkt.
De andere acties geven bewust HTTP 501 (nog niet geimplementeerd), zonder opslag of wijziging.
Een onbeschermde schrijfactie uitproberen kan eerst HTTP 419 door CSRF-beveiliging geven.
Zet CSRF niet uit. Formulieren en beveiligde opslag komen in latere lessen.

Open een tweede terminal en voer `php artisan route:list --path=products` uit.
Herken de zeven acties; GET-routes ondersteunen ook HEAD en update ondersteunt PUT en PATCH.
De oude oefenroute POST /tests staat in commentaar: TestController bestaat niet en blokkeerde route:list.

## 6. Zelf oefenen en uitleggen bij het mondeling

1. Volg een klik van home via de route naar de controller en de view.
2. Verander company in PageController en bekijk het resultaat op /about-us.
3. Verander het product-ID in de URL. Waarom verandert de titel zonder extra route?
4. Voer de named-route-proef uit en leg uit waarom de link blijft werken.
5. Test de merkroute met en zonder parameter.
6. Leg uit waarom de resource-regel routes registreert maar nog geen database of CRUD-opslag maakt.
7. Leg uit waarom de route /products/create naar create gaat en niet naar show met ID create.

Bij les 3 noemt de presentatie ook user stories, ERD en planning als voorbereiding op de volgende les.
Die moeten nog door jou worden uitgewerkt; deze code rondt dat planningswerk niet af.

## 7. Eigen voortgang vastleggen

Bekijk eerst `git status` en `git diff` of gebruik het Commit-venster in PhpStorm.
Les 1 was bij de start van deze stap nog niet gecommit; de huidige wijzigingen bevatten dus les 1 en les 3.
Maak geen verzonnen historie of eerdere datums. Je kunt zelf per bestand of wijzigingsdeel stagen als je inhoudelijk wilt splitsen.
Commit pas nadat je de code hebt gelezen, getest en begrepen. Er is door de assistent niets gecommit of gepusht.
