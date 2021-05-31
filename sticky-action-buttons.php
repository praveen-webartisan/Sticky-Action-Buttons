<?php

/**
 * Plugin Name: Sticky Action Buttons
 * Description: Add Floating Buttons on your website for Click to Chat with WhatsApp, FB Messenger, Send Mail and even Click to Call buttons
 * Version: 1.0
 * Requires at least: 5.7
 * Requires PHP: 7.4
 * Author: Praveen Tamil
 * Author URI: https://github.com/praveen-tamil
 * License: GPL v3 or Later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: sticky-action-buttons
 */

/*
Sticky Action Buttons is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
any later version.
 
Sticky Action Buttons is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with Sticky Action Buttons. If not, see https://www.gnu.org/licenses/gpl-3.0.html.
*/

if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

/* Plugin Activation Event */
function sabs_activate()
{
	update_option('sabs', ['enabled' => 'yes']);
}

register_activation_hook( __FILE__, 'sabs_activate' );
/* Plugin Activation Event */


/* Plugin Deactivation Event */
function sabs_deactivate()
{
    $sabsOptions = get_option('sabs');
    $sabsOptions = $sabsOptions ?? [];

    $sabsOptions['enabled'] = 'no';

	update_option('sabs', $sabsOptions);
}

register_deactivation_hook( __FILE__, 'sabs_deactivate' );
/* Plugin Deactivation Event */


/* Plugin Uninstall Event */
function sabs_uninstall()
{
	delete_option('sabs');
}

register_uninstall_hook( __FILE__, 'sabs_uninstall' );
/* Plugin Uninstall Event */

function register_session()
{
    if(!session_id()) {
        session_start();
    }
}

add_action('init', 'register_session');

function sabs_user_access_check()
{
    if(!(is_user_logged_in() && user_can(get_current_user_id(), 'administrator'))) {
        wp_die('You are Unauthorized to access this location!');
    }
}

function sabs_admin_options_form()
{
    require_once plugin_dir_path(__FILE__) . 'admin/sabs_admin_options.php';
}

function sabs_options_page_form_submit()
{
    sabs_user_access_check();

    sabs_include_assets();

    function is_phone_no($no)
    {
        return preg_match("/^(\+)([1-9]{1,3})([0-9]{10})$/", $no);
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        $sabs = $_POST['sabs'];

        $enabled = sanitize_text_field($sabs['enabled']);
        $whatsAppNo = sanitize_text_field($sabs['whatsApp']);
        $fb = sanitize_text_field($sabs['fb']);
        $phone = sanitize_text_field($sabs['phone']);
        $email = sanitize_text_field($sabs['email']);

        $sabsButtons = [];
        $errors = [];

        if(!empty($whatsAppNo)) {
            if(is_phone_no($whatsAppNo)) {
                $sabsButtons['whatsApp'] = $whatsAppNo;
            } else {
                $errors['whatsApp'] = "Invalid input";
            }
        }

        if(!empty($fb)) {
            if(preg_match("/^[A-Za-z\d.]{5,}$/", $fb)) {
                $sabsButtons['fb'] = $fb;
            } else {
                $errors['fb'] = "Invalid input";
            }
        }

        if(!empty($phone)) {
            if(is_phone_no($phone)) {
                $sabsButtons['phone'] = $phone;
            } else {
                $errors['phone'] = "Invalid input";
            }
        }

        if(!empty($email)) {
            if(is_email($email)) {
                $sabsButtons['email'] = $email;
            } else {
                $errors['email'] = "Invalid input";
            }
        }

        if(empty($errors)) {
            $sabsOptions['buttons'] = $sabsButtons;

            if(!empty($enabled) && $enabled == 'yes') {
                $sabsOptions['enabled'] = 'yes';
            }

            update_option('sabs', $sabsOptions);
        } else {
            $_SESSION['sabsValidationErrors'] = $errors;
            $_SESSION['sabsOldFormData'] = $sabs;
        }
    }
}

function sabs_admin_menu()
{
    sabs_user_access_check();

    $hookname = add_menu_page(
        'Sticky Action Buttons',
        'Sticky Action Buttons',
        'manage_options',
        'sabs-admin-options',
        'sabs_admin_options_form',
        'dashicons-align-left',
    );

    add_action('load-' . $hookname, 'sabs_options_page_form_submit');
}

add_action('admin_menu', 'sabs_admin_menu');

function sabs_render_buttons()
{
    require_once plugin_dir_path(__FILE__) . 'public/sabs_container.php';
}

add_action('wp_footer', 'sabs_render_buttons');

function sabs_include_assets()
{
    wp_enqueue_style('sabs-icons', plugins_url('css/icofont/icofont.min.css', __FILE__));
    wp_enqueue_style('sabs-css', plugins_url('css/style.css', __FILE__));
}

add_action('wp_enqueue_scripts', 'sabs_include_assets');
