<?php 

/**
 * Plugin Name: Mundo booking
 * Plugin URI: http://liva.com.vn/plugins/mundo-booking
 * Description: mundo booking 
 * Version: 1.0.0
 * Author: LIVA
 * Author URI: https://liva.com.vn
 */
 if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
add_action('init', function(){
  require_once (WP_PLUGIN_DIR.'/mundo-booking/class-wc-product-mundo.php');
  
  //add product
  add_filter('woocommerce_product_class', function ($classname) {
      return 'WC_Product_Mundo';
    }, 10, 1); 
});
function mundo_get_product(  $tour_id, $tag_name, $tour_price){
    return new WC_Product_Mundo($tour_id,$tag_name, $tour_price);
   // return WC()->product_factory->get_product( $postID);
  }
add_shortcode('cus-name',function(){
    return $_GET['cus-name'];
});
add_action('wp_ajax_nopriv_booking_from_home', 'mundo_booking_from_home');
add_action('wp_ajax_booking_from_home', 'mundo_booking_from_home');
function mundo_booking_from_home(){
     foreach($_POST['form_search_home'] as $value){
        if($value['name'] == 'destination[]'){
            $destination[] = $value['value'];
            
        }
        if($value['name'] == 'travel_style[]'){
            $travel_style[] = $value['value'];

        }
        if($value['name'] == 'date_tour'){
            $date_tour = $value['value'];
        }
    }
    $travel_style = implode(', ', $travel_style);
    $destination = implode(', ', $destination);
    
    if(!empty($_POST['form_contact'])){
        foreach ($_POST['form_contact'] as $value){
            if($value['name']=='et_pb_contact_name_1'){
                $contact['name'] = $value['value'];
            } 
            if($value['name']=='et_pb_contact_email_1'){
                $contact['email'] = $value['value'];
            } 
            if($value['name']=='et_pb_contact_phone_1'){
                $contact['phone'] = $value['value'];
            } 
            if($value['name']=='et_pb_contact_content_1'){
                $contact['content'] = $value['value'];
            } 
        }
    }
    //print_r($_POST['form_contact']);exit();
    //save order
    $address = array(
        'first_name' => sanitize_text_field($contact['name']),
        'test'  => 'test',
        'company'    => '',
        'email'      => sanitize_text_field($contact['email']),
        'phone'      => sanitize_text_field($contact['phone']),
        'address_1'  => '',
        'address_2'  => '',
        'city'       => '',
        'state'      => '',
        'postcode'   => sanitize_text_field($contact['content']),
        'country'    => '',
    );
    $woo_order = wc_create_order(); 
    $order_id = $woo_order->ID; 
    
    //add_product: $int = WC_Abstract_Order::add_product( $product, $qty, $args );
    $item_id = $woo_order->add_product( mundo_get_product($post_id,'contact', 0 ), 1, array() );
    wc_add_order_item_meta($item_id, 'destination', $destination );  
    wc_add_order_item_meta($item_id, 'travel_style', $travel_style );
    wc_add_order_item_meta($item_id, 'date_tour', $date_tour );
    $woo_order->set_address( $address, 'billing' );
    $woo_order->update_status('wc-completed', 'Booking was completed', TRUE);
    $url = add_query_arg(
        array(
            'cus-name' => sanitize_text_field($contact['name']),
        ),
        home_url('finish-booking')
    );
    $current_lang = pll_current_language();
    switch ($current_lang) {
            case 'en':
                $url = add_query_arg(
                    array(
                        'cus-name' => sanitize_text_field($contact['name']),
                    ),
                    home_url('finish-booking')
                );
                break;
            case 'es':
                $url = add_query_arg(
                    array(
                        'cus-name' => sanitize_text_field($contact['name']),
                    ),
                    home_url('finalizar-la-reserva ')
                );
                break;
            case 'pt':
                $url = add_query_arg(
                    array(
                        'cus-name' => sanitize_text_field($contact['name']),
                    ),
                    home_url('terminar-reserva')
                );
                break;
            default:
                $url = add_query_arg(
                    array(
                        'cus-name' => sanitize_text_field($contact['name']),
                    ),
                    home_url('terminar-reserva')
                );
                break;
        }
    echo json_encode(array(
        'error' => 0,
        'mess' => '',
        'href' => $url,
    ));
    exit();
}
//xu ly ajax cho booking
//xu ly ajax cho booking
add_action('wp_ajax_nopriv_booking_sic_tour', 'mundo_booking_sic_tour');
add_action('wp_ajax_booking_sic_tour', 'mundo_booking_sic_tour');
function mundo_booking_sic_tour(){
    foreach($_POST['form_tour_infor'] as $value){
        if($value['name'] == 'post_id'){
            $post_id = $value['value'];
        }
        if($value['name'] == 'date_from'){
            $time = $value['value'];

        }
        if($value['name'] == 'adult'){
            $adult = $value['value'];
        }
    }
    // lay available cua tour
    $departings = get_post_meta($post_id,'departure_date',true);
    foreach($departings as $departing){
       // print_r($time);
//        print_r($departing['date']['timestamp']);
        if($departing['date']['timestamp'] == $time){
            if($departing["status"][0]== 'full'){
                echo json_encode(array(
                    'error' => 1,
                    'mess' => __('Tour is not available'). '[code:11]',
                ));
                 exit();
            }
        }
    }
    if(!empty($_POST['form_contact'])){
        foreach ($_POST['form_contact'] as $value){
            if($value['name']=='et_pb_contact_your_name_1'){
                $contact['name'] = $value['value'];
            } 
            if($value['name']=='et_pb_contact_email_address_1'){
                $contact['email'] = $value['value'];
            } 
            if($value['name']=='et_pb_contact_phone_number_1'){
                $contact['phone'] = $value['value'];
            } 
            if($value['name']=='et_pb_contact_content_1'){
                $contact['content'] = $value['value'];
            } 
            if($value['number_pax']=='et_pb_contact_contact-number-people_1'){
                $contact['number_pax'] = __('Number of pax','mundo-booking').':'. $value['value'];
            }
        }
    }
    //save order
    $address = array(
        'first_name' => sanitize_text_field($contact['name']),
        'test'  => 'test',
        'company'    => '',
        'email'      => sanitize_text_field($contact['email']),
        'phone'      => sanitize_text_field($contact['phone']),
        'address_1'  => '',
        'address_2'  => '',
        'city'       => '',
        'state'      => sanitize_text_field($contact['number_pax']),
        'postcode'   => sanitize_text_field($contact['content']),
        'country'    => '',
    );
    $woo_order = wc_create_order(); 
    $order_id = $woo_order->ID; 
    
    
    //lay gia cua tung nguoi
    $price_per_person = mundo_get_sic_price($post_id, $time);
    //add_product: $int = WC_Abstract_Order::add_product( $product, $qty, $args );
    $item_id = $woo_order->add_product( mundo_get_product($post_id,'SIC tour', $price_per_person ), $adult, array() );
    $time = date('d/m/Y', $time);
    wc_add_order_item_meta($item_id, 'time', $time );  
    wc_add_order_item_meta($item_id, 'adult', $adult );
    $woo_order->calculate_totals();
    $woo_order->set_address( $address, 'billing' );
    $woo_order->update_status('wc-completed', 'Booking was completed', TRUE);
    $url = add_query_arg(
        array(
            'cus-name' => sanitize_text_field($contact['name']),
        ),
        home_url('finish-booking')
    );
    $current_lang = pll_current_language();
    switch ($current_lang) {
            case 'en':
                $url = add_query_arg(
                    array(
                        'cus-name' => sanitize_text_field($contact['name']),
                    ),
                    home_url('finish-booking')
                );
                break;
            case 'es':
                $url = add_query_arg(
                    array(
                        'cus-name' => sanitize_text_field($contact['name']),
                    ),
                    home_url('finalizar-la-reserva ')
                );
                break;
            case 'pt':
                $url = add_query_arg(
                    array(
                        'cus-name' => sanitize_text_field($contact['name']),
                    ),
                    home_url('terminar-reserva')
                );
                break;
            default:
                $url = add_query_arg(
                    array(
                        'cus-name' => sanitize_text_field($contact['name']),
                    ),
                    home_url('terminar-reserva')
                );
                break;
        }
    echo json_encode(array(
        'error' => 0,
        'mess' => '',
        'href' => $url,
    ));
    exit();
}




