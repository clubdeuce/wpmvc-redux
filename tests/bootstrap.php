<?php

require_once __DIR__ . '/../vendor/autoload.php';

// WordPress function stubs for unit testing.
if ( ! function_exists( 'add_action' ) ) {
    function add_action( string $hook, callable|array $callback, int $priority = 10, int $accepted_args = 1 ): bool {
        return true;
    }
}

if ( ! function_exists( 'register_post_type' ) ) {
    function register_post_type( string $post_type, array $args = [] ): void {
        $GLOBALS['_registered_post_types'][ $post_type ] = $args;
    }
}

if ( ! function_exists( 'register_taxonomy' ) ) {
    function register_taxonomy( string $taxonomy, array|string $object_type, array $args = [] ): void {
        $GLOBALS['_registered_taxonomies'][ $taxonomy ] = compact( 'object_type', 'args' );
    }
}

if ( ! class_exists( 'WP_Post' ) ) {
    class WP_Post {
        public int    $ID            = 0;
        public string $post_title    = '';
        public string $post_content  = '';
        public string $post_type     = 'post';
        public string $post_status   = 'publish';
    }
}

if ( ! class_exists( 'WP_Term' ) ) {
    class WP_Term {
        public int $term_id = 0;
        public string $name = '';
        public string $slug = '';
        public string $taxonomy = '';
    }
}
