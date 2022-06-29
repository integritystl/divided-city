<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ES_Drag_And_Drop_Editor {

	public static $instance;

	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );
	}

	public static function is_dnd_editor_page() {

		$is_dnd_editor_page = false;

		if ( ES()->is_es_admin_screen() ) {
			
			$current_page = ig_es_get_request_data( 'page' );

			if ( 'es_drag_and_drop' === $current_page ) {
				$is_dnd_editor_page = true;
			} else {
				$edit_campaign_pages = array(
					'es_notifications',
					'es_newsletters',
				);
		
				$is_edit_campaign_page = in_array( $current_page, $edit_campaign_pages, true );
		
				if ( $is_edit_campaign_page ) {
					$editor_type        = ig_es_get_request_data( 'editor-type' );
					$is_dnd_editor_page = IG_ES_DRAG_AND_DROP_EDITOR === $editor_type;
				}
			}
		}
		
		return $is_dnd_editor_page;

	}

	public function enqueue_scripts() {

		if ( ! self::is_dnd_editor_page() ) {
			return;
		}

		//Only for development - this branch only
		//wp_register_script( 'es_editor_js', 'http://localhost:9001/main.js', array(), time(), true );
		wp_register_script( 'es_editor_js', ES_PLUGIN_URL . 'lite/admin/js/editor.js', array( ), ES_PLUGIN_VERSION, true );
		wp_enqueue_script( 'es_editor_js' );
		wp_enqueue_media();
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    4.0
	 */
	public function enqueue_styles() {

		if ( ! self::is_dnd_editor_page() ) {
			return;
		}
		
		//wp_enqueue_style( 'es_editor_css', 'http://localhost:9000/main.css', array(), time(), 'all' );
		wp_enqueue_style( 'es_editor_css', ES_PLUGIN_URL . 'lite/admin/css/editor.css', array(), ES_PLUGIN_VERSION, 'all' );
	}

	public function es_draganddrop_callback() {
		?>
		<div class="mt-6 mr-6 p-2 rounded-lg border-dashed border bg-white">
			<div class="text-xl leading-relaxed ">
				<?php esc_html_e('How to use this?', 'email-subscribers'); ?>
			</div>
			<div class="text-sm">
				<?php esc_html_e('Create the content by dragging elements displayed on the right. After you are done click on "Export HTML" ', 'email-subscribers'); ?><span title="Export HTML " class="fa fa-download"></span>
				<?php esc_html_e(' to get your html content. Use it while sending campaigns.', 'email-subscribers'); ?>
			</div>
		</div>
		<div id="ig-es-dnd-builder"></div>
	   <?php
	}

	public function show_editor( $editor_args = array() ) {
		$editor_attributes = ! empty( $editor_args['attributes'] ) ? $editor_args['attributes'] : array();
		?>
		<div id="ig-es-dnd-builder"
			<?php
			if ( ! empty( $editor_attributes ) ) :
				foreach ( $editor_attributes as $arg_key => $arg_value ) :
					echo esc_attr( $arg_key ) . '="' . esc_attr( $arg_value ) . '" ';
				endforeach;
			endif;
			?>
		>
		</div>
		<?php
	}

	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}

ES_Drag_And_Drop_Editor::get_instance();
