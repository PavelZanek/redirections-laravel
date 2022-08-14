# Redirections for Laravel

Manage your redirects easily. This package provides an easy way to integrate a redirection tool to your Laravel application.

1. [ How it works ](#howItWorks)
2. [ Installations ](#installations)
    - [ Migrations ](#migrations)
    - [ Config ](#config)
3. [ Optional ](#optional)
    - [ Views ](#views)
    - [ Translations ](#translations)
4. [ Pruning Table ](#pruningTable)
5. [ Todos ](#todos)
6. [ License ](#license)

<a name="howItWorks"></a>
## How it works

You can manage redirects in your Laravel application. After installation you can create, edit and remove redirects.



<a name="installations"></a>
## Installations

Source URLs are cached. Check if your project has `cache settings` configured. You can use from several prepared drivers (file, Redis, ...). Package also requires `PHP 8.1` at least.

<a name="migrations"></a>
### Migrations

First of all, generate and customize migration files. It can be useful, if you want to add someting (for example - some realationships).

```
php artisan vendor:publish --tag=redirections-migrations
```

<a name="config"></a>
### Config file

```
php artisan vendor:publish --tag=redirections-config
```

<a name="optional"></a>
## Optional

<a name="views"></a>
### Views

If you want to change design of the app, you can generate views.

```
php artisan vendor:publish --tag=redirections-views
```

<a name="translations"></a>
### Translations

Also you can generate translations files.

```
php artisan vendor:publish --tag=redirections-translations
```

<a name="pruningTable"></a>
## Pruning table with redirects

You can prune your table with redirects. There is the command for do that:

```
php artisan redirections:prune-database
```

Alternatively you can schedule this command in your kernel file (app/Console/Kernel.php):

```
protected function schedule(Schedule $schedule)
{
    $schedule->command('redirections:prune')->dailyAt('8:00');
}
```

<a name="todos"></a>
## Todos

- ✅ Publish the package
- ⬜️ List of redirects - fulltext
- ⬜️ List of redirects - pagination
- ⬜️ Add more tests
- ⬜️ Seeder / Factory
- ⬜️ Import / Export redirects
- ⬜️ Toasts / Flash Messages
- ⬜️ Regex Support
- ⬜️ Bootstrap 5 CSS Support
- ⬜️ Tailwind CSS Support
- ⬜️ More info about redirects (referer, ...)

<a name="license"></a>
## License

Copyright (c) [Pavel Zaněk](https://pavelzanek.cz/). MIT Licensed, see [LICENSE](LICENSE.md) for details.