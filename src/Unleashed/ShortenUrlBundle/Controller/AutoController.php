<?php

namespace Unleashed\ShortenUrlBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Unleashed\ShortenUrlBundle\Model\Urls;
use Unleashed\ShortenUrlBundle\Model\UsersByIp;
use Unleashed\ShortenUrlBundle\Model\UrlsQuery;
use Unleashed\ShortenUrlBundle\Model\UsersByIpQuery;

class AutoController extends SuperController
{
    public function loadAnalyticsAction(Request $request)
    {
        $urlId = $request->request->get('urlId', null);
        
        $test = 'something';
        
        $response = new JsonResponse();
        $response->setData($test);
        
        return $response;
    }
}