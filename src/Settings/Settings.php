<?php

namespace Reviewsvanklanten\Settings;

use Illuminate\Support\Str;
use Reviewsvanklanten\Settings\Invites\WaitTime;
use Reviewsvanklanten\Settings\Invites\InviteCompany;
use Reviewsvanklanten\Settings\Invites\InviteProperty;

class Settings
{
	public const T_S_SETTING_NAME = 'reviews_van_klanten';

	public static function register(): void
	{
        static::register_settings();

		add_settings_section(
			static::generate_id('_base_section'),
			'Reviews van Klanten',
			[self::class, 'base_section_callback'],
			static::generate_id(false)
		);

        static::register_settings_fields();
	}

	protected static function register_settings(): void
    {
        static::register_Setting(ApiKey::get_key());
        static::register_Setting(SiteHash::get_key());
        static::register_Setting(UseCustomTemplate::get_key());
        static::register_Setting(WaitTime::get_key());
        static::register_setting(InviteCompany::get_key());
        static::register_setting(InviteProperty::get_key());
    }

    protected static function register_settings_fields(): void
    {
        static::register_base_setting_field(ApiKey::class);
        static::register_base_setting_field(SiteHash::class);
        static::register_base_setting_field(UseCustomTemplate::class);
        static::register_base_setting_field(WaitTime::class);
        static::register_base_setting_field(InviteCompany::class);
        static::register_base_setting_field(InviteProperty::class);
    }

	public static function register_menu_page(): void
    {
        add_options_page(
            'Reviews van Klanten instellingen',
            'Reviews van Klanten',
            'manage_options',
            static::generate_id('options_page'),
            [static::class, 'settings_page_callback']
        );
    }

	public static function base_section_callback(): void
	{
		?>
		<h2>Gebruik deze instellingen om reviews te tonen en te plaatsen.</h2>
		<?php
	}

	public static function settings_page_callback(): void
    {
        settings_errors(static::generate_id('errors'));
        ?>
            <div class="wrap">
                    <form action="options.php" method="post">
                        <?php
                        settings_fields(static::generate_id(false));
                        do_settings_sections(static::generate_id(false));
                        submit_button();
                        ?>
                    </form>
            </div>
        <?php
    }

	/**
	 * Returns a WP passable id for settings.
	 *
	 * Returns the base id when $key = false.
	 *
	 * @param string|false|null $key
	 *
	 * @return string
	 */
	public static function generate_id($key = null): string
	{
		if (null === $key)
		{
			return static::T_S_SETTING_NAME . '_' . Str::random(8);
		}

		if (false === $key)
		{
			return static::T_S_SETTING_NAME;
		}

		return static::T_S_SETTING_NAME . '_' . $key;
	}

	private static function register_setting($option_name): void
    {
        register_setting(static::generate_id(false), $option_name);
    }

    /**
     * @param AbstractSetting|string $setting
     */
    private static function register_base_setting_field($setting): void
    {
        add_settings_field(
            static::generate_id($setting::get_key('field')),
            $setting::title(),
            [$setting, 'callback'],
            static::generate_id(false),
            static::generate_id('_base_section')
        );
    }

}
