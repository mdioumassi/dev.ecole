<?php

namespace Ecole\LyceeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LyceeController extends Controller
{
    public function indexAction()
    {
        return $this->render('EcoleLyceeBundle:Lycee:index.html.twig');
    }
    
    public function biblioAction()
    {
        return $this->render('EcoleLyceeBundle:Lycee:biblio.html.twig');
    }
    
    public function inscAction()
    {
        return $this->render('EcoleLyceeBundle:Lycee:inscription.html.twig');
    }
    
    public function classeAction()
    {
        return $this->render('EcoleLyceeBundle:Lycee:classes.html.twig');
    }
}
