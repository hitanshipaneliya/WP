<?php
// remove tab IN PRODUCT PAGE
function woo_remove_product_tabs($tabs)
{
    unset($tabs['additional_information']);
    return $tabs;
}
add_filter('woocommerce_product_tabs', 'woo_remove_product_tabs', 98);



//  add new tab IN PRODUCT PAGE
add_filter('woocommerce_product_tabs', 'woo_tab_desc');
function woo_tab_desc($tabs)
{
    // Adds the Attribute Description tab
    $tabs['attrib_faqs_tab'] = array(
        'title' => __('FAQ', 'woocommerce'),
        'priority' => 10,
        'callback' => 'woo_faq_product_tab_content'
    );
    $tabs['nutval_tab'] = array(
        'title' => __('Nutritional Value', 'woocommerce'),
        'priority' => 20,
        'callback' => 'woo_nutval_product_tab_content'
    );

    return $tabs;
}

