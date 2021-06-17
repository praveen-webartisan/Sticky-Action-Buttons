<?php

/**
 * Plugin Name: Sticky Action Buttons
 * Description: Add Floating Buttons on your website for Click to Chat with WhatsApp, Send Mail and even Click to Call buttons
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
	echo esc_html('Hi there!  I\'m just a plugin, not much I can do when called directly.');
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

function sabs_on_init()
{
    //
}

add_action('init', 'sabs_on_init');

function sabs_user_access_check()
{
    if(!(is_user_logged_in() && user_can(get_current_user_id(), 'administrator'))) {
        wp_die('You are Unauthorized to access this location!');
    }
}

function sabs_admin_options_form()
{
    if(isset($_SESSION['sabsValidationErrors'])) {
        extract($_SESSION['sabsValidationErrors']);
    }

    if(isset($_SESSION['sabsOldFormData'])) {
        extract($_SESSION['sabsOldFormData']);
    }

    if(isset($_SESSION['saveSuccess'])) {
        $saveSuccess = true;
    }

    if(isset($_SESSION['invalidDataAlert'])) {
        $invalidDataAlert = true;
    }

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
        $enabled = (isset($_POST['sabsEnabled']) && !empty($_POST['sabsEnabled']) ? sanitize_text_field($_POST['sabsEnabled']) : null);
        $whatsAppNo = (isset($_POST['sabsWhatsApp']) && !empty($_POST['sabsWhatsApp']) ? sanitize_text_field($_POST['sabsWhatsApp']) : null);
        $phone = (isset($_POST['sabsPhone']) && !empty($_POST['sabsPhone']) ? sanitize_text_field($_POST['sabsPhone']) : null);
        $email = (isset($_POST['sabsEmail']) && !empty($_POST['sabsEmail']) ? sanitize_text_field($_POST['sabsEmail']) : null);

        $sabsButtons = [];
        $errors = [];

        if(!empty($whatsAppNo)) {
            if(is_phone_no($whatsAppNo)) {
                $sabsButtons['whatsApp'] = $whatsAppNo;
            } else {
                $errors['errWhatsApp'] = "Invalid input";
            }
        }

        if(!empty($phone)) {
            if(is_phone_no($phone)) {
                $sabsButtons['phone'] = $phone;
            } else {
                $errors['errPhone'] = "Invalid input";
            }
        }

        if(!empty($email)) {
            if(is_email($email)) {
                $sabsButtons['email'] = $email;
            } else {
                $errors['errEmail'] = "Invalid input";
            }
        }

        if(empty($errors)) {
            $sabsOptions['buttons'] = $sabsButtons;

            if(!empty($enabled) && $enabled == 'yes') {
                $sabsOptions['enabled'] = 'yes';
            }

            update_option('sabs', $sabsOptions);

            $_SESSION['saveSuccess'] = true;
        } else {
            $_SESSION['invalidDataAlert'] = true;

            $_SESSION['sabsValidationErrors'] = $errors;
            $_SESSION['sabsOldFormData'] = [
                "oldEnabled" => $enabled,
                "oldWhatsApp" => $whatsAppNo,
                "oldPhone" => $phone,
                "oldEmail" => $email,
            ];
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
