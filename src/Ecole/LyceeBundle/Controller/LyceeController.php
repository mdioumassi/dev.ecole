<?php

namespace Ecole\LyceeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LyceeController extends Controller
{
    public function indexAction()
    {
        return $this->render('EcoleLyceeBundle:Lycee:index.html.twig',array(
            'actualite'=>$this->getAllActualite()
        ));
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
    private function getAllActualite(){
	$em = $this->getDoctrine()->getEntityManager();
	$query = $em->createQuery(
	 'SELECT a FROM EcoleAdminBundle:Actualite a
          WHERE a.active=1
	  ORDER BY a.timestamp DESC
    '
	);//->setMaxResults(2);
	 return $query->getResult();
    }
}
