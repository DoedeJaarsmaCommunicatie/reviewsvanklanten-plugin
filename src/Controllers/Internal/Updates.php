<?php

namespace Reviewsvanklanten\Controllers\Internal;

class Updates
{
    public static function bootstrap()
    {
        $update_checker = \Puc_v4_Factory::buildUpdateChecker(
            'https://github.com/DoedeJaarsmaCommunicatie/reviewsvanklanten-plugin',
            RVK_FILE,
            'reviews-van-klanten'
        );
    }
}
