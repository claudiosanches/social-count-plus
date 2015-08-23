<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Social Count Plus Users Counter.
 *
 * @package  Social_Count_Plus/Users_Counter
 * @category Counter
 * @author   Claudio Sanches
 */
class Social_Count_Plus_Users_Counter extends Social_Count_Plus_Counter {

	/**
	 * Counter ID.
	 *
	 * @var string
	 */
	public $id = 'users';

	/**
	 * API URL.
	 *
	 * @var string
	 */
	protected $api_url = '';

	/**
	 * Test the counter is available.
	 *
	 * @param  array $settings Plugin settings.
	 *
	 * @return bool
	 */
	public function is_available( $settings ) {
		return isset( $settings['users_active'] ) && ! empty( $settings['users_user_role'] );
	}

	/**
	 * Get the total.
	 *
	 * @param  array $settings Plugin settings.
	 * @param  array $cache    Counter cache.
	 *
	 * @return int
	 */
	public function get_total( $settings, $cache ) {
		if ( $this->is_available( $settings ) ) {
			$users = count_users();

			if ( ! empty( $users['avail_roles'][ $settings['users_user_role'] ] ) ) {
				$this->total = intval( $users['avail_roles'][ $settings['users_user_role'] ] );
			} else {
				$this->total = 0;
			}
		}

		return $this->total;
	}
}
