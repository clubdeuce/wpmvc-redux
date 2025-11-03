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

use ClubDeuce\WpmvcRedux\Application;

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

## PSR-4 Autoloading

This library follows PSR-4 autoloading standards:

- Namespace: `ClubDeuce\WpmvcRedux`
- Source directory: `src/`
- Test namespace: `ClubDeuce\WpmvcRedux\Tests`
- Test directory: `tests/`

## License

MIT License - see [LICENSE](LICENSE) file for details.
