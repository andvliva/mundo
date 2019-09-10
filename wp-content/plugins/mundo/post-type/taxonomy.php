<?php
register_taxonomy("review-category", array("guest_review"), array(
    "hierarchical" => true,
    "query_var" => "review_category",
    "rewrite" => array("slug" => "review-category"),
    "public" => true,
    "show_ui" => true,
    "show_admin_column" => true,
    "labels" => array("name" => __("Review category"), "singular_name" => __("Review category")),
    ));

add_filter( 'rwmb_meta_boxes', function($meta_boxes) {
    
    $meta_boxes['mt_review_category'] = array(
        'id'      => 'mt_review_category',
        'name'      => 'Thông tin khác',
        'taxonomies' => 'review-category',
        'fields' => array(
            'link' => array(
                'id' => 'link',
                'name' => 'Link',
                'type' => 'text',
            ),
            'logo' => array(
                'id' => 'logo',
                'name' => 'Logo',
                'type' => 'image_advanced',
                'max_file_uploads' => 1,
            ),
        ),
    );
    return $meta_boxes;
},11 );

register_taxonomy("duration", array("product"), array(
    "hierarchical" => true,
    "query_var" => "duration",
    "rewrite" => array("slug" => "duration"),
    "public" => true,
    "show_ui" => true,
    "show_admin_column" => true,
    "labels" => array("name" => __("Duration"), "singular_name" => __("Duration")),
    ));