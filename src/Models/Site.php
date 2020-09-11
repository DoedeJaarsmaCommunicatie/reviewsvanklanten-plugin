<?php

namespace Reviewsvanklanten\Models;

use Illuminate\Support\Arr;
use Reviewsvanklanten\Settings\ApiKey;
use Reviewsvanklanten\Settings\SiteHash;
use Symfony\Component\HttpClient\HttpClient;

use function Reviewsvanklanten\setting;
use function Reviewsvanklanten\Config;

class Site
{
    public const T_K_TRANSIENT = 'rvk-site-cache';
    public const T_K_PROPERTY_TYPE = 'COMPANY';

    public $id;
    public $name;
    public $uuid;
    public $description;

    public $reviewCount;

    protected $positiveAverage;
    protected $totalAverage;
    /**
     * @var Review[]
     */
    protected $reviews = [];

    private function __construct($uuid)
    {
        $client = HttpClient::create(
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . setting(ApiKey::get_key())
                ],
            ]
        );

        $base_url = config('plugin.base_url');

        $res = $client->request(
            'GET',
            "$base_url/api/v1/companies/single/{$uuid}?type=hash"
        );

        $body = $res->toArray()['data'];
        $this->id = $body['id'];
        $this->name = $body['name'];
        $this->uuid = $body['uuid'];
        $this->description = $body['description']?? null;

        foreach ($body['reviews'] as $review) {
            $this->reviews[] = new Review($review);
        }

        $this->reviewCount = $body['review_count'];
        $this->positiveAverage = $body['positive_average'];
        $this->totalAverage = $body['average'];
    }

    public function reviews()
    {
        return $this->reviews;
    }

    public function random_review()
    {

        return Arr::random($this->reviews());
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
     * @return Site|void
     */
    public static function make()
    {
        if ($cached = get_transient(self::T_K_TRANSIENT)) {
            return unserialize($cached, [__CLASS__]);
        }

        $uuid = setting(SiteHash::get_key(), false);

        if (!$uuid) {
            add_action('admin_notices', static function () {
                ?>
                <div class="notice notice-error">
                    <p>Er is geen site id toegevoegd.</p>
                </div>
                <?php
            });
            error_log('No site ID passed to site make in reviews van klanten plugin.');
            return;
        }

        $self = new static($uuid);

        set_transient(self::T_K_TRANSIENT, serialize($self), 3600);

        return $self;
    }

    /**
     * @param Review $review
     *
     * @return Site
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function saveReview($review)
    {
        $client = HttpClient::create(
                [
                        'headers' => [
                                'Authorization' => 'Bearer ' . setting(ApiKey::get_key()),
                        ],
                ]
        );

        $base_url = config('plugin.base_url');

        $client->request(
            'POST',
            "$base_url/api/v1/companies/review",
            [
                'body' => [
                    'name' => $review->get_name(),
                    'remarks' => $review->get_remarks(),
                    'email' => $review->get_email(),
                    'score' => $review->get_score(),
                    'company' => $this->uuid,
                ]
            ]
        );

        return static::make();
    }
}
