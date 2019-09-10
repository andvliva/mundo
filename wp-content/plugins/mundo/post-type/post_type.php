<?php

add_filter('rwmb_meta_boxes', function ($meta_boxes)
{   $current_lang = pll_current_language();
    return array_merge($meta_boxes, array('blog_info' => array(
            'id' => 'blog_info',
            'title' => 'Blog information',
            'post_types' => 'post',
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => true,
            'not_show' => false,
            'fields' => array(

                2 => array(
                    'id' => 'blog_banner',
                    'type' => 'image_advanced',
                    'name' => 'Banner',
                    //  'columns' => '12',
                    ),
                4 => array(
                    'id' => 'view_home',
                    'type' => 'checkbox',
                    'name' => 'View home',
                    //  'columns' => '12',
                    ),
                // 3 => array(
                //     'id' => 'category',
                //     'type' => 'taxonomy',
                //     'name' => 'Destination',
                //     'taxonomy' => 'category-destination',
                //     'field_type' => 'checkbox_list',
                //     'replace_to_blog' => 'term_destination',
                //     //  'columns' => '12',
                //     ),
                5 => array(
                    'id' => 'view_about',
                    'type' => 'checkbox',
                    'name' => 'View about',
                    //   'columns' => '12',
                    ),
                6 => array(
                    'id' => 'related_post',
                    'type' => 'post',
                    'name' => 'Related post',
                    'post_type' => 'post',
                    'field_type' => 'select_advanced',
                    'multiple' => true,
                    'query_args' => array(
                        'post_status' => 'publish',
                        'posts_per_page' => -1,
                        'lang'  => $current_lang
                        ),
                    //  'columns' => '12',
                    ),
                7 => array(
                    'id' => 'related_tour',
                    'type' => 'post',
                    'name' => 'Related tour',
                    'post_type' => 'tour',
                    'field_type' => 'select_advanced',
                    'multiple' => true,
                    'query_args' => array(
                        'post_status' => 'publish',
                        'posts_per_page' => -1,
                        'lang'  => $current_lang,
                        ),
                    'max_file_uploads' => 2,
                    //  'columns' => '12',
                    ),
                8 => array(
                    'id' => 'expert',
                    'type' => 'post',
                    'name' => 'Expert',
                    'post_type' => 'expert',
                    'field_type' => 'select_advanced',
                    'query_args' => array(
                        'post_status' => 'publish',
                        'posts_per_page' => -1,
                        'lang'  => $current_lang,
                        ),
                    //   'columns' => '12',
                    ),
                9 => array(
                    'id' => 'popular_post',
                    'type' => 'checkbox',
                    'name' => 'Popular post',
                    //   'columns' => '12',
                    ),
                10 => array(
                    'id' => 'show_responsible',
                    'type' => 'checkbox',
                    'name' => 'Show responsible',
                    //   'columns' => '12',
                    ),
                ),
            ), )); }
);
register_post_type('restaurant', array(
    'labels' => array('name' => __('Restaurant'), 'singular_name' => __('Restaurant')),
    'public' => true,
    'has_archive' => true,
    'query_var' => false,
    'can_export' => false,
    'delete_with_user' => true,
    'capability_type' => 'restaurant',
    'columns' => array(),
    'actions' => array(),
    'supports' => array(
        'title',
        'thumbnail',
        'excerpt',
        ),
    ));
add_filter('rwmb_meta_boxes', function ($meta_boxes)
{
    $current_lang = pll_current_language();
    return array_merge($meta_boxes, array(
        'restaurant_info' => array(
            'id' => 'restaurant_info',
            'title' => 'Restaurant information',
            'post_types' => 'restaurant',
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => true,
            'not_show' => false,
            'fields' => array(
                0 => array(
                    'id' => 'image_banner',
                    'type' => 'image_advanced',
                    'name' => 'Image banner',
                    ),
                'res_content' => array(
                    'id' => 'res_content',
                    'type' => 'textarea',
                    'name' => 'Restaurant content',
                    ),
                'res_destination' => array(
                    'id' => 'res_destination',
                    'type' => 'taxonomy',
                    'name' => 'City',
                    'taxonomy' => 'category-destination',
                    'field_type' => 'select_advanced',
                    'replace_to_restaurant' => 'term_destination',
                    ),
                //'res_style' => array(
                //                    'id' => 'res_style',
                //                    'type' => 'taxonomy',
                //                    'name' => 'Restaurant style',
                //                    'taxonomy' => 'res_style',
                //                    'field_type' => 'checkbox_list',
                //                    'replace_to_restaurant' => 'cat_res_style',
                //                    ),
                'no_of_seats' => array(
                    'id' => 'no_of_seats',
                    'type' => 'number',
                    'name' => 'No of seats',
                    ),
                7 => array(
                    'id' => 'key_features',
                    'type' => 'text',
                    'name' => 'Key features',
                    ),
                ),
            ),
        'res_gallery' => array(
            'id' => 'res_gallery',
            'title' => 'Gallery',
            'post_types' => 'restaurant',
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => true,
            'not_show' => true,
            'fields' => array('group_res_gallery' => array(
                    'group_title' => '{#}',
                    'collapsible' => true,
                    'id' => 'res_gallery',
                    'type' => 'group',
                    'clone' => true,
                    'sort_clone' => true,
                    'fields' => array(
                        0 => array(
                            'id' => 'title',
                            'type' => 'text',
                            'name' => 'Title',
                            ),
                        1 => array(
                            'id' => 'image',
                            'type' => 'image_advanced',
                            'name' => 'Image',
                            ),
                        ),
                    ), ),
            ),
        'meals_sample' => array(
            'id' => 'meals_sample',
            'title' => 'Meals sample',
            'post_types' => 'restaurant',
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => true,
            'not_show' => true,
            'fields' => array(
                'group_meals_sample' => array(
                    'group_title' => '{#}',
                    'collapsible' => true,
                    'id' => 'meals_sample',
                    'type' => 'group',
                    'clone' => true,
                    'sort_clone' => true,
                    'fields' => array(
                        'meal_img' => array(
                            'id' => 'meal_img',
                            'type' => 'image_advanced',
                            'name' => 'Meal image',
                            ),
                        'meal_img_title' => array(
                            'id' => 'meal_img_title',
                            'type' => 'text',
                            'name' => 'Meal titel',
                            ),
                        ),
                    ),
                'detail_left' => array(
                    'id' => 'detail_left',
                    'type' => 'wysiwyg',
                    'name' => 'Detail left',
                    ),
                'detail_right' => array(
                    'id' => 'detail_right',
                    'type' => 'wysiwyg',
                    'name' => 'Detail -right',
                    ),
                ),
            ),
        'location_restaurant' => array(
            'id' => 'location_restaurant',
            'title' => 'Location restaurant',
            'post_types' => 'restaurant',
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => true,
            'not_show' => false,
            'fields' => array(0 => array(
                    'id' => 'location_res',
                    'type' => 'wysiwyg',
                    'name' => 'Location restaurant',
                    ), ),
            ),
        'map_restaurant' => array(
            'id' => 'map_restaurant',
            'title' => 'Map restaurant',
            'post_types' => 'restaurant',
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => true,
            'not_show' => false,
            'fields' => array(0 => array(
                    'id' => 'hotel_res',
                    'type' => 'textarea',
                    'name' => 'Map restaurant',
                    ), ),
            ),
        'alternative_res' => array(
            'id' => 'alternative_res',
            'title' => 'Alternative restaurant',
            'post_types' => 'restaurant',
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => true,
            'not_show' => false,
            'fields' => array(0 => array(
                    'id' => 'alternative_res',
                    'type' => 'post',
                    'name' => 'Alternative restaurant',
                    'post_type' => 'restaurant',
                    'field_type' => 'select_advanced',
                    'multiple' => true,
                    'query_args' => array(
                        'post_status' => 'publish',
                        'posts_per_page' => -1,
                        'lang'  => $current_lang,
                        ),
                    //'columns' => '12',
                    ), ),
            ),
        )); }
);
$role = get_role("administrator");
if (!empty($role))
{
    $role->add_cap("edit_restaurant");
    $role->add_cap("delete_restaurant");
    $role->add_cap("read_restaurant");
    $role->add_cap("edit_restaurants");
    $role->add_cap("edit_others_restaurants");
    $role->add_cap("publish_restaurants");
    $role->add_cap("read_private_restaurants");
    $role->add_cap("create_restaurants");

}
register_post_type('destination', array(
    'labels' => array('name' => __('Destination'), 'singular_name' => __('Destination')),
    'public' => true,
    'has_archive' => true,
    'query_var' => false,
    'can_export' => false,
    'delete_with_user' => true,
    'capability_type' => 'destination',
    'columns' => array(),
    'actions' => array(),
    // 'rewrite' => array('slug'=>' ','with_front' => false),
    'supports' => array(
        'title',
        'thumbnail',
        'excerpt'),
    ));
