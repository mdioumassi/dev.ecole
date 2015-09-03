<?php

/**
 * cotisation actions.
 *
 * @package    piwam
 * @subpackage cotisation
 * @author     Adrien Mogenet
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class cotisationActions extends sfActions
{
    /**
     * r20 : provides to the view the number of cotisation types that
     * 		 have been set
     *
     * @param 	sfWebRequest	$request
     */
    public function executeIndex(sfWebRequest $request)
    {
        $this->cotisation_list = CotisationPeer::doSelectJoinMembreId($this->getUser()->getAssociationId());
        $this->typesExist = CotisationTypePeer::doesOneTypeExist($this->getUser()->getAssociationId());
    }

    /**
     * Show details about a particular Cotisation
     *
     * @param   sfWebRequest $request
     */
    public function executeShow(sfWebRequest $request)
    {
        $this->cotisation = CotisationPeer::retrieveByPk($request->getParameter('id'));

        if ($this->cotisation->getCotisationType()->getAssociationId() == $this->getUser()->getAssociationId())
        {
            $this->forward404Unless($this->cotisation);
        }
        else
        {
            $this->redirect('@error_credentials');
        }
    }

    /**
     * Display the form to register a new cotisation
     *
     * @param 	sfWebRequest	$request
     */
    public function executeNew(sfWebRequest $request)
    {
        $this->form = new CotisationForm();
        $this->form->setDefault('enregistre_par', $this->getUser()->getUserId());
        $this->form->setDefault('association_id', $this->getUser()->getAssociationId());
    }

    /**
     * Check the creation of a new cotisation.
     *
     * @param 	sfWebRequest	$request
     */
    public function executeCreate(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod('post'));
        $this->form = new CotisationForm();
        $this->form->setDefault('enregistre_par', $this->getUser()->getUserId());
        $this->form->setDefault('association_id', $this->getUser()->getAssociationId());
        $this->processForm($request, $this->form);
        $this->setTemplate('new');
    }

    /**
     * Edit an existing Cotisation after checking that user has required
     * credentials
     *
     * @param   sfWebRequest $request
     */
    public function executeEdit(sfWebRequest $request)
    {
        $this->forward404Unless($cotisation = CotisationPeer::retrieveByPk($request->getParameter('id')), sprintf('Object cotisation does not exist (%s).', $request->getParameter('id')));

        if ($cotisation->getCotisationType()->getAssociationId() != $this->getUser()->getAssociationId())
        {
            $this->redirect('@error_credentials');
        }

        $this->form = new CotisationForm($cotisation);
        $this->form->setDefault('mis_a_jour_par', $this->getUser()->getUserId());
    }

    /**
     * Update a cotisation entry with new values
     *
     * @param 	sfWebRequest	$request
     */
    public function executeUpdate(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
        $this->forward404Unless($cotisation = CotisationPeer::retrieveByPk($request->getParameter('id')), sprintf('Object cotisation does not exist (%s).', $request->getParameter('id')));
        $this->form = new CotisationForm($cotisation);
        $this->form->setDefault('mis_a_jour_par', $this->getUser()->getUserId());
        $this->processForm($request, $this->form);
        $this->setTemplate('edit');
    }

    /**
     * Delete a cotisation
     *
     * @param   sfWebRequest $request
     */
    public function executeDelete(sfWebRequest $request)
    {
        $request->checkCSRFProtection();
        $this->forward404Unless($cotisation = CotisationPeer::retrieveByPk($request->getParameter('id')), sprintf('Object cotisation does not exist (%s).', $request->getParameter('id')));

        if ($cotisation->getCotisationType()->getAssociationId() != $this->getUser()->getAssociationId())
        {
            $this->redirect('@error_credentials');
        }

        $cotisation->delete();
        $this->redirect('cotisation/index');
    }

    /*
     * Redirect again to the form if we are registering new Cotisation (in order
     * to record several Cotisation in "one time" without going back and then
     * coming back to the form.
     *
     * Redirect to index action if we are editing an existing Cotisation
     */
    protected function processForm(sfWebRequest $request, sfForm $form)
    {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid())
        {
            $cotisation = $form->save();
            $this->getUser()->setFlash('notice', 'Cotisation enregistrée avec succès.');
            $data = $request->getParameter('cotisation');

            if (isset($data['id']))
            {
                $this->redirect('cotisation/index');
            }
            else
            {
                $this->redirect('cotisation/new');
            }
        }
    }
}