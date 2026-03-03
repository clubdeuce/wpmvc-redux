# Copilot Instructions

## Commands

```bash
# Install dependencies
composer install

# Run all tests
./vendor/bin/phpunit

# Run a single test
./vendor/bin/phpunit --filter testMethodName

# Run a single test file
./vendor/bin/phpunit tests/ApplicationTest.php

# Static analysis
composer phpstan
# or directly:
./vendor/bin/phpstan analyse --memory-limit=1G
```

## Architecture

This is a PHP MVC library for WordPress plugin/theme development. It provides base classes that plugin authors extend.

**Class hierarchy:**
- `Base\Base` — root base class; provides `set_state(array $args)` which bulk-sets matching properties from an array
- `Base\Post extends Base` — wraps a `\WP_Post` object; extend this for custom post type models
- `Controllers\Post_Type extends Base` — registers a WordPress custom post type via `add_action('init', ...)`; extend and set `const POST_TYPE` + `$arguments`
- `Application extends Base` — entry point; calls `add_actions()` on itself if the method exists (hook for subclasses)

**Dependency injection:** `php-di/php-di` is a required dependency, though DI container wiring is not yet wired into the base classes (planned).

## Key Conventions

- `declare(strict_types=1)` is used in `Application.php`; apply it to all new files.
- WordPress hook registration belongs in `register_actions()` (controllers) or `add_actions()` (Application subclasses), not in constructors directly.
- `Post_Type` subclasses must define `const POST_TYPE` (string slug) and set `$arguments` for `register_post_type()` args.
- `set_state()` only sets properties that already exist on the class — always declare properties explicitly.
- PHPStan is configured at level 0 with WordPress globals (e.g., `WP_Post`, `add_action`, `register_post_type`) suppressed via `phpstan.neon.dist`. Create a local `phpstan.neon` for environment-specific overrides; do not edit `phpstan.neon.dist`.
- PSR-4 namespace: `Clubdeuce\Wpmvc_Redux` → `src/`; tests: `Clubdeuce\Wpmvc_Redux\Tests` → `tests/`.
