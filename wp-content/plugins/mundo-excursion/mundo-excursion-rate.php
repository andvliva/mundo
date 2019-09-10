<?php

add_action( 'save_post_excursion_private', function($post_id, $post, $update) {
    
    if( !empty($_POST) ) {
        $private_excursion_rate = get_post_meta( $post_id, 'private_excursion_rate', true ) ?: array();
        //check full date
        $full_rate = array_filter( $private_excursion_rate, function( $value ) {
            return $value['check_full'];
        } );
        $excursion = get_post_meta( $post_id, 'excursion_name', true ) ?: 0;
        $to_day = strtotime();
        $full_date = array();
        foreach( $full_rate as $value ) {
            $t1 = $value['from_date']['timestamp'];
            $t2 = $value['to_date']['timestamp'];
            
            for( $i = $t1; $i <= $t2; $i+=86400 ) {
                if( $i >= $to_day ) {
                    $d = date('Y-m-d', $i);
                    $full_date[$d] = $d;
                }
            }
        }
        update_post_meta( $excursion, '_full_date_private', $full_date );

        //check max date
        $max = 0;
        foreach( $private_excursion_rate as $value ) {
            if( $value['to_date']['timestamp'] > $max ) {
                $max = $value['to_date']['timestamp'];
            }
        }
        update_post_meta( $excursion, '_max_date_private', $max );
    }

}, 10, 3 );

add_action( 'save_post_excursion_group', function($post_id, $post, $update) {
    
    if( !empty($_POST) ) {
        $group_rate = get_post_meta( $post_id, 'group_rate', true ) ?: array();
        //check full date
        $full_rate = array_filter( $group_rate, function( $value ) {
            return $value['check_full'];
        } );
        $excursion = get_post_meta( $post_id, 'excursion_name', true ) ?: 0;
        $to_day = strtotime();
        $full_date = array();
        foreach( $full_rate as $value ) {
            $t1 = $value['from_date']['timestamp'];
            $t2 = $value['to_date']['timestamp'];
            
            for( $i = $t1; $i <= $t2; $i+=86400 ) {
                if( $i >= $to_day ) {
                    $d = date('Y-m-d', $i);
                    $full_date[$d] = $d;
                }
            }
        }

        update_post_meta( $excursion, '_full_date_group', $full_date );

        //check max date
        $max = 0;
        foreach( $group_rate as $value ) {
            if( $value['to_date']['timestamp'] > $max ) {
                $max = $value['to_date']['timestamp'];
            }
        }
        update_post_meta( $excursion, '_max_date_group', $max );
    }

}, 10, 3 );

function excursion_get_default_date( $timest, $full_date, $max_date, $day_enable ) {
    $d = date('Y-m-d', $timest);
    $N = date('N', $timest);
    $day_enable = array_filter( $day_enable );

    if( $full_date && in_array( $d, $full_date ) ) {
        $timest += 86400;
        return excursion_get_default_date( $timest, $full_date, $max_date, $day_enable );
    }
    elseif( $max_date && $timest > strtotime($max_date) ) {
        return 0;
    }
    elseif( $day_enable && !in_array( $N, $day_enable ) ) {
        $timest += 86400;
        return excursion_get_default_date( $timest, $full_date, $max_date, $day_enable );
    }

    return $timest;
}

