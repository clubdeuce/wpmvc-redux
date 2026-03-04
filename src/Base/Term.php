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

	public function name(): string {

		return $this->term->name;

	}

	public function slug(): string {

		return $this->term->slug;

	}

	public function taxonomy(): string {

		return $this->term->taxonomy;

	}

	public function description(): string {

		return $this->term->description;

	}

	public function parent_id(): int {

		return $this->term->parent;

	}

	public function count(): int {

		return $this->term->count;

	}

}
