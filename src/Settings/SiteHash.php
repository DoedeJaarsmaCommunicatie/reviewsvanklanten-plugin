<?php

namespace Reviewsvanklanten\Settings;

use function Reviewsvanklanten\setting;

class SiteHash implements Setting
{
    public const T_S_KEY = 'rvk_site_hash';

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
        <p class="description">Deze code kan je vinden in jouw dashboard.</p>
        <?php
    }
}

