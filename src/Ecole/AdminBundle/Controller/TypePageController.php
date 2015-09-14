<?php

namespace Ecole\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Ecole\AdminBundle\Entity\TypePage;
use Ecole\AdminBundle\Form\TypePageType;

/**
 * TypePage controller.
 *
 */
class TypePageController extends Controller
{

    /**
     * Lists all TypePage entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EcoleAdminBundle:TypePage')->findAll();

        return $this->render('EcoleAdminBundle:TypePage:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new TypePage entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new TypePage();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('typepage_show', array('id' => $entity->getId())));
        }

        return $this->render('EcoleAdminBundle:TypePage:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a TypePage entity.
     *
     * @param TypePage $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TypePage $entity)
    {
        $form = $this->createForm(new TypePageType(), $entity, array(
            'action' => $this->generateUrl('typepage_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new TypePage entity.
     *
     */
    public function newAction()
    {
        $entity = new TypePage();
        $form   = $this->createCreateForm($entity);

        return $this->render('EcoleAdminBundle:TypePage:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TypePage entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EcoleAdminBundle:TypePage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TypePage entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('EcoleAdminBundle:TypePage:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TypePage entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EcoleAdminBundle:TypePage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TypePage entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('EcoleAdminBundle:TypePage:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a TypePage entity.
    *
    * @param TypePage $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TypePage $entity)
    {
        $form = $this->createForm(new TypePageType(), $entity, array(
            'action' => $this->generateUrl('typepage_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing TypePage entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EcoleAdminBundle:TypePage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TypePage entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('typepage_edit', array('id' => $id)));
        }

        return $this->render('EcoleAdminBundle:TypePage:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a TypePage entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EcoleAdminBundle:TypePage')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TypePage entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('typepage'));
    }

    /**
     * Creates a form to delete a TypePage entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('typepage_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
