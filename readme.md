These front and back end apps allow the user to add airports and related airport services.
Opening hours can be added for each airport service.
Airport services at a specific airport, opening during a specific time period can be searched for.

As an extra feature...
Airport services can be linked to the company provided, by providing a valid Companies House - Company number
using:
https://developer.companieshouse.gov.uk/api/docs/company/company_number/company_number.html


Laravel Backend
https://github.com/mattbeyer81/airports

app/Http/Controllers/AirportController.php
app/Http/Controllers/OpeningHourController.php
app/Http/Controllers/ServiceController.php

app/Airport.php
app/OpeningHour.php
app/Service.php

routes/api.php

database/migrations

AngularJS Front End
https://github.com/mattbeyer81/airport-admin

Airports-Admin was built using third-party AngularJS Admin:
https://github.com/akveo/blur-admin
https://akveo.github.io/blur-admin/

Airports-Admin has added these folders/files to Blur-Admin:

src/app/pages/airports
src/app/pages/services
src/app/theme/services/airport.js
src/app/theme/services/airportService.js

To run https://github.com/mattbeyer81/airports
php artisan migrate;
add COMPANIES_HOUSE_KEY
This can be provided on request from Author - M.Beyer

To run Airports-Admin locally:

add your localhost to src/app/app.js
e.g var url = 'http://localhost';

cd blur-admin
npm install
gulp serve

For more info, follow https://akveo.github.io/blur-admin/articles/002-installation-guidelines

Known Issues

Airports with same name and code can be created.
Page does not scroll up to view create/edit forms
Opening hours dates appear blank by default when creating/editing
Clearing search does not set search form as pristine.
Companies House API Key is visible in public repo.
