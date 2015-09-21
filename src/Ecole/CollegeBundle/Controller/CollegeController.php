<?php

namespace Ecole\CollegeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ecole\AdminBundle\Entity\Page;

class CollegeController extends Controller
{
    public function indexAction()
    {
        return $this->render('EcoleCollegeBundle:College:index.html.twig',array(
            'actualite'=>$this->getAllActualite(),
            'contenus'=>$this->getContenu()
        ));
    }
    
    public function biblioAction()
    {
        return $this->render('EcoleCollegeBundle:College:biblio.html.twig',array(
            'actualite'=>$this->getAllActualite()
        ));
    }
    
    public function objectifAction()
    {
        return $this->render('EcoleCollegeBundle:College:objectif.html.twig',array(
            'actualite'=>$this->getAllActualite(),
            'contenus'=>$this->getContenu()
        ));
    }
    
    public function programAction()
    {
        return $this->render('EcoleCollegeBundle:College:program.html.twig',array(
            'actualite'=>$this->getAllActualite(),
             'contenus'=>$this->getContenu()
        ));
    }
    
    public function classeAction()
    {
        return $this->render('EcoleCollegeBundle:College:classes.html.twig',array(
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
