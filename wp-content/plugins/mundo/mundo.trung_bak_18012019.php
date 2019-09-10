<?php 
/**
 * Plugin Name: mundo
 * Plugin URI: http://liva.com.vn/plugins/mundo
 * Description: mundo
 * Version: 1.0.0
 * Author: LIVA
 * Author URI: https://liva.com.vn
 */
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
// if ( ! defined( 'ABSPATH' ) ) {
//     exit;
// }
add_action('init', function(){
    // $args = array(
    //             'post_type' => 'tour',
    //             'posts_per_page' => -1,
    //         );
    // $all_tour = get_posts( $args );
    // foreach ($all_tour as $key => $value) {
    //     $post_term = wp_get_post_terms( $value->ID, 'flight', array() );
    //     if (empty($post_term)) {
    //         $sql = "SELECT * FROM backup_term_relationships trl 
    //        INNER JOIN wp_term_taxonomy tx ON trl.term_taxonomy_id = tx.term_id 
    //        WHERE trl.object_id = $value->ID and  tx.taxonomy = 'flight'";
    //         global $wpdb;
    //         $results = $wpdb->get_results( $wpdb->prepare( $sql ) );
    //         $results_id = wp_list_pluck($results,'term_id');
    //         print_r($results);
    //         wp_set_post_terms( $value->ID, $results_id, 'flight' );
    //     }
    // }
    // echo 'succsessfully';exit();
    $terms_tour_guide = get_terms( array(
                  'taxonomy' => 'tour_guide',
                  'hide_empty' => true,
              ) );
    foreach ($terms_tour_guide as $key => $value) {
        pll_register_string('Mundo-'.$value->slug,$value->name, 'Tour guide', false);
    }
    $terms_expert_team = get_terms( array(
                  'taxonomy' => 'expert_team',
                  'hide_empty' => true,
              ) );
    foreach ($terms_expert_team as $key => $value) {
        pll_register_string('Mundo-'.$value->slug,$value->name, 'Expert team', false);
    }

    $terms = get_terms( array(
                  'taxonomy' => 'tour_guide',
                  'hide_empty' => true,
              ) );
    foreach ($terms as $key => $value) {
        pll_register_string('Mundo-'.$value->slug,$value->name, 'Tour guide', false);
    }
    $terms = get_terms( array(
                  'taxonomy' => 'flight',
                  'hide_empty' => true,
              ) );
    foreach ($terms as $key => $value) {
        pll_register_string('Mundo-'.$value->slug,$value->name, 'Tour flight', false);
    }
}, 11);
require_once(WP_PLUGIN_DIR . '/mundo/class-virtual-page.php');
function na_remove_slug( $post_link, $post, $leavename ) {
    if ( !in_array($post->post_type, array('destination')) || 'publish' != $post->post_status ) {
        return $post_link;
    }
    //Nếu là destination thì Thay link của destination bỏ phần post type slug đi 
    $post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );
    return $post_link;
}
//add_filter( 'post_type_link', 'na_remove_slug', 10, 3 );
function na_parse_request( $query ) {
    if (!$query->is_main_query()) {
        return;
    }
    $args = $query->query;
    unset($args['lang']);
    unset($args['step']);
    if ( ! $query->is_main_query() || 2 != count( $args ) || ! isset( $query->query['page'] ) ) {
        return;
    }

    if ( ! empty( $query->query['name'] ) ) {
        $query->set( 'post_type', array( 'destination', 'post', 'page' ) );
    }
}
//add_action( 'pre_get_posts', 'na_parse_request' );


add_action('init', function() {
    //global $wpdb;
    //post type
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
    add_post_type_support( 'page', 'excerpt' );
}, 5);

add_action( 'admin_enqueue_scripts', function() {
    //wp_enqueue_style( 'gamiland-css', plugins_url( '/css/gamiland.css', __FILE__ ), array(), rand() );
    wp_enqueue_script( 'la-regina-js', plugins_url( '/js/la-regina.js', __FILE__ ), array(), rand(), true );
} );
add_filter( 'content_sustom_contact_form', function($content, $module_id) {
    $html = '';
    if(in_array($module_id, array('booking_form_home','form_contact_sic_booking','form_booking_customize_tour'))){
        ob_start();
        ?>
        <p class="et_pb_contact_field et_pb_custom_contact_field_3 et_pb_contact_field_last" data-id="content" data-type="text">        
            <textarea name="et_pb_contact_content_1" id="et_pb_contact_content_1" class="et_pb_contact_message input"  data-field_type="text" data-original_id="content" placeholder="<?php echo ot_get_option( 'text_area_1'); ?> &#x0a;<?php echo ot_get_option( 'text_area_2'); ?>"></textarea>
        </p>
        
    <?php
        $html = ob_get_clean();
    }
    return $content . $html;
},10,2);
add_filter( 'et_builder_post_types', function($post_types) {
    $post_types[] = 'package';
    $post_types[] = 'ship';
    $post_types[] = 'suite';
    $post_types[] = 'facility';
    return $post_types;
});

add_filter( 'et_fb_post_types', function($post_types) {
    $post_types[] = 'package';
    $post_types[] = 'ship';
    $post_types[] = 'suite';
    $post_types[] = 'facility';
    return $post_types;
});
add_shortcode('combo_tour', function(){
        $home_url = home_url();
        ob_start();
        $terms_combo = get_terms( array(
           'taxonomy' => 'combo_tour',
            'hide_empty' => false,
            'meta_query' => array(
                 array(
                    'key'       => 'style_view_home',
                    'value'     => true,
                    'compare'   => '='
                 ),
                'stt' => array(
                            'key' => 'style_thu_tu',
                            'compare' => 'meta_value_num',
                            'type'    => 'numeric',
                        ),  
            ),
            'orderby' => 'stt',
        ) );
        foreach($terms_combo as $key => $value)
      {

        
        $current_lang = pll_current_language();
        switch ($current_lang) {
            case 'en':
                $list_destination  = get_term_meta($value->term_id,'list_destination',false);
                $list_destination = implode("_",$list_destination);
                $link_travel = get_permalink(get_page_by_path('experiences')).'?destination_combo='.$list_destination;
                //$link_travel = get_permalink(get_page_by_path('experiences')).'?destination_combo="'.$value->slug.'"';
                break;
            case 'es':
                $list_destination  = get_term_meta($value->term_id,'list_destination',false);
                $list_destination = implode("_",$list_destination);
                $link_travel = get_permalink(get_page_by_path('experiencias-2')).'?destination_combo='.$list_destination;
                //$link_travel = get_permalink(get_page_by_path('experiences')).'?destination_combo="'.$value->slug.'"';
                break;
            case 'pt':
                $list_destination  = get_term_meta($value->term_id,'list_destination',false);
                $list_destination = implode("_",$list_destination);
                $link_travel = get_permalink(get_page_by_path('experiencias')).'?destination_combo='.$list_destination;
                //$link_travel = get_permalink(get_page_by_path('experiences')).'?destination_combo="'.$value->slug.'"';
                break;
            default:
                $list_destination  = get_term_meta($value->term_id,'list_destination',false);
                $list_destination = implode("_",$list_destination);
                $link_travel = get_permalink(get_page_by_path('experiences')).'?destination_combo='.$list_destination;
                //$link_travel = get_permalink(get_page_by_path('experiences')).'?destination_combo="'.$value->slug.'"';
                break;
        }

        echo "<a href='".$link_travel."'>";
        echo '<h5 class="combo-tour">'.str_replace("+","<span style = color:black;>+</span>",$value->name).'</h5>';
        echo '</a>';
      }
    ?>
        
    <?php
        $html = ob_get_clean();
        return $html;
    });
//footer booking_customize_info
add_shortcode('booking_customize_info', function(){
    $post_id = $_GET['post_id'];
   // $get_month = $_GET['month'];
   // $get_adult = $_GET['adult'];
   // $get_language = $_GET['language'];
   // $get_flight = $_GET['flight'];
    //style tour
    $styles = wp_get_post_terms( $post_id, 'travel_style', array() );
    $travel_style = $styles[0]->name;
    $days = 0; 
    $itinerarys = (get_post_meta($post_id, 'itinerary',true))?:array();            
    if($itinerarys){
        $days = count($itinerarys);
        if($days>0){
            $day_html = ($days==1)?$days.' '.__("Day",'mundo').' / 0 '.__("Night",'mundo').'': $days. ' '.__("Days",'mundo').' / '.($days-1).' '.__("Nights",'mundo').'';
            $day_html = __($day_html,'mundo');
        }
         // dia diem xuat phat theo hanh trinh itinerary
        $breakfasts = 0;
        $lunchs = 0;
        $dinners = 0;
        $visited_names = array();
        $country_names = array();
        $des_name = array();
        //print_r($itinerarys);exit();
        foreach($itinerarys as $itinerary){
            foreach($itinerary['meals'] as $meal){
                if($meal == 'breakfast' ){
                    $breakfasts++;   
                }
                if($meal == 'lunch'){
                    $lunchs++;   
                }
                if($meal == 'dinner'){
                    $dinners++;   
                }  
            } 
            // lay visited và country
            foreach($itinerary['visited'] as $visited){
               $post_des = get_post($visited);
               
               $visited_term = get_term($visited,'category-destination');
               //$visited_names[$visited_term->slug]= $visited_term->name;
               $visited_names[] = $post_des->post_title;
              // $term_parent = ($visited_term->parent == 0) ? $visited_term : get_term($visited_term->parent, 'category-destination');
               //$country_names[$term_parent->slug] = $term_parent->name;
               // lay parent cua visited term
               
               //lay danh sach destination theo khach san
               foreach($itinerary['accomodation'] as $hotel_id){
                    $des_term= get_the_terms($hotel_id,'category-destination');
                   $des_name[]= $des_term[0]->name;
                }
            }
        } 
    }
    $country_names_term = wp_get_post_terms( $post_id, 'category-destination', array() );
    $visited_names = array();
    foreach ($country_names_term as $key => $value) {
        if ($value->parent==0) {
            $country_names[] = $value->name;
        }
        if ($value->parent!=0) {
            $visited_names[] = $value->name;
        }
    }
    $visited_names = implode(', ', $visited_names);
    $country_names = implode(', ', $country_names);
    $tour_type = get_post_meta($post_id, 'select_type',true);
    $price_from_html = '';
    if($tour_type == 'seat_in_coach'){
        $price_from_html = '<div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left text-subtitle-overview et_pb_text_subtitle_overview_4">
                                <div class="row">
                                    <p class="col-md-4">'.__('From','mundo').':</p>
                                    <div class="et_pb_text_inner col-md-8 price-book">
                                        <p>$ 0</p>
                                    </div>
                                </div>
                            </div> <!-- .et_pb_text -->';
    }
   // lay diem start va end
    
   // $highlight_city = get_post_meta($post_id, 'highlight_city', true);
//    d($highlight_city);
//    $highlight_city = explode(', ',$highlight_city);
//    d($highlight_city);
    //d($des_name);
    $start_places = $des_name[0];
    $end_places = end($des_name);
    // lay visited
    // lay country
    $html = '<div id="address_contact" class=" et_pb_row et_pb_row_2">
                <div class="et_pb_column et_pb_column_1_3  et_pb_column_2 et_pb_css_mix_blend_mode_passthrough">
                    <div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left text-subtitle-overview et_pb_text_subtitle_overview_0">
                        <div class="row">
                            <p class="col-md-4">'.__('Style','mundo').':</p>
                            <div class="et_pb_text_inner col-md-8">
                                <p>'.$travel_style.'</p>
                            </div>
                        </div>
                    </div> <!-- .et_pb_text -->
                    
                    <div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left text-subtitle-overview et_pb_text_subtitle_overview_1">
                        <div class="row">
                            <p class="col-md-4">'.__('Itinerary','mundo').':</p>
                            <div class="et_pb_text_inner col-md-8">
                                 <p>'.$day_html.'</p>
                            </div>
                        </div>
                    </div> <!-- .et_pb_text -->
                    
                    <div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left text-subtitle-overview et_pb_text_subtitle_overview_2"> 
                        <div class="row">
                            <p class="col-md-4">'.__('Start','mundo').':</p>
                            <div class="et_pb_text_inner col-md-8">
                                <p>'.$start_places.'</p>
                            </div>
                        </div>
                    </div> <!-- .et_pb_text -->
                    
                    <div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left text-subtitle-overview et_pb_text_subtitle_overview_3">
                        <div class="row">
                            <p class="col-md-4">'.__('End','mundo').':</p>
                            <div class="et_pb_text_inner col-md-8">
                                <p>'.$end_places.'</p>
                            </div>
                        </div>
                    </div> <!-- .et_pb_text -->
                </div> <!-- .et_pb_column -->
                <div class="et_pb_column et_pb_column_1_3  et_pb_column_3 et_pb_css_mix_blend_mode_passthrough">
                
                    '.$price_from_html.'
                    <div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left text-subtitle-overview et_pb_text_subtitle_overview_5">
                        <div class="row">
                            <p class="col-md-4"> '.__('Meals','mundo').':</p>
                            <div class="et_pb_text_inner col-md-8">
                                <p>'.__("Breakfast",'mundo').': '.$breakfasts.'</p>
                                <p>'.__("Lunch",'mundo').': '.$lunchs.'</p>
                                <p>'.__("Dinner",'mundo').': '.$dinners.'</p>
                            </div>
                        </div>
                    </div> <!-- .et_pb_text -->
                </div> <!-- .et_pb_column -->
                <div class="et_pb_column et_pb_column_1_3  et_pb_column_4 et_pb_css_mix_blend_mode_passthrough et-last-child"> 
                    <div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left text-subtitle-overview et_pb_text_subtitle_overview_6">    
                        <div class="row">
                            <p class="col-md-4">'.__('Visiting','mundo').':</p>
                            <div class="et_pb_text_inner col-md-8">
                                <p>'.$visited_names.'</p>
                            </div>
                        </div>
                    </div> <!-- .et_pb_text -->
                    <div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left text-subtitle-overview et_pb_text_subtitle_overview_7">
                        <div class="row">
                            <p class="col-md-4">'.__('Countries','mundo').':</p>
                            <div class="et_pb_text_inner col-md-8">
                                <p>'.$country_names.'</p>
                            </div>
                        </div>
                    </div> <!-- .et_pb_text -->
                </div> <!-- .et_pb_column -->
            </div> <!-- .et_pb_row -->';
    return $html;
});


//form search in honeymoon
add_shortcode('form_search_tour_in_honeymoon',function(){
    $destination = $_GET['destination'];
    $travel_style = $_GET['travel_style'];
    $date_tour = $_GET['date_tour'];
    $terms = get_terms( 'duration', array(
        'hide_empty' => false,
    ) );
    ob_start();
?>
    
    <form method="post" class="form-search-travel-style" >
        <div id="travel_style_search" class="et_pb_search et_pb_module et_pb_bg_layout_light et_pb_text_align_left  et_pb_search_0">
            <!-- <input type="text" name="tour_name" id="tour_name" class="et_pb_s" placeholder="Search tour: Enter your name"/> -->
            <label> <?php echo __('Search tour', 'mundo');?>:</label>
            <input type="text" name="tour_name" id="tour_name" class="et_pb_s" placeholder="<?php echo __('Enter tour name', 'mundo');?>"/>
            <input type="submit" name="submit" value="<?php echo __('Search', 'mundo');?>" class="make-enquire" id="submit_travel_style" data-id ="tours_travel_style_honeymoon" data-travel_style_cat ="<?php echo get_query_var('travel_style_cat')?:'';?>"/>
        </div>
        <div id="form-search-home" >
             <?php wp_nonce_field('form_search_home'); ?>
        <?php 
            $terms_destination = get_terms( array(
                'taxonomy' => 'category-destination',
                'hide_empty' => false,
                'parent' => 0,
                'meta_query' => array(
                        'stt' => array(
                            'key' => 'stt',
                            'compare' => 'meta_value_num',
                            'type'    => 'numeric',
                        ), 
                    ),
                'orderby' => 'stt',
            ) );
            $terms_travel_style = get_terms( array(
                'taxonomy' => 'travel_style',
                'hide_empty' => false,
                'meta_query' => array(
                        'stt' => array(
                            'key' => 'style_thu_tu',
                            'compare' => 'meta_value_num',
                            'type'    => 'numeric',
                        ), 
                    ),
                'orderby' => 'stt',
            ) );
        ?>
        
        <div class="wrapper-destination_search">
            <p class='sub-title-search'> <?php echo __('Choose Destination', 'mundo');?></p>
            <select name="destination" id="destination" class="destination_search" multiple="true" readonly>
                <?php
                   
                    foreach($terms_destination as $term) {
                        $selected = ($destination == $term->slug)?'selected':'';
                        printf('<option value="%s" %s>%s</option>', $term->slug, $selected, $term->name);
                    }
                ?>
            </select>
            <span></span>
        </div>
        <input type="hidden" name="travel_style" id="travel_style" value="honeymoon">
        <div class="wrapper-date_tour"> 
            <p class='sub-title-search'><?php echo __('Choose Duration ', 'mundo');?></p> 
            <select name="duration" id="duration" class="travel_style_search duration_search" search="true" multiple="true" readonly>
                
                <?php
                   // $from_day = time();
        //                    $to_day = strtotime("+3 year");
        //                    for($i = $from_day; $i<$to_day; $i = strtotime('+1 month', $i)) {
        //                        $selected = ($date_tour == date('m_Y', $i))?'selected':'';
        //                        printf('<option value="%s" %s>%s</option>', date('m_Y', $i), $selected, date('F Y', $i));
        //                    }
                    $durations =  get_terms( 'duration_tour', array(
                        'hide_empty' => false,
                    ) );
                    foreach($durations as $term) {
                        $selected = ($_GET['duration'] == $term->slug)?'selected':'';
                        printf('<option value="%s" %s>%s</option>', $term->slug, $selected, $term->name);
                    }
                ?>
            </select>
            <span></span>
            
        </div>
        <div class="wrapper-search_tour">  
            <p class='sub-title-search'> <?php echo __('Choose departure', 'mundo');?></p>
            <input type="text" name="date_tour" placeholder="<?php echo __('Choose departure here', 'mundo');?>" id="date_tour" class="date_tour"  value="<?php echo __('Choose departure here', 'mundo');?>"/>
            
        </div>
        </div>
       
    </form>
<?php
    $html = ob_get_clean();
    return $html;
});
// form search in travel style
add_shortcode('form_search_tour_in_travel_style',function(){
    $p_destination = $_POST['destination']?:'';
    $p_travel_style = $_POST['travel_style']?:'';
    $p_date_tour = $_POST['date_tour']?:'';
    $destination = $_GET['destination'];

    $travel_style = $_GET['travel_style'];
    $date_tour = $_GET['date_tour'];
    $terms = get_terms( 'duration', array(
        'hide_empty' => false,
    ) );
    $destination_combo = $_GET['destination_combo'];
    if ($destination_combo) {
        $destination_combo = explode('_', $destination_combo);
    }
    //print_r($destination);exit();
    ob_start();
?>
    
    <form method="post" class="form-search-travel-style" >
        
        <div id="form-search-home" >

        <?php 
            $terms_destination = get_terms( array(
                'taxonomy' => 'category-destination',
                'hide_empty' => false,
                'parent' => 0,
                'meta_query' => array(
                        'stt' => array(
                            'key' => 'stt',
                            'compare' => 'meta_value_num',
                            'type'    => 'numeric',
                        ), 
                    ),
                'orderby' => 'stt',
            ) );
            $terms_travel_style = get_terms( array(
                'taxonomy' => 'travel_style',
                'hide_empty' => false,
                'meta_query' => array(
                        'stt' => array(
                            'key' => 'style_thu_tu',
                            'compare' => 'meta_value_num',
                            'type'    => 'numeric',
                        ), 
                    ),
                'orderby' => 'stt',
            ) );
            //print_r($terms_travel_style);exit();
        ?>
        <div class="wrapper-destination_search">
            <p class='sub-title-search'> <?php echo __('Choose destination', 'mundo');?></p>
            <select name="destination" id="destination" class="destination_search" multiple="true">
                <?php
                   
                    foreach($terms_destination as $term) {
                        $selected = (in_array($term->slug, $destination) )?'selected':'';
                        $p_selected = ($p_destination == $term->slug)?'selected':'';
                        $combo_selected = (in_array($term->slug, $destination_combo) )?'selected':'';
                        printf('<option value="%s" %s %s %s>%s</option>', $term->slug, $selected, $p_selected,$combo_selected, $term->name);
                    }
                ?>
            </select>

            
         </div>
        <div class="wrapper-travel_style_search">
            <p class='sub-title-search'> <?php echo __('Choose style', 'mundo');?></p>
            <select name="travel_style" id="travel_style" class="travel_style_search" search="true" multiple="true">
                <?php
                    foreach($terms_travel_style as $term) {
                        $selected = (in_array($term->slug, $travel_style) )?'selected':'';
                        $p_selected = ($p_travel_style == $term->slug)?'selected':'';
                        printf('<option value="%s" %s %s>%s</option>', $term->slug, $selected, $p_selected, $term->name);
                    }
                ?>
            </select>
     
            
        </div>
        <div class="wrapper-date_tour"> 
            <p class='sub-title-search'> <?php echo __('Choose duration', 'mundo');?></p> 
            <select name="duration" id="duration" class="travel_style_search duration_search" search="true" multiple="true" readonly>
                
                <?php
                   // $from_day = time();
//                    $to_day = strtotime("+3 year");
//                    for($i = $from_day; $i<$to_day; $i = strtotime('+1 month', $i)) {
//                        $selected = ($date_tour == date('m_Y', $i))?'selected':'';
//                        printf('<option value="%s" %s>%s</option>', date('m_Y', $i), $selected, date('F Y', $i));
//                    }
                    $durations =  get_terms( 'duration_tour', array(
                        'hide_empty' => false,
                    ) );
                    foreach($durations as $term) {
                        $selected = ($_GET['duration'] == $term->slug)?'selected':'';
                        printf('<option value="%s" %s>%s</option>', $term->slug, $selected, $term->name);
                    }
                ?>
            </select>
     
            
        </div>
        <div class="wrapper-search_tour">  
            <p class='sub-title-search'> <?php echo __('Choose departure', 'mundo');?></p>
            <input type="text" name="date_tour"   placeholder="<?php echo __('Choose departure here', 'mundo');?>" id="date_tour" class="date_tour" value="<?php echo __('Choose departure here', 'mundo');?>"/>
            
        </div>
        <div class="clear-both"></div>
        </div>
        <div id="travel_style_search" class="et_pb_search et_pb_module et_pb_bg_layout_light et_pb_text_align_left  et_pb_search_0">
            <label> <?php echo __('Search tour', 'mundo');?>:</label>
            <input type="text" name="tour_name" id="tour_name" class="et_pb_s" placeholder="<?php echo __('Enter tour name', 'mundo');?>"/>
            <input type="submit" name="submit" value="<?php echo __('Search', 'mundo');?>" class="make-enquire" id="submit_travel_style" data-id ="tours_travel_style" data-travel_style_cat ="<?php echo get_query_var('travel_style_cat')?:'';?>"/>
        </div>
    </form>
<?php
    $html = ob_get_clean();
    return $html;
});
add_shortcode('form_search_booking_from_home', function(){
    ob_start();
    ?>
    <?php 
    $current_lang = pll_current_language();
    switch ($current_lang) {
        case 'en':
            $link = get_permalink(get_page_by_path('make-enquiry'));
            break;
        case 'es':
            $link = get_permalink(get_page_by_path('hacer-reserva'));
            break;
        case 'pt':
            $link = get_permalink(get_page_by_path('solicite-aqui'));
            break;
        default:
            $link = get_permalink(get_page_by_path('make-enquiry'));
            break;
    }
?>
    
    <form method="post" id="form-search-home" action="<?php echo $link; ?>" class="form_in_make_enquiry">
        <input type="hidden" name="action" value="form_search_home" />
        <?php wp_nonce_field('form_search_home'); ?>
        <?php 
            $terms_destination = get_terms( array(
                'taxonomy' => 'category-destination',
                'hide_empty' => false,
                'parent' => 0,
                'meta_query' => array(
                        'stt' => array(
                            'key' => 'stt',
                            'compare' => 'meta_value_num',
                            'type'    => 'numeric',
                        ), 
                    ),
                'orderby' => 'stt',
            ) );
            $terms_travel_style = get_terms( array(
                'taxonomy' => 'travel_style',
                'hide_empty' => false,
                'meta_query' => array(
                        'stt' => array(
                            'key' => 'style_thu_tu',
                            'compare' => 'meta_value_num',
                            'type'    => 'numeric',
                        ), 
                    ),
                'orderby' => 'stt',
            ) );
        ?>
        <div class="wrapper-destination_search">
            <select name="destination[]" class="destination_search" multiple="true" search="true" readonly>
                <!-- <option class="placeholder-select"> <?php //echo __('Destination', 'mundo');?></option> -->
                <?php
                    foreach($terms_destination as $term) {
                        $selected = ($_POST['destination'] == $term->slug)?'selected':'';
                        printf('<option value="%s" %s>%s</option>', $term->slug, $selected, $term->name);
                    }
                ?>
            </select>
            <span></span>
            <p class='sub-title-search'> <?php echo __('Where would you like to go?', 'mundo');?></p>
         </div>
        <div class="wrapper-travel_style_search">
            <select name="travel_style[]" class="travel_style_search" multiple="true" search="true" readonly>
                <!-- <option class="placeholder-select"> <?php //echo __('Experiences', 'mundo');?></option> -->
                <?php
                    foreach($terms_travel_style as $term) {
                        $selected = ($_POST['travel_style'] == $term->slug)?'selected':'';
                        printf('<option value="%s" %s>%s</option>', $term->slug, $selected, $term->name);
                    }
                ?>
            </select>
            <span></span>
            <p class='sub-title-search'> <?php echo __('What would you like to do?', 'mundo');?></p>
        </div>
        <div class="wrapper-date_tour">  
            <select name="date_tour" class="travel_style_search duration_search" search="true">
                <option class="placeholder-select"><?php echo __('Departures ', 'mundo');?></option>
                <?php
                    $from_day = time();
                    $to_day = strtotime("+3 year");
                    for($i = $from_day; $i<$to_day; $i = strtotime('+1 month', $i)) {
                        $selected = ($_POST['date_tour'] == date('m_Y', $i))?'selected':'';
                        printf('<option value="%s" %s>%s</option>', date('m_Y', $i), $selected, date('F Y', $i));
                    }
                ?>
            </select>
            <span></span>
            <p class='sub-title-search'><?php echo __('When do you want to travel? ', 'mundo');?></p>
        </div>
    </form>
<?php
    $html = ob_get_clean();
    return $html;
});
add_shortcode('form_search_home', function($attr){
    $destination = $_POST['destination'];
    $travel_style = $_POST['travel_style'];
    $date_tour = $_POST['date_tour'];
    $btn_search = ' <div class="wrapper-search_tour">
                        <input class="search_tour" type="submit" name="search_tour" value="'.__("Search tour",'mundo').'" id="search_tour">
                    </div>';
    $step_1 = '';
    if($_POST['search_tour']){
        $btn_search = '';
        $step_1 = '<h1><span>'.__("Step 1",'mundo').'.</span> '.__("Design Your Tour",'mundo').'</h1>';
    }
    ob_start();
    echo $step_1;
?>
    <?php 
        $current_lang = pll_current_language();
        switch ($current_lang) {
            case 'en':
                $link = get_permalink(get_page_by_path('experiences'));
                break;
            case 'es':
                $link = get_permalink(get_page_by_path('experiencias-2'));
                break;
            case 'pt':
                $link = get_permalink(get_page_by_path('experiencias'));
                break;
            default:
                $link = get_permalink(get_page_by_path('experiences'));
                break;
        }
    ?>
    <form method="get" id="form-search-home" action="<?php echo $link;?>">
        <input type="hidden" name="action" value="form_search_home" />
        <?php wp_nonce_field('form_search_home'); ?>
        <?php 
            $terms_destination = get_terms( array(
                'taxonomy' => 'category-destination',
                'hide_empty' => false,
                'parent' => 0,
                'meta_query' => array(
                        'stt' => array(
                            'key' => 'stt',
                            'compare' => 'meta_value_num',
                            'type'    => 'numeric',
                        ), 
                    ),
                'orderby' => 'stt',
            ) );
            $terms_travel_style = get_terms( array(
                'taxonomy' => 'travel_style',
                'hide_empty' => false,
                'meta_query' => array(
                        'stt' => array(
                            'key' => 'style_thu_tu',
                            'compare' => 'meta_value_num',
                            'type'    => 'numeric',
                        ), 
                    ),
                'orderby' => 'stt',
            ) );
            //print_r($terms_travel_style);exit();
        ?>

        <div class="wrapper-destination_search">
            <p class='sub-title-search'><?php echo __('Where would you like to go?', 'mundo');?></p>
            <select name="destination[]" class="destination_search" search="true" multiple="true" readonly>
           <!--      <option class="placeholder-select" disabled selected hidden value="0"> <?php //echo __($attr['text_1'], 'mundo');?></option> -->
                <?php
                   
                    foreach($terms_destination as $term) {
                        $selected = ($destination == $term->slug)?'selected':'';
                        printf('<option value="%s" %s>%s</option>', $term->slug, $selected, $term->name);
                    }
                ?>
            </select>
            <span></span>
            
            <span class="icon-arr-down"></span>
         </div>
        <div class="wrapper-travel_style_search">
            <select name="travel_style[]" class="travel_style_search" search="true" multiple="true" readonly >
                <!-- <option class="placeholder-select" disabled selected hidden value="0"> <?php //echo __($attr['text_2'], 'mundo');?></option> -->
                <?php
                    foreach($terms_travel_style as $term) {
                        $selected = ($travel_style == $term->slug)?'selected':'';
                        printf('<option value="%s" %s>%s</option>', $term->slug, $selected, $term->name);
                    }
                ?>
            </select>
            <span></span>
            <p class='sub-title-search'> <?php echo __('What would you like to do?', 'mundo');?></p>
            <span class="icon-arr-down"></span>
        </div>
        <div class="wrapper-date_tour">  
            <select name="date_tour" class="travel_style_search duration_search" multiple="true" search="true" readonly>
                <!-- <option class="placeholder-select" disabled selected hidden value="0"><?php //echo __($attr['text_3'], 'mundo');?></option> -->
                <?php
                    $from_day = time();
                    $to_day = strtotime("+3 year");
                    for($i = $from_day; $i<$to_day; $i = strtotime('+1 month', $i)) {
                        $selected = ($date_tour == date('m_Y', $i))?'selected':'';
                        printf('<option value="%s" %s>%s</option>', date('m_Y', $i), $selected, date('F Y', $i));
                    }
                ?>
            </select>
            <span></span>
            <p class='sub-title-search'><?php echo __('When do you want to travel? ', 'mundo');?></p>
            <span class="icon-arr-calendar"></span>
        </div>
       <?php echo $btn_search;?>
    </form>
<?php
    $html = ob_get_clean();
    return $html;
});
// add_action('wp_ajax_nopriv_mundo_save_tour', 'mundo_save_tour');
// add_action('wp_ajax_mundo_save_tour', 'mundo_save_tour');
// function mundo_save_tour(){
//     $tour_id = $_POST['tour_id'];
//     if (isset($_COOKIE['post_tour']))
//     {
//         $cookie_tour =  $_COOKIE['post_tour'];
//     }
//     echo $cookie_tour;echo 'new-section';exit();
//     if ($cookie_tour!='tour_id') {
//         $new_cookie = $cookie_tour.'-'.$tour_id;
//         setcookie('post_tour', $new_cookie, time() + 86400*365);
//         echo 'lưu thành công'.$new_cookie;
//     }
//     exit();
// }
// add_shortcode('favorate_tour', function(){
//     if (isset($_COOKIE['post_tour']))
//     {
//         $cookie_tour =  $_COOKIE['post_tour'];
//         echo $cookie_tour;
//     }
//     ob_start();
//     $html = ob_get_clean();
//     return $html;
// });
add_shortcode('form_search_restaurants', function(){
    $terms = get_terms( 'duration', array(
        'hide_empty' => false,
    ) );

    ob_start();
?>
    <form method="post" id="form-search-hotel" class="et_pb_row row" action="<?php echo admin_url('admin-post.php')?>">
        <?php 
            $terms_destination = get_terms( array(
                'taxonomy' => 'category-destination',
                'hide_empty' => false,
            ) );
            $terms_style = get_terms( array(
                'taxonomy' => 'res_style',
                'hide_empty' => false,
            ) );
        ?>  
        <div class="col-md-4">
            <p><?php echo __("Search Hotel",'mundo');?></p>
             <select  class="hotel-name-search icon" search="true" name="name_res_search" id="name_res_search" readonly>
                <option><?php echo __('Restaurant Name ', 'mundo');?></option>
                <?php
                    $posts = get_posts(array(
                        'post_type' => 'restaurant',
                        'posts_per_page' => -1,
                    ));
                    foreach($posts as $post) {
                        printf('<option value="%s">%s</option>', $post->post_title, $post->post_title);
                    }
                ?>
            </select>
            
        </div>
        <div class="col-md-4">
            <p><?php echo __("Choose City",'mundo');?></p>
            <select  class="hotel-city-search" search="true" name="res_city_search" id="res_city_search" readonly>
                <option> <?php echo __('Choose City Here', 'mundo');?></option>
                <?php
                    foreach($terms_destination as $term) {
                        printf('<option value="%s">%s</option>', $term->slug, $term->name);
                    }
                ?>
            </select>
        </div>
        <div class="col-md-4">
            <p><?php echo __("Choose Restaurant Style",'mundo');?></p>
            <select class="hotel-style-search" search="true" name="res_style_search" id="res_style_search" readonly>
                <option> <?php echo __('Choose Style here', 'mundo');?></option>
                <?php
                    foreach($terms_style as $term) {
                        printf('<option value="%s">%s</option>', $term->slug, $term->name);
                    }
                ?>
            </select>
        </div>    
            
    </form>
<?php
    $html = ob_get_clean();
    return $html;
});

