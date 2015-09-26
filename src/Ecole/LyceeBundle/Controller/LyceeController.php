<?php

namespace Ecole\LyceeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ecole\AdminBundle\Entity\Page;

class LyceeController extends Controller
{
    public function indexAction()
    {
        return $this->render('EcoleLyceeBundle:Lycee:index.html.twig',array(
            'actualite'=>$this->getAllActualite(),
            'contenus'=>$this->getContenu()
        ));
    }
    
    public function biblioAction()
    {
        return $this->render('EcoleLyceeBundle:Lycee:biblio.html.twig',array(
            'actualite'=>$this->getAllActualite()
        ));
    }
    
    public function objectifAction()
    {
        return $this->render('EcoleLyceeBundle:Lycee:objectif.html.twig',array(
            'actualite'=>$this->getAllActualite(),
            'contenus'=>$this->getContenu()
        ));
    }
    
     public function programAction()
    {
        return $this->render('EcoleLyceeBundle:Lycee:program.html.twig',array(
            'actualite'=>$this->getAllActualite(),
             'contenus'=>$this->getContenu()
        ));
    }
    
    public function classeAction()
    {
        return $this->render('EcoleLyceeBundle:Lycee:classes.html.twig',array(
            'actualite'=>$this->getAllActualite()
        ));
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
    
     private function getContenu(){
        $em = $this->getDoctrine()->getManager();
        return $em->getRepository('EcoleAdminBundle:Page')->findAll();
    }
}
