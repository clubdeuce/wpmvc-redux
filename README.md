# wpmvc-redux

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/clubdeuce/wpmvc-redux/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/clubdeuce/wpmvc-redux/?branch=main)
[![Build Status](https://scrutinizer-ci.com/g/clubdeuce/wpmvc-redux/badges/build.png?b=main)](https://scrutinizer-ci.com/g/clubdeuce/wpmvc-redux/build-status/main)

An MVC base library for WordPress plugin and theme development. Provides typed base classes for models, custom post types, and taxonomies, following PSR-4 autoloading standards.

**Requires PHP 8.3+**

## Installation

```bash
composer require clubdeuce/wpmvc-redux
```

---

## Architecture

```
Application          – plugin/theme entry point
Base\Base            – root base; bulk property setter via set_state()
Base\Model           – abstract model; enforces ID() contract
  Base\Post          – wraps WP_Post; exposes typed accessors
  Base\Term          – wraps WP_Term; exposes typed accessors
Controllers\Post_Type (abstract) – registers a custom post type on init
Controllers\Taxonomy  (abstract) – registers a custom taxonomy on init
Contracts\HasActions  – interface for Application subclasses with hook registration
```

---

## Usage

### Application

Extend `Application` to create your plugin entry point. Implement `HasActions` to register WordPress hooks automatically on construction.

```php
use Clubdeuce\Wpmvc_Redux\Application;
use Clubdeuce\Wpmvc_Redux\Contracts\HasActions;

class My_Plugin extends Application implements HasActions
{
    public function add_actions(): void
    {
        add_action( 'init', [ $this, 'register_stuff' ] );
    }
}

$plugin = new My_Plugin();
echo $plugin->getVersion(); // '1.0.0'
```

A `?ContainerInterface $container` property is available for dependency injection. Assign it via `set_state()` or a subclass constructor.

---

### Post model

Extend `Base\Post` to wrap a custom post type. All `WP_Post` properties are available via typed accessors — no raw property access needed.

```php
use Clubdeuce\Wpmvc_Redux\Base\Post;

class Book extends Post
{
    // override any accessor or add custom methods
    public function isbn(): string
    {
        return get_post_meta( $this->ID(), '_isbn', true ) ?: '';
    }
}

$book = new Book( get_post( 42 ) );
echo $book->title();      // post_title
echo $book->slug();       // post_name
echo $book->status();     // post_status  (e.g. 'publish')
echo $book->type();       // post_type
echo $book->date();       // post_date    (MySQL datetime string)
echo $book->modified();   // post_modified
echo $book->excerpt();    // post_excerpt
$book->author_id();       // (int) post_author
$book->parent_id();       // (int) post_parent
$book->menu_order();      // (int) menu_order
$book->get_content_html(); // apply_filters('the_content', post_content)
$book->the_title();        // echoes esc_html( get_the_title() )
```

#### Template rendering

`the_template()` locates and renders a `.php` template file. Lookup order: child theme → parent theme → module dir (if `module_dir()` is overridden).

```php
// Renders templates/book-card.php from the active theme
$book->the_template( 'book-card', [ 'show_date' => true ] );
```

Inside the template, `$item` is automatically available as a reference to the model instance, alongside any variables passed in the second argument:

```php
// templates/book-card.php
echo $item->title();
if ( $show_date ) {
    echo $item->date();
}
```

Override `templates_subdir()` to change the theme subdirectory (defaults to `templates`, or `WPLIB_TEMPLATES_SUBDIR` if defined). Override `module_dir()` to enable a plugin-level template fallback.

---

### Term model

Extend `Base\Term` to wrap a taxonomy term.

```php
use Clubdeuce\Wpmvc_Redux\Base\Term;

class Genre extends Term {}

$genre = new Genre( get_term( 7, 'genre' ) );
echo $genre->ID();          // term_id
echo $genre->name();        // name
echo $genre->slug();        // slug
echo $genre->taxonomy();    // taxonomy
echo $genre->description(); // description
$genre->parent_id();        // (int) parent
$genre->count();            // (int) count
```

---

### Post_Type controller

Extend `Controllers\Post_Type` (abstract) to register a custom post type. Define `const ?string POST_TYPE` and set `$arguments`.

```php
use Clubdeuce\Wpmvc_Redux\Controllers\Post_Type;

class Book_Post_Type extends Post_Type
{
    const ?string POST_TYPE = 'book';

    protected array $arguments = [
        'public'    => true,
        'label'     => 'Books',
        'supports'  => [ 'title', 'editor', 'thumbnail' ],
    ];
}

new Book_Post_Type(); // registers on wp 'init' hook automatically
```

`slug()` returns the `POST_TYPE` constant value.

---

### Taxonomy controller

Extend `Controllers\Taxonomy` (abstract) to register a custom taxonomy.

```php
use Clubdeuce\Wpmvc_Redux\Controllers\Taxonomy;

class Genre_Taxonomy extends Taxonomy
{
    const ?string TAXONOMY = 'genre';

    protected array $object_type = [ 'book' ];

    protected array $arguments = [
        'hierarchical' => true,
        'label'        => 'Genres',
    ];
}

new Genre_Taxonomy(); // registers on wp 'init' hook automatically
```

`slug()` returns the `TAXONOMY` constant value.

---

### HasActions interface

Implement `Contracts\HasActions` on any `Application` subclass that needs to register hooks. The constructor calls `add_actions()` automatically when the interface is detected.

```php
use Clubdeuce\Wpmvc_Redux\Contracts\HasActions;

interface HasActions
{
    public function add_actions(): void;
}
```

---

## Development

### Requirements

- PHP 8.3+
- Composer

### Install dependencies

```bash
composer install
```

### Run tests

```bash
./vendor/bin/phpunit
```

### Static analysis

```bash
composer phpstan
```

Configuration is in `phpstan.neon.dist`. Create a local `phpstan.neon` for environment-specific overrides — do not edit `phpstan.neon.dist` directly.

---

## PSR-4 namespaces

| Namespace | Directory |
|-----------|-----------|
| `Clubdeuce\Wpmvc_Redux` | `src/` |
| `Clubdeuce\Wpmvc_Redux\Tests` | `tests/` |

---

## License

MIT — see [LICENSE](LICENSE).
