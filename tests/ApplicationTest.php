<?php

namespace ClubDeuce\WpmvcRedux\Tests;

use ClubDeuce\WpmvcRedux\Application;
use PHPUnit\Framework\TestCase;

/**
 * Test Application class
 */
class ApplicationTest extends TestCase
{
    /**
     * Test that the Application class can be instantiated
     */
    public function testCanInstantiate(): void
    {
        $app = new Application();
        $this->assertInstanceOf(Application::class, $app);
    }

    /**
     * Test version retrieval
     */
    public function testGetVersion(): void
    {
        $app = new Application();
        $this->assertEquals('1.0.0', $app->getVersion());
    }
}
