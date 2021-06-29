<?php

namespace TEC\Tickets\Commerce\Gateways;

/**
 * Class Interface_Gateway
 *
 * @since   TBD
 *
 * @package TEC\Tickets\Commerce\Gateways
 */
interface Interface_Gateway {
	/**
	 * Get's the key for this Commerce Gateway.
	 *
	 * @since TBD
	 *
	 * @return bool Whether the provider is active.
	 */
	public static function get_key();

	/**
	 * Get's the label for this Commerce Gateway.
	 *
	 * @since TBD
	 *
	 * @return string What label we are using for this gateway.
	 */
	public static function get_label();

	/**
	 * Determine whether the gateway is active.
	 *
	 * @since TBD
	 *
	 * @return bool Whether the provider is active.
	 */
	public static function is_active();

	/**
	 * Determine whether the gateway should be shown as an available gateway.
	 *
	 * @since TBD
	 *
	 * @return bool Whether the gateway should be shown as an available gateway.
	 */
	public static function should_show();

	/**
	 * Register the gateway for Tickets Commerce.
	 *
	 * @since TBD
	 *
	 * @param array       $gateways The list of registered Tickets Commerce gateways.
	 *
	 * @return array The list of registered Tickets Commerce gateways.
	 */
	public function register_gateway( array $gateways );
}