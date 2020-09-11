<?php

namespace Reviewsvanklanten;

use Mustache_Engine;
use Reviewsvanklanten\Settings\Settings;
use Reviewsvanklanten\Controllers\Internal\Updates;
use Reviewsvanklanten\Controllers\CustomProductProps;
use Reviewsvanklanten\Controllers\CustomReviewTemplate;

class ReviewPlugin {
	/**
	 * @var bool
	 */
	protected static $is_booted = false;

	/**
	 * @var static|null
	 */
	protected static $_instance = null;

    /**
     * @var Mustache_Engine|null
     */
	protected static $_template_engine = null;

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
		$this->public_hooks();

		$this->callInternals();
	}

    protected function callInternals()
    {
        Updates::bootstrap();
	}

	protected function admin_hooks()
	{
		add_action('admin_init', [Settings::class, 'register']);
		add_action('admin_menu', [Settings::class, 'register_menu_page']);

		add_filter('woocommerce_product_get_review_count', [CustomProductProps::class, 'custom_review_count'], 10, 0);
		add_filter('woocommerce_product_get_average_rating', [CustomProductProps::class, 'custom_average_rating'], 10, 0);
	}

    protected function public_hooks()
    {
        CustomReviewTemplate::bootstrap();
	}
}
