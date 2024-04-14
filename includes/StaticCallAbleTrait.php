<?php

namespace YOU_PLUGIN;

use function YOU_PLUGIN\app;

trait StaticCallAbleTrait {
	public static function __callStatic( $name, $arguments ) {
		$name = str_replace( '__', '', $name );
		app()->make( static::class )->$name( $arguments );
	}
}