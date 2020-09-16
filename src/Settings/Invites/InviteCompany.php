<?php

namespace Reviewsvanklanten\Settings\Invites;

use Reviewsvanklanten\Helpers\View;
use Reviewsvanklanten\Settings\AbstractSetting;

use function Reviewsvanklanten\setting;

class InviteCompany extends AbstractSetting
{
    public const T_S_KEY = 'rvk_invite_company';

    public static function callback()
    {
        View::render('/settings/checkbox_input', [
            'value' => static::get_value(),
            'name' => static::T_S_KEY,
            'description' => 'Laat jouw bedrijf beoordelen na het doen van een aankoop.'
        ]);
    }

    public static function title(): string
    {
        return 'Stuur uitnodiging om bedrijf te beoordelen';
    }

    public static function get_value($fallback = null)
    {
        return filter_var(setting(static::T_S_KEY, $fallback?? true), FILTER_VALIDATE_BOOLEAN);
    }
}
