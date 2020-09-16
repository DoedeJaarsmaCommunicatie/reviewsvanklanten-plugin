<?php

namespace Reviewsvanklanten\Settings;

use Reviewsvanklanten\Helpers\View;

class ApiKey extends AbstractSetting
{
	public const T_S_KEY = 'rvk_api_key';

	public static function callback()
	{
		$value = static::get_value();
	    View::render('settings/text_input', [
            'value' => $value,
            'name' => static::T_S_KEY,
            'description' => _x('Generate an API key in your dashboard.', 'WP Admin Screen', 'reviews-van-klanten'),
        ]);
	}

	public static function title(): string
    {
        return _x('API Key', 'WP Admin Screen label', 'reviews-van-klanten');
    }
}
