<?php

namespace Unleashed\ShortenUrlBundle\Controller;



class DefaultController extends SuperController
{
    public function indexAction($name)
    {
        return $this->render(
            'UnleashedShortenUrlBundle:Default:index.html.twig'
            , array(
                'name' => $name
            )
        );
    }
}
