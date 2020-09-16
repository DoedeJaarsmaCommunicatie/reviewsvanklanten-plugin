<?php

namespace Reviewsvanklanten;

use Reviewsvanklanten\Models\Site;
use Reviewsvanklanten\Helpers\View;
use Reviewsvanklanten\Helpers\Http;
use Reviewsvanklanten\Helpers\Config;
use Reviewsvanklanten\Models\Property;
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

if (!function_exists(__NAMESPACE__ . 'get_site')) {
    /**
     * @return Site|void
     */
    function get_site() {
        return Site::make();
    }
}

if (!function_exists(__NAMESPACE__ . 'get_current_property')) {
    /**
     * @return Property|void
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    function get_current_property() {
        return Property::make(get_queried_object_id());
    }
}

if (!function_exists(__NAMESPACE__ . 'get_property')) {
    /**
     * @param int $id
     *
     * @return Property|void
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    function get_property(int $id) {
        return Property::make($id);
    }
}

if (!function_exists(__NAMESPACE__ . 'render_view')) {
    /**
     * @param string $path
     * @param array  $data
     *
     * @see View::render
     */
    function render_view(string $path, array $data = []) {
        View::render(...func_get_args());
    }
}

if (!function_exists(__NAMESPACE__ . 'view')) {
    /**
     * @param string $path
     * @param array  $data
     *
     * @return string
     */
    function view(string $path, array $data = []) {
        return View::make(...func_get_args());
    }
}

if (!function_exists(__NAMESPACE__ . '')) {
    function http_client()
    {
        return Http::client();
    }
}
