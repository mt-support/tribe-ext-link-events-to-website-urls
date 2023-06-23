<?php
/**
 * Handles hooking all the actions and filters used by the module.
 *
 * To remove a filter:
 * ```php
 *  remove_filter( 'some_filter', [ tribe( Tribe\Extensions\Event_Link_To_Website_URL\Hooks::class ), 'some_filtering_method' ] );
 *  remove_filter( 'some_filter', [ tribe( 'extension.link_events_to_website_urls' ), 'some_filtering_method' ] );
 * ```
 *
 * To remove an action:
 * ```php
 *  remove_action( 'some_action', [ tribe( Tribe\Extensions\Event_Link_To_Website_URL\Hooks::class ), 'some_method' ] );
 *  remove_action( 'some_action', [ tribe( 'extension.link_events_to_website_urls' ), 'some_method' ] );
 * ```
 *
 * @since   1.1.0
 *
 * @package Tribe\Extensions\Event_Link_To_Website_URL;
 */

namespace Tribe\Extensions\Event_Link_To_Website_URL;

use TEC\Common\Contracts\Service_Provider;

/**
 * Class Hooks.
 *
 * @since   1.1.0
 *
 * @package Tribe\Extensions\Event_Link_To_Website_URL;
 */
class Hooks extends Service_Provider {

	/**
	 * Binds and sets up implementations.
	 *
	 * @since 1.1.0
	 */
	public function register() {
		$this->container->singleton( static::class, $this );
		$this->container->singleton( 'extension.link_events_to_website_urls.hooks', $this );

		$this->add_actions();
		$this->add_filters();
	}

	/**
	 * Adds the actions required by the plugin.
	 *
	 * @since 1.1.0
	 */
	protected function add_actions() {
		add_action( 'tribe_load_text_domains', [ $this, 'load_text_domains' ] );
	}

	/**
	 * Adds the filters required by the plugin.
	 *
	 * @since 1.1.0
	 */
	protected function add_filters() {
		add_filter( 'tribe_get_event_link', [ $this, 'filter_get_event_link' ], 10, 2 );
		add_filter( 'tribe_get_event', [ $this, 'filter_permalink_for_event' ] );
	}

	/**
	 * Load text domain for localization of the plugin.
	 *
	 * @since 1.1.0
	 */
	public function load_text_domains() {
		$mopath = tribe( Plugin::class )->plugin_dir . 'lang/';
		$domain = 'tribe-ext-link-events-to-website-urls';

		// This will load `wp-content/languages/plugins` files first.
		\Tribe__Main::instance()->load_text_domain( $domain, $mopath );
	}

	/**
	 * Make event titles link to URLs from their respective "Event Website" fields.
	 *
	 * @since 1.0.0
	 *
	 * @param $link string Event Link
	 * @param $post_id int Event ID
	 *
	 * @return string Event Link
	 */
	public function filter_get_event_link( $link, $post_id ) {

		$website_url = tribe_get_event_website_url( $post_id );

		if ( ! empty( $website_url ) ) {
			$link = $website_url;
		}

		return $link;
	}

	/**
	 * Alter Event Link for new Calendar views.
	 *
	 * @since 1.1.0
	 *
	 * @param \WP_Post $event The event post object.
	 *
	 * @return \WP_Post The event post object.
	 */
	public function filter_permalink_for_event( $event ) {

		$website_url = tribe_get_event_website_url( $event );

		if ( ! empty( $website_url ) ) {
			$event->permalink = $website_url;
		}

		return $event;
	}
}
