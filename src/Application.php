<?php

declare(strict_types=1);

namespace Clubdeuce\Wpmvc_Redux;

use Clubdeuce\Wpmvc_Redux\Base\Base;
use Psr\Container\ContainerInterface;

/**
 * Application class for the WP MVC Redux library
 * @package Clubdeuce\Wpmvc_Redux
 */
class Application extends Base
{
    /**
     * Application version
     */
    const string VERSION = '1.0.0';

    protected ?ContainerInterface $container = null;

    public function __construct( array $args = [] )
    {
        parent::__construct( $args );

		if ( method_exists($this, 'add_actions') ) {
			$this->add_actions();
		}
    }

    /**
     * Get the library version
     *
     * @return string
     */
    public function getVersion(): string
    {
        return self::VERSION;
    }

    public function getContainer(): ?ContainerInterface
    {
        return $this->container;
    }

}
