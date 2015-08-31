<?php
/**
 * Compare 2 Depense of Recette according to the date
 *
 * @param 	mixed	$entry1
 * @param 	mixed	$entry2
 * @return 	integer
 */
function compare_money_entries($entry1, $entry2)
{
    if ($entry1->getDate() <= $entry2->getDate())
    {
        return -1;
    }
    else
    {
        return 1;
    }
}

/**
 * activite actions.
 *
 * @package    piwam
 * @subpackage activite
 * @author     Adrien Mogenet
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class activiteActions extends sfActions
{
    /**
     * List existing Activite
     *
     * @param  sfWebRequest $request
     */
    public function executeIndex(sfWebRequest $request)
    {
        $this->activite_list = ActivitePeer::doSelectEnabled($this->getUser()->getAssociationId());
    }

    /**
     * List the detailed Recettes and Depenses in a merged array.
     *
     * @param  sfWebRequest    $request
     */
    public function executeShow(sfWebRequest $request)
    {
        $activiteId	      = $request->getParameter('id');
        $depenses 	      = DepensePeer::doSelectForActiviteId($activiteId);
        $recettes 	      = RecettePeer::doSelectForActiviteId($activiteId);
        $data		      = array_merge($depenses, $recettes);
        $isSortOk	      = usort($data, 'compare_money_entries');
        $this->data       = $data;
        $this->activite   = ActivitePeer::retrieveByPk($activiteId);
        $this->creances   = RecettePeer::getAmountOfCreancesForActivite($activiteId);
        $this->dettes     = DepensePeer::getAmountOfDettesForActivite($activiteId);
        $this->totalPrevu = $this->creances - $this->dettes;

        if ($this->activite->getAssociationId() == $this->getUser()->getAssociationId())
        {
            $this->forward404Unless($this->activite);
        }
        else
        {
            $this->redirect('@error_credentials');
        }
    }

    /**
     * Display the form to create a new Activity and set the default values.
     *
     * @param 	sfWebRequest $request
     */
    public function executeNew(sfWebRequest $request)
    {
        $this->form = new ActiviteForm();
        $this->form->setDefault('enregistre_par', $this->getUser()->getUserId());
        $this->form->setDefault('association_id', $this->getUser()->getAssociationId());
    }

    /**
     * Create the new Activity after performing operations. Form will be
     * displayed again if required.
     *
     * @param 	sfWebRequest	$request
     */
    public function executeCreate(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod('post'));
        $this->form = new ActiviteForm();
        $this->processForm($request, $this->form);
        $this->setTemplate('new');
    }

    /**
     * Display a form to edit an existing Activite, if user has required
     * credentials
     *
     * @param  sfWebRequest $request
     */
    public function executeEdit(sfWebRequest $request)
    {
        $this->forward404Unless($activite = ActivitePeer::retrieveByPk($request->getParameter('id')), sprintf('L\'activite n\'existe pas (%s).', $request->getParameter('id')));

        if ($activite->getAssociationId() != $this->getUser()->getAssociationId())
        {
            $this->redirect('@error_credentials');
        }

        $this->form = new ActiviteForm($activite);
        $this->form->setDefault('mis_a_jour_par', $this->getUser()->getUserId());
    }

    /**
     * Perform update of fields about an Activity
     *
     * @param 	sfWebRequest	$request
     */
    public function executeUpdate(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
        $this->forward404Unless($activite = ActivitePeer::retrieveByPk($request->getParameter('id')), sprintf('L\'activité (%s) n\'existe pas.', $request->getParameter('id')));
        $this->form = new ActiviteForm($activite);
        $this->processForm($request, $this->form);
        $this->setTemplate('edit');
    }

    /**
     * Delete existing Activite if user has enough Credentials
     *
     * @param  sfWebRequest $request
     */
    public function executeDelete(sfWebRequest $request)
    {
        $request->checkCSRFProtection();
        $this->forward404Unless($activite = ActivitePeer::retrieveByPk($request->getParameter('id')), sprintf('Object activite does not exist (%s).', $request->getParameter('id')));

        if ($activite->getAssociationId() != $this->getUser()->getAssociationId())
        {
            $this->redirect('@error_credentials');
        }

        $activite->delete();
        $this->redirect('activite/index');
    }

    /*
     * Process the different operations with data get from the form. Redirects
     * to main screen if everything is OK
     */
    protected function processForm(sfWebRequest $request, sfForm $form)
    {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid())
        {
            $activite = $form->save();
            $this->redirect('activite/index');
        }
    }
}
