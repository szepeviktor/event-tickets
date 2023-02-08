<?php
/**
 * Event Tickets Emails: Main template > Body > Tickets.
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/tickets/v2/emails/template-parts/body/tickets.php
 *
 * See more documentation about our views templating system.
 *
 * @link https://evnt.is/tickets-emails-tpl Help article for Tickets Emails template files.
 *
 * @version TBD
 *
 * @since TBD
 *
 * @var Tribe_Template  $this  Current template object.
 */

?>
<tr>
	<td class="tec-tickets__email-table-content-ticket">
		<?php $this->template( 'template-parts/body/ticket/attendee-name' ); ?>

		<?php $this->template( 'template-parts/body/ticket/ticket-name' ); ?>

		<?php $this->template( 'template-parts/body/ticket/security-code' ); ?>
	</td>
</tr>
