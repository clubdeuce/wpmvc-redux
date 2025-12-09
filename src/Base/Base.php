<?php

namespace Clubdeuce\Wpmvc_Redux\Base;

class Base {

	protected function set_state( array $args = array() ): void {

	    foreach ( $args as $key => $value ) {
            if ( property_exists( $this, $key ) ) {
                $this->{$key} = $value;
            }
		}

	}

}
