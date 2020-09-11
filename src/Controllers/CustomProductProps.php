<?php

namespace Reviewsvanklanten\Controllers;

use function Reviewsvanklanten\get_current_property;

class CustomProductProps
{
    public static function custom_review_count()
    {
        $property = get_current_property();
        if (!$property) {
            return 0;
        }

        return $property->reviewCount;
    }

    public static function custom_average_rating()
    {
        $property = get_current_property();
        if (!$property) {
            return 0;
        }

        return $property->get_average() / 2;
    }
}