function excursion_get_price_min( $post_id, $type = 'group', $from_date = null, $to_date = null ) {
    static $cache;
    if( $from_date == null ) {
        $from_date = strtotime( date('Y/m/d') ) + 86400;
    }
    if( $to_date == null ) {
        $to_date = $from_date + ( 60*86400 );
    }
    if( !empty( $cache[$post_id][$type][$from_date][$to_date] ) ) {
        return $cache[$post_id][$type][$from_date][$to_date];
    }
    if( $type == 'group' ) {
        $args = array(
            'post_type' => 'excursion_group',
            'post_status' => 'publish',
            'numberposts' => 1,
            'fields' => 'ids',
            'meta_query' => array(
                'excursion_name' => array( 'key' => 'excursion_name', 'value' => $post_id ),
            ),
        );
        $posts_rate = get_posts($args);
        $rate_id = reset($posts_rate);
        $group_rate = get_post_meta( $rate_id, 'group_rate', true ) ?: array();
        $min = array();
        foreach( $group_rate as $values ) {
            if( isset($values['check_full']) && $values['check_full'] ) {
                continue;
            }

            $f = $values['from_date']['timestamp'];
            $t = $values['to_date']['timestamp'];

            
            if( $from_date >= $f && $to_date <= $t ) {
                for( $i = $from_date; $i <= $to_date; $i += 86400 ) {
                    $min[$i] = 1 * $values['adult'];
                }
                break;
            }
            elseif( $from_date < $t && $to_date >= $t ) {
                for( $i = $from_date; $i <= $t; $i += 86400 ) {
                    $min[$i] = 1 * $values['adult'];
                }
            }
            elseif( $to_date > $f && $to_date <= $t ) {
                for( $i = $f; $i <= $to_date; $i += 86400 ) {
                    $min[$i] = 1 * $values['adult'];
                }
            }
        }
        $min = array_unique( $min );
        if (!empty($min)) {
            $min_p = min($min);
            $min_t = array_search( $min_p, $min );
            $cache[$post_id][$type][$from_date][$to_date] = array( 't' => $min_t, 'p' => $min_p );
            return $cache[$post_id][$type][$from_date][$to_date];
        }
        
        
    }
    elseif( $type == 'private' ) {
        $args = array(
            'post_type' => 'excursion_private',
            'post_status' => 'publish',
            'numberposts' => 1,
            'fields' => 'ids',
            'meta_query' => array(
                'excursion_name' => array( 'key' => 'excursion_name', 'value' => $post_id ),
            ),
        );
        $posts_rate = get_posts($args);
        $rate_id = reset($posts_rate);
        $private_rates = get_post_meta( $rate_id, 'private_excursion_rate', true ) ?: array();
        $min = array();
        if ( !empty($private_rates) ) {
            foreach( $private_rates as $values ) {
                if( isset($values['check_full']) && $values['check_full'] ) {
                    continue;
                }
                $f = $values['from_date']['timestamp'];
                $t = $values['to_date']['timestamp'];
                
                foreach( $values['private_rate'] as $value2 ) {
                    if( $value2['from'] <= 2 && $value2['to'] >= 2 ) {
                        if( $from_date >= $f && $to_date <= $t ) {
                            for( $i = $from_date; $i <= $to_date; $i += 86400 ) {
                                $min[$i] = 1 * $value2['adult'];
                            }
                            break;
                        }
                        elseif( $from_date < $t && $to_date >= $t ) {
                            for( $i = $from_date; $i <= $t; $i += 86400 ) {
                                $min[$i] = 1 * $value2['adult'];
                            }
                            //break;
                        }
                        elseif( $to_date > $f && $to_date <= $t ) {
                            for( $i = $f; $i <= $to_date; $i += 86400 ) {
                                $min[$i] = 1 * $value2['adult'];
                            }
                            //break;
                        }
                    }
                }
            }
        }
        $min = array_unique( $min );
        if (!empty($min)) {
            $min_p = min($min);
            $min_t = array_search( $min_p, $min );

            $cache[$post_id][$type][$from_date][$to_date] = array( 't' => $min_t, 'p' => $min_p );
            return $cache[$post_id][$type][$from_date][$to_date];
        }
        
    }
    
    return array( 't' => 0, 'p' => 0 );
}

