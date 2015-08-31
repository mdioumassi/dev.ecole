<?php

/**
 * membre actions.
 *
 * @package    piwam
 * @subpackage membre
 * @author     Adrien Mogenet
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class membreActions extends sfActions
{
    /**
     * Lists members who belongs to the current association. By default we sort
     * the list by pseudo, and if another column is specified we use it.
     *
     * r14 : pagination system
     *
     * @param 	sfWebRequest	$request
     * @since	r1
     */
    public function executeIndex(sfWebRequest $request)
    {
        if (! $this->getUser()->hasCredential('list_membre'))
        {
            $this->redirect('membre/show?id=' . $this->getUser()->getUserId());
        }

        $this->orderByColumn = $request->getParameter('orderby', MembrePeer::NOM);
        $this->membresPager = MembrePeer::doSelectOrderBy($this->getUser()->getAssociationId(),
                                                            $request->getParameter('page', 1),
                                                            $this->orderByColumn
                                                          );
        $this->pending = MembrePeer::doSelectPending($this->getUser()->getAssociationId());
        $ajaxUrl = $this->getController()->genUrl('@ajax_search_members');
        $this->searchForm = new SearchUserForm(null, array('associationId' => $this->getUser()->getAssociationId(),
                                                           'ajaxUrl'       => $ajaxUrl));
    }

    /**
     * Display images
     *
     * @param   sfWebRequest $request
     * @since   r139
     */
    public function executeFaces(sfWebRequest $request)
    {
        $this->membres = MembrePeer::doSelectForAssociation($associationId = $this->getUser()->getAssociationId());
    }

    /**
     * Perform a research and return results
     *
     * @param   sfWebRequest    $request
     * @since   r211
     */
    public function executeSearch(sfWebRequest $request)
    {
        $params = $request->getParameter('search');
        $magicField  = $request->getParameter('autocomplete_search[magic]');
        $params['magic'] = $magicField;

        if (strlen($params['magic']) > 0)
        {
            $this->membres = MembrePeer::doSearch($params);

            if (count($this->membres) === 1)
            {
                $this->redirect('membre/show?id=' . $this->membres[0]->getId());
            }
        }
        else
        {
            $this->membres = array();
        }

        $ajaxUrl = $this->getController()->genUrl('@ajax_search_members');
        $this->searchForm = new SearchUserForm(null, array('associationId' => $this->getUser()->getAssociationId(),
                                                           'ajaxUrl'       => $ajaxUrl));
    }

    /**
     * Provide all information about the member to the view. We check if we have
     * the right to see profile of someone else
     *
     * @param 	sfWebRequest	$request
     */
    public function executeShow(sfWebRequest $request)
    {
        $membre_id = $request->getParameter('id');
        $profile = MembrePeer::retrieveByPk($membre_id);

        if ($this->isAllowedToManageProfile($profile, 'show_membre'))
        {
            $this->cotisations = CotisationPeer::doSelectForUser($membre_id);
            $this->credentials = AclCredentialPeer::doSelectForMembreId($membre_id);
            $this->forward404Unless($profile);
            $this->membre = $profile;
        }
        else
        {
            $this->redirect('@error_credentials');
        }
    }

    /**
     * Export the list of Membre within a file
     *
     * @param   sfWebRequest    $request
     * @since   r19
     */
    public function executeExport(sfWebRequest $request)
    {
        $csv = new FileExporter('liste-membres.csv');
        $membres = MembrePeer::doSelectForAssociation($this->getUser()->getAssociationId());

        echo $csv->addLineCSV(array(
            'Prénom',
            'Nom',
            'Pseudo',
            'Email',
            'Tel (fixe)',
            'Tel (mobile)',
            'Rue',
            'CP',
            'Ville',
            'Pays',
            'Statut',
            'Date d\'inscription',
        ));

        foreach ($membres as $membre)
        {
            echo $csv->addLineCSV(array(
            $membre->getPrenom(),
            $membre->getNom(),
            $membre->getPseudo(),
            $membre->getEmail(),
            $membre->getTelFixe(),
            $membre->getTelPortable(),
            $membre->getRue(),
            $membre->getCp(),
            $membre->getVille(),
            $membre->getPays(),
            $membre->getStatut(),
            $membre->getDateInscription(),
            ));
        }
        $csv->exportContentAsFile();
    }

    /**
     * Perform the deletion
     *
     * @param   sfWebRequest    $request
     */
    public function executeDelete(sfWebRequest $request)
    {
        $request->checkCSRFProtection();
        $this->forward404Unless($membre = MembrePeer::retrieveByPk($request->getParameter('id')), sprintf('Le membre n\'existe pas (%s).', $request->getParameter('id')));

        if ($membre->getAssociationId() != $this->getUser()->getAssociationId())
        {
            $this->redirect('@error_credentials');
        }

        $membre->delete();
        $this->redirect('membre/index');
    }

    /**
     * Called method to display list of Membre within an autocompleted
     * form field.
     *
     * @param   sfWebRequest    $request
     * @since   r15
     * @return  JSON response
     */
    public function executeAjaxlist(sfWebRequest $request)
    {
        $this->getResponse()->setContentType('application/json');
        $membres = MembrePeer::retrieveForSelect($request->getParameter('q'),
                                                 $request->getParameter('limit'),
                                                 $request->getParameter('association_id'));

       if (count($membres) === 0)
       {
         $membres = null;
       }

        return $this->renderText(json_encode($membres));
    }


    /**
     * Geo-localize members within a map thanks to Google MAP
     * API.
     *
     * @param   sfWebRequest    $request
     * @since   r17
     */
    public function executeMap(sfWebRequest $request)
    {
        $associationId = $this->getUser()->getAssociationId();
        $GMapKey = Configurator::get('googlemap_key', $associationId);
        $map = new PhoogleMap();
        $map->setApiKey($GMapKey);
        $map->zoomLevel = 12;
        $map->setWidth(600);
        $map->setHeight(400);
        $membres = MembrePeer::doSelectForAssociation($associationId);

        foreach ($membres as $membre)
        {
            if (strlen($membre->getVille()) > 0)
            {
                $map->addAddress($membre->getCompleteAddress(), $membre->getInfoForGmap());
            }
        }

        $this->GMapKey = $GMapKey;
        $this->map = $map;
    }

    /**
     * Allows the user to manager ACL for each Membre. Once the form is submit,
     * the existing credentials are deleted and we created new ones.
     * The AclCredentialForm is also put on membre/edit view. If we reach the
     * form through this action, this is because we are registering a NEW user
     *
     * @param   sfWebRequest    $request
     * @since   r60
     */
    public function executeAcl(sfWebRequest $request)
    {
        $this->form = new AclCredentialForm();

        if ($request->isMethod('post'))
        {
            $this->form->bind($request->getParameter('rights', array()));
            if ($this->form->isValid())
            {
                $values = $request->getParameter('rights', array());
                $membre = MembrePeer::retrieveByPk($values['user_id']);
                $membre->resetAcl();

                // Browse the list of rights... first we get the 'modules' level

                if (isset($values['rights']))
                {
                    foreach ($values['rights'] as $mid => $acls)
                    {
                        // Then, foreach module, we get the list of enabled
                        // checkboxes. "$state" is normally always set to "ON"
                        // because we only have checked elements

                        foreach ($acls as $code => $state)
                        {
                            $membre->addCredential($code);
                        }
                    }
                }
                $this->redirect('membre/index');
            }
        }
        else
        {
            $this->user_id  = $request->getParameter('id');
            $membre  = MembrePeer::retrieveByPk($this->user_id);

            if (($membre->getAssociationId() != $this->getUser()->getAssociationId()) ||
                ($this->getUser()->hasCredential('edit_acl') == false))
            {
                $this->redirect('@error_credentials');
            }

            $this->form->setUserId($this->user_id);
            $this->form->automaticCheck();
        }
    }



    /* -------------------------------------------------------------------------
     *
     * Classic user management (creation, edition of existing users)
     * for an existing association
     *
     * ---------------------------------------------------------------------- */

    /**
     * Registration of a new Membre
     *
     * @param   sfWebRequest    $request
     */
    public function executeNew(sfWebRequest $request)
    {
        $this->form = new MembreForm(null, array('associationId' => $this->getUser()->getAssociationId(),
                                                 'context'       => $this->getContext()));
        $this->form->setDefault('mis_a_jour_par', $this->getUser()->getUserId());
    }

    /**
     * Perform the creation of the Membre object in database
     *
     * @param   sfWebRequest    $request
     */
    public function executeCreate(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod('post'));
        $this->form = new MembreForm(null, array('associationId' => $request->getParameter('membre[association_id]'),
                                                 'context'       => $this->getContext()));
        $this->processForm($request, $this->form);
        $this->setTemplate('new');
    }

    /**
     * Manages 2 differents forms :
     *  - profile editing
     *  - rights management
     *
     * @param $request
     * @return unknown_type
     */
    public function executeEdit(sfWebRequest $request)
    {
        $associationId = $this->getUser()->getAssociationId();
        $this->user_id = $request->getParameter('id');
        $this->forward404Unless($membre = MembrePeer::retrieveByPk($this->user_id));

        if (false === $this->isAllowedToManageProfile($membre, 'edit_membre'))
        {
            $this->redirect('@error_credentials');
        }

        $this->form = new MembreForm($membre, array('associationId' => $membre->getAssociationId(),
                                                    'context'       => $this->getContext()));
        $this->aclForm  = new AclCredentialForm();
        $this->canEditRight = $this->getUser()->hasCredential('edit_acl');
        $this->form->setDefault('mis_a_jour_par', $this->getUser()->getUserId());
        $this->aclForm->setUserId($this->user_id);
        $this->aclForm->automaticCheck();
    }

    /**
     * Perform the update of the Membre
     *
     * @param   sfWebRequest    $request
     */
    public function executeUpdate(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
        $this->user_id  = $request->getParameter('id');
        $this->forward404Unless($user = MembrePeer::retrieveByPk($this->user_id), sprintf('Member does not exist (%s).', $this->user_id));

        if (false === $this->isAllowedToManageProfile($user, 'edit_membre'))
        {
            $this->redirect('@error_credentials');
        }

        $this->form = new MembreForm($user, array('associationId' => $request->getParameter('membre[association_id]'),
                                                  'context'       => $this->getContext()));
        $this->aclForm  = new AclCredentialForm();
        $this->canEditRight = $this->getUser()->hasCredential('edit_acl');
        $this->aclForm->setUserId($this->user_id);
        $this->aclForm->automaticCheck();
        $this->processForm($request, $this->form);
        $this->setTemplate('edit');
    }



    /* -------------------------------------------------------------------------
     *
     * Actions to manage users who are requesting a subscription to an
     * existing association
     *
     * ---------------------------------------------------------------------- */

    /**
     * Display the form to request a new subscription to an existing
     * association. This action is -normally- reachable only if Piwam
     * is not in multi_association_mode, that's why we are selecting
     * with "doSelectOne" method
     *
     * @param   sfWebRequest    $request
     */
    public function executeRequestsubscription(sfWebRequest $request)
    {
        if (sfConfig::get('app_multi_association'))
        {
            $associationId = $request->getParameter('id', null);
            $this->forward404Unless($association = AssociationPeer::retrieveByPK($associationId), sprintf("L'association %s n'existe pas.", $associationId));
        }
        else
        {
            $association = AssociationPeer::doSelectOne(new Criteria());
            $associationId = $association->getId();
        }

        $this->form = new MembreForm(null, array('associationId' => $associationId,
                                                 'context'       => $this->getContext()));
        $this->form->setDefault('association_id', $associationId);
        $this->form->setDefault('actif', MembrePeer::IS_PENDING);
    }

    /**
     * Register a new pending user which requested a subscription to an existing
     * association
     *
     * @param   sfWebRequest    $request
     */
    public function executeCreatepending(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod('post'));
        $this->form = new MembreForm(null, array('associationId' => $request->getParameter("membre[association_id]"),
                                                 'context'       => $this->getContext()));
        $request->setAttribute('pending', true);
        $this->processForm($request, $this->form);
        $this->setTemplate('requestsubscription');
    }

    /**
     * Once subscription request form has been completed, we display a
     * message to the user
     *e
     */
    public function executePending()
    {
        // do nothing, just display template
    }

    /**
     * Validate a pending subscription. Send an email to the member if an
     * email has been given when subscribing
     *
     * @param   sfWebRequest    $request
     * @since   r160
     */
    public function executeValidate(sfWebRequest $request)
    {
        $membre_id = $request->getParameter('id');
        $membre = MembrePeer::retrieveByPk($membre_id);

        if ($membre->getAssociationId() == $this->getUser()->getAssociationId())
        {
            $membre->setActif(MembrePeer::IS_ACTIF);
            $membre->setMisAJourPar($this->getUser()->getUserId());
            $membre->save();

            if ($membre->getEmail() && $membre->getPseudo())
            {
                $mailer  = MailerFactory::get($this->getUser()->getAssociationId(), $this->getUser());
                $message = new Swift_Message('Activation du compte', "Bonjour {$membre}, votre compte a bien &eacute;t&eacute; activ&eacute;. Vous pouvez d&egrave;s maintenant vous identifier en tant que '{$membre->getPseudo()}'", 'text/html');
                $from    = Configurator::get('address', $membre->getAssociationId(), 'info-association@piwam.org');

                try
                {
                    $mailer->send($message, $membre->getEmail(), $from);
                }
                catch(Swift_ConnectionException $e)
                {
                    // do nothing
                }
            }

            $this->redirect('membre/index');
        }
        else
        {
            $this->redirect('@error_credentials');
        }
    }



    /* -------------------------------------------------------------------------
     *
     * Actions to manage the creation of the first user (who is registering
     * a new association)
     *
     * ---------------------------------------------------------------------- */

    /**
     * Register a new Membre - and the first one ! - for an
     * Association. This is a special method which use the temporary
     * AssociationID instead of using an already-registered AssociationID
     *
     * @param 	sfWebRequest	$request
     * @since	r16
     */
    public function executeNewfirst(sfWebRequest $request)
    {
        $associationId = $this->getUser()->getAttribute('association_id', null, 'temp');

        if (is_null($associationId))
        {
            throw new sfException('Erreur lors de la première étape d\'enregistrement');
        }
        else
        {
            $this->form = new MembreForm(null, array('associationId' => $associationId,
                                                     'context'       => $this->getContext(),
                                                     'first'         => true));
        }

        $this->form->setDefault('association_id', $associationId);
    }

    /**
     * Performed action when registering the first user
     *
     * @param 	sfWebRequest	$request
     * @since	r16
     */
    public function executeFirstcreate(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod('post'));
        $this->form = new MembreForm(null, array('associationId' => $this->getUser()->getTemporaryAssociationId(),
                                                 'context'       => $this->getContext(),
                                                 'first'         => true));
        $request->setAttribute('first', true);
        $this->processForm($request, $this->form);
        $this->setTemplate('newfirst');
    }

    /**
     * Display information about the just finished registration. We use
     * keyword 'instanceof' because getTemporaryUserInfo() returns
     * unserialized object - which can be null.
     *
     * @param 	sfWebRequest	$request
     * @see 	getTemporaryUserInfo()
     * @since	r16
     */
    public function executeEndregistration(sfWebRequest $request)
    {
        $membre = $this->getUser()->getTemporaryUserInfo();

        if ($membre instanceof Membre)
        {
            // here you can access to $membre properties
            // and methods
        }
    }

    /**
     * If this is a the first Membre that we registered, we redirect
     * to the `end` action to display success message about registration.
     *
     * r62 :    We give all the credentials to the user if this is the
     *          first user
     *
     * r139 :   resize pictures
     *
     * @param   sfWebRequest    $request
     * @param   sfForm          $form
     */
    protected function processForm(sfWebRequest $request, sfForm $form)
    {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid())
        {
            $membre = $form->save();

            if ($membre->getPicture())
            {
                $img = new sfImage(MembrePeer::PICTURE_DIR . '/' . $membre->getPicture(), 'image/jpg');
                $img->thumbnail(sfConfig::get('app_picture_width', 120), sfConfig::get('app_picture_height', 150), 'top');
                $img->saveAs(MembrePeer::PICTURE_DIR . '/' . $membre->getPicture());
            }
            if ($request->getAttribute('first') == true)
            {
                $association = AssociationPeer::retrieveByPK($membre->getAssociationId());
                $association->setEnregistrePar($membre->getId());
                $association->save();
                $this->getUser()->setTemporarUserInfo($membre);
                $credentials = AclActionPeer::doSelect(new Criteria());

                // we don't need to clear existing credentials before,
                // because we are sure the user doesn't have anyone

                foreach ($credentials as $credential)
                {
                    $membre->addCredential($credential->getCode());
                }

                // We check if we can warn the author that this association
                // is using Piwam

                if ($this->getUser()->getAttribute('ping_piwam', false, 'temp'))
                {
                    $swiftMailer   = new Swift(new Swift_Connection_NativeMail());
                    $subject       = '[Piwam] '    . $association->getNom() . ' utilise Piwam';
                    $content       = 'Site web : ' . $association->getSiteWeb() . '<br />';
                    $content      .= 'Email :    ' . $membre->getEmail() . '<br />';
                    $content      .= 'Pseudo :   ' . $membre->getPseudo();
                    $from          = 'info-association@piwam.org';
                    $swiftMessage = new Swift_Message($subject, $content, 'text/html');

                    try
                    {
                        $swiftMailer->send($swiftMessage, 'adrien@frenchcomp.net', $from);
                    }
                    catch(Swift_ConnectionException $e)
                    {
                        //
                    }
                }

                $this->getUser()->removeTemporaryData();
                $this->redirect('membre/endregistration');
            }
            elseif ($request->getAttribute('pending') == true)
            {
                $this->redirect('membre/pending');
            }
            else
            {
                $data = $request->getParameter('membre');

                if ((isset($data['enregistre_par'])) && ($membre->getPseudo() && $membre->getPassword()))
                {
                    $this->redirect('membre/acl?id=' . $membre->getId());
                }
                else
                {
                    $this->redirect('membre/index');
                }
            }
        }
    }

    /**
     * Checks if we are allowed to edit/show profile of $user
     *
     * @param   Membre  $user
     * @return  boolean
     */
    protected function isAllowedToManageProfile(Membre $user, $globalCredential = null)
    {
        if (($user->getAssociationId() != $this->getUser()->getAssociationId()))
        {
            return false;
        }
        else
        {
            if (! is_null($globalCredential))
            {
                if ($this->getUser()->hasCredential($globalCredential) == true)
                {
                    return true;
                }
            }

            if ($this->getUser()->getUserId() == $user->getId())
            {
                return true;
            }
        }

        return false;
    }
}
