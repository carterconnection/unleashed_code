<?php

namespace Unleashed\ShortenUrlBundle\Services;

class ValidationService
{
    public function validateUrl($url)
    {
        $isValid = filter_var($url, FILTER_VALIDATE_URL);
        
        return $isValid;
    }
    
    public function sanitizeInput($value)
    {
        $cleanData = filter_var($value, FILTER_SANITIZE_STRING);
        
        return $cleanData;
    }
}