<?php
/**
 * Event Tickets Emails: Order Purchaser Details
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/tickets/v2/emails/template-parts/body/order/purchaser-details.php
 *
 * See more documentation about our views templating system.
 *
 * @link https://evnt.is/tickets-emails-tpl Help article for Tickets Emails template files.
 *
 * @version TBD
 *
 * @since TBD
 *
 * @var Tribe_Template $this               Current template object.
 * @var Email_Abstract $email              The email object.
 * @var string         $heading            The email heading.
 * @var string         $title              The email title.
 * @var bool           $preview            Whether the email is in preview mode or not.
 * @var string         $additional_content The email additional content.
 * @var bool           $is_tec_active      Whether `The Events Calendar` is active or not.
 * @var \WP_Post       $order              The order object.
 */

if ( empty( $order ) ) {
	return;
}
?>
<tr>
	<td>
		<table>
			<tr>
				<?php $this->template( 'template-parts/body/order/purchaser-details/order-number' ); ?>
				<?php $this->template( 'template-parts/body/order/purchaser-details/name' ); ?>
			</tr>
			<tr>
				<?php $this->template( 'template-parts/body/order/purchaser-details/date' ); ?>
				<?php $this->template( 'template-parts/body/order/purchaser-details/email' ); ?>
			</tr>
		</table>
	</td>
</tr>
