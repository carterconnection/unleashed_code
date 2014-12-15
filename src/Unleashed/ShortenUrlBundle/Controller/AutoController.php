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
        $data = new \stdClass();
        $urlId = $request->request->get('urlId', null);
        
        $data->test = 'test data';
        
        $response = new JsonResponse();
        $response->setData($data);
        
        return $response;
    }
    
    public function getShortUrlAction(Request $request)
    {
        $data = new \stdClass();
        $data->error = false;        
        $response = new JsonResponse();
        $url = $request->request->get('url', null);

        try{
        
            $result = $this->get('shorten_url')->newUrlCode($url);
            if(empty($result)){
                throw new \Exception('An Error Occured While Creating Short Url');
            }
            $returnArray = $result->toArray();
            unset($returnArray['Id']);
            $data->result = $returnArray;;
        } catch(\Exception $e){
            
            $data->error = true;
            $data->errorMessage = 'Not a Valid Url';
        }

        $response->setData($data);
        
        return $response;
    }
}