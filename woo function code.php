// wishlist
if ( defined( 'YITH_WCWL' ) && ! function_exists( 'yith_wcwl_get_items_count' ) ) {
    function yith_wcwl_get_items_count() {
        ob_start();
?>
        <span class="yith-wcwl-items-count">
            <span class="yith_count_pro"><?php echo esc_html( yith_wcwl_count_all_products() ); ?></span>
        </span>
    <?php
        return ob_get_clean();
    }
add_shortcode( 'yith_wcwl_items_count', 'yith_wcwl_get_items_count' ); //[yith_wcwl_items_count]
}

if ( defined( 'YITH_WCWL' ) && ! function_exists( 'yith_wcwl_ajax_update_count' ) ) {
    function yith_wcwl_ajax_update_count() {
        wp_send_json( array(
            'count' => yith_wcwl_count_all_products()
        ) );
    }
add_action( 'wp_ajax_yith_wcwl_update_wishlist_count', 'yith_wcwl_ajax_update_count' );
add_action( 'wp_ajax_nopriv_yith_wcwl_update_wishlist_count', 'yith_wcwl_ajax_update_count' );
}

if ( defined( 'YITH_WCWL' ) && ! function_exists( 'yith_wcwl_enqueue_custom_script' ) ) {
    function yith_wcwl_enqueue_custom_script() {
        wp_add_inline_script(
            'jquery-yith-wcwl',
            "
                jQuery(document).ready(function($) {
                    $( document ).on( 'added_to_wishlist removed_from_wishlist', function() {
                        $.get( yith_wcwl_l10n.ajax_url, {
                            action: 'yith_wcwl_update_wishlist_count'
                        }, function( data ) {
                            $('.yith-wcwl-items-count .yith_count_pro').html( data.count );
                            $('.yith-wcwl-items-count .yith_count_pro_2').html( data.count );
                        } );
                    } );
                } );
            "
        );
    }
add_action( 'wp_enqueue_scripts', 'yith_wcwl_enqueue_custom_script', 20 );
}


// single product detail page quntity value -+ shortcode
add_action( 'wp_footer' , 'custom_quantity_fields_script' );
function custom_quantity_fields_script(){
    ?>
    <script type='text/javascript'>
    jQuery( function( jQuery ) {
        if ( ! String.prototype.getDecimals ) {
            String.prototype.getDecimals = function() {
                var num = this,
                    match = ('' + num).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
                if ( ! match ) {
                    return 0;
                }
                return Math.max( 0, ( match[1] ? match[1].length : 0 ) - ( match[2] ? +match[2] : 0 ) );
            }
        }
        // Quantity "plus" and "minus" buttons
        jQuery( document.body ).on( 'click', '.plus, .minus', function() {


            var $qty        = jQuery( this ).closest( '.quantity' ).find( '.qty'),
                currentVal  = parseFloat( $qty.val() ),
                max         = parseFloat( $qty.attr( 'max' ) ),
                min         = parseFloat( $qty.attr( 'min' ) ),
                step        = $qty.attr( 'step' );

            // Format values
            if ( ! currentVal || currentVal === '' || currentVal === 'NaN' ) currentVal = 0;
            if ( max === '' || max === 'NaN' ) max = '';
            if ( min === '' || min === 'NaN' ) min = 0;
            if ( step === 'any' || step === '' || step === undefined || parseFloat( step ) === 'NaN' ) step = 1;

            // Change the value
            if ( jQuery( this ).is( '.plus' ) ) {
                if ( max && ( currentVal >= max ) ) {
                    $qty.val( max );
                } else {
                    $qty.val( ( currentVal + parseFloat( step )).toFixed( step.getDecimals() ) );
                }
            } else {
                if ( min && ( currentVal <= min ) ) {
                    $qty.val( min );
                } else if ( currentVal > 0 ) {
                    $qty.val( ( currentVal - parseFloat( step )).toFixed( step.getDecimals() ) );
                }
            }

            // Trigger change event
            $qty.trigger( 'change' );
        });
    });
    </script>
    <?php
}



add_filter( 'woocommerce_form_field', 'checkout_fields_in_label_error', 10, 4 );
function checkout_fields_in_label_error( $field, $key, $args, $value ) {
   if ( strpos( $field, '</span>' ) !== false && $args['required'] ) {
      $error = '<span class="error" style="display:none">';
      $error .= sprintf( __( '%s is a required field.', 'woocommerce' ), $args['label'] );
      $error .= '</span>';
      $field = substr_replace( $field, $error, strpos( $field, '</span>' ), 0);
   }
   return $field;
}

add_filter( 'woocommerce_checkout_fields' , 'override_billing_checkout_fields', 20, 1 );
 function override_billing_checkout_fields( $fields ) {

     $fields['billing']['billing_first_name']['placeholder'] = 'First Name*';
     $fields['billing']['billing_last_name']['placeholder'] = 'Last Name*';
     $fields['billing']['billing_company']['placeholder'] = 'Company';
     $fields['billing']['billing_postcode']['placeholder'] = 'Postcode*';
     $fields['billing']['billing_phone']['placeholder'] = 'Phone*';
     $fields['billing']['billing_city']['placeholder'] = 'Suburb*';
     $fields['billing']['billing_email']['placeholder'] = 'Email*';
     $fields['billing']['billing_address_1']['placeholder'] = 'House number and street name*';
     $fields['billing']['billing_state']['placeholder'] = 'Select State...';


     $fields['shipping']['shipping_first_name']['placeholder'] = 'First Name';
     $fields['shipping']['shipping_last_name']['placeholder'] = 'Last Name';
     $fields['shipping']['shipping_company']['placeholder'] = 'Company';
     $fields['shipping']['shipping_postcode']['placeholder'] = 'Postcode';
     $fields['shipping']['shipping_phone']['placeholder'] = 'Phone';
     $fields['shipping']['shipping_city']['placeholder'] = 'City';

     return $fields;
 }

/* Disable new divi crazy crap code for CPT */
function disable_cptdivi()
{
    remove_action( 'wp_enqueue_scripts', 'et_divi_replace_stylesheet', 99999998 );
}
add_action('init', 'disable_cptdivi');

//  buy now checkout page redirect 
add_filter ('add_to_cart_redirect', 'redirect_to_checkout');
function redirect_to_checkout() {
    global $woocommerce;
    $checkout_url = $woocommerce->cart->get_checkout_url();
    return $checkout_url;
}