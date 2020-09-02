<?php

namespace Reviewsvanklanten;

use Reviewsvanklanten\Settings\Settings;

class ReviewPlugin {
	/**
	 * @var bool
	 */
	protected static $is_booted = false;

	/**
	 * @var static|null
	 */
	protected static $_instance = null;

	public static function boot() {
		if (static::$is_booted) {
			return static::$_instance;
		}

		static::$_instance = new static();
		static::$is_booted = true;

		return static::$_instance;
	}

	public static function is_booted() {
		return static::$is_booted && null !== static::$_instance;
	}

	public function __construct()
	{
		$this->admin_hooks();
	}

	protected function admin_hooks()
	{
		add_action('admin_init', [Settings::class, 'register']);
		add_action('admin_menu', [Settings::class, 'register_menu_page']);
	}
}
