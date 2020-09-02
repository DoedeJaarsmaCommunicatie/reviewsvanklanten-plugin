<?php

namespace Reviewsvanklanten;

use Reviewsvanklanten\Helpers\Config;
use Reviewsvanklanten\Helpers\Settings;

if (!function_exists(__NAMESPACE__ . 'config')) {
    /**
     * @param string $key
     * @param null|string $default
     *
     * @return array|false|mixed
     * @see Config::get
     */
    function config(string $key, ?string $default = null) {
        return Config::get($key, $default);
    }
}

if (!function_exists(__NAMESPACE__ . 'settings')) {
    /**
     * @param string $key
     * @param null|string $default
     *
     * @return false|mixed|void
     * @see Settings::get
     */
    function setting(string $key, ?string $default = null) {
        return Settings::get($key, $default);
    }
}
