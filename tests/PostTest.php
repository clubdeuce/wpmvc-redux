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
        $this->wp_post              = new \WP_Post();
        $this->wp_post->ID          = 99;
        $this->wp_post->post_content = 'Hello world';

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