add_filter('rwmb_meta_boxes', function ($meta_boxes)
{
    $current_lang = pll_current_language();
    $post_ID = $_GET['post'];
    $terms = wp_get_post_terms( $post_ID, 'category-destination', array() );
    $slug = $terms[0]->slug;

    return array_merge($meta_boxes, array(
        'overview' => array(
            'id' => 'overview',
            'title' => 'Overview',
            'post_types' => 'destination',
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => true,
            'not_show' => true,
            'fields' => array(
                0 => array(
                    'id' => 'image_banner',
                    'type' => 'image_advanced',
                    'name' => 'Image banner',
                    ),
                1 => array(
                    'id' => 'content',
                    'type' => 'wysiwyg',
                    'name' => 'Content',
                    ),
                2 => array(
                    'id' => 'capital',
                    'type' => 'text',
                    'name' => 'Capital',
                    ),
                3 => array(
                    'id' => 'mainlanguage',
                    'type' => 'text',
                    'name' => 'Mainlanguage',
                    ),
                4 => array(
                    'id' => 'population',
                    'type' => 'text',
                    'name' => 'population',
                    ),
                5 => array(
                    'id' => 'curentcy',
                    'type' => 'text',
                    'name' => 'Curentcy',
                    ),
                6 => array(
                    'id' => 'time_zone',
                    'type' => 'text',
                    'name' => 'Time zone',
                    ),
                7 => array(
                    'id' => 'calling_code',
                    'type' => 'text',
                    'name' => 'Calling code',
                    ),
                // 5 => array(
                //     'id' => 'best_time_to_go',
                //     'type' => 'textarea',
                //     'name' => 'Best time to go',
                //     ),
                8 => array(
                    'id' => 'map_image',
                    'type' => 'image_advanced',
                    'name' => 'Map image',
                    ),
                9 => array(
                    'id' => 'map_iframe',
                    'type' => 'textarea',
                    'name' => 'Map iframe',
                    ),
                10 => array(
                        'id' => 'city_relate',
                        'type' => 'post',
                        'post_type' => 'destination',
                        'name' => 'City relate',
                        'field_type' => 'select_advanced',
                        'multiple' => 'true',
                        'query_args'  => array(
                            'post_status'    => 'publish',
                            'posts_per_page' => - 1,
                            'lang'  => $current_lang,
                            'tax_query' => array(
                                            array(
                                                'taxonomy' => 'category-destination',
                                                'field'    => 'slug',
                                                'terms'    => $slug,
                                            ),
                                            array(
                                                        'taxonomy' => 'category-destination',
                                                        'field'    => 'slug',
                                                        'terms'    => $slug,
                                                        'operator' => 'NOT IN',
                                                        'include_children' => false,
                                            )         
                                        ),
                        ), 
                    ),
                ),
            ),
        'map_and_itinerary_destination' => array(
            'id' => 'location_maps',
            'title' => 'Location tour map and itinerary',
            'post_types' => 'destination',
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => true,
            'not_show' => true,
             'fields' => array(
                0 => array(
                    'id' => 'location_maps',
                    'type' => 'text',
                    'name' => 'Location maps',
                    ),),
        ),
        'destination_gallery' => array(
            'id' => 'destination_gallery',
            'title' => 'Gallery',
            'post_types' => 'destination',
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => true,
            'not_show' => true,
            'fields' => array('group_gallery' => array(
                    'group_title' => '{#}',
                    'collapsible' => true,
                    'id' => 'gallery',
                    'type' => 'group',
                    'clone' => true,
                    'sort_clone' => true,
                    'fields' => array(
                        0 => array(
                            'id' => 'file_name',
                            'type' => 'text',
                            'name' => 'File name',
                            ),
                        1 => array(
                            'id' => 'image',
                            'type' => 'single_image',
                            'name' => 'Image',
                            ),
                        2 => array(
                            'id' => 'image_thumb',
                            'type' => 'single_image',
                            'name' => 'Image thumb',
                            ),
                        3 => array(
                            'id' => 'link',
                            'type' => 'link',
                            'name' => 'Link',
                            ),
                        ),
                    ), ),
            ),
        'information' => array(
            'id' => 'information',
            'title' => 'Information',
            'post_types' => 'destination',
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => true,
            'not_show' => true,
            'fields' => array('group_information' => array(
                    'group_title' => '{#}',
                    'collapsible' => true,
                    'id' => 'information',
                    'type' => 'group',
                    'clone' => true,
                    'sort_clone' => true,
                    'fields' => array(
                        0 => array(
                            'id' => 'title_destination_info',
                            'type' => 'text',
                            'name' => 'Title destination info',
                            ),
                        1 => array(
                            'id' => 'content_destination_info',
                            'type' => 'wysiwyg',
                            'name' => 'Content destination info',
                            'size' => 100,
                            ),
                        ),
                    ), ),
            ),
        'experts' => array(
            'id' => 'experts',
            'title' => 'Experts',
            'post_types' => 'destination',
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => true,
            'not_show' => false,
            'fields' => array(
                0 => array(
                    'id' => 'experts',
                    'type' => 'post',
                    'name' => 'Experts',
                    'post_type' => 'expert',
                    'field_type' => 'select_advanced',
                    'multiple' => true,
                    'query_args' => array(
                        'post_status' => 'publish',
                        'posts_per_page' => -1,
                        'lang'  => $current_lang,
                        ),
                    ), 
                1 => array(
                        'id' => 'hotel_relate',
                        'type' => 'post',
                        'post_type' => 'hotel',
                        'name' => 'Hotel relate',
                        'field_type' => 'select_advanced',
                        'multiple' => 'true',
                        'query_args'  => array(
                            'post_status'    => 'publish',
                            'posts_per_page' => - 1,
                            'lang'  => $current_lang,
                            'tax_query' => array(
                                            array(
                                                'taxonomy' => 'category-destination',
                                                'field'    => 'slug',
                                                'terms'    => $slug,
                                            ),
                                                 
                                        ),
                        ), 
                    ), 
                2 => array(
                        'id' => 'restaurant_relate',
                        'type' => 'post',
                        'post_type' => 'restaurant',
                        'name' => 'Restaurant relate',
                        'field_type' => 'select_advanced',
                        'multiple' => 'true',
                        'query_args'  => array(
                            'post_status'    => 'publish',
                            'posts_per_page' => - 1,
                            'lang'  => $current_lang,
                            'tax_query' => array(
                                            array(
                                                'taxonomy' => 'category-destination',
                                                'field'    => 'slug',
                                                'terms'    => $slug,
                                            ),
                                                 
                                        ),
                        ), 
                    ), 

            ),
            ),
        'view_home' => array(
            'id' => 'view_home',
            'title' => 'View home',
            'post_types' => 'destination',
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => true,
            'not_show' => false,
            'fields' => array(
                0 => array(
                    'id' => 'view_home',
                    'type' => 'checkbox',
                    'name' => 'View home',
                    'columns' => '12',
                    ), 
                1 => array(
                    'id' => 'view_why_us',
                    'type' => 'checkbox',
                    'name' => 'View why us',
                    'columns' => '12',
                    ),
            ),
            ),
        // 'destination' => array(
        //            'id' => 'destination',
        //            'title' => 'Destination',
        //            'post_types' => 'destination',
        //            'context' => 'advanced',
        //            'priority' => 'default',
        //            'autosave' => true,
        //            'not_show' => false,
        //            'fields' => array(0 => array(
        //                    'id' => 'destination',
        //                    'type' => 'taxonomy',
        //                    'name' => 'Destination',
        //                    'taxonomy' => 'destination',
        //                    'field_type' => 'checkbox_list',
        //                    'columns' => '4',
        //                    ), ),
        //            ),
        )); }
);

$role = get_role("administrator");
if (!empty($role))
{
    $role->add_cap("edit_destination");
    $role->add_cap("delete_destination");
    $role->add_cap("read_destination");
    $role->add_cap("edit_destinations");
    $role->add_cap("edit_others_destinations");
    $role->add_cap("publish_destinations");
    $role->add_cap("read_private_destinations");
    $role->add_cap("create_destinations");
    $role->add_cap("delete_destinations");

}
register_post_type('tour', array(
    'labels' => array('name' => __('Tour'), 'singular_name' => __('Tour')),
    'public' => true,
    'has_archive' => true,
    'query_var' => false,
    'can_export' => false,
    'delete_with_user' => true,
    'capability_type' => 'tour',
    'columns' => array(),
    'actions' => array(),
    'supports' => array('title', 'thumbnail'),
    ));
