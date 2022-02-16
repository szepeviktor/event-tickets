<?php

namespace TEC\Tickets\Commerce\Gateways\Stripe\Webhooks;

use TEC\Tickets\Commerce\Gateways\Contracts\Webhook_Event_Interface;
use TEC\Tickets\Commerce\Gateways\Stripe\Payment_Intent;
use TEC\Tickets\Commerce\Gateways\Stripe\Status;
use TEC\Tickets\Commerce\Status\Status_Interface;

/**
 * Webhook for Payment_Intent operations
 *
 * @since   TBD
 *
 * @package TEC\Tickets\Commerce\Gateways\Stripe\Webhooks
 */
class Payment_Intent_Webhook implements Webhook_Event_Interface {

	/**
	 * @inheritDoc
	 */
	public static function handle( array $event, Status_Interface $new_status, \WP_REST_Request $request, \WP_REST_Response $response ) {
		$payment_intent    = static::get_payment_intent_data( $event );
		$payment_intent_id = $payment_intent['id'];

		if ( ! empty( $payment_intent['metadata']['order_id'] ) ) {
			$order = tec_tc_get_order( $payment_intent['metadata']['order_id'] );
		}

		if ( empty( $order ) ) {
			$order = static::get_order_by_payment_intent_id( $payment_intent_id );
		}


		if ( empty( $order ) ) {

			if ( ! empty( $payment_intent['metadata'][ Payment_Intent::$test_metadata_key ] ) ) {
				$response->set_status( 200 );
				$response->set_data(
					__( 'Payment Intent Test Successful', 'event-tickets' )
				);

				return $response;
			}

			return new \WP_Error( 400, sprintf(
				// Translators: %s is the payment intent id.
				__( 'Payment Intent %s does not correspond to a known order.', 'event-tickets' ),
				esc_html( $payment_intent_id )
			) );
		}

		if ( ! static::should_payment_intent_be_updated( $payment_intent, $order->gateway_payload ) ) {
			$response->set_status( 200 );
			$response->set_data(
				sprintf(
				// Translators: %s is the payment intent id
					__( 'Payment Intent %s does not require an update or is a duplicate of a past event.', 'event-tickets' ),
					esc_html( $payment_intent_id )
				)
			);
		}

		$meta = [
			'gateway_payload'  => $payment_intent,
			'gateway_order_id' => $payment_intent_id,
		];

		return Handler::update_order_status( $order, $new_status, $meta );
	}

	/**
	 * Get the order to update.
	 *
	 * @since TBD
	 *
	 * @param string $payment_intent_id The payment intent id.
	 *
	 * @return mixed|\WP_Post|null
	 */
	public static function get_order_by_payment_intent_id( string $payment_intent_id ) {
		return tec_tc_orders()->by_args( [
			'status'           => 'any',
			'gateway_order_id' => $payment_intent_id,
		] )->first();
	}

	/**
	 * Get the payment intent id from the webhook event data.
	 *
	 * @since TBD
	 *
	 * @param array $event Event data coming from the Webhook.
	 *
	 * @return string
	 */
	protected static function get_payment_intent_id( array $event ): string {
		$payment_intent = static::get_payment_intent_data( $event );

		return $payment_intent['id'];
	}

	/**
	 * Get the payment intent object array from the webhook event data.
	 *
	 * @since TBD
	 *
	 * @param array $event Event data coming from the Webhook.
	 *
	 * @return string
	 */
	protected static function get_payment_intent_data( array $event ): array {
		return $event['data']['object'];
	}

	/**
	 * Checks if the payment intent contained in the event received has already been processed.
	 *
	 * @since TBD
	 *
	 * @param array   $payment_intent_received The payment intent data received
	 * @param array[] $payment_intents_stored  The payment intent data stored from each update, keyed by status.
	 *
	 * @return bool
	 */
	public static function should_payment_intent_be_updated( $payment_intent_received, $payment_intents_stored ) {
		// This payment intent was reset, or processing has re-started without invalidating.
		if ( 1 < count( $payment_intents_stored ) && $payment_intent_received['status'] === Status::REQUIRES_PAYMENT_METHOD ) {
			return true;
		}

		foreach ( $payment_intents_stored as $intent ) {
			// This payment intent has already been processed and updated.
			if ( $payment_intent_received['id'] === $intent['id'] ) {
				return false;
			}
		}

		return true;
	}
}