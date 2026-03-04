<?php

declare(strict_types=1);

namespace Clubdeuce\Wpmvc_Redux\Controllers;

use Clubdeuce\Wpmvc_Redux\Base\Base;

class Post_Type extends Base {

	const POST_TYPE = null;

	protected array   $arguments = array();

	public function __construct( array $args = array() ) {

        $this->set_state( $args );
		$this->register_actions();
		
	}

	protected function register_actions(): void {

		add_action( 'init', array( $this, 'init' ) );

	}

	public function init(): void {

		$this->register_post_type();

	}

	public function arguments(): array {

		return array_merge( [], $this->arguments );

	}

	public function slug(): string {

		return static::POST_TYPE ?? '';

	}

	/**
	 * Register the custom post type
	 *
	 * @return void
	 */
	public function register_post_type(): void {

		if ( static::POST_TYPE === null ) {
			return;
		}

		register_post_type( static::POST_TYPE, $this->arguments() );

	}

}
