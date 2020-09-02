<?php

namespace Reviewsvanklanten\Helpers;

use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class Config
{
    public static function get($key, $default = null)
    {
        $splitKey = explode('.', $key);

        $data = static::getFile(array_shift($splitKey));

        if (!Arr::has($data, implode('.', $splitKey))) {
            return $default;
        }

        $loopData = $data;
        foreach ($splitKey as $split) {
            $loopData = $loopData[$split];
        }

        return $loopData?? $default;
    }

    /**
     * @param $filename
     *
     * @return false|array
     */
    private static function getFile($filename)
    {
        if (!Str::endsWith($filename, '.php')) {
            $filename .= '.php';
        }

        $file = include RVK_PLUGIN_DIR . '/config/' . $filename;

        if ($file) {
            return $file;
        }

        return false;
    }
}
