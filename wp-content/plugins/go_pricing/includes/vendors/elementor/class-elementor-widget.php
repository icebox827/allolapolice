<?php

namespace Elementor;

// Prevent direct call
if ( !defined( 'WPINC' ) ) die;

/**
 * Go Pricing Module for Elementor
 * Module Class
 */
class GW_GoPricing_Elementor_Widget extends Widget_Base {

    /**
     * Return name of the module
     *
     * @return string Name of the module
     */
    public function get_name() {
        return 'go-pricing';
    }

    /**
     * Return title of the module
     *
     * @return string Title of the module
     */

    public function get_title() {
        return __( 'Go Pricing', 'go_pricing_textdomain' );
    }

    /**
     * Return icon of the module
     *
     * @return string Icon of the module
     */

    public function get_icon() {
        return 'elementor-go-pricing-icon';
    }

    /**
     * Return categories
     *
     * @return array List of available categories
     */
    public function get_categories() {
        return array( 'granth-elements' );
    }

    /**
     * Register Controls of the module
     *
     * @return void
     */
    protected function _register_controls() {

        $pricing_tables = \GW_GoPricing_Data::get_tables( '', false, 'title', 'ASC' );

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

        $this->start_controls_section(
            'section_content',
            array(
                'label' => __( 'Pricing Table', 'go_pricing_textdomain' ),
            )
        );

        // Select
        $this->add_control(
            'go_pricing--id',
            array(
                'label' => __( 'Select Table', 'go_pricing_textdomain' ),
                'type' => Controls_Manager::SELECT,
                //'options' => $tl_select_options,
                'options' => $dropdown_data,
                //'default' => 'h1',
            )
        );

        // Edit button
        $url_base = add_query_arg(
            array( 'page' => 'go-pricing', 'action' => 'edit', 'id' => '' ),
            admin_url( 'admin.php' )
        );
        $btn_text = esc_html__( 'Edit Pricing Table', 'go_pricing_textdomain' );

        $this->add_control(
            'html_msg',
            array(
                'type' => Controls_Manager::RAW_HTML,
                'raw' => sprintf(
                    '<a data-url-base="%1$s" href="#" title="%2$s" target="_blank" class="go-pricing_btn-edit-table">%3$s</a>',
                    $url_base,
                    esc_attr( $btn_text ),
                    $btn_text
                )
            )
        );
		
        $this->add_control(
            'html_msg2',
            array(
                'type' => Controls_Manager::RAW_HTML,
                'raw' => '<p style="line-height: 16px;">' . esc_html__( 'Table animations are disabled in Elementor Editor!', 'go_pricing_textdomain' ) . '</p>'
            )
        );		
    }

    /**
     * Render function of the module
     * @return void
     */
    protected function render() {
        $setting = !is_null( $setting = $this->get_settings( 'go_pricing--id' ) ) ? $setting : '';
        $setting_values = explode(
            '--',
            $setting,
            2
        );

        echo do_shortcode(
            sprintf(
                '[go_pricing id="%s"]',
                isset( $setting_values[1] ) ? $setting_values[1] : ''
            )
        );

    }

}