<?php 
/*
 * Plugin Name: Stripe Payment Gateway
 * Plugin URI: #
 * Description: Payment Stripe
 * Author: #
 * Author URI: #
 * Version: 1.0.0
 */

require_once($plugin_dir_path."vendor/autoload.php");

use MyApp\Admin\Admin;
use MyApp\Frontend\Frontend;
    $obj = new Admin();
    $obj->connect_stripe();


?>