<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


/**
 * BP_API_Component class.
 * 
 * @extends BP_Component
 */
class BP_API_Component extends BP_Component {

	/**
	 * Constructor method
	 *
	 * @package BP json API
	 * @since 0.1
	 */
	function __construct() {
		global $bp;

		parent::start(
			'api',
			__( 'Api', 'bp-api' ),
			BP_API_PLUGIN_DIR
		);

	}


	/**
	 * includes function.
	 * 
	 * @access public
	 * @param array $includes (default: array())
	 * @return void
	 */
	function includes( $includes = array() ) {

		// Files to include
		$includes = array(
			'includes/endpoints/bp-activity-json.php',
			  //'includes/endpoints/bp-blogs-json.php',
			  //'includes/endpoints/bp-messages-json.php',
			'includes/endpoints/bp-members-json.php',
			  //'includes/endpoints/bp-settings-json.php',
			'includes/endpoints/bp-xprofile-json.php',
			  //'includes/endpoints/bp-notifications-json.php',
			  //'includes/endpoints/bp-forums-json.php',
			  //'includes/endpoints/bp-friends-json.php',
			'includes/endpoints/bp-core-json.php',
			  //'includes/endpoints/bp-groups-json.php'
		);

		parent::includes( $includes );

	}
}

buddypress()->api = new BP_API_Component;
