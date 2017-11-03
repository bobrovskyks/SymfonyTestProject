<?php

namespace symfony\LibraryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('symfonyLibraryBundle:Default:index.html.twig');
    }
}
