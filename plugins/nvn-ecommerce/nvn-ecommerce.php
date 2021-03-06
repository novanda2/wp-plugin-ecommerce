<?php

/**
 * @package nvn ecommerce
 */
/*
Plugin Name: nvn ecommerce
Plugin URI: https://akismet.com/
Description: Used by millions, Akismet is quite possibly the best way in the world to <strong>protect your blog from spam</strong>. It keeps your site protected even while you sleep. To get started: activate the Akismet plugin and then go to your Akismet Settings page to set up your API key.
Version: 0.0.1
Author: Automattic
Author URI: https://automattic.com/wordpress-plugins/
License: GPLv2 or later
Text Domain: akismet
*/

define('PLUGIN_DIR', plugin_dir_path(__FILE__));
define('PLUGIN_URL', plugin_dir_url(__FILE__));
define('PLUGIN_WITH_CLASSES__FILE__', __FILE__);


require_once(PLUGIN_DIR . 'post-type/class.order.php');
require_once(PLUGIN_DIR . 'post-type/class.payment.php');

require_once(PLUGIN_DIR . 'class.ecommerce-option.php');
require_once(PLUGIN_DIR . 'class.products.php');
require_once(PLUGIN_DIR . 'class.product-comments.php');
require_once(PLUGIN_DIR . 'class.permalink.php');
require_once(PLUGIN_DIR . 'class.metaboxio.php');

require_once(PLUGIN_DIR . 'pages/class.page-checkout.php');
require_once(PLUGIN_DIR . 'pages/class.page-my-account.php');
require_once(PLUGIN_DIR . 'pages/class.page-order.php');
require_once(PLUGIN_DIR . 'pages/class.page-payment.php');
require_once(PLUGIN_DIR . 'pages/class.page-payment-form.php');

require_once(PLUGIN_DIR . 'api/order.php');



$allow_rating = get_option('product_review_rating');


$products_params = (object)[
    'slug' => 'products',
    'posts' => (object)array(
        'templates' => (object)[
            'single' => 'templates/single-products.php',
            'archive' => 'templates/archive-products.php'
        ],
        'args' => [
            'labels' => array(
                'name' => __('Products'),
                'singular_name' => __('Product')
            ),
            'public' => true,
            'has_archive' => true,
            'hierarchical' => true,
            'supports' => array('title', 'editor', 'thumbnail', 'comments'),
            'graphql_single_name' => 'product',
            'graphql_plural_name' => 'products',
            'rewrite' => array('slug' => 'collections/%collections%/products', 'with_front' => false)
        ],
        'custom_field' => array(
            'name' => 'product detail',
            'id' => 'products_detail_fields',
            'title' =>  __('Product Detail', 'product custom field'),
            'context' => 'normal',
            'priority' => 'core',
            'callback_args' => array(
                'template' => '/templates/metabox/class.product-detail.php'
            ),
        ),
        'custom_field_metaboxio', array(),
        'custom_taxonomies' => array(
            'labels' => array(
                'name' => 'Product Category',
                'singular_name' => 'Product Categories'
            ),
            // 'hierarchical' => true,
            'rewrite' => array('slug' => 'collections', 'with_front' => false),
            'show_in_graphql' => true,
            'graphql_single_name' => 'documentTag',
            'graphql_plural_name' => 'documentTags',
        )
    ),
];

// products
$produtcs = new Products($products_params);

// metabox
// $produtcs->custom_metabox();
MetaboxIO::init();

// comments
if ($allow_rating)
    ProductComments::init();
else
    ProductComments::destroy();

// custom permalink
CustomPermalink::init();

// graphql
Products::graphql_init();

// checkout
$checkout = new CheckoutPage;

// my account, login, register
$my_account = new MyAccout;

// order post type
$order = new OrderPost;

// order page admin
$orderpage = new OrderPage;

// payment
$payment = new PaymentPost;
// $payment = new PaymentPage;

// // payment form
// $paymentForm = new PaymentFormPage;

add_action('wp_enqueue_scripts', function () {
    // wp_enqueue_style('ecommerce-admin', PLUGIN_URL . 'styles/admin/style.css');
    // wp_enqueue_script('ecommerce-admin', PLUGIN_URL . 'scripts/admin/main.js', array(), '1.0.0', true);
    // wp_enqueue_script('metabox-admin', PLUGIN_URL . 'scripts/admin/metabox-io.js', array(), '1.0.0', true);
    
    
    wp_enqueue_script('main', PLUGIN_URL . 'scripts/site/main.js', array(), '1.0.0', true);
});