add_action('wp_ajax_nopriv_booking_customize_tour', 'mundo_booking_customize_tour');
add_action('wp_ajax_booking_customize_tour', 'mundo_booking_customize_tour');
function mundo_booking_customize_tour(){
     foreach($_POST['form_tour_infor'] as $value){
        if($value['name'] == 'post_id'){
            $post_id = $value['value'];
        }
        if($value['name'] == 'month'){
            $time = $value['value'];
        }
        if($value['name'] == 'adult'){
            $adult = $value['value'];
        }
        if($value['name'] == 'language'){
            $language = $value['value'];
        }
        if($value['name'] == 'flight'){
            $flight = $value['value'];
        }
    }
    
    
    if(!empty($_POST['form_contact'])){
        foreach ($_POST['form_contact'] as $value){
            if($value['name']=='et_pb_contact_your_name_1'){
                $contact['name'] = $value['value'];
            } 
            if($value['name']=='et_pb_contact_email_address_1'){
                $contact['email'] = $value['value'];
            } 
            if($value['name']=='et_pb_contact_phone_number_1'){
                $contact['phone'] = $value['value'];
            } 
            if($value['name']=='et_pb_contact_content_1'){
                $contact['content'] = $value['value'];
            } 
        }
    }
    //save order
    $address = array(
        'first_name' => sanitize_text_field($contact['name']),
        'test'  => 'test',
        'company'    => '',
        'email'      => sanitize_text_field($contact['email']),
        'phone'      => sanitize_text_field($contact['phone']),
        'address_1'  => '',
        'address_2'  => '',
        'city'       => '',
        'state'      => '',
        'postcode'   => sanitize_text_field($contact['content']),
        'country'    => '',
    );
    $woo_order = wc_create_order(); 
    $order_id = $woo_order->ID; 
    
   
    //lay gia cua tung nguoi
    $price_per_person = mundo_calculate_customize_price_per_person($post_id, $time, $adult, $language, $flight);
    $price_per_person = get_price_usd($price_per_person);
    //add_product: $int = WC_Abstract_Order::add_product( $product, $qty, $args );
    $item_id = $woo_order->add_product( mundo_get_product($post_id, "Customize tour",$price_per_person ), $adult, array() );
    wc_add_order_item_meta($item_id, 'time', $time );  
    wc_add_order_item_meta($item_id, 'adult', $adult );
    // language lay ten ngon ngu ra
    $language_term = get_term($language,'tour_guide');
    wc_add_order_item_meta($item_id, 'language', pll__($language_term->name) );
    wc_add_order_item_meta($item_id, 'flight', $flight );
    $woo_order->calculate_totals();
    $woo_order->set_address( $address, 'billing' );
    $woo_order->update_status('wc-completed', 'Booking was completed', TRUE);
    $current_lang = pll_current_language();
    $url = add_query_arg(
        array(
            'cus-name' => sanitize_text_field($contact['name']),
        ),
        home_url('finish-booking')
    );
    switch ($current_lang) {
            case 'en':
                $url = add_query_arg(
                    array(
                        'cus-name' => sanitize_text_field($contact['name']),
                    ),
                    home_url('finish-booking')
                );
                break;
            case 'es':
                $url = add_query_arg(
                    array(
                        'cus-name' => sanitize_text_field($contact['name']),
                    ),
                    home_url('finalizar-la-reserva ')
                );
                break;
            case 'pt':
                $url = add_query_arg(
                    array(
                        'cus-name' => sanitize_text_field($contact['name']),
                    ),
                    home_url('terminar-reserva')
                );
                break;
            default:
                $url = add_query_arg(
                    array(
                        'cus-name' => sanitize_text_field($contact['name']),
                    ),
                    home_url('terminar-reserva')
                );
                break;
        }
    echo json_encode(array(
        'error' => 0,
        'mess' => '',
        'href' => $url,
    ));
    exit();
}

