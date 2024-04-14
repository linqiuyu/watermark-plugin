<?php

namespace YOU_PLUGIN;

use Exception;

abstract class BaseController {
	use StaticCallAbleTrait;

    protected $namespace = '';

    abstract public function register_routes();

	protected function render( $view, $renderData = [], $return = false ) {
		$viewFile = $this->getViewFile( $view );

		return $this->renderFile( $viewFile, $renderData, $return );
	}

	private function getViewFile( $view ) {
		return YOU_PLUGIN_DIR . 'views/' . $view . '.php';
	}

	private function renderFile( $file, $renderData, $return = false ) {
		if ( file_exists( $file ) ) {
			extract( $renderData, EXTR_OVERWRITE );

			ob_start();
			ob_implicit_flush( 0 );
			require( $file );
			$content = ob_get_clean();

			if ( $return ) {
				return $content;
			} else {
				echo $content;
			}
		} else {
			throw new Exception( "Can not found view file $file" );
		}
	}
}