add_filter('rwmb_meta_boxes', function ($meta_boxes)
{
    $terms_destination = get_terms('category-destination', array(
        'hide_empty' => false,
        'parent' => 0,
        )); foreach ($terms_destination as $key => $term_destination)
    {
        $options[$term_destination->name] = $term_destination->slug; }

    $all_destinations = get_posts(array(
            'post_type' => 'destination',
            'numberposts' => -1,
        )); 
    foreach ($all_destinations as $key => $all_destination)
    {
        $options_destination[$all_destination->ID] = $all_destination->name; 
    }
    $current_lang = pll_current_language();
    $args = array(
        'taxonomy' => 'travel_style',
        'hide_empty' => false,
        'lang'  => $current_lang,
        );
    $terms_style = get_terms('travel_style', $args ); 
    if($terms_style){
            foreach ($terms_style as $key => $tax) {
                if(pll_get_term_language($tax->term_id) !== $args['lang']){
                    unset($terms_style[$key]);
                }
            }
            $terms_style = array_values($terms_style);
        }
    foreach ($terms_style as $key => $term)
    {
    $travel_style[$term->name] = $term->slug; }
    return array_merge($meta_boxes, array(

        'tour_over_view' => array(
            'id' => 'tour_over_view',
            'title' => 'Over view',
            'post_types' => 'tour',
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => true,
            'not_show' => false,
            'fields' => array(
                'image_banner' => array(
                    'id' => 'image_banner',
                    'type' => 'image_advanced',
                    'name' => 'Image Banner',
                    ),
                'content_over_view' => array(
                    'id' => 'content_over_view',
                    'type' => 'wysiwyg',
                    'name' => 'Content over view',
                    ),
                'tour_guide' => array(
                    'id' => 'tour_guide',
                    'type' => 'taxonomy',
                    'name' => 'Tour guide',
                    'taxonomy' => 'tour_guide',
                    'field_type' => 'checkbox_list',
                    'replace_to_tour' => 'cat_tour_guide',
                    'attributes' => array('class' => 'tour_guide', )),
                'route' => array(
                    'id' => 'route',
                    'type' => 'text',
                    'name' => 'Route',
                    'multiple' => false,
                    //'clone' => true,
                    //                    'options' => $options,
                    ),
                'highlight_city' => array(
                    'id' => 'highlight_city',
                    'type' => 'text',
                    'name' => 'Highlight city',
                    ),
                'travel_style' => array(
                    'id' => 'travel_style',
                    'type' => 'select',
                    'name' => 'Travel Style',
                    'options' => $travel_style,
                    // 'taxonomy' => 'travel_style',
                    // 'field_type' => 'select_advanced',
                    // 'replace_to_tour' => 'cat_travel_style',
                    // 'multiple'  => true,
                    ),

                // 'price_from' => array(
                //     'id' => 'price_from',
                //     'type' => 'text',
                //     'name' => 'Price from',
                //     ),
                'discount_price' => array(
                    'id' => 'discount_price',
                    'type' => 'text',
                    'name' => 'Discount price',
                    ),
                'select_type' => array(
                    'id' => 'select_type',
                    'type' => 'select',
                    'name' => 'Select type',
                    'options' => array(
                        'customize' => 'Customize',
                        'seat_in_coach' => 'Seat in coach',
                        ),
                    // 'columns' => '4',
                    ),
                'num_of_tour' => array(
                    'id' => 'number_of_tourists',
                    'type' => 'number',
                    'name' => 'Number of tourists',
                    ),
                'age_from' => array(
                    'id' => 'age_from',
                    'type' => 'number',
                    'name' => 'Age from',
                    //  'columns' => '6',
                    ),
                'age_to' => array(
                    'id' => 'age_to',
                    'type' => 'number',
                    'name' => 'Age to',
                    //'columns' => '6',
                    ),
                'hide_tour' => array(
                    'id' => 'hide_tour',
                    'type' => 'checkbox',
                    'name' => 'Hide tour',
                    ),
                'show_home' => array(
                    'id' => 'show_home',
                    'type' => 'checkbox',
                    'name' => 'Show home',
                    ),
                'position_display' => array(
                    'id' => 'position_display',
                    'type' => 'text',
                    'name' => 'Position display',
                    'std' =>'9999',
                    ),
                'show_list_hotel' => array(
                    'id' => 'show_list_hotel',
                    'type' => 'checkbox',
                    'name' => 'Show in list hotel',
                    ),
                'show_list_restaurant' => array(
                    'id' => 'show_list_restaurant',
                    'type' => 'checkbox',
                    'name' => 'Show in list restaurant',
                    ),
                //'departure_month' => array(
                //                    'id' => 'departure_month',
                //                    'type' => 'checkbox',
                //                    'name' => 'Departure month in home',
                //                    ),
                
               
                'departure_date' => array(
                    'group_title' => 'Departure date {#}',
                    'collapsible' => true,
                    'id' => 'departure_date',
                    'type' => 'group',
                    'clone' => true,
                    'sort_clone' => true,
                    'fields' => array(
                         'date' => array(
                            'id' => 'date',
                            'type' => 'date',
                            'name' => 'Date',
                            'timestamp' => true,
                            //'columns' => '4',
                         ),
                        'status' => array(
                            'id' => 'status',
                            'type' => 'checkbox_list',
                            'name' => 'Status',
                            'options' => array(
                                'available' => 'Available',
                                'full' => 'Full',
                                ),
                        ),
                    ),
                    ),
               // 'departure_month' => array(
//                    'id' => 'departure_month',
//                    'type' => 'checkbox_list',
//                    'name' => 'Departure month',
//                    'options' => array(
//                        'all' => 'All',
//                        'jan' => 'January',
//                        'feb' => 'Febuary',
//                        'mar' => 'March',
//                        'apr' => 'April',
//                        'may' => 'May',
//                        'jun' => 'June',
//                        'july' => 'July',
//                        'aug' => 'August',
//                        'sep' => 'September',
//                        'oct' => 'October',
//                        'nov' => 'November',
//                        'dec' => 'December',
//
//                        ),
//                    ),
//
                ),
            ),
        'tour_highlight' => array(
            'id' => 'tour_highlight',
            'title' => 'Tour highlight',
            'post_types' => 'tour',
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => true,
            'not_show' => true,
            'fields' => array(
                'tour_highlight' => array(
                    'id' => 'tour_highlight',
                    'type' => 'post',
                    'post_type' => 'highlight',
                    'name' => 'Tour highlight',
                    'field_type' => 'select_advanced',
                    'multiple' => 'true',
                    'max_file_uploads' => 2,
                    'query_args'  => array(
                        'post_status'    => 'publish',
                        'posts_per_page' => - 1,
                        'lang'  => $current_lang,
                    ), 
                    ),
                'destination' => array(
                    'id' => 'destination',
                    'type' => 'post',
                    'post_type' => 'destination',
                    'name' => 'Destination',
                    'field_type' => 'select_advanced',
                    'multiple' => 'true',
                    'query_args'  => array(
                        'post_status'    => 'publish',
                        'posts_per_page' => - 1,
                        'lang'  => $current_lang,
                    ),     
                    ),
                'hotel' => array(
                    'id' => 'hotel',
                    'type' => 'post',
                    'post_type' => 'hotel',
                    'name' => 'Hotel',
                    'field_type' => 'select_advanced',
                    'multiple' => 'true',
                    'query_args'  => array(
                        'post_status'    => 'publish',
                        'posts_per_page' => - 1,
                        'lang'  => $current_lang,
                    ), 
                    ),
                'restaurant' => array(
                    'id' => 'restaurant',
                    'type' => 'post',
                    'post_type' => 'restaurant',
                    'name' => 'Restaurant',
                    'field_type' => 'select_advanced',
                    'multiple' => 'true',
                    'query_args'  => array(
                        'post_status'    => 'publish',
                        'posts_per_page' => - 1,
                        'lang'  => $current_lang,
                    ), 
                    ),
                'blog' => array(
                    'id' => 'blog',
                    'type' => 'post',
                    'post_type' => 'post',
                    'name' => 'Blog',
                    'field_type' => 'select_advanced',
                    'multiple' => 'true',
                    'query_args'  => array(
                        'post_status'    => 'publish',
                        'posts_per_page' => - 1,
                        'lang'  => $current_lang,
                    ), 
                    ),
                ),
            ),
        'map_and_itinerary' => array(
            'id' => 'tour_map',
            'title' => 'Location tour map and itinerary',
            'post_types' => 'tour',
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => true,
            'not_show' => true,
            'fields' => array(
                0 => array(
                    'id' => 'title_map',
                    'type' => 'text',
                    'name' => 'Title map',
                    ),
                1 => array(
                    'id' => 'description_map',
                    'type' => 'textarea',
                    'name' => 'Description map',
                    ),
                // 2 => array(
                //     'id' => 'map_iframe',
                //     'type' => 'textarea',
                //     'name' => 'Map iframe',
                //     ),
                'group_location_tour_map' => array(
                    'group_title' => 'Location {#}',
                    'collapsible' => true,
                    'id' => 'location_tour_map',
                    'type' => 'group',
                    'clone' => true,
                    'sort_clone' => true,
                    'fields' => array(
                        'location_first' => array(
                            'id' => 'location_first',
                            'name' => 'location first',
                            'type' => 'post',
                            'post_type' => 'destination',
                            'field_type' => 'select_advanced',
                            'query_args'  => array(
                                'post_status'    => 'publish',
                                'posts_per_page' => - 1,
                                'lang'  => $current_lang,
                            ), 
                            ),
                        'location_last' => array(
                            'id' => 'location_last',
                            'name' => 'Location last',
                            'type' => 'post',
                            'post_type' => 'destination',
                            'field_type' => 'select_advanced',
                            'query_args'  => array(
                                'post_status'    => 'publish',
                                'posts_per_page' => - 1,
                                'lang'  => $current_lang,
                            ), 
                            //'options' => $options_destination,
                            ),
                        'curvature' => array(
                            'id' => 'curvature',
                            'name' => 'Curvature',
                            'type' => 'text',
                            ),
                        ),
                    ),

                'group_itinerary' => array(
                    'group_title' => 'Itinerary {#} ',
                    'collapsible' => true,
                    'id' => 'itinerary',
                    'type' => 'group',
                    'clone' => true,
                    'sort_clone' => true,
                    'fields' => array(
                        0 => array(
                            'id' => 'day_title',
                            'type' => 'text',
                            'name' => 'Day title',
                            ),
                        1 => array(
                            'id' => 'itinerary_detail',
                            'type' => 'wysiwyg',
                            'name' => 'Itinerary detail',
                            ),
                        2 => array(
                            'id' => 'meals',
                            'type' => 'checkbox_list',
                            'name' => 'Meals',
                            'options' => array(
                                'breakfast' => 'Breakfast',
                                'lunch' => 'Lunch',
                                'dinner' => 'Dinner',
                                'no_meals' => 'No meal',
                                ),
                            'inline' => true,
                            ),
                        3 => array(
                            'id' => 'visited',
                            'type' => 'post',
                            'post_type' => 'destination',
                            'name' => 'Visited',
                            'multiple' => 'true',
                            'field_type' => 'select_advanced',
                            'query_args'  => array(
                                'post_status'    => 'publish',
                                'posts_per_page' => - 1,
                                'lang'  => $current_lang,
                            ), 
                            ),
                        4 => array(
                            'id' => 'accomodation',
                            'type' => 'post',
                            'post_type' => 'hotel',
                            'name' => 'Accomodation',
                            'field_type' => 'select_advanced',
                            'multiple' => 'true',
                            'query_args'  => array(
                                'post_status'    => 'publish',
                                'posts_per_page' => - 1,
                                'lang'  => $current_lang,
                            ), 
                            ),
                        ),
                    ),
                'pdf_file' => array(
                    'id' => 'pdf_file',
                    'type' => 'file_advanced',
                    'name' => 'PDF file',
                    ),
                ),
            ),
        'tour_gallery' => array(
            'id' => 'tour_gallery',
            'title' => 'Gallery',
            'post_types' => 'tour',
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => true,
            'not_show' => true,
            'fields' => array('group_gallery' => array(
                    'group_title' => '{#}',
                    'collapsible' => true,
                    'id' => 'gallery',
                    'type' => 'group',
                    'clone' => true,
                    'sort_clone' => true,
                    'fields' => array(

                        0 => array(
                            'id' => 'image',
                            'type' => 'single_image',
                            'name' => 'Image',
                            ),
                        1 => array(
                            'id' => 'image_thumb',
                            'type' => 'single_image',
                            'name' => 'Image thumb',
                            ),
                        2 => array(
                            'id' => 'video',
                            'type' => 'text',
                            'name' => 'Video',
                            ),
                        3 => array(
                            'id' => 'title',
                            'type' => 'text',
                            'name' => 'Title',
                            ),
                        ),
                    ), ),
            ),
        'tour_price_match_guarantee' => array(
            'id' => 'tour_price_match_guarantee',
            'title' => 'Price match guarantee',
            'post_types' => 'tour',
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => true,
            'not_show' => true,
            'fields' => array(
                'price_match_title' => array(
                    'id' => 'price_match_title',
                    'type' => 'text',
                    'name' => 'Title',
                    ),

                'price_match_guarantee' => array(
                    'id' => 'price_match_guarantee',
                    'type' => 'wysiwyg',
                    'name' => 'Price match guarantee',
                    ),
                'price_match_post' => array(
                    'id' => 'price_match_post',
                    'type' => 'post',
                    'post_type' => 'text_samples',
                    'name' => 'Text samples',
                    'field_type' => 'select_advanced',
                    'multiple' => false,
                    'query_args'  => array(
                        'post_status'    => 'publish',
                        'posts_per_page' => - 1,
                        'lang'  => $current_lang,
                    ), 
                    ),

                ),
            ),
        'tour_why_book_this_trip' => array(
            'id' => 'tour_why_book_this_trip',
            'title' => 'Why book this trip',
            'post_types' => 'tour',
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => true,
            'not_show' => true,
            'fields' => array(
                'why_book_title' => array(
                    'id' => 'why_book_title',
                    'type' => 'text',
                    'name' => 'Title',
                    ),
                'why_book_this_trip' => array(
                    'id' => 'why_book_this_trip',
                    'type' => 'wysiwyg',
                    'name' => 'Why book this trip',
                    ),
                 'why_book_post' => array(
                    'id' => 'why_book_post',
                    'type' => 'post',
                    'post_type' => 'text_samples',
                    'name' => 'Text samples',
                    'field_type' => 'select_advanced',
                    'multiple' => false,
                    'query_args'  => array(
                        'post_status'    => 'publish',
                        'posts_per_page' => - 1,
                        'lang'  => $current_lang,
                    ), 
                    ),                    
                ),
            ),
        'tour_info' => array(
            'id' => 'tour_info',
            'title' => 'Tour infomation',
            'post_types' => 'tour',
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => true,
            'not_show' => true,
            'fields' => array('group_inclussion' => array(
                    'group_title' => '{#}',
                    'collapsible' => true,
                    'id' => 'inclussion',
                    'type' => 'group',
                    'clone' => true,
                    'sort_clone' => true,
                    'fields' => array(
                        'inclussion_title' => array(
                            'id' => 'inclussion_title',
                            'type' => 'text',
                            'name' => 'Inclussion title',
                            ),
                        'inclussion_detail' => array(
                            'id' => 'inclussion_detail',
                            'type' => 'wysiwyg',
                            'name' => 'Inclussion detail',
                            ),
                        'other_info' => array(
                            'id' => 'other_info',
                            'type' => 'post',
                            'post_type' => 'tour_infor',
                            'name' => 'Other information',
                            'field_type' => 'select_advanced',
                            'multiple' => false,
                            'query_args'  => array(
                                'post_status'    => 'publish',
                                'posts_per_page' => - 1,
                                'lang'  => $current_lang,
                            ), 
                            ),
                        'restaurants_in_tour' => array(
                            'id' => 'restaurants_in_tour',
                            'type' => 'post',
                            'post_type' => 'restaurant',
                            'name' => 'Restaurants in tour',
                            'field_type' => 'select_advanced',
                            'multiple' => true,
                            'query_args'  => array(
                                'post_status'    => 'publish',
                                'posts_per_page' => - 1,
                                'lang'  => $current_lang,
                            ), 
                            ),
                        'hotels_in_tour' => array(
                            'id' => 'hotels_in_tour',
                            'type' => 'post',
                            'post_type' => 'hotel',
                            'name' => 'Hotels in tour',
                            'field_type' => 'select_advanced',
                            'multiple' => true,
                            'query_args'  => array(
                                'post_status'    => 'publish',
                                'posts_per_page' => - 1,
                                'lang'  => $current_lang,
                            ), 
                            ),
                        ),
                    ), ),
            ),
        'explore_another_tour' => array(
            'id' => 'explore_another_tour',
            'title' => 'Explore another tour',
            'post_types' => 'tour',
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => true,
            'not_show' => true,
            'fields' => array('explore_another_tour' => array(
                    'id' => 'explore_another_tour',
                    'type' => 'post',
                    'name' => 'Explore another tour',
                    'post_type' => 'tour',
                    'multiple' => true,
                    'field_type' => 'select_advanced',
                    'query_args' => array(
                        'post_status' => 'publish',
                        'posts_per_page' => -1,
                        'exclude' => $_GET['post'],
                        'lang' => $current_lang,
                        ),
                    ), ),
            ),
        // 'flight_tour' => array(
        //     'id' => 'flight_tour',
        //     'title' => 'Flights for tour',
        //     'post_types' => 'tour',
        //     'context' => 'advanced',
        //     'priority' => 'default',
        //     'autosave' => true,
        //     //'not_show' => true,
        //     'fields' => array('flight_tour' => array(
        //             'id' => 'flight_tour',
        //             'type' => 'taxonomy',
        //             'name' => 'Flight',
        //             'taxonomy' => 'flight',
        //             'multiple' => true,
        //             'field_type' => 'select_advanced',
        //             ), ),
        //     ),

        )); }
);