function excursion_get_price( $post_id, $type = 'group', $check_in_date, $total_participants = 0 ) {
    $check_in_date = strtotime($check_in_date);
    
    if( $type == 'group' ) {
        $args = array(
            'post_type' => 'excursion_group',
            'post_status' => 'publish',
            'numberposts' => 1,
            'fields' => 'ids',
            'meta_query' => array(
                'excursion_name' => array( 'key' => 'excursion_name', 'value' => $post_id ),
            ),
        );
        $posts_rate = get_posts($args);
        $rate_id = reset($posts_rate);
        $group_rate = get_post_meta( $rate_id, 'group_rate', true ) ?: array();
        //loc theo ngay check in
        $rate = array_filter( $group_rate, function( $values ) use ( $check_in_date ) {
            if( $values['check_full'] ) {
                return false;
            }
            return !empty( $values['from_date']['timestamp'] ) && !empty( $values['to_date']['timestamp'] ) && ( $check_in_date >= $values['from_date']['timestamp'] && $check_in_date <= $values['to_date']['timestamp'] );
        } );
        return reset($rate);
    }
    elseif( $type == 'private' && $total_participants ) {
        $args = array(
            'post_type' => 'excursion_private',
            'post_status' => 'publish',
            'numberposts' => 1,
            'fields' => 'ids',
            'meta_query' => array(
                'excursion_name' => array( 'key' => 'excursion_name', 'value' => $post_id ),
            ),
        );
        $rates = get_posts($args);
        //print_r($rates);
        $rate_id = reset($rates);
        
        $private_rates = get_post_meta( $rate_id, 'private_excursion_rate', true ) ?: array();
        //Loc theo ngay check in va tong so nguoi
        $private_rates = array_filter( $private_rates, function( &$values ) use ( $check_in_date, $total_participants ) {
            if( isset($values['check_full']) && $values['check_full'] ) {
                return false;
            }
            $t1 = !empty( $values['from_date']['timestamp'] ) ? $values['from_date']['timestamp'] : 0;
            $t2 = !empty( $values['to_date']['timestamp'] ) ? $values['to_date']['timestamp'] : 0;
            $valid_date = ( $check_in_date >= $values['from_date']['timestamp'] && $check_in_date <= $values['to_date']['timestamp'] );
            $paxs = $values['private_rate'];
            $paxs = array_filter( $paxs, function( $pax ) use ($total_participants) {
                $from = $pax['from'];
                $to = $pax['to'];
                
                return ( $total_participants >= $from && $total_participants <= $to );
            } );
            $values['pax'] = reset($paxs);

            return $valid_date && $paxs;
        } );

        $private_rate = reset($private_rates);
        $rate_pax = array();
        foreach( $private_rate['private_rate'] as $item ) {
            for( $i = $item['from']; $i <= $item['to']; $i++ ) {
                $rate_pax[$i] = $item;
            }
        }
        $private_rate['pax'] = $rate_pax;
        return $private_rate;
    }
    return false;
}

