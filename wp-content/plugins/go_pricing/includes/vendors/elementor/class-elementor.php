<?php
// Prevent direct call
if ( !defined( 'WPINC' ) ) die;

/**
 * Go Pricing Widget for Elementor
 * Main Class
 */
class GW_GoPricing_Elementor {

    protected static $instance;

    /**
     * Constructor of the class
     */
    private function __construct() {
    }

    /**
     * Return an instance of the class
     *
     * @return object Instance of the class.
     */
    final public static function instance() {
        if ( is_null( static::$instance ) ) {
            static::$instance = new static();
            static::$instance->create();
        }

        return static::$instance;
    }

    /**
     * Disable cloning
     *
     * @return void
     */
    private function __clone() {
    }

    /**
     * Disable unserialization
     *
     * @return void
     */
    private function __wakeup() {
    }

    /**
     * Create function
     *
     * @return void
     */
    protected function create() {

        // Add new Elementor Categories
        add_action( 'elementor/init', array( $this, 'add_elementor_category' ) );

        // Add new scripts & styles
        add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'before_enqueue_scripts' ) );
        add_action( 'elementor/editor/before_enqueue_styles', array( $this, 'before_enqueue_styles' ) );

        // Register New Widget
        add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widget' ) );

    }

    /**
     * Add editor before styles
     *
     * @return void
     */
    public function before_enqueue_styles() {
        $plugin_globals = GW_GoPricing::instance();
        wp_enqueue_style(
            $plugin_globals['plugin_slug'] . '-elementor-widget',
            $plugin_globals['plugin_url'] . 'includes/vendors/elementor/assets/widget.css',
            array(),
            $plugin_globals['plugin_version']
        );
    }

    /**
     * Add editor before scripts
     *
     * @return void
     */
    public function before_enqueue_scripts() {
        $plugin_globals = GW_GoPricing::instance();
        wp_enqueue_script(
            $plugin_globals['plugin_slug'] . '-elementor-widget',
            $plugin_globals['plugin_url'] . 'includes/vendors/elementor/assets/widget.js',
            array( 'jquery' ),
            $plugin_globals['plugin_version'],
            true
        );
    }

    /**
     * Add Elementor category if not registered
     *
     * @return void
     */
    public function add_elementor_category() {
        if ( !array_key_exists(
            'granth-elements',
            ( \Elementor\Plugin::instance()->elements_manager->get_categories() )
        ) ) {

            \Elementor\Plugin::instance()->elements_manager->add_category(
                'granth-elements',
                array( 'title' => __( 'Granth Elements', 'go_pricing_textdomain' ) ),
                1
            );

        }
    }

    /**
     * Register the  widget
     *
     * @return void
     */
    public function register_widget() {
        $plugin_globals = GW_GoPricing::instance();
        require_once( $plugin_globals['plugin_path'] . 'includes/vendors/elementor/class-elementor-widget.php' );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(
            new \Elementor\GW_GoPricing_Elementor_Widget()
        );

    }
}
