<?php

declare(strict_types=1);

namespace Clubdeuce\Wpmvc_Redux\Base;

/**
 * Abstract base class for all model objects.
 */
abstract class Model extends Base {

    abstract public function ID(): int;

}
