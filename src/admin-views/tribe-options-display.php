<?php
/**
 * @var array $settings List of display settings.
 */

/** @var Tribe__Dependency $dep */
$dep = tribe( Tribe__Dependency::class );

$etp_active = $dep->is_plugin_active( 'Tribe__Tickets_Plus__Main' );

// Don't display this section if ET is a newer install and ETP is inactive or ETP is active but a newer install.
if (
	(
		! $etp_active
		&& ! tribe_installed_before( 'Tribe__Tickets__Main', '5.0' )
	)
	|| (
		$etp_active
		&& ! tribe_installed_before( 'Tribe__Tickets_Plus__Main', '5.1' )
	)
) {
	return;
}

$tickets_rsvp_display_title = sprintf(
	esc_html_x(
		'%1$s Display Settings',
		'title of settings section',
		'event-tickets'
	),
	tribe_get_rsvp_label_plural( 'tickets_rsvp_display_title' )
);

$tickets_rsvp_display_description = sprintf(
	esc_html_x(
		'The settings below control the display of your %1$s.',
		'description of settings section',
		'event-tickets'
	),
	tribe_get_rsvp_label_plural( 'tickets_rsvp_display_description' )
);

if ( $etp_active ) {
	$tickets_rsvp_display_title = sprintf(
		esc_html_x(
			'%1$s and %2$s Display Settings',
			'title of settings section',
			'event-tickets'
		),
		tribe_get_ticket_label_plural( 'tickets_rsvp_display_title' ),
		tribe_get_rsvp_label_plural( 'tickets_rsvp_display_title' )
	);

	$tickets_rsvp_display_description = sprintf(
		esc_html_x(
			'The settings below control the display of your %1$s and %2$s.',
			'description of settings section',
			'event-tickets'
		),
		tribe_get_ticket_label_plural( 'tickets_rsvp_display_description' ),
		tribe_get_rsvp_label_plural( 'tickets_rsvp_display_description' )
	);
}

$et_options_display = [
	'tickets_rsvp_display_title'       => [
		'type' => 'html',
		'html' => '<h3 id="tickets_rsvp_display_title">' . $tickets_rsvp_display_title . '</h3>',
	],
	'tickets_rsvp_display_description' => [
		'type' => 'html',
		'html' => '<p>' . $tickets_rsvp_display_description . '</p>',
	],
];

// Only show this option to older installs, as newer installs default to new views.
if ( tribe_installed_before( 'Tribe__Tickets__Main', '5.0' ) ) {
	$et_options_display['tickets_rsvp_use_new_views'] = [
		'type'            => 'checkbox_bool',
		'label'           => sprintf(
			esc_html_x(
				'Enable New %1$s Experience',
				'settings label',
				'event-tickets'
			),
			tribe_get_rsvp_label_singular( 'tickets_rsvp_use_new_views' )
		),
		'tooltip'         => sprintf(
			esc_html_x(
				'This setting will render the new front-end designs (styling) and user-flow for the %1$s experience.',
				'settings tooltip',
				'event-tickets'
			),
			tribe_get_rsvp_label_singular( 'tickets_rsvp_use_new_views' )
		),
		'validation_type' => 'boolean',
		'default'         => false,
	];
}

// Only show this option to older installs, as newer installs default to new views.
if (
	$etp_active
	&& tribe_installed_before( 'Tribe__Tickets_Plus__Main', '5.1' )
) {
	$et_options_display['tickets_use_new_views'] = [
		'type'            => 'checkbox_bool',
		'label'           => sprintf(
			esc_html_x(
				'Enable Updated %1$s Experience',
				'settings label',
				'event-tickets'
			),
			tribe_get_ticket_label_plural( 'tickets_use_new_views' )
		),
		'tooltip'         => sprintf(
			esc_html_x( 'This setting will enable the updated front-end views and Individual Attendee Collection (IAC) flows for %1$s.', 'settings tooltip', 'event-tickets' ),
			tribe_get_ticket_label_plural( 'tickets_use_new_views' )
		),
		'validation_type' => 'boolean',
		'default'         => false,
	];
}

$settings = Tribe__Main::array_insert_before_key(
	'tribe-form-content-end',
	$settings,
	$et_options_display
);

return $settings;