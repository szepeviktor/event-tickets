<?php

namespace TEC\Tickets\Commerce\Gateways;

abstract class Abstract_REST_Endpoint implements REST_Endpoint_Interface, \Tribe__Documentation__Swagger__Provider_Interface {

	/**
	 * The REST API endpoint path.
	 *
	 * @since TBD
	 *
	 * @var string
	 */
	protected $path;

	/**
	 * @inheritDoc
	 */
	public function get_endpoint_path() {
		return $this->path;
	}

	/**
	 * @inheritDoc
	 */
	public function get_route_url() {
		$namespace = tribe( 'tickets.rest-v1.main' )->get_events_route_namespace();

		return rest_url( '/' . $namespace . $this->get_endpoint_path(), 'https' );
	}

	/**
	 * Gets the Return URL pointing to this on boarding route.
	 *
	 * @since TBD moved to Abstract_REST_Endpoint
	 * @since 5.1.9
	 *
	 * @return string
	 */
	public function get_return_url( $hash = null ) {
		$arguments = [
			'hash' => $hash,
		];

		return add_query_arg( $arguments, $this->get_route_url() );
	}

	/**
	 * Sanitize a request argument based on details registered to the route.
	 *
	 * @since TBD moved to Abstract_REST_Endpoint
	 * @since 5.1.9
	 *
	 * @param mixed $value Value of the 'filter' argument.
	 *
	 * @return string|array
	 */
	public function sanitize_callback( $value ) {
		if ( is_array( $value ) ) {
			return array_map( 'sanitize_text_field', $value );
		}

		return sanitize_text_field( $value );
	}

	/**
	 * {@inheritDoc}
	 *
	 * @TODO  We need to make sure Swagger documentation is present.
	 *
	 * @since TBD moved to Abstract_REST_Endpoint
	 * @since 5.1.9
	 *
	 * @return array
	 */
	public function get_documentation() {
		return [];
	}
}