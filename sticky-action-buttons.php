<?php

/**
 * Plugin Name: Sticky Action Buttons
 * Description: Add Floating Buttons on your website for Click to Chat with WhatsApp, Send Mail and even Click to Call buttons
 * Version: 1.1
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
	//
}

register_activation_hook( __FILE__, 'sabs_activate' );
/* Plugin Activation Event */


/* Plugin Deactivation Event */
function sabs_deactivate()
{
    //
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
    // Check if there's any Validation Errors
    if(isset($_SESSION['sabsValidationErrors'])) {
        extract($_SESSION['sabsValidationErrors']);

        // Check if there's any Validation Errors for Custom Buttons and send it to Front-end Script
        if(isset($_SESSION['sabsValidationErrors']['sabsCustom'])) {
            wp_localize_script('sabs-admin-script', 'oldSabsCustomErrors', $_SESSION['sabsValidationErrors']['sabsCustom']);
        }
    }

    // Send currently submitted Form data to View
    if(isset($_SESSION['sabsOldFormData'])) {
        extract($_SESSION['sabsOldFormData']);

        // Currently submitted Custom Button data to Front-end Script
        if(isset($_SESSION['sabsOldFormData']['oldSabsCustom'])) {
            wp_localize_script('sabs-admin-script', 'oldSabsCustom', $_SESSION['sabsOldFormData']['oldSabsCustom']);
        }
    } else {
        // Fetch data from Database (only when the Form is not Submitted)
        $currSabOptions = get_option('sabs');

        // Send fetched Custom Buttons data to Front-end Script
        if(isset($currSabOptions['customButtons']) && !empty($currSabOptions['customButtons'])) {
            wp_localize_script('sabs-admin-script', 'currentCustomSabs', $currSabOptions['customButtons']);
        }
    }

    // Check if Success message needed to be shown
    if(isset($_SESSION['saveSuccess'])) {
        $saveSuccess = true;
    }

    // Check if Failure message needed to be shown
    if(isset($_SESSION['invalidDataAlert'])) {
        $invalidDataAlert = true;
    }

    // Render the View
    require_once plugin_dir_path(__FILE__) . 'admin/sabs_admin_options.php';
}

function sabs_sanitize_custom_buttons_post_data($sabsCustom)
{
    $sabsCustom = !empty($sabsCustom) && is_array($sabsCustom) ? $sabsCustom : [];

    $sabsCustom = array_map(function ($btnAttributes) {
        return array_map('sanitize_text_field', $btnAttributes);
    }, $sabsCustom);

    return $sabsCustom;
}

function sabs_is_valid_color_code($colorCode)
{
    // Color code (Hex) validation
    return preg_match('/^#(([0-9a-z]{6})|([0-9a-z]{8}))$/i', $colorCode);
}

function sabs_is_valid_icon($icon)
{
    $classArray = explode(' ', $icon);

    // Should be only one Icon class
    if(count($classArray) == 1) {
        // Icon class format: icofont-[name of the icon]
        if(preg_match('/^icofont\-[a-z\-]{1,}[a-z]$/', $classArray[0])) {
            return true;
        }
    } else {
        $errors['icon'] = 'Invalid Icon';
    }

    return false;
}

function sabs_get_custom_button_action_type($action)
{
    $type = false;

    // Check if action is URL
    if(filter_var($action, FILTER_VALIDATE_URL) !== false) {
        $type = 'link';
    } else {
        // Check if action is JavaScript function
        if(preg_match('/^[\$a-z\_][0-9a-z\_\$]*$/i', $action)) {
            $type = 'js-function';
        } else {
            // Check if action is any app Link
            if(preg_match('/^[a-z]{3,}\:([a-z0-9\/\-\.\?\&\=\%\_\~\#\+])*$/i', $action)) {
                $type = 'link';
            }
        }
    }

    return $type;
}

function sabs_validate_custom_button($customButton)
{
    $errors = [];

    // Validate Custom Button attributes and throw error when it's invalid

    if(isset($customButton['bgColor']) && !empty($customButton['bgColor'])) {
        if(!sabs_is_valid_color_code($customButton['bgColor'])) {
            $errors['bgColor'] = 'Invalid Background Color';
        }
    } else {
        $errors['bgColor'] = 'Invalid Background Color';
    }

    if(isset($customButton['color']) && !empty($customButton['color'])) {
        if(!sabs_is_valid_color_code($customButton['color'])) {
            $errors['color'] = 'Invalid Icon Color';
        }
    } else {
        $errors['color'] = 'Invalid Icon Color';
    }

    if(isset($customButton['icon']) && !empty($customButton['icon'])) {
        if(!sabs_is_valid_icon($customButton['icon'])) {
            $errors['icon'] = 'Invalid Icon';
        }
    } else {
        $errors['icon'] = 'Invalid Icon';
    }

    if(isset($customButton['action']) && !empty($customButton['action'])) {
        if(sabs_get_custom_button_action_type($customButton['action']) == false) {
            $errors['action'] = 'Invalid Action';
        }
    } else {
        $errors['action'] = 'Invalid Action';
    }

    return $errors;
}

