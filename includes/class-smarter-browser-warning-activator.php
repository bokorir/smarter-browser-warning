<?php

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Smarter_Browser_Warning
 * @subpackage Smarter_Browser_Warning/includes
 * @author     Robert Bokori <robert@smarter.uk.com>
 */
class Smarter_Browser_Warning_Activator {

  /**
   * Short Description. (use period)
   *
   * Long Description.
   *
   * @since    1.0.0
   */
  public static function activate() {

    if(!get_option('smarter_browser_warning', false)) {
      add_option( 'smarter_browser_warning', Smarter_Browser_Warning::get_defaults() );
    }
  }

}
