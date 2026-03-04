<?php

declare(strict_types=1);

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
        $this->wp_term              = new \WP_Term();
        $this->wp_term->term_id     = 42;
        $this->wp_term->name        = 'Science Fiction';
        $this->wp_term->slug        = 'science-fiction';
        $this->wp_term->taxonomy    = 'genre';
        $this->wp_term->description = 'Sci-fi books';
        $this->wp_term->parent      = 10;
        $this->wp_term->count       = 7;
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

    public function testNameReturnsTermName(): void
    {
        $this->assertSame( 'Science Fiction', $this->term->name() );
    }

    public function testSlugReturnsTermSlug(): void
    {
        $this->assertSame( 'science-fiction', $this->term->slug() );
    }

    public function testTaxonomyReturnsTaxonomy(): void
    {
        $this->assertSame( 'genre', $this->term->taxonomy() );
    }

    public function testDescriptionReturnsDescription(): void
    {
        $this->assertSame( 'Sci-fi books', $this->term->description() );
    }

    public function testParentIdReturnsParent(): void
    {
        $this->assertSame( 10, $this->term->parent_id() );
    }

    public function testCountReturnsCount(): void
    {
        $this->assertSame( 7, $this->term->count() );
    }
}
