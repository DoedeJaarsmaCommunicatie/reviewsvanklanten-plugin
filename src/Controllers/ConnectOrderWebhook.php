<?php

namespace Reviewsvanklanten\Controllers;

use Reviewsvanklanten\Helpers\Http;

use Reviewsvanklanten\Models\Property;
use Reviewsvanklanten\Settings\SiteHash;
use Reviewsvanklanten\Settings\Invites\WaitTime;
use Symfony\Contracts\HttpClient\HttpClientInterface;

use Reviewsvanklanten\Settings\Invites\InviteCompany;
use Reviewsvanklanten\Settings\Invites\InviteProperty;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

use function Reviewsvanklanten\config;
use function Reviewsvanklanten\http_client;

class ConnectOrderWebhook
{
    private static $_is_booted = false;

    private function __construct()
    {
        add_action('woocommerce_order_status_processing', [$this, 'fire_order_event_hook']);
    }

    public function fire_order_event_hook($order_id): void
    {
        $order = wc_get_order($order_id);

        $client = http_client();
        $base_url = config('plugin.base_url');


        if (InviteProperty::get_value()) {
            $this->createProductInvitations($client, $base_url, $order);
        }

        if (InviteCompany::get_value()) {
            $this->createCompanyInvitation($client, $base_url, $order);
        }
    }

    private function createProductInvitations(
        HttpClientInterface $client,
        string $base_url,
        \WC_Order $order
    ): void
    {
        $products = [];

        foreach ($order->get_items() as $item) {
            $property = Property::make($item->get_product_id());
            if (!$property) {
                continue;
            }

            if ($property->uuid) {
                $products []= $property->uuid;
            }
        }


        try {
            $client->request(
                Http::REQUEST_POST,
                "$base_url/api/v1/invitations/properties",
                [
                    'body' => [
                        'to' => $order->get_billing_email('edit'),
                        'wait' => WaitTime::get_value(10),
                        'name' => $order->get_billing_first_name('edit') . ' ' . $order->get_billing_last_name('edit'),
                        'targets' => $products
                    ]
                ]
            );
        } catch (TransportExceptionInterface $e) {
            // Do nothing.
        }
    }

    private function createCompanyInvitation(
        HttpClientInterface $client,
        string $base_url,
        \WC_Order $order
    ): void
    {
        try {
            $client->request(
                Http::REQUEST_POST,
                "$base_url/api/v1/invitations/company",
                [
                    'body' => [
                        'to' => $order->get_billing_email('edit'),
                        'target' => SiteHash::get_value(),
                        'wait' => WaitTime::get_value(10),
                        'name' => $order->get_billing_first_name('edit') . ' ' . $order->get_billing_last_name('edit')
                    ]
                ]
            );
        } catch (TransportExceptionInterface $e) {
            // Do nothing.
        }
    }

    public static function bootstrap(): void
    {
        if (static::$_is_booted) {
            return;
        }

        new static();
        static::$_is_booted;
    }
}
