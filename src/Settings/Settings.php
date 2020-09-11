<?php

namespace Reviewsvanklanten\Settings;

use Illuminate\Support\Str;

class Settings
{
	public const T_S_SETTING_NAME = 'reviews_van_klanten';

	public static function register(): void
	{
		register_setting(static::generate_id(false), ApiKey::get_key());
		register_setting(static::generate_id(false), SiteHash::get_key());
        register_setting(static::generate_id(false), UseCustomTemplate::get_key());

		add_settings_section(
			static::generate_id('_base_section'),
			'Reviews van Klanten',
			[self::class, 'base_section_callback'],
			static::generate_id(false)
		);

		add_settings_field(
			static::generate_id(ApiKey::get_key('field')),
			'API Key',
			[ApiKey::class, 'callback'],
			static::generate_id(false),
            static::generate_id('_base_section')
		);

		add_settings_field(
		        static::generate_id(SiteHash::get_key('field')),
            'Site Hash',
            [SiteHash::class, 'callback'],
            static::generate_id(false),
            static::generate_id('_base_section')
        );

		add_settings_field(
            static::generate_id(UseCustomTemplate::get_key('field')),
            'Gebruik onze templates',
            [UseCustomTemplate::class, 'callback'],
            static::generate_id(false),
            static::generate_id('_base_section')
        );
	}

	public static function register_menu_page()
    {
        add_options_page(
            'Reviews van Klanten instellingen',
            'Reviews van Klanten',
            'manage_options',
            static::generate_id('options_page'),
            [static::class, 'settings_page_callback']
        );
    }

	public static function base_section_callback()
	{
		?>
		<h2>Gebruik deze instellingen om reviews te tonen en te plaatsen.</h2>
		<?php
	}

	public static function settings_page_callback()
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
	public static function generate_id($key = null)
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
}
