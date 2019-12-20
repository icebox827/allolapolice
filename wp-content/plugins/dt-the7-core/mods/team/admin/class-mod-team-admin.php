<?php
/**
 * Team admin part.
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Presscore_Mod_Team_Admin {

	public function register_post_types() {
		$post_type = 'dt_team';
		$args      = array(
			'labels'             => array(
				'name'               => _x( 'Team', 'backend team', 'dt-the7-core' ),
				'singular_name'      => _x( 'Teammate', 'backend team', 'dt-the7-core' ),
				'add_new'            => _x( 'Add New', 'backend team', 'dt-the7-core' ),
				'add_new_item'       => _x( 'Add New Teammate', 'backend team', 'dt-the7-core' ),
				'edit_item'          => _x( 'Edit Teammate', 'backend team', 'dt-the7-core' ),
				'new_item'           => _x( 'New Teammate', 'backend team', 'dt-the7-core' ),
				'view_item'          => _x( 'View Teammate', 'backend team', 'dt-the7-core' ),
				'search_items'       => _x( 'Search Teammates', 'backend team', 'dt-the7-core' ),
				'not_found'          => _x( 'No teammates found', 'backend team', 'dt-the7-core' ),
				'not_found_in_trash' => _x( 'No Teammates found in Trash', 'backend team', 'dt-the7-core' ),
				'parent_item_colon'  => '',
				'menu_name'          => _x( 'Team', 'backend team', 'dt-the7-core' ),
			),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'dt_team' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => 37,
			'supports'           => array( 'title', 'editor', 'comments', 'excerpt', 'thumbnail' ),
			'show_in_rest'       => true,
		);

		$args = apply_filters( "presscore_post_type_{$post_type}_args", $args );

		register_post_type( $post_type, $args );
	}

	public function register_taxonomies() {
		$post_type = 'dt_team';
		$taxonomy  = 'dt_team_category';
		$args      = array(
			'labels'            => array(
				'name'              => _x( 'Team Categories', 'backend team', 'dt-the7-core' ),
				'singular_name'     => _x( 'Team Category', 'backend team', 'dt-the7-core' ),
				'search_items'      => _x( 'Search in Team Category', 'backend team', 'dt-the7-core' ),
				'all_items'         => _x( 'Team Categories', 'backend team', 'dt-the7-core' ),
				'parent_item'       => _x( 'Parent Team Category', 'backend team', 'dt-the7-core' ),
				'parent_item_colon' => _x( 'Parent Team Category:', 'backend team', 'dt-the7-core' ),
				'edit_item'         => _x( 'Edit Team Category', 'backend team', 'dt-the7-core' ),
				'update_item'       => _x( 'Update Team Category', 'backend team', 'dt-the7-core' ),
				'add_new_item'      => _x( 'Add New Team Category', 'backend team', 'dt-the7-core' ),
				'new_item_name'     => _x( 'New Team Category Name', 'backend team', 'dt-the7-core' ),
				'menu_name'         => _x( 'Team Categories', 'backend team', 'dt-the7-core' ),
			),
			'hierarchical'      => true,
			'public'            => true,
			'show_ui'           => true,
			'rewrite'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
		);

		$args = apply_filters( "presscore_taxonomy_{$taxonomy}_args", $args );

		register_taxonomy( $taxonomy, array( $post_type ), $args );
	}

	public function add_meta_boxes( $metaboxes ) {
		$metaboxes[] = plugin_dir_path( __FILE__ ) . 'metaboxes/metaboxes-team.php';

		return $metaboxes;
	}

	public function add_basic_meta_boxes_support( $pages ) {
		$pages[] = 'dt_team';

		return $pages;
	}

	public function add_options( $options ) {
		if ( array_key_exists( 'of-blog-and-portfolio-menu', $options ) ) {
			$options['of-team-mod-injected-slug-options'] = plugin_dir_path( __FILE__ ) . 'options/options-slug-team.php';
		}

		return $options;
	}

	public function render_bulk_actions( $col, $type ) {
		if ( $type !== 'dt_team' || $col !== 'presscore-thumbs' ) {
			return;
		}

		$no_change_option = '<option value="-1">' . _x( '&mdash; No Change &mdash;', 'backend bulk edit', 'dt-the7-core' ) . '</option>';
		?>
        <div class="clear"></div>
        <div class="presscore-bulk-actions">
            <fieldset class="inline-edit-col-left">
                <legend class="inline-edit-legend"><?php _ex( 'Link options', 'backend bulk edit', 'dt-the7-core' ); ?></legend>
                <div class="inline-edit-col">
                    <div class="inline-edit-group">
                        <label class="alignleft">
                            <span class="title"><?php _ex( 'Link to page', 'backend bulk edit', 'dt-the7-core' ) ?></span>
							<?php
							$show_wf = array(
								1 => _x( 'Yes', 'backend bulk edit footer', 'dt-the7-core' ),
								0 => _x( 'No', 'backend bulk edit footer', 'dt-the7-core' ),
							);
							?>
                            <select name="_dt_bulk_edit_go_to_single">
								<?php echo $no_change_option ?>
								<?php foreach ( $show_wf as $value => $title ): ?>
                                    <option value="<?php echo $value ?>"><?php echo $title ?></option>
								<?php endforeach ?>
                            </select>
                        </label>
                    </div>
                </div>
            </fieldset>
        </div>
		<?php
	}

	function handle_bulk_actions( $post_ID, $post ) {
		if ( $post->post_type !== 'dt_team' ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Verify this came from the our screen and with proper authorization,
		// because save_post can be triggered at other times.
		if ( ! check_ajax_referer( 'bulk-posts', false, false ) ) {
			return;
		}

		// Check permissions.
		if ( ! current_user_can( 'edit_page', $post_ID ) ) {
			return;
		}

		if ( isset( $_REQUEST['_dt_bulk_edit_go_to_single'] ) && $_REQUEST['_dt_bulk_edit_go_to_single'] !== '-1' ) {
			update_post_meta( $post_ID, '_dt_teammate_options_go_to_single', (int) $_REQUEST['_dt_bulk_edit_go_to_single'] );
		}
	}

}
