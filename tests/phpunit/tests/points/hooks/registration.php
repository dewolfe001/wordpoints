<?php

/**
 * A test case for the registration points hook.
 *
 * @package WordPoints\Tests
 * @since 1.3.0
 */

/**
 * Test that registration points hook works as expected.
 *
 * Since 1.0.0 it was a part of WordPoints_Included_Points_Hooks_Test.
 *
 * @since 1.3.0
 *
 * @group points
 * @group points_hooks
 *
 * @covers WordPoints_Registration_Points_Hook
 */
class WordPoints_Registration_Points_Hook_Test extends WordPoints_PHPUnit_TestCase_Points {

	/**
	 * Test that points are awarded on registration.
	 *
	 * @since 1.3.0
	 */
	public function test_points_awarded() {

		wordpointstests_add_points_hook( 'wordpoints_registration_points_hook', array( 'points' => 10 ) );

		$user_id = $this->factory->user->create();

		$this->assertSame( 10, wordpoints_get_points( $user_id, 'points' ) );
	}
}

// EOF