$role = get_role("administrator");
if (!empty($role))
{
    $role->add_cap("edit_tour");
    $role->add_cap("delete_tour");
    $role->add_cap("read_tour");
    $role->add_cap("edit_tours");
    $role->add_cap("delete_tours");
    $role->add_cap("edit_others_tours");
    $role->add_cap("publish_tours");
    $role->add_cap("read_private_tours");
    $role->add_cap("create_tours");

}
register_post_type('text_samples', array(
    'labels' => array('name' => __('Text samples'), 'singular_name' => __('Text samples')),
    'public' => true,
    'has_archive' => true,
    'query_var' => false,
    'can_export' => false,
    'delete_with_user' => true,
    'capability_type' => 'text_samples',
    'columns' => array(),
    'actions' => array(),
    'supports' => array(
        'title',
        'editor',
        'thumbnail'),
    ));
$role = get_role("administrator");
if (!empty($role))
{
    $role->add_cap("edit_text_samples");
    $role->add_cap("delete_text_samples");
    $role->add_cap("read_text_samples");
    $role->add_cap("edit_text_sampless");
    $role->add_cap("delete_text_sampless");
    $role->add_cap("edit_others_text_sampless");
    $role->add_cap("publish_text_sampless");
    $role->add_cap("read_private_text_sampless");
    $role->add_cap("create_text_sampless");

}
register_post_type('sic_tour_rate', array(
    'labels' => array('name' => __('SIC tour rate'), 'singular_name' => __('SIC tour rate')),
    'public' => true,
    'has_archive' => true,
    'query_var' => false,
    'can_export' => false,
    'delete_with_user' => true,
    'capability_type' => 'sic_tour_rate',
    'columns' => array(),
    'actions' => array(),
    'supports' => array('title','thumbnail'),
    ));
add_filter('rwmb_meta_boxes', function ($meta_boxes)
{
    $current_lang = pll_current_language();
    return array_merge($meta_boxes, array(
        'sic_tour_name' => array(
            'id' => 'sic_tour_name',
            'title' => 'Tour name',
            'post_types' => 'sic_tour_rate',
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => true,
            'not_show' => false,
            'fields' => array(2 => array(
                    'id' => 'tour_name',
                    'type' => 'post',
                    'name' => 'SIC tour name',
                    'post_type' => 'tour',
                    'field_type' => 'select_advanced',
                    'query_args' => array(
                        'post_status' => 'publish',
                        'posts_per_page' => -1,
                        'lang'  => $current_lang,
                        ),
                    //  'columns' => '12',
                    ), ),
            ),
        'sic_rate' => array(
            'id' => 'sic_rate',
            'title' => 'SIC tour rate',
            'post_types' => 'sic_tour_rate',
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => true,
            'not_show' => false,
            'fields' => array('group_sic_rate' => array(
                    'group_title' => '{#}',
                    'collapsible' => true,
                    'id' => 'group_sic_rate',
                    'type' => 'group',
                    'clone' => true,
                    'columns' => 12,
                    'sort_clone' => true,
                    'fields' => array(
                        'from_date' => array(
                            'id' => 'from_date',
                            'type' => 'date',
                            'name' => 'From date',
                            'timestamp' => 'true',
                            'columns' => 4,
                            ),
                        'to_date' => array(
                            'id' => 'to_date',
                            'type' => 'date',
                            'name' => 'To date',
                            'timestamp' => 'true',
                            'columns' => 4,
                            ),
                        'tour_rate' => array(
                            'id' => 'tour_rate',
                            'type' => 'number',
                            'name' => 'Price per person',
                             'columns' => 4,
                            ),
                        ),
                    ), ),
            ),
        )); }
);

$role = get_role("administrator");
if (!empty($role))
{
    $role->add_cap("edit_sic_tour_rate");
    $role->add_cap("delete_sic_tour_rate");
    $role->add_cap("read_sic_tour_rate");
    $role->add_cap("edit_sic_tour_rates");
    $role->add_cap("edit_others_sic_tour_rates");
    $role->add_cap("publish_sic_tour_rates");
    $role->add_cap("read_private_sic_tour_rates");
    $role->add_cap("create_sic_tour_rates");

}
register_post_type('customize_rate', array(
    'labels' => array('name' => __('Customize tour rate'), 'singular_name' => __('Customize tour rate')),
    'public' => true,
    'has_archive' => true,
    'query_var' => false,
    'can_export' => false,
    'delete_with_user' => true,
    'capability_type' => 'customize_rate',
    'columns' => array(),
    'actions' => array(),
    'supports' => array('title','thumbnail'),
    ));
add_filter('rwmb_meta_boxes', function ($meta_boxes)
{
    $current_lang = pll_current_language();
    return array_merge($meta_boxes, array(
        'tour_name' => array(
            'id' => 'tour_name',
            'title' => 'Tour name',
            'post_types' => 'customize_rate',
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => true,
            'not_show' => false,
            'fields' => array(2 => array(
                    'id' => 'tour_name_customize',
                    'type' => 'post',
                    'name' => 'Tour name',
                    'post_type' => 'tour',
                    'field_type' => 'select_advanced',
                    'replace_to_customize_rate' => 'post_title',
                    'query_args' => array(
                        'post_status' => 'publish',
                        'posts_per_page' => -1,
                        'lang'  => $current_lang,
                        ),
                    //  'columns' => '12',
                    ), ),
            ),
        'customize_rate' => array(
            'id' => 'tour_rate',
            'title' => 'Tour rate',
            'post_types' => 'customize_rate',
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => true,
            'not_show' => false,

            'fields' => array('group_tour_rate' => array(
                    'group_title' => '{#}',
                    'collapsible' => true,
                    'id' => 'group_tour_rate',
                    'type' => 'group',
                    'clone' => true,
                    'columns' => 12,
                    'sort_clone' => true,
                    'fields' => array(
                            'from_date' => array(
                            'id' => 'from_date',
                            'type' => 'date',
                            'name' => 'From date',
                            'timestamp' => 'true',
                            'columns' => 6,
                            ),
                        'to_date' => array(
                            'id' => 'to_date',
                            'type' => 'date',
                            'name' => 'To date',
                            'timestamp' => 'true',
                            'columns' => 6,
                            ),
                        'single_supplement' => array(
                            'id' => 'single_supplement',
                            'type' => 'number',
                            'name' => 'Single Supplement',
                             'columns' => 6,
                            ),
                        'english_guide' => array(
                            'id' => 'english_guide',
                            'type' => 'number',
                            'name' => 'English guide',
                             'columns' => 6,
                            ),
                        'spanish_guide' => array(
                            'id' => 'spanish_guide',
                            'type' => 'number',
                            'name' => 'Spanish guide',
                             'columns' => 6,
                            ),
                        'portugese_guide' => array(
                            'id' => 'portugese_guide',
                            'type' => 'number',
                            'name' => 'Portugese guide',
                             'columns' => 6,
                            ),
                        'group_rate' => array(
                            'group_title' => 'Pax{#}',
                            'collapsible' => true,
                            'id' => 'group_rate',
                            'type' => 'group',
                            'clone' => true,
                            'sort_clone' => true,
                            'fields' => array(
                                'from' => array(
                                    'id' => 'from',
                                    'type' => 'number',
                                    'name' => 'From',
                                    'columns' => 4,
                                    ),
                                'to' => array(
                                    'id' => 'to',
                                    'type' => 'number',
                                    'name' => 'To',
                                    'columns' => 4,
                                    ),
                                'price' => array(
                                    'id' => 'price',
                                    'type' => 'number',
                                    'name' => 'Price per person',
                                    'columns' => 4,
                                    ),
                                ),
                            ),
                    
                        ),
                    ), ),
            ),
        )); }
);

$role = get_role("administrator");
if (!empty($role))
{
    $role->add_cap("edit_customize_rate");
    $role->add_cap("delete_customize_rate");
    $role->add_cap("read_customize_rate");
    $role->add_cap("edit_customize_rates");
    $role->add_cap("edit_others_customize_rates");
    $role->add_cap("publish_customize_rates");
    $role->add_cap("read_private_customize_rates");
    $role->add_cap("create_customize_rates");

}
register_post_type('hotel', array(
    'labels' => array('name' => __('Hotel'), 'singular_name' => __('Hotel')),
    'public' => true,
    'has_archive' => true,
    'query_var' => false,
    'can_export' => false,
    'delete_with_user' => true,
    'capability_type' => 'hotel',
    'columns' => array(),
    'actions' => array(),
    'supports' => array(
        'title',
        'excerpt',
        'thumbnail'),
    ));
