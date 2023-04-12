<?php
/**
 * Class Completed_Order
 *
 * @package TEC\Tickets\Emails
 */

namespace TEC\Tickets\Emails\Email;

use \TEC\Tickets\Emails\Email_Template;
use TEC\Tickets\Emails\Admin\Preview_Data;

/**
 * Class Completed_Order
 *
 * @since 5.5.10
 *
 * @package TEC\Tickets\Emails
 */
class Completed_Order extends \TEC\Tickets\Emails\Email_Abstract {

	/**
	 * Email ID.
	 *
	 * @since 5.5.10
	 *
	 * @var string
	 */
	public $id = 'tec_tickets_emails_completed_order';

	/**
	 * Email slug.
	 *
	 * @since 5.5.10
	 *
	 * @var string
	 */
	public $slug = 'completed-order';

	/**
	 * Email template.
	 *
	 * @since 5.5.10
	 *
	 * @var string
	 */
	public $template = 'admin-new-order';

	/**
	 * Get email title.
	 *
	 * @since 5.5.10
	 *
	 * @return string The email title.
	 */
	public function get_title(): string {
		return esc_html__( 'Completed Order', 'event-tickets' );
	}

	/**
	 * Get email to.
	 *
	 * @since TBD
	 *
	 * @return string The email "to".
	 */
	public function get_to(): string {
		return esc_html__( 'Admin', 'event-tickets' );
	}

	/**
	 * Get default email recipient.
	 *
	 * @since 5.5.10
	 *
	 * @return string $recipient The default email recipient.
	 */
	public function get_default_recipient(): string {
		return get_option( 'admin_email' );
	}

	/**
	 * Get default email heading.
	 *
	 * @since 5.5.10
	 *
	 * @return string
	 */
	public function get_default_heading(): string {
		return esc_html__( 'Completed order: #{order_number}', 'event-tickets' );
	}

	/**
	 * Get default email subject.
	 *
	 * @since 5.5.10
	 *
	 * @return string
	 */
	public function get_default_subject():string {
		return esc_html__( '[{site_title}]: Completed order #{order_number}', 'event-tickets' );
	}

	/**
	 * Get email settings.
	 *
	 * @since 5.5.10
	 *
	 * @return array
	 */
	public function get_settings_fields(): array {
		return [
			[
				'type' => 'html',
				'html' => '<div class="tribe-settings-form-wrap">',
			],
			[
				'type' => 'html',
				'html' => '<h2>' . esc_html__( 'Completed Order Email Settings', 'event-tickets' ) . '</h2>',
			],
			[
				'type' => 'html',
				'html' => '<p>' . esc_html__( 'The site admin will receive an email about any orders that were made. Customize the content of this specific email using the tools below. The brackets {event_name}, {event_date}, and {ticket_name} can be used to pull dynamic content from the ticket into your email. Learn more about customizing email templates in our Knowledgebase.' ) . '</p>',
			],
			$this->get_option_key( 'enabled' ) => [
				'type'                => 'toggle',
				'label'               => esc_html__( 'Enabled', 'event-tickets' ),
				'default'             => true,
				'validation_type'     => 'boolean',
			],
			$this->get_option_key( 'recipient' ) => [
				'type'                => 'text',
				'label'               => esc_html__( 'Recipient(s)', 'event-tickets' ),
				'default'             => $this->get_default_recipient(),
				'size'                => 'large',
				'validation_type' => 'email_list',
			],
			$this->get_option_key( 'subject' ) => [
				'type'                => 'text',
				'label'               => esc_html__( 'Subject', 'event-tickets' ),
				'default'             => $this->get_default_subject(),
				'placeholder'         => $this->get_default_subject(),
				'size'                => 'large',
				'validation_callback' => 'is_string',
			],
			$this->get_option_key( 'heading' ) => [
				'type'                => 'text',
				'label'               => esc_html__( 'Heading', 'event-tickets' ),
				'default'             => $this->get_default_heading(),
				'placeholder'         => $this->get_default_heading(),
				'size'                => 'large',
				'validation_callback' => 'is_string',
			],
			$this->get_option_key( 'add-content' ) => [
				'type'                => 'wysiwyg',
				'label'               => esc_html__( 'Additional content', 'event-tickets' ),
				'default'             => $this->get_default_additional_content(),
				'tooltip'             => esc_html__( 'Additional content will be displayed below the order details.', 'event-tickets' ),
				'validation_type'     => 'html',
				'settings'        => [
					'media_buttons' => false,
					'quicktags'     => false,
					'editor_height' => 200,
					'buttons'       => [
						'bold',
						'italic',
						'underline',
						'strikethrough',
						'alignleft',
						'aligncenter',
						'alignright',
					],
				],
			],
		];
	}

	/**
	 * Get default preview context for email.
	 *
	 * @since TBD
	 *
	 * @param array $args The arguments.
	 * @return array $args The modified arguments
	 */
	public function get_default_preview_context( $args = [] ): array {
		$defaults = [
			'email'              => $this,
			'is_preview'         => true,
			'title'              => esc_html__( 'Completed order: #123', 'event-tickets' ),
			'heading'            => esc_html__( 'Completed order: #123', 'event-tickets' ),
			'additional_content' => $this->get_additional_content(),
			'order'              => Preview_Data::get_order(),
			'tickets'            => Preview_Data::get_tickets(),
			'attendees'          => Preview_Data::get_attendees(),
		];

		return wp_parse_args( $args, $defaults );
	}

	/**
	 * Get default template context for email.
	 *
	 * @since TBD
	 *
	 * @return array $args The default arguments
	 */
	public function get_default_template_context(): array {
		$defaults = [
			'email'              => $this,
			'title'              => $this->get_title(),
			'heading'            => $this->get_heading(),
			'additional_content' => $this->get_additional_content(),
			'order'              => $this->__get( 'order' ),
		];

		return $defaults;
	}

	/**
	 * Get email content.
	 *
	 * @since 5.5.10
	 *
	 * @param array $args The arguments.
	 *
	 * @return string The email content.
	 */
	public function get_content( $args = [] ): string {
		$is_preview = ! empty( $args['is_preview'] ) ? tribe_is_truthy( $args['is_preview'] ) : false;
		$args       = $this->get_template_context( $args );

		$email_template = tribe( Email_Template::class );
		$email_template->set_preview( $is_preview );

		return $email_template->get_html( $this->template, $args );
	}

	/**
	 * Send the email.
	 *
	 * @since TBD
	 *
	 * @return bool Whether the email was sent or not.
	 */
	public function send() {
		$recipient = $this->get_recipient();

		// Bail if there is no email address to send to.
		if ( empty( $recipient ) ) {
			return false;
		}

		if ( ! $this->is_enabled() ) {
			return false;
		}

		$order = $this->__get( 'order' );

		// Bail if there's no order.
		if ( empty( $order ) ) {
			return false;
		}

		$placeholders = [
			'{order_number}' => $order->ID,
			'{order_id}'     => $order->ID,
		];

		$this->set_placeholders( $placeholders );

		$subject     = $this->get_subject();
		$content     = $this->get_content();
		$headers     = $this->get_headers();
		$attachments = $this->get_attachments();

		return tribe( \TEC\Tickets\Emails\Email_Sender::class )->send( $recipient, $subject, $content, $headers, $attachments );
	}
}