<?php
/**
 * IgniterAuth
 *
 * @package   igniter-auth
 * @link      https://affilipoint.com/plugins/
 * @author    Affilipoint.com <https://affilipoint.com>
 * @copyright 2023 Affilipoint.com
 * @license   GPL v2 or later
 *
 * 
 * Plugin Name: IgniterAuth
 * Plugin URI: https://affilipoint.com/plugins/
 * Description: Protects your website from the public and search engines with HTTP Basic Authentication.
 * Version: 1.0.0
 * Author: affilipoint.com
 * Author URI: https://affilipoint.com
 * License: GPLv2
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: igniter-auth
 * Domain Path: /i18n
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
*/

use IgniterAuth\AuthClass;

! defined( 'ABSPATH' ) ? exit : '';

define( 'IGNITER_AUTH_VERSION', '1.1.0' );
define( 'IGNITER_AUTH_PLUGIN_PATH', plugin_dir_path(__FILE__) );
define( 'IGNITER_AUTH_PLUGIN_URL', plugin_dir_url(__FILE__) );

// Includes
include_once IGNITER_AUTH_PLUGIN_PATH . "/vendor/autoload.php";

$igniterAuth = new AuthClass();

// Actions
add_action( 'init', array( $igniterAuth, 'lock' ) );
add_action( 'admin_menu', array( $igniterAuth, 'settingsMenu' ) );
add_action( 'admin_notices', array( $igniterAuth, 'adminNoticeWarning' ), 1 );
add_action( 'wp_head', array( $igniterAuth, 'noIndex' ) );

// Filters
add_filter( 'plugin_action_links_igniter-auth/index.php', array($igniterAuth, 'settingsLink') );

// Hooks
