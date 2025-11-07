<?php
namespace Clubdeuce\Wpmvc_Redux\Base;

/**
 * Post base model.
 */
class Post extends Base {

	protected \WP_Post $post;

	public function __construct( \WP_Post $post ) {

		$this->post = $post;

	}

	public function get_post(): \WP_Post {

		return $this->post;

	}

}
