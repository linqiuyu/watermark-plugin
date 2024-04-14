<?php

namespace YOU_PLUGIN\Processors;

use YOU_PLUGIN\Activate\Activate;
use YOU_PLUGIN\Application;
use YOU_PLUGIN\Controllers\Admin\WatermarksController as AdminWatermarksController;
use YOU_PLUGIN\PostType\Watermark;
use YOU_PLUGIN\ProcessorInterface;

class Actions implements ProcessorInterface {
    private Application $app;

    public function process( $app ) {
        $this->app = $app;
        register_activation_hook( YOU_PLUGIN_FILE, [ Activate::class, '__activate' ] );
        $this->actions();
        if ( is_admin() ) {
            $this->admin_actions();
        }
        add_action( 'template_redirect', [ $this, 'template_actions' ] );
    }

    public function actions() {
        add_action( 'rest_api_init', [ AdminWatermarksController::class, '__register_routes' ] );

        add_action( 'plugins_loaded', [ $this->app[ 'i18n' ], 'load_textdomain' ] );

        add_action( 'init', [ Watermark::class, '__register_post_type' ] );
    }

    public function admin_actions() {
        add_action( 'admin_menu', function () {
            add_menu_page(
                'Watermark',
                'Watermark Design',
                'manage_options',
                'watermark',
                [ AdminWatermarksController::class, '__watermarks' ],
            );
        } );
    }

    public function template_actions() {

    }
}