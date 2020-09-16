<?php

namespace Reviewsvanklanten\Helpers;

use Reviewsvanklanten\Settings\ApiKey;
use Symfony\Component\HttpClient\HttpClient;

use Symfony\Contracts\HttpClient\HttpClientInterface;

use function Reviewsvanklanten\setting;

class Http
{
    public const REQUEST_POST = 'POST';
    public const REQUEST_GET = 'GET';
    public const REQUEST_PUT = 'PUT';
    public const REQUEST_PATCH = 'PATCH';

    /**
     * @return HttpClientInterface
     */
    public static function client(): HttpClientInterface
    {
        return HttpClient::create(
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . setting(ApiKey::get_key()),
                ]
            ]
        );
    }
}
