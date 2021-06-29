<?php
/**
 * The main service provider for the Tickets updated and new code.
 *
 * @since   TBD
 * @package TEC\Tickets
 */

namespace TEC\Tickets;

use \tad_DI52_ServiceProvider;
use \Tribe__Tickets__Main as Tickets_Plugin;

/**
 * Class Provider for all the Tickets loading.
 *
 * @since   TBD
 * @package TEC\Tickets
 */
class Provider extends tad_DI52_ServiceProvider {

	/**
	 * Binds and sets up implementations.
	 *
	 * @since TBD
	 */
	public function register() {
		require_once Tickets_Plugin::instance()->plugin_path . 'src/functions/commerce/provider.php';

		// Specifically prevents anything else from loading.
		if ( ! tec_tickets_commerce_is_enabled() ) {
			return;
		}

		$this->register_hooks();
		$this->register_assets();

		// Register the SP on the container.
		$this->container->singleton( static::class, $this );
		$this->container->singleton( 'tickets.provider', $this );

		// Loads all of tickets commerce.
		$this->container->register( Commerce\Provider::class );
	}

	/**
	 * Registers the provider handling all the 1st level filters and actions for Tickets.
	 *
	 * @since TBD
	 */
	protected function register_assets() {
		$assets = new Assets( $this->container );
		$assets->register();

		$this->container->singleton( Assets::class, $assets );
	}

	/**
	 * Registers the provider handling all the 1st level filters and actions for Tickets.
	 *
	 * @since TBD
	 */
	protected function register_hooks() {
		$hooks = new Hooks( $this->container );
		$hooks->register();

		// Allow Hooks to be removed, by having the them registered to the container
		$this->container->singleton( Hooks::class, $hooks );
		$this->container->singleton( 'tickets.hooks', $hooks );
	}
}