add_shortcode('form_search_hotel', function(){
    $terms = get_terms( 'duration', array(
        'hide_empty' => false,
    ) );

    ob_start();
?>
    <form method="post" id="form-search-hotel" class="et_pb_row row" action="<?php echo admin_url('admin-post.php')?>">
        <?php 
            $terms_destination = get_terms( array(
                'taxonomy' => 'category-destination',
                'hide_empty' => false,
            ) );
            $terms_style = get_terms( array(
                'taxonomy' => 'hotel_style',
                'hide_empty' => false,
            ) );
        ?>  
        <div class="col-md-4">
            <p><?php echo __("Search Hotel",'mundo');?></p>
             <select  class="hotel-name-search icon" search="true" name="search_hotel" id="search_hotel" readonly>
                <option><?php echo __('Hotel Name ', 'mundo');?></option>
                <?php
                    $posts = get_posts(array(
                        'post_type' => 'hotel',
                        'posts_per_page' => -1,
                    ));
                    foreach($posts as $post) {
                        printf('<option value="%s">%s</option>', $post->post_title, $post->post_title);
                    }
                ?>
            </select>
            
        </div>
        <div class="col-md-4">
            <p><?php echo __("Choose City",'mundo');?></p>
            <select  class="hotel-city-search" search="true" name="hotel_city_search" id="hotel_city_search" readonly>
                <option>Choose City Here</option>
                <?php
                    foreach($terms_destination as $term) {
                        printf('<option value="%s">%s</option>', $term->slug, $term->name);
                    }
                ?>
            </select>
        </div>
        <div class="col-md-4">
            <p><?php echo __("Choose Hotel Style",'mundo');?></p>
            <select class="hotel-style-search" search="true" name="hotel_style_search" id="hotel_style_search" readonly>
                <option> <?php echo __('Choose Style here', 'mundo');?></option>
                <?php
                    foreach($terms_style as $term) {
                        printf('<option value="%s">%s</option>', $term->slug, $term->name);
                    }
                ?>
            </select>
        </div>    
            
    </form>
<?php
    $html = ob_get_clean();
    return $html;
});
add_shortcode('form_search_blog', function(){
    $terms = get_terms( 'duration', array(
        'hide_empty' => false,
    ) );

    ob_start();
    $current_lang = pll_current_language();
    switch ($current_lang) {
        case 'en':
            $link = 'inspiration';
            break;
        case 'es':
            $link = 'inspiracion';
            break;
        case 'pt':
            $link = 'inspiracao';
            break;
        

    }
?>
    <form method="get" id="form-search-blog" class="form-search-blog row" action="<?php echo home_url($link)?>">
        <input class="blog-name-search" type="text" name="blog_name" placeholder="<?php echo __('Type article name','mundo');?>" id="blog_name"><span class="icon"></span>
        <button class="icon-search" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>   
    </form>
<?php
    $html = ob_get_clean();
    return $html;
});
add_shortcode('link_riderect', function(){
    $html = '/finish-subscribing';
    return $html;
});

add_shortcode('bread_ex', function($att){ 
    ob_start();
    $travel_style_cat = get_query_var('travel_style_cat')?:'';
    $current_lang = $pll_current_language;
    switch ($current_lang) {
        case 'en':
            $ex_link = get_permalink(get_page_by_path('experiences'));
            break;
        case 'es':
            $ex_link = get_permalink(get_page_by_path('experiencias-2'));
            break;
        case 'pt':
            $ex_link = get_permalink(get_page_by_path('experiencias'));
            break;
        default:
            # code...
            break;
    }
    if ($travel_style_cat) {
        $terms = get_terms( 'travel_style', array(
            'hide_empty' => false,
            'slug' => $travel_style_cat,
        ) );
        foreach ($terms as $key => $value) {
            echo  '<a href="'.home_url().'">'.__('Home','Mundo').'</a> /  <a href="'.$ex_link.'">'.$att['title'].'</a>'.' / '.$value->name;
        } 
    }else{
         echo  '<a href="'.home_url().'">'.__('Home','Mundo').'</a> /  <a href="'.$ex_link.'">'.$att['title'].'</a>';
    }
    //print_r($html);exit();
    $html = ob_get_clean();
    return $html;
});
add_shortcode('bread_ex_head', function($att){ 
    ob_start();
    $travel_style_cat = get_query_var('travel_style_cat')?:'';

    if ($travel_style_cat) {
        $terms = get_terms( 'travel_style', array(
            'hide_empty' => false,
            'slug' => $travel_style_cat,
        ) );
        foreach ($terms as $key => $value) {
            echo  '<h1>'.$value->name.'</h1>';
        } 
    }else{
         echo  '<h1>'.$att['title'].'</h1>';
    }
    //print_r($html);exit();
    $html = ob_get_clean();
    return $html;
});
add_shortcode('experiences_content', function($att){ 
    ob_start();
    $travel_style_cat = get_query_var('travel_style_cat')?:'';
    $content = $att['content'];
    if ($travel_style_cat) {
        $terms = get_terms( 'travel_style', array(
            'hide_empty' => false,
            'slug' => $travel_style_cat,
        ) );
        foreach ($terms as $key => $value) {
            echo $value->description;
        } 
    }else{
        echo  $att['content'];
    }
    //print_r($html);exit();
    $html = ob_get_clean();
    return $html;
});
add_shortcode('social_icons_blog', function(){
    ob_start();
?>
                        <div class='social_icons social_icons_blog '>
                                
                                <a href="<?php echo ot_get_option( 'facebook');?>" class="icon">
                                    <span aria-hidden="true" class="social_facebook"></span>
                                </a>
                                
                               <!--  <span aria-hidden="true" class="social-googleplus-ft">
                                    <a href="<?php echo ot_get_option( 'google');?>">
                                        <img src="<?php echo $home_url.'/wp-content/themes/mundo/icon/google.png';?>" class='icon-img'>
                                        <img src="<?php echo $home_url.'/wp-content/themes/mundo/icon/google_hover.png';?>" class='icon-hover'>
                                    </a>
                                </span> -->
                                
                                    <a href="<?php echo ot_get_option( 'twitter');?>" class="icon">
                                        <span aria-hidden="true" class="social_twitter"></span>
                                    </a>
                                
                                
                                    <a href="<?php echo ot_get_option( 'instagram');?>" class="icon">
                                        <span aria-hidden="true" class="social_instagram"></span>
                                    </a>
                                
                                
                                    <a href="<?php echo ot_get_option( 'linkedin');?>" class="icon">
                                        <span aria-hidden="true" class="social_linkedin_square"></span>
                                    </a>
                                
                                
                                    <a href="<?php echo ot_get_option( 'youtube');?>" class="icon">
                                        <span aria-hidden="true" class="social_youtube"></span>
                                    </a>
                                
                        </div>
<?php
    $html = ob_get_clean();
    return $html;
});
add_shortcode('my_custome_shortcode', function($attr){
        ob_start();
        global $post;
       ?>
       <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse " id="navbarNavAltMarkup">
    <div class="navbar-nav et_pb_row row navbar-nav-single tab_about">
        <?php $link = get_permalink();?>
        <div class="col-md-7 scroll-to-div">
            <a class="nav-item nav-link active" scroll-to ="our-story"  ><?php echo __($attr['tab_1'], 'mundo');?></a>
            <a class="nav-item nav-link" scroll-to ="meet-our-team" ><?php echo __($attr['tab_2'], 'mundo');?></a>
            <a class="nav-item nav-link" scroll-to ="what-make-us-diff" ><?php echo __($attr['tab_3'], 'mundo');?></a>
            <a class="nav-item nav-link disabled" scroll-to ="what-we-are-doing" ><?php echo __($attr['tab_4'], 'mundo');?></a>
        </div>
            
        <div class="btn-nav btn-single-desti col-md-5 show_on_desktop">
                        <span class="show_on_desktop">
                            <a href="" class="share-head"> <?php echo __('Share', 'mundo');?></a>
                            <div class="triangle2" >
                                    <ul class="et-social-icons icon-menu-top">
                                                    <li class="et-social-icon et-social-facebook">
                                                        <?php $link_share = "https://www.facebook.com/sharer.php?u=".get_permalink($post->ID);
                                                        $link_share_print = "https://www.pinterest.com/pin/find/?url=".get_permalink($post->ID);
                                                         $link_share_twitter = "https://twitter.com/intent/tweet?text=How%20to%20share%20a%20Tweet&url=".get_permalink($post->ID);
                                          ?>
                                                    <a href="<?php echo $link_share;?>" class="icon" target="blank">
                                                            <span><?php echo __('Facebook','Mundo') ?></span>
                                                        </a>
                                                    </li>
                                                    <!-- <li class="et-social-icon et-social-google-plus">
                                                        <a href="https://mail.google.com/mail/u/0/#inbox">
                                                            <img src="<?php echo $home_url;?>/wp-content/themes/mundo/icon/google.png" class="icon-img">
                                                            <img src="<?php echo $home_url;?>/wp-content/themes/mundo/icon/google_hover.png" class="icon-hover">
                                                        </a>
                                                    </li> -->
                                                    <li class="et-social-icon et-social-whatsapp" >
                                                        <a href="<?php echo $link_share_print;?>" target="blank">
                                                            <i class="fa fa-pinterest" ></i>
                                                            <!-- <img src="<?php echo $home_url;?>/wp-content/themes/mundo/icon/whatsapp.png" class="icon-img">
                                                            <img src="<?php echo $home_url;?>/wp-content/themes/mundo/icon/whatsapp_hover.png" class="icon-hover"> -->
                                                        </a>
                                                    </li>
                                                    <li class="et-social-icon et-social-twitter" >
                                                        <a href="<?php echo $link_share_twitter;?>" class="icon" target="blank" >
                                                            <span><?php echo __('Twitter','Mundo') ?></span>
                                                        </a>
                                                    </li>
                                    </ul>
                            </div>
                        </span>
                        <?php 
                            $current_lang = pll_current_language();
                                switch ($current_lang) {
                                    case 'en':
                                        $link = get_permalink(get_page_by_path('contact'));
                                        break;
                                    case 'es':
                                        $link = get_permalink(get_page_by_path('contactenos'));
                                        break;
                                    case 'pt':
                                        $link = get_permalink(get_page_by_path('contato'));
                                        break;
                                    default:
                                        $link = get_permalink(get_page_by_path('contact'));
                                        break;
                                }
                        ?>
                        <a href="<?php echo $link;?>" class="make-enquire">  <?php echo __('CONTACT US', 'mundo');?></a>
                    </div>
    </div>
    </div>
</nav>
        
    <?php
        $html = ob_get_clean();
        return $html;
    });
add_shortcode('tab_about', function($attr){
        ob_start();
        global $post;
       ?>
       <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse " id="navbarNavAltMarkup">
    <div class="navbar-nav et_pb_row row navbar-nav-single tab_about">
        <?php $link = get_permalink();?>
        <div class="col-md-8 scroll-to-div">
            <a class="nav-item nav-link active" scroll-to ="our-story"  ><?php echo __($attr['tab_1'], 'mundo');?></a>
            <a class="nav-item nav-link" scroll-to ="meet-our-team" ><?php echo __($attr['tab_2'], 'mundo');?></a>
            <a class="nav-item nav-link" scroll-to ="what-make-us-diff" ><?php echo __($attr['tab_3'], 'mundo');?></a>
            <a class="nav-item nav-link disabled" scroll-to ="what-we-are-doing" ><?php echo __($attr['tab_4'], 'mundo');?></a>
        </div>
            
        <div class="btn-nav btn-single-desti col-md-4 show_on_desktop">
                        <span class="show_on_desktop">
                            <a href="" class="share-head"> <?php echo __('Share', 'mundo');?></a>
                            <div class="triangle2" >
                                    <ul class="et-social-icons icon-menu-top">
                                                    <li class="et-social-icon et-social-facebook">
                                                        <?php $link_share = "https://www.facebook.com/sharer.php?u=".get_permalink($post->ID);
                                                        $link_share_print = "https://www.pinterest.com/pin/find/?url=".get_permalink($post->ID);
                                                         $link_share_twitter = "https://twitter.com/intent/tweet?text=How%20to%20share%20a%20Tweet&url=".get_permalink($post->ID);
                                          ?>
                                                    <a href="<?php echo $link_share;?>" class="icon" target="blank">
                                                            <span><?php echo __('Facebook','Mundo') ?></span>
                                                        </a>
                                                    </li>
                                                    <!-- <li class="et-social-icon et-social-google-plus">
                                                        <a href="https://mail.google.com/mail/u/0/#inbox">
                                                            <img src="<?php echo $home_url;?>/wp-content/themes/mundo/icon/google.png" class="icon-img">
                                                            <img src="<?php echo $home_url;?>/wp-content/themes/mundo/icon/google_hover.png" class="icon-hover">
                                                        </a>
                                                    </li> -->
                                                    <li class="et-social-icon et-social-whatsapp" >
                                                        <a href="<?php echo $link_share_print;?>" target="blank">
                                                            <i class="fa fa-pinterest" ></i>
                                                            <!-- <img src="<?php echo $home_url;?>/wp-content/themes/mundo/icon/whatsapp.png" class="icon-img">
                                                            <img src="<?php echo $home_url;?>/wp-content/themes/mundo/icon/whatsapp_hover.png" class="icon-hover"> -->
                                                        </a>
                                                    </li>
                                                    <li class="et-social-icon et-social-twitter" >
                                                        <a href="<?php echo $link_share_twitter;?>" class="icon" target="blank" >
                                                            <span><?php echo __('Twitter','Mundo') ?></span>
                                                        </a>
                                                    </li>
                                    </ul>
                            </div>
                        </span>
                        <?php 
                            $current_lang = pll_current_language();
                                switch ($current_lang) {
                                    case 'en':
                                        $link = get_permalink(get_page_by_path('contact'));
                                        break;
                                    case 'es':
                                        $link = get_permalink(get_page_by_path('contactenos'));
                                        break;
                                    case 'pt':
                                        $link = get_permalink(get_page_by_path('contato'));
                                        break;
                                    default:
                                        $link = get_permalink(get_page_by_path('contact'));
                                        break;
                                }
                        ?>
                        <a href="<?php echo $link;?>" class="make-enquire">  <?php echo __('CONTACT US', 'mundo');?></a>
                    </div>
    </div>
    </div>
</nav>
        
    <?php
        $html = ob_get_clean();
        return $html;
    });
add_filter('post_owlcarousel_query_args', function($query_args, $module_id) {
    switch ($module_id) {
        case 'excursion_relate':
                global $post;
                $post_id = $post->ID;
                $excursion_relate = get_post_meta($post_id,'excursion_relate',false);
                $query_args['post__in']= $excursion_relate;    
                $query_args['orderby'] = 'post__in';  
            return $query_args;
            break;
        case 'relate_excursion_check_out':
                global $post;
                $post_id = $_REQUEST['excursion'];
                $relate_excursion_check_out = get_post_meta($post_id,'excursion_relate_booked',false);
                $query_args['post__in']= $relate_excursion_check_out;    
                $query_args['orderby'] = 'post__in';  
            return $query_args;
            break;
        case 'post_home':
            // $query_args['post_type']= 'post'; 
            // //$query_args['lang']= $current_lang;
            // $query_args['meta_query']['view_home'] = array(
            //     'key' => 'view_home',
            //     'value' => 1,
            // );
            $query_args = array();
            $query_args['post_type']= 'post'; 
            $query_args['meta_query']['view_home'] = array(
                'key' => 'view_home',
                'value' => 1,
            );
            return $query_args;
            break;
        case 'post_destination_page':
            global $post;
                $post_id = $post->ID;
                $terms = wp_get_post_terms( $post_id, 'category-destination', array() );
                $query_args['post_type']= 'post'; 
                $query_args['tax_query']['hotel_destination'] = array(
                            'taxonomy' => 'category-destination',
                            'field'    => 'slug',
                            'terms'    => $terms[0]->slug,
               );
            return $query_args;
            break;
        case 'post_hotel_detination':
            global $post;
                $post_id = $post->ID;
                $hotel_relate = get_post_meta($post_id,'hotel_relate',false);
                $query_args = array();
                
                $query_args['post_type']= 'hotel'; 
                $query_args['post__in']= $hotel_relate;    
                $query_args['orderby'] = 'post__in';  
            return $query_args;
            break;
        case 'post_restaurant_detination':
            global $post;
                $post_id = $post->ID;
                $restaurant_relate = get_post_meta($post_id,'restaurant_relate',false);
                $query_args = array();
                $query_args['post_type']= 'restaurant'; 
                $query_args['post__in']= $restaurant_relate;    
                $query_args['orderby'] = 'post__in';  
            return $query_args;
            break;
        case 'sic_destination_page':
            global $post;
                $post_id = $post->ID;
                $terms = wp_get_post_terms( $post_id, 'category-destination', array() );
                $query_args['post_type']= 'tour';
                $query_args['posts_per_page'] = -1;
                $query_args['meta_query'] = array(
                    array(
                        'key' => 'select_type',
                        'value' => 'seat_in_coach',
                        'compare' => '=',
                    ),                       
                );
                $query_args['tax_query']['destination'] = array(
                            'taxonomy' => 'category-destination',
                            'field'    => 'slug',
                            'terms'    => $terms[0]->slug,
               );

            return $query_args;
            break;
        case 'package_home':
            $query_args['post_type']= 'package';
            $query_args['meta_query']['show_home'] = array(
                'key' => 'show_home',
                'value' => 1,
            );
            return $query_args;
            break;
        case 'city_of_vietnam':
        global $post;
        $terms = wp_get_post_terms( $post->ID, 'category-destination', array() );
        $slug = $terms[0]->slug;
            $query_args['post_type']= 'destination';
            // $query_args['tax_query']['city'] = array(
            //     'taxonomy' => 'category-destination',
            //     'field'    => 'slug',
            //     'terms'    => $slug,
            // );
            // $query_args['tax_query']['not_viet_nam'] = array(
            //             'taxonomy' => 'category-destination',
            //             'field'    => 'slug',
            //             'terms'    => $slug,
            //             'operator' => 'NOT IN',
            //             'include_children' => false,
            // );  
            global $post;
            $post_id = $post->ID;
            $experts = get_post_meta($post_id,'city_relate',false);
            $query_args['post__in']= $experts;    
            $query_args['orderby'] = 'post__in';      
            //print_r($query_args);exit();
        return $query_args;
            break;
        default:
            # code...
            break;
    }
    // if($module_id == 'package_home') {
        
    // }
    return $query_args;
}, 10, 2);

