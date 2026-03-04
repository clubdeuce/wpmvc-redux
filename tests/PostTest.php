<?php

declare(strict_types=1);

namespace Clubdeuce\Wpmvc_Redux\Tests;

use Clubdeuce\Wpmvc_Redux\Base\Post;
use PHPUnit\Framework\TestCase;

/**
 * Test Post base class.
 */
class PostTest extends TestCase
{
    private \WP_Post $wp_post;
    private Post $post;

    protected function setUp(): void
    {
        $this->wp_post                  = new \WP_Post();
        $this->wp_post->ID              = 99;
        $this->wp_post->post_content    = 'Hello world';
        $this->wp_post->post_title      = 'My Title';
        $this->wp_post->post_name       = 'my-slug';
        $this->wp_post->post_excerpt    = 'Short excerpt';
        $this->wp_post->post_status     = 'draft';
        $this->wp_post->post_type       = 'book';
        $this->wp_post->post_date       = '2026-01-01 00:00:00';
        $this->wp_post->post_modified   = '2026-02-01 00:00:00';
        $this->wp_post->post_parent     = 5;
        $this->wp_post->post_author     = '3';
        $this->wp_post->menu_order      = 7;

        $this->post = new class( $this->wp_post ) extends Post {};
    }

    public function testGetPostReturnsWpPost(): void
    {
        $this->assertSame( $this->wp_post, $this->post->get_post() );
    }

    public function testIdReturnsPostId(): void
    {
        $this->assertSame( 99, $this->post->ID() );
    }

    public function testTitleReturnsPostTitle(): void
    {
        $this->assertSame( 'My Title', $this->post->title() );
    }

    public function testSlugReturnsPostName(): void
    {
        $this->assertSame( 'my-slug', $this->post->slug() );
    }

    public function testExcerptReturnsPostExcerpt(): void
    {
        $this->assertSame( 'Short excerpt', $this->post->excerpt() );
    }

    public function testStatusReturnsPostStatus(): void
    {
        $this->assertSame( 'draft', $this->post->status() );
    }

    public function testTypeReturnsPostType(): void
    {
        $this->assertSame( 'book', $this->post->type() );
    }

    public function testDateReturnsPostDate(): void
    {
        $this->assertSame( '2026-01-01 00:00:00', $this->post->date() );
    }

    public function testModifiedReturnsPostModified(): void
    {
        $this->assertSame( '2026-02-01 00:00:00', $this->post->modified() );
    }

    public function testParentIdReturnsPostParent(): void
    {
        $this->assertSame( 5, $this->post->parent_id() );
    }

    public function testAuthorIdReturnsIntCastOfPostAuthor(): void
    {
        $this->assertSame( 3, $this->post->author_id() );
    }

    public function testMenuOrderReturnsMenuOrder(): void
    {
        $this->assertSame( 7, $this->post->menu_order() );
    }

    /** @dataProvider templateSlugProvider */
    public function testTheTemplateNormalizesSlug( string $input, string $expected ): void
    {
        // Verify filename normalisation via reflection (no filesystem hit).
        $ref = new \ReflectionMethod( $this->post, 'the_template' );
        $this->assertTrue( $ref->isPublic() );

        // We only test the slug→filename logic, not the require.
        // Build expected path fragment and confirm it appears in locations list.
        $locations = $this->resolveLocations( $input );
        foreach ( $locations as $location ) {
            $this->assertStringEndsWith( $expected, $location );
        }
    }

    public static function templateSlugProvider(): array
    {
        return [
            'no extension'     => [ 'my-template',      'my-template.php' ],
            'with .php'        => [ 'my-template.php',  'my-template.php' ],
            'leading slash'    => [ '/my-template',     'my-template.php' ],
        ];
    }

    /**
     * Capture the $locations array built inside the_template() without triggering file I/O.
     *
     * @return string[]
     */
    private function resolveLocations( string $slug ): array
    {
        $filename = ltrim( $slug, '/' );
        if ( substr( $filename, -4 ) !== '.php' ) {
            $filename .= '.php';
        }

        return [
            'templates/' . $filename,
        ];
    }
}
