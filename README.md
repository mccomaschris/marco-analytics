# Marco Analytics

A lightweight, self-hosted analytics package for Laravel.

## Installation

```bash
composer require mccomaschris/marco-analytics
```

## Configuration

After installing the package, you can publish the configuration file to customize tracking settings:

```bash
php artisan vendor:publish --tag=config
```

This will create a config file at:

```bash
config/marco-analytics.php
```

### Available Configuration Options
```php
return [
    // Enable or disable IP tracking
    'track_ip' => true,

    // File extensions to exclude from tracking
    'ignored_extensions' => [
        'js', 'css', 'png', 'jpg', 'jpeg', 'gif', 'svg', 'webp', 'ico', 'woff', 'woff2', 'ttf', 'eot', 'otf'
    ],

    // URL paths to exclude from tracking
    'ignored_paths' => [
        'admin/*',      // Ignore all admin routes
        'login',        // Ignore login page
        'register',     // Ignore registration page
        'password/*',   // Ignore password reset pages
        'api/*',        // Ignore all API requests
        'debugbar/*',   // Ignore Laravel Debugbar
    ],
];
```

### Customizing Excluded Paths
```php
'ignored_paths' => [
    'checkout',   // Ignore checkout page
    'profile/*',  // Ignore all profile-related routes
],
```

After making changes, clear the config cache to apply them:
```bash
php artisan config:clear
```

## Console Commands
This package includes an Artisan command to **purge old analytics data** from the database.

### Purging Old Analytics Data
By default, this command removes analytics records older than **30 days**:

```bash
php artisan analytics:purge
```

You can also specify a custom number of days:

```bash
php artisan analytics:purge 60
```

This would delete all analytics records **older than 60 days**.

### Automating Purging with Laravel Scheduler
To automatically delete old analytics records every day, add this to your `app/Console/Kernel.php`:

```php
protected function schedule(Schedule $schedule)
{
    $schedule->command('analytics:purge')->daily();
}
```
This will **run the cleanup automatically** every day.
