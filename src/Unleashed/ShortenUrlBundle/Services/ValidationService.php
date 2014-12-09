<?php

namespace Unleashed\ShortenUrlBundle\Services;

class ValidationService
{
    public function validateUrl($url)
    {
        $isValid = filter_var($url, FILTER_SANITIZE_URL);
    }
    
    public function validateInput($value)
    {
        $isValid = filter_var($value, FILTER_SANITIZE_STRING);
    }
}