// content list tour
add_filter('custom_post_show_content', function($post_content, $module_id, $post) {
    if($module_id == 'city_of_vietnam_list_hotel'){
        $location = wp_get_post_terms( $post->ID, 'category-destination', array() );
        $hotel_styles = wp_get_post_terms( $post->ID, 'hotel_style', array() );
        $post_content = '<div class="content">';
        $post_content .= '<span class="location">'.$location[0]->name.'</span>   ';
        $post_content .= ' <span class="style">'.$hotel_styles[0]->name.'</span>  <hr> ';
        $discount_price_html = '';
        
        $price = get_post_meta($post->ID,'price_from',true);
        $symbol_exchange = '$';
        if (isset($_COOKIE['exchange_rate'])){
            $exchange_rate_string = $_COOKIE['exchange_rate'];
            $exchange_rate_cookie = explode("-",$exchange_rate_string); 
            $price = $price * $exchange_rate_cookie[2];
            $symbol_exchange = $exchange_rate_cookie[1];
        }
        $lang = pll_current_language();
        $price = mundo_exchange_rate($price,$lang);
        $post_content .= '<div class=""><b class="text_gray">From:  </b>'.$discount_price_html.' <b class="'.$discount.' '.$text_gray.' price">'.$symbol_exchange.$price.' </b> <b class=" '.$discount.' text_gray "> per room</b></div></div>';     
        return $post_content;
    }
     if($module_id == 'city_of_vietnam_list_restaurants'){
        $location = wp_get_post_terms( $post->ID, 'category-destination', array() );
        $res_style = wp_get_post_terms( $post->ID, 'res_style', array() );
        $post_content = '<div class="content">';
        $post_content .= '<span class="location">'.$location[0]->name.'</span>   ';
        $post_content .= ' <span class="style">'.$res_style[0]->name.'</span>';
        $post_content .= '</div>';     
        return $post_content;
    }
    if($module_id == 'expert_hotel'){
        $specialize = get_post_meta($post->ID, 'Specialize',true);
        $introduce = get_post_meta($post->ID,'Introduce',true);
        $post_content = '';
        $post_content .= '<div class="specialize">'.$specialize.'</div>';
        $post_content .= '<div class="introduce">'.$introduce.'</div>';
    }
    if($module_id == 'expert_blog'){
        $specialize = get_post_meta($post->ID, 'Specialize',true);
        $introduce = get_post_meta($post->ID,'Introduce',true);
        $post_content = '';
        $post_content .= '<div class="specialize">'.$specialize.'</div>';
        $post_content .= '<div class="introduce">'.$introduce.'</div>';
    }
    if($module_id == 'traveller_reviews'){
        $title = get_post_meta($post->ID, 'title',true);
        $content = get_post_meta($post->ID, 'content',true);
        $guest_name = get_post_meta($post->ID,'guest_name',true);
        //$guest_name = get_post_meta($post->ID,'from',true);
        $country = wp_get_post_terms( $post->ID, 'country', array() );
        $country_name = $country[0]->name;
        $post_content = '';
        $post_content .= '<div class="title-review">'.$title.'</div>';
        $post_content .= '<div class="content-review">'.$content.'</div>';
        $post_content .= '<div class="guest_name_review">'.$guest_name.'</div>';
        $post_content .= '<div class="country_name_review">'.$country_name.'</div>';
        
    }
    if($module_id == 'excursion_reviews'){
        $title = get_post_meta($post->ID, 'title',true);
        $content = get_post_meta($post->ID, 'content',true);
        $guest_name = get_post_meta($post->ID,'guest_name',true);
        $country = wp_get_post_terms( $post->ID, 'country', array() );
        $country_name = $country[0]->name;
        $post_content = '';
        $post_content .= '<div class="title-review">'.$title.'</div>';
        $post_content .= '<div class="content-review">'.$content.'</div>';
        $post_content .= '<div class="guest_name_review">'.$guest_name.'</div>';
        $post_content .= '<div class="country_name_review">'.$country_name.'</div>';
        
    }
    
    return $post_content;
    },10,3);
add_filter('custom_posts_show_more', function($posts, $module_id, $args=array(), $offset, $fullwidth) {
    if(($module_id == 'tours_travel_style')||($module_id == 'tours_travel_style_honeymoon')){
        $content = '<div class="et_pb_salvattore_content tour_in_travel_style" data-columns>';
        //$posts = get_posts($args);
        //print_r($args);exit();
        $posts = array();
        $posts_first = get_posts($args);
        foreach ($posts_first as $key_post => $value_post) {
            $quanty_all = 0;
            $quanty_term = 0;
            $quanty_term_other = 0;



            $term_des_parent = wp_get_post_terms($value_post->ID,'category-destination',array('parent'=>0));
            $term_des_id = wp_list_pluck( $term_des_parent, 'term_id');



            $quanty_term = count($term_des_id);
            $term_des = wp_get_post_terms($value_post->ID,'category-destination',array());
            $term_parent_other = array();
            foreach ($term_des as $key_1 => $value_1){
                if ( ( !in_array($value_1->parent, $term_des_id) ) && ( $value_1->parent != 0) ) {//Nếu cha ko thuộc các cha còn lại và cha khác 0
                    $term_parent_other[] = $value_1->parent;
                }
            }

            $term_parent_other = array_unique($term_parent_other);




            $quanty_term_other = count($term_parent_other);

            $quanty_all = $quanty_term + $quanty_term_other;

            $value_post->quanty_term = $quanty_all;
            $posts[] = $value_post;
        }
        
        if (!$order_price) {
            usort($posts, function($a, $b)
            {
                return strcmp($a->quanty_term, $b->quanty_term);
            });
        }

        $posts_found = count($posts);
        if(($posts_found>0) && ($posts_found>$offset)){
            array_pop($posts);
        }
        $i = 1;
        foreach($posts as $post){
            $content .= get_post_tour_html($post,$module_id,$i,$fullwidth);
            $i++;
        }
        $content .= '</div>';
        return $content; 
    }
    return $posts;
},10,5);

add_filter('custom_posts_style_1', function($posts, $module_id) {
    
    if( $module_id == 'post_restaurant_alternative' ) {
        
        global $post;
        if($post->post_type == 'restaurant'){
            $alternative_posts = get_post_meta($post->ID, 'alternative_res',false);
            $content = '<div class="et_pb_salvattore_content" data-columns>';
            foreach($alternative_posts as $post_id){
                $thumbnail_id = get_post_thumbnail_id($post_id);
                    $src = mundo_get_attachment_image_src($thumbnail_id, 'hotel_another')?:'';                   
                    $title = (get_the_title($post_id))?:''; 
                    $location = wp_get_post_terms( $post_id, 'category-destination', array() );
                    $styles = wp_get_post_terms( $post_id, 'res_style', array() );
                    $content .= '<article id="'.$post_id.'" class="et_pb_post clearfix post-'.$post_id.' '.$post->post_type.' type-'.$post->post_type.' status-publish format-standard has-post-thumbnail hentry category-uncategorized">';
                    $content .= '<div class="et_pb_image_container">    ';
                    $content .= '<a href="'.get_the_permalink($post_id).'" class="entry-featured-image-url">';
                    $content .= '<img src="'.$src.'" alt=""> ';  
                    $content .= '</a>'   ;  
                    $content .= '</div>';
                    $content .= '<div class="content"><a href="'.get_the_permalink($post_id).'">';
                    $content .= '   <h2 class="entry-title"><b>'.$title.'</b></h2>';
                    $content .= ' <span class="location">'.$location[0]->name.'</span>   ';
                    $content .= ' <span class="style">'.$styles[0]->name.'</span>';
                    $content .= '</a></div>';
                    $content .= '   </article>';
            }
            $content .= '</div>';
            return $content;   
        }
        
        return $content;
    }
    if( $module_id == 'post_hotel_alternative' ) {
        
        global $post;
        if($post->post_type == 'hotel'){
            $alternative_posts = get_post_meta($post->ID, 'alternative_hotel',false);
            $content = '<div class="et_pb_salvattore_content" data-columns>';
            foreach($alternative_posts as $post_id){
                $thumbnail_id = get_post_thumbnail_id($post_id);
                    $src = mundo_get_attachment_image_src($thumbnail_id, 'hotel_another')?:'';                   
                    $title = (get_the_title($post_id))?:''; 
                    $location = wp_get_post_terms( $post_id, 'category-destination', array() );
                    $hotel_styles = wp_get_post_terms( $post_id, 'hotel_style', array() );
                    $content .= '<article id="'.$post_id.'" class="et_pb_post clearfix post-'.$post_id.' post type-post status-publish format-standard has-post-thumbnail hentry category-uncategorized">';
                    $content .= '<div class="et_pb_image_container">    ';
                    $content .= '<a href="'.get_the_permalink($post_id).'" class="entry-featured-image-url">';
                    $content .= '<img src="'.$src.'" alt=""> ';  
                    $content .= '</a>'   ;  
                    $content .= '</div>';
                    $content .= '<div class="content"><a href="'.get_the_permalink($post_id).'">';
                    $content .= '   <h2 class="entry-title"><b>'.$title.'</b></h2>';
                    $content .= ' <span class="location">'.$location[0]->name.'</span>   ';
                    $content .= ' <span class="style">'.$hotel_styles[0]->name.'</span>  <hr> ';
                    $discount_price_html = '';
                    $price = get_post_meta($post_id,'price_from',true);
                    $symbol_exchange = '$';
                    if (isset($_COOKIE['exchange_rate'])){
                        $exchange_rate_string = $_COOKIE['exchange_rate'];
                        $exchange_rate_cookie = explode("-",$exchange_rate_string); 
                        $price = $price * $exchange_rate_cookie[2];
                        $symbol_exchange = $exchange_rate_cookie[1];
                    }
                    $lang = pll_current_language();
                    $price = mundo_exchange_rate($price, $lang);
                    $content .= '<div class=""><b class="text_gray">From:  </b>'.$discount_price_html.' <b class="price'.$discount.' '.$text_gray.'">'.$symbol_exchange.$price.' </b> <b class=" '.$discount.' text_gray "> per room</b></div>';
                    $content .= '</a></div>';
                    $content .= '   </article>';
            }
            $content .= '</div>';
            return $content;   
        }
        
        return $content;
    }

    return $posts;
    },10,2);
    
add_filter('custom_post_query_args', function($query_args, $module_id) {
    if( $module_id == 'post_destination' ) {
        $query_args['post_type']= 'destination'; 
        $query_args['meta_query']= array(array(
                'key' => 'view_home',
                'value' => '1',
                'compare' => '='
            ));
        // $terms = get_terms( array(
        //     'taxonomy' => 'category-destination',
        //     'hide_empty' => false,
        //     'parent' => 0,
        //     'meta_query' => array(
        //         'key' => 'des_view_home',
        //         'value' => 1,
        //     )
        // ) );
        // $terms = wp_list_pluck($terms,'term_id');
        
        // $query_args['tax_query'] = array(
        //     'relation' => 'AND',
        //     array(
        //         'taxonomy' => 'category-destination',
        //         'field'    => 'term_id',
        //         'terms'     => $terms,
        //         'operator' => 'IN',
        //     ),
        // );
        return $query_args;
       // print_r($query_args); exit;
    }
    if( $module_id == 'post_destination_whyus' ) {
        $query_args['post_type']= 'destination'; 
        $query_args['meta_query']= array(array(
                'key' => 'view_why_us',
                'value' => '1',
                'compare' => '='
            ));
        return $query_args;
    }
    if( $module_id == 'traveller_reviews' ) {
        global $post;
        $review_id = get_post_meta($post->ID,'related_review',false);
        $query_args['post_type']= 'customer_feedback'; 
        $query_args['post__in']= $review_id; 
        return $query_args;
    }
    if( $module_id == 'excursion_reviews' ) {
        global $post;
        $review_id = get_post_meta($post->ID,'related_review',false);
        $query_args['post_type']= 'customer_feedback'; 
        $query_args['post__in']= $review_id; 
        return $query_args;
    }


    if ($module_id=='city_of_vietnam_list_hotel') {
        $query_args['post_type']= 'hotel';
        $query_args['posts_per_page']= 10;
        $query_args['post_status']= 'publish';
    }
    if ($module_id=='city_of_vietnam_list_restaurants') {
        $query_args['post_type']= 'restaurant';
        $query_args['posts_per_page']= 10;
    }
    
    if( $module_id == 'post_tour' ) {
        $query_args['post_type']= 'tour'; 
        //$query_args['meta_query']['show_home'] = array(
//            'key' => 'style_view_home',
//            'value' => 1,
//        );
    }
    if( $module_id == 'post_popular' ) {
        $query_args['post_type']= 'tour'; 
       //  $query_args['meta_query']['show_home'] = array(
       //     'key' => 'style_view_home',
       //     'value' => 1,
       // );
    }
    // if( $module_id == 'post_home' ) {
    //     $query_args['post_type']= 'post'; 
    //     $query_args['meta_query']['view_home'] = array(
    //         'key' => 'view_home',
    //         'value' => 1,
    //     );

    // }
    if( $module_id == 'post_destination_page' ) {
        global $post;
        $post_id = $post->ID;
        $terms = wp_get_post_terms( $post_id, 'category-destination', array() );
        $query_args['post_type']= 'post'; 
        $query_args['tax_query']['hotel_destination'] = array(
                    'taxonomy' => 'category-destination',
                    'field'    => 'slug',
                    'terms'    => $terms[0]->slug,
       );
    }
    if( $module_id == 'post_responsible' ) {
        $current_lang = pll_current_language();
        $query_args['post_type']= 'post'; 
        $query_args['meta_query']['show_responsible'] = array(
                    'key' => 'show_responsible',
                    'value' => 1,
        );
        $query_args['post_per_page']= 3;

    }
    if( $module_id == 'related_post' ) {
        global $post;
        $post_id = $post->ID;

        $related_post = get_post_meta($post_id,'related_post',false);
        $query_args = array();
        $query_args['post_type']= 'post'; 
        $query_args['posts_per_page']= 3;
        $query_args['post__in'] = $related_post;
        $query_args['orderby'] = 'post__in'; 

    }
    if( $module_id == 'post_expert_home' ) {
        $query_args['post_type']= 'expert'; 
        //$query_args['meta_query']['view_home'] = array(
//            'key' => 'view_home',
//            'value' => 1,
//        );
    }  
    if( $module_id == 'post_expert_detination' ) {
        global $post;
        $post_id = $post->ID;
        $experts = get_post_meta($post_id,'experts',false);
        $query_args['post_type']= 'expert'; 
        $query_args['post__in']= $experts; 
        $query_args['orderby'] = 'post__in'; 
        
    } 

    if( $module_id == 'travel_about' ) {
        $query_args['post_type']= 'post'; 
        $query_args['meta_query']['view_about'] = array(
            'key' => 'view_about',
            'value' => 1,
        );
        $query_args['posts_per_page']= '4'; 
    } 
    if( $module_id == 'expert_blog' ) {
        $query_args['post_type']= 'expert'; 
        $query_args['meta_query']['expert_view_blog'] = array(
            'key' => 'expert_view_blog',
            'value' => 1,
        );
    }
    if( $module_id == 'expert_hotel' ) {
        $query_args['post_type']= 'expert'; 
        $query_args['meta_query']['expert_view_hotel'] = array(
            'key' => 'expert_view_hotel',
            'value' => 1,
        );
    }
    if( $module_id == 'tours_travel_style' ) {
        $query_args['post_type']= 'tour'; 
        $query_args['posts_per_page'] = 9;
        if (isset($_COOKIE['post_tour']) && $_GET['save_tour'] )
        {
            $cookie_tour =  $_COOKIE['post_tour'];
            //print_r($cookie_tour);exit();
            $all_id_tour = explode("-",$cookie_tour);
            if (!empty($all_id_tour)) {
                $query_args['post__in'] = $all_id_tour;
            }
        }
        $travel_style_cat = get_query_var('travel_style_cat');
        //print_r($travel_style_cat);exit();
        $terms_destination = get_terms( array(
            'taxonomy' => 'category-destination',
            'hide_empty' => false,
            'parent' => 0
        ) );
        $terms_destination_slug = wp_list_pluck( $terms_destination, 'slug');

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

        if($travel_style_cat=='all'){
            $query_args['meta_query']['seat_in_coach'] = array(
                    'key'     => 'select_type',
                    'value'   => 'seat_in_coach',
                    'compare' => 'LIKE',
                );
            
        }else{
            if (in_array($travel_style_cat, $terms_destination_slug)) {
                $query_args['meta_query']['seat_in_coach'] = array(
                    'key'     => 'select_type',
                    'value'   => 'seat_in_coach',
                    'compare' => '=',
                );
                $query_args['tax_query']['destination'] = array(
                    array(
                        'taxonomy' => 'category-destination',
                        'terms' => $travel_style_cat,
                        'field' => 'slug'
                    )
                ); 
            }elseif($travel_style_cat){
                $query_args['tax_query']['travel_style'] = array(
                    array(
                        'taxonomy' => 'travel_style',
                        'terms' => $travel_style_cat,
                        'field' => 'slug'
                    )
                ); 

            }   
        }
        //Truyền dữ liệu search
        $destination = $_GET['destination']?:'';
        $travel_style = $_GET['travel_style']?:'';
        $date_tour = $_GET['date_tour']?:'';
        $destination_combo = $_GET['destination_combo'];
        if($travel_style){
            $query_args['tax_query']['travel_style'] = array(
                array(
                    'taxonomy' => 'travel_style',
                    'terms' => $travel_style,
                    'field' => 'slug'
                )
            );
        }
  
        if($destination){
        	foreach ($destination as $key_des => $value_des) {
        		$query_des[] = array(
                    'taxonomy' => 'category-destination',
                    'terms' => $value_des,
                    'field' => 'slug'
                );
        	}
            $query_args['tax_query']['destination'] = $query_des;
        }
        if($destination_combo){
            $destination_combo = explode('_', $destination_combo);
            // $query_args['tax_query']['destination'] = array(
            //     array(
            //         'taxonomy' => 'category-destination',
            //         'terms' => $destination_combo,
            //         'field' => 'slug'
            //     )
            // );
            foreach ($destination_combo as $key_des => $value_des) {
                $query_des[] = array(
                    'taxonomy' => 'category-destination',
                    'terms' => $value_des,
                    'field' => 'slug'
                );
            }
            $query_args['tax_query']['destination'] = $query_des;
        }

        $args_all_post = $query_args;
        $args_all_post['posts_per_page'] = -1;
        $all_posts = get_posts($args_all_post);
        $total_posts = count($all_posts);
        $duration = $_POST['duration']?:'';
        if($duration){
            $duration_term = get_terms(array(
                'taxonomy' => 'duration_tour',
                'hide_empty' => false,
                'slug' => $duration,
            ) );
            //print_r($duration_term);
            if(!empty($duration_term)){
                $from = get_term_meta($duration_term[0]->term_id,'duration_from',true);
                $to = get_term_meta($duration_term[0]->term_id,'duration_to',true);
        
                // get post
                $posts = get_posts($query_args);
                //lay cac post có duration 
                foreach($posts as $post){
                     $itinerarys = (get_post_meta($post->ID, 'itinerary',true))?:array();            
                     $days = ($itinerarys)?count($itinerarys):0;
                     if(($days >= $from) && ($days <= $to)){
                        $query_args['post__in'][$post->ID]= $post->ID;

                         
                     }
                };
                if(empty($query_args['post__in'])){
                    $query_args['post__in']= array(0);
                }
            }else{
                $query_args['post__in']= array(0);
            }
        }
        //print_r($query_args);exit();
        //end serach by duration
    }
    //Nếu là page honeymoon
    if( $module_id == 'tours_travel_style_honeymoon' ) {
        $query_args['post_type']= 'tour'; 
        $query_args['tax_query']['travel_style'] = array(
            array(
                'taxonomy' => 'travel_style',
                'terms' => 'honeymoon',
                'field' => 'slug'
            )
        );        
        $query_args['posts_per_page'] = 10;
    }
    if($module_id == 'post_blog'){
        $query_args['post_type']= 'post'; 
        //search name
        $blog_name = $_GET['blog_name'];
        $query_args['s'] = $blog_name;
        //search destintion
        $des_slug = $_GET['destination'];
        if($des_slug){
            $query_args['tax_query']['blog_destination'] = array(
                array(
                        'taxonomy' => 'category-destination',
                        'field'    => 'slug',
                        'terms'    => $des_slug,
                ),
            );
        }
    }
    return $query_args; 
}, 10, 2);
add_filter('custom_post_post_thumb',function($image, $post, $module_id) {
    switch ($module_id) {
        case 'departure_month':
            $thumbnail_id = get_post_thumbnail_id($post);
            if($thumbnail_id) {
                $src = mundo_get_attachment_image_src($thumbnail_id, 'tour_another');
                $image = sprintf('<img src="%s" alt="%s" />', $src, $post->post_title);
            }
            return $image;
        break;
        case 'tours_travel_style_honeymoon':
        case 'tours_travel_style':
            $thumbnail_id = get_post_thumbnail_id($post);
            if($thumbnail_id) {
                $src = mundo_get_attachment_image_src($thumbnail_id, 'tour_another');
                $image = sprintf('<img src="%s" alt="%s" />', $src, $post->post_title);
            }
            return $image;
        break;
        case 'post_home':
            $thumbnail_id = get_post_thumbnail_id($post);
            if($thumbnail_id) {
                $src = mundo_get_attachment_image_src($thumbnail_id, 'post_home');
                $image = sprintf('<img src="%s" alt="%s" />', $src, $post->post_title);
            }
            return $image;
        break;
        case 'post_destination_page':
            $thumbnail_id = get_post_thumbnail_id($post);
            if($thumbnail_id) {
                $src = mundo_get_attachment_image_src($thumbnail_id, 'post_home');
                $image = sprintf('<img src="%s" alt="%s" />', $src, $post->post_title);
            }
            return $image;
        break;
        case 'sic_destination_page':
            $thumbnail_id = get_post_thumbnail_id($post);
            if($thumbnail_id) {
                $src = mundo_get_attachment_image_src($thumbnail_id, 'post_home');
                $image = sprintf('<img src="%s" alt="%s" />', $src, $post->post_title);
            }
            return $image;
        break;
        case 'related_post':
            $thumbnail_id = get_post_thumbnail_id($post);
            if($thumbnail_id) {
                $src = mundo_get_attachment_image_src($thumbnail_id, 'related_post');
                $image = sprintf('<img src="%s" alt="%s" />', $src, $post->post_title);
            }
            return $image;
        break;
        case 'post_responsible':
            $thumbnail_id = get_post_thumbnail_id($post);
            if($thumbnail_id) {
                $src = mundo_get_attachment_image_src($thumbnail_id, 'post_home');
                $image = sprintf('<img src="%s" alt="%s" />', $src, $post->post_title);
            }
            return $image;
        break;
        case 'post_expert_detination':
            $thumbnail_id = get_post_thumbnail_id($post);
            if($thumbnail_id) {
                $src = mundo_get_attachment_image_src($thumbnail_id, 'post_expert_detination');
                $image = sprintf('<img src="%s" alt="%s" />', $src, $post->post_title);
            }
            return $image;
        break;
        case 'post_expert_home':
            $thumbnail_id = get_post_thumbnail_id($post);
            if($thumbnail_id) {
                $src = mundo_get_attachment_image_src($thumbnail_id, 'post_expert_home');
                $image = sprintf('<img src="%s" alt="%s" />', $src, $post->post_title);
            }
            return $image;
        break;
         case 'expert_hotel':
            $thumbnail_id = get_post_thumbnail_id($post);
            if($thumbnail_id) {
                $src = mundo_get_attachment_image_src($thumbnail_id, 'post_expert_home');
                $image = sprintf('<img src="%s" alt="%s" />', $src, $post->post_title);
            }
            return $image;
        break;
        case 'expert_blog':
            $thumbnail_id = get_post_thumbnail_id($post);
            if($thumbnail_id) {
                $src = mundo_get_attachment_image_src($thumbnail_id, 'post_expert_blog');
                $image = sprintf('<img src="%s" alt="%s" />', $src, $post->post_title);
            }
            return $image;
        break;
        case 'post_destination':
            $thumbnail_id = get_post_thumbnail_id($post);
            if($thumbnail_id) {
                $src = mundo_get_attachment_image_src($thumbnail_id, 'post_destination');
                $image = sprintf('<img src="%s" alt="%s" />', $src, $post->post_title);
            }
            return $image;
        case 'expert_about_page':
            $thumbnail_id = get_post_thumbnail_id($post);
            if($thumbnail_id) {
                $src = mundo_get_attachment_image_src($thumbnail_id, 'post_destination');
                $image = sprintf('<img src="%s" alt="%s" />', $src, $post->post_title);
            }
            return $image;
        case 'post_tour_slider_js':
            if($module_id == 'post_tour_slider_js') {
                $thumbnail_id = get_post_thumbnail_id($post);
                if($thumbnail_id) {
                    $src = mundo_get_attachment_image_src($thumbnail_id, 'tour_another');
                    $thumb = sprintf('<img src="%s" alt="%s" />', $src, $post->post_title);
                }
            }
            return $thumb;
        case 'post_tour_slider_js_mobile':
            if($module_id == 'post_tour_slider_js_mobile') {
                $thumbnail_id = get_post_thumbnail_id($post);
                if($thumbnail_id) {
                    $src = mundo_get_attachment_image_src($thumbnail_id, 'tour_another');
                    $thumb = sprintf('<img src="%s" alt="%s" />', $src, $post->post_title);
                }
            }
            return $thumb;
        default:
            # code...
            break;
    }
    return $image;
},10,3);
add_filter('custom_post_show_content',function($show_content, $module_id,$type_tour){
    // switch ($module_id) {
    //     case 'post_tour':
    //         $show_content='';
    //         global $post;
    //         $post_id = $post->ID;
    //         $routes = get_post_meta($post_id,'route',false);
    //         $departures_date = get_post_meta($post_id,'departure_date',false);
    //         if ($routes && $type_tour == 'travel_style') {
    //             $routes_name = implode('/', $routes);
    //             $show_content .= '<div class="route">'.$routes_name.'</div>';
    //         }
    //         if ($departures_date && $type_tour == 'departures_month' ) {
    //             $departures_date_name = implode(',', $departures_date['0']);
    //             $show_content .= '<div class="departures-date-name">'.$departures_date_name.'</div>';
    //         }
    //         $high_light = wp_get_post_terms( $post_id, 'highlight_city');
    //         if ($high_light) {
    //             $high_light_name_arr = wp_list_pluck($high_light,'name');
    //             $high_light_name = implode(',', $high_light_name_arr);
    //             $show_content .= '<div class="hight-tour-text"><span>'.__('Highlight City:').'</span> <span> '.$high_light_name.'</span></div>';
    //         }
    //         return $show_content;
    //     break;
    //     case 'expert_blog':
    //         $show_content='';
    //         global $post;
    //         $post_id = $post->ID;
    //         $Specialize = get_post_meta($post_id,'Specialize',true);
    //         $show_content .= $Specialize?'<div class="specialize-home">'.$Specialize.'</div>':'';
    //         $Introduce = get_post_meta($post_id,'Introduce',true);
    //         $show_content .= $Introduce?'<div class="introduce-home">'.$Introduce.'</div>':'';
    //         return $show_content;
    //     break;
    //     case 'expert_view_hotel':
    //         $show_content='';
    //         global $post;
    //         $post_id = $post->ID;
    //         $Specialize = get_post_meta($post_id,'Specialize',true);
    //         $show_content .= $Specialize?'<div class="specialize-home">'.$Specialize.'</div>':'';
    //         $Introduce = get_post_meta($post_id,'Introduce',true);
    //         $show_content .= $Introduce?'<div class="introduce-home">'.$Introduce.'</div>':'';
    //         return $show_content;
    //     break;
    //     case 'post_hotel_detination':
    //         $show_content='';
    //         global $post;
    //         $post_id = $post->ID;
    //         $location = get_post_meta($post_id,'location',true);
    //         $hotel = get_post_meta($post_id,'hotel_style',false);
    //         $terms = wp_get_post_terms( $post_id, 'hotel_style', array() );
    //         $show_content .= '<div class="destination-hotelinformation">'.$location.' '.$terms[0]->name.'</div>';
    //         $show_content .= '<div class="destination-hotel-content">From<span> US$ '.get_post_meta($post_id,'price_from',true).'</span> per room</div>';
    //         return $show_content;
    //     break;
    //     case 'city_of_vietnam_list_hotel':
    //      $show_content='';
    //         global $post;
    //         $post_id = $post->ID;
    //         $location = get_post_meta($post_id,'location',true);
    //         $hotel = get_post_meta($post_id,'hotel_style',false);
    //         $terms = wp_get_post_terms( $post_id, 'hotel_style', array() );
    //         $show_content .= '<div class="destination-hotelinformation">'.$location.' '.$terms[0]->name.'</div>';
    //         $show_content .= '<div class="destination-hotel-content">From<span> US$ '.get_post_meta($post_id,'price_from',true).'</span> per room</div>';
    //         return $show_content;
    //      break;
    //     default:
    //         # code...
    //         return $show_content;
    //         break;
    // }
    // if($module_id=='post_tour'){
    //     $show_content='';
    //     global $post;
    //     $post_id = $post->ID;
    //     $routes = get_post_meta($post_id,'route',false);
    //     $departures_date = get_post_meta($post_id,'departure_date',false);
    //     if ($routes && $type_tour == 'travel_style') {
    //         $routes_name = implode('/', $routes);
    //         $show_content .= '<div class="route">'.$routes_name.'</div>';
    //     }
    //     if ($departures_date && $type_tour == 'departures_month' ) {
    //         $departures_date_name = implode(',', $departures_date['0']);
    //         $show_content .= '<div class="departures-date-name">'.$departures_date_name.'</div>';
    //     }
    //     $high_light = wp_get_post_terms( $post_id, 'highlight_city');
    //     if ($high_light) {
    //         $high_light_name_arr = wp_list_pluck($high_light,'name');
    //         $high_light_name = implode(',', $high_light_name_arr);
    //         $show_content .= '<div class="hight-tour-text"><span>'.__('Highlight City:').'</span> <span> '.$high_light_name.'</span></div>';
    //     }
    // }
    return $show_content;
},10,3 );

