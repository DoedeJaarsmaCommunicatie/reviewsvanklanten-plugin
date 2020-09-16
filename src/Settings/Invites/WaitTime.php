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
            'description' => 'Tijd in dagen vanaf bestelling tot uitnodiging.'
        ]);
    }

    public static function title(): string
    {
        return 'Wacht tijd (dagen)';
    }
}
