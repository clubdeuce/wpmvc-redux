<?php

declare(strict_types=1);

namespace Clubdeuce\Wpmvc_Redux\Tests;

use Clubdeuce\Wpmvc_Redux\Controllers\Post_Type;
use Clubdeuce\Wpmvc_Redux\Controllers\Taxonomy;
use PHPUnit\Framework\TestCase;

/**
 * Tests for Post_Type controller.
 */
class Post_TypeTest extends TestCase
{
    protected function setUp(): void
    {
        $GLOBALS['_registered_post_types'] = [];
    }

    public function testNullPostTypeDoesNotRegister(): void
    {
        $controller = new class extends Post_Type {};
        $controller->register_post_type();

        $this->assertEmpty( $GLOBALS['_registered_post_types'] );
    }

    public function testConcretePostTypeRegisters(): void
    {
        $controller = new class extends Post_Type {
            const ?string POST_TYPE = 'book';
            protected array $arguments = [ 'public' => true ];
        };

        $GLOBALS['_registered_post_types'] = [];
        $controller->register_post_type();

        $this->assertArrayHasKey( 'book', $GLOBALS['_registered_post_types'] );
        $this->assertTrue( $GLOBALS['_registered_post_types']['book']['public'] );
    }

    public function testSlugReturnsPostType(): void
    {
        $controller = new class extends Post_Type {
            const ?string POST_TYPE = 'event';
        };

        $this->assertSame( 'event', $controller->slug() );
    }

    public function testSlugOnBaseClassReturnsEmptyString(): void
    {
        $controller = new class extends Post_Type {};
        $this->assertSame( '', $controller->slug() );
    }
}

/**
 * Tests for Taxonomy controller.
 */
class TaxonomyTest extends TestCase
{
    protected function setUp(): void
    {
        $GLOBALS['_registered_taxonomies'] = [];
    }

    public function testNullTaxonomyDoesNotRegister(): void
    {
        $controller = new class extends Taxonomy {};
        $controller->register_taxonomy();

        $this->assertEmpty( $GLOBALS['_registered_taxonomies'] );
    }

    public function testConcreteTaxonomyRegisters(): void
    {
        $controller = new class extends Taxonomy {
            const ?string TAXONOMY = 'genre';
            protected array $object_type = [ 'book' ];
            protected array $arguments   = [ 'hierarchical' => true ];
        };

        $controller->register_taxonomy();

        $this->assertArrayHasKey( 'genre', $GLOBALS['_registered_taxonomies'] );
        $this->assertSame( [ 'book' ], $GLOBALS['_registered_taxonomies']['genre']['object_type'] );
        $this->assertTrue( $GLOBALS['_registered_taxonomies']['genre']['args']['hierarchical'] );
    }

    public function testSlugReturnsTaxonomy(): void
    {
        $controller = new class extends Taxonomy {
            const ?string TAXONOMY = 'genre';
        };

        $this->assertSame( 'genre', $controller->slug() );
    }

    public function testSlugOnBaseClassReturnsEmptyString(): void
    {
        $controller = new class extends Taxonomy {};
        $this->assertSame( '', $controller->slug() );
    }
}
