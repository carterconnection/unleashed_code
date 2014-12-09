<?php

namespace Unleashed\ShortenUrlBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Unleashed\ShortenUrlBundle\Model\Urls;
use Unleashed\ShortenUrlBundle\Model\UsersByIp;
use Unleashed\ShortenUrlBundle\Model\UrlsQuery;
use Unleashed\ShortenUrlBundle\Model\UsersByIpQuery;

class DefaultController extends SuperController
{
    public function indexAction(Request $request)
    {
        if($request->getMethod() == 'POST'){
            $url = $request->request->get('url', null);
            $viewUrlCode = $this->insertUrl($url);

            if(!empty($viewUrlCode)){
                return $this->redirect($this->generateUrl('unleashed_view', array('urlCode' => $viewUrlCode)));                
            }
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

        $data->url = UrlsQuery::create('u')
            ->leftJoinWith('UsersByIp')
            ->addJoinCondition('UsersByIp', 'UsersByIp.IpAddress = ?', $this->getClientIp())
            ->filterByUrlCode($urlCode)
        ->findOne();
        
        $data->url->currentUserRedirects = null;
        foreach($data->url->getUsersByIps() as $redirect){
            $data->url->currentUserRedirects = $redirect->getRedirectCount();
        }
        
        $data->shortenedUrl = $this->generateUrl('unleashed_view', array('urlCode' => $data->url->getUrlCode()), true);

        return $this->render(
            'UnleashedShortenUrlBundle:Default:view.html.twig'
            , array(
                'data' => $data
            )
        );
    }
    
    public function redirectAction(Request $request, $urlCode)
    {
        $url = UrlsQuery::create()
            ->filterByUrlCode($urlCode)
        ->findOne();

        if($url){
            $this->recordRedirects($url);
            
            $redirectUrl = $this->get('validation')->prepareUrl($url->getFullUrl());
            header("Location:  $redirectUrl");
            exit;
        }
        
        return new Response('redirecting...');
    }
    
    public function downloadAction(Request $request)
    {
        return true;
    }
    
    private function recordRedirects($url)
    {
        $userRedirects = UsersByIpQuery::create()
            ->filterByIpAddress($this->getClientIp())
            ->filterByUrlId($url->getId())
        ->findOne();
        
        if(!empty($userRedirects)){
            $userRedirectsCount = $userRedirects->getRedirectCount() + 1;
        } else {
            $userRedirects = new UsersByIp();
            $userRedirects->setUrlId($url->getId());
            $userRedirects->setIpAddress($this->getClientIp());
            $userRedirectsCount = 1;
        }

        $userRedirects->setLastRedirect('now');
        $userRedirects->setRedirectCount($userRedirectsCount);
        $userRedirects->save();
        
        $url->setRedirectCount($url->getRedirectCount() + 1);
        $url->save();
    }
    
    private function insertUrl($url)
    {
        $validation = $this->get('validation');
        
        $check = UrlsQuery::create()
            ->filterByFullUrl($validation->sanitizeInput($url))
        ->findOne();
        
        if($check){
            $viewUrlCode = $check->getUrlCode();
            
        } else{

            if(!$validation->isValidateUrl($url) || !$validation->isValidDns($url)){ 
                $this->get('session')->getFlashBag()->add('notice','This Url is Invalid');
    
                return false;
            }
            
            $urlcode = $this->get('shorten_url')->getShortUrl();
           
            $newUrl = new Urls();
            $newUrl->setFullUrl($validation->sanitizeInput($url));
            $newUrl->setUrlCode($urlcode);
            $newUrl->setDateAdded('now');
            $newUrl->setQrCode(null);
            $newUrl->save();
            
            $viewUrlCode = $newUrl->getUrlCode();
        }
        
        return $viewUrlCode;
    }
}
