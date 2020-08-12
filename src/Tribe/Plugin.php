<?php
namespace Tribe\Extensions\Event_Link_To_Website_URL;

/**
 * Class Plugin
 *
 * @since   1.1.0
 *
 * @package Tribe\Extensions\Event_Link_To_Website_URL
 */
class Plugin extends \tad_DI52_ServiceProvider {
	/**
	 * Stores the version for the plugin.
	 *
	 * @since 1.1.0
	 *
	 * @var string
	 */
	const VERSION = '1.1.0';

	/**
	 * Stores the base slug for the plugin.
	 *
	 * @since 1.1.0
	 *
	 * @var string
	 */
	const SLUG = 'link-events-to-website-urls';

	/**
	 * Stores the base slug for the extension.
	 *
	 * @since 1.1.0
	 *
	 * @var string
	 */
	const FILE = TRIBE_EXTENSION_LINK_EVENTS_TO_WEBSITE_URLS_FILE;

	/**
	 * @since 1.1.0
	 *
	 * @var string Plugin Directory.
	 */
	public $plugin_dir;

	/**
	 * @since 1.1.0
	 *
	 * @var string Plugin path.
	 */
	public $plugin_path;

	/**
	 * @since 1.1.0
	 *
	 * @var string Plugin URL.
	 */
	public $plugin_url;

	/**
	 * Setup the Extension's properties.
	 *
	 * This always executes even if the required plugins are not present.
	 *
	 * @since 1.1.0
	 */
	public function register() {
		// Set up the plugin provider properties.
		$this->plugin_path = trailingslashit( dirname( static::FILE ) );
		$this->plugin_dir  = trailingslashit( basename( $this->plugin_path ) );
		$this->plugin_url  = plugins_url( $this->plugin_dir, $this->plugin_path );

		// Register this provider as the main one and use a bunch of aliases.
		$this->container->singleton( static::class, $this );
		$this->container->singleton( 'extension.link_events_to_website_urls', $this );
		$this->container->singleton( 'extension.link_events_to_website_urls.plugin', $this );
		$this->container->register( PUE::class );

		if ( ! $this->check_plugin_dependencies() ) {
			// If the plugin dependency manifest is not met, then bail and stop here.
			return;
		}

		// Start binds.



		// End binds.

		$this->container->register( Hooks::class );
		$this->container->register( Assets::class );
	}

	/**
	 * Checks whether the plugin dependency manifest is satisfied or not.
	 *
	 * @since 1.1.0
	 *
	 * @return bool Whether the plugin dependency manifest is satisfied or not.
	 */
	protected function check_plugin_dependencies() {
		$this->register_plugin_dependencies();

		if ( ! tribe_check_plugin( static::class ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Registers the plugin and dependency manifest among those managed by Tribe Common.
	 *
	 * @since 1.1.0
	 */
	protected function register_plugin_dependencies() {
		$plugin_register = new Plugin_Register();
		$plugin_register->register_plugin();

		$this->container->singleton( Plugin_Register::class, $plugin_register );
		$this->container->singleton( 'extension.link_events_to_website_urls', $plugin_register );
	}
}