add_filter('post_owlcarousel_posts', function($posts, $module_id) {
    if($module_id == 'thing_to_do_hotel'){
        global $post;
        if($post->post_type == 'hotel'){
             //print_r($post); exit;
            $posts = 'test';
            //$thing_to_do = get_post_meta($post->ID,'thing_to_do',true);
            $highlight_posts = (get_post_meta($post->ID,'things_to_do',false))?:array();
            $destination_posts = (get_post_meta($post->ID,'destination',false))?:array();
            $hotel_posts = (get_post_meta($post->ID,'hotel',false))?:array();
            $restaurant_posts = (get_post_meta($post->ID,'restaurant',false))?:array();
            $blog_posts = (get_post_meta($post->ID,'blog',false))?:array();                                                
            $things_to_do = array_merge($highlight_posts,$destination_posts, $hotel_posts, $restaurant_posts, $blog_posts);
            foreach ($things_to_do as $p) {
                $thumbnail_id = get_post_thumbnail_id($p);
                $src = mundo_get_attachment_image_src($thumbnail_id, 'hotel_detail')?:'';
                $title = (get_the_title($p))?:'';
                $description_thing_to_do =(get_the_excerpt($p))?:'';
                $content .= '<div  class="item">';
                $content .= ' <div><article id="post-'.$post->ID.'" class="et_pb_post clearfix post-'.$post->ID.' post type-post status-publish format-standard has-post-thumbnail hentry category-uncategorized"><div class="post-thumbnail"><a href="'.$link.'" class="entry-featured-image-url"><img src="'.$src.'" alt="'.$title.'" width="1080" height="675"></a></div>
                <div class="thing-to-do-content">
                <h2 class="entry-title content"><a href="'.$link.'">'.$title.'</a></h2>
                <p>'.$description_thing_to_do.'</p> </div>
                <hr class="line_bottom">';
                $content .= '
                
                </article></div>';
                $content .= '</div>';
            }
        } 
       
        return $content;
    }
    return $posts;
},10,2);
add_filter('custom_post_2_show_content',function($show_content, $module_id){
    if(in_array($module_id,array('post_expert_home','post_expert_detination'))){
        $show_content='';
        global $post;
        $post_id = $post->ID;
        $Specialize = get_post_meta($post_id,'Specialize',true);
        if ($Specialize) {
            $show_content .= '<div class="specialize-home">'.$Specialize.'</div>';
        }
    }
   
    return $show_content;
},10,2 );
add_filter( 'custom-post-owlcarosel-content', function($custom_content,$module_id ){
    if($module_id=='expert_about_page'){
        $custom_content='';
        global $post;
        $post_id = $post->ID; 
        $Specialize = get_post_meta($post_id,'Specialize',true);
        //return $Specialize;   
        if ($Specialize) {
            $custom_content .= '<div class="specialize-home">'.$Specialize.'</div>';
        }
    }
    if($module_id=='sic_destination_page'){
        $custom_content='';
        global $post;
        $post_id = $post->ID; 
        $custom_content= get_post_tour_html($post, $module_id = '',' ',',');
    }
    if($module_id=='excursion_relate'){
        $custom_content=' ';
        global $post;
        $custom_content= get_post_excursion_html($post, $module_id,0,'off');
    }

    if($module_id=='relate_excursion_check_out'){
        $custom_content=' ';
        global $post;
        $custom_content= get_post_excursion_html_check_out($post, $module_id,0,'off');
    }
    if($module_id=='excursion_expert_relate'){
        $custom_content=' ';
        global $post;
        $custom_content= get_post_meta($post->ID, 'Specialize',true);
    }
    if($module_id=='post_hotel_detination'){
        $custom_content=' ';
        global $post;
        $post_id = $post->ID;                
        $title = (get_the_title($post_id))?:''; 
        $location = wp_get_post_terms( $post_id, 'category-destination', array() );
        $hotel_styles = wp_get_post_terms( $post_id, 'hotel_style', array() );
        
        $custom_content .= '<div class="content"><a href="'.get_the_permalink($post_id).'">';
        $custom_content .= ' <span class="location">'.$location[0]->name.'</span>   ';
        $custom_content .= ' <span class="style">'.$hotel_styles[0]->name.'</span>  <hr> ';
        $discount_price_html = '';
        $price = get_post_meta($post_id, 'price_from',true);
        $symbol_exchange = '$';
        if (isset($_COOKIE['exchange_rate'])){
            $exchange_rate_string = $_COOKIE['exchange_rate'];
            $exchange_rate_cookie = explode("-",$exchange_rate_string); 
            $price = $price * $exchange_rate_cookie[2];
            $symbol_exchange = $exchange_rate_cookie[1];
        }
        $custom_content .= '<div class=""><b class="text_gray">From:  </b>'.$discount_price_html.' <b class="price'.$discount.' '.$text_gray.'">'.$symbol_exchange.$price.' </b> <b class=" '.$discount.' text_gray "> per room</b></div>';
        $custom_content .= '</a></div>';
    }
    if($module_id=='post_restaurant_detination'){
        $custom_content=' ';
        global $post;
        $post_id = $post->ID;                
        $title = (get_the_title($post_id))?:''; 
        $location = wp_get_post_terms( $post_id, 'category-destination', array() );
        $hotel_styles = wp_get_post_terms( $post_id, 'res_style', array() );
        
        $custom_content .= '<div class="content"><a href="'.get_the_permalink($post_id).'">';
        $custom_content .= ' <span class="location">'.$location[0]->name.'</span>   ';
        $custom_content .= ' <span class="style">'.$hotel_styles[0]->name.'</span>';        
        $custom_content .= '</a></div>';
    }
    return $custom_content;
},10,2);
add_shortcode('map_tour', function(){
        $home_url = home_url();
        ob_start();
        global $post;
        $post_id = $post->ID;
        print_r($post_id);echo 'test';
        $location = rwmb_get_value( 'map',$post_id);
        print_r($location);
    ?>
        
    <?php
        $html = ob_get_clean();
        return $html;
    });
add_shortcode('title_tour_shortcode', function(){
        $home_url = home_url();
        ob_start();
        $post_id = $_GET['post_id']?:'';
        $tour = get_post($post_id);
        $html = $tour->post_title;
        echo $tour->post_title;
        $html = ob_get_clean();
        return $html;
    });

add_shortcode('list_category_blog_destination', function(){
    $terms = get_terms( 'category-destination', array(
        'hide_empty' => true,
        'parent' => 0,
        'hierarchical' => false
    ) );
    ob_start();
    echo '<h5>'.__("Categories",'mundo').'</h5>';
    echo '<div class="list-blog-cate">';
    foreach ($terms as $key => $term) {
        switch ($current_lang) {
            case 'vi':
                $link = 'inspiration';
                break;
            case 'es':
                $link = 'inspiracion';
                break;
            case 'pt':
                $link = 'inspiracao';
                break;
        }
        $link = get_permalink(get_page_by_path($link)).'/?destination='.$term->slug;
        $args = array( 'post_type' =>'post',
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'category-destination',
                                        'field'    => 'slug',
                                        'terms'    => $term->slug,
                                    ),
                                ),);
        $query = new WP_Query( $args );
        $total = $query->found_posts;
        if($total){
            echo '<div class="blog_destination"><a href="'.$link.'">'.$term->name." (".$total.")".'</a></div>';
        }
    }
    echo '</div>';
    $html = ob_get_clean();
    return $html;
});
// function getIDfromGUID( $guid ){
//     global $wpdb;
//     return $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE guid=%s", $guid ) );
// }
add_filter ('post_slider_with_js_taxonomy', function($taxonomies, $module_id){
    switch ($module_id) {
        
         case 'departure_month':
             $args  = array(
                'taxonomy' => 'category-destination',
                'hide_empty' => false,
                'parent' => 0,

                'meta_query' => array(
                array(
                    'key'       => 'departure_month',
                    'value'     => true,
                    'compare'   => '='
                ),
                'stt' => array(
                            'key' => 'stt',
                            'compare' => 'meta_value_num',
                            'type'    => 'numeric',
                        ),  
            ),
            'orderby' => 'stt',
                // 'meta_query' => array
                //      (
                //         'departure_month' => array(
                //             'key' => 'departure_month',
                //             'value' => 1,
                //         ),
                //         //'order_depart' => array(
                //              //'relation' =>'OR',
                //             // 'stt' =>  array(
                //             //     'key' => 'stt',
                //             //     'compare' => 'meta_value_num',
                //             //     'type'  => 'numeric',
                //             // ),
                //             // 'stt_ex' => array(
                //             //                     'key' => 'stt',  
                //             //                     'compare' => 'NOT EXISTS',
                //             //                  ),
                //        //),
                //      ),
                // // 'orderby' => array(
                // //                     'stt' => 'ASC',
                // //                     'date' => 'DESC',
                // //                 ),
               
            );
            $taxonomies = get_terms( $args );
            return $taxonomies;
            break;
          case 'travel_guide_tour':
            $taxonomies = get_terms( array(
                'taxonomy' => 'category-travel-guide',
                'hide_empty' => false,
                'parent' => 0,
            ) );
            return $taxonomies;
            break;
          case 'other_tours':
            $taxonomies = array();
            return $taxonomies;
            break;

        default:
            return $taxonomies;
        break;
    }
},10,2);
add_filter ('post_slider_with_js_tab_header', function($tab_header, $module_id){
    if($module_id == 'tour_in_list_hotel'){
       // print_r('aa'); exit;
        return '';
    }
    if($module_id == 'expert_about_page'){
       $tab_header = '<div class = "travel_style tab_header text_center" data-taxonomy="expert_team" data-module_id='.$module_id.'>';
        $taxonomies = get_terms( array(
            'taxonomy' => 'expert_team',
            'hide_empty' => false,
        ) );
        $i = 1;
       foreach($taxonomies as $taxonomy){
            $active = ($i == 1)?'active':'';
           $tab_header .= '<span class="tab_name '.$active.'" data-slug="'.$taxonomy->slug.'">'.pll__($taxonomy->name).' </span>'; 
           $i += 1;
        }
        $tab_header .= '</div>';
        return $tab_header;
    }
    return $tab_header;
},10,2);
add_filter ('post_slider_with_js_query_args', function($query_args, $module_id){
    
     switch ($module_id) {
         case 'expert_about_page':
             $taxonomies = get_terms( array(
                'taxonomy' => 'expert_team',
                'hide_empty' => false,
                'number' => '1',
                
            ) );
        case 'excursion_relate':
                global $post;
                $post_id = $post->ID;
                $excursion_relate = get_post_meta($post_id,'excursion_relate',false);
                $query_args['post__in']= $excursion_relate;    
                $query_args['orderby'] = 'post__in';  
            return $query_args;
            break;

        case 'tour_in_list_hotel':
            $query_args['post_type']= 'tour';
            $query_args['posts_per_page'] = 3;
            $query_args['meta_query'] = array(
                array(
                    'key' => 'show_list_hotel',
                    'value' => 1,
                    'compare' => '=',
                ),
             );
            
            return $query_args;
            break;
        case 'post_tour_slider_js':
            global $post;
            //$query_args = array();
            $terms = wp_get_post_terms( $post->ID, 'category-destination', array() );
            $slug = $terms[0]->slug;
            $query_args['post_type']= 'tour';
            $query_args['posts_per_page'] = 18;
           
            
            if ($slug) {
                $query_args['meta_query']['sort_tour_by_cat'] = array(
                        'key' => 'sort_tour_by_cat',
                        'compare' => 'meta_value_num',
                        'type'  => 'numeric',
                    );
                //$query_args['meta_query']['relation'] = 'OR';
                $query_args['meta_query']['position_display'] = array(
                        'key' => 'position_display',
                        'compare' => 'meta_value_num',
                        'type'  => 'numeric',
                    );
                // $query_args['meta_query']['position_display_ex'] = array(
                //     'key' => 'position_display',  
                //     'compare' => 'NOT EXISTS'
                // );
                $query_args['orderby'] = array(
                        'sort_tour_by_cat' => 'ASC',
                        'position_display' => 'ASC',
                        'date' => 'DESC',
                    );

                $query_args['tax_query']['city'] = array(
                    'taxonomy' => 'category-destination',
                    'field'    => 'slug',
                    'terms'    => $slug,
                );
                
            }else{
                $query_args['meta_key']  = 'position_display';
                $query_args['order']   = 'ASC';
                $query_args['orderby']   = 'meta_value_num';
                $query_args['type']    = 'numeric';

                $query_args['meta_query']['relation'] = 'OR';
                $query_args['meta_query']['show_home'] = array(
                        'key' => 'show_home',
                        'value' => 1,
                        'compare' => '=',
                );

                $query_args['meta_query']['position_display_ex'] = array(
                        'key' => 'position_display',  
                        'compare' => 'NOT EXISTS'
                    );
            }
            return $query_args;
            break;
        case 'post_tour_slider_js_mobile':
            global $post;
            //$query_args = array();
            $terms = wp_get_post_terms( $post->ID, 'category-destination', array() );
            $slug = $terms[0]->slug;
            $query_args['post_type']= 'tour';
            $query_args['posts_per_page'] = -1;
           
            
            if ($slug) {
                $query_args['meta_query']['sort_tour_by_cat'] = array(
                        'key' => 'sort_tour_by_cat',
                        'compare' => 'meta_value_num',
                        'type'  => 'numeric',
                    );
                //$query_args['meta_query']['relation'] = 'OR';
                $query_args['meta_query']['position_display'] = array(
                        'key' => 'position_display',
                        'compare' => 'meta_value_num',
                        'type'  => 'numeric',
                    );
                // $query_args['meta_query']['position_display_ex'] = array(
                //     'key' => 'position_display',  
                //     'compare' => 'NOT EXISTS'
                // );
                $query_args['orderby'] = array(
                        'sort_tour_by_cat' => 'ASC',
                        'position_display' => 'ASC',
                        'date' => 'DESC',
                    );

                $query_args['tax_query']['city'] = array(
                    'taxonomy' => 'category-destination',
                    'field'    => 'slug',
                    'terms'    => $slug,
                );
                
            }else{
                $query_args['meta_key']  = 'position_display';
                $query_args['order']   = 'ASC';
                $query_args['orderby']   = 'meta_value_num';
                $query_args['type']    = 'numeric';

                $query_args['meta_query']['relation'] = 'OR';
                $query_args['meta_query']['show_home'] = array(
                        'key' => 'show_home',
                        'value' => 1,
                        'compare' => '=',
                );

                $query_args['meta_query']['position_display_ex'] = array(
                        'key' => 'position_display',  
                        'compare' => 'NOT EXISTS'
                    );
            }
            return $query_args;
            break;
        case 'departure_month':
            $query_args['post_type']= 'tour';
            $query_args['posts_per_page'] = -1;
            //$query_args['meta_query'] = array(
            //                array(
            //                    'key' => 'departure_month',
            //                    'value' => 1,
            //                    'compare' => '=',
            //                ),                     
            //             );
            $query_args['meta_query'] = array(
                //'relation' => 'OR',
                // array(
                //     'key' => 'show_home',
                //     'value' => 1,
                //     'compare' => '=',
                // ), 
                array(
                    'key' => 'select_type',
                    'value' => 'seat_in_coach',
                    'compare' => '=',
                ),                       
            );
            //print_r($query_args);
            return $query_args;
            break;
        case 'travel_guide_tour':
            global $post;
            $term_des_parent = wp_get_post_terms($post->ID,'category-destination',array('parent'=>0));
            $query_args['post_type']= 'tour';
            $query_args['posts_per_page'] = -1;
            $query_args['tax_query']['category-travel-guide'] = array(
                array(
                    'taxonomy' => 'category-travel-guide',
                    'operator' => 'EXISTS'
                ),                      
            );
            $query_args['tax_query']['destination'] = array(
                array(
                    'taxonomy' => 'category-destination',
                    'terms' => $term_des_parent[0]->slug,
                    'field' => 'slug'
                )
            );
            return $query_args;
            break;
        default:
            return $query_args;
        break;
    }
    
    return $query_args;
},10,2);
//form search restaurants
//form search hotel in hotel_list page
add_action('wp_ajax_nopriv_form_search_restaurants', 'mundo_form_search_restaurants');
add_action('wp_ajax_form_search_restaurants', 'mundo_form_search_restaurants');
function mundo_form_search_restaurants(){
    $title= ($_POST['title'] == 'Restaurant Name')?'':$_POST['title'];
    $city = $_POST['city'];
    $res_style = $_POST['res_style'];
    $offset = ($_POST['offset']);
    $module_id = ($_POST['module_id'])?:'';
    $args = array( 
        'post_type' => 'restaurant',
        'posts_per_page' => 10,
    );
    if($title){
        $args['s'] = $title;
    }
     if($city && $city!='Choose City Here'){
        $args['tax_query']['destination'] = array(
            array(
                'taxonomy' => 'category-destination',
                'terms' => $city,
                'field' => 'slug'
            )
        );
    }
    if($res_style && $res_style != 'Choose Style here'){
        $args['tax_query']['res_style'] = array(
            array(
                'taxonomy' => 'res_style',
                'terms' => $res_style,
                'field' => 'slug'
            )
        );
    }
    $json_args = json_encode($args);
    $json_args = str_replace('"','/',$json_args);
    $posts = get_posts($args);
    $posts_found = count($posts);
//    print_r('d'.$offset); exit;
    if(($posts_found>0) && ($posts_found>$offset)){
        array_pop($posts);
    }
    if($posts_found <= 3){
        $posts = array_chunk($posts, (count($posts) / 1)); 
    }else{
        $posts = array_chunk($posts, (count($posts) / 3)); 
    }
    $content = '';
    if($posts){
        $content = '<div class="et_pb_blog_grid clearfix et_pb_bg_layout_light">
                    <div class="et_pb_ajax_pagination_container">
                    <div class="et_pb_salvattore_content tour_in_travel_style" data-columns="3">';
        foreach($posts as $columns){
            $content .= '
                        <div class="column size-1of3">';
            foreach ($columns as $post){
                $content  .= get_post_res_html($post,$module_id);
            }
            $content  .= '</div>';
        }
        $content .= '</div></div></div>';
        if(($posts_found>0) && ($posts_found>$offset)){
            $content .= '<div class="show_more_posts"><input type="submit" class="make-enquire" name="btn_show_more_posts" id="btn_show_more_posts" value="'.__("Show More","mundo").'" data-step="2" data-args="'.$json_args.'" /></div> ';
        }
    }
    
    // dua att cuar arg vaof btn opset = 9 bor nhung thang dau ra roi tang ofset di
   // $content .= '</div>';
   // print_r($content);
    echo json_encode(array(
        'error' => 0,
        'mess' => '',
        'html' => $content,
    ));
    exit(); 
}

// save view couter
add_action('wp_ajax_nopriv_save_post_view', 'mundo_save_post_view');
add_action('wp_ajax_save_post_view', 'mundo_save_post_view');
function mundo_save_post_view(){
    $post_id = $_POST['post_id'];
    $post_id = substr($post_id,5);
    $view_couter = (get_post_meta($post_id, 'view', true))?:0;
    $view_couter ++;
    update_post_meta($post_id,'view',$view_couter);  
}



