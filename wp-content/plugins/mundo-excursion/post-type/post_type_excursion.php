<?php 
register_post_type('excursion', array(
    'labels' => array('name' => __('Excursions'), 'singular_name' => __('Excursions')),
    'public' => true,
    'has_archive' => true,
    'query_var' => false,
    'can_export' => false,
    'delete_with_user' => true,    
    'columns' => array(),
    'actions' => array(),
    'supports' => array('title', 'thumbnail'),
));
add_filter('rwmb_meta_boxes', function ($meta_boxes)
{
    $opntions_date = array('monday' => 'Monday','tuesday' => 'Tuesday','wednesday' => 'Wednesday','thursday' => 'Thursday','friday' => 'Friday','saturday' => 'Saturday','sunday' => 'Sunday', );
    return array_merge($meta_boxes, array(
            'excursion_over_view' => array(
                'id' => 'excursion_over_view',
                'title' => 'Over view',
                'post_types' => 'excursion',
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
                    'over_view' => array(
                        'id' => 'over_view',
                        'type' => 'wysiwyg',
                        'name' => 'Over view',
                    ),
                    'time_trip' => array(
                        'id' => 'time_trip',
                        'type' => 'text',
                        'name' => 'Time trip',
                    ),
                    // 'destination_from' => array(
                    //     'id' => 'destination_from',
                    //     'type' => 'text',
                    //     'name' => 'Destination from',
                    // ),
                    'highlight_excursion' => array(
                        'id' => 'highlight_excursion',
                        'type' => 'text',
                        'name' => 'Highlight excursion',
                        'size' => 100,
                    ),
                    'discount_price' => array(
                        'id' => 'discount_price',
                        'type' => 'text',
                        'name' => 'Discount Price',
                    ),
                    'from_rate' => array(
                        'id' => 'from_rate',
                        'type' => 'text',
                        'name' => 'Destination from text ',
                    ),
                    'position_display' => array(
                        'id' => 'position_display',
                        'type' => 'text',
                        'name' => 'Position display',
                        'std' =>'9999',
                    ),
                ),
        ), 
        //end over view ex
        'excursion_highlight' => array(
            'id' => 'excursion_highlight',
            'title' => 'Excursion highlight',
            'post_types' => 'excursion',
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => true,
            'not_show' => false,
            'fields' => array('group_excursion_highlight' => array(
                    'group_title' => '{#}',
                    'collapsible' => true,
                    'id' => 'group_excursion_highlight',
                    'type' => 'group',
                    'clone' => true,
                    'columns' => 12,
                    'sort_clone' => true,
                    'fields' => array(
                            'highlight' => array(
                                'id' => 'highlight',
                                'type' => 'text',
                                'name' => 'Highlight',
                                'size' => 100
                            ),
                        ),
            ),),
        ),
        //end ex highlight
        'gallery_excursion' => array(
            'id' => 'gallery_excursion',
            'title' => 'Gallery',
            'post_types' => 'excursion',
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
                            'name' => 'Title',
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
        //end gallery ex
        'excursion_group_rate_field' => array(
                'id' => 'excursion_group_rate_field',
                'title' => 'Excursion group rate field',
                'post_types' => 'excursion',
                'context' => 'advanced',
                'priority' => 'default',
                'autosave' => true,
                'not_show' => false,
                'fields' => array(
                    'lang_group' => array(
                        'id' => 'language_group',
                        'type' => 'text',
                        'name' => 'Language group',
                    ),
                    'departure_date_group' => array(
                        'id' => 'departure_date_group',
                        'type' => 'select_advanced',
                        'multiple' => true,
                        'options' => $opntions_date,
                        'name' => 'Departure date',
                    ),
                    'daily_group' => array(
                        'id' => 'daily_group',
                        'type' => 'checkbox',
                        'name' => 'daily',
                    ),
                    'departure_time_group' => array(
                        'id' => 'departure_time_group',
                        'type' => 'text',
                        'name' => 'Departure time',
                    ),
                    'accomodation_group' => array(
                            'id' => 'accomodation_group',
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
                    'pick_up_point_group' => array(
                        'id' => 'pick_up_point_group',
                        'type' => 'wysiwyg',
                        'name' => 'Pick up point',
                    ),
                    'over_rate_group' => array(
                        'id' => 'over_rate_group',
                        'type' => 'wysiwyg',
                        'name' => 'Over rate',
                    ),
                ),
        ),
        //end excursion rate group
        'excursion_private_rate_field' => array(
                'id' => 'excursion_private_rate_field',
                'title' => 'Excursion private rate field',
                'post_types' => 'excursion',
                'context' => 'advanced',
                'priority' => 'default',
                'autosave' => true,
                'not_show' => false,
                'fields' => array(
                    'lang_private' => array(
                        'id' => 'language_private',
                        'type' => 'text',
                        'name' => 'Language private',
                    ),
                    'departure_date_private' => array(
                        'id' => 'departure_date_private',
                        'type' => 'select_advanced',
                        'multiple' => true,
                        'options' => $opntions_date,
                        'name' => 'Departure date',
                    ),
                    'daily_private' => array(
                        'id' => 'daily_private',
                        'type' => 'checkbox',
                        'name' => 'daily',
                    ),
                    'departure_time_private' => array(
                        'id' => 'departure_time_private',
                        'type' => 'text',
                        'name' => 'Departure time',
                    ),
                    'accomodation_private' => array(
                            'id' => 'accomodation_private',
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
                    'pick_up_point_private' => array(
                        'id' => 'pick_up_point_private',
                        'type' => 'wysiwyg',
                        'name' => 'Pick up point',
                    ),
                    'over_rate_private' => array(
                        'id' => 'over_rate_private',
                        'type' => 'wysiwyg',
                        'name' => 'Over rate',
                    ),
                ),
        ),
        //end excursion rate private

        'excursion_infomation' => array(
                'id' => 'excursion_infomation',
                'title' => 'Excursion infomation',
                'post_types' => 'excursion',
                'context' => 'advanced',
                'priority' => 'default',
                'autosave' => true,
                'not_show' => false,
                'fields' => array(
                    'itinerary' => array(
                        'id' => 'itinerary',
                        'type' => 'wysiwyg',
                        'name' => 'Itinerary',
                    ),
                    'inclusions_exclusions_group' => array(
                        'id' => 'inclusions_exclusions_group',
                        'type' => 'wysiwyg',
                        'name' => 'Inclusions & Exclusions Group',
                    ),
                    'inclusions_exclusions_private' => array(
                        'id' => 'inclusions_exclusions_private',
                        'type' => 'wysiwyg',
                        'name' => 'Inclusions & Exclusions private',
                    ),
                    'how_to_book_pay' => array(
                        'id' => 'how_to_book_pay',
                        'type' => 'wysiwyg',
                        'name' => 'How to book & pay',
                    ),
                    'cancellation_policy' => array(
                        'id' => 'cancellation_policy',
                        'type' => 'wysiwyg',
                        'name' => 'Cancellation policy',
                    ),
                    'tips_advice' => array(
                        'id' => 'tips_advice',
                        'type' => 'wysiwyg',
                        'name' => 'Tips and advice',
                    ),
                ),
        ),
        //end excursion infomation 
        'reviews_group' => array(
            'id' => 'reviews_group',
            'title' => 'Reviews group',
            'post_types' => 'excursion',
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => true,
            'not_show' => true,
            'fields' => array('reviews_group' => array(
                    'group_title' => '{#}',
                    'collapsible' => true,
                    'id' => 'reviews_group',
                    'type' => 'group',
                    'clone' => true,
                    'sort_clone' => true,
                    'fields' => array(

                        0 => array(
                            'id' => 'star_rate',
                            'type' => 'number',
                            'name' => 'Star rate',
                            ),
                        1 => array(
                            'id' => 'title',
                            'type' => 'text',
                            'name' => 'Title',
                            ),
                        2 => array(
                            'id' => 'day',
                            'type' => 'text',
                            'name' => 'Day',
                            ),
                        3 => array(
                            'id' => 'content',
                            'type' => 'wysiwyg',
                            'name' => 'Content',
                            ),
                        4 => array(
                            'id' => 'avatar',
                            'type' => 'single_image',
                            'name' => 'Avatar',
                            ),
                        ),
            ), ),
        ),
        //end review group
        'reviews_private' => array(
            'id' => 'reviews_private',
            'title' => 'Reviews private',
            'post_types' => 'excursion',
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => true,
            'not_show' => true,
            'fields' => array('reviews_private' => array(
                    'group_title' => '{#}',
                    'collapsible' => true,
                    'id' => 'reviews_private',
                    'type' => 'group',
                    'clone' => true,
                    'sort_clone' => true,
                    'fields' => array(
                        0 => array(
                            'id' => 'star_rate',
                            'type' => 'number',
                            'name' => 'Star rate',
                            ),
                        1 => array(
                            'id' => 'title',
                            'type' => 'text',
                            'name' => 'Title',
                            ),
                        2 => array(
                            'id' => 'day',
                            'type' => 'text',
                            'name' => 'Day',
                            ),
                        3 => array(
                            'id' => 'content',
                            'type' => 'wysiwyg',
                            'name' => 'Content',
                            ),
                        4 => array(
                            'id' => 'avatar',
                            'type' => 'single_image',
                            'name' => 'Avatar',
                            ),
                        ),
            ), ),
        ),
        //end review private
        'excursion_relate' => array(
            'id' => 'excursion_relate',
                'title' => 'Excursion relate',
                'post_types' => 'excursion',
                'context' => 'advanced',
                'priority' => 'default',
                'autosave' => true,
                'not_show' => false,
                'fields' => array(
                    'excursion_relate' =>array(
                            'id' => 'excursion_relate',
                            'type' => 'post',
                            'post_type' => 'excursion',
                            'name' => 'Excursion relate',
                            'field_type' => 'select_advanced',
                            'multiple' => 'true',
                            'query_args'  => array(
                                'post_status'    => 'publish',
                                'posts_per_page' => - 1,
                                'lang'  => $current_lang,
                            ), 
                    ),
                    'excursion_relate_booked' =>array(
                            'id' => 'excursion_relate_booked',
                            'type' => 'post',
                            'post_type' => 'excursion',
                            'name' => 'Excursion relate booked',
                            'field_type' => 'select_advanced',
                            'multiple' => 'true',
                            'query_args'  => array(
                                'post_status'    => 'publish',
                                'posts_per_page' => - 1,
                                'lang'  => $current_lang,
                            ), 
                    ),
                    'expert_relate' =>array(
                            'id' => 'expert_relate',
                            'type' => 'post',
                            'post_type' => 'expert',
                            'name' => 'Expert relate',
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
        //end recomend excursion
    ));
});
//taxonomy excursion
register_taxonomy("duration_excursion", array("excursion"), array(
    "hierarchical" => true,
    "query_var" => "category_name",
    "rewrite" => array("slug" => "duration_excursion"),
    "public" => true,
    "show_ui" => true,
    "show_admin_column" => true,
    "labels" => array("name" => __("Duration excursion"), "singular_name" => __("Duration excursion")),
));
// add_filter('rwmb_meta_boxes', function ($meta_boxes)
// {
//     return array_merge($meta_boxes, array(
//         'duration_excursion' => array(
//             'id' => 'duration_excursion',
//             'name' => 'Duration excursion',
//             'taxonomies' => 'duration_excursion',
//             'fields' => array(
//                     0 => array(
//                         'id' => 'duration_from',
//                         'type' => 'number',
//                         'name' => 'Duration from',
//                     ),
//                     1 => array(
//                         'id' => 'duration_to',
//                         'type' => 'number',
//                         'name' => 'Duration to',
//                     ), 
//             ),
//         ),
//     ));
// });
//giá group
register_post_type('excursion_group', array(
    'labels' => array('name' => __('Excursion group  rate'), 'singular_name' => __('Excursion group  rate')),
    'public' => true,
    'has_archive' => true,
    'query_var' => false,
    'can_export' => false,
    'delete_with_user' => true,   
    'columns' => array(),
    'actions' => array(),
    'supports' => array('title','thumbnail'),
 ));
add_filter('rwmb_meta_boxes', function ($meta_boxes)
{
    $current_lang = pll_current_language();
    return array_merge($meta_boxes, array(
        'excursion_group_name' => array(
            'id' => 'excursion_group_name',
            'title' => 'Excursion name',
            'post_types' => 'excursion_group',
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => true,
            'not_show' => false,
            'fields' => array(2 => array(
                    'id' => 'excursion_name',
                    'type' => 'post',
                    'name' => 'Group excursion name',
                    'post_type' => 'excursion',
                    'field_type' => 'select_advanced',
                    'query_args' => array(
                        'post_status' => 'publish',
                        'posts_per_page' => -1,
                        'lang'  => $current_lang,
                        ),
                    ), ),
            ),
        'group_rate' => array(
            'id' => 'group_rate',
            'title' => 'Group excursion rate',
            'post_types' => 'excursion_group',
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => true,
            'not_show' => false,
            'fields' => array('group_rate' => array(
                    'group_title' => '{#}',
                    'collapsible' => true,
                    'id' => 'group_rate',
                    'type' => 'group',
                    'clone' => true,
                    //'columns' => 12,
                    'sort_clone' => true,
                    'fields' => array(
	                        'from_date' => array(
	                            'id' => 'from_date',
	                            'type' => 'date',
	                            'name' => 'From date',
	                            'timestamp' => 'true',
	                            'columns' => 3,
	                            ),
	                        'to_date' => array(
	                            'id' => 'to_date',
	                            'type' => 'date',
	                            'name' => 'To date',
	                            'timestamp' => 'true',
	                            'columns' => 3,
	                            ),
                            'check_full' => array(
                                'id' => 'check_full',
                                'type' => 'checkbox',
                                'name' => 'Check full',
                                'columns' => 6,
                                ),
	                        'adult' => array(
	                            'id' => 'adult',
	                            'type' => 'number',
	                            'name' => 'Adult',
	                            'columns' => 3,
	                        ),
	                        'youth' => array(
	                            'id' => 'youth',
	                            'type' => 'number',
	                            'name' => 'Youth (Age 8 - 11)',
	                            'columns' => 3,
	                        ),
	                        'children' => array(
	                            'id' => 'children',
	                            'type' => 'number',
	                            'name' => 'Children (Age 4 - 7)',
	                            'columns' => 3,
	                        ),
	                        'infant' => array(
	                            'id' => 'infant',
	                            'type' => 'number',
	                            'name' => 'Infant (Age 8 - 11)',
	                            'columns' => 3,
	                        ),
                        ),
                    ), ),
            ),
        )); }
);
//end giá group
//giá private
register_post_type('excursion_private', array(
    'labels' => array('name' => __('Excursion private  rate'), 'singular_name' => __('Excursion private  rate')),
    'public' => true,
    'has_archive' => true,
    'query_var' => false,
    'can_export' => false,
    'delete_with_user' => true,
    'columns' => array(),
    'actions' => array(),
    'supports' => array('title','thumbnail'),
));
add_filter('rwmb_meta_boxes', function ($meta_boxes)
{
    $current_lang = pll_current_language();
    return array_merge($meta_boxes, array(
        'excursion_name' => array(
            'id' => 'excursion_name',
            'title' => 'Excursion name',
            'post_types' => 'excursion_private',
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => true,
            'not_show' => false,
            'fields' => array(2 => array(
                    'id' => 'excursion_name',
                    'type' => 'post',
                    'name' => 'Excursion name',
                    'post_type' => 'excursion',
                    'field_type' => 'select_advanced',
                    'query_args' => array(
                        'post_status' => 'publish',
                        'posts_per_page' => -1,
                        'lang'  => $current_lang,
                        ),
                    ), ),
            ),
        'private_rate' => array(
            'id' => 'private_rate',
            'title' => 'Excursion private rate',
            'post_types' => 'excursion_private',
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => true,
            'not_show' => false,

            'fields' => array('private_excursion_rate' => array(
                    'group_title' => '{#}',
                    'collapsible' => true,
                    'id' => 'private_excursion_rate',
                    'type' => 'group',
                    'clone' => true,
                    //'columns' => 12,
                    'sort_clone' => true,
                    'fields' => array(
                        'from_date' => array(
                            'id' => 'from_date',
                            'type' => 'date',
                            'name' => 'From date',
                            'timestamp' => 'true',
                            'columns' => 3,
                            ),
                        'to_date' => array(
                            'id' => 'to_date',
                            'type' => 'date',
                            'name' => 'To date',
                            'timestamp' => 'true',
                            'columns' => 3,
                            ),
                        'check_full' => array(
                                'id' => 'check_full',
                                'type' => 'checkbox',
                                'name' => 'Check full',
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
                        'private_rate' => array(
                            'group_title' => 'Pax{#}',
                            'collapsible' => true,
                            'id' => 'private_rate',
                            'type' => 'group',
                            'clone' => true,
                            'sort_clone' => true,
                            'fields' => array(
                                'from' => array(
	                            'id' => 'from',
	                            'type' => 'text',
	                            'name' => 'From ',
	                            'timestamp' => 'true',
	                            'columns' => 3,

	                            ),
	                        'to' => array(
	                            'id' => 'to',
	                            'type' => 'text',
	                            'name' => 'To',
	                            'timestamp' => 'true',
	                            'columns' => 3,
	                            ),
                             '1' => array(
                                'type' => 'custom_html',
                                'columns' => 6,
                                ),
	                        'adult' => array(
	                            'id' => 'adult',
	                            'type' => 'number',
	                            'name' => 'Adult',
	                            'columns' => 3,

	                        ),
	                        'youth' => array(
	                            'id' => 'youth',
	                            'type' => 'number',
	                            'name' => 'Youth (Age 8 - 11)',
	                            'columns' => 3,
	                        ),
	                        'children' => array(
	                            'id' => 'children',
	                            'type' => 'number',
	                            'name' => 'Children (Age 4 - 7)',
	                            'columns' => 3,
	                        ),
	                        'infant' => array(
	                            'id' => 'infant',
	                            'type' => 'number',
	                            'name' => 'Infant (Age 8 - 11)',
	                            'columns' => 3,
	                        ),
                                ),
                            ),
                    
                        ),
                    ), ),
            ),
        )); }
);
//end giá private
//Tạo trường excursion cho destination
add_filter('rwmb_meta_boxes', function ($meta_boxes)
{
    return array_merge($meta_boxes, array(
            'excursion_in_destination' => array(
                'id' => 'excursion_in_destination_overview',
                'title' => 'Excursion Overview',
                'post_types' => 'destination',
                'context' => 'advanced',
                'priority' => 'default',
                'autosave' => true,
                'not_show' => false,
                'fields' => array(
                    'image_banner_excursion' => array(
                        'id' => 'image_banner_excursion',
                        'type' => 'image_advanced',
                        'name' => 'Image Banner Excursion',
                    ),
                    'over_view' => array(
                        'id' => 'over_view',
                        'type' => 'wysiwyg',
                        'name' => 'Over view',
                    ),
                    // 'excursion_travel_guide' => array(
                    //     'group_title' => 'Excursion travel guide {#}',
                    //     'collapsible' => true,
                    //     'id' => 'excursion_travel_guide',
                    //     'type' => 'group',
                    //     'clone' => true,
                    //     'sort_clone' => true,
                    //     'fields' =>  array(
                    //                     'title' => array(
                    //                         'id' => 'title',
                    //                         'type' => 'text',
                    //                         'name' => 'Title',
                    //                         'size' => 100
                    //                     ),
                    //                     'content' => array(
                    //                         'id' => 'content',
                    //                         'type' => 'wysiwyg',
                    //                         'name' => 'Content',
                    //                     ),
                    //                 ),
                    // ),
                    //end excursion travel guide
                ),
        ),
        //end excursion_in_destination
        
    ));
});