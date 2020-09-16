<?php

namespace Reviewsvanklanten\Settings;

use Reviewsvanklanten\Helpers\View;

class SiteHash extends AbstractSetting
{
    public const T_S_KEY = 'rvk_site_hash';

    public static function callback()
    {
        $value = static::get_value();
        View::render('/settings/text_input', [
            'value' => $value,
            'name' => static::T_S_KEY,
            'description' => __('You can find this code in your dashboard.', 'reviews-van-klanten')
        ]);
    }

    public static function title(): string
    {
        return __('Site Hash', 'reviews-van-klanten');
    }
}