function sabs_is_valid_phone_number($no)
{
    // Validate Phone Number
    return preg_match('/^(\+)([1-9]{1,3})([0-9]{10})$/', $no);
}

function sabs_options_page_form_submit()
{
    sabs_user_access_check();

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        // Default Buttons
        $whatsAppNo = (isset($_POST['sabsWhatsApp']) && !empty($_POST['sabsWhatsApp']) ? sanitize_text_field($_POST['sabsWhatsApp']) : null);
        $phone = (isset($_POST['sabsPhone']) && !empty($_POST['sabsPhone']) ? sanitize_text_field($_POST['sabsPhone']) : null);
        $email = (isset($_POST['sabsEmail']) && !empty($_POST['sabsEmail']) ? sanitize_text_field($_POST['sabsEmail']) : null);

        // Custom Buttons
        $sabsCustom = (isset($_POST['sabsCustom']) && !empty($_POST['sabsCustom']) && is_array($_POST['sabsCustom']) ? $_POST['sabsCustom'] : []);
        $sabsCustom = sabs_sanitize_custom_buttons_post_data($sabsCustom);

        // Size
        $size = (isset($_POST['sabsSize']) && !empty($_POST['sabsSize']) ? sanitize_text_field($_POST['sabsSize']) : null);
        $size = in_array($size, [1, 2, 3]) ? $size : 2;

        // Direction
        $direction = (isset($_POST['sabsDirection']) && !empty($_POST['sabsDirection']) ? sanitize_text_field($_POST['sabsDirection']) : null);
        $direction = in_array($direction, ['vertical', 'horizontal']) ? $direction : 'vertical';

        // Placement
        $placement = (isset($_POST['sabsPlacement']) && !empty($_POST['sabsPlacement']) ? sanitize_text_field($_POST['sabsPlacement']) : null);
        $placement = in_array($placement, ['topLeft', 'left', 'bottomLeft', 'topRight', 'right', 'bottomRight']) ? $placement : 'right';

        // View Mode
        $viewMode = (isset($_POST['sabsViewMode']) && !empty($_POST['sabsViewMode']) ? sanitize_text_field($_POST['sabsViewMode']) : null);
        $viewMode = in_array($viewMode, ['always', 'collapsible']) ? $viewMode : 'always';

        if($viewMode == 'collapsible') {
            // Collapse Mode
            $collapseMode = (isset($_POST['sabsCollapseMode']) && !empty($_POST['sabsCollapseMode']) ? sanitize_text_field($_POST['sabsCollapseMode']) : null);
            $collapseMode = in_array($collapseMode, ['hover', 'click']) ? $collapseMode : 'hover';

            // Collapse Button Style
            $sabsCollapseButtonIcon = (isset($_POST['sabsCollapseButtonIcon']) && !empty($_POST['sabsCollapseButtonIcon']) ? sanitize_text_field($_POST['sabsCollapseButtonIcon']) : null);

            $sabsCollapseButtonBgColor = (isset($_POST['sabsCollapseButtonBgColor']) && !empty($_POST['sabsCollapseButtonBgColor']) ? sanitize_text_field($_POST['sabsCollapseButtonBgColor']) : null);

            $sabsCollapseButtonIconColor = (isset($_POST['sabsCollapseButtonIconColor']) && !empty($_POST['sabsCollapseButtonIconColor']) ? sanitize_text_field($_POST['sabsCollapseButtonIconColor']) : null);
        }

        $sabsButtons = [];
        $errors = [];

        // Validate Default Button #1
        if(!empty($whatsAppNo)) {
            if(sabs_is_valid_phone_number($whatsAppNo)) {
                $sabsButtons['whatsApp'] = $whatsAppNo;
            } else {
                $errors['errWhatsApp'] = 'Invalid input';
            }
        }

        // Validate Default Button #2
        if(!empty($phone)) {
            if(sabs_is_valid_phone_number($phone)) {
                $sabsButtons['phone'] = $phone;
            } else {
                $errors['errPhone'] = 'Invalid input';
            }
        }

        // Validate Default Button #3
        if(!empty($email)) {
            if(is_email($email)) {
                $sabsButtons['email'] = $email;
            } else {
                $errors['errEmail'] = 'Invalid input';
            }
        }

        // Validate [Toggle Collapsible Button] attributes (if View Mode is Collapsible)
        if($viewMode == 'collapsible') {
            if(!empty($sabsCollapseButtonIcon)) {
                if(!sabs_is_valid_icon($sabsCollapseButtonIcon)) {
                    $errors['errCollapseButtonIcon'] = 'Invalid Icon';
                }
            } else {
                $errors['errCollapseButtonIcon'] = 'Invalid Icon';
            }

            if(!empty($sabsCollapseButtonBgColor)) {
                if(!sabs_is_valid_color_code($sabsCollapseButtonBgColor)) {
                    $errors['errCollapseButtonBgColor'] = 'Invalid Background Color';
                }
            } else {
                $errors['errCollapseButtonBgColor'] = 'Invalid Background Color';
            }

            if(!empty($sabsCollapseButtonIconColor)) {
                if(!sabs_is_valid_color_code($sabsCollapseButtonIconColor)) {
                    $errors['errCollapseButtonIconColor'] = 'Invalid Icon Color';
                }
            } else {
                $errors['errCollapseButtonIconColor'] = 'Invalid Icon Color';
            }
        }

        if(!empty($sabsCustom)) {
            // Validate Custom Buttons
            foreach($sabsCustom as $sabsCustomIndex => $customButton) {
                $sabsCustomValidationErr = sabs_validate_custom_button($customButton);

                if(!empty($sabsCustomValidationErr)) {
                    $errors['sabsCustom'][$sabsCustomIndex] = $sabsCustomValidationErr;
                }
            }
        }

        if(empty($errors)) {
            // Save data to wp_options when all data are valid
            $sabsOptions['buttons'] = $sabsButtons;

            foreach($sabsCustom as $sabsCustomIndex => $customButton) {
                $sabsOptions['customButtons'][] = [
                    'bgColor' => $customButton['bgColor'],
                    'color' => $customButton['color'],
                    'icon' => $customButton['icon'],
                    'action' => $customButton['action'],
                    'actionType' => sabs_get_custom_button_action_type($customButton['action']),
                    'withNotificationIcon' => isset($customButton['withNotificationIcon']) && !empty($customButton['withNotificationIcon']) ? 'yes' : 'no',
                ];
            }

            $sabsOptions['size'] = $size;
            $sabsOptions['direction'] = $direction;
            $sabsOptions['placement'] = $placement;
            $sabsOptions['viewMode'] = $viewMode;

            if($viewMode == 'collapsible') {
                $sabsOptions['collapseMode'] = $collapseMode;
                $sabsOptions['collapseButton'] = [
                    'icon' => $sabsCollapseButtonIcon,
                    'bgColor' => $sabsCollapseButtonBgColor,
                    'color' => $sabsCollapseButtonIconColor,
                ];
            }

            update_option('sabs', $sabsOptions);

            // Show Success message when Data saved
            $_SESSION['saveSuccess'] = true;
        } else {
            // Show Failure message when Validation fails
            $_SESSION['invalidDataAlert'] = true;

            // Send Validation Errors
            $_SESSION['sabsValidationErrors'] = $errors;
            $_SESSION['sabsOldFormData'] = [
                'oldWhatsApp' => $whatsAppNo,
                'oldPhone' => $phone,
                'oldEmail' => $email,
                'oldSabsCustom' => $sabsCustom,
                'oldSabsSize' => $size,
                'oldSabsDirection' => $direction,
                'oldSabsPlacement' => $placement,
                'oldSabsViewMode' => $viewMode,
            ];

            if($viewMode == 'collapsible') {
                $_SESSION['sabsOldFormData']['oldSabsCollapseMode'] = $collapseMode;
                $_SESSION['sabsOldFormData']['oldSabsCollapseButtonIcon'] = $sabsCollapseButtonIcon;
                $_SESSION['sabsOldFormData']['oldSabsCollapseButtonBgColor'] = $sabsCollapseButtonBgColor;
                $_SESSION['sabsOldFormData']['oldSabsCollapseButtonIconColor'] = $sabsCollapseButtonIconColor;
            }
        }
    }
}

function sabs_admin_menu()
{
    sabs_user_access_check();

    // Add Menu Item
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
    // Attach Buttons render code to footer
    require_once plugin_dir_path(__FILE__) . 'public/sabs_container.php';
}

add_action('wp_footer', 'sabs_render_buttons');

function sabs_include_styles_assets()
{
    wp_enqueue_style('sabs-icons', plugins_url('css/icofont/icofont.min.css', __FILE__));
    wp_enqueue_style('sabs-css', plugins_url('css/style.css', __FILE__));
}

function sabs_include_assets()
{
    sabs_include_styles_assets();

    if(!is_admin()) {
        wp_enqueue_script('sabs-admin-script', plugins_url('js/public-script.js', __FILE__), array('jquery'), false, true);
    }
}

add_action('wp_enqueue_scripts', 'sabs_include_assets');

function sabs_include_admin_assets($hook)
{
    sabs_include_styles_assets();

    if(is_admin()) {
        if(isset($_GET['page']) && $_GET['page'] == 'sabs-admin-options') {
            wp_enqueue_script('sabs-admin-script', plugins_url('js/admin-script.js', __FILE__), array('jquery'), false, true);
        }
    }
}

add_action('admin_enqueue_scripts', 'sabs_include_admin_assets');
