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
			$ssTemplate = new SSTeamMemberTemplate( plugin_dir_path( dirname( __FILE__ ) ) . 'templates' );
			//render the template
			echo $ssTemplate->render( 'teammember-admin-form', array(
				'pluginName' => $this->pluginName,
				'post_id'    => $post->ID
			) );
			?>
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
				"_position",
				"_email",
				"_website",
				"_image_id",
			];
			foreach ( $ssfields as $field ) {
				if ( array_key_exists( $this->pluginName . $field, $_POST ) ) {
					update_post_meta( $post_id, $this->pluginName . $field, sanitize_text_field( $_POST[ $this->pluginName . $field ] ) );
				}
			}
		}
	}
}