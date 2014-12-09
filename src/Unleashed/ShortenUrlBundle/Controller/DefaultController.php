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
    public function indexAction(Request $request, $name)
    {
        $urlcode = $this->get('shorten_url')->getShortUrl();
$this->pre($urlcode);die;
        return $this->render(
            'UnleashedShortenUrlBundle:Default:index.html.twig'
            , array(
                'name' => $name
            )
        );
    }
    
    public function viewAction(Request $request)
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
}
