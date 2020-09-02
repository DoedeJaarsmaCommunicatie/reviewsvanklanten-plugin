<?php

namespace Reviewsvanklanten\Helpers;

class Settings
{
	public static function get($key, $fallback = null)
	{
		return get_option($key, $fallback);
	}
}
