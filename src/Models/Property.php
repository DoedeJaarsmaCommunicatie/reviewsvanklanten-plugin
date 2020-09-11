<?php

namespace Reviewsvanklanten\Models;

use Illuminate\Support\Arr;
use Reviewsvanklanten\Settings\ApiKey;
use Symfony\Component\HttpClient\HttpClient;

use function Reviewsvanklanten\config;
use function Reviewsvanklanten\setting;

class Property
{
    public const T_K_TRANSIENT = 'rvk-property-cache-';
    public const T_K_META = 'rvk-property-uuid';

    public $id;
    public $uuid;
    public $name;
    public $description;

    public $reviewCount;

    protected $positiveAverage;
    protected $totalAverage;

    /**
     * @var Review[]
     */
    protected $reviews = [];

    /**
     * @var string[]
     */
    protected $links = [];

    private function __construct($uuid)
    {
        $client = HttpClient::create(
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . setting(ApiKey::get_key()),
                ]
            ]
        );

        $base_url = config('plugin.base_url');

        $res = $client->request(
            'GET',
            "$base_url/api/v1/properties/single/{$uuid}?type=hash"
        );

        $body = $res->toArray()['data'];
        $this->id = $body['id'];
        $this->name = $body['name'];
        $this->description = $body['description']?? '';
        $this->uuid = $body['uuid'];

        foreach($body['reviews'] as $review) {
            $this->reviews[] = new Review($review);
        }

        $this->reviewCount = $body['review_count'];
        $this->positiveAverage = $body['positive_average'];
        $this->totalAverage = $body['average'];

        $this->links = $res->toArray()['links'];
    }

    /**
     * @return Review[]
     */
    public function reviews()
    {
        return $this->reviews;
    }

    /**
     * @return Review|null
     */
    public function random_review()
    {
        return $this->reviews()[0];
    }

    /**
     * @return Review
     */
    public function latest_review()
    {
        return Arr::first($this->reviews());
    }

    public function get_average($type = 'normal')
    {
        switch ($type) {
            case 'positive':
                return (float) $this->positiveAverage;
            case 'normal':
            case 'total':
                return (float) $this->totalAverage;
            default:
                return 0.0;
        }
    }

    /**
     * @param string $link the link supports 'dot notation'
     *
     * @return false|mixed|string
     */
    public function get_link(string $link)
    {
        if (Arr::has($this->links, $link)) {
            return Arr::get($this->links, $link);
        }

        return false;
    }

    /**
     * @param null|int $product_id
     *
     * @return Property|void
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public static function make($product_id = null)
    {
        if (null === $product_id) {
            $product_id = get_queried_object_id();
        }

        if ($cached = get_transient(static::T_K_TRANSIENT . $product_id)) {
            return unserialize($cached, [__CLASS__]);
        }

        $uuid = get_post_meta($product_id, static::T_K_META, true);

        if (!$uuid) {
            $uuid = static::createRemoteProperty($product_id);
            update_post_meta($product_id, static::T_K_META, $uuid);
        }

        $self = new static($uuid);

        set_transient(self::T_K_TRANSIENT . $product_id, serialize($self), 600);

        return $self;
    }

    /**
     * @param int $product_id
     *
     * @return string the UUID received from remote request
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public static function createRemoteProperty($product_id)
    {
        $product = wc_get_product($product_id);
        $site = \Reviewsvanklanten\get_site();
        $client = HttpClient::create(
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . setting(ApiKey::get_key())
                ]
            ]
        );

        $base_url = config('plugin.base_url');

        $response = $client->request(
            'POST',
            "$base_url/api/v1/properties",
            [
                'body' => [
                    'name' => $product->get_name(),
                    'parent_type' => Site::T_K_PROPERTY_TYPE,
                    'parent_id' => $site->id
                ]
            ]
        );

        $body = $response->toArray()['data'];

        return $body['uuid'];
    }

    /**
     * @param Review $review
     *
     *
     * @return Property
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function saveReview($review)
    {
        $client = HttpClient::create(
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . setting(ApiKey::get_key())
                ]
            ]
        );

        $base_url = config('plugin.base_url');

        $client->request(
            'POST',
            "$base_url/api/v1/properties/review",
            [
                'body' => [
                    'name' => $review->get_name(),
                    'remarks' => $review->get_remarks(),
                    'email' => $review->get_email(),
                    'score' => $review->get_score(),
                    'property' => $this->uuid,
                ]
            ]
        );

        return $this;
    }
}