//form search hotel in hotel_list page
add_action('wp_ajax_nopriv_form_search_hotel', 'mundo_form_search_hotel');
add_action('wp_ajax_form_search_hotel', 'mundo_form_search_hotel');
function mundo_form_search_hotel(){
   $title= ($_POST['title'] == 'Hotel Name')?'':$_POST['title'];
    $city = $_POST['city'];
   // print_r($city); exit;
    $hotel_style = $_POST['hotel_style'];
    $offset = ($_POST['offset']);
    $module_id =($_POST['module_id'])?:'';
    $args = array( 
        'post_type' => 'hotel',
        'posts_per_page' => 10,
    );
    if($title){
        $args['s'] = $title;
    }
     if($city && $city!='Choose City Here'){
        $args['tax_query']['destination'] = array(
            array(
                'taxonomy' => 'category-destination',
                'terms' => $city,
                'field' => 'slug'
            )
        );
    }
    if($hotel_style && $hotel_style != 'Choose Style here'){
        $args['tax_query']['hotel_style'] = array(
            array(
                'taxonomy' => 'hotel_style',
                'terms' => $hotel_style,
                'field' => 'slug'
            )
        );
    }
    //print_r($args);
    $json_args = json_encode($args);
    $json_args = str_replace('"','/',$json_args);
    $posts = get_posts($args);
    $posts_found = count($posts);
   //print_r($posts);
   // print_r($posts_found);
//    print_r('d'.$offset); exit;
    if(($posts_found>0) && ($posts_found>$offset)){
        array_pop($posts);
        
    }
    if($posts_found <= 3){
        $posts = array_chunk($posts, (count($posts) / 1));
    }else{
        $posts = array_chunk($posts, (count($posts) / 3));
    }
     
    // print_r($posts);
    $content = '<div class="et_pb_blog_grid clearfix et_pb_bg_layout_light">
                    <div class="et_pb_ajax_pagination_container">
                    <div class="et_pb_salvattore_content tour_in_travel_style" data-columns="3">';
    foreach($posts as $columns){
        $content .= '
                    <div class="column size-1of3">';
        foreach ($columns as $post){
            $content  .= get_post_hotel_html($post,$module_id);
        }
        $content  .= '</div>';
    }
    $content .= '</div></div></div>';
    if(($posts_found>0) && ($posts_found>$offset)){
        $content .= '<div class="show_more_posts"><input type="submit" class="make-enquire" name="btn_show_more_posts" id="btn_show_more_posts" value="'.__("Show More","mundo").'" data-step="2" data-args="'.$json_args.'" data-offset="'.$offset.'"/></div> ';
    }
    // dua att cuar arg vaof btn opset = 9 bor nhung thang dau ra roi tang ofset di
   // $content .= '</div>';
   // print_r($content);
    echo json_encode(array(
        'error' => 0,
        'mess' => '',
        'html' => $content,
    ));
    exit(); 
}
// // order by tour in travel style
// add_filter('posts_join', function($join, &$query){
//    global $wpdb;
//    $query_vars = $query->query_vars;
//    if( !empty($query_vars['order_price']) && $query_vars['post_type'] == 'tour'  ) {
//        d($query); 
//        print_r($query);exit();
//        $join .= "LEFT JOIN {$wpdb->prefix}postmeta mt_price 
//                        ON {$wpdb->prefix}posts.ID = mt_price.post_id 
//                        AND mt_price.meta_key = 'price_from'";
//    }
//    if( !empty($query_vars['order_most_popular']) && $query_vars['post_type'] == 'tour') {
//        d($query);
//        $join .= " LEFT JOIN {$wpdb->prefix}postmeta mt_most_popular 
//                        ON {$wpdb->prefix}posts.ID = mt_most_popular.post_id 
//                        AND mt_most_popular.meta_key = 'view'";
//    }
//    //d($query);
//    return $join;
// },12,2);

// add_filter('posts_orderby', function($order_by, &$query){
//    global $wpdb;
//    $query_vars = $query->query_vars;
//    if( !empty($query_vars['order_price']) && $query_vars['post_type'] == 'tour' ) {
//        $order_by = "mt_price.meta_value DESC, ". $order_by;// {$wpdb->prefix}posts.post_date DESC";
//         d($query->request);
//    }
//    if( !empty($query_vars['order_most_popular']) && $query_vars['post_type'] == 'tour' ) {
//        //trong truong hop la sap xep theo date thi thay doi dieu kien sap xep la tang hay giam tu $query_vars['odr']
//        if ($query_vars['order_most_popular'] == 'date'){
//            $order_by = $order_by = "mt_price.meta_value DESC, ". $order_by;
//        }
//        if ($query_vars['odrby'] == 'download'){
//            $order_by = str_replace("mt_pin.meta_value DESC,", "",$order_by);
//            $order_by = "mt_pin.meta_value DESC, mt_dl.meta_value {$query_vars['odr']}, ". $order_by;
//        }
//        // {$wpdb->prefix}posts.post_date DESC";
//         d($query->request);
//    }
//   // d($query);
//    return $order_by;
// },9,2);
//form search tour in travel style page
add_action('wp_ajax_nopriv_search_tour_in_travel_style', 'mundo_search_tour_in_travel_style');
add_action('wp_ajax_search_tour_in_travel_style', 'mundo_search_tour_in_travel_style');
function mundo_search_tour_in_travel_style(){
    $title= $_POST['title'];
    $destination = $_POST['destination'];
    $travel_style = $_POST['travel_style'];
    $date_tour = $_POST['date_tour'];
    $offset = ($_POST['offset']);   
    $module_id = ($_POST['module_id']);  
    $order_price =  $_POST['order_price']; 
    $order_most_popular =  $_POST['order_most_popular'];
    $args = array( 
        'post_type' => 'tour',
        'posts_per_page' => 10,
    );
    $travel_style_cat =  $_POST['travel_style_cat'];
    if($travel_style_cat=='all'){
        $args['meta_query']['seat_in_coach'] = array(
                'key'     => 'select_type',
                'value'   => 'seat_in_coach',
                'compare' => 'LIKE',
            );
        
    }else{
        if (in_array($travel_style_cat, $terms_destination_slug)) {
            $args['meta_query']['seat_in_coach'] = array(
                'key'     => 'select_type',
                'value'   => 'seat_in_coach',
                'compare' => '=',
            );
            $args['tax_query']['destination'] = array(
                array(
                    'taxonomy' => 'category-destination',
                    'terms' => $travel_style_cat,
                    'field' => 'slug'
                )
            ); 
        }elseif($travel_style_cat){
            $args['tax_query']['travel_style'] = array(
                array(
                    'taxonomy' => 'travel_style',
                    'terms' => $travel_style_cat,
                    'field' => 'slug'
                )
            ); 

        }   
    }
    //print_r($destination);
    // print_r($order_price);exit();
    
    // if($order_most_popular){
    //      // $args['order_most_popular'] = $order_most_popular;
    //     $args['meta_query'] = array(
    //                                 'order_with_view' => array(
    //                                     'key' => 'view',
    //                                     'compare' => 'meta_value_num',
    //                                     'type'    => 'numeric',
    //                             ));
    //     $args['orderby'] = array( 
    //                         'order_with_view' => $order_most_popular,
    //                     );
        $args['meta_query']['position']['relation'] = 'OR';
        $args['meta_query']['position']['position_display'] = array(
                'key' => 'position_display',
                'compare' => 'meta_value_num',
                'type'  => 'numeric',
            );
        $args['meta_query']['position']['position_display_ex'] = array(
            'key' => 'position_display',  
            'compare' => 'NOT EXISTS'
        );
        $args['orderby'] = array(
                'position_display' => 'ASC',
                'date' => 'DESC',
            );
        if($order_price){  
        // $args['order_price'] = $order_price;
        $args['meta_query']['relation'] = 'AND';
        $args['meta_query']['order_with_price'] =  array(
                                        'key' => 'price_from',
                                        'compare' => 'meta_value_num',
                                        'type'    => 'numeric',);
        $args['orderby'] = array( 
                                'order_with_price' => $order_price,
                                'position_display' => 'ASC',
                                'date' => 'DESC',
                            );//echo 'haha'.$order_price;exit();
        }

    //}    
    if($title){
        $args['s'] = $title;
    }
    if($travel_style && $travel_style!='Choose Style Here'){
        $args['tax_query']['travel_style'] = array(
            array(
                'taxonomy' => 'travel_style',
                'terms' => $travel_style,
                'field' => 'slug'
            )
        );
    }
    if($destination && $destination!='Choose Destination Here'){
        // $args['tax_query']['destination'] = array(
        //     array(
        //         'taxonomy' => 'category-destination',
        //         'terms' => $destination,
        //         'field' => 'slug'
        //     )
        // );
        foreach ($destination as $key_des => $value_des) {
    		$query_des[] = array(
                'taxonomy' => 'category-destination',
                'terms' => $value_des,
                'field' => 'slug'
            );
    	}
        $args['tax_query']['destination'] = $query_des;
    }
    //print_r($args);
    //lay ra tat ca cac bai viet
    $args_all_post = $args;
    $args_all_post['posts_per_page'] = -1;
    $all_posts = get_posts($args_all_post);
    $total_posts = count($all_posts);
   // print_r($all_posts);
    $duration = $_POST['duration'];
   
    if($duration && $duration != 'Choose Duration Here'){
        $duration_term = get_terms(array(
            'taxonomy' => 'duration_tour',
            'hide_empty' => false,
            'slug' => $duration,
        ) );
        //print_r($duration_term);
        if(!empty($duration_term)){
            $from = get_term_meta($duration_term[0]->term_id,'duration_from',true);
            $to = get_term_meta($duration_term[0]->term_id,'duration_to',true);
    
            // get post
            $posts = get_posts($args);
            //lay cac post có duration 
            foreach($posts as $post){
                 $itinerarys = (get_post_meta($post->ID, 'itinerary',true))?:array();            
                 $days = ($itinerarys)?count($itinerarys):0;
                 if(($days >= $from) && ($days <= $to)){
                    $args['post__in'][$post->ID]= $post->ID;
                     
                 }
            };
            if(empty($args['post__in'])){
                $args['post__in']= array(0);
            }
        }else{
            $args['post__in']= array(0);
        }
    }
   
    $json_args = json_encode($args);
    $json_args = str_replace('"','/',$json_args);

    $posts_first = get_posts($args);
    foreach ($posts_first as $key_post => $value_post) {
        $quanty_all = 0;
        $quanty_term = 0;
        $quanty_term_other = 0;



        $term_des_parent = wp_get_post_terms($value_post->ID,'category-destination',array('parent'=>0));
        $term_des_id = wp_list_pluck( $term_des_parent, 'term_id');



        $quanty_term = count($term_des_id);
        $term_des = wp_get_post_terms($value_post->ID,'category-destination',array());
        $term_parent_other = array();
        foreach ($term_des as $key_1 => $value_1){
            if ( ( !in_array($value_1->parent, $term_des_id) ) && ( $value_1->parent != 0) ) {//Nếu cha ko thuộc các cha còn lại và cha khác 0
                $term_parent_other[] = $value_1->parent;
            }
        }

        $term_parent_other = array_unique($term_parent_other);




        $quanty_term_other = count($term_parent_other);

        $quanty_all = $quanty_term + $quanty_term_other;

        $value_post->quanty_term = $quanty_all;
        $posts[] = $value_post;
    }
    // print_r($posts);exit();
    if (!$order_price) {
        usort($posts, function($a, $b)
        {
            return strcmp($a->quanty_term, $b->quanty_term);
        });
    }
    
    //print_r($posts);echo 'end';
    $posts_found = count($posts);
   // print_r($posts_found);
    if($posts_found == 0){
        echo json_encode(array(
            'error' => 0,
            'mess' => '',
            'html' => '<h1 class="not_found" >'.__("Can't find any tour!").'</h1>',
        ));
        exit(); 
    }
    if(($posts_found>0) && ($posts_found>$offset)){
        array_pop($posts);
    }
    if(count($posts) > 3){
        if (count($posts)<6) {
            $posts = array_chunk($posts, 3);    
        }else{
            $posts = array_chunk($posts, (count($posts) / 3));    
        }
    }else{
        $posts = array_chunk($posts, (count($posts) / 1));
    }
    //$content = '<div class="et_pb_blog_grid clearfix et_pb_bg_layout_light">';
    $content .= '<div class="et_pb_ajax_pagination_container">
                    <div class="et_pb_salvattore_content tour_in_travel_style" data-columns="1">';
    foreach($posts as $columns){
        //$content .= '<div class="column size-1of3">';
        $i = 1;
        foreach ($columns as $post){
            $full = 'on';
            $content  .= get_post_tour_html($post,$module_id,$i,$full);
            $i++;
        }
        //$content  .= '</div>';
    }
    $content .= '</div></div>';
    //$content .='</div>';
    if(($posts_found>0) && ($posts_found>$offset)){
        $content .= '<div class="show_more_posts"><input type="submit" class="make-enquire" name="btn_show_more_posts" id="btn_show_more_posts" value="'.__("Show More","mundo").'" data-step="2" data-args="'.$json_args.'"</div> ';
    }
    //print_r($content);
    echo json_encode(array(
        'error' => 0,
        'mess' => '',
        'html' => $content,
        'total_posts' => $total_posts,
    ));
    exit(); 
};

function mundo_get_sic_price($post_id, $date){
    //1. lay post co gia
    $sic_rate_posts = get_posts(array(
        'post_type' => 'sic_tour_rate',
        'posts_per_page' => -1,
        'post_status' =>'publish',
        'meta_query' => array(
            array(
                'key' => 'tour_name',
                'value' => $post_id,
            )
        ),
    ));
   // print_r($sic_rate_posts);
    if($sic_rate_posts){
        $rates = get_post_meta($sic_rate_posts[0]->ID,'group_sic_rate',true);
        foreach($rates as $rate){
            $from_date = $rate['from_date']['timestamp'];
            $to_date = $rate['to_date']['timestamp'];
            if(($date >= $from_date) && ($date <= $to_date)){
                $rate_per_person = $rate['tour_rate'];
            }
        }
    }
   // print_r($rate_per_person); exit;
    if (isset($_COOKIE['exchange_rate'])){
        $exchange_rate_string = $_COOKIE['exchange_rate'];
        $exchange_rate_cookie = explode("-",$exchange_rate_string); 
        $rate_per_person = $rate_per_person * $exchange_rate_cookie[2];
    }
    return ceil($rate_per_person);
}
// tinh gia tour customize per person
add_action('wp_ajax_nopriv_get_row_sic_rate', 'mundo_get_row_sic_rate');
add_action('wp_ajax_get_row_sic_rate', 'mundo_get_row_sic_rate');
function mundo_get_row_sic_rate(){
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $departings = $_POST['departings_affter'];
    $post_id = $_POST['post_id'];
    
    $departings = str_replace('/','"',$departings);
    $departings = json_decode($departings,true);
    $departings_before = array_slice($departings,0, 5);
    
    $departings_affter = array_slice($departings, 5);
    $url = home_url('booking-customize-tour');
    $current_lang = pll_current_language();
    switch ($current_lang) {
        case 'en':
            $url = get_permalink(get_page_by_path('booking-sic-tour'));
            setlocale(LC_TIME, 'us_US');
            break;
        case 'es':
            $url = get_permalink(get_page_by_path('reserva-de-salidas-garantizadas'));
            setlocale(LC_TIME, 'es_ES');
            break;
        case 'pt':
            $url = get_permalink(get_page_by_path('reserva-saidas-regulares'));
            setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
            break;
        default:
            $url = get_permalink(get_page_by_path('booking-sic-tour'));
            break;
    }
    $dem =$_POST['dem'];
    $form = '';
     foreach($departings_before as $departing){
                    $row_light = (($dem % 2) == 0)?'row_light':'row_black';
                    $dem++;
                    // 
                    $date_from = date('d M Y', $departing['date']['timestamp']);
                    $date_from_text = utf8_encode( strftime('%d  %B %Y', $departing['date']['timestamp'] ) );
                    $days = 0; 
                    $itinerary = (get_post_meta($post_id, 'itinerary',true))?:array();            
                    if($itinerary){
                        $days = count($itinerary);
                        if($days>0){
                           $finishing = strtotime('+'.$days.' days', $departing['date']['timestamp']);
                           $finishing = date('d M Y', $finishing);
                           $finishing_text = utf8_encode( strftime('%d  %B %Y', strtotime('+'.$days.' days', $departing['date']['timestamp']) ) );
                        }
                    }
                    
                    //lay so luong nguoi
                    $adult = (get_post_meta($post_id,'number_of_tourists',true))?:0;
                    $adult_select = '<select class="adult_sic_select" name="adult" readonly >';
                    for( $i=1; $i <= $adult; $i++){
                       // $selected = ($i==2)?'selected':'';
                        $adult_select .= '<option value="'.$i.'">'.$i.'</option>' ;
                    };
                    $adult_select .= '</select>';
                    // css cho btn
                    
                    $btn_hide = ($departing["status"][0]== 'full')?'hide_btn':'';
                    $available_text = ($departing["status"][0]== 'full')?__('Fully Booked','mundo'):__('Available','mundo');
                    $available_class = ($departing["status"][0]== 'full')?__('fully','mundo'):__('available','mundo');
                    
                    //lay gia tour
                    $total = mundo_get_sic_price($post_id, $departing['date']['timestamp']);
                    if(($departing["status"][0]== 'full')){
                        $adult_select = '';
                        $total = '';
                    }

                   //print_r($btn_hide); exit;
                    $form .=  '<form method="GET" action="'.$url.'" name="frm_sic_tour" id="form_sic_tour" data-post="'.$post_id.'">    
                                        <input type="hidden" name="post_id" value='.$post_id.'>
                                        <input type="hidden" name="date_from" value='.$departing['date']['timestamp'].'>
                                        <div class="row  value '.$row_light.'" >
                                            <div class="col-md-3 col-sm-3 col-xs-4 sic-head-mobile show_on_mobile"> '.__('Departing','Mundo').'</div>
                                            <div class="col-md-3 col-sm-3 col-xs-4 sic-head-mobile show_on_mobile"> '.__('Finishing','Mundo').'</div>
                                            <div class="col-md-2 col-sm-2 col-xs-4 show_on_mobile sic-head-mobile"> '.__('Total from  USD','Mundo').'</div>

                                            <div class="col-md-3 col-sm-3 col-xs-4 sic-body-mobile departing '.$dem.' " id="departing" data-date="'.$departing['date']['timestamp'].'">'.$date_from_text.'</div>
                                            <div class="col-md-3 col-sm-3 col-xs-4 sic-body-mobile show_on_mobile" id="finishing">'.$finishing_text.'</div>
                                            <div class="col-md-2 col-sm-2 total col-xs-4 sic-body-mobile show_on_mobile '.$dem.'" id="total"> $'.$total.'</div>

                                            

                                            <div class="col-md-3 col-sm-3 show_on_desktop" id="finishing">'.$finishing_text.'</div>
                                            <div class="col-md-2 col-sm-2 show_on_desktop '.$available_class.'">'.$available_text.' </div>';
                        //$form .=            '<div class="col-md-2 col-sm-2" id="adult" data-row="'.$dem.'"> '.$adult_select.'</div>';
                        $form .=        '<div class="col-md-2 col-sm-2  total show_on_desktop '.$dem.'" id="total"> $'.$total.'</div>
                                            <div class="col-md-2 col-sm-2 show_on_desktop btn_submit '.$dem.'" id="submit"><input type="submit" value="'.__("BOOK NOW",'Mundo').'" name="book" class="make-enquire '.$btn_hide.'"/></div>
                                            <hr class="show_on_mobile">
                                            
                                            <div class="col-md-2 col-sm-2 col-xs-4 show_on_mobile '.$available_class.'">'.$available_text.' </div>
                                            <div class="col-md-2 col-sm-2 show_on_mobile submit_sic_mobile col-xs-2 btn_submit '.$dem.'" id="submit"><input type="submit" value="'.__("BOOK NOW",'Mundo').'" name="book" class="make-enquire '.$btn_hide.'"/></div>
                                        </div>    
                            </form>';
                }
                
                if(!empty($departings_affter)){
                     $departings_affter = json_encode($departings_affter);
                     $departings_affter = str_replace('"','/',$departings_affter);
                     $form .='<div id="data" data-departings_affter="'.$departings_affter.'" data-post="'.$post_id.'">  <div id="sic_tour_rate" class="text_center">'.__("Show More","mundo").'</div></div></div>';
           
                }

    //  echo json_encode(array(
    //     'error' => 0,
    //     'mess' => '',
    //     'html' => $form,
    // ));
   echo $form;
    exit();
    
}

// tinh gia tour customize per person
add_action('wp_ajax_nopriv_get_sic_price', 'mundo_get_sic_price_ajax');
add_action('wp_ajax_get_sic_price', 'mundo_get_sic_price_ajax');
function mundo_get_sic_price_ajax(){
    $adult  = $_POST['adult'];
    $date = $_POST['date'];
    $post_id = $_POST['post_id'];
    $price_per_person = mundo_get_sic_price($post_id, $date);
    
     echo json_encode(array(
        'error' => 0,
        'mess' => '',
        'total' => '$'.$price_per_person*$adult,
    ));
    exit();
    
}
// tinh gia tour customize per person form contact
add_action('wp_ajax_nopriv_get_sic_price_contact', 'mundo_get_sic_price_ajax_contact');
add_action('wp_ajax_get_sic_price_contact', 'mundo_get_sic_price_ajax_contact');
function mundo_get_sic_price_ajax_contact(){
    $adult  = $_POST['adult'];
    $date = $_POST['date'];
    $post_id = $_POST['post_id'];
    $price_per_person = mundo_get_sic_price($post_id, $date);
    
     echo json_encode(array(
        'error' => 0,
        'mess' => '',
        'total' => '$'.$price_per_person*$adult,
    ));
    exit();
    
}
// tinh gia tour customize per person
add_action('wp_ajax_nopriv_get_customize_price', 'mundo_get_customize_price');
add_action('wp_ajax_get_customize_price', 'mundo_get_customize_price');
function mundo_get_customize_price(){
    $date  = $_POST['month'];
    $adult  = $_POST['adult'];
    $language = $_POST['language'];
    $flight = $_POST['flight'];
    $post_id = $_POST['post_id'];
    $symbol_exchange = '$';
    if (isset($_COOKIE['exchange_rate'])){
        $exchange_rate_string = $_COOKIE['exchange_rate'];
        $exchange_rate_cookie = explode("-",$exchange_rate_string); 
        $exchange_detail = $exchange_rate_cookie[2];
        $symbol_exchange = $exchange_rate_cookie[1];
    }
    $price_per_person = mundo_calculate_customize_price_per_person($post_id, $date, $adult, $language, $flight);
    // if($price_per_person == 0){
    //     echo json_encode(array(
    //         'error' => 1,
    //         'mess' => 'Date is not available!',
    //     ));
    //     exit();
    // }
    $total_price = $price_per_person*$adult;

    $total_price = $total_price ?$total_price:__('On Request','Mundo');

    $price_per_person = $price_per_person ? $price_per_person : __('On Request','Mundo');
   echo json_encode(array(
        'error' => 0,
        'mess' => '',
        'price_per_person' => '$'.get_price_usd($price_per_person).'('.$symbol_exchange.$price_per_person.')',
        'total' => '$'.get_price_usd($total_price).'('.$symbol_exchange.$total_price.')',
    ));
    exit();
}
function mundo_calculate_customize_price_per_person($post_id, $date, $adult, $language, $flight){
    $prices = array();
    //1. lay post co gia
    $custom_rate_posts = get_posts(array(
        'post_type' => 'customize_rate',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => 'tour_name_customize',
                'value' => $post_id,
            )
        ),
    ));
    $custom_rates = get_post_meta($custom_rate_posts[0]->ID,'group_tour_rate',true);
   // print_r($custom_rates);
    foreach ($custom_rates as $custom_rate){
        $from_date = $custom_rate['from_date']['timestamp'];
        $to_date =  $custom_rate['to_date']['timestamp'];
        if($to_date <  time()){
            continue;
        }
       // $from_date = ($from_date< time())?time():$from_date;
       //$obj_date = date_create_from_format('d/m/Y', $check_in_date);
       //print_r($from_date);
      // print_r($to_date);
        for ($i = $from_date; $i < $to_date; $i = strtotime('+1 days', $i)){
            //print_r(date('d/m/Y', $i));
            //print_r($date); 
             if(date('d/m/Y', $i) != $date){
                continue;
             }else{
                $prices['single_supplement'] = $custom_rate['single_supplement'];
                $prices['english_guide'] = $custom_rate['english_guide'];
                $prices['spanish_guide'] = $custom_rate['spanish_guide'];
                $prices['portugese_guide'] = $custom_rate['portugese_guide'];
                foreach ($custom_rate['group_rate'] as $rate){
                    if(!$rate['from'] && !$rate['to']){
                        continue;
                    }
                    if(!$rate['from']){
                        $prices['price_per_person'] = ($rate['to']==2)?$rate['price']:0;
                    }
                    if(!$rate['to']){
                        $prices['price_per_person'] = ($rate['from']==2)?$rate['price']:0;
                    }
                    if(($rate['from'] <= $adult)&($rate['to']>= $adult)){
                         $prices['price_per_person'] = $rate['price'];
                    }
                }
            }
        } 
    }
    // lay gia single_supplement theo so nguoi
    if(($adult%2)== 0){
        $prices['single_supplement'] = 0;
    }
    //Nếu có 1 người thì single_suplement không tính
    if($adult==1){
        $prices['single_supplement'] = 0;

    }
    // lay gia guide
    switch($language){
        //71 tieng anh ; 70: Spanish; 73: no guide 72: Portuguese
        case '71':
            $prices['language'] = 0;
            $prices['language'] = 0-$prices['english_guide'];
            break;
        case '70':
            $prices['language'] = $prices['spanish_guide'];
            break;
        case '72':
            $prices['language'] =  $prices['portugese_guide'] ;
            break;
        case '73':
            $prices['language'] = 0;
            break;
        
    }
    //lay gia flight
        if($flight == 'no' || $prices['price_per_person']==0){
            $prices['flight'] = 0;
        }else{
            $flights = wp_get_post_terms($post_id, 'flight',array());

            foreach($flights as $flight){
                $group_price_flight = get_term_meta($flight->term_id, 'group_price_flight',true);
                foreach($group_price_flight as $price_flight){
                    $fl_from_date = $price_flight['from_date']['timestamp'];
                    $fl_to_date =  $price_flight['to_date']['timestamp'];
                    if($fl_to_date <  time()){
                        continue;
                    }
                    for ($i = $fl_from_date; $i < $fl_to_date; $i = strtotime('+1 days', $i)){
                         if(date('d/m/Y', $i) != $date){
                            continue;
                         }else{
                                $prices['flight'] = $price_flight['price_flight'];
                                $prices['flight_arr'][] = $price_flight['price_flight'];
                        }
                    } 
                }
                
            }
        }
        $gia_ = $prices['price_per_person'] + $prices['single_supplement']/$adult + $prices['language']/$adult + $prices['flight'];
        $price_flight = array_sum($prices['flight_arr']);
    //print_r($flight_ids);
    // tinh gia tren 1 nguoi
        // print_r($prices['price_per_person']);echo 'price_per_person';
        // print_r($prices['single_supplement']);echo 'single_supplement';
        // print_r($prices['language']);echo 'language';
        // print_r($prices['flight']);echo 'flight';
        // print_r($gia_); echo 'gia_';
        // exit();
        $return_price = $prices['price_per_person'] + $prices['single_supplement']/$adult + $prices['language']/$adult + $price_flight;

        if (isset($_COOKIE['exchange_rate'])){
            $exchange_rate_string = $_COOKIE['exchange_rate'];
            $exchange_rate_cookie = explode("-",$exchange_rate_string); 
            $return_price = $return_price * $exchange_rate_cookie[2];
        }
    return  ceil($return_price);
}


