<?php

namespace Unleashed\ShortenUrlBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Unleashed\ShortenUrlBundle\Model\Urls;
use Unleashed\ShortenUrlBundle\Model\UserByIp;
use Unleashed\ShortenUrlBundle\Model\UrlsQuery;
use Unleashed\ShortenUrlBundle\Model\UserByIpQuery;

class DefaultController extends SuperController
{
    public function indexAction(Request $request)
    {
        if($request->getMethod() == 'POST'){
            $url = $request->request->get('url', null);
            $this->insertUrl($url);
            
//$this->pre($this->insertUrl());die;
        }
        
        
        return $this->render(
            'UnleashedShortenUrlBundle:Default:index.html.twig'
            , array(
                
            )
        );
    }
    
    public function viewAction(Request $request, $urlCode)
    {
        $data = new \stdClass();
        
        return $this->render(
            'UnleashedShortenUrlBundle:Default:view.html.twig'
            , array(
                'data' => $data
            )
        );
    }
    
    public function redirectAction(Request $request)
    {
        return true;
    }
    
    public function downloadAction(Request $request)
    {
        return true;
    }
    
    private function insertUrl($url)
    {
        $validation = $this->get('validation');

        if(!$validation->isValidateUrl($url) || !$validation->isValidDns($url)){
            $this->get('session')->getFlashBag()->add('notice','This Url is Invalid');
            
            return false;
        }
        
        $check = UrlsQuery::create()
            ->filterByFullUrl($url)
        ->findOne();
        
        if($check){
            $this->redirect($this->generateUrl('unleashed_view', array('urlCode' => $check->getUrlCode())));
        }
        
        $urlcode = $this->get('shorten_url')->getShortUrl();
            
        $newUrl = new Urls();
        $newUrl->setFullUrl($validation->sanitizeInput($url));
        $newUrl->setUrlCode($urlcode);
        $newUrl->setDateAdded('now');
        $newUrl->setQrCode(null);
        
        return $urlcode;
    }
}
