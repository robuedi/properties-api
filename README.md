# Properties API

<a href="https://github.com/robuedi/properties-api/actions"><img src="https://github.com/robuedi/properties-api/actions/workflows/tests.yml/badge.svg" alt="Build Status"></a>
<a href="https://github.com/robuedi/properties-api/actions"><img src="https://github.com/robuedi/properties-api/actions/workflows/lint.yml/badge.svg" alt="Lint"></a>


This project is the backend API for a properties renting app

## Project's objectives:
- make use of Scramble library to automatically generate the API documentation (more info about Scramble <a target="_blank" href="https://scramble.dedoc.co/">here</a>)
- combine Spatie Query Builder library with the Scramble library (more info about Spatie Query Builder <a target="_blank" href="https://spatie.be/docs/laravel-query-builder/">here</a>)
- make use of stateless JWT authentication (more info about JWT <a target="_blank" href="https://medium.com/@extio/understanding-json-web-tokens-jwt-a-secure-approach-to-web-authentication-f551e8d66deb">here</a>)

## Setup

1. Clone repo + composer install vendors
2. Install Laravel Sail + in terminal in repo base `sail up -d`
3. Prepare the DB with: `sail artisan migrate:fresh` + ` sail artisan db:seed` and fake data for demo with `sail artisan db:seed --class=FakerSeeder`

## API Endpoints Docs

Your local API Docs URL [here](http://localhost/docs/api#/)
![Properties API](/readme/docs.png)

## Test cases

![Properties API](/readme/tests.png)

## License

Copyright (C) Eduard Cristian Robu - All Rights Reserved
Written by Eduard Cristian Robu <robu.edi.office at gmail.com>, 2024
