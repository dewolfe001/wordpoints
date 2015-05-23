<?php

/**
 * A test case for the update to 1.8.0.
 *
 * @package WordPoints\Tests
 * @since 1.8.0
 */

/**
 * Test that the plugin updates to 1.8.0 properly.
 *
 * @since 1.8.0
 *
 * @group update
 *
 * @covers WordPoints_Un_Installer::update_site_to_1_8_0
 */
class WordPoints_1_8_0_Update_Test extends WordPoints_UnitTestCase {

	/**
	 * @since 2.0.0
	 */
	protected $previous_version = '1.7.0';

	/**
	 * Test that the installed site IDs are added to the DB option.
	 *
	 * @since 1.8.0
	 */
	public function test_installed_site_ids_added() {

		if ( ! is_multisite() ) {
			$this->markTestSkipped( 'Multisite is required.' );
		}

		if ( is_wordpoints_network_active() ) {
			$this->markTestSkipped( 'WordPoints must not be network-active.' );
		}

		// Create a second site on the network.
		$blog_id = $this->factory->blog->create();

		// Check that the ID doesn't exist.
		$this->assertNotContains( $blog_id, get_site_option( 'wordpoints_installed_sites' ) );

		// Simulate the update.
		switch_to_blog( $blog_id );
		$this->update_wordpoints();
		restore_current_blog();

		// Check that the ID was added.
		$this->assertContains( $blog_id, get_site_option( 'wordpoints_installed_sites' ) );
	}
}

// EOF
