# Heyrecruit Templates

A collection of public Heyrecruit templates implementing the REST API with PHP.
To use this code, you need an account at www.heyrecruit.de.
Heyrecruit is a top-level recruitment management software.


## System requirements:
- HTTP Server. For example, Apache. Having mod_rewrite is preferred.
- PHP 8.0 or greater.

## Installation and configuration

### Download or checkout

You can either download the ZIP file:

https://github.com/Heyrecruit/rest-templates/archive/refs/heads/master.zip

or check out the code:

```
https://github.com/Heyrecruit/rest-templates.git
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