add_action('wp_ajax_nopriv_get_another_tour', 'mundo_get_another_tour');
add_action('wp_ajax_get_another_tour', 'mundo_get_another_tour');
function mundo_get_another_tour(){
    $post_id = ($_POST['post_id'])?:0;
    $title = ($_POST['title'])?:'';
    $tour_info = get_post_meta($post_id,'inclussion',true);
    $tab_content = '<div class="et_pb_row "';
    $tab = '';
    foreach($tour_info as $key => $tour){
        if($tour['inclussion_title'] == $title){
            $tab = $key;
        }
        
    }
    foreach ($tour_info[$tab] as $key => $value){
            switch ($key){ 
                case 'inclussion_detail':
                     $tab_content .= $value?'<div class="tab_content"><div class="content-inclussion-detail">'.str_replace("<!--more-->","</div><div class='content-inclussion-detail'>",$value).'</div></div>':' ';
                    break;
                    
                case 'other_info':
                    $other_info = (get_the_excerpt($value))?:'';
                    $tab_content .= '<div class"tab_content">'.$other_info.'</div>';
                    break;
                case 'restaurants_in_tour':
                case 'hotels_in_tour':
                    $content = '<div class="tab_content tab_hotels_in_tour">';
                    foreach($value as $post_id){
                        $thumbnail_id = get_post_thumbnail_id($post_id);
                        $src = mundo_get_attachment_image_src($thumbnail_id, 'tour_another')?:'';                   
                        $title = (get_the_title($post_id))?:'';                            
                        $excerpt= (get_the_excerpt($post_id))?:'';
                        $location = get_post_meta($post_id,'location',true);
                        $terms_des = wp_get_post_terms( $post_id, 'category-destination', array() );
                        $location = $terms_des[0]->name;
                        $hotel_styles = wp_get_post_terms( $post_id, 'hotel_style', array() );
                        $content .= '<div class="row hotels_in_tour">';
                        $content .= '<div class="col-md-4 col-sm-4">';
                        $content .= '<a href="'.get_the_permalink($post_id).'">';
                        $content .= ' <div class="et_pb_slide_image2"><img src="'.$src.'" alt=""></div>   ';  
                        $content .= '</a>'   ;  
                        $content .= '</div>';
                        $content .= '<div class="col-md-8 col-sm-8">';
                            $content .= '<a href="'.get_the_permalink($post_id).'">';
                            $content .= '<b>'.$title.'</b><br>';
                            $content .= ' <span class="location">'.$location.'</span>   ';
                            $content .= ' <span class="style">'.$hotel_styles[0]->name.'</span>   ';
                            $content .= '<p>'.$excerpt.'</p>';
                        $content .= '</a></div>';
                        $content .= '</div>';
                    }
                    $tab_content .= $content.'</div>';
                    
                    break;
                default:
                    break;
                
            }
        }
        $tab_content .= '</div>';
        echo json_encode(array(
            'error' => 0,
            'mess' => '',
            'html' => $tab_content,
        ));
        exit();
}

// add_action('wp_ajax_nopriv_get_infomation_tour_pdf', 'mundo_get_infomation_tour_pdf');
// add_action('wp_ajax_get_infomation_tour_pdf', 'mundo_get_infomation_tour_pdf');
function mundo_get_infomation_tour_pdf($post_id){
    $tour_info = get_post_meta($post_id,'inclussion',true);
    $tab_content = ' ';
        foreach ($tour_info as $key_info => $value_info) {
        $tab_content .= '<div class="et_pb_row tab_title_tour_info tab_header pdf_tour">';
        $tab_content .= '<span class="other_tour_tab_name active" >'.$tour_info[$key_info]['inclussion_title'].'</span>';
        $tab_content .= '</div>';
        
        //tab content
        $tab_content .= '<div class="et_pb_row tab_content_tour_info pdf_tour">';
        foreach ($tour_info[$key_info] as $key => $value){
            switch ($key){
                case 'inclussion_detail':
                    $tab_content .= $value?'<div class="tab_content"><div class="content-inclussion-detail">'.str_replace("<!--more-->","</div><div class='content-inclussion-detail'>",$value).'</div></div>':' ';
                    break;
                    
                case 'other_info':
                    $other_info = (get_the_excerpt($value))?:'';
                    $tab_content .= '<div class"tab_content">'.$other_info.'</div>';
                    // $tab_content .= $value?'<div class="tab_content"><div class="content-inclussion-detail">'.str_replace("<!--more-->","</div><div class='content-inclussion-detail'>",$other_info).'</div></div>':' ';
                    break;
                case 'restaurants_in_tour':
                case 'hotels_in_tour':
                    $content = '<div class="tab_content tab_hotels_in_tour">';
                    foreach($value as $post_id){
                        $thumbnail_id = get_post_thumbnail_id($post_id);
                        $src = mundo_get_attachment_image_src($thumbnail_id, 'tour_another')?:'';                   
                        $title = (get_the_title($post_id))?:'';                            
                        $excerpt= (get_the_excerpt($post_id))?:'';
                        $terms_des = wp_get_post_terms( $post_id, 'category-destination', array() );
                        if ($terms_des) {
                            foreach ($terms_des as $key => $value) {
                                $location = $value->name;
                            }
                        }
                        $hotel_styles = wp_get_post_terms( $post_id, 'hotel_style', array() );
                        $content .= '<div class="row hotels_in_tour">';
                        $content .= '<div class="col-md-4 col-sm-4">';
                        $content .= '<a href="'.get_the_permalink($post_id).'">';
                        $content .= ' <div class="et_pb_slide_image2"><img src="'.$src.'" alt=""></div>   ';  
                        $content .= '</a>'   ;  
                        $content .= '</div>';
                        $content .= '<div class="col-md-8 col-sm-8">';
                            $content .= '<a href="'.get_the_permalink($post_id).'">';
                            $content .= '<b>'.$title.'</b><br>';
                            $content .= ' <span class="location">'.$location.'a</span>   ';
                            $content .= ' <span class="style">'.$hotel_styles[0]->name.'b</span>   ';
                            $content .= '<p class="excerpt-content">'.$excerpt.'</p>';
                        $content .= '</a></div>';
                        $content .= '</div>';
                    }
                    $tab_content .= $content.'</div>';
                    
                    break;
                default:
                    break;
                
            }
        }
        $tab_content .= '</div>';
    }
    return $tab_content;
    // echo json_encode(array(
    //     'error' => 0,
    //     'mess' => '',
    //     'html' => $tab_content,
    // ));
    // exit();
}
// lay cac tour trong travel style
 function get_excursion_reviews_html($post, $module_id = '',$i, $fullwidth){
    $title = get_post_meta($post->ID, 'title',true);
    $content = get_post_meta($post->ID, 'content',true);
    $guest_name = get_post_meta($post->ID,'guest_name',true);
    $country = wp_get_post_terms( $post->ID, 'country', array() );
    $country_name = $country[0]->name;
    $post_content = '';
    $post_content .= '<article><div class="title-review">'.$title.'</div>';
    $post_content .= '<div class="content-review">'.$content.'</div>';
    $post_content .= '<div class="guest_name_review">'.$guest_name.'</div>';
    $post_content .= '<div class="country_name_review">'.$country_name.'</div></article>';
    return $post_content;
 }
add_action('wp_ajax_nopriv_get_post_show_more', 'mundo_get_post_show_more');
add_action('wp_ajax_get_post_show_more', 'mundo_get_post_show_more');

function mundo_get_post_show_more(){
    $args = ($_POST['args'])?:'';
    $args = str_replace('/','"',$args);
    $args = json_decode($args, true);
    $offset = ($_POST['offset'])?:0;
    $module_id = ($_POST['module_id'])?:'';
    $arg_offset = ($args['offset'])?:0;
    $post_number = ($_POST['post_number'])?:0;
    $step = ($_POST['step'])?:0;
    $args['offset']= ($step == 2)?$arg_offset+$offset:$post_number;
    $args['posts_per_page'] = intval($offset)+1;
    $json_args = json_encode($args);
    $json_args = str_replace('"','/',$json_args);
    $posts = get_posts($args);     
    $posts_found = count($posts);
    $data_fullwidth = ($_POST['data_fullwidth'])?:off;
    // print_r($posts);
    // exit();
    if ($data_fullwidth == 'off') {
        // foreach ($posts as $key => $post) {
        //    $content .= get_post_travel_html($post, $module_id);
        // }
        
        if(($posts_found>0) && ($posts_found>$offset)){
            array_pop($posts);
        }
        $posts = array_chunk($posts, ceil(count($posts) / 3)); 
        $content = '<div class="et_pb_blog_grid clearfix et_pb_bg_layout_light">
                        <div class="et_pb_ajax_pagination_container">
                        <div class="et_pb_salvattore_content tour_in_travel_style" data-columns="3">';
        foreach($posts as $columns){
            $content .= '<div class="column size-1of3">';
            $i=1;
            foreach ($columns as $post){
                //$content  .= get_post_travel_html($post,$module_id);
                if ($module_id=='city_of_vietnam_list_hotel') {
                     $content  .= get_post_hotel_html($post, $module_id,$i, $data_fullwidth);$i++;
                }
                elseif($module_id=='excursions_list_page'){
                	$content  .= get_post_excursion_html($post, $module_id,$i, $data_fullwidth);$i++;
                }
                elseif($module_id=='excursion_reviews'){
                    $content  .= get_excursion_reviews_html($post, $module_id,$i, $data_fullwidth);$i++;
                }
                else{
                    $content  .= get_post_tour_html($post, $module_id,$i, $data_fullwidth);$i++;
                }
                
            }
            $content  .= '</div>';
        }
        $content .= '</div></div></div>';
        if(($posts_found>0) && ($posts_found>=$offset)){
            $content .= '<div class="show_more_posts"><input type="submit" class="make-enquire" name="btn_show_more_posts" id="btn_show_more_posts" value="'.__("Show More","mundo").'" data-step="2" data-args="'.$json_args.'"/></div> ';
        }
    }else{

        // foreach ($posts as $key => $post) {
        //    $content .= get_post_travel_html($post, $module_id);
        // }
        if(($posts_found>0) && ($posts_found>$offset)){
            array_pop($posts);
        }
        $content = '<div class="et_pb_ajax_pagination_container">';
        $i=1;
        foreach($posts as $post){
            //$content  .= get_post_travel_html($post,$module_id);
            if ($module_id=='city_of_vietnam_list_hotel') {
                     $content  .= get_post_hotel_html($post, $module_id,$i, $data_fullwidth);$i++;
                }
                elseif($module_id=='excursions_list_page'){
                	$content  .= get_post_excursion_html($post, $module_id,$i, $data_fullwidth);$i++;
                }
                elseif($module_id=='excursion_reviews'){
                    $content  .= get_excursion_reviews_html($post, $module_id,$i, $data_fullwidth);$i++;
                }
                else{
                    $content  .= get_post_tour_html($post, $module_id,$i, $data_fullwidth);$i++;
                }
        }
        $content .= '</div>';
        if(($posts_found>0) && ($posts_found>$offset)){
            $content .= '<div class="show_more_posts"><input type="submit" class="make-enquire" name="btn_show_more_posts" id="btn_show_more_posts" value="'.__("Show More","mundo").'" data-step="2" data-args="'.$json_args.'"/><span class="travel-guide-show-more"></span></div> ';
        }
    }
    
    
    // dua att cuar arg vaof btn opset = 9 bor nhung thang dau ra roi tang ofset di
   // $content .= '</div>';
   // print_r($content);
    echo json_encode(array(
        'error' => 0,
        'mess' => '',
        'html' => $content,
    ));
    exit(); 
}
add_action('wp_ajax_nopriv_get_post_show_more_blog', 'mundo_get_post_show_more_blog');
add_action('wp_ajax_get_post_show_more_blog', 'mundo_get_post_show_more_blog');

function mundo_get_post_show_more_blog(){
    $args = ($_POST['args'])?:'';
    $args = str_replace('/','"',$args);
    $args = json_decode($args, true);
    $offset = ($_POST['offset'])?:0;
    $module_id = ($_POST['module_id'])?:'';
    $arg_offset = ($args['offset'])?:0;
    $post_number = ($_POST['post_number'])?:0;
    $step = ($_POST['step'])?:0;
    $args['offset']= ($step == 2)? $arg_offset+$offset+1 :$post_number;
    $args['posts_per_page'] = intval($offset)+1;
    $json_args = json_encode($args);
    $json_args = str_replace('"','/',$json_args);
    $posts = get_posts($args);     
    $posts_found = count($posts);
    $data_fullwidth = ($_POST['data_fullwidth'])?:off;
    if ($data_fullwidth == 'off') {
        foreach ($posts as $key => $post) {
           $content .= get_post_travel_html($post, $module_id);
        }
        if(($posts_found>0) && ($posts_found>$offset)){
            $content .= '<div class="show_more_posts"><input type="submit" class="make-enquire" name="btn_show_more_posts" id="btn_show_more_posts_blog" value="'.__("Show More","mundo").'" data-step="2" data-args="'.$json_args.'"/></div> ';
        }
    }else{
        foreach ($posts as $key => $post) {
           $content .= get_post_travel_html($post, $module_id);
        }
        if(($posts_found>0) && ($posts_found>$offset)){
            $content .= '<div class="show_more_posts"><input type="submit" class="make-enquire" name="btn_show_more_posts" id="btn_show_more_posts_blog" value="'.__("Show More","mundo").'" data-step="2" data-args="'.$json_args.'"/><span class="travel-guide-show-more"></span></div> ';
        }
    }
    echo json_encode(array(
        'error' => 0,
        'mess' => '',
        'html' => $content,
    ));
    exit(); 
}

add_action('wp_ajax_nopriv_get_items', 'mundo_get_items');
add_action('wp_ajax_get_items', 'mundo_get_items');

