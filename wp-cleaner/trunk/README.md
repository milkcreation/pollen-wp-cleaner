# Pollen Wordpress Cleaner Component

[![Latest Version](https://img.shields.io/badge/release-1.0.0-blue?style=for-the-badge)](https://www.presstify.com/pollen-solutions/wp-cleaner/)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-green?style=for-the-badge)](LICENSE.md)

## Installation

```bash
composer require pollen-solutions/wp-cleaner
```

## Pollen Framework Setup

### Declaration

```php
// config/app.php

use Pollen\WpCleaner\WpCleanerServiceProvider;

return [
      //...
      'providers' => [
          //...
          WpCleanerServiceProvider::class,
          //...
      ]
      // ...
];
```

### Configuration

```php
// config/wp-cleaner.php
// @see /vendor/pollen-solutions/wp-cleaner/resources/config/wp-cleaner.php
return [
      //...

      // ...
];
```
