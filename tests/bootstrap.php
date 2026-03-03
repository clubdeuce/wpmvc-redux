<?php

require_once __DIR__ . '/../vendor/autoload.php';

if ( ! class_exists( 'WP_Term' ) ) {
    class WP_Term {
        public int $term_id = 0;
        public string $name = '';
        public string $slug = '';
        public string $taxonomy = '';
    }
}