function mundo_get_items(){
    $taxonomy = ($_POST['taxonomy'])?:'';
    $term = ($_POST['term'])?:'';
    $post_type = ($_POST['post_type'])?:'';
    $posts_per_page = ($_POST['posts_per_page'])?:3;
    $show_home = ($_POST['show_home'])?:false;
    $module_id = ($_POST['module_id'])?:false;
    $destination_id = ($_POST['destination_id'])?:false;
    //print_r($_POST['module_id']);exit;
    if ($term=='all') {
        $posts_per_page = 18;
    }
    $query_args =array(
        'posts_per_page'   => $posts_per_page,
        'post_type'        => $post_type,
        'post_status'      => 'publish',
    );
    if($term != 'all'){
        $query_args['tax_query'] = array(
                array(
                     'taxonomy' => $taxonomy,
                     'field' => 'slug',
                     'terms' => $term,
                )
               
        );

    }

    set_query_var( 'taxonomy_name', $taxonomy );
    set_query_var( 'term_name', $term );
    // if($show_home=== 'true'){
    //     $query_args['meta_query'] = array(
    //         'relation' => 'OR',
    //         array(
    //             'key' => 'show_home',
    //             'value' => 1,
    //             'compare' => '=',
    //         ),
    //      );
    // }
    if ($module_id=='departure_month') {
        $query_args['meta_query'] = array(array(
                    'key' => 'select_type',
                    'value' => 'seat_in_coach',
                    'compare' => '=',
                ),);
    }
    //if($_POST['module_id']== 'post_tour_slider_js' && $destination_id){
        $terms = wp_get_post_terms( $destination_id, 'category-destination', array() );
        $slug = $terms[0]->slug;
        if ($slug) {
                $query_args['meta_query']['sort_tour_by_cat'] = array(
                        'key' => 'sort_tour_by_cat',
                        'compare' => 'meta_value_num',
                        'type'  => 'numeric',
                    );
                //$query_args['meta_query']['relation'] = 'OR';
                $query_args['meta_query']['position_display'] = array(
                        'key' => 'position_display',
                        'compare' => 'meta_value_num',
                        'type'  => 'numeric',
                    );
                // $query_args['meta_query']['position_display_ex'] = array(
                //     'key' => 'position_display',  
                //     'compare' => 'NOT EXISTS'
                // );
                $query_args['orderby'] = array(
                        'sort_tour_by_cat' => 'ASC',
                        'position_display' => 'ASC',
                        'date' => 'DESC',
                    );

                $query_args['tax_query']['city'] = array(
                    'taxonomy' => 'category-destination',
                    'field'    => 'slug',
                    'terms'    => $slug,
                );

            }
            else{

                // $query_args['meta_key']  = 'position_display';
                // $query_args['order']   = 'ASC';
                // $query_args['orderby']   = 'meta_value_num';
                // $query_args['type']    = 'numeric';

                // $query_args['meta_query']['relation'] = 'OR';
                // $query_args['meta_query']['show_home'] = array(
                //         'key' => 'show_home',
                //         'value' => 1,
                //         'compare' => '=',
                // );

                // $query_args['meta_query']['position_display_ex'] = array(
                //         'key' => 'position_display',  
                //         'compare' => 'NOT EXISTS'
                // );

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
            if ($module_id=='travel_guide_tour'){
                $post_id = $_POST['post_id'];
                $term_des_parent = wp_get_post_terms($post_id,'category-destination',array('parent'=>0));
                $query_args['tax_query']['destination'] = array(
                    array(
                        'taxonomy' => 'category-destination',
                        'terms' => $term_des_parent[0]->slug,
                        'field' => 'slug'
                    )
                );
            }
    //}

   // print_r($query_args);exit();
    $query_args = apply_filters('et_pb_post_slider_with_js_query_args',$query_args,$module_id,$term);
    $posts = get_posts($query_args);    
    $html = '<div class="experience"> <div class="owl-carousel owl-loaded owl-drag owl-theme">';
    if(!empty($posts)){
        if($_POST['module_id']== 'post_tour_slider_js'){
            $posts = array_chunk($posts,3);
            $posts = array_chunk($posts,2);
            foreach ($posts as $owl_items){
                $html .=  '<div  class="item">';
                    foreach($owl_items as $rows){
                        $html .= '<div  class="row">';
                            foreach($rows as $post) {
                                $html .= get_post_tour_hightlight_html($post, $module_id);
                            }
                        $html .= '</div>';
                    }
            $html .= '</div>';
            }                                       
       }

       if($_POST['module_id']== 'departure_month'){
           if (!empty($posts)) {      
                foreach($posts as $post) {
                    $html .= get_post_tour_html($post,'','','');
                }
            }
       }
       
       if($_POST['module_id']== 'post_tour_slider_js_mobile'){
           // print_r('trss'); exit;        
            foreach($posts as $post) {
                $html .= get_post_tour_html($post,'','','');
            }
       }
        if($_POST['module_id']== 'travel_guide_tour'){
           // print_r('trss'); exit;        
            foreach($posts as $post) {
                $html .= get_post_tour_html($post,'','','');
            }
       }

       if($_POST['module_id']== 'expert_about_page'){
            foreach($posts as $post) {
                $thumbnail_id = get_post_thumbnail_id($post->ID);
                $thubnail = mundo_get_attachment_image_src($thumbnail_id, 'post_destination')?:'';
                $link = (get_the_permalink($post->ID))?:'';
                $title = ($post->post_title)?:'' ;
                $experts = (get_the_excerpt($post->ID))?:'';
                $Specialize = get_post_meta($post->ID,'Specialize',true);
                //return $Specialize;   
                
                $html .= ' <div class="item"><article id="post-'.$post->ID.'" class="et_pb_post clearfix post-'.$post->ID.' post type-post status-publish format-standard has-post-thumbnail hentry category-uncategorized">
                                <div class="post-thumbnail">
                                    <a href="'.$link.'" class="entry-featured-image-url">
                                        <img src="'.$thubnail.'" alt="'.$title.'" width="1080" height="675">
                                    </a>
                                </div>
                                <h2 class="entry-title content"><a href="'.$link.'">'.$title.'</a></h2>
                                <div><p>'.$experts.'</p></div>';
               if ($Specialize) {
                    $html .= '<div class="specialize-home">'.$Specialize.'</div>';
                }
                $html .= '</div>';
                
            }
       }
         
    }
       
    $html.= '</div> ';

    $language = pll_current_language();
    switch ($language) {
        case 'en':
            $link_experience = get_permalink(get_page_by_path('experiences')).$term;
            // $link_experience = $module_id=='departure_month'?$link_experience.'?type=SIC':'';
            break;
        case 'es':
             $link_experience = get_permalink(get_page_by_path('experiencias-2')).$term;
             // $link_experience = $module_id=='departure_month'?$link_experience.'?type=SIC':'';
            break;
        case 'pt':
             $link_experience = get_permalink(get_page_by_path('experiencias')).$term;
             // $link_experience = $module_id=='departure_month'?$link_experience.'?type=SIC':'';
            break;
    }
     
    $html .= '<div class="show_more_in_tab"><a href="'.$link_experience.'" class="make-enquire">'.__('Show more','mundo').'</a></div>';
    $html.='</div> ';
    
    //print_r($html); exit;
    echo json_encode(array(
        'error' => 0,
        'mess' => '',
        'html' => $html,
    ));
    exit();
   
    
};
add_filter('et_pb_post_slider_with_js_query_args',function($query_args,$module_id,$term){
    switch ($module_id) {
        case 'travel_guide_tour':
        if($term=='all'){
            $query_args['tax_query'] = array(
                    array(
                        'taxonomy' => 'category-travel-guide',
                        'operator' => 'EXISTS'
                    ),                      
            );
        }  
            break;
    }
    return $query_args;
},10,3);

//post = ọpject
function get_post_res_html($post,$module_id = ''){
    $thumbnail_id = get_post_thumbnail_id($post->ID);
    $thubnail = mundo_get_attachment_image_src($thumbnail_id, 'tour_another')?:'';
    $link = (get_the_permalink($post->ID))?:'';
    $title = ($post->post_title)?:'' ;
    $experts = '';
    $html = '<div class="item">
                <article id="post-'.$post->ID.'" class="et_pb_post clearfix post-'.$post->ID.' post type-post status-publish format-standard has-post-thumbnail hentry category-uncategorized">
                    <div class="post-thumbnail">
                        <a href="'.$link.'" class="entry-featured-image-url"><img src="'.$thubnail.'" alt="'.$title.'" width="1080" height="675"></a>
                    </div>
                    <div class="post_content">
                        <h2 class="entry-title content"><a href="'.$link.'">'.$title.'</a></h2><p>'.$experts.'</p>';
  //  $html .= apply_filters('custom_post_show_content', $html, $module_id, $post);
    $location = wp_get_post_terms( $post->ID, 'category-destination', array() );
    $res_style = wp_get_post_terms( $post->ID, 'res_style', array() );
    $html .= '<div class="content">';
    $html .= '<span class="location">'.$location[0]->name.'</span>   ';
    $html .= ' <span class="style">'.$res_style[0]->name.'</span>';
    $html .= '</div>';     
    $html .= '      </div>';
    $html .= '</article>
            </div>';
    return $html;        
}
//post = ọpject
function get_post_hotel_html($post,$module_id = ''){
    $thumbnail_id = get_post_thumbnail_id($post->ID);
    $thubnail = mundo_get_attachment_image_src($thumbnail_id, 'tour_another')?:'';
    $link = (get_the_permalink($post->ID))?:'';
    $title = ($post->post_title)?:'' ;
    $experts = '';
    $html = '<div class="item">
                <article id="post-'.$post->ID.'" class="et_pb_post clearfix post-'.$post->ID.' post type-post status-publish format-standard has-post-thumbnail hentry category-uncategorized">
                    <div class="post-thumbnail">
                        <a href="'.$link.'" class="entry-featured-image-url"><img src="'.$thubnail.'" alt="'.$title.'" width="1080" height="675"></a>
                    </div>
                    <div class="post_content">
                        <h2 class="entry-title content"><a href="'.$link.'">'.$title.'</a></h2><p>'.$experts.'</p>';
  //  $html .= apply_filters('custom_post_show_content', $html, $module_id, $post);
    $location = wp_get_post_terms( $post->ID, 'category-destination', array() );
    $hotel_styles = wp_get_post_terms( $post->ID, 'hotel_style', array() );
    $html .= '<div class="content">';
    $html .= '<span class="location">'.$location[0]->name.'</span>   ';
    $html .= ' <span class="style">'.$hotel_styles[0]->name.'</span>  <hr> ';
    $discount_price_html = '';
    $price = get_post_meta($post->ID,'price_from',true);
    $symbol_exchange = '$';
    if (isset($_COOKIE['exchange_rate'])){
        $exchange_rate_string = $_COOKIE['exchange_rate'];
        $exchange_rate_cookie = explode("-",$exchange_rate_string); 
        $price = $price * $exchange_rate_cookie[2];
        $symbol_exchange = $exchange_rate_cookie[1];
    }
    $lang = pll_current_language();
    $price = mundo_exchange_rate($price, $lang);
    $html .= '<div class=""><b class="text_gray">From:  </b>'.$discount_price_html.' <b class="'.$discount.' '.$text_gray.' price">'.$symbol_exchange.$price.' </b> <b class=" '.$discount.' text_gray "> per room</b></div></div>';     
    $html .= '      </div>';
    $html .= '</article>
            </div>';
    return $html;        
}

function get_post_tour_hightlight_html($post, $module_id = ''){
    $symbol_exchange = '$';
    if (isset($_COOKIE['exchange_rate'])){
        $exchange_rate_string = $_COOKIE['exchange_rate'];
        $exchange_rate_cookie = explode("-",$exchange_rate_string); 
        $symbol_exchange = $exchange_rate_cookie[1];
    }
    $taxonomy_name = get_query_var( 'taxonomy_name');
    $term_name = get_query_var( 'term_name');

    $thumbnail_id = get_post_thumbnail_id($post->ID);
    $src = mundo_get_attachment_image_src($thumbnail_id, 'tour_another')?:''; 
    $link = (get_the_permalink($post->ID))?:'';
    $title = ($post->post_title)?:'' ;
    $experts = (get_the_excerpt($post->ID))?:'';
    $html .= ' <div  class="col-md-4">
                    <article id="post-'.$post->ID.'"et_pb_post clearfix post-'.$post->ID.' '.$post->post_type.' type-'.$post->post_type.' status-publish has-post-thumbnail hentry label_tour-new type_of_tour-tour travel_style-highlights category-destination-vietnam tour_guide-english tour_guide-spanish">
                    <div class="post-thumbnail">
                        <a href="'.$link.'" class="entry-featured-image-url"><img src="'.$src.'" alt="'.$title.'"></a>';
    // label
    $label_tour = (wp_get_post_terms($post->ID, 'label_tour'))?:array();
    if($label_tour){
        $html .= '<div class="label_tour">'.$label_tour[0]->name.' </div>';
    }
    // so ngay/ dem
    $days = 0; 
    $itinerary = (get_post_meta($post->ID, 'itinerary',true))?:array();                    
    if($itinerary){
        $days = count($itinerary);
        //$day_html = ($days==1)?$days.' Day / 0 Night': $days. ' Days / '.($days-1).' Nights';
        $day_html = ($days==1)?$days.' '.__("Day",'mundo').' / 0 '.__("Night",'mundo').'': $days. ' '.__("Days",'mundo').' / '.($days-1).' '.__("Nights",'mundo').'';
    }
    $html .= '<div class="days"><b>'.$day_html.'</b> </div>';
    //category
    $terms = wp_get_post_terms($post->ID,'travel_style'); 
    $terms = get_terms( array(
        'taxonomy' => $taxonomy_name,
        'hide_empty' => false,
        'slug' => $term_name,
    ) );
    $list_category = get_post_meta($post->ID,'travel_style',true);    
    if($terms){
        $list_category = '';
        foreach($terms as $term){
            $list_category .= $term->name .'    ';
        }
    }
         
    //$html .= '<div class="post-meta post-content content category_tour"><b>'.$list_category.'</b> </div>';
    //het phan thumbnail
    $html .='</div>';
    
    //phan content
    $html .='<div class="post_content" style="height: 152px;">
            <h2 class="entry-title content" style="height: 56px;">
                 <a href="'.$link.'">'.$title.'</a>
            </h2>
                <div><p>'.$experts.'</p></div>';
    $route = (get_post_meta($post->ID,'route',true))?:'';
    $html .= '<div class="route content"><b>'.str_replace(",","/",$route).'</b> </div>'; 
    
    //hightlight city
    $highlight_city = (get_post_meta($post->ID, 'highlight_city', true))?:'';
    $html .= '<div class="highlight_city content"><b>'.__("Highlights",'mundo').' : </b> <b class="text_gray">'.$highlight_city.'</b> </div>
    </div>'; // het phan content
    
    $discount_price = get_post_meta($post->ID, 'discount_price',true);
    $text_gray = '';
    $discount = 'price';
    $discount_price_html = '';
    if($discount_price){
        $discount_price_html = '<b class="discount_price"> '.$symbol_exchange.$discount_price.'pp </b>';
        $text_gray = 'text_gray';
        $discount = 'discount';
    }
    $price = mundo_get_price_last_6_month($post->ID);
     if($price){
        $lang = pll_current_language();
        $price = (intval($price))?mundo_exchange_rate($price,$lang ):$price;
        $price_html = (intval($price))?'<b class="'.$discount.' '.$text_gray.'">'.$symbol_exchange.$price.' </b> <b class=" '.$discount.' text_gray ">pp</b>':'<b class="'.$discount.' '.$text_gray.'">'.$price.' </b>';
    }else{
        $price_html ='<b class="price">'.__('On Request','mundo').'</b>';
    }

    //d($price);d($price_html);d($discount_price_html);
    $from = $price=='On request'&&empty($discount_price)?__("Price",'mundo').': ':__("From",'mundo').': ';
    $html .= '<hr>
              <div class="row content">
                    <div class = "col-lg-7 col-md-6">
                        <b class="text_gray">'.$from.' </b>'.$discount_price_html.$price_html.'</div>';
    $html .= '<div class="col-lg-5 col-md-6 view-tour"><a class="more-link" href="'.$link.'">'.__("View Tour",'mundo').'</a></div>
              </div>';
              
    $html .= '</article></div>';
    return $html;
}
//post = ọpject
function get_post_tour_html($post, $module_id = '',$i, $fullwidth){
		//echo $i.'bieni';
            $symbol_exchange = '$';
            if (isset($_COOKIE['exchange_rate'])){
                $exchange_rate_string = $_COOKIE['exchange_rate'];
                $exchange_rate_cookie = explode("-",$exchange_rate_string); 
                $symbol_exchange = $exchange_rate_cookie[1];
            }
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
            if($itinerarys){
                $days = count($itinerarys);
                //$day_html = ($days==1)?$days.' Day / 0 Night': $days. ' Days / '.($days-1).' Nights';
                $day_html = ($days==1)?$days.' '.__("Day",'mundo').' / 0 '.__("Night",'mundo').'': $days. ' '.__("Days",'mundo').' / '.($days-1).' '.__("Nights",'mundo').'';
            }
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
                            <h2 class="entry-title content"><a href="'.$link.'">'.$title.'</a></h2><div><p>'.$experts.'</p>';
           
            
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
           
            //$html .= '<div class="departure_date content"><b> '.__("Departures date",'mundo').': '.$departure_date_text.'</b> </div>';
            $route = (get_post_meta($post->ID,'route',true))?:'';
            $html .= '<div class="route content"><b>'.str_replace(",", " - ",$route).'</b></div>';
            
            
             $highlight_city = (get_post_meta($post->ID, '', true))?:'';
            $highlight_city = (get_post_meta($post->ID, 'highlight_city', true))?:'';
            

            //$html .= get_post_meta($post->ID,'select_type',true);


            $html .= '<div class="highlight_city content"><b>'.__("Highlights",'mundo').' : </b> <b class="text_gray">'.$highlight_city.'</b> </div></div></div><hr>';
            $discount_price = get_post_meta($post->ID, 'discount_price',true);
            $text_gray = '';
            $discount = 'price';
            $discount_price_html = '';
            if($discount_price){
                $discount_price_html = '<b class="discount_price"> '.$symbol_exchange.$discount_price.'pp </b>';
                $text_gray = 'text_gray';
                $discount = 'discount';
            }
            //lay ham gia 6 thang gần nhất.
            $price = mundo_get_price_last_6_month($post->ID);
            if($price){
                $lang = pll_current_language();
                $price = (intval($price))?mundo_exchange_rate($price,$lang ):$price;
                $price_html = (intval($price))?'<b class="'.$discount.' '.$text_gray.'">'.$symbol_exchange.$price.' </b> <b class=" '.$discount.' text_gray ">pp</b>':'<b class="'.$discount.' '.$text_gray.'">'.$price.' </b>';
            }else{
                $price_html ='<b class="price">'.__('On Request','mundo').'</b>';
            }

           $from = $price=='On request'&&empty($discount_price)?__("Price",'mundo').': ':__("From",'mundo').': ';
           // $price = get_post_meta($post->ID, 'price_from',true);
            $html .= '<div class="row content"><div class = "col-lg-7 col-md-6"><b class="text_gray">'.$from.'</b>'.$discount_price_html. $price_html.'</div>';
           $html .= '<div class=" col-lg-5 col-md-6 view-tour"><a class="more-link" href="'.$link.'">'.__("View tour",'mundo').'</a></div></div></article></div>';
    return $html;        
}
//get post travel
function get_post_travel_html($post, $module_id = ''){
            $title = get_post_meta($post->ID, 'title',true);
            $content = get_post_meta($post->ID, 'content',true);
            $guest_name = get_post_meta($post->ID,'guest_name',true);
            $country = wp_get_post_terms( $post->ID, 'country', array() );
            $country_name = $country[0]->name;
            $html = '<article id="post-'.$post->ID.'" class="et_pb_post clearfix post-'.$post->ID.' post type-post status-publish format-standard has-post-thumbnail hentry category-uncategorized"> 
                <div class="row"><div class="col-md-7 col-sm-7">';
                $html .= '<a href="'.get_permalink($post).'" class="entry-featured-image-url postition-thumb-all">';
                $thumbnail_id = get_post_thumbnail_id($post);
                if($thumbnail_id) {
                    $src = mundo_get_attachment_image_src($thumbnail_id, 'blog_list_all');
                    $image = sprintf('<img src="%s" alt="%s" />', $src, $post->post_title);
                    $html .= $image;
                }
            $html .=  '</a></div>';
            $date = date('M d,Y', strtotime($post->post_date));
            $html .= '<div class="wrapper-content postition-content-all  col-md-5 col-sm-5">
                        <div class="published date_before">'.$date.'</div>
                        <h2 class="entry-title"><a href="'.get_permalink($post).'">'.$post->post_title.'</a></h2>
                        <div class="post-content"><p>'.$post->post_excerpt.'
                        </p></div> <a href="'.get_permalink($post).'" class="more-link">'.__("Show more",'mundo').'</a></div>';
            $html .= '</div></article>';
    return $html;        
}

// ham lay gia tour
function mundo_get_price_last_6_month($post_id){
    $tour_type = get_post_meta($post_id, 'select_type',true);
    if($tour_type == 'seat_in_coach'){
         //1. lay post co gia
        $sic_rate_posts = get_posts(array(
            'post_type' => 'sic_tour_rate',
            'posts_per_page' => -1,
            'post_status' =>'publish',
            'meta_query' => array(
                array(
                    'key' => 'tour_name',
                    'value' => $post_id,
                )
            ),
        ));
        // print_r($sic_rate_posts);
        //$min_rate = 100000;

        if($sic_rate_posts){
            $rates = get_post_meta($sic_rate_posts[0]->ID,'group_sic_rate',true);
            foreach($rates as $rate){
                $from_date = $rate['from_date']['timestamp'];
                $to_date = $rate['to_date']['timestamp'];
                //(time() >= $from_date) && (time() <= $to_date) && thêm vào dưới kiểm tra ngày hiện tại có trong khoảng ko
                if((($to_date <= strtotime('+6 months', time()))||($from_date<= strtotime('+6 months', time())&&$to_date>= strtotime('+6 months', time()) ))){

                    
                    if($min_rate){
                        $min_rate = ($min_rate < $rate['tour_rate'] )?$min_rate: $rate['tour_rate'];
                    }else{
                        $min_rate = $rate['tour_rate'];
                    }
                    
                }
            }
        }   
    }else{
        //1. lay post co gia
        $custom_rate_posts = get_posts(array(
            'post_type' => 'customize_rate',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => 'tour_name_customize',
                    'value' => $post_id,
                    'compare' => '='
                )
            ),
        ));
        if(!empty($custom_rate_posts)){
            $custom_rates = get_post_meta($custom_rate_posts[0]->ID,'group_tour_rate',true);//Lấy ra mảng các giá của tour rate
        }
        
        $min_time_rate = get_min_time_tour_rate($post_id);
        $min_time = $min_time_rate['min_time'] ;
        if(!empty($custom_rates)){
        foreach ($custom_rates as $custom_rate){//chạy vòng lặp qua các khoảng time
            $from_date = $custom_rate['from_date']['timestamp'];//lấy ngày đầu của khoảng
            $to_date =  $custom_rate['to_date']['timestamp']; //lấy ngày cuối của khoảng
            //(time() >= $from_date) && (time() <= $to_date) && thêm vào dưới kiểm tra ngày hiện tại có trong khoảng ko
            if( $to_date >= time() && ( ($to_date <= strtotime('+6 months', time() ) )||($from_date<= strtotime('+6 months', time())&&$to_date>= strtotime('+6 months', time()) )) ){
                //Nếu ngày cuối cùng lớn hơn hiện tại và (ngày cuối cùng nhỏ hơn 6 tháng tới hoặc ( ngày đầu tiên nhỏ hơn 6 tháng tới và ngày cuối cùng lơn hơn 6 tháng tới))
                foreach ($custom_rate['group_rate'] as $rate){
                    if($rate['from']==2 || $rate['to']==2){ //trong các giá trong khoảng thời gian đó thì lấy giá cho 2 người
                        $tour_guide_cus = get_main_lang_tour($post_id);
                        $tour_html = $tour_guide_cus['tour_html'];
                        $tour_lang_main = $tour_guide_cus['main_lang'];
                        

                        if($min_rate){

                            $min_rate = ($min_rate> $rate['price'])?$rate['price']:$min_rate;

                        }else{
                            $min_rate = $rate['price'];

                        }
                        
                    }
                }
            }
            $tour_guides = wp_get_post_terms($post_id,'tour_guide',array());
            if ($tour_guides) {
                    $tour_guide_cus = get_main_lang_tour($post_id);
                    $tour_lang_main = $tour_guide_cus['main_lang'];
            }

            if (  ( $from_date <= $min_time && $min_time <= $to_date) ) {
                switch($tour_lang_main){
                    //71 tieng anh ; 70: Spanish; 73: no guide 72: Portuguese
                    case '71':
                        $prices_lang = 0;
                        $prices_lang = 0-$custom_rate['english_guide'];
                        break;
                    case '70':
                        $prices_lang =  $custom_rate['spanish_guide'];
                        break;
                    case '72':
                        $prices_lang=  $custom_rate['portugese_guide'];
                        break;
                    case '73':
                        $prices_lang = 0;
                        break;
                    
                }
            }

        }//end foreach
        }//end if       
    }

    
    
    $price_from = !empty($min_rate)?$min_rate:"On request"; 
    $price_not_guide = $price_from;

    $prices_lang = $prices_lang?:0;
    //$prices_lang = 0;
    $price_from = $price_from+$prices_lang/2;

    if(intval($price_from)){
        update_post_meta( $post_id, 'price_from', $price_from);
        update_post_meta( $post_id, 'price_not_guide', $price_not_guide);
    }else{
        update_post_meta( $post_id, 'price_from', 0 );
        update_post_meta( $post_id, 'price_not_guide', 0 );
    }

    if (isset($_COOKIE['exchange_rate'])){
        $exchange_rate_string = $_COOKIE['exchange_rate'];
        $exchange_rate_cookie = explode("-",$exchange_rate_string); 
        $price_from = $price_from * $exchange_rate_cookie[2];
    }
    return ceil($price_from) ; 
};
//save tieu de post sic rate
add_action('wp_ajax_admin_get_tour_name', function(){
    $tour_id = $_POST['tour_id'];
    $tour_name = get_the_title($tour_id);
    echo json_encode(array(
        'error' => 0,
        'mess' => '',
        'html' => $tour_name,
    ));
    exit();
});
add_filter( 'custom_show_more_text',function($show_more_text,$module_id){
    switch ($module_id) {
        case 'traveller_reviews':
            $show_more_text = __('More Reviews', 'mundo');
            break;
        case 'excursion_reviews':
            $show_more_text = __('Show more', 'mundo');
            break;
        default:
            $show_more_text = __('Show more', 'mundo');
            break;
    }
    return $show_more_text;
},10,2);

function liva_get_post_menu_custom($menu_parent){
        $terms_parent = get_terms( array(
                    'taxonomy' => 'category-destination',
                    'hide_empty' => false,
                    'parent' => 0,
                ) );
        $terms_parent_id = wp_list_pluck($terms_parent,'term_id');
        $args = array(
                  'numberposts' => -1,
                  'post_type'   => 'destination',
                  'tax_query' => array(
                                            array(
                                                'taxonomy' => 'category-destination',
                                                'field'    => 'term_id',
                                                'terms'    => $terms_parent_id,
                                                'operator' => 'IN',
                                                'include_children' => false,
                                            ),
                                        ),
                  'orderby'    => 'post_title',
                  'order'      => 'ASC',
                );
        $menu_posts = get_posts( $args );
        if ($menu_posts) {
            foreach ($menu_posts as $key => $menu_post) {
                $menu_post->menu_item_parent = $menu_parent;
                $menu_post->title = $menu_post->post_title;
                $menu_post->url = get_permalink($menu_post->ID);//get_post_meta($menu_post->ID,'link',true);
                $item[] = $menu_post;
            }
        }
        return $item;
    };
add_filter( 'wp_nav_menu_objects', function($items,$args ){  
    if($args->menu->slug =="topmenu")
    {
        $items1= liva_get_post_menu_custom('7650')?:array();
        $items = array_merge($items,$items1);
    }   
    return $items;
},10,2);
function mundo_exchange_rate($price, $lang){
    if($lang == 'en'){
        return $price;
    }
    $post_ex_rates = get_posts(array(
       'posts_per_page'   => -1,
       'post_type' => 'exchange_rate',
       'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'from_date',
                'value' => time(),
                'compare' => '<=' 
            ),
            array(
                'key' => 'to_date',
                'value' => time(),
                'compare' => '>',
            )
        )
    ));
    foreach($post_ex_rates as $post_ex_rate){
        $group_rate = get_post_meta($post_ex_rate->ID, 'group_currency',true);
        foreach($group_rate as $rate){
            $from_currency = get_term( $rate['from_currency']);
            if($lang == $from_currency->slug){
                $price = ($rate['Value'])?$price * $rate['Value']:$price;
            }
        }
    }
    return $price;
};
//Slider Đối tác chiến lược
add_shortcode( 'slide_owl', 'slide_owl_func' );
    function slide_owl_func(  ) {
        global $post;
        ob_start();
            echo '<div class="doitacchienluoc">';
            echo '<span class="tieu_de"><h3> '.__('Đối tác chiến lược','colormag-child').'</h3></span>';   
                echo '<div class="owl-carousel owl-theme" id="owl-carousel">';
                  $args = array(
                    'post_type' => 'doi_tac',
                    );
                 $wp_query = new WP_Query($args); 
                 $count =0;
                 if ( $wp_query->have_posts() ) : 
                  while ( $wp_query->have_posts() ) : $wp_query->the_post();
                    //print_r($wp_query);
                   // print_r($post);  
                    $link= get_post_meta( $post->ID, 'txt_link', true );
                    $img_img= get_post_meta( $post->ID, 'img_img', true );
                    $img_doitac = wp_get_attachment_image_src( $img_img, $size ='img-doi-tac-chien-luoc', false );  
                    echo '<div class="item" >';
                    echo   '<a href="'.$link.'"><img class="'.$count.'" src="'. $img_doitac[0].'"/></a>';
                    echo '</div>';
                    $count++;
                 endwhile; 
                endif; 

           echo  '</div>';    
           echo '</div>'; 
        $result = ob_get_contents();
        ob_end_clean();
     return $result;
    }
//Đổi link của destination
// add_filter('post_type_link',function ($post_link, $post, $leavename){
//     if ($post->post_type=='destination') {
//         $terms = wp_get_post_terms( $post->ID, 'category-destination', array() );
//         // print_r($terms);exit();
//         $name = $terms[0]->name;
//         $slug = $terms[0]->slug;
//         $parent  = $terms[0]->parent;
//         if ($parent) {
//             $parent_term = get_terms( array( 'taxonomy'=>'category-destination',
//                                              'include' => array($parent),));
//             $slug_parent = $parent_term[0]->slug;
//             $post_link = str_replace("destination",$slug_parent,$post_link);
//         }else{
//             $post_link = str_replace("destination/",'',$post_link);
//         }
//     }
//     return $post_link;
// },10,4);
//rewrite url web
add_action('init',function(){
    //add_rewrite_tag('%destination%', '([^&]+)');
    // add_rewrite_rule('^([^/]+)/([^/]+)/([^/]+)?$', 'index.php?post_type=hotel&name=$matches[3]', 'top');
    // add_rewrite_rule('^([^/]+)?$', 'index.php?post_type=destination&name=$matches[1]', 'top');
    // add_rewrite_rule('^([^/]+)/([^/]+)?$', 'index.php?post_type=destination&name=$matches[2]', 'top');
    //add_rewrite_rule('^([^/]+)/([^/]+)/([^/]+)?$', 'index.php?post_type=destination&name=$matches[3]', 'top');
    add_rewrite_tag('%travel_style_cat%', '([^&]+)');
    add_rewrite_rule('^experiences/([^/]+)?$', 'index.php?pagename=experiences&travel_style_cat=$matches[1]', 'top');
    add_rewrite_rule('^es/experiencias-2/([^/]+)?$', 'index.php?pagename=experiencias-2&travel_style_cat=$matches[1]', 'top');
    add_rewrite_rule('^pt/experiencias/([^/]+)?$', 'index.php?pagename=experiencias&travel_style_cat=$matches[1]', 'top');
});
add_action('manage_posts_extra_tablenav', function($which)
{
  $post_type = isset($_GET['post_type']) ? $_GET['post_type'] : '';
  if ($post_type == 'destination' && $which == 'top') {
    //DIA DIEM KHACH SAN
    $tree    = get_terms('category-destination', array(
      'hide_empty' => false
    ));
    $option_ = '';
    $get_dd  = isset($_GET['category_destination_query']) ? $_GET['category_destination_query'] : '';
    foreach ($tree as $term) {
      $selected = selected($term->slug, $get_dd, false);
      $option_ .= sprintf('<option value="%s" %s>%s</option>', $term->slug, $selected, $term->name);
    }
    
    echo '<div class="alignleft actions">';
    echo '<select name="category_destination_query" id="category_destination_query" readonly><option value="">None</option>';
    echo $option_;
    echo '</select>';
    echo '<input type="submit" name="filter_action" id="category_destination_query-submit" class="button" value="Filter">';
    echo '</div>'; //PUBLISH
    $option_         = '';
    $get_post_status = isset($_GET['post_status']) ? $_GET['post_status'] : '';
    foreach (array(
      '' => 'None',
      'publish' => 'Publish',
      'pending' => 'Not publish'
    ) as $key => $value) {
      $selected = selected($key, $get_post_status, false);
      $option_ .= sprintf('<option value="%s" %s>%s</option>', $key, $selected, $value);
    }
    echo '<div class="alignleft actions">';
    echo '<select name="post_status" id="post_status" readonly>';
    echo $option_;
    echo '</select>';
    echo '<input type="submit" name="filter_action" id="post_status-submit" class="button" value="Filter">';
    echo '</div>';
  }
  if ($post_type == 'tour' && $which == 'top') {
    //DIA DIEM KHACH SAN
    $tree    = get_terms('category-destination', array(
      'hide_empty' => false
    ));
    $option_ = '';
    $get_dd  = isset($_GET['category_destination_query']) ? $_GET['category_destination_query'] : '';
    foreach ($tree as $term) {
      $selected = selected($term->slug, $get_dd, false);
      $option_ .= sprintf('<option value="%s" %s>%s</option>', $term->slug, $selected, $term->name);
    }
    
    echo '<div class="alignleft actions">';
    echo '<select name="category_destination_query" id="category_destination_query" readonly><option value="">None</option>';
    echo $option_;
    echo '</select>';
    echo '<input type="submit" name="filter_action" id="category_destination_query-submit" class="button" value="Filter">';
    echo '</div>'; //PUBLISH
    $option_         = '';
    $get_post_status = isset($_GET['post_status']) ? $_GET['post_status'] : '';
    foreach (array(
      '' => 'None',
      'publish' => 'Publish',
      'pending' => 'Not publish'
    ) as $key => $value) {
      $selected = selected($key, $get_post_status, false);
      $option_ .= sprintf('<option value="%s" %s>%s</option>', $key, $selected, $value);
    }
    echo '<div class="alignleft actions">';
    echo '<select name="post_status" id="post_status" readonly>';
    echo $option_;
    echo '</select>';
    echo '<input type="submit" name="filter_action" id="post_status-submit" class="button" value="Filter">';
    echo '</div>';
  }
  
}, 10, 1);
add_filter( 'bulk_actions-edit-destination', 'register_my_bulk_actions',10,1 );
add_filter( 'bulk_actions-edit-tour', 'register_my_bulk_actions',10,1 );
function register_my_bulk_actions($bulk_actions) {
  $bulk_actions['trash'] = __( 'Move to trash', 'mundo');
  return $bulk_actions;
}
add_action("save_post_tour", function($post_id, $post, $update) {
    return  sort_tour_by_cat($post_id);
}, 10, 3 );



