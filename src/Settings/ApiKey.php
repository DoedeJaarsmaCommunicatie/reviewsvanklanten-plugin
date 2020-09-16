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
            'description' => 'Deze api key kan je aanmaken in jouw dashboard als token.'
        ]);
	}

	public static function title(): string
    {
        return 'API Key';
    }
}
