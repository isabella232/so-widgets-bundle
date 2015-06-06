<?php

class SiteOrigin_Widget_Field_TinyMCE extends SiteOrigin_Widget_Field_Text_Input_Base {
	/**
	 * The number of visible rows in the textarea.
	 *
	 * @access protected
	 * @var int
	 */
	protected $rows = 10;
	/**
	 * The editor to be displayed initially.
	 *
	 * @access protected
	 * @var string
	 */
	protected $default_editor = 'tinymce';
	/**
	 * The editor initial height.
	 *
	 * @access protected
	 * @var int
	 */
	protected $editor_height = 200;

	protected function render_field( $value, $instance ) {

		$settings = array(
			'textarea_name' => esc_attr( $this->element_name ),
			'default_editor' => $this->default_editor,
			'textarea_rows' => $this->rows,
			'editor_height' => $this->editor_height,
			'tinymce' => array(
				'wp_skip_init' => strpos( $this->element_id, '__i__' ) >= 0
			)
		);
		$this->javascript_variables['mceSettings'] = $settings;
		$this->javascript_variables['qtSettings'] = array();

		?>
		<div class="siteorigin-widget-tinymce-container">
			<?php
			wp_editor( $value, esc_attr( $this->element_id ), $settings )
			?>
			<input type="hidden" name="<?php echo esc_attr( $this->element_name) ?>" value="<?php echo esc_attr( $value ) ?>">
		</div>
		<?php

		if( $this->default_editor == 'html' ) {
			remove_filter( 'the_editor_content', 'wp_htmledit_pre' );
		}
		if( $this->default_editor == 'tinymce' ) {
			remove_filter( 'the_editor_content', 'wp_richedit_pre' );
		}
	}

	public function enqueue_scripts() {
		wp_enqueue_script( 'so-tinymce-field', plugin_dir_url(__FILE__) . 'js/so-tinymce-field' . SOW_BUNDLE_JS_SUFFIX . '.js', array( 'jquery', 'editor', 'quicktags' ), SOW_BUNDLE_VERSION );
	}
}