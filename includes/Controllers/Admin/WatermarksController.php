<?php

namespace YOU_PLUGIN\Controllers\Admin;

use WP_REST_Server;
use YOU_PLUGIN\BaseController;

class WatermarksController extends BaseController {
    protected $namespace = 'watermark/v1';

    public function register_routes() {
        register_rest_route( $this->namespace, '/test', array(
            'methods'  => WP_REST_Server::READABLE,
            'callback' => [ $this, 'test' ],
            'permission_callback' => '__return_true'
        ) );
    }

    public function watermarks() {
        $this->render( 'admin/watermark/watermarks' );
    }

    /**
     * 获取水印列表
     */
    public function watermark_list() {

    }

    /**
     * 投放商品到水印
     */
    public function add_product_to_watermark() {

    }

    /**
     * 商品退出水印
     */
    public function del_product_to_watermark() {

    }

    public function test() {
        return rest_ensure_response( 'Hello World, this is the WordPress REST API' );
    }
}