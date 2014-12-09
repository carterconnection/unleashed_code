<?php

namespace Unleashed\ShortenUrlBundle\Services;

use Unleashed\ShortenUrlBundle\Model\UrlsQuery;

class ShortenUrlService
{
    private $urlCode;
    private $allowedChars = '123456789bcdfghjkmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ';
    
    public function __construct()
    {
        
    }
    
    public function getShortUrl()
    {   
        // set code length between 5 - 9
        $codeLength = rand(5, 9);
        
        $code = '';
        for($i = 0; $i < $codeLength; $i++){
            $allowedIndex = rand(0, 49);
            $code .= $this->allowedChars[$allowedIndex];
        }
        
        return $code;
    }
    
    private function isCodeInUse()
    {
        $url = UrlsQuery::create()
            ->filterByUrlCode()
        ->findOne();
    }
}