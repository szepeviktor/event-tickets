<?php
/**
 * This template renders the RSVP AR form title.
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/tickets/v2/rsvp/ari/form/title.php
 *
 * @since TBD
 *
 * @version TBD
 */

?>
<h3 class="tribe-tickets__rsvp-ar-form-title tribe-common-h5">
	<?php
	echo wp_kses_post(
		sprintf(
			/* Translators: %s Guest label for RSVP attendee registration form title. */
			__( 'Main %s', 'event-tickets' ),
			tribe_get_guest_label_singular( 'RSVP attendee registration form title' )
		)
	);
	?>
</h3>
