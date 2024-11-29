<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       developerforwebsites@gmail.com
 * @since      1.0.0
 *
 * @package    Welcome_Page_Redirect
 * @subpackage Welcome_Page_Redirect/public/partials
 */
 /**
  * @snippet       WooCommerce: Redirect to Custom Thank you Page
  * @how-to        Get CustomizeWoo.com FREE
  * @author        Rodolfo Melogli
  * @compatible    WooCommerce 3.7
  * @donate $9     https://businessbloomer.com/bloomer-armada/
  */

      add_filter('woocommerce_thankyou_order_received_text', 'woo_change_order_received_text', 10, 2 );
      function woo_change_order_received_text( $str, $order )
      {


          $customer_orders = get_posts( array(
              'numberposts' => -1,
              'post_type'   => wc_get_order_types(),
              'post_status' => array_keys( wc_get_order_statuses() ),
          ) );


          // get an instance of the WC_Order object
          //$order = wc_get_order( $customer_orders[0]->ID );
          $order = wc_get_order( $customer_orders[0]->ID );

          $product_cats = wp_get_post_terms( $customer_orders[0]->ID, 'product_cat' );

          echo do_shortcode( '[products limit="1" category="'.$product_cats[0]->name.'" columns="2" orderby="rand"  class="quick-sale" on_sale="true" ]' );

/*
          // The loop to get the order items which are WC_Order_Item_Product objects since WC 3+
          foreach( $order->get_items() as $item_id => $item )
          {

              $product_cats[] = wp_get_post_terms( $item->get_product_id(), 'product_cat' );

          }

          echo '
          <style>
            .quick-sale ul {

                float: left;
            }

            .quick-sale {
              display: inline-block;
            }
          </style>';

          foreach ($product_cats as $key => $value)
          {

            echo do_shortcode( '[products limit="1" category="'.$value[0]->name.'" columns="2" orderby="rand"  class="quick-sale" on_sale="true" ]' );

          }
*/



      }


      add_action( 'woocommerce_before_cart', 'bbloomer_apply_coupon' );
      function bbloomer_apply_coupon()
      {



            $coupon_post_type = get_posts( array(
                'numberposts' => -1,
                'post_type'   => 'shop_coupon',
                //'post_status' => array_keys( wc_get_order_statuses() ),
            ) );


            $coupon_code = 'woocommerce coupons'; // Code

            foreach ( $coupon_post_type as $key_type => $value_type )
            {
              $name_array[] = $value_type->post_title;
            }

            if (in_array( $coupon_code, (array)$name_array ))
            {

              if ( WC()->cart->has_discount( $coupon_code ) ) return;
              WC()->cart->add_discount( $coupon_code );
              wc_print_notices();

            }
            else
            {

              $amount = '10';
              $discount_type = 'percent';
              $coupon = array(
                  'post_title' => $coupon_code,
                  'post_content' => '',
                  'post_status' => 'publish',
                  'post_author' => 1,
                  'post_type'    => 'shop_coupon'
              );
              $new_coupon_id = wp_insert_post( $coupon );
              update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
              update_post_meta( $new_coupon_id, 'coupon_amount', $amount );
              update_post_meta( $new_coupon_id, 'individual_use', 'no' );
              update_post_meta( $new_coupon_id, 'product_ids', '' );
              update_post_meta( $new_coupon_id, 'exclude_product_ids', '' );
              update_post_meta( $new_coupon_id, 'usage_limit', '' );
              update_post_meta( $new_coupon_id, 'expiry_date', '' );
              update_post_meta( $new_coupon_id, 'free_shipping', 'no' );

            }
            //print_r(  $name_array );




            }


            // Hook before calculate fees
            add_action('woocommerce_cart_calculate_fees' , 'add_user_discounts');
            /**
             * Add custom fee if more than three article
             * @param WC_Cart $cart
             */
            function add_user_discounts( WC_Cart $cart ){
                //any of your rules
                // Calculate the amount to reduce
                $discount = $cart->get_subtotal() * 0.1;

                $cart->add_fee( 'Test discount 10%', -$discount);
            }







?>
