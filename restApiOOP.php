<?php
/**
 * Plugin Name: Rest Api OOP
 * Description: A REST API OOP implementation
 * Author: Paulo Carvajal
 * Version: 1.0
 */

namespace paulo\api;




use paulo\api\routes\student;
use paulo\api\routes\teacher;
use paulo\api\util\apiGroup;

class restApiOOP {

	private static restApiOOP $instance;

	protected array $routes;

	protected string $namespace;

	public static function getInstance(): restApiOOP {
		static::$instance = static::$instance ?? new static();
		return static::$instance;
	}

	// singleton constructs should be protected
	protected function __construct() {}


	public function init() {
		$this->create_plugin_constants();

		add_action( 'plugins_loaded', [ $this, 'auto_load' ] );
		add_action( 'rest_api_init', [ $this, 'init_api'] );
	}

	public function create_plugin_constants() {
		$constant_name_prefix = 'API_';
		$plugin_data = get_file_data( __FILE__, array( 'name'=>'Plugin Name', 'version'=>'Version', 'text'=>'Text Domain' ) );
		define( $constant_name_prefix . 'DIR', dirname( plugin_basename( __FILE__ ) ) );
		define( $constant_name_prefix . 'BASE', plugin_basename( __FILE__ ) );
		define( $constant_name_prefix . 'URL', plugin_dir_url( __FILE__ ) );
		define( $constant_name_prefix . 'PATH', plugin_dir_path( __FILE__ ) );
		define( $constant_name_prefix . 'NAME', $plugin_data['name'] );
		define( $constant_name_prefix . 'VERSION', $plugin_data['version'] );
	}

	public function auto_load() {
		if (file_exists(__DIR__ . '/vendor/autoload.php')) {
			include __DIR__ . '/vendor/autoload.php';
		}
	}

	public function init_api() {

		$teacher = new teacher();
		$student = new student();

		$api = new apiGroup( 'school/v1' );
		$api->add_route($teacher);
		$api->add_route($student);
		$api->add_routes();
	}
}

restApiOOP::getInstance()->init();
