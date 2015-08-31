<?php

/**
 * depense actions.
 *
 * @package    piwam
 * @subpackage depense
 * @author     Adrien Mogenet
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class depenseActions extends sfActions
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
        $csv = new FileExporter('liste-depenses.csv');
        $depenses = DepensePeer::doSelectForAssociation($this->getUser()->getAssociationId());

        echo $csv->addLineCSV(array(
              'Libellé',
              'Montant (euros)',
              'Compte',
              'Activité',
              'Date',
                ));

        foreach ($depenses as $depense)
        {
            echo $csv->addLineCSV(array(
            $depense->getLibelle(),
            format_currency($depense->getMontant()),
            $depense->getCompte(),
            $depense->getActivite(),
            $depense->getDate(),
            ));
        }
        $csv->exportContentAsFile();
    }

    /**
     * List Depenses of current association
     *
     * @param 	sfWebRequest     $request
     */
    public function executeIndex(sfWebRequest $request)
    {
        $this->depensesPager = DepensePeer::doSelectPagerForAssociation($this->getUser()->getAssociationId(),
        $request->getParameter('page', 1));
    }

    /**
     * View details of a particular Depense
     *
     * @param 	sfWebRequest     $request
     */
    public function executeShow(sfWebRequest $request)
    {
        $this->depense = DepensePeer::retrieveByPk($request->getParameter('id'));

        if ($this->depense->getAssociationId() == $this->getUser()->getAssociationId())
        {
            $this->forward404Unless($this->depense);
        }
        else
        {
            $this->redirect('@error_credentials');
        }
    }

    /**
     * Display the form to register a new entry
     *
     * @param   sfWebRequest    $request
     */
    public function executeNew(sfWebRequest $request)
    {
        $this->form = new DepenseForm();
        $this->form->setDefault('mis_a_jour_par', $this->getUser()->getUserId());

    }

    /**
     * Perform creation
     *
     * @param   sfWebRequest    $request
     */
    public function executeCreate(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod('post'));
        $this->form = new DepenseForm();
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
        $this->forward404Unless($depense = DepensePeer::retrieveByPk($request->getParameter('id')), sprintf('Object depense does not exist (%s).', $request->getParameter('id')));

        if ($depense->getAssociationId() != $this->getUser()->getAssociationId())
        {
            $this->redirect('@error_credentials');
        }

        $this->form = new DepenseForm($depense);
        $this->form->setDefault('mis_a_jour_par', $this->getUser()->getUserId());
    }

    /**
     * Perfoms update.
     *
     * @param   sfWebRequest    $request
     */
    public function executeUpdate(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
        $this->forward404Unless($depense = DepensePeer::retrieveByPk($request->getParameter('id')), sprintf('Object depense does not exist (%s).', $request->getParameter('id')));
        $this->form = new DepenseForm($depense);
        $this->form->setDefault('mis_a_jour_par', $this->getUser()->getUserId());
        $this->processForm($request, $this->form);
        $this->setTemplate('edit');
    }

    /**
     * Delete an existing Depense if user has required credentials
     *
     * @param  sfWebRequest $request
     */
    public function executeDelete(sfWebRequest $request)
    {
        $request->checkCSRFProtection();
        $this->forward404Unless($depense = DepensePeer::retrieveByPk($request->getParameter('id')), sprintf('Object depense does not exist (%s).', $request->getParameter('id')));
        $depense->delete();
        $this->redirect('depense/index');

        if ($depense->getAssociationId() != $this->getUser()->getAssociationId())
        {
            $this->forward('error', 'credentials');
        }
    }

    /**
     * Process the values given by the form. Redirects to index if success
     *
     * @param   sfWebRequest    $request
     * @param   sfForm          $form
     */
    protected function processForm(sfWebRequest $request, sfForm $form)
    {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

        if ($form->isValid())
        {
            $depense = $form->save();
            $this->redirect('depense/index');
        }
    }
}
