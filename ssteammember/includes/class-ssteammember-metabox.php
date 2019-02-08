<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2/7/2019
 * Time: 4:42 PM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'SSTeamMemberMetabox' ) ) {
	class SSTeamMemberMetaBox {
		protected $pluginName;

		function __construct( $pluginName ) {
			$this->pluginName = $pluginName;
			$this->register_metabox();
			$this->save_metabox_fields();
		}

		function save_metabox_fields() {
			add_action( 'save_post', array( $this, 'save_metabox_callback' ) );
		}

		function register_metabox() {
			add_action( 'add_meta_boxes_team-member', array( $this, 'teammember_metabox' ) );
		}

		function teammember_metabox() {
			add_meta_box(
				$this->pluginName . "_metabox",
				__( 'Personal Detail' ),
				array( $this, 'render_metabox' ),
				'team-member',
				'normal',
				'high'
			);
		}

		function render_metabox( $post ) {
			wp_nonce_field( $this->pluginName . "_nonce", $this->pluginName . "_nonce_field" );
			?>
            <div class="sscbox" id="frmAddMateri">
                <p class="ss-field">
                    <label for="ssposition"><?php echo __( 'Position' ); ?></label>
                    <input type="text" class="soal regular-text" name="ssposition" id="ssposition"
                           value="<?php echo get_post_meta( $post->ID, 'ssposition', true ); ?>" required>
                </p>
                <p class="ss-field">
                    <label for="ssemail"><?php echo __( 'Email' ); ?></label>
                    <input type="email" class="ssemail regular-text" name="ssemail" id="ssemail"
                           value="<?php echo get_post_meta( $post->ID, 'ssemail', true ); ?>" required/>
                </p>
                <p class="ss-field">
                    <label for="sswebsite"><?php echo __( 'Website' ); ?></label>
                    <input type="url" class="sswebsite regular-text" name="sswebsite" id="sswebsite"
                           value="<?php echo get_post_meta( $post->ID, 'sswebsite', true ); ?>" required/>
                </p>
                <p class="ss-field">
                    <label for="ssimage"><?php echo __( 'Image' ); ?></label>
                <div class="pimg">
					<?php $ssimageid = get_post_meta( $post->ID, 'ssimage', true ); ?>
                    <div class="imgprev <?php echo ! $ssimageid ? "hidden" : ""; ?>">
                        <img src="<?php echo $ssimageid ? wp_get_attachment_image_url( $ssimageid ) : ""; ?>"/>
                        <input type="hidden" name="ssimage" value="<?php echo $ssimageid; ?>"/>
                        <a href="#" class="rimage">X</a>
                    </div>
                    <button type="button" class="imgselect button"><?php echo __( 'Select Image' ); ?></button>
                </div>
                </p>
            </div>
			<?php
		}

		function save_metabox_callback( $post_id ) {

			if ( ! wp_verify_nonce( $_POST[ $this->pluginName . "_nonce_field" ], $this->pluginName . "_nonce" ) ) {
				return;
			}

			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}

			if ( get_post_type( $post_id ) != "team-member" ) {
				return;
			}

			if ( $parent_id = wp_is_post_revision( $post_id ) ) {
				$post_id = $parent_id;
			}
			$ssfields = [
				'ssposition',
				'ssemail',
				'sswebsite',
				'ssimage',
				'ssimage'
			];
			foreach ( $ssfields as $field ) {
				if ( array_key_exists( $field, $_POST ) ) {
					update_post_meta( $post_id, $field, sanitize_text_field( $_POST[ $field ] ) );
				} else {
					delete_post_meta( $post_id, $field );
				}
			}
		}
	}
}