add_filter('rwmb_meta_boxes', function ($meta_boxes)
{
    $current_lang = pll_current_language();
    $terms_destination = get_terms('category-destination', array(
        'hide_empty' => false,
        'parent' => 0,
        )); 
    foreach ($terms_destination as $key => $term_destination)
    {
        $options[$term_destination->name] = $term_destination->slug; }
    return array_merge($meta_boxes, array(
        // '' => array(
        //     'id' => '',
        //     'title' => 'Over view',
        //     'post_types' => 'hotel',
        //     'context' => 'advanced',
        //     'priority' => 'default',
        //     'autosave' => true,
        //     'not_show' => false,
        //     'fields' => array(
        //         0 => array(
        //             'id' => 'over_view',
        //             'type' => 'text',
        //             'name' => 'Over view',
        //             ), ),
        //     ),
        'over_view' => array(
            'id' => 'over_view',
            'title' => 'Over view',
            'post_types' => 'hotel',
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => true,
            'not_show' => false,
            'fields' => array(
                0 => array(
                    'id' => 'image_banner',
                    'type' => 'image_advanced',
                    'name' => 'Image banner',
                    ),
                1 => array(
                    'id' => 'over_view_text',
                    'type' => 'wysiwyg',
                    'name' => 'Over view text',
                    //'columns' => '12',
                    ),
                // 2 => array(
                //     'id' => 'location',
                //     'type' => 'taxonomy',
                //     'name' => 'Location',
                //     'taxonomy' => 'category-destination',
                //     'field_type' => 'select_advanced',
                //     'replace_to_hotel' => 'cat_category-destination',
                //     ),
                //                3 => array(
                //                    'id' => 'hotel_style',
                //                    'type' => 'taxonomy',
                //                    'name' => 'Hotel style',
                //                    'taxonomy' => 'hotel_style',
                //                    'field_type' => 'checkbox_list',
                //                    'replace_to_hotel' => 'cat_hotel_style',
                //                    'columns' => '4',
                //                    ),
                4 => array(
                    'id' => 'no_of_rooms',
                    'type' => 'number',
                    'name' => 'No. of rooms',
                    ),
                5 => array(
                    'id' => 'price_from',
                    'type' => 'number',
                    'name' => 'Price from',
                    ),
                7 => array(
                    'id' => 'key_features',
                    'type' => 'text',
                    'name' => 'Key features',
                    ),
                ),
            ),
        'gallery' => array(
            'id' => 'gallery',
            'title' => 'Gallery',
            'post_types' => 'hotel',
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => true,
            'not_show' => true,
            'fields' => array('group_gallery' => array(
                    'group_title' => '{#}',
                    'collapsible' => true,
                    'id' => 'gallery',
                    'type' => 'group',
                    'clone' => true,
                    'sort_clone' => true,
                    'fields' => array(
                        0 => array(
                            'id' => 'title',
                            'type' => 'text',
                            'name' => 'Title',
                            ),
                        1 => array(
                            'id' => 'image',
                            'type' => 'image_advanced',
                            'name' => 'Image',
                            ),
                        ),
                    ), ),
            ),
        'accommondation' => array(
            'id' => 'accommondation',
            'title' => 'Accommondation',
            'post_types' => 'hotel',
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => true,
            'not_show' => true,
            'fields' => array(
                'group_hotel_detail' => array(
                    'group_title' => '{#}',
                    'collapsible' => true,
                    'id' => 'hotel_detail',
                    'type' => 'group',
                    'clone' => true,
                    'sort_clone' => true,
                    'fields' => array(
                        'room_img' => array(
                            'id' => 'room_img',
                            'type' => 'image_advanced',
                            'name' => 'Room image',
                            ),
                        'room_img_title' => array(
                            'id' => 'room_img_title',
                            'type' => 'text',
                            'name' => 'Image titel',
                            ),
                        ),
                    ),
                'detail_left' => array(
                    'id' => 'detail_left',
                    'type' => 'wysiwyg',
                    'name' => 'Detail left',
                    ),
                'detail_right' => array(
                    'id' => 'detail_right',
                    'type' => 'wysiwyg',
                    'name' => 'Detail -right',
                    ),
                ),
            ),
        'location' => array(
            'id' => 'location',
            'title' => 'Location hotel',
            'post_types' => 'hotel',
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => true,
            'not_show' => false,
            'fields' => array(
                    0 => array(
                        'id' => 'title_location',
                        'type' => 'text',
                        'name' => 'Title',
                    ),
                    1 => array(
                    'id' => 'location_hotel',
                    'type' => 'wysiwyg',
                    'name' => 'Content',
                    ), ),
            ),
        'map' => array(
            'id' => 'map',
            'title' => 'Map hotel',
            'post_types' => 'hotel',
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => true,
            'not_show' => false,
            'fields' => array(0 => array(
                    'id' => 'map_hotel',
                    'type' => 'textarea',
                    'name' => '',
                    ), ),
            ),
        //'thing_to_do' => array(
        //            'id' => 'thing_to_do',
        //            'title' => 'Thing to do',
        //            'post_types' => 'hotel',
        //            'context' => 'advanced',
        //            'priority' => 'default',
        //            'autosave' => true,
        //            'not_show' => true,
        //            'fields' => array('group_thing_to_do' => array(
        //                    'group_title' => '{#}',
        //                    'collapsible' => true,
        //                    'id' => 'thing_to_do',
        //                    'type' => 'group',
        //                    'clone' => true,
        //                    'sort_clone' => true,
        //                    'fields' => array(
        //                        0 => array(
        //                            'id' => 'image',
        //                            'type' => 'image_advanced',
        //                            'name' => 'Image',
        //                            ),
        //                        1 => array(
        //                            'id' => 'thing_to_do_title',
        //                            'type' => 'text',
        //                            'name' => 'Thing to do title',
        //                            //  'columns' => '12',
        //                            ),
        //                        2 => array(
        //                            'id' => 'thing_to_do_detail',
        //                            'type' => 'wysiwyg',
        //                            'name' => 'Thing to do detail',
        //                            //  'columns' => '12',
        //                            ),
        //                        ),
        //                    ), ),
        //            ),
        'thing_to_do' => array(
            'id' => 'thing_to_do',
           'title' => 'Thing to do',
           'post_types' => 'hotel',
           'context' => 'advanced',
           'priority' => 'default',
           'autosave' => true,
           'not_show' => true,
            'fields' => array(
                // 'things_to_do' => array(
                //     'id' => 'things_to_do',
                //     'type' => 'post',
                //     'post_type' => 'highlight',
                //     'name' => 'Tour highlight',
                //     'field_type' => 'select_advanced',
                //     'multiple' => 'true',
                //     'max_file_uploads' => 2,
                //     'query_args'  => array(
                //         'post_status'    => 'publish',
                //         'posts_per_page' => - 1,
                //         'lang'  => $current_lang,
                //     ), 
                //     ),
                // 'destination' => array(
                //     'id' => 'destination',
                //     'type' => 'post',
                //     'post_type' => 'destination',
                //     'name' => 'Destination',
                //     'field_type' => 'select_advanced',
                //     'multiple' => 'true',
                //     'query_args'  => array(
                //         'post_status'    => 'publish',
                //         'posts_per_page' => - 1,
                //         'lang'  => $current_lang,
                //     ), 
                //     ),
                'hotel' => array(
                    'id' => 'hotel',
                    'type' => 'post',
                    'post_type' => 'hotel',
                    'name' => 'Hotel',
                    'field_type' => 'select_advanced',
                    'multiple' => 'true',
                    'query_args'  => array(
                        'post_status'    => 'publish',
                        'posts_per_page' => - 1,
                        'lang'  => $current_lang,
                    ), 
                    ),
                // 'restaurant' => array(
                //     'id' => 'restaurant',
                //     'type' => 'post',
                //     'post_type' => 'restaurant',
                //     'name' => 'Restaurant',
                //     'field_type' => 'select_advanced',
                //     'multiple' => 'true',
                //     'query_args'  => array(
                //         'post_status'    => 'publish',
                //         'posts_per_page' => - 1,
                //         'lang'  => $current_lang,
                //     ), 
                //     ),
                // 'blog' => array(
                //     'id' => 'blog',
                //     'type' => 'post',
                //     'post_type' => 'post',
                //     'name' => 'Blog',
                //     'field_type' => 'select_advanced',
                //     'multiple' => 'true',
                //     'query_args'  => array(
                //         'post_status'    => 'publish',
                //         'posts_per_page' => - 1,
                //         'lang'  => $current_lang,
                //     ), 
                //     ),
                ),
            ),
        'alternative_hotel' => array(
            'id' => 'alternative_hotel',
            'title' => 'Alternative hotel',
            'post_types' => 'hotel',
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => true,
            'not_show' => false,
            'fields' => array(
                0 => array(
                    'id' => 'alternative_hotel',
                    'type' => 'post',
                    'name' => 'Alternative hotel',
                    'post_type' => 'hotel',
                    'field_type' => 'select_advanced',
                    'multiple' => 'true',
                    'query_args' => array(
                        'post_status' => 'publish',
                        'posts_per_page' => -1,
                        'lang'  => $current_lang,
                        ),
                    'columns' => '12',
                    ),
                // 1 => array(
                //     'id' => 'view_city',
                //     'type' => 'checkbox',
                //     'name' => 'View City',
                //     ),
                ),

            ),
        )); }
);

$role = get_role("administrator");
if (!empty($role))
{
    $role->add_cap("edit_hotel");
    $role->add_cap("delete_hotel");
    $role->add_cap("read_hotel");
    $role->add_cap("edit_hotels");
    $role->add_cap("edit_others_hotels");
    $role->add_cap("publish_hotels");
    $role->add_cap("read_private_hotels");
    $role->add_cap("create_hotels");

}
register_post_type('expert', array(
    'labels' => array('name' => __('Expert'), 'singular_name' => __('Expert')),
    'public' => true,
    'has_archive' => true,
    'query_var' => false,
    'can_export' => false,
    'delete_with_user' => true,
    'capability_type' => 'expert',
    'columns' => array(),
    'actions' => array(),
    'supports' => array('title', 'thumbnail'),
    ));
add_filter('rwmb_meta_boxes', function ($meta_boxes)
{
    return array_merge($meta_boxes, array('expert_info' => array(
            'id' => 'expert_info',
            'title' => 'Expert information',
            'post_types' => 'expert',
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => true,
            'not_show' => false,
            'fields' => array(
                1 => array(
                    'id' => 'Specialize',
                    'type' => 'text',
                    'name' => 'Specialize',
                    //  'columns' => '12',
                    ),
                2 => array(
                    'id' => 'Introduce',
                    'type' => 'textarea',
                    'name' => 'Introduce',
                    // 'columns' => '12',
                    ),
                4 => array(
                    'id' => 'expert_view_home',
                    'type' => 'checkbox',
                    'name' => 'View home',
                    //   'columns' => '12',
                    ),
                5 => array(
                    'id' => 'expert_view_blog',
                    'type' => 'checkbox',
                    'name' => 'View blog',
                    //   'columns' => '12',
                    ),
                6 => array(
                    'id' => 'expert_view_hotel',
                    'type' => 'checkbox',
                    'name' => 'View hotel',
                    //   'columns' => '12',
                    ),
                7 => array(
                    'id' => 'expert_view_restaurant',
                    'type' => 'checkbox',
                    'name' => 'View restaurant',
                    //   'columns' => '12',
                    ),
                ),
            ), )); }
);

$role = get_role("administrator");
if (!empty($role))
{
    $role->add_cap("edit_expert");
    $role->add_cap("delete_expert");
    $role->add_cap("read_expert");
    $role->add_cap("edit_experts");
    $role->add_cap("edit_others_experts");
    $role->add_cap("publish_experts");
    $role->add_cap("read_private_experts");
    $role->add_cap("create_experts");

}

