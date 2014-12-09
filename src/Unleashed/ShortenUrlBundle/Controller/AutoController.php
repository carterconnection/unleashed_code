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
    public function loadAnalytics(Request $request)
    {
        $test = 'something';
        
        $response = new JsonResponse();
        $response->setData($test);
        
        return $response;
    }
}