<?php

declare(strict_types=1);

namespace Clubdeuce\Wpmvc_Redux;

use Clubdeuce\Wpmvc_Redux\Base\Base;
use Clubdeuce\Wpmvc_Redux\Contracts\HasActions;
use DI\ContainerBuilder;
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
    const VERSION = '1.0.0';

    protected ?ContainerInterface $container = null;

    public function __construct( array $args = [] )
    {
        parent::__construct( $args );

		if ( $this instanceof HasActions ) {
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
