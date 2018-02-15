<?php

require_once dirname( __FILE__ ) . '/factory.php';

/**
 * Defines a basic fixture to run multiple tests.
 *
 * Resets the state of the WordPress installation before and after every test.
 *
 * Includes utility functions and assertions useful for testing WordPress.
 *
 * All WordPress unit tests should inherit from this class.
 */
class EDD_UnitTestCase extends WP_UnitTestCase {

	public static function wpSetUpBeforeClass() {
		edd_install();
	}

	protected static function edd() {
		static $factory = null;
		if ( ! $factory ) {
			$factory = new EDD\Tests\Factory();
		}
		return $factory;
	}


	public static function tearDownAfterClass() {
		self::_delete_all_data();
		return parent::tearDownAfterClass();
	}

	protected static function _delete_all_data() {
		global $wpdb;
		foreach ( array(
			EDD()->customers->table_name,
			EDD()->customer_meta->table_name
		) as $table ) {
			$wpdb->query( "DELETE FROM {$table}" );
		}
	}
}