<?php

namespace Reviewsvanklanten\Settings\Invites;

use Reviewsvanklanten\Helpers\View;
use Reviewsvanklanten\Settings\AbstractSetting;

class WaitTime extends AbstractSetting
{
    public const T_S_KEY = 'rvk_invite_wait_time';

    public static function callback()
    {
        View::render('settings/text_input', [
            'value' => static::get_value(10),
            'name' => static::T_S_KEY,
            'description' => _x('Delay in days to send invite.', 'WP Admin Screen', 'reviews-van-klanten')
        ]);
    }

    public static function title(): string
    {
        return _x('Delay (days)', 'WP Admin Screen label', 'reviews-van-klanten');
    }
}
