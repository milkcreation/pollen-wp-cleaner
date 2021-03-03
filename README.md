# Wordpress Configurator Component

[![Latest Version](https://img.shields.io/badge/release-1.0.0-blue?style=for-the-badge)](https://www.presstify.com/pollen-solutions/wp-config/)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-green?style=for-the-badge)](LICENSE.md)

## Installation

```bash
composer require pollen-solutions/wp-config
```

## Pollen Framework Setup

### Declaration

```php
// config/app.php
return [
      //...
      'providers' => [
          //...
          \Pollen\WpConfig\WpConfigServiceProvider::class,
          //...
      ];
      // ...
];
```

### Configuration

```php
// config/wp-config.php
// @see /vendor/pollen-solutions/wp-config/resources/config/wp-config.php
return [
      //...

      // ...
];
```
