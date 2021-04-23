<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.crestinfosystems.com
 * @since      1.0.0
 *
 * @package    Skins_Mirakl_Api
 * @subpackage Skins_Mirakl_Api/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Skins_Mirakl_Api
 * @subpackage Skins_Mirakl_Api/includes
 * @author     Crest Infosystem Pvt Ltd <chirag.parmar@crestinsosystems.com>
 */
class Skins_Mirakl_Api_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'skins-mirakl-api',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
