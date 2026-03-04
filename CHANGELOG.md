# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] – 2026-03-04

### ⚠ Breaking changes

- **PHP 8.3 required.** The minimum PHP version has been raised from 8.0 to 8.3 to align with the typed-constant syntax already in use.
- `Controllers\Post_Type` and `Controllers\Taxonomy` are now **abstract**. Direct instantiation of the base classes is no longer possible; subclasses must be created.
- `Base\Model` is now **abstract** and declares `abstract public function ID(): int`. All model subclasses must implement `ID()`.

### Added

- `Base\Term` – wraps a `\WP_Term` object with typed accessors: `ID()`, `name()`, `slug()`, `taxonomy()`, `description()`, `parent_id()`, `count()`, `get_term()`.
- `Base\Post` typed accessors: `title()`, `slug()`, `excerpt()`, `status()`, `type()`, `date()`, `modified()`, `parent_id()`, `author_id()`, `menu_order()`. These complement the existing `ID()`, `get_content_html()`, and `the_title()`.
- `Base\Post::the_template()` – locates and renders a theme/plugin template file; injects `$item` (the model instance) into template scope.
- `Controllers\Taxonomy` – registers a custom taxonomy on the WordPress `init` hook; mirrors the `Post_Type` controller pattern.
- `Controllers\Taxonomy::slug()` – returns the `TAXONOMY` constant value, consistent with `Post_Type::slug()`.
- `Contracts\HasActions` interface – implement on `Application` subclasses to have `add_actions()` called automatically on construction (replaces duck-typed `method_exists()` check).
- `Application::$container` – declared `protected ?ContainerInterface $container = null` for future DI wiring; `getContainer()` return type corrected to `?ContainerInterface`.
- Typed constants: `Controllers\Post_Type::POST_TYPE` and `Controllers\Taxonomy::TAXONOMY` are now `const ?string`.

### Fixed

- `Post_Type::slug()` was returning an undeclared `$this->slug` property; now correctly returns `static::POST_TYPE ?? ''`.
- `Post::the_template()` regex was doubling the `.php` extension for slugs that already ended in `.php`; replaced with a simple `substr` check.
- `Application::getContainer()` referenced an unimported `Container` return type; corrected to `?ContainerInterface`.
- `Post_Type::register_post_type()` and `Taxonomy::register_taxonomy()` now guard against a `null` constant before calling the WordPress registration functions.
- `Application`, `Post`, `Term`, `Post_Type`, and `Taxonomy` constructors now all correctly chain `parent::__construct($args)`.
- `Base\Base::__construct()` visibility changed from `protected` to `public` to allow anonymous subclass instantiation.

### Changed

- `Base\Base` and `Controllers\Post_Type` now declare `strict_types=1`, consistent with all other source files.
- PHPStan baseline updated to suppress known WordPress symbol errors; all WordPress function/class stubs consolidated in `tests/bootstrap.php`.
- `tests/ModelTest::testSetStatePopulatesProperties` no longer uses deprecated `ReflectionMethod::setAccessible()`; exercises `set_state()` via the public constructor instead.

### Documentation

- `README.md` fully rewritten with architecture overview, usage examples for all classes, template rendering guide, and development commands.
- `example.php` expanded to demonstrate all five classes with annotated accessor listings.
- `.idea/` added to `.gitignore` and removed from version control.

## [0.0.1] – initial release

- `Base\Base` with `set_state()` bulk-property setter.
- `Base\Post` wrapping `\WP_Post`.
- `Application` entry-point class.
- `Controllers\Post_Type` for custom post type registration.
- PHPStan at level 0 with WordPress function suppressions.
