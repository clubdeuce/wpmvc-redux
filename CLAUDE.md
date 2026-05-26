# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Commands

```bash
composer install                          # install dependencies
vendor/bin/phpunit                        # run all tests
vendor/bin/phpunit tests/PostTest.php     # run a single test file
vendor/bin/phpunit --filter testSlug      # run a single test method
composer phpstan                          # static analysis (level 0, src/ only)
```

PHPStan config lives in `phpstan.neon.dist`. Create a local `phpstan.neon` for environment-specific overrides — do not edit `phpstan.neon.dist` directly. To regenerate the baseline: `vendor/bin/phpstan analyse --generate-baseline phpstan-baseline.neon`.

## Architecture

This is a standalone MVC base library for WordPress plugin/theme development. It has no WordPress runtime dependency — WordPress classes and functions are stubbed in `tests/bootstrap.php` for unit testing.

**Class hierarchy:**

```
Base\Base               – root; constructor calls set_state() to bulk-assign matching properties from an $args array
  Application           – plugin entry point; holds an optional PSR-11 ContainerInterface; auto-calls add_actions() if HasActions is implemented
  Base\Model (abstract) – enforces ID() contract
    Base\Post           – wraps WP_Post; typed accessors for all WP_Post properties; template rendering via the_template()
    Base\Term           – wraps WP_Term; typed accessors for all WP_Term properties
  Controllers\Post_Type (abstract) – registers a CPT on the WordPress init hook; define POST_TYPE const and $arguments array
  Controllers\Taxonomy  (abstract) – registers a taxonomy on init; define TAXONOMY const, $object_type, and $arguments array
Contracts\HasActions    – interface; Application constructor detects and calls add_actions() automatically
```

**Template resolution in `Base\Post::the_template()`:** child theme → parent theme → module dir (if `module_dir()` is overridden). The model instance is always injected as `$item` in template scope alongside any passed variables.

**Key extension points:**
- Override `templates_subdir()` on `Post` subclasses to change the theme subdirectory (defaults to `templates`, or `WPLIB_TEMPLATES_SUBDIR` constant if defined).
- Override `module_dir()` on `Post` subclasses to add a plugin-level template fallback path.
- `Post_Type` and `Taxonomy` are abstract — `POST_TYPE` / `TAXONOMY` constants must be defined in concrete subclasses. A `null` constant value skips registration silently.

**DI container:** `Application::$container` is a `?ContainerInterface` (php-di/php-di). Assign it via constructor `$args` or a subclass constructor; the base class does not build or wire it automatically.
