<?php

namespace paulo\api\routes;

class student extends routeBase {

	public function request_args() {
		return [];
	}


	public function get_items_permissions_check( \WP_REST_Request $request ): bool {
		return true;
	}


	public function create_item_permissions_check( \WP_REST_Request $request ): bool {
		return current_user_can( 'manage_options' );
	}

	protected function route_base(): string {
		return 'scholars';
	}
}
