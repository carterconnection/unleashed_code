<?php

namespace Unleashed\ShortenUrlBundle\Services;

use Unleashed\ShortenUrlBundle\Model\Urls;
use Unleashed\ShortenUrlBundle\Model\UrlsQuery;

class ShortenUrlService
{
    private $urlCode;
    private $validation;
    private $allowedChars = '123456789bcdfghjkmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ';
    
    public function __construct($validation)
    {
        $this->validation = $validation;
    }
    
    public function newUrlCode($url)
    {
        $url = $this->validation->prepareUrl($url);
        
        if(empty($url)){
            return false;
        }
        
        $check = UrlsQuery::create()
            ->filterByFullUrl($url)
        ->findOne();
        
        if($check){
            $viewUrl = $check;
            
        } else{
            
            $urlcode = $this->getShortUrl();
           
            $newUrl = new Urls();
            $newUrl->setFullUrl($url);
            $newUrl->setUrlCode($urlcode);
            $newUrl->setDateAdded('now');
            $newUrl->setQrCode(null);
            $newUrl->save();
            
            $viewUrl = $newUrl;
        }
        
        return $viewUrl;
    }
    
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