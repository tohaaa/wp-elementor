 
<?php
/**
 * Plugin Name: Artem Custom Plugin
 * Description: Plugin feito por Artem para testar o elementor e as suas funcionalidades.
 * Plugin URI:  https://elementor.com/
 * Version:     1.0.0
 * Author:      Artem para Elementor
 * Author URI:  https://elementor.com/
 * Text Domain: elementor-test-extension
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

 



function my_admin_menu() {
		add_menu_page(
			__( 'Artem', 'my-textdomain' ),
			__( 'Artem', 'my-textdomain' ),
			'manage_options',
			'sample-page',
			'my_admin_page_contents',
			'dashicons-sos'
		);
	}
add_action( 'admin_menu', 'my_admin_menu' );


function my_admin_page_contents() {
    ?>
        <h1>
            <?php esc_html_e( 'Welcome to my custom admin page.', 'my-plugin-textdomain' ); ?>
        </h1>
    <?php
}




 
    
function add_elementor_widget_categories( $elements_manager ) {
  $elements_manager->add_category(
    'Artem',
    [
      'title' => __( 'Artem', 'elementor' ),
      'icon' => 'fa fa-arrow-up',
    ]
  );
}
add_action('elementor/elements/categories_registered','add_elementor_widget_categories');
 


final class Elementor_Test_Extension {
	const VERSION = '1.0.0';
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';
	const MINIMUM_PHP_VERSION = '7.0';
    
	private static $_instance = null;
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __construct() {
		add_action( 'init', [ $this, 'i18n' ] );
		add_action( 'plugins_loaded', [ $this, 'init' ]);
	}

	public function i18n() {
		load_plugin_textdomain( 'elementor-test-extension' );
	}


	public function init() {
		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}
		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}
		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}
        
        // Register Widget Styles
		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'widget_styles' ] );
        
        
        // Register Widget Scripts
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );

        
		// Add Plugin actions
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
        

	}

    public function widget_styles() {
        wp_enqueue_style('style', plugin_dir_url( __FILE__ ) . '/css/style1.css?v=2.0');
	}
    
    public function widget_scripts() {
		wp_enqueue_script( 'script', plugins_url( 'js/script.js?v=omnibees', __FILE__ ) );
	}
    
    public function init_widgets() {
		// Include Widget files
		require_once( __DIR__ . '/widgets/test-widget.php' );
		// Register widget
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Elementor_Test_Widget());
	}
    

    
    
    
	public function admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'elementor-test-extension' ),
			'<strong>' . esc_html__( 'Elementor Test Extension', 'elementor-test-extension' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'elementor-test-extension' ) . '</strong>'
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}
	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-test-extension' ),
			'<strong>' . esc_html__( 'Elementor Test Extension', 'elementor-test-extension' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'elementor-test-extension' ) . '</strong>',
			 self::MINIMUM_ELEMENTOR_VERSION
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}
	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-test-extension' ),
			'<strong>' . esc_html__( 'Elementor Test Extension', 'elementor-test-extension' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'elementor-test-extension' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}	 
}

Elementor_Test_Extension::instance();