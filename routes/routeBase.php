<?php

namespace paulo\api\routes;

use paulo\api\interfaces\route;
use paulo\api\responses\error;
use paulo\api\responses\response;

/**
 * @author Paulo
 */
abstract class routeBase implements route {

	public function add_routes( $namespace ) {
		$base = $this->route_base();

		register_rest_route( $namespace, '/' . $base, [
				[
					'methods'         => \WP_REST_Server::READABLE,
					'callback'        => [ $this, 'get_items' ],
					'permission_callback' => [ $this, 'get_items_permissions_check' ],
					'args'            => [
						'page' => [
							'default' => 1,
							'sanitize_callback'  => 'absint',
						],
						'limit' => [
							'default' => 10,
							'sanitize_callback'  => 'absint',
						]
					],
				],
				[
					'methods'         => \WP_REST_Server::CREATABLE,
					'callback'        => [ $this, 'create_item' ],
					'permission_callback' => [ $this, 'create_item_permissions_check' ],
					'args'            => $this->request_args()
				],
			]
		);


		register_rest_route( $namespace, '/' . $base . '/(?P<id>\d+)', [
				[
					'methods'             => \WP_REST_Server::READABLE,
					'callback'            => [ $this, 'get_item' ],
					'permission_callback' => [ $this, 'get_item_permissions_check' ],
					'args'                => [
						'id' => [
							'validate_callback' => function($param, $request, $key) {
								return is_numeric( $param );
							}
						],
						'context' => [
							'default' => 'view',
						]
					],
				],
				[
					'methods'             => \WP_REST_Server::EDITABLE,
					'callback'            => [ $this, 'update_item' ],
					'permission_callback' => [ $this, 'update_item_permissions_check' ],
					'args'                => $this->request_args(  )
				],
				[
					'methods'             => \WP_REST_Server::DELETABLE,
					'callback'            => [ $this, 'delete_item' ],
					'permission_callback' => [ $this, 'delete_item_permissions_check' ],
					'args'                => [
						'force' => [
							'default'  => false,
							'required' => false,
						],
						'all'   => [
							'default'  => false,
							'required' => false,
						],
						'id'    => [
							'default'               => 0,
							'sanatization_callback' => 'absint'
						]
					],
				],
			]
		);
	}

	abstract public function request_args();

	// Permissions
	abstract public function get_items_permissions_check( \WP_REST_Request $request );
	public function get_item_permissions_check( \WP_REST_Request $request ) {
		return $this->get_items_permissions_check(  $request );

	}

	abstract public function create_item_permissions_check( \WP_REST_Request $request );
	public function update_item_permissions_check( \WP_REST_Request $request ) {
		return $this->create_item_permissions_check( $request );
	}
	public function delete_item_permissions_check( \WP_REST_Request $request ) {
		return $this->create_item_permissions_check( $request );
	}



	// Callbacks
	public function get_item( \WP_REST_Request $request ): response {
		return $this->not_route_yet();
	}

	public function get_items( \WP_REST_Request $request ): response {
		return $this->not_route_yet();
	}

	public function create_item( \WP_REST_Request $request ): response {
		return $this->not_route_yet();
	}

	public function update_item( \WP_REST_Request $request ): response {
		return $this->not_route_yet();
	}

	public function delete_item( \WP_REST_Request $request ): response {
		return $this->not_route_yet();
	}



	protected function not_route_yet() {
		$error =  new error( 'not-implemented-yet', __( 'Route Not Yet Implemented!', 'your-domain' )  );
		return new response( $error, 501, [] );
	}


	protected function route_base() {
		return substr( strrchr( get_class( $this ), '\\' ), 1 );
	}

}
