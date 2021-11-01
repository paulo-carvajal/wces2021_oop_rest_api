<?php

namespace paulo\api\routes;

use paulo\api\responses\response;

class teacher extends routeBase {

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
		return 'teacher';
	}


	public function get_item( \WP_REST_Request $request ): response {
		$url_params = $request->get_url_params();
		// $post = get_post(  $url_params[ 'id' ] );
		$post = ['response'=> 'OK'];
		if( ! empty( $post )  ){
			return new response( $url_params, 200, [] );
		}
		return new response( [], 404, [] );
	}

	public function get_items( \WP_REST_Request $request ): response {
		$post = ['response'=> 'OK'];
		if( ! empty( $post )  ){
			return new response( $post, 200, [] );
		}
		return new response( [], 404, [] );
	}

}
