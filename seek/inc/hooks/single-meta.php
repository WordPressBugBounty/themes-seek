<?php
/**
 * Implement theme metabox.
 *
 * @package Seek
 */
if (!function_exists('seek_add_theme_meta_box')) :

    /**
     * Add the Meta Box
     *
     * @since 1.0.0
     */
    function seek_add_theme_meta_box()
    {

        $screens = array('post', 'page');

        foreach ($screens as $screen) {
            add_meta_box(
                'seek-theme-settings',
                esc_html__('Single Page/Post Layout Settings', 'seek'),
                'seek_render_theme_settings_metabox',
                $screen,
                'normal', 
            	'high'

            );
        }

    }

endif;

add_action('add_meta_boxes', 'seek_add_theme_meta_box');


if ( ! function_exists( 'seek_render_theme_settings_metabox' ) ) :

	/**
	 * Render theme settings meta box.
	 *
	 * @since 1.0.0
	 */
	function seek_render_theme_settings_metabox( $post, $metabox ) {

		$post_id = $post->ID;
		$seek_post_meta_value = get_post_meta($post_id);

		// Meta box nonce for verification.
		wp_nonce_field( basename( __FILE__ ), 'seek_meta_box_nonce' );
		// Fetch Options list.
		$page_layout = get_post_meta($post_id,'seek-meta-select-layout',true);
		$seek_meta_checkbox = get_post_meta($post_id,'seek-meta-checkbox',true);
	?>

	<div class="seek-tab-main">

        <div class="seek-metabox-tab">
            <ul>
                <li>
                    <a id="twp-tab-general" class="twp-tab-active" href="javascript:void(0)"><?php esc_html_e('Layout Settings', 'seek'); ?></a>
                </li>
            </ul>
        </div>

        <div class="seek-tab-content">
            
            <div id="twp-tab-general-content" class="seek-content-wrap seek-tab-content-active">

                <div class="seek-meta-panels">

                    <div class="seek-opt-wrap seek-checkbox-wrap">

                        <input id="seek-meta-checkbox" name="seek-meta-checkbox" type="checkbox" <?php if ( $seek_meta_checkbox ) { ?> checked="checked" <?php } ?> />

                        <label for="seek-meta-checkbox"><?php esc_html_e('Check To Enable Featured Image On Single Page', 'seek'); ?></label>
                    </div>

                    <div class="seek-opt-wrap seek-opt-wrap-alt">
						
						<label><?php esc_html_e('Single Page/Post Layout', 'seek'); ?></label>

	                     <select name="seek-meta-select-layout" id="seek-meta-select-layout">
				            <option value="right-sidebar" <?php selected('right-sidebar',$page_layout);?>>
				            	<?php _e( 'Content - Primary Sidebar', 'seek' )?>
				            </option>
				            <option value="left-sidebar" <?php selected('left-sidebar',$page_layout);?>>
				            	<?php _e( 'Primary Sidebar - Content', 'seek' )?>
				            </option>
				            <option value="no-sidebar" <?php selected('no-sidebar',$page_layout);?>>
				            	<?php _e( 'No Sidebar', 'seek' )?>
				            </option>
			            </select>

			        </div>

                </div>
            </div>

        </div>
    </div>

    <?php
	}

endif;



if ( ! function_exists( 'seek_save_theme_settings_meta' ) ) :

	/**
	 * Save theme settings meta box value.
	 *
	 * @since 1.0.0
	 *
	 * @param int     $post_id Post ID.
	 * @param WP_Post $post Post object.
	 */
	function seek_save_theme_settings_meta( $post_id, $post ) {

		// Verify nonce.
		if ( ! isset( $_POST['seek_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['seek_meta_box_nonce'], basename( __FILE__ ) ) ) {
			  return; }

		// Bail if auto save or revision.
		if ( defined( 'DOING_AUTOSAVE' ) || is_int( wp_is_post_revision( $post ) ) || is_int( wp_is_post_autosave( $post ) ) ) {
			return;
		}

		// Check the post being saved == the $post_id to prevent triggering this call for other save_post events.
		if ( empty( $_POST['post_ID'] ) || $_POST['post_ID'] != $post_id ) {
			return;
		}

		// Check permission.
		if ( 'page' === $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return; }
		} else if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		$seek_meta_checkbox =  isset( $_POST[ 'seek-meta-checkbox' ] ) ? esc_attr($_POST[ 'seek-meta-checkbox' ]) : '';
		update_post_meta($post_id, 'seek-meta-checkbox', sanitize_text_field($seek_meta_checkbox));

		$seek_meta_select_layout =  isset( $_POST[ 'seek-meta-select-layout' ] ) ? esc_attr($_POST[ 'seek-meta-select-layout' ]) : '';
		if(!empty($seek_meta_select_layout)){
			update_post_meta($post_id, 'seek-meta-select-layout', sanitize_text_field($seek_meta_select_layout));
		}
	}

endif;

add_action( 'save_post', 'seek_save_theme_settings_meta', 10, 3 );