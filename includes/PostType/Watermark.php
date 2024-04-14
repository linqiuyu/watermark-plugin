<?php

namespace YOU_PLUGIN\PostType;

use YOU_PLUGIN\Controllers\WatermarksController;

class Watermark {
    const post_type = 'watermark';
    const post_name = 'Watermark';

    public function register_post_type() {
        register_post_type( Watermark::post_type,
            [
                'labels' =>[
                    'name' => Watermark::post_name,
                ],
                'public' => false,
                'show_in_rest' => true,
                'rest_base' => Watermark::post_name . 's',
                'rest_controller_class' => WatermarksController::class,
            ],
        );

        register_meta( Watermark::post_type, 'layer', [
            'type' => 'object',
            'description' => '图层信息',
            'single' => true,
            'show_in_rest' => true,
        ] );

        register_meta( Watermark::post_type, 'watermark_product_id', [
            'type' => 'number',
            'description' => '投放的商品id',
            'single' => false,
            'show_in_rest' => true,
        ] );
    }
}