register_post_type('customer_feedback', array(
    'labels' => array('name' => __('Customer Feedback'), 'singular_name' => __('Customer Feedback')),
    'public' => true,
    'has_archive' => true,
    'query_var' => false,
    'can_export' => false,
    'delete_with_user' => true,
    'capability_type' => 'customer_feedback',
    'columns' => array(),
    'actions' => array(),
    'supports' => array('title', 'thumbnail'),
    ));
add_filter('rwmb_meta_boxes', function ($meta_boxes)
{
    $current_lang = pll_current_language();
    return array_merge($meta_boxes, array('feedback_info' => array(
            'id' => 'feedback_info',
            'title' => 'Feedback infor',
            'post_types' => 'customer_feedback',
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => true,
            'not_show' => false,
            'fields' => array(
                0 => array(
                    'id' => 'guest_name',
                    'type' => 'text',
                    'name' => 'Guest name',
                    //  'columns' => '12',
                    ),
                1 => array(
                    'id' => 'title',
                    'type' => 'text',
                    'name' => 'Title',
                    'size' => 100
                    // 'columns' => '12',
                    ),
                2 => array(
                    'id' => 'content',
                    'type' => 'wysiwyg',
                    'name' => 'Content',
                    // 'columns' => '12',
                    ),
                3 => array(
                    'id' => 'from',
                    'type' => 'taxonomy',
                    'name' => 'From',
                    'taxonomy' => 'country',
                    'field_type' => 'select_advanced',
                    'replace_to_customer_feedback' => 'cat_country',
                    //   'columns' => '12',
                    ),
                4 => array(
                    'id' => 'tour',
                    'type' => 'post',
                    'name' => 'Tour',
                    'post_type' => 'tour',
                    'field_type' => 'select_advanced',
                    'query_args' => array(
                        'post_status' => 'publish',
                        'posts_per_page' => -1,
                        'lang'  => $current_lang,
                        ),
                    //  'columns' => '12',
                    ),
                5 => array(
                    'id' => 'destination_category',
                    'type' => 'taxonomy',
                    'name' => 'Destination category',
                    'taxonomy' => 'category-destination',
                    'field_type' => 'checkbox_list',
                    'replace_to_customer_feedback' => 'cat_destination',
                    //    'columns' => '12',
                    ),
                ),
            ), )); }
);

$role = get_role("administrator");
if (!empty($role))
{
    $role->add_cap("edit_customer_feedback");
    $role->add_cap("delete_customer_feedback");
    $role->add_cap("read_customer_feedback");
    $role->add_cap("edit_customer_feedbacks");
    $role->add_cap("edit_others_customer_feedbacks");
    $role->add_cap("publish_customer_feedbacks");
    $role->add_cap("read_private_customer_feedbacks");
    $role->add_cap("create_customer_feedbacks");

}
register_post_type('partner', array(
    'labels' => array('name' => __('Partner'), 'singular_name' => __('Partner')),
    'public' => true,
    'has_archive' => true,
    'query_var' => false,
    'can_export' => false,
    'delete_with_user' => true,
    'capability_type' => 'partner',
    'columns' => array(),
    'actions' => array(),
    'supports' => array('title', 'thumbnail'),
    ));
add_filter('rwmb_meta_boxes', function ($meta_boxes)
{
    return array_merge($meta_boxes, array('partner_info' => array(
            'id' => 'partner_info',
            'title' => 'Partner info',
            'post_types' => 'partner',
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => true,
            'not_show' => false,
            'fields' => array(
                0 => array(
                    'id' => 'partner',
                    'type' => 'free text',
                    'name' => 'partner',
                    //  'columns' => '12',
                    ),
                1 => array(
                    'id' => 'Image',
                    'type' => 'image_advanced',
                    'name' => 'Image',
                    //  'columns' => '12',
                    ),
                ),
            ), )); }
);

$role = get_role("administrator");
if (!empty($role))
{
    $role->add_cap("edit_partner");
    $role->add_cap("delete_partner");
    $role->add_cap("read_partner");
    $role->add_cap("edit_partners");
    $role->add_cap("edit_others_partners");
    $role->add_cap("publish_partners");
    $role->add_cap("read_private_partners");
    $role->add_cap("create_partners");

}
register_post_type('exchange_rate', array(
    'labels' => array('name' => __('Exchange rate'), 'singular_name' => __('Exchange rate')),
    'public' => true,
    'has_archive' => true,
    'query_var' => false,
    'can_export' => false,
    'delete_with_user' => true,
    'capability_type' => 'exchange_rate',
    'columns' => array(),
    'actions' => array(),
    'supports' => array('title', 'thumbnail'),
    ));
add_filter('rwmb_meta_boxes', function ($meta_boxes)
{
    return array_merge($meta_boxes, array('exchange_rate' => array(
            'id' => 'exchange_rate',
            'title' => 'Exchange rate',
            'post_types' => 'exchange_rate',
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => true,
            'not_show' => false,
            'fields' => array(
                0 => array(
                    'id' => 'from_date',
                    'type' => 'date',
                    'name' => 'From date',
                    'timestamp' => true,
                    'columns' => '6',
                    ),
                1 => array(
                    'id' => 'to_date',
                    'type' => 'date',
                    'name' => 'To date',
                    'timestamp' => true,
                    'columns' => '6',
                    ),
                'group_currency' => array(
                    'group_title' => '{#}',
                    'collapsible' => true,
                    'id' => 'group_currency',
                    'type' => 'group',
                    'clone' => true,
                    'sort_clone' => true,
                    'fields' => array(
                        2 => array(
                            'id' => 'from_currency',
                            'type' => 'taxonomy',
                            'taxonomy' => 'currency',
                            'field_type' => 'select_advanced',
                            'replace_to_exchange_rate' => 'cat_currency',
                            'name' => 'From Currency',
                            'columns' => '6',
                            ),
                        3 => array(
                            'id' => 'Value',
                            'type' => 'mumber',
                            'name' => 'Value',
                            'columns' => '6',
                            ),
                        ),
                    ),),
            ), )); }
);

$role = get_role("administrator");
if (!empty($role))
{
    $role->add_cap("edit_exchange_rate");
    $role->add_cap("delete_exchange_rate");
    $role->add_cap("read_exchange_rate");
    $role->add_cap("edit_exchange_rates");
    $role->add_cap("edit_others_exchange_rates");
    $role->add_cap("publish_exchange_rates");
    $role->add_cap("read_private_exchange_rates");
    $role->add_cap("create_exchange_rates");

}
register_post_type('contact_info', array(
    'labels' => array('name' => __('Contact info'), 'singular_name' => __('Contact info')),
    'public' => true,
    'has_archive' => true,
    'query_var' => false,
    'can_export' => false,
    'delete_with_user' => true,
    'capability_type' => 'contact_info',
    'columns' => array(),
    'actions' => array(),
    'supports' => array('title', 'thumbnail'),
    ));
add_filter('rwmb_meta_boxes', function ($meta_boxes)
{
    return array_merge($meta_boxes, array('contact_info' => array(
            'id' => 'contact_info',
            'title' => 'Contact info',
            'post_types' => 'contact_info',
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => true,
            'not_show' => false,
            'fields' => array(
                0 => array(
                    'id' => 'content_info',
                    'type' => 'wysiwyg',
                    'name' => 'Content info',
                    'columns' => '12',
                    ),
                1 => array(
                    'id' => 'tel',
                    'type' => 'text',
                    'name' => 'Tel',
                    'columns' => '12',
                    ),
                2 => array(
                    'id' => 'position',
                    'type' => 'select',
                    'name' => 'Position',
                    'options' => array(
                        'home' => 'Home',
                        'destination_list' => 'Destination list',
                        ),
                    'columns' => '12',
                    ),
                ),
            ), )); }
);

$role = get_role("administrator");
if (!empty($role))
{
    $role->add_cap("edit_contact_info");
    $role->add_cap("delete_contact_info");
    $role->add_cap("read_contact_info");
    $role->add_cap("edit_contact_infos");
    $role->add_cap("edit_others_contact_infos");
    $role->add_cap("publish_contact_infos");
    $role->add_cap("read_private_contact_infos");
    $role->add_cap("create_contact_infos");

}
register_post_type('highlight', array(
    'labels' => array('name' => __('Highlight/Things to do'), 'singular_name' => __('Highlight/Things to do')),
    'public' => true,
    'has_archive' => true,
    'query_var' => false,
    'can_export' => false,
    'delete_with_user' => true,
    'capability_type' => 'highlight',
    'columns' => array(),
    'actions' => array(),
    'supports' => array(
        'title',
        'excerpt',
        'thumbnail'),
    ));
$role = get_role("administrator");
if (!empty($role))
{
    $role->add_cap("edit_highlight");
    $role->add_cap("delete_highlight");
    $role->add_cap("read_highlight");
    $role->add_cap("edit_highlights");
    $role->add_cap("edit_others_highlights");
    $role->add_cap("publish_highlights");
    $role->add_cap("read_private_highlights");
    $role->add_cap("create_highlights");

}
register_post_type('tour_infor', array(
    'labels' => array('name' => __('Tour information'), 'singular_name' => __('Tour information')),
    'public' => true,
    'has_archive' => true,
    'query_var' => false,
    'can_export' => false,
    'delete_with_user' => true,
    'capability_type' => 'tour_infor',
    'columns' => array(),
    'actions' => array(),
    'supports' => array(
        'title',
        'editor',
        'thumbnail'),
    ));

$role = get_role("administrator");
if (!empty($role))
{
    $role->add_cap("edit_tour_infor");
    $role->add_cap("delete_tour_infor");
    $role->add_cap("read_tour_infor");
    $role->add_cap("edit_tour_infors");
    $role->add_cap("edit_others_tour_infors");
    $role->add_cap("publish_tour_infors");
    $role->add_cap("read_private_tour_infors");
    $role->add_cap("create_tour_infors");

}
// register_taxonomy("location_tour", array("tour"), array(
//     "hierarchical" => true,
//     "query_var" => "category_name",
//     "rewrite" => array("slug" => "location_tour"),
//     "public" => true,
//     "show_ui" => true,
//     "show_admin_column" => true,
//     "labels" => array("name" => __("Maps location"), "singular_name" => __("Maps location")),
//     ));
// add_filter('rwmb_meta_boxes', function ($meta_boxes)
// {

//     $meta_boxes['mt_location_map'] = array(
//         'id' => 'mt_location_map',
//         'name' => 'Location Information',
//         'taxonomies' => 'location_tour',
//         'fields' => array(

//             '0' => array(
//                 'id' => 'description_spanish',
//                 'name' => 'Description  SPANISH',
//                 'type' => 'textarea',
//                 ),
//             '1' => array(
//                 'id' => 'description_portuguese',
//                 'name' => 'Description PORTUGUESE',
//                 'type' => 'textarea',
//                 ),
//             '2' => array(
//                 'id' => 'location',
//                 'name' => 'Location',
//                 'type' => 'text',
//                 ),
//             '3' => array(
//                 'id' => 'location_image',
//                 'name' => 'Location Image',
//                 'type' => 'image_advanced',
//                 ),
//             ),
//         ); return $meta_boxes; }
// , 11);
register_taxonomy("label_tour", array("tour"), array(
    "hierarchical" => true,
    "query_var" => "category_name",
    "rewrite" => array("slug" => "label_tour"),
    "public" => true,
    "show_ui" => true,
    "show_admin_column" => true,
    "labels" => array("name" => __("Label tour"), "singular_name" => __("Label tour")),
    ));
