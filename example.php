<?php

/**
 * Example usage of the WP MVC Redux library.
 *
 * In a real plugin, these classes would live in separate files loaded via
 * Composer's PSR-4 autoloader.
 */

require_once __DIR__ . '/vendor/autoload.php';

use Clubdeuce\Wpmvc_Redux\Application;
use Clubdeuce\Wpmvc_Redux\Base\Post;
use Clubdeuce\Wpmvc_Redux\Base\Term;
use Clubdeuce\Wpmvc_Redux\Contracts\HasActions;
use Clubdeuce\Wpmvc_Redux\Controllers\Post_Type;
use Clubdeuce\Wpmvc_Redux\Controllers\Taxonomy;

// ---------------------------------------------------------------------------
// 1. Application entry point
// ---------------------------------------------------------------------------

class My_Plugin extends Application implements HasActions
{
    public function add_actions(): void
    {
        // WordPress hooks go here; called automatically by the constructor.
        // add_action( 'init', [ $this, 'boot' ] );
    }
}

$plugin = new My_Plugin();
echo 'Library version: ' . $plugin->getVersion() . PHP_EOL;

// ---------------------------------------------------------------------------
// 2. Custom post type controller
// ---------------------------------------------------------------------------

class Book_Post_Type extends Post_Type
{
    const ?string POST_TYPE = 'book';

    protected array $arguments = [
        'public'   => true,
        'label'    => 'Books',
        'supports' => [ 'title', 'editor', 'thumbnail' ],
    ];
}

// Instantiation registers the post type on the WordPress 'init' hook.
// new Book_Post_Type();

// ---------------------------------------------------------------------------
// 3. Custom taxonomy controller
// ---------------------------------------------------------------------------

class Genre_Taxonomy extends Taxonomy
{
    const ?string TAXONOMY = 'genre';

    protected array $object_type = [ 'book' ];

    protected array $arguments = [
        'hierarchical' => true,
        'label'        => 'Genres',
    ];
}

// Instantiation registers the taxonomy on the WordPress 'init' hook.
// new Genre_Taxonomy();

// ---------------------------------------------------------------------------
// 4. Post model
// ---------------------------------------------------------------------------

class Book extends Post
{
    public function isbn(): string
    {
        // In a real plugin: return get_post_meta( $this->ID(), '_isbn', true ) ?: '';
        return '978-3-16-148410-0';
    }
}

// In a real plugin: $book = new Book( get_post( $post_id ) );
// $book->title();        — post_title
// $book->slug();         — post_name
// $book->status();       — post_status
// $book->type();         — post_type
// $book->date();         — post_date (MySQL datetime string)
// $book->modified();     — post_modified
// $book->excerpt();      — post_excerpt
// $book->author_id();    — (int) post_author
// $book->parent_id();    — (int) post_parent
// $book->menu_order();   — (int) menu_order
// $book->get_content_html(); — filtered post_content
// $book->the_template('book-card', ['show_date' => true]);

// ---------------------------------------------------------------------------
// 5. Term model
// ---------------------------------------------------------------------------

class Genre extends Term {}

// In a real plugin: $genre = new Genre( get_term( $term_id, 'genre' ) );
// $genre->ID();          — term_id
// $genre->name();        — name
// $genre->slug();        — slug
// $genre->taxonomy();    — taxonomy
// $genre->description(); — description
// $genre->parent_id();   — (int) parent
// $genre->count();       — (int) post count
