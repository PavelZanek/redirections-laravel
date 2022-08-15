<?php

return [

    /*
    *   Number of days after which records are deleted from the database.
    *   Redirects with at least one use.
    */
    'days_removing_unused_records' => 14,

    /*
    *   Number of days after which records are deleted from the database.
    *   Redirects without use.
    */
    'days_removing_unused_records_only_created' => 14,

    /*
    *   Specify route prefix for redirections tool
    */
    'route_prefix' => 'redirections',

    /*
    *   Specify route middleware for redirections tool
    */
    'route_middleware' => ['web'],

    /*
    *   Specify CSS framework
    */
    'css_framework' => 'tailwind',
];