register_taxonomy("duration_tour", array("tour"), array(
    "hierarchical" => true,
    "query_var" => "category_name",
    "rewrite" => array("slug" => "duration_tour"),
    "public" => true,
    "show_ui" => true,
    "show_admin_column" => true,
    "labels" => array("name" => __("Duration tour"), "singular_name" => __("Duration tour")),
    ));
register_taxonomy("expert_team", array("expert"), array(
    "hierarchical" => true,
    "query_var" => "category_name",
    "rewrite" => array("slug" => "expert_team"),
    "public" => true,
    "show_ui" => true,
    "show_admin_column" => true,
    "labels" => array("name" => __("Expert team"), "singular_name" => __("Expert team")),
    ));
register_taxonomy("currency", array("exchange_rate"), array(
    "hierarchical" => true,
    "query_var" => "category_name",
    "rewrite" => array("slug" => "currency"),
    "public" => true,
    "show_ui" => true,
    "show_admin_column" => true,
    "labels" => array("name" => __("Currency"), "singular_name" => __("Currency")),
    ));
register_taxonomy("type_of_tour", array("tour"), array(
    "hierarchical" => true,
    "query_var" => "category_name",
    "rewrite" => array("slug" => "type_of_tour"),
    "public" => true,
    "show_ui" => true,
    "show_admin_column" => true,
    "labels" => array("name" => __("Type of tour"), "singular_name" => __("Type of tour")),
    ));
register_taxonomy("travel_style", array("tour"), array(
    "hierarchical" => true,
    "query_var" => "category_name",
    "rewrite" => array("slug" => "travel_style"),
    "public" => true,
    "show_ui" => true,
    "show_admin_column" => true,
    "labels" => array("name" => __("Travel style"), "singular_name" => __("Travel style")),
    ));
register_taxonomy("category-destination", array(
    "destination",
    "hotel",
    "customer_feedback",
    "post",
    'tour',
    'excursion',
    'travel-guide'), array(
    "hierarchical" => true,
    "query_var" => "category_destination_query",
    "rewrite" => array("slug" => "category-destination"),
    "public" => true,
    "show_ui" => true,
    "show_admin_column" => true,
    "labels" => array("name" => __("Destination category"), "singular_name" => __("Destination category")),
    ));
register_taxonomy("destination-visit", array(
    'excursion',), array(
    "hierarchical" => true,
    "query_var" => "destination-visit",
    "rewrite" => array("slug" => "destination-visit"),
    "public" => true,
    "show_ui" => true,
    "show_admin_column" => true,
    "labels" => array("name" => __("Destination visit"), "singular_name" => __("Destination visit")),
    ));
register_taxonomy("combo_tour", array("tour"), array(
    "hierarchical" => true,
    "query_var" => "category_name",
    "rewrite" => array("slug" => "combo_tour"),
    "public" => true,
    "show_ui" => true,
    "show_admin_column" => true,
    "labels" => array("name" => __("Combo tour"), "singular_name" => __("Combo tour")),
    ));
register_taxonomy("hotel_style", array("hotel"), array(
    "hierarchical" => true,
    "query_var" => "category_name",
    "rewrite" => array("slug" => "hotel_style"),
    "public" => true,
    "show_ui" => true,
    "show_admin_column" => true,
    "labels" => array("name" => __("Hotel style"), "singular_name" => __("Hotel style")),
    ));
register_taxonomy("country", array("customer_feedback"), array(
    "hierarchical" => true,
    "query_var" => "category_name",
    "rewrite" => array("slug" => "country"),
    "public" => true,
    "show_ui" => true,
    "show_admin_column" => true,
    "labels" => array("name" => __("Country"), "singular_name" => __("Country")),
    ));
//register_taxonomy("highlight_city", array("tour"), array(
//    "hierarchical" => false,
//    "query_var" => "category_name",
//    "rewrite" => array("slug" => "highlight_city"),
//    "public" => true,
//    "show_ui" => true,
//    "show_admin_column" => true,
//    "labels" => array("name" => __("Highlight city"), "singular_name" => __("Highlight city")),
//    ));
register_taxonomy("key_features", array("hotel", "restaurant"), array(
    "hierarchical" => false,
    "query_var" => "category_name",
    "rewrite" => array("slug" => "key_features"),
    "public" => true,
    "show_ui" => true,
    "show_admin_column" => true,
    "labels" => array("name" => __("Key features"), "singular_name" => __("Key features")),
    ));
register_taxonomy("res_style", array("restaurant"), array(
    "hierarchical" => true,
    "query_var" => "category_name",
    "rewrite" => array("slug" => "res_style"),
    "public" => true,
    "show_ui" => true,
    "show_admin_column" => true,
    "labels" => array("name" => __("Restaurant style"), "singular_name" => __("Restaurant style")),
    ));
register_taxonomy("tour_guide", array("tour"), array(
    "hierarchical" => true,
    "query_var" => "category_name",
    "rewrite" => array("slug" => "tour_guide"),
    "public" => true,
    "show_ui" => true,
    "show_admin_column" => true,
    "labels" => array("name" => __("Tour guide"), "singular_name" => __("Tour guide")),
    ));
register_taxonomy("flight", array("tour"), array(
    "hierarchical" => true,
    "query_var" => "category_name",
    "rewrite" => array("slug" => "flight"),
    "public" => true,
    "show_ui" => true,
    "show_admin_column" => true,
    "labels" => array("name" => __("Flight"), "singular_name" => __("Flight")),
    ));
