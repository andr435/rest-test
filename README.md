rest-test

Rest API Test

Using Symfony4, FOSRestBundle and LexikJWTAuthenticationBundle

Instalation over Apache2:
- clone git repository
- from project root excecute: composer install.
- update file .env with correct mysql connection.
- from project root excecute: bin/console doc:mig:mig.
- rest-test.conf is example of virtual host for this project.
- from root project execute: bin/console debug:router to see all API endpoints

API


All request should be with header: Content-Type:application/json


POST /token


This API return security token that will be used to enter to other methods. 
Return token should be placed at request header under key: Authorization In the project exists 2 users:

- username: test@test.com, password: 123456
- username: admin@test.com, password: qwerty

Request example: { "username": "test@test.com", "password": 123456 }

GET /account

Return info about current user. Protected by JWT Token

GET /album Return list of all records. Protected b JWT Token

GET /album/{id}

Return data about album

POST /album

Create a new record. required fields:

title - album title

track - number of tracks in album

release_date - album release date in format "dd-MM-yyyy"

Request example:

{ "title":"bla bla", "track": 3, "release-date": "15-04-2011" }

PUT /album/{id}

Update one or many album fields

Request example:

{ "track":15 }

DELETE /album/{id}

Delete record

Known Problem

Not good reprisantation of error/exception. To fix it need to rewrite Exception handler and I think is out of view of this test. I left 
environment on dev to display unhandled exception instead of empty response with error code 500. Environment can be changed in .env file -> APP_ENV=prod

May be I forgot something in instalation proccess fill free to call me 052-6915249
