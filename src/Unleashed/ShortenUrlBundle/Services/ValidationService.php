<?php

namespace Unleashed\ShortenUrlBundle\Services;

class ValidationService
{
    public function isValidateUrl($url)
    {
        $this->prepareUrl($url);
        
        $isValid = filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_SCHEME_REQUIRED | FILTER_FLAG_HOST_REQUIRED);
        
        return $isValid;
    }
    
    public function isValidDns($url)
    {
        // checkdnsrr doesnt like protocol - so remove it
        $remove = array('https://', 'http://');
        $url = str_replace($remove, '', $url);
        
        $isValid = checkdnsrr($url, 'A');
        
        return $isValid;
    }
    
    public function sanitizeInput($value)
    {
        $cleanData = filter_var($value, FILTER_SANITIZE_URL);
        
        return $cleanData;
    }
    
    public function prepareUrl($url)
    {
        // if protocol is not defined - define it (which it should always be)
        if((strpos($url, 'http://') !== 0 && strpos($url, 'https://') !== 0)){
            $url = 'http://'. $url;
        }
        
        return $url;
    }
}