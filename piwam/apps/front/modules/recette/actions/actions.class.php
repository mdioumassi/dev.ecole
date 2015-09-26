<?php

/**
 * recette actions.
 *
 * @package    piwam
 * @subpackage recette
 * @author     Adrien Mogenet
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class recetteActions extends sfActions
{
    /**
     * Export the list of Depense within a file
     *
     * @param 	sfWebRequest	$request
     * @since	r39
     */
    public function executeExport(sfWebRequest $request)
    {
        sfContext::getInstance()->getConfiguration()->loadHelpers('Number');
        $csv = new FileExporter('liste-recettes.csv');
        $recettes = RecettePeer::doSelectForAssociation($this->getUser()->getAssociationId());

        echo $csv->addLineCSV(array(
              'Libellé',
              'Montant (euros)',
              'Compte',
              'Activité',
              'Date',
                ));

        foreach ($recettes as $recette)
        {
            echo $csv->addLineCSV(array(
            $recette->getLibelle(),
            format_currency($recette->getMontant()),
            $recette->getCompte(),
            $recette->getActivite(),
            $recette->getDate(),
            ));
        }
        $csv->exportContentAsFile();
    }

    /**
     * List Recettes
     *
     * @param  sfWebRequest $request
     */
    public function executeIndex(sfWebRequest $request)
    {
        $page = $request->getParameter('page', 1);
        $this->recettesPager = RecettePeer::doSelectPagerForAssociation($this->getUser()->getAssociationId(), $page);
    }

    /**
     * Show details about a particular Recette
     *
     * @param  sfWebRequest $request
     */
    public function executeShow(sfWebRequest $request)
    {
        $this->recette = RecettePeer::retrieveByPk($request->getParameter('id'));

        if ($this->recette->getAssociationId() == $this->getUser()->getAssociationId())
        {
            $this->forward404Unless($this->recette);
        }
        else
        {
            $this->redirect('@error_credentials');
        }
    }

    /**
     * Display the form to record a new Recette
     *
     * @param  sfWebRequest $request
     */
    public function executeNew(sfWebRequest $request)
    {
        $this->form = new RecetteForm();
        $this->form->setDefault('mis_a_jour_par', $this->getUser()->getUserId());
    }

    /**
     * Display form if error or record the new Recette
     *
     * @param  sfWebRequest $request
     */
    public function executeCreate(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod('post'));
        $this->form = new RecetteForm();
        $this->form->setDefault('mis_a_jour_par', $this->getUser()->getUserId());
        $this->processForm($request, $this->form);
        $this->setTemplate('new');
    }

    /**
     * Display edit form
     *
     * @param   sfWebRequest    $request
     */
    public function executeEdit(sfWebRequest $request)
    {
        $this->forward404Unless($recette = RecettePeer::retrieveByPk($request->getParameter('id')), sprintf('Object recette does not exist (%s).', $request->getParameter('id')));

        if ($recette->getAssociationId() != $this->getUser()->getAssociationId())
        {
            $this->redirect('@error_credentials');
        }

        $this->form = new RecetteForm($recette);
        $this->form->setDefault('mis_a_jour_par', $this->getUser()->getUserId());
    }

    /**
     * Performs update
     *
     * @param   sfWebRequest    $request
     */
    public function executeUpdate(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
        $this->forward404Unless($recette = RecettePeer::retrieveByPk($request->getParameter('id')), sprintf('Object recette does not exist (%s).', $request->getParameter('id')));
        $this->form = new RecetteForm($recette);
        $this->form->setDefault('mis_a_jour_par', $this->getUser()->getUserId());
        $this->processForm($request, $this->form);
        $this->setTemplate('edit');
    }

    /**
     * Delete an existing Recette. Check if user has required credentials
     *
     * @param sfWebRequest $request
     */
    public function executeDelete(sfWebRequest $request)
    {
        $request->checkCSRFProtection();
        $this->forward404Unless($recette = RecettePeer::retrieveByPk($request->getParameter('id')), sprintf('Object recette does not exist (%s).', $request->getParameter('id')));

        if ($recette->getAssociationId() != $this->getUser()->getAssociationId())
        {
            $this->redirect('@error_credentials');
        }

        $recette->delete();
        $this->redirect('recette/index');
    }

    /**
     * Process values given by the $form
     *
     * @param   sfWebRequest    $request
     * @param   sfForm          $form
     */
    protected function processForm(sfWebRequest $request, sfForm $form)
    {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

        if ($form->isValid())
        {
            $recette = $form->save();
            $this->redirect('recette/index');
        }
    }
}
