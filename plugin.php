<?php

/*
Plugin Name: Reviews van Klanten koppeling
Plugin URI: https://reviewsvanklanten.nl/plugin
Description: Deze plugin legt de koppeling tussen jouw WooCommerce winkel en Reviews van Klanten.
Version: 1.0
Author: Reviews van Klanten team
License: MIT
*/

use Reviewsvanklanten\ReviewPlugin;
use Reviewsvanklanten\Installers\Installer;
use Reviewsvanklanten\Installers\DeInstaller;

define('RVK_SLUG', 'RVK');
define('RVK_VERSION', '1.0.0');
define('RVK_FILE', __FILE__);
define('RVK_PLUGIN_DIR', plugin_dir_path(RVK_FILE));

require_once __DIR__ . '/vendor/autoload.php';

ReviewPlugin::boot();

register_activation_hook(__FILE__, [Installer::class, 'install']);
register_deactivation_hook(__FILE__, [DeInstaller::class, 'de_install']);

