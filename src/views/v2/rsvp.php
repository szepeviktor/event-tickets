<?php
/**
 * Block: RSVP
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/tickets/v2/rsvp.php
 *
 * See more documentation about our Blocks Editor templating system.
 *
 * @link  http://m.tri.be/1amp
 *
 * @since 4.12.3
 *
 * @version5.0.0
 *
 * @var Tribe__Tickets__Editor__Template $this
 * @var WP_Post|int                      $post_id      The post object or ID.
 * @var boolean                          $has_rsvps    True if there are RSVPs.
 * @var array                            $active_rsvps An array containing the active RSVPs.
 */

// We don't display anything if there is no RSVP.
if ( ! $has_rsvps ) {
	return false;
}

// Bail if there are no active RSVP.
if ( empty( $active_rsvps ) ) {
	return;
}

?>

<div id="rsvp-now" class="tribe-common event-tickets">
	<?php foreach ( $active_rsvps as $rsvp ) : ?>
		<div
			class="tribe-tickets__rsvp-wrapper"
			data-rsvp-id="<?php echo esc_attr( $rsvp->ID ); ?>"
		>
			<?php $this->template( 'v2/components/loader/loader' ); ?>
			<?php $this->template( 'v2/rsvp/content', [ 'rsvp' => $rsvp ] ); ?>

		</div>
	<?php endforeach; ?>
</div>
