# Santex Challenge

[![License](https://poser.pugx.org/laravel/lumen-framework/license.svg)](https://packagist.org/packages/laravel/lumen-framework)

The goal is to make a project that exposes an API with an HTTP GET in this URI: /import-league/{leagueCode} . E.g., it must be possible to invoke the service using this URL:
http://localhost/import-league/CL

Additionally, expose an HTTP GET in URI /total-players/{leagueCode}  , with a simple JSON response like this:
{"total" : N } and HTTP Code 200.

## Server Requirements
- PHP >= 7.2
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Mysql 8.0.13

## Install
1 - Run composer 
```
 composer install
```
2 - Edit the env file

3 - Run migrations
```
 php artisan migrate
```
Optional Command.

This command is to use from the terminal because on browser sometimes depends on the webserver configuration could appear 503 service unavailable even though the script is running. 
E.g. leagueCode=CL
```
 php artisan import:league {leagueCode}
```

# REST API

The REST API to access the santex challenge task.

## Import League by League Code

### Request

`GET /import-league/{leagueCode}`

    curl -i -H 'Accept: application/json' http://localhost/import-league/PL

### Response

    HTTP/1.1 201 OK
    Date: Thu, 24 Feb 2011 12:36:30 GMT
    Status: 201 OK
    Connection: close
    Content-Type: application/json
    Content-Length: 2

    {"message": "Successfully imported"}

## Get Total Players by League Code

### Request

`GET /total-players/{leagueCode}`

    curl -i -H 'Accept: application/json' http://localhost/total-players/PL

### Response

    HTTP/1.1 200 OK
    Date: Thu, 24 Feb 2011 12:36:30 GMT
    Status: 200 OK
    Connection: close
    Content-Type: application/json
    Content-Length: 2

    {"total" : N }


## Related Tools

- [Lumen PHP Framework](https://github.com/laravel/lumen) — Lumen PHP Framework
- [FootballData](https://github.com/grambas/football-data) — football-data.org API Container for Laravel

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
