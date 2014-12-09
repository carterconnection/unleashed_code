<?php

namespace Unleashed\ShortenUrlBundle\Services;

class ValidationService
{
    private $url;
    private $isValidDns = false;
    private $isValidUrl = false;

    public function validateUrl()
    {
        if(preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$this->url)) {
            $this->isValidUrl = true;
        }
    }
    
    public function validateDns()
    {
        $parsed = parse_url($this->url);
        
        if(isset($parsed['host'])){
            $this->isValidDns = checkdnsrr($parsed['host'], 'A');    
        }
        
    }
    
    public function sanitizeInput($value, $isUrl = false)
    {
        $value = strip_tags($value);

        if($isUrl){
            $cleanData = filter_var($value, FILTER_SANITIZE_URL); 
        } else {
            $cleanData = filter_var($value, FILTER_SANITIZE_STRING);
        }
        
        return $cleanData;
    }
    
    public function prepareUrl($url)
    {
        $this->url = $this->sanitizeInput($url, true);
        
        // if protocol is not defined - define it (which it should always be)
        if((strpos($this->url, 'http://') !== 0 && strpos($this->url, 'https://') !== 0)){
            $this->url = 'http://'. $this->url;
        }
        
        $this->validateUrl();
        $this->validateDns();
        
        if(!$this->isValidUrl || !$this->isValidDns){
            return false;
        } else {
            return $this->url;
        }
    }
}