Laravel Settings
==============

Laravel settings it's a composer package made for our projects that allows developers to persist settings into database or json files.
Documentation and tests still need to be added.

## Installation

[PHP](https://php.net) 5.4+ and [Laravel](https://laravel.com) are required.

To get the latest version of Laravel Settings run the following command:

```
composer require ionutmilica/laravel-settings
```

Once Laravel Settings is installed, you need to register the service provider. Open up `config/app.php` and add the following to the `providers` key.

* `'IonutMilica\LaravelSettings\SettingsServiceProvider'`

You can register the Settings facade in the `aliases` key of your `config/app.php` file if you like.

* `'Settings' => 'IonutMilica\LaravelSettings\Facade'`

If you want to have persistent settings, you will need to add a new middleware in `app/Http/Kernel.php` to the `middleware` key.

* `'IonutMilica\LaravelSettings\SavableMiddleware',`

Laravel settings default driver is set to json. If you want to change it you can execute `artisan vendor:publish` command and then modify `app/config/settings.php` file.

If you chose database driver you should also migrate the database with `php artisan migrate`.