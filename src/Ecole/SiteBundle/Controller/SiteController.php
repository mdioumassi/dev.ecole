<?php

namespace Ecole\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Ecole\AdminBundle\Entity\Actualite;
use Ecole\AdminBundle\Entity\Page;
use Ecole\AdminBundle\Entity\Eleve;
use Ecole\AdminBundle\Form\EleveType;

class SiteController extends Controller {

  public function indexAction() {
    return $this->render('EcoleSiteBundle:Site:index.html.twig', array(
                'actualite' => $this->getActualite()
    ));
  }

  public function preinscripionAction(Request $request) {
        $entity = new Eleve();
        $form = $this->createCreateForm($entity);
    return $this->render('EcoleSiteBundle:Site/Inscription:preinscription.html.twig', array(
                'actualite' => $this->getActualite(),
                'form' => $form->createView(),
    ));
  }

      /**
     * Creates a new Actualite entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Eleve();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
        }
    return $this->render('EcoleSiteBundle:Site:index.html.twig', array(
                'actualite' => $this->getActualite(),

    ));
    }
  public function actualiteAction() {
    return $this->render('EcoleSiteBundle:Site:actualite.html.twig', array(
                'actualite' => $this->getAllActualite()
    ));
  }

  public function statAction() {
    return $this->render('EcoleSiteBundle:Site:stat.html.twig', array(
                'actualite' => $this->getAllActualite()
    ));
  }

  public function presentationAction() {
    $em = $this->getDoctrine()->getManager();

    $presentation = $em->getRepository('EcoleAdminBundle:Page')->findAll();

    return $this->render('EcoleSiteBundle:Site:presentation.html.twig', array(
                'actualite' => $this->getAllActualite(),
                'contenus' => $this->getContenu()
    ));
  }

  public function pedagogieAction() {
    return $this->render('EcoleSiteBundle:Site:pedagogie.html.twig', array(
                'actualite' => $this->getAllActualite(),
                'contenus' => $this->getContenu()
    ));
  }

  public function surveilleAction() {
    return $this->render('EcoleSiteBundle:Site/Etude:surveille.html.twig', array(
                'actualite' => $this->getAllActualite(),
                'contenus' => $this->getContenu()
    ));
  }

  /**
   * Creates a form to create a Actualite entity.
   *
   * @param Eleve $entity The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createCreateForm(Eleve $entity) {
    $form = $this->createForm(new EleveType(), $entity, array(
        'action' => $this->generateUrl('eleve_create'),
        'method' => 'POST',
    ));

    $form->add('submit', 'submit', array('label' => 'Valider'));

    return $form;
  }

  public function contactAction(Request $request) {
    //$request = $this->getRequest();
    $form = $this->createFormBuilder()
            ->add('nom', 'text', array('max_length' => 200))
            ->add('email', 'email')
            ->add('objet', 'text')
            ->add('message', 'textarea')
            ->getForm();
    $form->handleRequest($request);
    if ($form->isValid()) {
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

    return $this->render('EcoleSiteBundle:Site:contact.html.twig', array(
                'form' => $form->createView(),
                'actualite' => $this->getAllActualite()
    ));
    //
  }

  private function getContenu() {
    $em = $this->getDoctrine()->getManager();
    return $em->getRepository('EcoleAdminBundle:Page')->findAll();
  }

  private function getActualite() {
    $em = $this->getDoctrine()->getEntityManager();
    $query = $em->createQuery(
                    'SELECT a FROM EcoleAdminBundle:Actualite a
          WHERE a.active=1
	  ORDER BY a.timestamp DESC
    '
            )->setMaxResults(2);
    return $query->getResult();
  }

  private function getAllActualite() {
    $em = $this->getDoctrine()->getEntityManager();
    $query = $em->createQuery(
            'SELECT a FROM EcoleAdminBundle:Actualite a
          WHERE a.active=1
	  ORDER BY a.timestamp DESC
    '
    ); //->setMaxResults(2);
    return $query->getResult();
  }

}
