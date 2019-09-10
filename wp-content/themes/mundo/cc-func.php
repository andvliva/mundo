<?php
if (!function_exists('cc_woo_send_customer_ip_adress')) {
	function cc_woo_send_customer_ip_adress($order, $sent_to_admin, $plain_text, $email){

		// Just for admin new order notification
		if('new_order' == $email->id){
			// WC3+ compatibility
			$order_id = method_exists( $order, 'get_id' ) ? $order->get_id() : $order->id;

			echo '<br><p style="float: right;margin: 15px 0;">'. get_post_meta( $order_id, '_customer_ip_address', true ).'</p>';
		}
	}

	add_action('woocommerce_email_customer_details', 'cc_woo_send_customer_ip_adress', 99, 4);
}

?>