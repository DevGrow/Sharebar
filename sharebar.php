<?php
/*
Plugin Name: Sharebar 2
Plugin URI: http://devgrow.com/
Description: Adds a dynamic bar with sharing icons (Facebook, Twitter, etc.) that changes based on browser size and page location.  More info and demo at: <a href="http://devgrow.com/sharebar-wordpress-plugin/">Sharebar Plugin Home</a>
Version: 1.3
Author: Monji Dolon
Author URI: http://devgrow.com/
Contributors: mdolon
License: GPL3

Copyright 2012 digital-telepathy  (email : support@digital-telepathy.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Base Config
if(!defined('PLUGIN_BASENAME')) define('PLUGIN_BASENAME', basename(__FILE__));
if(!defined('PLUGIN_DIR')) define('PLUGIN_DIR', dirname(__FILE__));
if(!defined('PLUGIN_PATH')) define('PLUGIN_PATH', plugins_url("", __FILE__));

// Require API files
require(PLUGIN_DIR . "/app/api/admin.php");
require(PLUGIN_DIR . "/app/api/buttons.php");

add_action( 'plugins_loaded', array( 'SharebarAdmin', 'getInstance' ) );

?>