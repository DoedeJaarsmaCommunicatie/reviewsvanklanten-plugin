<?php

namespace Reviewsvanklanten\Settings;

interface Setting
{
	public static function get_key($append = false);
	public static function callback();
}
