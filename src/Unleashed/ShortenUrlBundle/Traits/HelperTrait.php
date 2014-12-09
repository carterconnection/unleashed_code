<?php

namespace Unleashed\ShortenUrlBundle\Traits;

trait HelperTrait
{
    
    /**
     * Easy debugging print_r
     *
     */
    public function pre($value)
    {
        print '<pre style="padding:15px;font-family: '.
        'Helvetica Neue,Arial,sans-serif;font-size:16px;'.
        'color:#fff;background-color:#44619D;">';

        print_r($value);

        print '</pre>';
    }
}