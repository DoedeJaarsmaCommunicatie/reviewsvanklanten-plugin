<?php

namespace Reviewsvanklanten\Controllers;

use Reviewsvanklanten\Settings\UseCustomTemplate;

class CustomReviewTemplate
{
    private static $_is_booted = false;

    private function __construct()
    {
        if (!$this->is_enabled()) {
            return;
        }

        add_filter('comments_template', [$this, 'comments_template_custom_loader'], 50);
    }

    public function comments_template_custom_loader($template)
    {
        if (get_post_type() !== 'product') {
            return $template;
        }

        $check_dirs = [
            trailingslashit( get_stylesheet_directory() ) . WC()->template_path(),
            trailingslashit( get_template_directory() ) . WC()->template_path(),
            trailingslashit( get_stylesheet_directory() ),
            trailingslashit( get_template_directory() ),
            trailingslashit( RVK_PLUGIN_DIR ) . 'views/templates/',
            trailingslashit( WC()->plugin_path() ) . 'templates/',
        ];


        foreach ( $check_dirs as $dir ) {
            if ( file_exists( trailingslashit( $dir ) . 'single-product-reviews.php' ) ) {
                return trailingslashit( $dir ) . 'single-product-reviews.php';
            }
        }

        return $template;
    }

    public function is_enabled(): bool
    {

        return UseCustomTemplate::get_value();
    }

    public static function bootstrap(): void
    {
        if (static::$_is_booted) {
            return;
        }

        new static();
        static::$_is_booted = true;
    }
}
