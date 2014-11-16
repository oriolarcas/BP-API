<?php
/**
 * bp API Activity.
 *
 * Activity api endpoints.
 *
 * @package bp
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * bp_api_activity_init function.
 *
 * initializes api class for activity and creates endpoints
 *
 * @access public
 * @return void
 */
function bp_api_activity_init() {
	global $bp_api_activity;

	$bp_api_activity = new BP_API_Activity();
	add_filter( 'json_endpoints', array( $bp_api_activity, 'register_routes' ) );

}
add_action( 'wp_json_server_before_serve', 'bp_api_activity_init' );


/**
 * BP_API_Activity class.
 */
class BP_API_Activity {


	/**
	 * register_routes function.
	 *
	 * @access public
	 * @param mixed $routes
	 * @return void
	 */
	public function register_routes( $routes ) {
	
		$activity_routes = array(
			'/bp/activity' => array(
				array( array( $this, 'get_activity_all'), WP_JSON_Server::READABLE ) ),
			'/bp/activity/groups' => array(
				array( array( $this, 'get_activity_groups'), WP_JSON_Server::READABLE ) ),
			'/bp/activity/mentions' => array(
				array( array( $this, 'get_activity_groups'), WP_JSON_Server::READABLE ) )
			);

		return array_merge($routes, $activity_routes);
	}

	/**
	 * get_activity function.
	 *
	 * @access public
	 * @return void
	 */
	private function get_activity($args) {
		global $bp;

		if ( bp_has_activities( $args ) ) {

			while ( bp_activities() ) {

				bp_the_activity();

				$activity = array(
					'avatar'    		=> bp_core_fetch_avatar( array( 'html' => false, 'item_id' => bp_get_activity_id() ) ),
					'action'    		=> bp_get_activity_action(),
					'content'    		=> bp_get_activity_content_body(),
					'activity_id'  		=> bp_get_activity_id(),
					'activity_username' => bp_core_get_username( bp_get_activity_user_id() ),
					'user_id'   		=> bp_get_activity_user_id(),
					'comment_count'  	=> bp_activity_get_comment_count(),
					'can_comment'   	=> bp_activity_can_comment(),
					'can_favorite'   	=> bp_activity_can_favorite(),
					'is_favorite'   	=> bp_get_activity_is_favorite(),
					'can_delete'  		=> bp_activity_user_can_delete()
				);

				$activities[] =  $activity;

				$response = array(
					'activity' => $activities,
					'more_activity' => bp_activity_has_more_items()
				);

			}

			return $response;
		} else {
			return wp_send_json_error();
		}


	}
	
	public function get_activity_all() {
		return $this->get_activity(array('scope' => 'all'));
	}
	
	public function get_activity_groups() {
		return $this->get_activity(array('scope' => 'groups'));
	}
	
	public function get_activity_mentions() {
		return $this->get_activity(array('scope' => 'mentions'));
	}
	
	public function create_activity() {
		return 'create activity';
	}

	public function edit_activity() {
		return 'edit activity';
	}

	public function delete_activity() {
		return 'delete activity';
	}

}
