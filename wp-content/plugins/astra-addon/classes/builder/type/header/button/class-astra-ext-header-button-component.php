<?php
/**
 * Button component.
 *
 * @package     Astra Builder
 * @author      Brainstorm Force
 * @copyright   Copyright (c) 2020, Brainstorm Force
 * @link        https://www.brainstormforce.com
 * @since       Astra 3.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'ASTRA_EXT_HEADER_BUTTON_DIR', ASTRA_EXT_DIR . 'classes/builder/type/header/button/' );
define( 'ASTRA_EXT_HEADER_BUTTON_URI', ASTRA_EXT_URI . 'classes/builder/type/header/button/' );

/**
 * Button Initial Setup
 *
 * @since 3.1.0
 */
class Astra_Ext_Header_Button_Component {

	/**
	 * Constructor function that initializes required actions and hooks
	 */
	public function __construct() {

		// @codingStandardsIgnoreStart WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
		require_once ASTRA_EXT_HEADER_BUTTON_DIR . 'classes/class-astra-ext-header-button-component-loader.php';
		// @codingStandardsIgnoreEnd WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
	}
}

/**
 *  Kicking this off by creating an object.
 */
new Astra_Ext_Header_Button_Component();

