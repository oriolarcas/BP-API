<?php
/**
 * bp API Groups.
 *
 * Groups api endpoints.
 *
 * @package bp
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * bp_api_groups_init function.
 *
 * initializes api class for groups and creates endpoints
 *
 * @access public
 * @return void
 */
function bp_api_groups_init() {
	global $bp_api_groups;

	$bp_api_groups = new BP_API_Groups();
	add_filter( 'json_endpoints', array( $bp_api_groups, 'register_routes' ) );

}
add_action( 'wp_json_server_before_serve', 'bp_api_groups_init' );


/**
 * BP_API_Groups class.
 */
class BP_API_Groups {


	/**
	 * register_routes function.
	 *
	 * @access public
	 * @param mixed $routes
	 * @return void
	 */
	public function register_routes( $routes ) {
	
		$group_routes = array(
			'/bp/groups' => array(
				array( array( $this, 'get_all_groups'), WP_JSON_Server::READABLE ) ),
			'/bp/groups/user/(?P<uid>\d+)' => array(
				array( array( $this, 'get_user_groups'), WP_JSON_Server::READABLE ) )
		);

		return array_merge($routes, $group_routes);
	}


	/**
	 * get_groups function.
	 *
	 * @access public
	 * @return void
	 */
	private function get_groups($args) {
		global $bp;
		
		if ( bp_has_groups( $args ) ) {
		
			$response = array();
			while ( bp_groups( $args ) ) {
			
				bp_the_group();

				$group = array(
					'id' => bp_get_group_id(),
					'name' => bp_get_group_name(),
					'permalink' => bp_get_group_permalink(),
					'type' => bp_get_group_type(),
					'description' => bp_get_group_description_excerpt(),
					'member-count' => bp_get_group_member_count()
					);
				$response[] = $group;
			}

			return $response;
		} else {
			return wp_send_json_error();
		}
		
	}
	
	public function get_all_groups() {
		return $this->get_groups();
	}
	
	public function get_user_groups($uid) {
		return $this->get_groups(array('user_id' => $uid));
	}

	public function create_group() {
		return 'create group';
	}

	public function edit_group() {
		return 'edit group';
	}

	public function delete_group() {
		return 'delete group';
	}

}
