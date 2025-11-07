<?php

namespace Clubdeuce\Wpmvc_Redux\Controllers;

use Clubdeuce\Wpmvc_Redux\Base\Base;

class Post_Type extends Base {

	protected string  $slug;
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

		return $this->slug;

	}

	/**
	 * Register the custom post type
	 *
	 * @return void
	 */
	public function register_post_type(): void {

		register_post_type( $this->slug(), $this->arguments() );
		
	}

}
