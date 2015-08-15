<?php

namespace Ecole\AdminBundle\Controller;
use Ecole\AdminBundle\Entity\Actualite;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function indexAction()
    {
         return $this->render('EcoleAdminBundle:Admin:index.html.twig',array(
            'actualite'=>$this->getActualite()
        ));
    }
    
    private function getActualite(){
	$em = $this->getDoctrine()->getManager();
	$query = $em->createQuery(
	 'SELECT a FROM EcoleAdminBundle:Actualite a
	  ORDER BY a.timestamp DESC
    '
	);//->setMaxResults();
	 return $query->getResult();
    }
}
