<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Smarter_Browser_Warning
 * @subpackage Smarter_Browser_Warning/admin
 * @author     Robert Bokori <robert@smarter.uk.com>
 */
class Smarter_Browser_Warning_Admin {

	private $plugin_name;
	private $version;
	private $settings_page_slug;
	private $settings_name;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 *
	 * @param      string $plugin_name The name of this plugin.
	 * @param      string $version The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name        = $plugin_name;
		$this->version            = $version;
		$this->settings_page_slug = $this->plugin_name;
		$this->settings_name      = 'smarter_browser_warning';

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( 'wp-color-picker' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/smarter-browser-warning-admin.js', array(
			'jquery',
			'wp-color-picker'
		), $this->version, false );

	}

	/**
	 * Register options page
	 */
	public function load_menus() {
		add_submenu_page( 'options-general.php', 'Smarter Browser Warning', 'Browser Support', 'manage_options', $this->settings_page_slug, array(
			$this,
			'settings_page_html'
		) );
	}

	/**
	 * Register setting fields
	 */
	public function settings_init() {

		register_setting(
			$this->settings_name,
			$this->settings_name,
			array( $this, 'sanitize_settings' )
		);

		add_settings_section(
			$this->settings_name . '_configuration',
			__( 'General Configuration', $this->plugin_name ),
			'__return_false',
			$this->settings_name
		);

		add_settings_field(
			$this->settings_name . '_modal_title',
			__( 'Modal Title', $this->plugin_name ),
			array( $this, 'control_modal_title' ),
			$this->settings_name,
			$this->settings_name . '_configuration',
			array(
				"field_name"  => $this->settings_name . '[modal_title]',
				"field_id"    => $this->settings_name . '_modal_title',
				"field_class" => 'large-text'
			)
		);

		add_settings_field(
			$this->settings_name . '_modal_headline',
			__( 'Modal Headline', $this->plugin_name ),
			array( $this, 'control_modal_headline' ),
			$this->settings_name,
			$this->settings_name . '_configuration',
			array(
				"field_name"  => $this->settings_name . '[modal_headline]',
				"field_id"    => $this->settings_name . '_modal_headline',
				"field_class" => 'large-text'
			)
		);

		add_settings_field(
			$this->settings_name . '_modal_text',
			__( 'Modal Text', $this->plugin_name ),
			array( $this, 'control_modal_text' ),
			$this->settings_name,
			$this->settings_name . '_configuration',
			array(
				"field_name"  => $this->settings_name . '[modal_text]',
				"field_id"    => $this->settings_name . '_modal_text',
				"field_class" => 'large-text'
			)
		);

		add_settings_field(
			$this->settings_name . '_title_color',
			__( 'Title Color', $this->plugin_name ),
			array( $this, 'control_title_color' ),
			$this->settings_name,
			$this->settings_name . '_configuration',
			array(
				"field_name"  => $this->settings_name . '[title_color]',
				"field_id"    => $this->settings_name . '_title_color',
				"field_class" => 'color-picker'
			)
		);

		add_settings_field(
			$this->settings_name . '_headline_color',
			__( 'Headline Color', $this->plugin_name ),
			array( $this, 'control_headline_color' ),
			$this->settings_name,
			$this->settings_name . '_configuration',
			array(
				"field_name"  => $this->settings_name . '[headline_color]',
				"field_id"    => $this->settings_name . '_headline_color',
				"field_class" => 'color-picker'
			)
		);

		add_settings_field(
			$this->settings_name . '_text_color',
			__( 'Text Color', $this->plugin_name ),
			array( $this, 'control_text_color' ),
			$this->settings_name,
			$this->settings_name . '_configuration',
			array(
				"field_name"  => $this->settings_name . '[text_color]',
				"field_id"    => $this->settings_name . '_text_color',
				"field_class" => 'color-picker'
			)
		);

		add_settings_section(
			$this->settings_name . '_browsers',
			__( 'Minimum Browser Requirements', $this->plugin_name ),
			'__return_false',
			$this->settings_name
		);

		add_settings_field(
			$this->settings_name . '_internet_explorer',
			__( 'Internet Explorer', $this->plugin_name ),
			array( $this, 'control_internet_explorer' ),
			$this->settings_name,
			$this->settings_name . '_browsers',
			array(
				"field_name"  => $this->settings_name . '[internet_explorer]',
				"field_id"    => $this->settings_name . '_internet_explorer',
				"field_class" => ''
			)
		);
	}

	/**
	 * Settings page callback
	 */
	public function settings_page_html() {
		?>
		<div class="wrap">
			<h2>Smarter Browser Warning</h2>

			<form method="post" action="options.php">
				<?php
				settings_fields( $this->settings_name );
				do_settings_sections( $this->settings_name );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * Get default setting values
	 *
	 * @return array
	 */
	public function get_defaults() {
    return Smarter_Browser_Warning::get_defaults();
	}

	/**
	 * Get plugin settings mixed with defaults
	 *
	 * @return array
	 */
	private function get_settings() {
		return wp_parse_args( (array) get_option( $this->settings_name ), $this->get_defaults() );
	}

	/**
	 * Get plugin setting value
	 *
	 * @param $key
	 *
	 * @return bool
	 */
	private function get_setting( $key ) {

		$settings = $this->get_settings();

		if ( isset( $settings[ $key ] ) ) {
			return $settings[ $key ];
		}

		return false;
	}

	/**
	 * Function that will check if value is a valid HEX color.
	 *
	 * @param $color
	 *
	 * @return bool
	 */
	public function check_color( $color ) {

		if ( preg_match( '/^#[a-f0-9]{6}$/i', $color ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Returns the supported Internet Explorer version numbers
	 *
	 * @return array
	 */
	public function get_internet_explorer_versions() {
		return array( 7, 8, 9, 10, 11, 12 );
	}

	/**
	 * Sanitize setting fields
	 *
	 * @param $input
	 *
	 * @return array
	 */
	public function sanitize_settings( $input ) {

		$valid_fields = $this->get_defaults();

		if ( ! empty( $input ) ) {
			foreach ( $input as $key => $value ) {
				switch ( $key ) {
					case 'modal_title':
						$modal_title                 = trim( $value );
						$valid_fields['modal_title'] = strip_tags( stripslashes( $modal_title ) );
						break;
					case 'modal_headline':
						$modal_headline                 = trim( $value );
						$valid_fields['modal_headline'] = strip_tags( stripslashes( $modal_headline ) );
						break;
					case 'modal_text':
						$modal_text                 = trim( $value );
						$valid_fields['modal_text'] = strip_tags( stripslashes( $modal_text ) );
						break;
					case 'title_color':
						$title_color = trim( $value );
						$title_color = strip_tags( stripslashes( $title_color ) );

						if ( false === $this->check_color( $title_color ) ) {

							add_settings_error( $this->settings_name, $this->settings_name . '_title_color_error', 'Insert a valid color for Title Color', 'error' );

							$valid_fields['title_color'] = $this->get_setting( 'title_color' );

						} else {

							$valid_fields['title_color'] = $title_color;

						}
						break;
					case 'text_color':
						$text_color = trim( $value );
						$text_color = strip_tags( stripslashes( $text_color ) );

						if ( false === $this->check_color( $text_color ) ) {

							add_settings_error( $this->settings_name, $this->settings_name . '_text_color_error', 'Insert a valid color for Title Color', 'error' );

							$valid_fields['text_color'] = $this->get_setting( 'text_color' );

						} else {

							$valid_fields['text_color'] = $text_color;

						}
						break;
					case 'headline_color':
						$headline_color = trim( $value );
						$headline_color = strip_tags( stripslashes( $headline_color ) );

						if ( false === $this->check_color( $headline_color ) ) {

							add_settings_error( $this->settings_name, $this->settings_name . '_headline_color_error', 'Insert a valid color for Title Color', 'error' );

							$valid_fields['headline_color'] = $this->get_setting( 'headline_color' );

						} else {

							$valid_fields['headline_color'] = $headline_color;

						}
						break;
					case 'internet_explorer':

						$internet_explorer          = intval( $value );
						$internet_explorer_versions = $this->get_internet_explorer_versions();

						if ( ! in_array( $internet_explorer, $internet_explorer_versions ) ) {
							$valid_fields['internet_explorer'] = $this->get_setting( 'internet_explorer' );
						} else {
							$valid_fields['internet_explorer'] = $internet_explorer;
						}

						break;
				}
			}
		}

		return $valid_fields;
	}

	/**
	 * Modal title setting field
	 *
	 * @param $args
	 */
	public function control_modal_title( $args ) {

		$modal_title = $this->get_setting( 'modal_title' );

		?>
		<input type="text" class="<?php echo $args['field_class']; ?>" id="<?php echo $args['field_id']; ?>"
		       name="<?php echo $args['field_name'] ?>" value="<?php echo esc_attr( $modal_title ); ?>">
		<?php
	}

	/**
	 * Modal title setting field
	 *
	 * @param $args
	 */
	public function control_modal_headline( $args ) {

		$modal_headline = $this->get_setting( 'modal_headline' );

		?>
		<input type="text" class="<?php echo $args['field_class']; ?>" id="<?php echo $args['field_id']; ?>"
		       name="<?php echo $args['field_name'] ?>" value="<?php echo esc_attr( $modal_headline ); ?>">
		<?php
	}

	/**
	 * Modal text setting field
	 *
	 * @param $args
	 */
	public function control_modal_text( $args ) {

		$modal_text = $this->get_setting( 'modal_text' );

		?>
		<textarea class="<?php echo $args['field_class']; ?>" id="<?php echo $args['field_id']; ?>"
		          name="<?php echo $args['field_name'] ?>" rows="5"><?php echo esc_attr( $modal_text ); ?></textarea>
		<?php
	}

	/**
	 * Title color setting field
	 *
	 * @param $args
	 */
	public function control_title_color( $args ) {

		$title_color = $this->get_setting( 'title_color' );

		?>
		<input type="text" class="<?php echo $args['field_class']; ?>" id="<?php echo $args['field_id']; ?>"
		       name="<?php echo $args['field_name'] ?>" value="<?php echo esc_attr( $title_color ); ?>">
		<?php
	}

	/**
	 * Headline color setting field
	 *
	 * @param $args
	 */
	public function control_headline_color( $args ) {

		$headline_color = $this->get_setting( 'headline_color' );

		?>
		<input type="text" class="<?php echo $args['field_class']; ?>" id="<?php echo $args['field_id']; ?>"
		       name="<?php echo $args['field_name'] ?>" value="<?php echo esc_attr( $headline_color ); ?>">
		<?php
	}

	/**
	 * Text color setting field
	 *
	 * @param $args
	 */
	public function control_text_color( $args ) {

		$text_color = $this->get_setting( 'text_color' );

		?>
		<input type="text" class="<?php echo $args['field_class']; ?>" id="<?php echo $args['field_id']; ?>"
		       name="<?php echo $args['field_name'] ?>" value="<?php echo esc_attr( $text_color ); ?>">
		<?php
	}

	/**
	 * Internet Explorer setting field
	 *
	 * @param $args
	 */
	function control_internet_explorer( $args ) {

		$internet_explorer          = $this->get_setting( 'internet_explorer' );
		$internet_explorer_versions = $this->get_internet_explorer_versions();
		?>

		<select id="<?php echo $args['field_id']; ?>" name="<?php echo $args['field_name'] ?>">
			<?php foreach ( $internet_explorer_versions as $version ) : ?>
				<option value="<?php echo $version; ?>" <?php if ( $version === $internet_explorer ) {
					echo 'selected';
				} ?>>
					<?php echo sprintf( __( 'Internet Explorer %d', $this->plugin_name ), $version ); ?>
				</option>
			<?php endforeach; ?>
		</select>

		<?php
	}
}
