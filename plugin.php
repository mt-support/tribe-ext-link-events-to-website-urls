<?php
/**
 * Plugin Name:       The Events Calendar Extension: Event Titles Link to Website URL
 * Plugin URI:        https://theeventscalendar.com/extensions/make-event-titles-link-to-the-event-website-url/
 * GitHub Plugin URI: https://github.com/mt-support/tribe-ext-link-events-to-website-urls
 * Description:       An extension that makes event titles link to the events' Website URLs when present.
 * Version:           1.1.0
 * Author:            Modern Tribe, Inc.
 * Author URI:        http://m.tri.be/1971
 * License:           GPL version 3 or any later version
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       tribe-ext-link-events-to-website-urls
 *
 *     This plugin is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     any later version.
 *
 *     This plugin is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *     GNU General Public License for more details.
 */

/**
 * Define the base file that loaded the plugin for determining plugin path and other variables.
 *
 * @since 1.1.0
 *
 * @var string Base file that loaded the plugin.
 */
define( 'TRIBE_EXTENSION_LINK_EVENTS_TO_WEBSITE_URLS_FILE', __FILE__ );

/**
 * Register and load the service provider for loading the extension.
 *
 * @since 1.1.0
 */
function tribe_extension_link_events_to_website_urls() {
	// When we dont have autoloader from common we bail.
	if ( ! class_exists( 'Tribe__Autoloader' ) ) {
		return;
	}

	// Register the namespace so we can the plugin on the service provider registration.
	Tribe__Autoloader::instance()->register_prefix(
		'\\Tribe\\Extensions\\Event_Link_To_Website_URL\\',
		__DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Tribe',
		'link-events-to-website-urls'
	);

	tribe_register_provider( '\Tribe\Extensions\Event_Link_To_Website_URL\Plugin' );
}

// Loads after common is already properly loaded.
add_action( 'tribe_common_loaded', 'tribe_extension_link_events_to_website_urls' );