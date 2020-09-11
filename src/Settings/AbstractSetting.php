<?php

namespace Reviewsvanklanten\Settings;

use function Reviewsvanklanten\setting;

abstract class AbstractSetting implements Setting
{
    public const T_S_KEY = '';

    public static function get_key($append = false)
    {
        if ($append) {
            return static::T_S_KEY . $append;
        }

        return static::T_S_KEY;
    }

    public static function get_value()
    {
        return setting(static::T_S_KEY);
    }
}
