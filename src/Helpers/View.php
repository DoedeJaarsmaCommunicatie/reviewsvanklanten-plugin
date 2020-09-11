<?php

namespace Reviewsvanklanten\Helpers;

use Mustache_Engine;
use Illuminate\Support\Str;
use Mustache_Loader_FilesystemLoader;

class View
{
    /**
     * @var null|Mustache_Engine
     */
    protected static $_template_engine = null;

    /**
     * @param string $path a '/' delimited string based on plugin base.
     * @param array  $data the data to be passed to the template.
     *
     * @return string
     */
    public static function make(string $path, array $data = [])
    {
        $base_path = RVK_PLUGIN_DIR;

        if (Str::startsWith($path, 'views/')) {
            $path = Str::replaceFirst('views/', '', $path);
        }

        return static::build()->render($path, $data);
    }

    /**
     * @param string $path a '/' delimited string based on plugin base.
     * @param array  $data the data to be passed to the template.
     *
     * @see View::make
     * @return void
     */
    public static function render(string $path, array $data = []): void
    {
        print static::make(...func_get_args());
    }

    /**
     * @return Mustache_Engine
     */
    protected static function build(): Mustache_Engine
    {
        if (null !== static::$_template_engine) {
            return static::$_template_engine;
        }

        static::$_template_engine = new Mustache_Engine(
            [
                'loader' => new Mustache_Loader_FilesystemLoader(RVK_PLUGIN_DIR . '/views'),
            ]
        );

        return static::$_template_engine;
    }
}
