<?php

// Change email address
function change_default_sender_email( $original_email_address ) {
    return 'info@vicsolarrebates.com';
}
  
// Change sender name

  
// Hooking up functions to the correct WordPress filters 
add_filter( 'wp_mail_from', 'change_default_sender_email' );


// /update code remove
function remove_core_updates(){

    global $wp_version;
    return(object) array('last_checked'=> time(),'version_checked'=> $wp_version,);

}
add_filter('pre_site_transient_update_core','remove_core_updates');
add_filter('pre_site_transient_update_plugins','remove_core_updates');
add_filter('pre_site_transient_update_themes','remove_core_updates');