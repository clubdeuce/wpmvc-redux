<?php

namespace Clubdeuce\Wpmvc_Redux\Base;

class Base {

	protected function set_state( array $args = array() ): void {

	    foreach ( $args as $key => $value ) {
	        $this->{$key} = $value;
		}

	}

}
