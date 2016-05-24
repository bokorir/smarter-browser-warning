<?php

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Smarter_Browser_Warning
 * @subpackage Smarter_Browser_Warning/public
 * @author     Robert Bokori <robert@smarter.uk.com>
 */
class Smarter_Browser_Warning_Public {

	private $plugin_name;
	private $version;
	private $settings_name;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 *
	 * @param      string $plugin_name The name of the plugin.
	 * @param      string $version The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name   = $plugin_name;
		$this->version       = $version;
		$this->settings_name = 'smarter_browser_warning';

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/smarter-browser-warning-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name . "_jquery_cookie", plugin_dir_url( __FILE__ ) . 'js/vendor/jquery.cookie.js', array( 'jquery' ), $this->version, false );
		wp_register_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/smarter-browser-warning-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'sbw_globals', $this->get_js_globals() );
		wp_enqueue_script( $this->plugin_name );

	}

	/**
	 * Returns the javascript globals
	 *
	 * @return array
	 */
	public function get_js_globals() {
		return array(
			"ajaxurl" => admin_url( 'admin-ajax.php' ),
			"nonce" => wp_create_nonce("sbw-ruVqkQqgQz0b"),
			"ie_support" => $this->get_setting( 'internet_explorer' )
		);
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
	public function get_setting( $key ) {

		$settings = $this->get_settings();

		if ( isset( $settings[ $key ] ) ) {
			return $settings[ $key ];
		}

		return false;
	}

	/**
	 * Modal html on ajax callback
	 */
	public function get_browser_warning_popup_html() {

		check_ajax_referer('sbw-ruVqkQqgQz0b', 'nonce');

		?>

		<div class="sbw-browser-support-modal">

			<div class="sbw-container">

				<h1 class="sbw-modal-title" style="color: <?php echo $this->get_setting( 'title_color' ); ?>;">
          <?php echo $this->get_setting( 'modal_title' ); ?>
        </h1>

				<h2 class="sbw-modal-headline"
				    style="color: <?php echo $this->get_setting( 'headline_color' ); ?>;">
          <?php echo $this->get_setting( 'modal_headline' ); ?>
        </h2>

				<p class="sbw-modal-text" style="color: <?php echo $this->get_setting( 'text_color' ); ?>;">
          <?php echo $this->get_setting( 'modal_text' ); ?>
        </p>

				<div class="sbw-browsers" style="color: <?php echo $this->get_setting( 'text_color' ); ?>;">

					<a class="sbw-browser sbw-chrome" href="https://www.google.com/intl/en_uk/chrome/browser/" title="Google Chrome" target="_blank" rel="nofollow">
						<figure class="sbw-browser-logo">
							<img src="<?php echo plugins_url( "/images/chrome.png", __FILE__ ); ?>">
						</figure>
						<h4>Google Chrome</h4>
					</a>

					<a class="sbw-browser sbw-firefox" href="http://www.mozilla.org/en-GB/firefox/new/" title="Mozilla Firefox" target="_blank" rel="nofollow">
						<figure class="sbw-browser-logo">
							<img src="<?php echo plugins_url( "/images/firefox.png", __FILE__ ); ?>">
						</figure>
						<h4>Mozilla Firefox</h4>
					</a>

          <div class="sbw-clearfix-xs"></div>

					<a class="sbw-browser sbw-ie" href="http://windows.microsoft.com/en-GB/internet-explorer/download-ie" title="Internet Explorer" target="_blank" rel="nofollow">
						<figure class="sbw-browser-logo">
							<img src="<?php echo plugins_url( "/images/internet_explorer.png", __FILE__ ); ?>">
						</figure>
						<h4>Internet Explorer</h4>
					</a>

					<a class="sbw-browser sbw-opera" href="http://www.opera.com/download" title="Opera" target="_blank" rel="nofollow">
						<figure class="sbw-browser-logo">
							<img src="<?php echo plugins_url( "/images/opera.png", __FILE__ ); ?>">
						</figure>
						<h4>Opera</h4>
					</a>

          <div class="sbw-clearfix-xs"></div>

					<a class="sbw-browser sbw-safari" href="http://support.apple.com/downloads/#internet" title="Safari" target="_blank" rel="nofollow">
						<figure class="sbw-browser-logo">
							<img src="<?php echo plugins_url( "/images/safari.png", __FILE__ ); ?>">
						</figure>
						<h4>Safari</h4>
					</a>

					<div class="sbw-clearfix"></div>

				</div>

				<div class="sbw-buttons">

					<a class="sbw-remind-later sbw-btn" href="#" title="<?php _e( "Remind me later", "smarter-browser-warning" ); ?>" role="button">
            <?php _e( "Remind me later", "smarter-browser-warning" ); ?>
          </a>

					<a class="sbw-no-reminder sbw-btn" href="#" title="<?php _e( "No, do not remind me again", "smarter-browser-warning" ); ?>" role="button">
            <?php _e( "No, do not remind me again", "smarter-browser-warning" ); ?>
          </a>

				</div>

			</div>

		</div>

		<?php
		die();
	}

}