function excursion_calc_price( $rate, $type, $adult, $youth=0, $children=0, $infant=0 ) {
    $data = array();
    if( $type == 'group' ) {
        $data['price_info'][] = sprintf('%s/person', '$'.$rate['adult']);
        $data['a'] = $rate;

        $price_adult = $adult * $rate['adult'];
        $price_youth = $youth * $rate['youth'];
        $price_children = $children * $rate['children'];
        $price_infant = 0;

        $data['total_price'] = $price_adult + $price_youth + $price_children + $price_infant;
        
        $data['total_price'] = round( $data['total_price'] );
        
        $data['price_detail'] = array();
        if($price_adult) {
            $data['price_detail'][] = sprintf('<span>'.__("Adult",'mundo-excursion').' x %d x %s</span><span>%s</span>', $adult, '$'.$rate['adult'], '$'.$price_adult);
        }
        if($price_youth) {
            $data['price_detail'][] = sprintf('<span>'.__("Youth",'mundo-excursion').' x %d x %s</span><span>%s</span>', $youth, '$'.$rate['youth'], '$'.$price_youth);
        }
        if($price_children) {
            $data['price_detail'][] = sprintf('<span>'.__("Children",'mundo-excursion').' x %d x %s</span><span>%s</span>', $children, '$'.$rate['children'], '$'.$price_children);
        }
    }
    elseif( $type == 'private' ) {
        
        $price_info = array();
        foreach( $rate['private_rate'] as $item ) {
            $p = $item['adult'];
            $t = ( $item['from'] == $item['to'] ? "{$item['from']} adult" : "{$item['from']} - {$item['to']}" . ' adults' );
            $price_info[] = sprintf('%s: %s/person', $t, $p);
        }
        $data['price_info'] = $price_info;
        
        $data['total_price'] = 0;
        $data['$rate'] = $rate;
        
        $price_adult = $adult * $rate['pax'][$adult]['adult'];
        $price_youth = $youth * $rate['pax'][$adult]['youth'];
        $price_children = $children * $rate['pax'][$adult]['children'];
        $price_infant = 0;//$infant * $rate['pax']['infant'];
        $price_single_sup = !empty($rate['single_supplement']) ? $rate['single_supplement'] / ( $adult +$youth +$children ) : 0;
        $price_english_guide = !empty($rate['english_guide']) ? $rate['english_guide'] / ( $adult +$youth +$children ) : 0;

        $data['total_price'] = $price_adult + $price_youth + $price_children + $price_infant + $price_single_sup + $price_english_guide;
        
        $data['total_price'] = round( $data['total_price'] );
        
        $data['price_detail'] = array();
        if($price_adult) {
            $data['price_detail'][] = sprintf('<span>'.__("Adult",'mundo-excursion').' x %d x %s</span><span>%s</span>', $adult, '$'.$rate['pax'][$adult]['adult'], '$'.$price_adult);
        }
        if($price_youth) {
            $data['price_detail'][] = sprintf('<span>'.__("Youth",'mundo-excursion').' x %d x %s</span><span>%s</span>', $youth, '$'.$rate['pax'][$adult]['youth'], '$'.$price_youth);
        }
        if($price_children) {
            $data['price_detail'][] = sprintf('<span>'.__("Children",'mundo-excursion').' x %d x %s</span><span>%s</span>', $children, '$'.$rate['pax'][$adult]['children'], '$'.$price_children);
        }
        if($price_infant) {
            $data['price_detail'][] = sprintf('<span>Infant x %d x %s</span><span>%s</span>', $infant, '$'.$price_infant, '$'.$price_infant);
        }
        if( $price_single_sup ) {
            $data['price_detail'][] = sprintf('<span>Single supplement x %d x %s</span><span>%s</span>', ($adult +$youth +$children), '$'.$rate['single_supplement'], '$'.$price_single_sup);
        }
        if( $price_english_guide ) {
            $data['price_detail'][] = sprintf('<span>English guide x %d x %s</span><span>%s</span>', ($adult +$youth +$children), '$'.$rate['english_guide'], '$'.$price_english_guide);
        }
    }
    return $data;
}

add_shortcode('excursion_price_box', function($atts) {
    global $post;
    
    $meta = array();
    foreach( array('language', 'departure_date', 'departure_time', 'accomodation', 'pick_up_point', 'over_rate') as $key ) {
        foreach( array( 'group', 'private' ) as $g ) {
            $value = rwmb_meta( "{$key}_{$g}", array(), $post->ID );
            
            if( $key == 'accomodation' ) {
                $value = array_map( function( $post_id ) {
                    return get_the_title($post_id);
                }, $value );
                $value = implode(', ', $value);
            }
            
            $meta[ $g ][ $key ] = $value;
        }
    }
    
    $full_date_group = get_post_meta( $post->ID, '_full_date_group', true ) ?: array();
    $full_date_private = get_post_meta( $post->ID, '_full_date_private', true ) ?: array();
    $max_date_group = get_post_meta( $post->ID, '_max_date_group', true ) ?: 0;
    $max_date_private = get_post_meta( $post->ID, '_max_date_private', true ) ?: 0;

    set_query_var('meta', $meta);
    set_query_var('post_id', $post->ID);
    set_query_var('full_date_group', $full_date_group);
    set_query_var('full_date_private', $full_date_private);
    set_query_var('max_date_group', ( $max_date_group ? date('Y-m-d', $max_date_group) : '' ));
    set_query_var('max_date_private', ( $max_date_private ? date('Y-m-d', $max_date_private) : '' ));

    ob_start();
    get_template_part('excursion/price-box');
    return ob_get_clean();
});

function excursion_private_price_detail($post_id) {
    $check_in_date = date('Y/m/d');
    $rate = excursion_get_price( $post_id, 'private', $check_in_date, 1 );
    $details = array();
    foreach( $rate['pax'] as $item ) {
        if( !isset( $details[ $item['from'] ] ) ) {
            $text = sprintf('%s %s: $%s/'.__('person','mundo-excursion'),
                ( $item['from'] == $item['to'] ? $item['from'] : "{$item['from']} - {$item['to']}" ),
                ( $item['from'] == 1 ? __('person','mundo-excursion') : __('people','mundo-excursion') ),
                $item['adult']
            );
            
            $details[ $item['from'] ] = $text;
        }
    }
    return $details;
}