add_filter('rwmb_meta_boxes', function ($meta_boxes)
{
    // $current_lang = 'en';
    // $args = array(
    //     'taxonomy' => 'category-destination',
    //     'hide_empty' => false,
    //     'parent' => 0,
    //     'lang'  => $current_lang,
    //     );
    // $terms_destination = get_terms('category-destination', $args); 
    // foreach ($terms_destination as $key => $tax)
    // {
    //     $lang_cate = pll_get_term_language($tax->term_id);
    //     if( $lang_cate !== $args['lang'] ){
    //         unset($terms_destination[$key]);
    //     }
    //     $terms_destination = array_values($terms_destination);
    // }
    // foreach ($terms_destination as $key => $term)
    // {
    //     $options_des[$term->term_id] = $term->name; 
    // }

    $current_lang = pll_current_language();
    $args = array(
        'taxonomy' => 'category-destination',
        'hide_empty' => false,
        'parent' => 0,
        'lang'  => $current_lang,
        );
    $terms_destination = get_terms('category-destination', $args ); 
    if($terms_destination){
            foreach ($terms_destination as $key => $tax) {
                if(pll_get_term_language($tax->term_id) !== $args['lang']){
                    unset($terms_destination[$key]);
                }
            }
            $terms_destination = array_values($terms_destination);
    }
    foreach ($terms_destination as $key => $term)
    {
    $destination_opt[$term->slug] = $term->name; }

    return array_merge($meta_boxes, array(
        'img_destination' => array(
            'id' => 'img_destination',
            'name' => 'Destination Feature Image',
            'taxonomies' => 'category-destination',
            'fields' => array(0 => array(
                    'id' => 'des_feature_img',
                    'type' => 'image_advanced',
                    'multiple' => false,
                    'name' => 'Feature image',
                    ), ),
            ),
        'duration_tour' => array(
            'id' => 'duration_tour',
            'name' => 'Duration tour',
            'taxonomies' => 'duration_tour',
            'fields' => array(0 => array(
                    'id' => 'duration_from',
                    'type' => 'number',
                    'name' => 'Duration from',
                    ),
                    1 => array(
                    'id' => 'duration_to',
                    'type' => 'number',
                    'name' => 'Duration to',
                    ), ),
            ),
        'des_view_home' => array(
            'id' => 'des_view_home',
            'name' => 'View home',
            'taxonomies' => array('category-destination'),
            'fields' => array(
                0 => array(
                    'id' => 'des_view_home',
                    'type' => 'checkbox',
                    'name' => 'View home',
                    ),
                'departure_month' => array(
                    'id' => 'departure_month',
                    'type' => 'checkbox',
                    'name' => 'Departure month in home',
                    ),
                'stt' => array(
                    'id' => 'stt',
                    'type' => 'number',
                    'name' => 'Số thứ tự',
                    'std' => 9999,
                    ),
                ),
            ),
        'style_view_home' => array(
            'id' => 'style_view_home',
            'name' => 'View home',
            'taxonomies' => array('travel_style', 'combo_tour'),
            'fields' => array(
                    0 => array(
                    'id' => 'style_view_home',
                    'type' => 'checkbox',
                    'name' => 'View home',
                    ),
                    1 => array(
                    'id' => 'style_thu_tu',
                    'type' => 'number',
                    'name' => 'Thứ tự',
                    'std' => 9999,
                    ),
                    2 => array(
                            'id' => 'list_destination',
                            'type' => 'select_advanced',
                            'name' => 'List Destination',
                            'options' => $destination_opt,
                            'multiple' => true,
                        ),
					3 => array(
						'id' => 'cc_bg',
						'type' => 'image_advanced',
						'name' => 'Background',
						'std' => '',
                    ),
                    // 3 => array(
                    //         'id' => 'list_destination_es',
                    //         'type' => 'select_advanced',
                    //         'name' => 'List Destination ES',
                    //         'options' => $destination_opt,
                    //         'multiple' => true,
                    //     ),
                    // 4 => array(
                    //         'id' => 'list_destination_pt',
                    //         'type' => 'select_advanced',
                    //         'name' => 'List Destination PT',
                    //         'options' => $destination_opt,
                    //         'multiple' => true,
                    //     ),
                    ),
            ),

        'extra_guide' => array(
            'id' => 'extra_guide',
            'name' => 'Extra guide',
            'taxonomies' => array('tour_guide'),
            'fields' => array(0 => array(
                    'id' => 'extra_guide',
                    'type' => 'member',
                    'name' => 'Extra guide',
                    ), ),
            ),
        'airline' => array(
            'id' => 'airline',
            'name' => 'Airline',
            'taxonomies' => array('flight'),
            'fields' => array(0 => array(
                    'id' => 'airline',
                    'type' => 'text',
                    'name' => 'Airline',
                    ), ),
            ),
        'oneway' => array(
            'id' => 'oneway',
            'name' => 'Onewway',
            'taxonomies' => array('flight'),
            'fields' => array(0 => array(
                    'id' => 'oneway',
                    'type' => 'checkbox',
                    'name' => 'Oneway',
                    ), ),
            ),
        'round_trip' => array(
            'id' => 'round_trip',
            'name' => 'Onewway',
            'taxonomies' => array('flight'),
            'fields' => array(0 => array(
                    'id' => 'round_trip',
                    'type' => 'checkbox',
                    'name' => 'Round trip',
                    ), ),
            ),
        'flight_price' => array(
            'id' => 'flight_price',
            'name' => 'Flight price',
            'taxonomies' => array('flight'),
            'fields' => array('group_price_flight' => array(
                    'group_title' => '{#}',
                    'collapsible' => true,
                    'id' => 'group_price_flight',
                    'type' => 'group',
                    'clone' => true,
                    'sort_clone' => true,
                    'fields' => array(
                        0 => array(
                            'id' => 'from_date',
                            'type' => 'date',
                            'name' => 'Date from',
                            'timestamp' => true,
                            ),
                        1 => array(
                            'id' => 'to_date',
                            'type' => 'date',
                            'name' => 'Date to',
                            'timestamp' => true,
                            ),
                        2 => array(
                            'id' => 'price_flight',
                            'type' => 'number',
                            'name' => 'Price',
                            //  'columns' => '12',
                            ),
                        ),
                    ), ),
            ),
        )); }
);
register_post_type('travel-guide', array(
    'labels' => array('name' => __('Travel guide'), 'singular_name' => __('Travel guide')),
    'public' => true,
    'has_archive' => true,
    'query_var' => false,
    'can_export' => false,
    'delete_with_user' => true,
    'capability_type' => 'travel-guide',
    'columns' => array(),
    'actions' => array(),
    'supports' => array(
        'title',
        'thumbnail',
        'excerpt',
        ),
));
$role = get_role("administrator");
if (!empty($role))
{
    $role->add_cap("edit_travel-guide");
    $role->add_cap("delete_travel-guide");
    $role->add_cap("read_travel-guide");
    $role->add_cap("edit_travel-guides");
    $role->add_cap("delete_travel-guides");
    $role->add_cap("edit_others_travel-guides");
    $role->add_cap("publish_travel-guides");
    $role->add_cap("read_private_travel-guides");
    $role->add_cap("create_travel-guides");

}
add_filter('rwmb_meta_boxes', function ($meta_boxes)
{
    $current_lang = pll_current_language();
    $post_ID = $_GET['post'];
    $terms = wp_get_post_terms( $post_ID, 'category-destination', array() );
    $slug = $terms[0]->slug;
    return array_merge($meta_boxes, 
        array(
            'travel_guide_info' => array(
                'id' => 'travel_guide_info',
                'title' => 'Travel guide information',
                'post_types' => 'travel-guide',
                'context' => 'advanced',
                'priority' => 'default',
                'autosave' => true,
                'not_show' => false,
                'fields' => array(
                    0 => array(
                        'id' => 'image_banner',
                        'type' => 'image_advanced',
                        'name' => 'Image banner',
                        ),
                    1 => array(
                        'id' => 'over_view',
                        'type' => 'wysiwyg',
                        'name' => 'Overview',
                        ),
                    2 => array(
                        'id' => 'language_spoken',
                        'type' => 'textarea',
                        'name' => 'Language Spoken',
                        ),
                    3 => array(
                        'id' => 'currency',
                        'type' => 'textarea',
                        'name' => 'Currency',
                        ),
                    4 => array(
                        'id' => 'time_zones',
                        'type' => 'text',
                        'name' => 'Time Zones',
                        ),
                    5 => array(
                        'id' => 'weather',
                        'type' => 'textarea',
                        'name' => 'Weather',
                        ),
                    6 => array(
                        'id'   => 'address',
                        'name' => 'Address',
                        'type' => 'text',
                        ),

                    7 => array(
                        'id'            => 'map',
                        'name'          => 'Location',
                        'type'          => 'map',
                        'address_field' => 'address',
                        'api_key' => 'AIzaSyCk2KOy3Rqcz-Jy7ZMlXeA7cInikpHwMR0',
                        ),
                    10 => array(
                        'id' => 'city_relate',
                        'type' => 'post',
                        'post_type' => 'destination',
                        'name' => 'City relate',
                        'field_type' => 'select_advanced',
                        'multiple' => 'true',
                        'query_args'  => array(
                            'post_status'    => 'publish',
                            'posts_per_page' => - 1,
                            'lang'  => $current_lang,
                            'tax_query' => array(
                                            array(
                                                'taxonomy' => 'category-destination',
                                                'field'    => 'slug',
                                                'terms'    => $slug,
                                            ),
                                            array(
                                                        'taxonomy' => 'category-destination',
                                                        'field'    => 'slug',
                                                        'terms'    => $slug,
                                                        'operator' => 'NOT IN',
                                                        'include_children' => false,
                                            )         
                                        ),
                        ), 
                    ),
                ),
            ),
            'things_to_do' => array(
                'id' => 'things_to_do',
                'title' => 'Things to do',
                'post_types' => 'travel-guide',
                'context' => 'advanced',
                'priority' => 'default',
                'autosave' => true,
                'not_show' => true,
                'fields' => array(
                    'things_to_do' => array(
                        'id' => 'things_to_do',
                        'type' => 'post',
                        'post_type' => 'highlight',
                        'name' => 'Tour highlight',
                        'field_type' => 'select_advanced',
                        'multiple' => 'true',
                        'query_args'  => array(
                            'post_status'    => 'publish',
                            'posts_per_page' => - 1,
                            'lang'  => $current_lang,
                        ), 
                        ),
                    'destination' => array(
                        'id' => 'destination',
                        'type' => 'post',
                        'post_type' => 'destination',
                        'name' => 'Destination',
                        'field_type' => 'select_advanced',
                        'multiple' => 'true',
                        'query_args'  => array(
                            'post_status'    => 'publish',
                            'posts_per_page' => - 1,
                            'lang'  => $current_lang,
                        ), 
                        ),
                    'hotel' => array(
                        'id' => 'hotel',
                        'type' => 'post',
                        'post_type' => 'hotel',
                        'name' => 'Hotel',
                        'field_type' => 'select_advanced',
                        'multiple' => 'true',
                        'query_args'  => array(
                            'post_status'    => 'publish',
                            'posts_per_page' => - 1,
                            'lang'  => $current_lang,
                        ), 
                        ),
                    'restaurant' => array(
                        'id' => 'restaurant',
                        'type' => 'post',
                        'post_type' => 'restaurant',
                        'name' => 'Restaurant',
                        'field_type' => 'select_advanced',
                        'multiple' => 'true',
                        'query_args'  => array(
                            'post_status'    => 'publish',
                            'posts_per_page' => - 1,
                            'lang'  => $current_lang,
                        ), 
                        ),
                    'blog' => array(
                        'id' => 'blog',
                        'type' => 'post',
                        'post_type' => 'post',
                        'name' => 'Blog',
                        'field_type' => 'select_advanced',
                        'multiple' => 'true',
                        'query_args'  => array(
                            'post_status'    => 'publish',
                            'posts_per_page' => - 1,
                            'lang'  => $current_lang,
                        ), 
                        ),
                    ),
                ),
            'related' => array(
                'id' => 'related',
                'title' => 'Related',
                'post_types' => 'travel-guide',
                'context' => 'advanced',
                'priority' => 'default',
                'autosave' => true,
                'not_show' => false,
                'fields' => array(
                    0 => array(
                        'id' => 'experts',
                        'type' => 'post',
                        'name' => 'Experts',
                        'post_type' => 'expert',
                        'field_type' => 'select_advanced',
                        'multiple' => true,
                        'query_args' => array(
                            'post_status' => 'publish',
                            'posts_per_page' => -1,
                            'lang'  => $current_lang,
                            ),
                        ), 
                    1 => array(
                        'id' => 'related_post',
                        'type' => 'post',
                        'name' => 'Related blog',
                        'post_type' => 'post',
                        'field_type' => 'select_advanced',
                        'multiple' => true,
                        'query_args' => array(
                            'post_status' => 'publish',
                            'posts_per_page' => -1,
                            'lang'  =>  $current_lang,
                            ),
                    ),
                    2 => array(
                        'id' => 'related_review',
                        'type' => 'post',
                        'name' => 'Related review',
                        'post_type' => 'customer_feedback',
                        'field_type' => 'select_advanced',
                        'multiple' => true,
                        'query_args' => array(
                            'post_status' => 'publish',
                            'posts_per_page' => -1,
                            'lang'  => $current_lang,
                            ),
                    ),
                ),  
            ),
            'travel-guide-time-to-visit' => array(
                            'id' => 'travel-guide-time-to-visit',
                            'title' => 'Travel guide time to visit',
                            'post_types' => 'travel-guide',
                            'context' => 'advanced',
                            'priority' => 'default',
                            'autosave' => true,
                            'not_show' => true,
                            'fields' => array(
                                0 => array(
                                    'id' => 'description_time_to_visit',
                                    'type' => 'textarea',
                                    'name' => 'Description time to visit',
                                    ),
                                'travel-guide-time-to-visit' => array(
                                    'group_title' => '{#}',
                                    'collapsible' => true,
                                    'id' => 'travel-guide-time-to-visit',
                                    'type' => 'group',
                                    'clone' => true,
                                    'sort_clone' => true,
                                    'fields' => array(
                                        0 => array(
                                            'id' => 'month',
                                            'type' => 'text',
                                            'name' => 'Month',
                                            ),
                                        1 => array(
                                            'id' => 'popularity',
                                            'type' => 'select_advanced',
                                            'name' => 'Popularity',
                                            'options' => array(
                                                '1' => '1',
                                                '2' => '2',
                                                '3' => '3',
                                                '4' => '4',
                                                '5' => '5',
                                                ),
                                            ),
                                        3 => array(
                                            'id' => 'high-low',
                                            'type' => 'text',
                                            'name' => 'High/Low',
                                            ),
                                        4 => array(
                                            'id' => 'precip',
                                            'type' => 'text',
                                            'name' => 'Precip',
                                            ),
                                        ),
                                    ), ),
                    ),
            'travel-guide-travel-infomation' => array(
                            'id' => 'travel-guide-travel-infomation',
                            'title' => 'Travel Information',
                            'post_types' => 'travel-guide',
                            'context' => 'advanced',
                            'priority' => 'default',
                            'autosave' => true,
                            'not_show' => true,
                            'fields' => array(
                                'travel-guide-travel-infomation-gr' => array(
                                    'group_title' => '{#}',
                                    'collapsible' => true,
                                    'id' => 'travel-guide-travel-infomation-gr',
                                    'type' => 'group',
                                    'clone' => true,
                                    'sort_clone' => true,
                                    'fields' => array(
                                        0 => array(
                                           'id' => 'title_travel_info',
                                            'type' => 'title',
                                            'name' => 'Title',
                                            'size' => 100,
                                            ),
                                        1 => array(
                                            'id' => 'hotel-in-travel',
                                            'type' => 'post',
                                            'name' => 'Hotel in travel',
                                            'post_type' => 'hotel',
                                            'field_type' => 'select_advanced',
                                            'multiple' => true,
                                            'query_args' => array(
                                                'post_status' => 'publish',
                                                'posts_per_page' => -1,
                                                'lang'  => $current_lang,
                                                ),
                                            ),
                                        2 => array(
                                            'id' => 'description',
                                            'type' => 'wysiwyg',
                                            'name' => 'Description',
                                            ),
                                        ),
                                    ), ),
                    ),

        )
    );
});
register_taxonomy("category-travel-guide", array("tour"), array(
    "hierarchical" => true,
    "query_var" => "category_name",
    "rewrite" => array("slug" => "travel-guide"),
    "public" => true,
    "show_ui" => true,
    "show_admin_column" => true,
    "labels" => array("name" => __("Travel guide related tour"), "singular_name" => __("Travel guide related tour")),
    ));