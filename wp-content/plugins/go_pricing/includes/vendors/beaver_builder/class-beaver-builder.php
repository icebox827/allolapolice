<?php
// Prevent direct call
if ( !defined( 'WPINC' ) ) die;

/**
 * Go Pricing Module for Beaver Builder
 * Main Class
 */
class GW_GoPricing_BeaverBuilder {

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
        $this->load_includes();
        add_action( 'init', array( $this, 'register_module' ) );
        add_filter( 'fl_builder_custom_fields', array( $this, 'register_custom_fields' ) );
    }

    /**
     * Load required files
     *
     * @return void
     */
    protected function load_includes() {
        $plugin_globals = GW_GoPricing::instance();
        require_once( $plugin_globals['plugin_path'] . 'includes/vendors/beaver_builder/class-beaver-builder-module.php' );			
    }

    /**
     * Register custom fields
     *
     * @return void
     */
    public function register_custom_fields( $fields ) {
        $plugin_globals = GW_GoPricing::instance();        
		$fields['go-pricing_btn-edit-table'] = $plugin_globals['plugin_path'] . 'includes/vendors/beaver_builder/includes/field_custom_button.php';	
		$fields['go-pricing_html'] = $plugin_globals['plugin_path'] . 'includes/vendors/beaver_builder/includes/field_custom_html.php';			
        return $fields;
    }

    /**
     * Register the module
     *
     * @return void
     */
    public function register_module() {

        $pricing_tables = GW_GoPricing_Data::get_tables( '', false, 'title', 'ASC' );

        if ( !empty( $pricing_tables ) ) {
            foreach ( $pricing_tables as $pricing_table ) {
                if ( !empty( $pricing_table['name'] ) && !empty( $pricing_table['id'] ) ) {
                    $dropdown_data[sprintf( '%1$s--%2$s', $pricing_table['postid'], $pricing_table['id'] )] = sprintf(
                        '%1$s (#%2$s)',
                        $pricing_table['name'],
                        $pricing_table['postid']
                    );
                }
            }
        }

        if ( empty( $dropdown_data ) ) $dropdown_data[0] = __( 'No tables found!', 'go_pricing_textdomain' );

        // Register the module
        FLBuilder::register_module(
            'GW_GoPricing_BeaverBuilderModule',
            array(
                'general' => array( // Tab
                    'title' => __( 'General', 'go_pricing_textdomain' ), // Tab title
                    'sections' => array( // Tab Sections
                        'general' => array( // Section
                            'fields' => array( // Section Fields
                                'go_pricing--id' => array(
                                    'type' => 'select',
                                    'label' => __( 'Select Table', 'go_pricing_textdomain' ),
                                    'options' => $dropdown_data
                                ),
                                'go-pricing_btn-edit-table' => array(
                                    'type' => 'go-pricing_btn-edit-table'
                                ),
                                'go-pricing_html' => array(
                                    'type' => 'go-pricing_html'
                                ),								
                            )
                        )
                    )
                )
            )
        );

    }
}