add_action('wp_ajax_excurtion_step1', 'excurtion_step1_cb');
add_action('wp_ajax_nopriv_excurtion_step1', 'excurtion_step1_cb');
function excurtion_step1_cb() {
    $trigger = empty($_POST['trigger_name']) ? '' : $_POST['trigger_name'];
    $tab = $_POST['tab'];
    if ( ! isset( $_POST['_wpnonce'] ) 
        || ! wp_verify_nonce( $_POST['_wpnonce'], "price-{$tab}" ) 
    ) {
        //echo json_encode( array( 'error' => 1, 'mess' => 'Sorry, your nonce did not verify.' ) );
        //exit();
    }
    
    $post_id = $_POST['post_id'];
    $adult = intval( $_POST['adult'] ) ?: 1;
    $youth = intval( $_POST['youth'] );
    $children = intval( $_POST['children'] );
    $infant = intval( $_POST['infant'] );
    $check_in_date = $_POST['check_in_date'];
    $total_participants = $adult + $youth + $children;

    $rate = excursion_get_price($post_id, $tab, $check_in_date, $adult);
    if( !$rate ) {
        echo json_encode( array( 'error' => 1, 'mess' => 'This day is fully booked!' ) );
        exit();
    }
    $price_data = excursion_calc_price($rate, $tab, $adult, $youth, $children, $infant);
    
    if( !$price_data['total_price'] ) {
        echo json_encode( array( 'error' => 1, 'mess' => 'This day is fully booked!' ) );
        exit();
    }

    if( $trigger == 'book_now' ) {
        $data = $price_data;
        $data['check_in_date'] = $check_in_date;
        $data['adult'] = $adult;
        $data['youth'] = $youth;
        $data['children'] = $children;
        $data['infant'] = $infant;
        $data['tab'] = $tab;
        $data['post_id'] = $post_id;
        $id = rand(11111, 99999);
        set_transient('check_out_'.$id, $data, HOUR_IN_SECONDS);
        $current_lang = pll_current_language();

        switch ($current_lang) {
        	case 'en':
        		$link = get_permalink(get_page_by_path('booking-excursion-checkout'));
        		break;
        	case 'es':
        		$link = get_permalink(get_page_by_path('booking-excursion-checkout-es'));
        		break;
        	case 'pt':
        		$link = get_permalink(get_page_by_path('booking-excursion-checkout-pt'));
        		break;

        	
        }
        $data['href'] = add_query_arg( array( 'check-out' => $id ), $link );
        echo json_encode($data);
        exit();
    }
    
    if( count($price_data['price_info']) == 1 ) {
        $price_data['price_info'] = reset($price_data['price_info']);
    }
    else {
        $price_data['price_info'] = implode('', array_map( function($txt) {
            return sprintf('<div>%s</div>', $txt);
        }, $price_data['price_info'] ));
    }
    $price_data['price_detail'] = implode('', array_map( function($txt) {
        return sprintf('<div>%s</div>', $txt);
    }, $price_data['price_detail'] ));
    
    $price_data['total_price'] = __('Total price','mundo-excursion').': <span>$'.$price_data['total_price'].'</span>';

    $price_data['tab'] = $tab;
    
    echo json_encode($price_data);
    exit();
}

add_shortcode('excursion_checkout', function($atts) {
    $id = $_GET['check-out'];
    $transient = get_transient( "check_out_{$id}" );
    if( !$transient ) {
        return 'Timeout!';
    }

    set_query_var('transient', $transient);
    set_query_var('transient-id', $id);

    ob_start();
    get_template_part('excursion/check-out');
    return ob_get_clean();
});

