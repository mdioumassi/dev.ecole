<?php

/**
 * compte actions.
 *
 * @package    piwam
 * @subpackage compte
 * @author     Adrien Mogenet
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class compteActions extends sfActions
{
    /**
     * List existing Compte
     *
     * @param  sfWebRequest $request
     */
    public function executeIndex(sfWebRequest $request)
    {
        $this->compte_list = ComptePeer::doSelectEnabled($this->getUser()->getAssociationId());
    }

    /**
     * Show details about a particular Compte
     *
     * @param   sfWebRequest $request
     */
    public function executeShow(sfWebRequest $request)
    {
        $this->compte = ComptePeer::retrieveByPk($request->getParameter('id'));
        $this->forward404Unless($this->compte);

        if ($this->compte->getAssociationId() != $this->getUser()->getAssociationId())
        {
            $this->redirect('@error_credentials');
        }
    }

    /**
     * Display a form to register a new account
     *
     * @param 	sfWebRequest	$request
     */
    public function executeNew(sfWebRequest $request)
    {
        $this->form = new CompteForm(null, array('associationId' => $this->getUser()->getAssociationId()));
        $this->form->setDefault('enregistre_par', $this->getUser()->getUserId());
        $this->form->setDefault('association_id', $this->getUser()->getAssociationId());
    }

    /**
     * Perform the creation ; display the form again if an error occured
     *
     * @param 	sfWebRequest	$request
     */
    public function executeCreate(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod('post'));
        $this->form = new CompteForm(null, array('associationId' => $request->getParameter('compte[association_id]')));
        $this->processForm($request, $this->form);
        $this->setTemplate('new');
    }

    /**
     * Display the form to edit an existing account object
     *
     * @param 	sfWebRequest	$request
     */
    public function executeEdit(sfWebRequest $request)
    {
        $compte = ComptePeer::retrieveByPk($request->getParameter('id'));
        $this->forward404Unless($compte, sprintf('Compte does not exist (%s).', $request->getParameter('id')));

        if ($compte->getAssociationId() != $this->getUser()->getAssociationId())
        {
            $this->redirect('@error_credentials');
        }

        $this->form = new CompteForm($compte, array('associationId' => $compte->getAssociationId()));
        $this->form->setDefault('mis_a_jour_par', $this->getUser()->getUserId());
    }

    /**
     * Perform the update of information
     *
     * @param 	sfWebRequest	$request
     */
    public function executeUpdate(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
        $compte = ComptePeer::retrieveByPk($request->getParameter('id'));
        $this->forward404Unless($compte, sprintf('Object compte does not exist (%s).', $request->getParameter('id')));
        $this->form = new CompteForm($compte, array('associationId' => $compte->getAssociationId()));
        $this->processForm($request, $this->form);
        $this->redirect('compte/index');
    }

    /**
     * Delete a Compte if user has enough credentials
     *
     * @param   sfWebRequest $request
     */
    public function executeDelete(sfWebRequest $request)
    {
        $request->checkCSRFProtection();
        $compte = ComptePeer::retrieveByPk($request->getParameter('id'));
        $this->forward404Unless($compte, sprintf('Object compte does not exist (%s).', $request->getParameter('id')));

        if ($this->compte->getAssociationId() != $this->getUser()->getAssociationId())
        {
            $this->redirect('@error_credentials');
        }

        $compte->delete();
        $this->redirect('compte/index');
    }

    /**
     * Process values got from the form. Redirects to the list of accounts
     * if everything went fine
     *
     * @param   sfWebRequest    $request
     * @param   sfForm          $form
     */
    protected function processForm(sfWebRequest $request, sfForm $form)
    {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

        if ($form->isValid())
        {
            $compte = $form->save();
            $this->redirect('compte/index');
        }
    }
}
