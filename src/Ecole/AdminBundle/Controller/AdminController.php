<?php

namespace Ecole\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function indexAction()
    {
        return $this->render('EcoleAdminBundle:Admin:index.html.twig');
    }
    
    public function actualiteAction()
    {
        return $this->render('EcoleAdminBundle:Admin:actualite.html.twig');
    }
}
