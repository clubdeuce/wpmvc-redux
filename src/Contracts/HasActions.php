<?php

declare(strict_types=1);

namespace Clubdeuce\Wpmvc_Redux\Contracts;

/**
 * Implemented by Application subclasses that register WordPress action hooks.
 */
interface HasActions
{
    public function add_actions(): void;
}
