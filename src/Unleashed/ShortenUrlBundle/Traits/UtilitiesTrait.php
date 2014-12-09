<?php

namespace Unleashed\ShortenUrlBundle\Traits;

trait UtilitiesTrait
{
    public function getClientIp()
    {
        return $_SERVER['REMOTE_ADDR'];
    }
}