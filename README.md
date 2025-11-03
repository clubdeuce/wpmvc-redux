# wpmvc-redux

A base library for WordPress application development following PSR-4 autoloading standards.

## Installation

Install via Composer:

```bash
composer require clubdeuce/wpmvc-redux
```

## Usage

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Clubdeuce\Wpmvc_Redux\Application;

$app = new Application();
echo $app->getVersion();
```

## Development

### Install Dependencies

```bash
composer install
```

### Run Tests

```bash
./vendor/bin/phpunit
```

### Static Analysis (PHPStan)

Install dev dependencies (first time):

```bash
composer install
```

Run PHPStan:

```bash
composer phpstan
```

Or directly:

```bash
./vendor/bin/phpstan analyse --memory-limit=1G
```

Configuration lives in `phpstan.neon.dist`. Create a local `phpstan.neon` if you need environment-specific overrides.

## PSR-4 Autoloading

This library follows PSR-4 autoloading standards:

- Namespace: `Clubdeuce\Wpmvc_Redux`
- Source directory: `src/`
- Test namespace: `Clubdeuce\Wpmvc_Redux\Tests`
- Test directory: `tests/`

## License

MIT License - see [LICENSE](LICENSE) file for details.
