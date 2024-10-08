<?php
/**
 * Plugin Name: Lightbox - Gallery Lightbox
 * Plugin URI: https://wpdevart.com/wordpress-lightbox-plugin/
 * Author URI: https://wpdevart.com/
 * Description: WordPress Lightbox plugin is a highly customizable and responsive product for displaying images and videos(YouTube and Vimeo) in the popup. The Lightbox plugin is one of the most popular and useful plugins for WordPress websites.
 * Version: 2.1.6
 * Author: wpdevart
 * License: GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
define('wpdevart_lightbox_plugin_url', trailingslashit( plugins_url('', __FILE__ )),0);
define('wpdevart_lightbox_plugin_path',trailingslashit( plugin_dir_path( __FILE__ )),0);
define("wpdevart_lightbox_support_url","https://wordpress.org/support/plugin/lightbox-popup");

class wpdevart_lightbox{
	// required variables
	public  $options;
	
	public $database_parametrs;	

	/*###################### Construct function ##################*/	
	
	function __construct(){		
		
		$this->install_databese(); // class for information about database and getting information
		$this->include_library(); // include library for getting and setting options and other
		$this->call_base_filters(); // call base filters for connecting to WordPress CMS required functions
		$this->create_admin_menu(); // function for creating admin menu
		$this->crate_fornt_end(); // function for creating front end
	
			
	}
	
	/*###################### Install database function ##################*/		
	
	private function install_databese(){
		
		require_once(wpdevart_lightbox_plugin_path.'includes/install_database.php'); //include database file
		
		$lightbox_install_database = new wpdevart_lightbox_database_params(); // create object
		
		$this->database_parametrs = $lightbox_install_database->installed_options; // connect initials variables to class
		
	}
	
	/*###################### Library function ##################*/	
	
	private function include_library(){
		
		require_once(wpdevart_lightbox_plugin_path.'includes/library.php'); // library for lightbox
				
		
	}
	
	/*###################### Admin menu function ##################*/	
	
	private function create_admin_menu(){
		
		require_once(wpdevart_lightbox_plugin_path.'includes/admin_menu.php');		
		
		$admin_menu = new wpdevart_lightbox_admin_menu(array('databese_parametrs' =>$this->database_parametrs));		
		
	}	
	
    /*############  Crate front-end function  ################*/		
	
	private function crate_fornt_end(){
		
		require_once(wpdevart_lightbox_plugin_path.'includes/front_end.php');	
			
		$front_end = new wpdevart_lightbox_front_end(array('databese_parametrs' =>$this->database_parametrs));	
		
	}
	
	/*###################### Register required scripts function ##################*/	
	
	public function registr_requeried_scripts(){		
	
		wp_register_script('wpdevart_lightbox_front_end_js',wpdevart_lightbox_plugin_url.'includes/javascript/wpdevart_lightbox_front.js',array('jquery'),'1.0',false);
		wp_register_script('wpdevart_lightbox_admin_scripts',wpdevart_lightbox_plugin_url.'includes/javascript/wpdevart_lightbox_admin_scripts.js');
		wp_register_style('wpdevart_lightbox_front_end_css',wpdevart_lightbox_plugin_url.'includes/style/wpdevart_lightbox_front.css');
		wp_register_style('admin_style_wp_lightbox',wpdevart_lightbox_plugin_url.'includes/style/admin_wpdevart_lightbox.css');	
		wp_register_style('wpdevart_lightbox_effects',wpdevart_lightbox_plugin_url.'includes/style/effects_lightbox.css');
		wp_register_style('jquery-ui-style',wpdevart_lightbox_plugin_url.'includes/style/jquery-ui-style.css');
		
		
	}

	/*############ Call base function ################*/
		
	public function call_base_filters(){
		
		add_action( 'init',  array($this,'registr_requeried_scripts') );
		//for_upgrade
		add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array($this,'plugin_activate_sublink') );
		
	}
	
	/*############ Activate sub-link function ################*/
	
	public function plugin_activate_sublink($links){
		$plugin_submenu_added_link=array();		
		 $added_link = array(
		 '<a target="_blank" style="color: #7052fb; font-weight: bold; font-size: 13px;" href="http://wpdevart.com/wordpress-lightbox-plugin">Upgrade to Pro</a>',
		 );
		$plugin_submenu_added_link=array_merge( $plugin_submenu_added_link, $added_link );
		$plugin_submenu_added_link=array_merge( $plugin_submenu_added_link, $links );
		return $plugin_submenu_added_link;
	}
  	

}
$wpdevart_lightbox = new wpdevart_lightbox();