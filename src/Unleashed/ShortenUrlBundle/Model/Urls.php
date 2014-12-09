<?php

namespace Unleashed\ShortenUrlBundle\Model;

use Unleashed\ShortenUrlBundle\Model\om\BaseUrls;
use Unleashed\ShortenUrlBundle\Model\UsersByIp;

use Unleashed\ShortenUrlBundle\Traits\UtilitiesTrait;

class Urls extends BaseUrls
{
    use UtilitiesTrait;
    
    public function postInsert(\PropelPDO $con = null)
    {
        $newUserInsert = new UsersByIp();
        $newUserInsert->setIpAddress($this->getClientIp());
        $newUserInsert->setUrlId($this->getId());
        $newUserInsert->save();
    }
}
