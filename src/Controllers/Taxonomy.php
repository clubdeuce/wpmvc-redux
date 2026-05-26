<?php

declare(strict_types=1);

namespace Clubdeuce\Wpmvc_Redux\Controllers;

use Clubdeuce\Wpmvc_Redux\Base\Base;

abstract class Taxonomy extends Base {
	
	const ?string TAXONOMY = null;

	protected array $object_type = array();

	protected array $arguments = array();

	public function __construct( array $args = array() ) {

		parent::__construct( $args );
		$this->register_actions();

	}

	protected function register_actions(): void {

		add_action( 'init', array( $this, 'init' ) );

	}

	public function init(): void {

		$this->register_taxonomy();

	}

	public function arguments(): array {

		return array_merge( [], $this->arguments );

	}

	public function slug(): string {

		return static::TAXONOMY ?? '';

	}

	public function object_type(): array {

		return $this->object_type;

	}

	/**
	 * Register the taxonomy
	 *
	 * @return void
	 */
	public function register_taxonomy(): void {

		if ( static::TAXONOMY === null ) {
			return;
		}

		register_taxonomy( static::TAXONOMY, $this->object_type(), $this->arguments() );

	}

}
