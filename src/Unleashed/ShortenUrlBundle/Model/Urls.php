<?php

namespace Unleashed\ShortenUrlBundle\Model;

use Unleashed\ShortenUrlBundle\Model\om\BaseUrls;
use Unleashed\ShortenUrlBundle\Model\UsersByIp;

class Urls extends BaseUrls
{
    public function postInsert(\PropelPDO $con = null)
    {
        $newUserInsert = new UsersByIp();
        $newUserInsert->setIpAddress($_SERVER['REMOTE_ADDR']);
        $newUserInsert->setUrlId($this->getId());
        $newUserInsert->save();
    }
}
