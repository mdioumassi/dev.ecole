<?php

namespace Ecole\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Ecole\AdminBundle\Entity\Actualite;

class SiteController extends Controller
{
    public function indexAction()
    {
        return $this->render('EcoleSiteBundle:Site:index.html.twig',array(
            'actualite'=>$this->getActualite()
        ));
    }
    
    public function actualiteAction()
    {
        return $this->render('EcoleSiteBundle:Site:actualite.html.twig',array(
            'actualite'=>$this->getAllActualite()
        ));
    }
    
    public function statAction()
    {
        return $this->render('EcoleSiteBundle:Site:stat.html.twig',array(
            'actualite'=>$this->getAllActualite()
        ));
    }
    
    public function presentationAction()
    {
        return $this->render('EcoleSiteBundle:Site:presentation.html.twig',array(
            'actualite'=>$this->getAllActualite()
        ));
    }
    
    public function pedagogieAction()
    {
        return $this->render('EcoleSiteBundle:Site:pedagogie.html.twig',array(
            'actualite'=>$this->getAllActualite()
        ));
    }
    
    public function primaireAction()
    {
        return $this->render('EcoleSiteBundle:Site:primaire.html.twig',array(
            'actualite'=>$this->getAllActualite()
        ));
    }
    
    public function collegeAction()
    {
        return $this->render('EcoleSiteBundle:Site:college.html.twig',array(
            'actualite'=>$this->getAllActualite()
        ));
    }
    
    public function lyceeAction()
    {
        return $this->render('EcoleSiteBundle:Site:lycee/lycee.html.twig',array(
            'actualite'=>$this->getAllActualite()
        ));
    }

    
    public function contactAction(Request $request)
    {
        //$request = $this->getRequest();
        $form = $this->createFormBuilder()
            ->add('nom','text',array('max_length'=>200))
            ->add('email','email')
            ->add('objet','text')
            ->add('message','textarea')
            ->getForm();
        $form->handleRequest($request);
          if($form->isValid()){
                $data = $request->request->get($form->getName());
                print_r($data);
                $mailer = $this->get('mailer');
                $message = \Swift_Message::newInstance()
                    ->setSubject($data['objet'])
                    ->setFrom($data['email'])
                    ->setTo('mohamed.dioumassi@gmail.com')
                    ->setBody($data['message']);
                $mailer->send($message);
                return $this->redirect($this->generateUrl('EcoleSiteBundle:Site:contact.html.twig'));
            } 
        
        return $this->render('EcoleSiteBundle:Site:contact.html.twig',array(
            'form'=>$form->createView(),
            'actualite'=>$this->getAllActualite()
        ));
       //
    }
    
     private function getActualite(){
	$em = $this->getDoctrine()->getEntityManager();
	$query = $em->createQuery(
	 'SELECT a FROM EcoleAdminBundle:Actualite a
          WHERE a.active=1
	  ORDER BY a.timestamp DESC
    '
	)->setMaxResults(2);
	 return $query->getResult();
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
