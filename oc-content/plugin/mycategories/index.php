<?php

/*
Plugin Name: Arrange Category
Plugin URI: http://www.GarageBargain.org
Description: Arrange Category
Version: 1.1
Author: GarageBargain
Author URI: cto@garagebargain.com
Short Name: mycategories
Plugin update URI: xml-import-export-category
*/

function mycategories_admin_menu() 
{

	 osc_add_admin_menu_page( 
   __('Arrange Categories'),                                             // menu title
   osc_admin_base_url(true).'?page=mycategories',                    // menu url
   'mycategories',                                                   // menu id
   'moderator'                                                // capability
 ) ; 
$filename="/var/www/html/oc-admin/mycategories.php";

if (file_exists($filename)) {
    
} else {
    copy('mycategories.php', '/var/www/html/oc-admin/mycategories.php');
}




   
}

// This is needed in order to be able to activate the plugin
osc_register_plugin(osc_plugin_path(__FILE__), '');

// This is a hack to show a Uninstall link at plugins table (you could also use some other hook to show a custom option panel)
osc_add_hook(osc_plugin_path(__FILE__)."_uninstall", '');

osc_add_hook('admin_header','mycategories_admin_menu');

?>
