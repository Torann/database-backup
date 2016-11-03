# Database Backup

[![Latest Stable Version](https://poser.pugx.org/torann/database-backup/v/stable.png)](https://packagist.org/packages/torann/database-backup)
[![Total Downloads](https://poser.pugx.org/torann/database-backup/downloads.png)](https://packagist.org/packages/torann/database-backup)
[![Patreon donate button](https://img.shields.io/badge/patreon-donate-yellow.svg)](https://www.patreon.com/torann)
[![Donate weekly to this project using Gratipay](https://img.shields.io/badge/gratipay-donate-yellow.svg)](https://gratipay.com/~torann)
[![Donate to this project using Flattr](https://img.shields.io/badge/flattr-donate-yellow.svg)](https://flattr.com/profile/torann)
[![Donate to this project using Paypal](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=4CJA2A97NPYVU)

Uncomplicated database backup package for Laravel 5.

## Installation

### Composer

From the command line run:

```
$ composer require torann/database-backup
```

### Laravel

Once installed you need to register the service provider with the application. Open up `config/app.php` and find the `providers` key.

``` php
'providers' => [

    Torann\DatabaseBackup\DatabaseBackupServiceProvider::class,

]
```

### Lumen

For Lumen register the service provider in `bootstrap/app.php`.

``` php
$app->register(Torann\DatabaseBackup\DatabaseBackupServiceProvider::class);
```

### Publish the configurations

Run this on the command line from the root of your project:

```
$ php artisan vendor:publish --provider="Torann\DatabaseBackup\DatabaseBackupServiceProvider" --tag=config
```

A configuration file will be publish to `config/database-backups.php`.

## Commands

### `php artisan db:backup`

Dump the default database.

## Change Log

#### v0.1.0

- First release