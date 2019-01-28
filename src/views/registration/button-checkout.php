<?php
/**
 * This template renders the attendee registration checkout button
 *
 * @since 4.9
 * @version 4.9.4
 *
 */
if ( ! $checkout_url ) {
	return;
}
?>
<form
	class="tribe-block__tickets__registration__checkout"
	action="<?php echo esc_url( $checkout_url ); ?>"
	method="post"
>
	<input type="hidden" name="tribe_tickets_checkout" value="1" />
	<button
		type="submit"
		class="alignright button-primary tribe-block__tickets__registration__checkout__submit"
		disabled
	>
		<?php esc_html_e( 'Checkout', 'event-tickets' ); ?>
	</button>
</form>
