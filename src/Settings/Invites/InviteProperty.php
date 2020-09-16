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
            'description' => _x('Send a review invite after purchase for your company.', 'WP Admin Settings', 'reviews-van-klanten'),
        ]);
    }

    public static function title(): string
    {
        return _x('Send invites on Product level', 'WP Admin Screen label', 'reviews-van-klanten');
    }

    public static function get_value($fallback = null)
    {
        return filter_var(setting(static::T_S_KEY, $fallback?? true), FILTER_VALIDATE_BOOLEAN);
    }

}
