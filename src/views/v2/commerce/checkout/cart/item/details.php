<?php
/**
 * Tickets Commerce: Checkout Cart Item Details
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/tickets/v2/commerce/checkout/cart/item/details.php
 *
 * See more documentation about our views templating system.
 *
 * @link    https://evnt.is/1amp Help article for RSVP & Ticket template files.
 *
 * @since   TBD
 *
 * @version TBD
 *
 * @var \Tribe__Template $this                  [Global] Template object.
 * @var Module           $provider              [Global] The tickets provider instance.
 * @var string           $provider_id           [Global] The tickets provider class name.
 * @var array[]          $items                 [Global] List of Items on the cart to be checked out.
 * @var string           $paypal_attribution_id [Global] What is our PayPal Attribution ID.
 * @var bool             $must_login            [Global] Whether login is required to buy tickets or not.
 * @var string           $login_url             [Global] The site's login URL.
 * @var string           $registration_url      [Global] The site's registration URL.
 * @var array            $item                  Which item this row will be for.
 */

?>
<div class="tribe-tickets__commerce-checkout-cart-item-details">

	<?php $this->template( 'checkout/cart/item/details/title', [ 'item' => $item ] ); ?>

	<?php $this->template( 'checkout/cart/item/details/toggle', [ 'item' => $item ] ); ?>

	<?php $this->template( 'checkout/cart/item/details/description', [ 'item' => $item ] ); ?>

</div>
