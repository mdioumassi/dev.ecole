<?php

namespace Ecole\PrimaireBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ecole\AdminBundle\Entity\Page;

class PrimaireController extends Controller
{
    public function indexAction()
    {
        return $this->render('EcolePrimaireBundle:Primaire:index.html.twig',array(
            'actualite'=>$this->getAllActualite(),
            'contenus'=>$this->getContenu()
        ));
    }
    
    public function biblioAction()
    {
        return $this->render('EcolePrimaireBundle:Primaire:biblio.html.twig',array(
            'actualite'=>$this->getAllActualite()
        ));
    }
    
    public function objectifAction()
    {
        return $this->render('EcolePrimaireBundle:Primaire:objectif.html.twig',array(
            'actualite'=>$this->getAllActualite(),
            'contenus'=>$this->getContenu()
        ));
    }
    
    public function programAction()
    {
        return $this->render('EcolePrimaireBundle:Primaire:program.html.twig',array(
            'actualite'=>$this->getAllActualite(),
             'contenus'=>$this->getContenu()
        ));
    }
    
    public function classeAction()
    {
        return $this->render('EcolePrimaireBundle:Primaire:classes.html.twig',array(
            'actualite'=>$this->getAllActualite(),
             'contenus'=>$this->getContenu()
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
