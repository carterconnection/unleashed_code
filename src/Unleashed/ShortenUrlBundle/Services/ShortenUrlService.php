<?php

namespace Unleashed\ShortenUrlBundle\Services;

use Unleashed\ShortenUrlBundle\Model\UrlsQuery;

class ShortenUrlService
{
    private $urlCode;
    private $allowedChars = '123456789bcdfghjkmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ';
    
    public function getShortUrl()
    {   
        $this->generateCode();
        
        return $this->urlCode;
    }
    
    private function generateCode()
    {
        // set code length between 5 - 9
        $codeLength = rand(5, 9);
        
        $this->urlCode = '';
        for($i = 0; $i < $codeLength; $i++){
            $allowedIndex = rand(0, 49);
            $this->urlCode .= $this->allowedChars[$allowedIndex];
        }
        
        // check if code is already in use
        if($this->isCodeInUse()){
            $this->generateCode();
        }
    }
    
    private function isCodeInUse()
    {
        $url = UrlsQuery::create()
            ->filterByUrlCode($this->urlCode)
        ->findOne();

        return !empty($url);
    }
}