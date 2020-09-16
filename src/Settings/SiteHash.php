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
            'description' => 'Deze code kan je vinden in jouw dashboard.'
        ]);
    }

    public static function title(): string
    {
        return 'Site Hash';
    }
}