add_action('wp_ajax_excurtion_checkout', 'excurtion_checkout_cb');
add_action('wp_ajax_nopriv_excurtion_checkout', 'excurtion_checkout_cb');
function excurtion_checkout_cb() {
    $trigger = empty($_POST['trigger_name']) ? '' : $_POST['trigger_name'];
    $tab = $_POST['tab'];
    if ( ! isset( $_POST['_wpnonce'] ) 
        || ! wp_verify_nonce( $_POST['_wpnonce'], "checkout-{$tab}" ) 
    ) {
        echo json_encode( array( 'error' => 1, 'mess' => 'Sorry, your nonce did not verify.' ) );
        exit();
    }
    
    $post_id = $_POST['post_id'];
    $adult = intval( $_POST['adult'] ) ?: 1;
    $youth = intval( $_POST['youth'] );
    $children = intval( $_POST['children'] );
    $infant = intval( $_POST['infant'] );
    $check_in_date = $_POST['check_in_date'];
    $total_participants = $adult + $youth + $children;

    $rate = excursion_get_price($post_id, $tab, $check_in_date, $adult);
    if( !$rate ) {
        echo json_encode( array( 'error' => 1, 'mess' => 'This day is fully booked!' ) );
        exit();
    }
    $price_data = excursion_calc_price($rate, $tab, $adult, $youth, $children, $infant);
    
    if( !$price_data['total_price'] ) {
        echo json_encode( array( 'error' => 1, 'mess' => 'This day is fully booked!' ) );
        exit();
    }

    if( $trigger == 'book_now' ) {
        //SAVE WOO
        $address = array(
            'first_name' => sanitize_text_field($_POST['full_name']),
            'test'  => 'test',
            'company'    => '',
            'email'      => sanitize_text_field($_POST['email']),
            'phone'      => sanitize_text_field($_POST['phone']),
            'address_1'  => '',
            'address_2'  => '',
            'city'       => '',
            'state'      => '',
            'postcode'   => sanitize_text_field($_POST['message']),
            'country'    => '',
        );
        $woo_order = wc_create_order(); 
        $order_id = $woo_order->ID;
        
        $item_id = $woo_order->add_product( mundo_get_product($post_id,'Excursion', $price_data['total_price'] ), 1, array() );
        wc_add_order_item_meta($item_id, 'type', strtoupper($tab) );  
        wc_add_order_item_meta($item_id, 'time', $check_in_date );  
        wc_add_order_item_meta($item_id, 'adult', $adult );
        wc_add_order_item_meta($item_id, 'youth', $youth );
        wc_add_order_item_meta($item_id, 'children', $children );
        wc_add_order_item_meta($item_id, 'infant', $infant );
        wc_add_order_item_meta($item_id, 'price_info', $price_data['price_info'] );
        wc_add_order_item_meta($item_id, 'price_detail', $price_data['price_detail'] );
        $woo_order->calculate_totals();
        $woo_order->set_address( $address, 'billing' );
        $woo_order->update_status('wc-completed', 'Booking was completed', TRUE);
        $current_lang = pll_current_language();
        switch ($current_lang) {
            case 'en':
                $link_lang = get_permalink(get_page_by_path('excursion-finish'));
                break;
            case 'es':
                $link_lang = get_permalink(get_page_by_path('excursion-reserva'));
                break;
            case 'pt':
                $link_lang = get_permalink(get_page_by_path('excursao-terminar-reserva'));
                break; 
        }
        $data['href'] = add_query_arg(
                            array(
                                'cus-name' => sanitize_text_field($_POST['full_name']),
                                'excursion' => sanitize_text_field($post_id),
                            ), $link_lang );
        echo json_encode($data);
        exit();
    }
    
    if( count($price_data['price_info']) == 1 ) {
        $price_data['price_info'] = reset($price_data['price_info']);
    }
    else {
        $price_data['price_info'] = implode('', array_map( function($txt) {
            return sprintf('<div>%s</div>', $txt);
        }, $price_data['price_info'] ));
    }
    $price_data['price_detail'] = implode('', array_map( function($txt) {
        return sprintf('<div>%s</div>', $txt);
    }, $price_data['price_detail'] ));
    
    $price_data['total_price_checkout'] = '$'.$price_data['total_price'];

    $price_data['tab'] = $tab;
    
    echo json_encode($price_data);
    exit();
}