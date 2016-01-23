Laravel Settings
==============
[![Build Status](https://travis-ci.org/ionutmilica/laravel-settings.svg?branch=master)](https://travis-ci.org/ionutmilica/goose)

Laravel settings it's a composer package made for our projects that allows developers to persist settings into database or json files.

## Installation

[PHP](https://php.net) 5.4+ and [Laravel](https://laravel.com) 5.* are required.

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

## How to use it

For simple usage we provide a helper that provides all the features you need:

1.Fetching a value
```php
$canRegister = settings('restrictions.register');

if (! $canRegister) {
	// do something
}

// Fetching with default value

$canRegister = settings('restrictions.register', false);

// Fetching and save the setting if it does not exist

$canRegister = settings('restrictions.register, false, true);

```
2. Storing a new setting or editing an old one?
```php
settings()->set('my-setting', 'some-value');
```
3. Checking for a setting existence
```php
if (settings()->has('my-setting')) {
    // do something
}
```
4. Wanting to delete a not needed setting?
```php
settings()->forgot('my-setting');
```
5. Force the saving of the settings into the datastore
```php
settings()->set('the-answer', 42);
settings()->save();
```

You can also inject the settings instance into your laravel controller:

```php

use IonutMilica/LaravelSettings/SettingsContract;

class RegistrationController extends Controller {

    public function register(Request $request, SettingsContract $settings)
    {
        if ($settings->get('restrictions.registration')) {
        	return redirect()->back();
        }
    }
}
```

More examples will follow!
