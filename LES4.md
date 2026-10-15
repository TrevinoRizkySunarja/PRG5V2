# Les 4: layouts, partials en Blade-componenten

Gebaseerd op Components.html en de presentatie les4-layouts-templates uit de les-4-ZIP.
De uitwerking is met AI-hulp gemaakt; bewaar de chat en werk de oefeningen zelf door.

## Starten met Herd

Open https://programmeren-5.test en start in de PhpStorm-terminal `npm run dev`.
Herd voert PHP uit; Vite verwerkt CSS en JavaScript en vernieuwt tijdens ontwikkeling.
`composer run dev` start daarnaast de PHP-ontwikkelserver en een queue-worker. Gebruik een van deze twee manieren; start niet beide tegelijk.
Bij dit project is HerdHelper hersteld: deze Windows-dienst koppelt lokale .test-adressen aan je computer.
De instellingen van je Laravel-project hoefden daarvoor niet te veranderen.

## Wat is er veranderd?

Eerst had elke pagina een eigen html-, head- en body-element. Nu staat die gezamenlijke structuur in:
`resources/views/components/library-layout.blade.php`.

Een pagina gebruikt bijvoorbeeld:

```blade
<x-library-layout title="Contact | Gaming Products Library">
    <h1>Contact</h1>
    <p>De inhoud van deze pagina.</p>
</x-library-layout>
```

De inhoud tussen de componenttags komt in `{{ $slot }}` terecht.
De paginatitel is een prop. `@props(['title' => 'Gaming Products Library'])` stelt ook een standaardwaarde in.
Als je een PHP-variabele doorgeeft, gebruik je een dubbele punt:

```blade
<x-library-layout :title="$pageTitle">
```

Zonder dubbele punt zou `$pageTitle` als letterlijke tekst worden doorgegeven.
De controller kiest nog steeds de view en levert de gegevens; de layout verandert deze taak niet.

## Partial en linkcomponent

De layout voegt `partials/library-navigation.blade.php` toe met:

```blade
@include('partials.library-navigation')
```

Een partial is een herbruikbaar stukje view. De navigatie staat daardoor op alle library-pagina's.
Binnen die partial gebruiken we voor iedere link `x-library-nav-link`.
Deze component gebruikt drie begrippen:

- `@props(['active' => false])`: een eigen instelling met standaardwaarde.
- `$attributes`: overige HTML-attributen, bijvoorbeeld href en extra classes.
- `$slot`: de tekst tussen de tags, bijvoorbeeld Producten.

```blade
<x-library-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
    Producten
</x-library-nav-link>
```

`request()->routeIs('products.*')` geeft true voor products.index en products.show.
De dubbele punt zorgt dat active een PHP-boolean ontvangt.
De actieve link krijgt een andere achtergrond en aria-current="page".
De component gebruikt merge om de standaard-CSS-class met meegegeven attributen te combineren.

De bestaande component navigation.blade.php geeft nu door aan de nieuwe layout.
Daardoor verschijnen ook de inhoud van dashboard en test, die eerder door een ontbrekend slot wegviel.
De bestaande Breeze-layouts voor inloggen, registreren en profiel zijn behouden.

## Gasten en ingelogde gebruikers

`@guest` toont Inloggen en Registreren. `@auth` toont Dashboard, de gebruikersnaam en Uitloggen.
Op home verschijnt Jouw account alleen als je bent ingelogd.
Uitloggen verstuurt een POST-formulier met `@csrf`, zoals de bestaande Breeze-route verwacht.

Verbergen in een view beveiligt een URL niet. Daarom heeft de dashboardroute nu auth-middleware.
Een gast die /dashboard rechtstreeks bezoekt, wordt naar login gestuurd.
De profielroute had deze middleware al. Er is geen nieuw inlogsysteem gebouwd.

## Een lijst vanuit de controller

ProductController::index() geeft nu brands en categories als arrays door.
De productenview gebruikt:

```blade
@foreach ($brands as $brand)
    <li>{{ $brand }}</li>
@endforeach
```

Blade herhaalt de HTML voor elke waarde. De gegevens komen nog uit een PHP-array, niet uit een database.
De merklinks verwijzen nog naar de optionele merkparameter uit les 3; er is nog geen productfilter.

## Zelf testen in de browser

1. Open home, producten, merken, over de bibliotheek en contact. Controleer dat het menu overal gelijk is.
2. Open /products/24. Producten moet actief blijven, omdat de route products.show heet.
3. Wijzig tijdelijk de tekst van Contact in de navigatiepartial. Controleer meerdere pagina's en zet de tekst terug.
4. Wijzig een paginatitel en controleer het browsertabblad. Leg uit waarom de h1 niet automatisch verandert.
5. Voeg tijdelijk een merk toe aan de array in ProductController. Controleer of een extra lijstitem verschijnt en draai de oefenwijziging terug.
6. Test als gast: Inloggen en Registreren zijn zichtbaar; /dashboard verwijst naar login.
7. Log in met je eigen testaccount: je naam, Dashboard, Uitloggen en Jouw account verschijnen.
8. Klik op Uitloggen en controleer dat de gastnavigatie terugkomt.
9. Open /test: de tekst Test Page moet nu zichtbaar zijn binnen dezelfde layout.

## Debuggen oefenen

Zet tijdelijk `dump($brands);` in index(), nadat brands is aangemaakt. De waarde wordt getoond en de uitvoering gaat door.
Gebruik daarna `dd($brands);`: de waarde wordt getoond en de uitvoering stopt, dus je view verschijnt niet.
Verwijder debugregels na de oefening; er staan geen dump/dd-regels in de definitieve uitwerking.

## Mondeling kunnen uitleggen

- Waarom staat het HTML-skelet op een centrale plek?
- Waar belandt de inhoud tussen de x-library-layout-tags?
- Wat is het verschil tussen een prop, een attribuut en een slot?
- Waarom staat er een dubbele punt voor title, href en active wanneer je PHP gebruikt?
- Waarom is Producten ook op een detailpagina actief?
- Wat doet foreach en waar komen de gegevens vandaan?
- Waarom zijn auth-middleware en @auth niet hetzelfde?
- Waarom gebruikt uitloggen POST met een CSRF-token?

Bekijk je wijzigingen in PhpStorm en test ze zelf voordat je commit. Er is niets gecommit of gepusht door de assistent.
Database, migrations, reviews en CRUD-opslag zijn nog niet toegevoegd.
