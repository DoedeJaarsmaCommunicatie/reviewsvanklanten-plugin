<?php

namespace Reviewsvanklanten\Settings;

use function Reviewsvanklanten\setting;

class ApiKey implements Setting
{
	public const T_S_KEY = 'rvk_api_key';

	public static function get_key($append = false)
	{
		if ($append) {
			return static::T_S_KEY . $append;
		}

		return static::T_S_KEY;
	}

	public static function callback()
	{
		$value = setting(static::T_S_KEY);
		?>
        <input type="text" value="<?=$value?>" name="<?=static::T_S_KEY?>" />
        <p class="description">Deze api key kan je aanmaken in jouw dashboard als token.</p>
		<?php
	}
}
