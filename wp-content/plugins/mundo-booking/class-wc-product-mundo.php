<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

require_once (WP_PLUGIN_DIR.'/woocommerce/includes/class-wc-product-simple.php');
/**
 * Simple Product Class.
 *
 * The Fantasea product type kinda product.
 *
 * @class 		WC_Product_Mundo
 * @category	Class
 * @author 		LIVA
 */
 //$tour_id, $name, $tour_price
class WC_Product_Mundo extends WC_Product_Simple {
    protected $post;
    protected $name;
    protected $tour_price;
    public function __construct($tour_id = 0, $tag_name, $tour_price = 0) {
        $this->post = get_post($tour_id);
        // trả về giá trị của product
        if ($tour_id == 0){
            $this->name = 'Booking Contact';
        }else{
            $this->name = $this-> post -> post_title.'_'.$tag_name;
        };
        $this->tour_price = $tour_price;
    }
    public function get_name( $context = 'view' ) {
        return $this->name;
    }
    public function get_price( $context = 'view' ) {
        return $this->tour_price;
    }

}
