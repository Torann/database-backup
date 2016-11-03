<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Databases Backup Path Prefix
    |--------------------------------------------------------------------------
    |
    | This is used along with Laravel's filesystem for storing the backup dump
    | generated using the `db:backup` command.
    |
    */

    'prefix' => 'backups',

    /*
    |--------------------------------------------------------------------------
    | Databases Backup Path
    |--------------------------------------------------------------------------
    |
    | Use this to override the default disk in the `configs/filesystems.php`
    | config file. This is helpful for backup on a different bucket or
    | cloud service than what the system default is.
    |
    */

    'disk' => null,
];