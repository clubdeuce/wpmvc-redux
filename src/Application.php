<?php

namespace Clubdeuce\Wpmvc_Redux;

/**
 * Base class for the WP MVC Redux library
 */
class Application
{
    /**
     * Application version
     */
    const string VERSION = '1.0.0';

    /**
     * Get the library version
     *
     * @return string
     */
    public function getVersion(): string
    {
        return self::VERSION;
    }
}
