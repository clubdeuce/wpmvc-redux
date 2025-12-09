<?php

namespace Clubdeuce\Wpmvc_Redux;

use Clubdeuce\Wpmvc_Redux\Base\Base;
use DI\Container;

/**
 * Base class for the WP MVC Redux library
 */
class Application extends Base
{
    /**
     * Application version
     */
    const string VERSION = '1.0.0';

    public function __construct(protected Container $container)
    {
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

    public function container(): Container
    {
        return $this->container;
    }

    public function setContainer(Container $container): self
    {
        $this->container  = $container;

        return $this;
    }

}
