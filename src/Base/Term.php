<?php

declare(strict_types=1);

namespace Clubdeuce\Wpmvc_Redux\Base;

/**
 * Term base model.
 */
class Term extends Base {

	protected \WP_Term $term;

	public function __construct( \WP_Term $term ) {

		$this->term = $term;

	}

	public function get_term(): \WP_Term {

		return $this->term;

	}

	public function ID(): int {

		return $this->term->term_id;

	}

}
