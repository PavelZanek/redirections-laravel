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
4. [ Events ](#events)
6. [ Todos ](#todos)
7. [ Testing ](#testing)
8. [ Security ](#security)
9. [ Chnagelog ](#changelog)
10. [ License ](#license)

<a name="howItWorks"></a>
## How it works

You can manage redirects in your Laravel application. Once installed, you can create, edit, and delete redirects without the need to install additional packages.

There is a lot of consideration for application performance. The tool caches the redirect information, specifically the source url. With each request to the server, the middleware will run, which will determine whether the requested url address is not listed in the cache. If it is found here, a query will be made to the database, which will find the target url address. Meanwhile, an event is dispatched and the associated queued event listener takes care of storing the additional redirection information.

Don't forget to run `php artisan queue:work`, `php artisan horizon` or something else what you use.

It may happen that the redirection will be unused over time, or completely unused - and records will also remain in the database. For these cases, you can schedule a command that will automatically take care of cleaning the database from unused records.

Furthermore, the tool includes functions such as easy import and export of redirects, graphs of the usability of redirects, etc.

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

If you want to change design of the app, you can generate views. The tool contains several pre-made templates for different CSS frameworks. Now available:

- Bootstrap 4
- Bootstrap 5
- Tailwind CSS

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

## Events

If someone uses a redirect (that is, goes to the source URL), the `RedirectWasUsedEvent` event is fired. So you can hook your own listener if needed.

|  **Name**            |                     **Class**                              |
|:--------------------:|:----------------------------------------------------------:|
| RedirectWasUsedEvent | PavelZanek\RedirectionsLaravel\Events\RedirectWasUsedEvent |

```php
Event::listen(\PavelZanek\RedirectionsLaravel\Events\RedirectWasUsedEvent::class, function ($event) {
    dd($event->redirect);
});
```

<a name="todos"></a>
## Todos

- ✅ Publish the package
- ✅ List of redirects - fulltext
- ✅ List of redirects - pagination
- ✅ Disable editing Source URL
- ✅ Factory
- ✅ Add more tests
- ✅ Import / Export redirects
- ✅ Toasts / Flash Messages
- ⬜️ Regex Support
- ✅ Bootstrap 5 CSS Support
- ✅ Tailwind CSS Support
- ⬜️ More info about redirects (referer, ...)

<a name="testing"></a>
## Testing

The tool includes several tests for easier scalability.

<a name="security"></a>
## Security

If you've found a bug regarding security please mail [zanek.pavel@gmail.com](mailto:zanek.pavel@gmail.com) instead of using the issue tracker.

<a name="changelog"></a>
## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

<a name="license"></a>
## License

Copyright (c) [Pavel Zaněk](https://pavelzanek.cz/). MIT Licensed, see [LICENSE](LICENSE.md) for details.