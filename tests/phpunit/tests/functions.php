<?php

/**
 * A test case for the general core functions.
 *
 * @package WordPoints\Tests
 * @since 1.2.0
 */

/**
 * Test that all of the core functions work properly.
 *
 * @since 1.2.0
 */
class WordPoints_Core_Functions_Test extends WP_UnitTestCase {

	/**
	 * Test is_wordpoints_network_active().
	 *
	 * @since 1.2.0
	 */
	public function test_is_wordpoints_network_active() {

		$plugin_file = plugin_basename( WORDPOINTS_DIR . 'wordpoints.php' );

		// Make sure it isn't network active.
		update_site_option( 'active_sitewide_plugins', array() );

		$this->assertFalse( is_wordpoints_network_active() );

		// Now make it network active.
		update_site_option( 'active_sitewide_plugins', array( $plugin_file => true ) );

		if ( is_multisite() ) {
			$this->assertTrue( is_wordpoints_network_active() );
		} else {
			$this->assertFalse( is_wordpoints_network_active() );
		}
	}
}