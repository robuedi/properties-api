# Properties API

<a href="https://github.com/robuedi/properties-api/actions"><img src="https://github.com/robuedi/properties-api/actions/workflows/tests.yml/badge.svg" alt="Build Status"></a>
<a href="https://github.com/robuedi/properties-api/actions"><img src="https://github.com/robuedi/properties-api/actions/workflows/lint.yml/badge.svg" alt="Lint"></a>


This project is the backend API for a properties renting app

## Setup

1. Clone repo + composer install vendors
2. Install Laravel Sail + in terminal in repo base `sail up -d`
3. Prepare the DB with: `sail artisan migrate:fresh` + ` sail artisan db:seed` + `sail artisan db:seed --class=FakerSeeder`

## API Endpoints Docs

Your local API Docs URL [here](http://localhost/docs/api#/)
![Properties API](/readme/api-docs.png)

## Test cases

![Properties API](/readme/testcases.png)

## DB - ER Diagram

Your local DB - ER Diagram URL [here](http://localhost/erd)
![ER Diagram](/readme/er-diagram.png)

## License

Copyright (C) Eduard Cristian Robu - All Rights Reserved
Written by Eduard Cristian Robu <robu.edi.office at gmail.com>, 2024