//form booking sic
add_shortcode('form_booking_sic', function(){
    $post_id = $_GET['post_id'];
    $get_date_from = $_GET['date_from'];
    $get_adult = $_GET['adult'];
    //d($get_adult);
    $current_lang = pll_current_language();
    switch ($current_lang) {
            case 'en':
                $url = add_query_arg(
                    array(
                        'cus-name' => sanitize_text_field($contact['name']),
                    ),
                    home_url('finish-booking')
                );
                break;
            case 'es':
                $url = add_query_arg(
                    array(
                        'cus-name' => sanitize_text_field($contact['name']),
                    ),
                    home_url('finalizar-la-reserva ')
                );
                break;
            case 'pt':
                $url = add_query_arg(
                    array(
                        'cus-name' => sanitize_text_field($contact['name']),
                    ),
                    home_url('terminar-reserva')
                );
                break;
            default:
                $url = add_query_arg(
                    array(
                        'cus-name' => sanitize_text_field($contact['name']),
                    ),
                    home_url('terminar-reserva')
                );
                break;
        }
    $form = ' <form name="frm_sic_tour" id="form_sic_tour">
        <input type="hidden" name="href" value='.$url.'>
        <input type="hidden" name="post_id" class="post-id-book" value='.$post_id.'>
        <input type="hidden" name="date_from" class="date-from-book" value='.$get_date_from.'>
        <input type="hidden" name="adult" class="adult-book" value='.$get_adult.'>
        </from>
        ';
    return $form;
    }
);
//form booking customize tour
add_shortcode('form_booking_customize', function(){
    $post_id = $_GET['post_id'];
    $get_month = $_GET['month'];
    $get_adult = $_GET['adult'];
    $get_language = $_GET['language'];
    $get_flight = $_GET['flight'];
    $tour_guides = wp_get_post_terms($post_id,'tour_guide',array());
    //lay tour guide cho truong Language cua form
    $lang_num = 0;
    if(!empty($tour_guides)){
        $lang_select = '<select class="language_select" name="language">';
        foreach($tour_guides as $tour){
            $selected = ($tour->term_id==$get_language)?'selected':'';
            $lang_select .= '<option value="'.$tour->term_id.'" '.$selected.'>'.pll__($tour->name).'</option>' ;
            $lang_num++;
        };
        $lang_select .= '</select>';
    }
    if(!empty($tour_guides) && $lang_num == 1){//Nếu chỉ có 1 ngôn ngữ thì ô select ko cho chọn
        $lang_select = '<select class="language_select select-readonly" name="language" readonly>';
        foreach($tour_guides as $tour){
                    $lang_select .= '<option value="'.$tour->term_id.'">'.pll__($tour->name).'</option>' ;
                };
        $lang_select .= '</select>';
        $only_lang = 'only_lang';
    }
    //lay thang 
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
    //lay ngay thang hien tai
    //$current_month_stm = strtotime($current_month)/60/60/24/365;
    //xet khoang gia lay cac thang sap xep theo thu tu tu thap den cao
    $months = array();
    $custom_rates = get_post_meta($custom_rate_posts[0]->ID,'group_tour_rate',true);
    foreach ($custom_rates as $custom_rate){
        $from_date = $custom_rate['from_date']['timestamp'];
        $to_date =  $custom_rate['to_date']['timestamp'];
        if($to_date <  time()){
            continue;
        }
        $from_date = ($from_date< time())?time():$from_date;
        for ($i = $from_date; $i < $to_date; $i = strtotime('+1 month', $i)){
                $months[date('m_Y', $i)] = date('M Y',$i);
        
        } 
        
    }
  
    //$month_select = '<select class="month_select" name="month">';
//    foreach($months as $key => $month){
//        $selected = ($key==$get_month)?'selected':'';
//        $month_select .= '<option value="'.$key.'" '.$selected.'>'.$month.'</option>' ;
//    };
//    $month_select .= '</select>';
    $on_request = mundo_calculate_customize_price_per_person($post->ID, $min_date, 2, $tour_lang_main, 'no');
    $on_request = $on_request?:'on_request_calender';
    $month_select = '<input type="text" name="month" class="month_select '.$on_request.'" value="'.$_GET['month'].'">';  
    //lay so luong nguoi
    $adult = (get_post_meta($post_id,'number_of_tourists',true))?:0;
    $adult_select = '<select class="adult_select" name="adult">';
    for( $i=1; $i <= 14; $i++){
                $selected = ($i==$get_adult)?'selected':'';
                $adult_select .= '<option value="'.$i.'" '.$selected.'>'.$i.'</option>' ;
            };
    $adult_select .= '</select>';
    
    // co tinh gia flight
    $selected_no = ($get_flight == 'no')?'selected':'';
    $selected_yes = ($get_flight == 'yes')?'selected':'';
    $flight_select = '<select class="flight_select" name="flight">
                        <option value="no" '.$selected_no.'>'.__("No","mundo-booking").'</option>
                        <option value="yes" '.$selected_yes.'>'.__("Yes","mundo-booking").'</option>
                    </select>';
    $bottom_text_form = ot_get_option('bottom_text_form');
    // tinh tin tren 1 ng
    $price_per_person = mundo_calculate_customize_price_per_person($post_id, $get_month, $get_adult, $get_language, $get_flight);
    $total_price = $price_per_person*2;
    $total_price_show =  $total_price ? ' ' :'display_none';
    $symbol_exchange = '$';
    if (isset($_COOKIE['exchange_rate'])){
        $exchange_rate_string = $_COOKIE['exchange_rate'];
        $exchange_rate_cookie = explode("-",$exchange_rate_string); 
        $exchange_detail = $exchange_rate_cookie[2];
        $symbol_exchange = $exchange_rate_cookie[1];
    }
    $total_price = $total_price ?$symbol_exchange.$total_price:__('On Request','Mundo');
    
    $price_per_person = $price_per_person ? $symbol_exchange.$price_per_person : __('On Request','Mundo'); 
    $current_lang = pll_current_language();
    switch ($current_lang) {
            case 'en':
                $url = add_query_arg(
                    array(
                        'cus-name' => sanitize_text_field($contact['name']),
                    ),
                    home_url('finish-booking')
                );
                break;
            case 'es':
                $url = add_query_arg(
                    array(
                        'cus-name' => sanitize_text_field($contact['name']),
                    ),
                    home_url('finalizar-la-reserva ')
                );
                break;
            case 'pt':
                $url = add_query_arg(
                    array(
                        'cus-name' => sanitize_text_field($contact['name']),
                    ),
                    home_url('terminar-reserva')
                );
                break;
            default:
                $url = add_query_arg(
                    array(
                        'cus-name' => sanitize_text_field($contact['name']),
                    ),
                    home_url('terminar-reserva')
                );
                break;
        }
    $flight_tour = wp_get_post_terms($post_id,'flight',array());
    $flight_html .= '<ul class="list-filght">';
    foreach ($flight_tour as $key => $value) {
        $flight_html .= '<li>'.$value->name.'</li>';
    }
    $flight_html .= '</ul>';
    $col_month = $flight_tour?'mundo-6-item':'mundo-5-item';
    $col_month = $total_price_show == 'display_none'?'mundo-5-item':'mundo-6-item';
    $form = '
                    <div class="form_cuctomize_tour '.$col_month.'">
                    <form method = "GET" action="'.$url.'" name="frm_customize_tour" id="form_cuctomize_tour" data-post="'.$post_id.'">
                        <input type="hidden" name="post_id" value="'.$post_id.'">
                        <div class="row header"> 
                            <div class="col-md-2 col-sm-2 col-xs-6">'.__('Departure date','Mundo').' </div>
                            <div class="col-md-2 col-sm-2 col-xs-6 show_on_mobile" id="month">'.$month_select.' </div>
                            <div class="col-md-2 col-sm-2 col-xs-6"> '.__('Adult','Mundo').'</div>
                            <div class="col-md-2 col-sm-2 show_on_mobile col-xs-6" id="adult"> '.$adult_select.'</div>
                            <div class="col-md-2 col-sm-2 col-xs-6">'.__('Language','Mundo').' 
                                
                                <i class="fa fa-question-circle mundo-tooltip-head" aria-hidden="true" data-icon="u"  data-toggle="modal" data-target="#myModal_lang"></i>
                                  <!-- Modal -->
                                  <div class="modal fade mundo-tooltip" id="myModal_lang" role="dialog">
                                    <div class="modal-dialog">
                                    
                                      <!-- Modal content-->
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <h4 class="modal-title">'.__('Language','Mundo').'</h4>
                                        </div>
                                        <div class="modal-body">
                                          '.ot_get_option('tooltip_language').'
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-default" data-dismiss="modal">'.__('Close','Mundo').'</button>
                                        </div>
                                      </div>
                                      
                                    </div>
                                  </div> <!-- Modal -->
                            </div>';
                    $form        .='<div class="col-md-2 col-sm-2 col-xs-6 '.$only_lang.' show_on_mobile" id="language" > '.$lang_select.'</div>';
                    if($flight_tour){//Nếu có bay thì mới vẽ
                    $form .=    '<div class="col-md-2 col-sm-2 col-xs-6"> '.__('Flight','Mundo').'
                               
                                <i class="fa fa-question-circle mundo-tooltip-head" aria-hidden="true" data-icon="u"  data-toggle="modal" data-target="#myModal"></i>
                                  <!-- Modal -->
                                  <div class="modal fade mundo-tooltip" id="myModal" role="dialog">
                                    <div class="modal-dialog">
                                    
                                      <!-- Modal content-->
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <h4 class="modal-title">'.__('Flight','Mundo').'</h4>
                                        </div>
                                        <div class="modal-body">
                                          '.ot_get_option('tooltip_flight').$flight_html.'<div class="clear-both"></div>
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-default" data-dismiss="modal">'.__('Close','Mundo').'</button>
                                        </div>
                                      </div>
                                      
                                    </div>
                                  </div> <!-- Modal -->
                            </div>';
                            $form .='<div class="col-md-2 col-sm-2 col-xs-6 show_on_mobile" id="flight"> '.$flight_select.'</div>';
                    }
                    $sub_price = $symbol_exchange=='$'?' ':' ('.$price_per_person.')';
                    $sub_price_total = $symbol_exchange=='$'?' ':'('.$total_price.')';
                    $form .= '<div class="col-md-2 col-sm-2 col-xs-6"> '.__('Per person','Mundo').'</div>
                            <div class="col-md-2 col-sm-2 col-xs-6 show_on_mobile" id="per_person"> $'.get_price_usd($price_per_person).$sub_price.'</div>
                            <div class="col-md-2 col-sm-2 col-xs-6 '.$total_price_show.'"> '.__('Total','Mundo').' </div>
                            <div class="col-md-2 col-sm-2 col-xs-6 show_on_mobile '.$total_price_show.'" id="total">$'.get_price_usd($total_price).$sub_price_total.'</div>
                        </div>
                        <div class="row value show_on_desktop">
                            <div class="col-md-2 col-sm-2 show_on_desktop" id="month">'.$month_select.' </div>
                            <div class="col-md-2 col-sm-2 show_on_desktop" id="adult"> '.$adult_select.'</div>
                            <div class="col-md-2 col-sm-2 '.$only_lang.' show_on_desktop" id="language" > '.$lang_select.'</div>';
                            if($flight_tour){
                                $form .='<div class="col-md-2 col-sm-2 show_on_desktop" id="flight"> '.$flight_select.'</div>';
                            }
                            $form .='<div class="col-md-2 col-sm-2 show_on_desktop" id="per_person"> $'.get_price_usd($price_per_person).$sub_price.'</div>
                            <div class="col-md-2 col-sm-2 show_on_desktop '.$total_price_show.'" id="total">$'.get_price_usd($total_price).$sub_price_total.'</div>
                        </div>
                        <div class="bottom_text_form text_center text_gray"><span>* </span>'.__($bottom_text_form).'</div>
                        
                    </form>
                    </div>
                    <hr class="finish-booking-hr">
                    ';
    return $form;
});