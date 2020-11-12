# SCOPE Recruiting Templates

A collection of public SCOPE Recruiting templates implementing the REST API with PHP.
To use this code you need an account at www.scope-recruiting.de.
Scope-Recruiting is a top-level recruitment management software.


## System requirements:
- HTTP Server. For example: Apache. Having mod_rewrite is preferred.
- PHP 7.0 or greater (including PHP 7.2).

## Installation and configuration

### Download or checkout

You can either download the ZIP file:

https://github.com/SCOPE-Recruiting/rest-templates.git

or checkout the code:

```
https://github.com/SCOPE-Recruiting/rest-templates.git
```

### Run composer

1. Download [Composer](https://getcomposer.org/doc/00-intro.md) or update `composer self-update`.
2. Run `php composer.phar install`.

If Composer is installed globally, run

```bash
composer install
```

### Configuration

Rename `.env.example` to `.env` and set `BASE_PATH`, `CLIENT_ID` and `CLIENT_SECRET`. 

