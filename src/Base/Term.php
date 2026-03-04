<?php

declare(strict_types=1);

namespace Clubdeuce\Wpmvc_Redux\Base;

/**
 * Term base model.
 */
class Term extends Model {

	protected \WP_Term $term;

	public function __construct( \WP_Term $term, array $args = [] ) {

		$this->term = $term;

		parent::__construct( $args );

	}

	public function get_term(): \WP_Term {

		return $this->term;

	}

	public function ID(): int {

		return $this->term->term_id;

	}

}
