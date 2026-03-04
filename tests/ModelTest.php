<?php

declare(strict_types=1);

namespace Clubdeuce\Wpmvc_Redux\Tests;

use Clubdeuce\Wpmvc_Redux\Base\Model;
use PHPUnit\Framework\TestCase;

/**
 * Test Model abstract base class.
 */
class ModelTest extends TestCase
{
    public function testConcreteModelReturnsId(): void
    {
        $model = new class( 7 ) extends Model {
            private int $id;

            public function __construct( int $id ) {
                $this->id = $id;
            }

            public function ID(): int {
                return $this->id;
            }
        };

        $this->assertSame( 7, $model->ID() );
    }

    public function testModelIsInstanceOfModel(): void
    {
        $model = new class extends Model {
            public function ID(): int { return 0; }
        };

        $this->assertInstanceOf( Model::class, $model );
    }

    public function testSetStatePopulatesProperties(): void
    {
        $model = new class extends Model {
            public int $value = 0;

            public function ID(): int { return $this->value; }
        };

        // set_state is protected; exercise it via the ID() contract
        $ref = new \ReflectionMethod( $model, 'set_state' );
        $ref->setAccessible( true );
        $ref->invoke( $model, [ 'value' => 99 ] );

        $this->assertSame( 99, $model->ID() );
    }
}
