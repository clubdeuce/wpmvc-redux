<?php

namespace Clubdeuce\Wpmvc_Redux\Tests;

use Clubdeuce\Wpmvc_Redux\Base\Term;
use PHPUnit\Framework\TestCase;

/**
 * Test Term base class
 */
class TermTest extends TestCase
{
    private \WP_Term $wp_term;
    private Term $term;

    protected function setUp(): void
    {
        $this->wp_term = new \WP_Term();
        $this->wp_term->term_id = 42;
        $this->term = new Term( $this->wp_term );
    }

    public function testGetTermReturnsWpTerm(): void
    {
        $this->assertSame( $this->wp_term, $this->term->get_term() );
    }

    public function testIdReturnsTermId(): void
    {
        $this->assertSame( 42, $this->term->ID() );
    }
}
