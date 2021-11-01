<?php

namespace paulo\api\util;

use paulo\api\interfaces\route;

class apiGroup {

	protected array $routes;
	protected string $namespace;

	public function __construct( string $namespace ) {
		$this->namespace = $namespace;
	}

	public function add_route( route $route ){
		$this->routes[] = $route;
	}


	public function add_routes(){
		if( ! empty( $this->routes ) ){
			foreach ( $this->routes as $route ){
				$route->add_routes( $this->namespace );
			}
		}
	}
}
