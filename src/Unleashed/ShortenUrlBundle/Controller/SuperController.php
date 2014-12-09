<?php

namespace Unleashed\ShortenUrlBundle\Controller;

use Unleashed\ShortenUrlBundle\Traits\HelperTrait;
use Unleashed\ShortenUrlBundle\Traits\UtilitiesTrait;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SuperController extends Controller
{
    use HelperTrait, UtilitiesTrait;
}