<?php 
/**
 * Plugin Name: mundo-excursion
 * Plugin URI: http://liva.com.vn/plugins/mundo
 * Description: mundo-excursion
 * Version: 1.0.0
 * Author: LIVA
 * Author URI: https://liva.com.vn
 */
add_action('init', function() {
    $post_type_dir = plugin_dir_path(__FILE__) . 'post-type';
    $files_post_type = scandir($post_type_dir);

    if( $files_post_type ) {
        foreach( $files_post_type as $file ) {
            $ext = is_string($file) ? pathinfo($file, PATHINFO_EXTENSION) : '';
            if( $ext == 'php' ) {
                include_once $post_type_dir . '/' . $file;
            }
        }
    }

    include_once plugin_dir_path(__FILE__) . 'mundo-excursion-rate.php';
}, 5);
add_action('init',function(){
    add_rewrite_tag('%excursion_place%', '([^&]+)');
    add_rewrite_rule('^excursions/([^/]+)?$', 'index.php?pagename=excursions&excursion_place=$matches[1]', 'top');
    add_rewrite_rule('^es/excursiones/([^/]+)?$', 'index.php?pagename=excursiones&excursion_place=$matches[1]', 'top');
    add_rewrite_rule('^pt/excurcoes/([^/]+)?$', 'index.php?pagename=excurcoes&excursion_place=$matches[1]', 'top');
});
add_shortcode('excursion_page', function(){
    ob_start();
    get_template_part('templates/page-excursion');
    $html = ob_get_clean();
    return $html;
});
add_filter('custom_posts_show_more', function($posts, $module_id, $args=array(), $offset, $fullwidth) {
    if ($module_id=='excursions_list_page') {
        $content = '<div class="et_pb_salvattore_content tour_in_travel_style" data-columns>';
            $posts = get_posts($args);
            $posts_found = count($posts);
            if(($posts_found>0) && ($posts_found>$offset)){
                array_pop($posts);
            }
            $i = 1;
            foreach($posts as $post){
                $content .= get_post_excursion_html($post,$module_id,$i,$fullwidth);
                $i++;
            }
            $content .= '</div>';
        return $content; 
    }
    return $posts;
},10,5);
add_filter('custom_post_query_args', function($query_args, $module_id) {
    $destination_category = get_query_var('excursion_place');
    // $destination_category = 'viet-nam';
    if ($module_id=='excursions_list_page') {
        $query_args['post_type'] = 'excursion'; 
        $query_args['tax_query'] =  array(
                                        array(
                                            'taxonomy' => 'category-destination',
                                            'field'    => 'slug',
                                            'terms'    => $destination_category,
                                            'include_children' =>true
                                        ),
                                    ); 
        $query_args['meta_query']['relation']='AND';
                $query_args['meta_query']['position']['relation'] = 'OR';
                $query_args['meta_query']['position']['position_display'] = array(
                        'key' => 'position_display',
                        'compare' => 'meta_value_num',
                        'type'  => 'numeric',
                    );
                $query_args['meta_query']['position']['position_display_ex'] = array(
                    'key' => 'position_display',  
                    'compare' => 'NOT EXISTS'
                );
                $query_args['orderby'] = array(
                        'position_display' => 'ASC',
                        'date' => 'DESC',
                    );
    }
    return $query_args;
},10,2);
function get_post_excursion_html($post, $module_id = '',$i, $fullwidth){
            $thumbnail_id = get_post_thumbnail_id($post->ID);
            $thubnail = mundo_get_attachment_image_src($thumbnail_id, 'tour_another')?:'';
            $link = (get_the_permalink($post->ID))?:'';
            $title = ($post->post_title)?:'' ;
            $experts = (get_the_excerpt($post->ID))?:'';
            $class = $i%3==0&&$fullwidth=='on'?'private-tour':'';
            $class_full = $fullwidth=='on'?' tour-list-item':'';
            $html = '<div class="item  '.$class.' '.$class_full.'">
                        <article id="post-'.$post->ID.'" class="et_pb_post clearfix post-'.$post->ID.' '.$post->post_type.' type-'.$post->post_type.' status-publish format-standard has-post-thumbnail hentry category-uncategorized">
                            <div class="post-thumbnail">
                                <a href="'.$link.'" class="entry-featured-image-url"><img src="'.$thubnail.'" alt="'.$title.'"></a>';
            $label_tour = (wp_get_post_terms($post->ID, 'label_tour'))?:array();
            if(!empty($label_tour)){
                $html .= '<div class="label_tour">'.$label_tour[0]->name.' </div>';
            }  
            $days = 0;
            $itinerarys = (get_post_meta($post->ID, 'itinerary',true))?:array(); 
            // if($itinerarys){
            //     $days = count($itinerarys);
            //     //$day_html = ($days==1)?$days.' Day / 0 Night': $days. ' Days / '.($days-1).' Nights';
            //     $day_html = ($days==1)?$days.' '.__("Day",'mundo').' / 0 '.__("Night",'mundo').'': $days. ' '.__("Days",'mundo').' / '.($days-1).' '.__("Nights",'mundo').'';
            // }
            $duration_term = wp_get_post_terms($post->ID,'duration_excursion');
            $day_html = !empty($duration_term)?$duration_term[0]->name:'';
            $html .= '<div class="days"><b>'.$day_html.'</b> </div>';   
            $terms = wp_get_post_terms($post->ID,'travel_style'); 
            $list_category = '';          
            if($terms){
                
                foreach($terms as $term){
                    $list_category .= $term->name .' ';
                }
            }
            $taxonomy_name = get_query_var( 'taxonomy_name');
            $term_name = get_query_var( 'term_name');
            $terms = wp_get_post_terms($post->ID,'travel_style'); 
            $terms = get_terms( array(
                'taxonomy' => $taxonomy_name,
                'hide_empty' => false,
                'slug' => $term_name,
            ) );
            $list_category = get_post_meta($post->ID,'travel_style',true);    //Seat in coach tours trang chủ ko có phân theo cate
            //$html .= '<div class="category_tour "><b>'.$list_category.'</b> </div>';                
            $html .=       '</div>
                            <div class="post_content">
                            <h2 class="entry-title content"><a href="'.$link.'">'.$title.'</a></h2><div>';
           
            
            $departure_dates = (get_post_meta($post->ID, 'departure_date',true))?:array();
            $departure_date_text = '';
            $i = 1;
            if($departure_dates){
                
                foreach($departure_dates as $departure_date){
                if($i>3){
                    continue;
                }
                $departure_date_fm =   date('d M',$departure_date['date']['timestamp']);
                if($i == 3){
                    $departure_date_text .= $departure_date_fm.' ... ';
                }else{
                    $departure_date_text .= $departure_date_fm.' / ';
                }
                
                $i += 1;
            }
            }
           
            $home_url = home_url();
            // $route = (get_post_meta($post->ID,'route',true))?:'';
            $terms_des = wp_get_post_terms( $post->ID, 'category-destination', array() );
            $html .= '<div class="route content">'.__('From','mundo-excursion').': <b>'.$terms_des[0]->name.'</b></div>';
            $highlight_city = (get_post_meta($post->ID, 'highlight_excursion', true))?:'';
            $html .= '<div class="highlight_city content"><b>'.__("Highlights",'mundo').' : </b> <b class="text_gray">'.$highlight_city.'</b> </div></div>';
            $html .= '<div class="list-rate-excursion content">';
            $price_group_arr = excursion_get_price_min( $post->ID, 'group' );
            $price_group = $price_group_arr['p'];
            if ($price_group) {
                $html .= '<span class="check-private"><img src="'.$home_url.'/wp-content/themes/mundo/icon/1.png'.'"> '.__('Group','mundo-excursion').'</span>';
            }
            $price_private_arr = excursion_get_price_min( $post->ID, 'private' );
            $price_private = $price_private_arr['p'];
            if ($price_private) {
                $html .= '<span class="check-group"><img src="'.$home_url.'/wp-content/themes/mundo/icon/1.png'.'"> '.__('Private','mundo-excursion').'</span>';
            }
            $html .= '</div>';
            $html .= '</div><hr>';
            
            $discount_price = get_post_meta($post->ID, 'discount_price',true);
            $text_gray = '';
            $discount = 'price';
            $discount_price_html = '';
            if($discount_price){
                $discount_price_html = '<b class="discount_price"> $'.$discount_price.'pp </b>';
                $text_gray = 'text_gray';
                $discount = 'discount';
            }
            //lay ham gia 6 thang gần nhất.
            $price = excursion_get_price_min($post->ID,'group');

            if(!empty($price['p'])){
                $lang = pll_current_language();
                $price = (intval($price))?mundo_exchange_rate($price,$lang ):$price;
                $price_html = (intval($price))?'<b class="'.$discount.' ">$'.$price['p'].' </b> <b class=" text_gray ">pp</b>':'<b class="'.$discount.' '.$text_gray.'">'.$price['p'].' </b>';

            }else{
                $price_html ='<b class="price">'.__('On Request','mundo').'</b>';
            }
           $from =excursion_get_price_min( $post->ID, 'group' )?__("From",'mundo').': ':__("Price",'mundo').': ';

            

            $price_group_arr = excursion_get_price_min( $post->ID, 'group' );
            $price_group = $price_group_arr['p'];
            if ($price_group) {
                $price_html = $price_group?'<b class="price">$'.$price_group.'</b>':'<b class="price">'.__('On Request','mundo').'</b>';
                $html .= '<div class="row content"><div class = "col-lg-7 col-md-6 price-2-month"><b class="text_gray">'.$from.'</b>'.$discount_price_html. $price_html.'</div>';
                
            }else{
                
                $price_private_arr = excursion_get_price_min( $post->ID, 'private' );
                $price_private = $price_private_arr['p'];
                $price_html = $price_private?'<b class="price">$'.$price_private.'</b>':'<b class="price">'.__('On Request','mundo').'</b>';
                $html .= '<div class="row content"><div class = "col-lg-7 col-md-6 price-2-month"><b class="text_gray">'.$from.'</b>'.$discount_price_html. $price_html.'</div>';
                
            }
           
            

            
            $type_rate = 'reviews_private';
            $price_private_arr = excursion_get_price_min( $post->ID, 'private' );
            $price_private = $price_private_arr['p'];
            if (!$price_private) {
                $type_rate = 'reviews_group';
            }
            $star_rate_equal = get_rate_star_avg($post->ID,$type_rate);

           $html .= '<div class=" col-lg-5 col-md-6 star-ex">'.$star_rate_equal['star_html'].' ('.$star_rate_equal['count'].')</div></div></article></div>';
    return $html;        
}
function get_post_excursion_html_check_out($post){

    $thumbnail_id = get_post_thumbnail_id($post->ID);
            $thubnail = mundo_get_attachment_image_src($thumbnail_id, 'tour_another')?:'';
            $link = (get_the_permalink($post->ID))?:'';
            $title = ($post->post_title)?:'' ;
            $experts = (get_the_excerpt($post->ID))?:'';
            $class = $i%3==0&&$fullwidth=='on'?'private-tour':'';
            $class_full = $fullwidth=='on'?' tour-list-item':'';
            $html = '<div class="item  '.$class.' '.$class_full.'">
                        <article id="post-'.$post->ID.'" class="row et_pb_post clearfix post-'.$post->ID.' '.$post->post_type.' type-'.$post->post_type.' status-publish format-standard has-post-thumbnail hentry category-uncategorized">
                            <div class="post-thumbnail col-md-6">
                                <a href="'.$link.'" class="entry-featured-image-url"><img src="'.$thubnail.'" alt="'.$title.'"></a>';
            $label_tour = (wp_get_post_terms($post->ID, 'label_tour'))?:array();
            if(!empty($label_tour)){
                $html .= '<div class="label_tour">'.$label_tour[0]->name.' </div>';
            }  
            $days = 0;
            $itinerarys = (get_post_meta($post->ID, 'itinerary',true))?:array(); 
            if($itinerarys){
                $days = count($itinerarys);
                //$day_html = ($days==1)?$days.' Day / 0 Night': $days. ' Days / '.($days-1).' Nights';
                $day_html = ($days==1)?$days.' '.__("Day",'mundo').' / 0 '.__("Night",'mundo').'': $days. ' '.__("Days",'mundo').' / '.($days-1).' '.__("Nights",'mundo').'';
            }
            $duration_term = wp_get_post_terms($post->ID,'duration_excursion');
            $day_html = !empty($duration_term)?$duration_term[0]->name:'';
            $html .= '<div class="days"><b>'.$day_html.'</b> </div>';   
            $terms = wp_get_post_terms($post->ID,'travel_style'); 
            $list_category = '';          
            if($terms){
                
                foreach($terms as $term){
                    $list_category .= $term->name .' ';
                }
            }
            $taxonomy_name = get_query_var( 'taxonomy_name');
            $term_name = get_query_var( 'term_name');
            $terms = wp_get_post_terms($post->ID,'travel_style'); 
            $terms = get_terms( array(
                'taxonomy' => $taxonomy_name,
                'hide_empty' => false,
                'slug' => $term_name,
            ) );
            $list_category = get_post_meta($post->ID,'travel_style',true);    //Seat in coach tours trang chủ ko có phân theo cate
            //$html .= '<div class="category_tour "><b>'.$list_category.'</b> </div>';                
            $html .=       '</div><div class="ex_check_out_content col-md-6">
                            <div class="post_content">
                            <h2 class="entry-title content"><a href="'.$link.'">'.$title.'</a></h2><div>';
           
            
            $departure_dates = (get_post_meta($post->ID, 'departure_date',true))?:array();
            $departure_date_text = '';
            $i = 1;
            if($departure_dates){
                
                foreach($departure_dates as $departure_date){
                if($i>3){
                    continue;
                }
                $departure_date_fm =   date('d M',$departure_date['date']['timestamp']);
                if($i == 3){
                    $departure_date_text .= $departure_date_fm.' ... ';
                }else{
                    $departure_date_text .= $departure_date_fm.' / ';
                }
                
                $i += 1;
            }
            }
           
            $home_url = home_url();
            // $route = (get_post_meta($post->ID,'route',true))?:'';
            $terms_des = wp_get_post_terms( $post->ID, 'category-destination', array() );
            $html .= '<div class="route content">'.__('From','mundo-excursion').': <b>'.$terms_des[0]->name.'</b></div>';
            $html .= '<div class="list-rate-excursion content">';
            $price_private_arr = excursion_get_price_min( $post->ID, 'private' );
            $price_private = $price_private_arr['p'];
            if ($price_private) {
                $html .= '<span class="check-private"><img src="'.$home_url.'/wp-content/themes/mundo/icon/1.png'.'"> '.__('Private','mundo-excursion').'</span>';
            }
            $price_group_arr = excursion_get_price_min( $post->ID, 'group' );
            $price_group = $price_group_arr['p'];
            if ($price_group) {
                $html .= '<span class="check-group"><img src="'.$home_url.'/wp-content/themes/mundo/icon/1.png'.'"> '.__('Group','mundo-excursion').'</span>';
            }
            $html .= '</div>';
            $html .= '</div><hr>';
            
            $discount_price = get_post_meta($post->ID, 'discount_price',true);
            $text_gray = '';
            $discount = 'price';
            $discount_price_html = '';
            if($discount_price){
                $discount_price_html = '<b class="discount_price"> $'.$discount_price.'pp </b>';
                $text_gray = 'text_gray';
                $discount = 'discount';
            }
            //lay ham gia 6 thang gần nhất.
            $price = excursion_get_price_min($post->ID,'group');
            if($price){
                $lang = pll_current_language();
                $price = (intval($price))?mundo_exchange_rate($price,$lang ):$price;
                $price_html = (intval($price))?'<b class="'.$discount.' '.$text_gray.'">$'.$price.' </b> <b class=" '.$discount.' text_gray ">pp</b>':'<b class="'.$discount.' '.$text_gray.'">'.$price.' </b>';
            }else{
                $price_html ='<b class="price">'.__('On Request','mundo').'</b>';
            }
           $from = excursion_get_price_min( $post->ID, 'group' )?__("From",'mundo').': ':__("Price",'mundo').': ';
           $price_group_arr = excursion_get_price_min( $post->ID, 'group' );
           $price_group = $price_group_arr['p'];
           $price_html = $price_group?'<b class="price">$'.$price_group.'</b>':'<b class="price">'.__('On Request','mundo').'</b>';
            $html .= '<div class="price-ex-thank price-2-month"><b class="text_gray">'.$from.'</b>'.$discount_price_html. $price_html.'</div>';
           $html .= '</div></article></div>';
    return $html;     
}
function get_rate_star_avg($id,$type_rate){
    $reviews_group = get_post_meta($id,$type_rate,true);
    $star = 0;
    $count = 0;
    if (!empty($reviews_group)) {
        foreach ($reviews_group as $key => $value) {
                $star = $value['star_rate']+$star;
                $count++;
            }
        
        $star_tbc = $star/$count;

        $star_html = ' ';
        for ($i=1; $i <= 5 ; $i++) { 
            if($i <= $star_tbc ){
                $star_html .= '<span aria-hidden="true" class="icon_star icon_star_all"></span>';
            }else{
                $star_html .= '<span aria-hidden="true" class="icon_star_none icon_star_all"></span>';
            }
            
        }
        $star_rate_equal['star_html'] = $star_html;
        $star_rate_equal['count'] = $count;

        return $star_rate_equal;
    }
}
add_shortcode('title_excursion_shortcode', function(){
    $home_url = home_url();
    ob_start();
    $id = $_GET['check-out'];
    $transient = get_transient( "check_out_{$id}" );
    if( !$transient ) {
        return 'Timeout!';
    }

    set_query_var('transient', $transient);
    set_query_var('transient-id', $id);
    $transient = get_query_var('transient', array());

    $checkout_id = get_query_var('transient-id', 0);
    $post_id = $transient['post_id'];

    //print_r($post_id);exit();
    $tour = get_post($post_id);
    $html = $tour->post_title;
    echo $tour->post_title;
    $html = ob_get_clean();
    return $html;
});


add_filter('rwmb_meta_boxes', function($meta_boxes){
    $meta_boxes[] = array(
      'id' => 'mt_edit_excursion',
      'title' => esc_html__('Edit excursions', 'metabox-online-generator'),
      'post_types' => array('destination'),
      'context' => 'advanced',
      'priority' => 'default',
      'autosave' => true,
      'fields' => array(
            array(
              'id' => 'edit_excursion',
              'type' => 'custom_html',
              'callback' => 'link_edit_excursion',
            ), 
 
             // Other sub-fields here
        ),
      );

  return $meta_boxes;
});
function link_edit_excursion()
{
    global $post;  
    if ($post->post_type=='destination'){
      $url = add_query_arg( array(
        'post' => $post->ID,
        'action' => 'edit',
        'type' => 'excursion'
      ), admin_url( 'post.php' ) );

      $actions = '<a href="'.$url.'" title="">'.__('Edit excursion').'</a>';
    }
    return $actions;
}