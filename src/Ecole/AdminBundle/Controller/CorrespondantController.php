<?php

namespace Ecole\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Ecole\AdminBundle\Entity\Correspondant;
use Ecole\AdminBundle\Form\CorrespondantType;

/**
 * Correspondant controller.
 *
 */
class CorrespondantController extends Controller
{

    /**
     * Lists all Correspondant entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EcoleAdminBundle:Correspondant')->findAll();

        return $this->render('EcoleAdminBundle:Correspondant:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Correspondant entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Correspondant();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('correspondant_show', array('id' => $entity->getId())));
        }

        return $this->render('EcoleAdminBundle:Correspondant:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Correspondant entity.
     *
     * @param Correspondant $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Correspondant $entity)
    {
        $form = $this->createForm(new CorrespondantType(), $entity, array(
            'action' => $this->generateUrl('correspondant_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Correspondant entity.
     *
     */
    public function newAction()
    {
        $entity = new Correspondant();
        $form   = $this->createCreateForm($entity);

        return $this->render('EcoleAdminBundle:Correspondant:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Correspondant entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EcoleAdminBundle:Correspondant')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Correspondant entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('EcoleAdminBundle:Correspondant:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Correspondant entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EcoleAdminBundle:Correspondant')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Correspondant entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('EcoleAdminBundle:Correspondant:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Correspondant entity.
    *
    * @param Correspondant $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Correspondant $entity)
    {
        $form = $this->createForm(new CorrespondantType(), $entity, array(
            'action' => $this->generateUrl('correspondant_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Correspondant entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EcoleAdminBundle:Correspondant')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Correspondant entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('correspondant_edit', array('id' => $id)));
        }

        return $this->render('EcoleAdminBundle:Correspondant:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Correspondant entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EcoleAdminBundle:Correspondant')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Correspondant entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('correspondant'));
    }

    /**
     * Creates a form to delete a Correspondant entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('correspondant_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
