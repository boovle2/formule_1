# Architectuur- en beveiligingsnotities

Dit project illustreert drie belangrijke principes:

1) Bedrijfslogica en relaties in de modellayer

- `app/Models/DriverModel.php` heeft nu een `standings()`-relatie en een `refreshPoints()`-methode die de punten van de coureur opnieuw berekent op basis van de `standings`-tabel. Dit houdt de bedrijfslogica (hoe punten worden berekend) bij het model dat de gegevens beheert.
- `app/Models/RaceModel.php` heeft helpermethoden `raceResults()` en `sprintResultsGrouped()` om gerelateerde standings per sessietype op te halen.
- `app/Models/TeamModel.php` heeft een `drivers()`-relatie en `refreshPoints()` om teampunten te berekenen uit de punten van de coureurs.

2) Scheiding van verantwoordelijkheden

- Een aparte service `app/Services/PointsCalculator.php` centraliseert puntentabellen en logica. Controllers roepen deze aan in plaats van zelf de ruwe arrays/gates te bevatten.
- Form-validatie is verplaatst naar `app/Http/Requests/StoreStandingsRequest.php` en `UpdateStandingsRequest.php` zodat controllers zich op flow control kunnen richten en niet op validatiedetails.
- Autorisatie is geconcentreerd in `app/Policies/StandingPolicy.php` en geregistreerd in `AppServiceProvider` (Gate-mapping), waardoor verspreide rolchecks worden vermeden.

3) Veilige code: authenticatie, autorisatie, validatie en foutafhandeling

- FormRequests implementeren `authorize()` om te waarborgen dat alleen admins resultaten kunnen indienen.
- Controllers gebruiken `$this->authorize(...)` policy-aanroepen voor create/update/delete-acties.
- Tests in `tests/Feature/StandingsAuthorizationTest.php` verifiëren de autorisatieregels.
- Inputvalidatie zit in FormRequests en defensieve controles blijven waar nodig in controllers aanwezig.

Bestanden om te inspecteren voor details:

- `app/Services/PointsCalculator.php`
- `app/Models/DriverModel.php`
- `app/Models/TeamModel.php`
- `app/Models/RaceModel.php`
- `app/Http/Requests/StoreStandingsRequest.php`
- `app/Http/Requests/UpdateStandingsRequest.php`
- `app/Policies/StandingPolicy.php`
- `app/Http/Controllers/StandingController.php` (controller bijgewerkt om de service, FormRequests en policies te gebruiken)

Deze wijzigingen maken de codebase makkelijker te begrijpen, testen en onderhouden, en zorgen voor een duidelijke scheiding van verantwoordelijkheden terwijl de beveiliging verbetert door gecentraliseerde autorisatie en validatie.