add_action('init',function(){

    function sort_tour_by_cat($post_id){
        $terms_des = wp_get_post_terms($post_id,'category-destination'); 
        $count_des = 0;
        foreach ($terms_des as $key_des => $value_des) {
            if($value_des->parent==0){
                $count_des++;
            }
        }
        update_post_meta($post_id,'sort_tour_by_cat',$count_des);  
    };
    // $post_tour = get_posts( array(
    //     'post_type'    => 'tour',
    //     'posts_per_page' => -1,
    // ) );
    // foreach ($post_tour as $key => $value) {
    //     $post_id = $value->ID;
    //     sort_tour_by_cat($post_id);
    //     $position_display = get_post_meta($post_id,'position_display',true);
    //     if (!$position_display) {
    //         update_post_meta($post_id,'position_display',9999); 
    //     }
    // }
    // echo 'thành công';exit();
    // $terms_des = get_terms( 'category-destination', array(
    //     'hide_empty' => false,
    // ) );
    // foreach ($terms_des as $key => $value) {
    //     $stt = get_term_meta($value->term_id,'stt',true);
    //     if (!$stt) {
    //         update_term_meta( $value->term_id, 'stt',9999 );
    //     }
    // }
});

if (!function_exists('cc_tour_page_ajax_filter')) {
	function cc_tour_page_ajax_filter() {
		$c_url					= $_REQUEST['c_url'];
		$new_url				= '';

		$checked				= $_REQUEST['checked'];

		$type_of_tour 			= $_REQUEST['type_of_tour'];
		$type_of_tour			= $type_of_tour[0];

		$category_destination	= $_REQUEST['category_destination'];
		$category_destination	= $category_destination[0];

		$travel_style			= $_REQUEST['travel_style'];
		$travel_style			= $travel_style[0];

		$duration_tour			= $_REQUEST['duration_tour'];
		$duration_tour			= $duration_tour[0];

		$highlight				= $_REQUEST['highlight'];
		$highlight				= $highlight[0];

		$departure				= $_REQUEST['departure'];
		$departure				= $departure[0];

		$tour_guide				= $_REQUEST['tour_guide'];
		$tour_guide				= $tour_guide[0];

		$post_per_page			= $_REQUEST['post_per_page'];

		$filter_price			= $_REQUEST['filter_price'];

		$sort_by				= $_REQUEST['sort_by'];

		$s_tour					= $_REQUEST['s_tour'];

		$clear_all				= $_REQUEST['clear_all'];

		$queries = array();
		parse_str($c_url, $queries);

		//type of tour
		if (isset($type_of_tour)) {
			if ($checked == 1) {
				if (strpos($c_url, 'type_of_tour') !== false) {
					$new_url = str_replace('type_of_tour=' . $queries['type_of_tour'], 'type_of_tour=' . $queries['type_of_tour'] . '.' . $type_of_tour, $c_url);
				} else {
					$new_url = $c_url . '&type_of_tour=' . $type_of_tour;
				}
			} else if ($checked == 0) {
				if (strpos($c_url, 'type_of_tour') !== false) {
					if ($queries['type_of_tour'] == $type_of_tour) {
						$new_url = str_replace('&type_of_tour=' . $type_of_tour, '', $c_url);
					} else {
						if (strpos($c_url, '.' . $type_of_tour) !== false) {
							$new_url = str_replace('.' . $type_of_tour, '', $c_url);
						} else {
							$new_url = str_replace($type_of_tour . '.', '', $c_url);
						}
					}
				}
			}
		}

		// category destination
		if (isset($category_destination)) {
			if ($checked == 1) {
				if (strpos($c_url, 'category_destination') !== false) {
					$new_url = str_replace('category_destination=' . $queries['category_destination'], 'category_destination=' . $queries['category_destination'] . '.' . $category_destination, $c_url);
				} else {
					$new_url = $c_url . '&category_destination=' . $category_destination;
				}
			} else if ($checked == 0) {
				if (strpos($c_url, 'category_destination') !== false) {
					if ($queries['category_destination'] == $category_destination) {
						$new_url = str_replace('&category_destination=' . $category_destination, '', $c_url);
					} else {
						if (strpos($c_url, '.' . $category_destination) !== false) {
							$new_url = str_replace('.' . $category_destination, '', $c_url);
						} else {
							$new_url = str_replace($category_destination . '.', '', $c_url);
						}
					}
				}
			}
		}

		//travel style
		if (isset($travel_style)) {
			if ($checked == 1) {
				if (strpos($c_url, 'travel_style') !== false) {
					$new_url = str_replace('travel_style=' . $queries['travel_style'], 'travel_style=' . $queries['travel_style'] . '.' . $travel_style, $c_url);
				} else {
					$new_url = $c_url . '&travel_style=' . $travel_style;
				}
			} else if ($checked == 0) {
				if (strpos($c_url, 'travel_style') !== false) {
					if ($queries['travel_style'] == $travel_style) {
						$new_url = str_replace('&travel_style=' . $travel_style, '', $c_url);
					} else {
						if (strpos($c_url, '.' . $travel_style) !== false) {
							$new_url = str_replace('.' . $travel_style, '', $c_url);
						} else {
							$new_url = str_replace($travel_style . '.', '', $c_url);
						}
					}
				}
			}
		}

		//duration tour
		if (isset($duration_tour)) {
			if ($checked == 1) {
				if (strpos($c_url, 'duration_tour') !== false) {
					$new_url = str_replace('duration_tour=' . $queries['duration_tour'], 'duration_tour=' . $queries['duration_tour'] . '.' . $duration_tour, $c_url);
				} else {
					$new_url = $c_url . '&duration_tour=' . $duration_tour;
				}
			} else if ($checked == 0) {
				if (strpos($c_url, 'duration_tour') !== false) {
					if ($queries['duration_tour'] == $duration_tour) {
						$new_url = str_replace('&duration_tour=' . $duration_tour, '', $c_url);
					} else {
						if (strpos($c_url, '.' . $duration_tour) !== false) {
							$new_url = str_replace('.' . $duration_tour, '', $c_url);
						} else {
							$new_url = str_replace($duration_tour . '.', '', $c_url);
						}
					}
				}
			}
		}

		//highlight
		if (isset($highlight)) {
			if ($checked == 1) {
				if (strpos($c_url, 'highlight') !== false) {
					$new_url = str_replace('highlight=' . $queries['highlight'], 'highlight=' . $queries['highlight'] . '.' . $highlight, $c_url);
				} else {
					$new_url = $c_url . '&highlight=' . $highlight;
				}
			} else if ($checked == 0) {
				if (strpos($c_url, 'highlight') !== false) {
					if ($queries['highlight'] == $highlight) {
						$new_url = str_replace('&highlight=' . $highlight, '', $c_url);
					} else {
						if (strpos($c_url, '.' . $highlight) !== false) {
							$new_url = str_replace('.' . $highlight, '', $c_url);
						} else {
							$new_url = str_replace($highlight . '.', '', $c_url);
						}
					}
				}
			}
		}

		//departure
		if (isset($departure)) {
			if ($checked == 1) {
				if (strpos($c_url, 'departure') !== false) {
					$new_url = str_replace('departure=' . $queries['departure'], 'departure=' . $queries['departure'] . '.' . $departure, $c_url);
				} else {
					$new_url = $c_url . '&departure=' . $departure;
				}
			} else if ($checked == 0) {
				if (strpos($c_url, 'departure') !== false) {
					if ($queries['departure'] == $departure) {
						$new_url = str_replace('&departure=' . $departure, '', $c_url);
					} else {
						if (strpos($c_url, '.' . $departure) !== false) {
							$new_url = str_replace('.' . $departure, '', $c_url);
						} else {
							$new_url = str_replace($departure . '.', '', $c_url);
						}
					}
				}
			}
		}

		//tour_guide
		if (isset($tour_guide)) {
			if ($checked == 1) {
				if (strpos($c_url, 'tour_guide') !== false) {
					$new_url = str_replace('tour_guide=' . $queries['tour_guide'], 'tour_guide=' . $queries['tour_guide'] . '.' . $tour_guide, $c_url);
				} else {
					$new_url = $c_url . '&tour_guide=' . $tour_guide;
				}
			} else if ($checked == 0) {
				if (strpos($c_url, 'tour_guide') !== false) {
					if ($queries['tour_guide'] == $tour_guide) {
						$new_url = str_replace('&tour_guide=' . $tour_guide, '', $c_url);
					} else {
						if (strpos($c_url, '.' . $tour_guide) !== false) {
							$new_url = str_replace('.' . $tour_guide, '', $c_url);
						} else {
							$new_url = str_replace($tour_guide . '.', '', $c_url);
						}
					}
				}
			}
		}

		//post per page
		if (isset($post_per_page)) {
			if (strpos($c_url, 'posts_per_page') !== false) {
				$new_url = str_replace('posts_per_page=' . $queries['posts_per_page'], 'posts_per_page=' . $post_per_page, $c_url);
			} else {
				$new_url = $c_url . '&posts_per_page=' . $post_per_page;
			}
		}

		//filter price
		if (isset($filter_price)) {
			if (strpos($c_url, 'filter_price') !== false) {
				$new_url = str_replace('filter_price=' . $queries['filter_price'], 'filter_price=' . $filter_price, $c_url);
			} else {
				$new_url = $c_url . '&filter_price=' . $filter_price;
			}
		}

		//sort by
		if (isset($sort_by)) {
			if (strpos($c_url, 'sort_by') !== false) {
				$new_url = str_replace('sort_by=' . $queries['sort_by'], 'sort_by=' . $sort_by, $c_url);
			} else {
				$new_url = $c_url . '&sort_by=' . $sort_by;
			}
		}

		//seach tour
		if (isset($s_tour)) {
			if (strpos($c_url, 's_tour') !== false) {
				$new_url = str_replace('s_tour=' . $queries['s_tour'], 's_tour=' . $s_tour, $c_url);
			} else {
				$new_url = $c_url . '&s_tour=' . $s_tour;
			}
		}

		//clear all
		if (isset($clear_all) && $clear_all == 'cc') {
			$new_url = str_replace('&type_of_tour=' . $queries['type_of_tour'], '', $c_url);
			$new_url = str_replace('&category_destination=' . $queries['category_destination'], '', $new_url);
			$new_url = str_replace('&travel_style=' . $queries['travel_style'], '', $new_url);
			$new_url = str_replace('&duration_tour=' . $queries['duration_tour'], '', $new_url);
			$new_url = str_replace('&highlight=' . $queries['highlight'], '', $new_url);
			$new_url = str_replace('&departure=' . $queries['departure'], '', $new_url);
			$new_url = str_replace('&tour_guide=' . $queries['tour_guide'], '', $new_url);
		}

		//build html
		$new_queries = array();
		parse_str($new_url, $new_queries);

		$args = cc_tour_build_query($new_queries);

		$cc_tour_query 	= new WP_Query($args);
		$data			= $cc_tour_query->posts;
		$max			= intval($cc_tour_query->max_num_pages);

		$html = array();

		ob_start();

		$html[] = cc_custom_tour_page_data_content($data, $max, $new_url);

		$html[] = ob_get_clean();

		if (strpos($new_url,'type_of_tour') !== false || strpos($new_url,'category_destination') !== false || strpos($new_url,'travel_style') !== false || strpos($new_url,'duration_tour') !== false || strpos($new_url,'highlight') !== false || strpos($new_url,'departure') !== false || strpos($new_url,'tour_guide') !== false) {
			$has_filter = 'cc';
		} else {
			$has_filter = '';
		}

		$request_arr = array(
			'text'		=> implode('', $html),
			'count'		=> count($data),
			'new_url'	=> $new_url,
			'has_filter'	=> $has_filter
		);

		echo json_encode($request_arr);

		exit;
	}

	add_action('wp_ajax_cc_tour_page_ajax_filter', 'cc_tour_page_ajax_filter');
	add_action('wp_ajax_nopriv_cc_tour_page_ajax_filter', 'cc_tour_page_ajax_filter');
}

if (!function_exists('cc_tour_build_query')) {
	function cc_tour_build_query($params) {
		$arpg			= array();

		$type_of_tour			= isset($params['type_of_tour'])			? $params['type_of_tour']			: '';
		$category_destination	= isset($params['category_destination'])	? $params['category_destination']	: '';
		$travel_style			= isset($params['travel_style'])			? $params['travel_style']			: '';
		$duration_tour			= isset($params['duration_tour'])			? $params['duration_tour']			: '';
		$highlight				= isset($params['highlight'])				? $params['highlight']				: '';
		$departure				= isset($params['departure'])				? $params['departure']				: '';
		$tour_guide				= isset($params['tour_guide'])				? $params['tour_guide']				: '';

		$posts_per_page			= isset($params['posts_per_page'])			? $params['posts_per_page']			: 9;
		$filter_price			= isset($params['filter_price'])			? $params['filter_price']			: '';
		$sort_by				= isset($params['sort_by'])					? $params['sort_by']				: '';
		$s_tour					= isset($params['s_tour'])					? $params['s_tour']					: '';

		/*
		 * Begin
		 */

		//basic
		$arpg['post_type']		= 'tour';
		$arpg['paged']			= '';
		$arpg['posts_per_page']	= $posts_per_page;

		if ($type_of_tour) {
			$arpg['tax_query'][] = array(
				'taxonomy' => 'type_of_tour',
				'field' => 'term_id',
				'terms' => explode('.', $type_of_tour)
			);
		}

		if ($category_destination) {
			$arpg['tax_query'][] = array(
				'taxonomy' => 'category-destination',
				'field' => 'term_id',
				'terms' => explode('.', $category_destination)
			);
		}

		if ($travel_style) {
			$arpg['tax_query'][] = array(
				'taxonomy' => 'travel_style',
				'field' => 'term_id',
				'terms' => explode('.', $travel_style)
			);
		}

		if ($duration_tour) {
			$arpg['tax_query'][] = array(
				'taxonomy' => 'duration_tour',
				'field' => 'term_id',
				'terms' => explode('.', $duration_tour)
			);
		}

		if ($tour_guide) {
			$arpg['tax_query'][] = array(
				'taxonomy' => 'tour_guide',
				'field' => 'term_id',
				'terms' => explode('.', $tour_guide)
			);
		}

		if ($highlight) {
			$arpg['meta_query'][] = array(
				'key'		=> 'tour_highlight',
				'value'		=> $highlight,
				'compare'	=> '='
			);
		}

		if ($filter_price) {
			$price_arr = explode('-', $filter_price);

			$arpg['meta_query'][] = array(
				'relation' => 'AND',
				array(
					'key' 		=> 'price_from',
					'value' 	=> $price_arr[0],
					'compare' 	=> '>'
				),
				array(
					'key' 		=> 'price_from',
					'value' 	=> $price_arr[1],
					'compare' 	=> '<'
				),
			);
		}

		if ($sort_by) {
			if ($sort_by == 'price-asc') {
				$arpg['meta_key'] 	= 'price_from';
				$arpg['orderby']	= 'meta_value_num';
				$arpg['order']		= 'ASC';
			} else if ($sort_by == 'price-desc') {
				$arpg['meta_key'] 	= 'price_from';
				$arpg['orderby']	= 'meta_value_num';
				$arpg['order']		= 'DESC';
			} else if ($sort_by == 'position') {
				$arpg['meta_key'] 	= 'position_display';
				$arpg['orderby']	= 'meta_value_num';
				$arpg['order']		= 'DESC';
			}
		}

		if ($s_tour) {
			$arpg['s'] = sanitize_title($s_tour);
		}

		return $arpg;
	}
}

if (!function_exists('cc_custom_tour_page_data_content')) {
	function cc_custom_tour_page_data_content($posts, $max, $c_url) {
		$html = '';

		if (!empty($posts)) {
			foreach ($posts as $item) {
				$thumbnail_id = get_post_thumbnail_id($item->ID);
				$thubnail = mundo_get_attachment_image_src($thumbnail_id, 'tour_another') ?: '';
				$link = (get_the_permalink($item->ID)) ?: '';
				$title = ($item->post_title) ?: '';
				$experts = (get_the_excerpt($item->ID)) ?: '';

				$html .= '<div class="item tour-list-item">
							<article id="post-' . $item->ID . '" class="et_pb_post clearfix post-' . $item->ID . ' ' . $item->post_type . ' type-' . $item->post_type . ' status-publish format-standard has-post-thumbnail hentry category-uncategorized">
								<div class="post-thumbnail">
									<a href="' . $link . '" class="entry-featured-image-url"><img src="' . $thubnail . '" alt="' . $title . '"></a>';

				$label_tour = (wp_get_post_terms($item->ID, 'label_tour')) ?: array();
				if (!empty($label_tour)) {
					$html .= '<div class="label_tour">' . $label_tour[0]->name . ' </div>';
				}

				$days = 0;
				$itinerarys = (get_post_meta($item->ID, 'itinerary', true)) ?: array();

				if ($itinerarys) {
					$days = count($itinerarys);
					$day_html = ($days == 1) ? $days . ' ' . __("Day", 'mundo') . ' / 0 ' . __("Night", 'mundo') . '' : $days . ' ' . __("Days", 'mundo') . ' / ' . ($days - 1) . ' ' . __("Nights", 'mundo') . '';
				}

				$html .= '<div class="days"><b>' . $day_html . '</b> </div>';

				$terms = wp_get_post_terms($item->ID, 'travel_style');
				$list_category = '';

				if ($terms) {
					foreach ($terms as $term) {
						$list_category .= $term->name . ' ';
					}
				}

				$taxonomy_name = get_query_var('taxonomy_name');
				$term_name = get_query_var('term_name');
				$terms = wp_get_post_terms($item->ID, 'travel_style');
				$terms = get_terms(array(
					'taxonomy' => $taxonomy_name,
					'hide_empty' => false,
					'slug' => $term_name,
				));

				$html .= '</div>
							<div class="post_content">
							<h2 class="entry-title content"><a href="' . $link . '">' . $title . '</a></h2><div><p>' . $experts . '</p>';

				$departure_dates = (get_post_meta($item->ID, 'departure_date', true)) ?: array();
				$departure_date_text = '';

				$i = 1;

				if ($departure_dates) {
					foreach ($departure_dates as $departure_date) {
						if ($i > 3) {
							continue;
						}

						$departure_date_fm = date('d M', $departure_date['date']['timestamp']);

						if ($i == 3) {
							$departure_date_text .= $departure_date_fm . ' ... ';
						} else {
							$departure_date_text .= $departure_date_fm . ' / ';
						}

						$i += 1;
					}
				}

				$route = (get_post_meta($item->ID, 'route', true)) ?: '';
				$html .= '<div class="route content"><b>' . str_replace(",", " - ", $route) . '</b></div>';

				$highlight_city = (get_post_meta($item->ID, 'highlight_city', true)) ?: '';
				$html .= '<div class="highlight_city content"><b>' . __("Highlights", 'mundo') . ' : </b> <b class="text_gray">' . $highlight_city . '</b> </div></div></div><hr>';

				$discount_price = get_post_meta($item->ID, 'discount_price', true);
				$text_gray = '';
				$discount = 'price';

				$discount_price_html = '';
				if ($discount_price) {
					$discount_price_html = '<b class="discount_price"> $' . $discount_price . 'pp </b>';
					$text_gray = 'text_gray';
					$discount = 'discount';
				}

				//lay ham gia 6 thang gần nhất.
				$price = mundo_get_price_last_6_month($item->ID);

				if ($price) {
					$lang = pll_current_language();
					$price = (intval($price)) ? mundo_exchange_rate($price, $lang) : $price;
					$price_html = (intval($price)) ? '<b class="' . $discount . ' ' . $text_gray . '">$' . $price . ' </b> <b class=" ' . $discount . ' text_gray ">pp</b>' : '<b class="' . $discount . ' ' . $text_gray . '">' . $price . ' </b>';
				} else {
					$price_html = '<b class="price">' . __('On Request', 'mundo') . '</b>';
				}

				$from = $price == 'On request' && empty($discount_price) ? __("Price", 'mundo') . ': ' : __("From", 'mundo') . ': ';

				$html .= '<div class="row content"><div class = "col-lg-7 col-md-6"><b class="text_gray">' . $from . '</b>' . $discount_price_html . $price_html . '</div>';
				$html .= '<div class=" col-lg-5 col-md-6 view-tour"><a class="more-link" href="' . $link . '">' . __("View tour", 'mundo') . '</a></div></div></article></div>';

			}

			if ($max >= 2) {
				$html .= cc_tour_pagination(array('max_pages' => $max, 'current_url' => $c_url));
			}
		} else {
			$html = esc_html__('No result founds', 'mundo');
		}

		echo $html;
	}
}

/*
 * Generate pagination
 */
if (! function_exists('cc_tour_pagination')) {
	function cc_tour_pagination($args = array()) {
		if (is_front_page() || is_home()) {
			$paged	= (get_query_var('paged')) ? intval(get_query_var('paged')) : intval(get_query_var('page'));
		} else if (is_single()) {
			$paged	= (get_query_var('paged')) ? intval(get_query_var('paged')) : intval(get_query_var('page'));
		} else {
			$paged	= intval(get_query_var('paged'));
		}

		$paged			= $paged ? $paged : 1;
		$pagenum_link	= html_entity_decode(get_pagenum_link());

		if (defined('WP_ADMIN') && WP_ADMIN) {
			$pagenum_link	= $args['current_url'];
		}

		$query_args		= array();
		$url_parts		= explode('?', $pagenum_link);

		if (isset($url_parts[1])) {
			wp_parse_str($url_parts[1], $query_args);
		}

		$pagenum_link	= remove_query_arg(array_keys($query_args), $pagenum_link);
		$pagenum_link	= trailingslashit($pagenum_link) . '%_%';

		$format	= $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos($pagenum_link, 'index.php') ? 'index.php/' : '';

		if (is_single()) {
			$format	.= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit('%#%', 'paged') : '?paged=%#%';
		} else {
			$format	.= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit('page/%#%', 'paged') : '?paged=%#%';
		}

		if (is_single() && $paged > 1) {
			$page_arr	= explode('/', $pagenum_link);
			$str_p		= count($page_arr) - 2;
			unset($page_arr[ $str_p ]);

			$pagenum_link	= implode('/', $page_arr);
		}

		$links = paginate_links(array(
			'base'		=> $pagenum_link,
			'format'	=> $format,
			'total'		=> $args['max_pages'],
			'current'	=> $paged,
			'mid_size'	=> 1,
			'type'		=> 'array',
			'add_args'	=> array_map('urlencode', $query_args),
			'prev_text'	=> esc_html__('Prev', 'mundo'),
			'next_text'	=> esc_html__('Next', 'mundo'),
		));

		if ($links) {
			$output	= '<div class="clear"></div>';
			$output	.= '<nav class="cc-pagination">';
			$output	.= '<div class="cc-shadow">';

			foreach ($links as $link) {
				$output	.= $link;
			}

			$output	.= '</div>';
			$output	.= '</nav>';
		}

		return $output;
	}
}
add_filter('post_row_actions', function($actions, $post) {
if ($post->post_type=='destination'){
  $url = add_query_arg( array(
    'post' => $post->ID,
    'action' => 'edit',
    'type' => 'excursion'
  ), admin_url( 'post.php' ) );

  $actions['xem_phong'] = '<a href="'.$url.'" title="">'.__('Edit excursion').'</a>';
}
return $actions;
}, 10, 2);


add_filter( 'admin_body_class', function ( $classes ) {
    if ($_GET['type']=='excursion') {
        return "$classes admin_excursion admin_destination_body";
    }
    global $post;
    if ($post->post_type=='destination') {
        return "$classes admin_destination_body";
    }
} );
add_action('admin_enqueue_scripts', function()
{
    wp_enqueue_style('admin-css', plugins_url('mundo/css/mundo-admin.css'), array(), rand());
});
add_filter( 'woocommerce_display_item_meta',function($html, $item, $args){
    $time = __('time','mundo');
    $adult = __('adult','mundo');
    $language = __('language','mundo');
    $flight = __('flight','mundo');
    $html = str_replace('time', $time, $html);
    $html = str_replace('adult', $adult, $html);
    $html = str_replace('language', $language, $html);
    $html = str_replace('flight', $flight, $html);
    return $html;
} ,10,3 ); 