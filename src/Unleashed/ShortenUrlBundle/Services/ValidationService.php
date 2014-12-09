<?php

namespace Unleashed\ShortenUrlBundle\Services;

class ValidationService
{
    public function isValidateUrl($url)
    {
        if((strpos($url, "http://") !== 0 && strpos($url, "https://") !== 0)){
            $url = 'http://'. $url;
        }
        
        $isValid = filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_SCHEME_REQUIRED | FILTER_FLAG_HOST_REQUIRED);
        
        return $isValid;
    }
    
    public function isValidDns($url)
    {
        $isValid = checkdnsrr($url, 'A');
        
        return $isValid;
    }
    
    public function sanitizeInput($value)
    {
        $cleanData = filter_var($value, FILTER_SANITIZE_URL);
        
        return $cleanData;
    }
}