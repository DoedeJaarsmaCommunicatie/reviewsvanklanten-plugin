<?php

namespace Reviewsvanklanten\Settings\Invites;

use Reviewsvanklanten\Helpers\View;
use Reviewsvanklanten\Settings\AbstractSetting;

use function Reviewsvanklanten\setting;

class InviteProperty extends AbstractSetting
{
    public const T_S_KEY = 'rvk_invite_property';

    public static function callback()
    {
        View::render('/settings/checkbox_input', [
            'value' => static::get_value(),
            'name' => static::T_S_KEY,
            'description' => 'Kies er voor om producten te laten reviewen na aankoop.'
        ]);
    }

    public static function title(): string
    {
        return 'Stuur product review uitnodigingen';
    }

    public static function get_value($fallback = null)
    {
        return filter_var(setting(static::T_S_KEY, $fallback?? true), FILTER_VALIDATE_BOOLEAN);
    }

}
