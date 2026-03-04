<?php

declare(strict_types=1);

namespace Clubdeuce\Wpmvc_Redux\Base;

/**
 * Post base model.
 */
class Post extends Model {

	protected \WP_Post $post;

	public function __construct( \WP_Post $post, array $args = [] ) {

		$this->post = $post;

        parent::__construct( $args );

	}

	public function get_post(): \WP_Post {

		return $this->post;

	}

	public function ID(): int {

		return $this->post->ID;

	}

	/**
	 * Returns the subdirectory (within the theme) where templates are located.
	 * Respects WPLIB_TEMPLATES_SUBDIR if defined for backwards compatibility.
	 */
	protected function templates_subdir(): string {

		return defined( 'WPLIB_TEMPLATES_SUBDIR' ) ? WPLIB_TEMPLATES_SUBDIR : 'templates';

	}

	/**
	 * Returns the module/plugin root directory for template lookup, or null to skip.
	 * Override in subclasses to enable plugin-level template fallback.
	 */
	protected function module_dir(): ?string {

		return null;

	}

	/**
	 * Locate and render a template, with variables extracted into scope.
	 * Lookup order: child theme → parent theme → module dir (if set).
	 *
	 * @param string $template_slug Template filename without leading slash; .php is added if omitted.
	 * @param array  $template_vars Variables to extract into the template scope.
	 */
	public function the_template( string $template_slug, array $template_vars = [] ): void {

		$_filename = ltrim( $template_slug, '/' );
		if ( substr( $_filename, -4 ) !== '.php' ) {
			$_filename .= '.php';
		}

		$locations = array_filter( [
			get_stylesheet_directory() . '/' . $this->templates_subdir() . '/' . $_filename,
			get_template_directory()   . '/' . $this->templates_subdir() . '/' . $_filename,
			$this->module_dir() ? $this->module_dir() . '/templates/' . $_filename : null,
		] );

		$template_file = null;

		foreach ( $locations as $location ) {
			if ( file_exists( $location ) ) {
				$template_file = $location;
				break;
			}
		}

		if ( ! $template_file ) {
			return;
		}

		$item = $this;
		extract( $template_vars, EXTR_PREFIX_SAME, '_' );
		unset( $template_slug, $template_vars, $_filename, $locations, $location );

		require $template_file;

	}

    public function the_title(): void {

        echo esc_html( get_the_title( $this->ID() ) );

    }

    public function title(): string {

        return $this->post->post_title;

    }

    public function slug(): string {

        return $this->post->post_name;

    }

    public function excerpt(): string {

        return $this->post->post_excerpt;

    }

    public function status(): string {

        return $this->post->post_status;

    }

    public function type(): string {

        return $this->post->post_type;

    }

    public function date(): string {

        return $this->post->post_date;

    }

    public function modified(): string {

        return $this->post->post_modified;

    }

    public function parent_id(): int {

        return $this->post->post_parent;

    }

    public function author_id(): int {

        return (int) $this->post->post_author;

    }

    public function menu_order(): int {

        return $this->post->menu_order;

    }

    public function get_content_html(): string {

        return apply_filters( 'the_content', $this->post->post_content );

    }
}
