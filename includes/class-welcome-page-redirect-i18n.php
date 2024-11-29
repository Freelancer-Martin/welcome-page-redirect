<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       developerforwebsites@gmail.com
 * @since      1.0.0
 *
 * @package    Welcome_Page_Redirect
 * @subpackage Welcome_Page_Redirect/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Welcome_Page_Redirect
 * @subpackage Welcome_Page_Redirect/includes
 * @author     Freelancer Martin <developerforwebsites@gmail.com>
 */
class Welcome_Page_Redirect_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'welcome-page-redirect',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
