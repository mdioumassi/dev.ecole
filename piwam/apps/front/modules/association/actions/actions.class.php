<?php

/**
 * association actions.
 *
 * @package    piwam
 * @subpackage association
 * @author     Adrien Mogenet
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class associationActions extends sfActions
{
    /*
     * Make some operations easier
     *
     * @var Association
     */
    private $_association = null;

    /**
     * Display config form to edit Association's configuration
     *
     * @param   sfWebRequest    $request
     * @since   r75
     */
    public function executeConfig(sfWebRequest $request)
    {
        if ($request->isMethod('post'))
        {
            $ph = $request->getParameterHolder();
            $data = $ph->getAll();
            foreach ($data['config'] as $key => $value)
            {
                Configurator::set($key, $value, $this->getUser()->getAssociationId());
            }
            $this->getUser()->setFlash('notice', 'Les préférences ont bien été prises en compte.');
        }

        $this->form = new ConfigForm();
    }

    /**
     * Login action. This is the default action if we are not authenticated.
     * If we can't perform the Propel operations, we consider the database
     * settings are not correct and we redirect to /install automatically
     *
     * @param 	sfWebRequest $request
     * @since	r7
     */
    public function executeLogin(sfWebRequest $request)
    {
        $this->form = new LoginForm();
        $this->displayRegisterLink = $this->_canRegisterAnotherAssociation();

        if ($request->isMethod('post'))
        {
            $this->form->bind($request->getParameter('login'));
            if ($this->form->isValid())
            {
                $user = MembrePeer::doSelectByUsernameAndPassword($request->getParameter('login[username]'), $request->getParameter('login[password]'));
                if (! is_null($user))
                {
                    $this->getUser()->login($user);

                    // Unused cookie, fake value is set
                    $this->getResponse()->setCookie(myUser::COOKIE_NAME, '1', time() + 60 * 60 * 24 * 15, '/');

                    if (! $request->getCookie(myUser::COOKIE_NAME))
                    {
                        $this->getUser()->setFlash('error', 'Les cookies doivent être activés');
                    }

                    if ($this->getUser()->hasCredential('list_membre'))
                    {
                        $this->redirect('membre/index');
                    }
                    else
                    {
                        $this->redirect('membre/show?id=' . $user->getId());
                    }
                }
                else
                {
                    if (MembrePeer::retrieveByPseudo($request->getParameter('login[username]')))
                    {
                        $this->getUser()->setFlash('error', "Le mot de passe est invalide", false);
                    }
                    else
                    {
                        $this->getUser()->setFlash('error', "Le nom d'utilisateur est invalide", false);
                    }
                }
            }
        }
    }

    /**
     * Logout action
     *
     * @param 	sfWebRequest	$request
     * @since	r7
     */
    public function executeLogout(sfWebRequest $request)
    {
        $this->getUser()->logout();
        $this->redirect('@homepage');
    }

    /**
     * Allows an user to retrieve a forget password. Set flash message if user
     * does not exist or if password has been set correctly
     *
     * @param   sfWebRequest    $request
     */
    public function executeForgottenpassword(sfWebRequest $request)
    {
        $this->form = new ForgottenPasswordForm();
        $this->displayRegisterLink = $this->_canRegisterAnotherAssociation();

        if ($request->isMethod('post'))
        {
            $this->form->bind($request->getParameter('password'));
            if ($this->form->isValid())
            {
                $user = MembrePeer::retrieveByPseudo($request->getParameter('password[username]'));
                if (! is_null($user))
                {
                    if ($user->getEmail())
                    {
                        $email = $user->getEmail();
                        $newPassword = StringTools::generatePassword(8);
                        $user->setPassword($newPassword);
                        $user->save();

                        $mailer   = MailerFactory::get($user->getAssociationId(), $this->getUser());
                        $message  = new Swift_Message('Votre mot de passe', 'Bonjour, votre nouveau mot de passe pour acc&eacute;der au gestionnaire d\'association est ' . $newPassword, 'text/html');
                        $from     = Configurator::get('address', $user->getAssociationId(), 'info-association@piwam.org');

                        try
                        {
                            $mailer->send($message, $email, $from);
                        }
                        catch(Swift_ConnectionException $e)
                        {
                            $this->getUser()->setFlash('error', 'Le mot de passe n\'a pu être envoyé par e-mail');
                        }

                        $mailer->disconnect();
                        $this->getUser()->setFlash('notice', 'Le nouveau mot de passe a été envoyé par e-mail', false);
                    }
                    else
                    {
                        $this->getUser()->setFlash('error', 'L\'utilisateur ne possède pas d\'adresse e-mail', false);
                    }
                }
                else
                {
                    $this->getUser()->setFlash('error', 'Le nom d\'utilisateur n\'existe pas', false);
                }
            }
        }
    }

    /**
     * Display the current overview of the association, for each Compte and
     * each Activite.
     * We provide the lists of the Compte and Activite to the view.
     *
     * @param 	sfWebRequest	$request
     * @since	r9
     */
    public function executeBilan(sfWebRequest $request)
    {
        $associationId          = $this->getUser()->getAssociationId();
        $this->comptes          = ComptePeer::doSelectEnabled($associationId);
        $this->activites        = ActivitePeer::doSelectEnabled($associationId);
        $this->totalCotisations = CotisationPeer::doSeletSumForAssociationId($associationId);
        $this->totalDettes      = DepensePeer::getAmountOfDettes($associationId);
        $this->totalCreances    = RecettePeer::getAmountOfCreances($associationId);
        $this->totalPrevu       = $this->totalCreances - $this->totalDettes;
    }

    /**
     * We don't have any way to list the associations
     *
     * @param   sfWebRequest    $request
     */
    public function executeIndex(sfWebRequest $request)
    {
        $this->associationsPager = AssociationPeer::doSelectActiveAssociations($request->getParameter('page', 1));
    }

    /**
     * Display creation form to register a new Assocation
     *
     * @param   sfWebRequest    $request
     */
    public function executeNew(sfWebRequest $request)
    {
        if (! $this->_canRegisterAnotherAssociation())
        {
            $this->redirect('@error_credentials');
        }

        $this->getUser()->removeTemporaryData();
        $this->form = new AssociationForm();
    }

    /**
     * Perform the creation of the new Association
     *
     * @param   sfWebRequest    $request
     */
    public function executeCreate(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod('post'));
        $this->form = new AssociationForm();

        if ($this->processForm($request, $this->form))
        {
            $this->_association->initialize();
            $this->getUser()->setTemporaryAssociationId($this->_association->getId());
            $this->redirect('membre/newfirst');
        }
        else
        {
            $this->setTemplate('new');
        }
    }

    /**
     * Display form to edit Association's information
     *
     * @param   sfWebRequest    $request
     */
    public function executeEdit(sfWebRequest $request)
    {
        $association = AssociationPeer::retrieveByPk($request->getParameter('id'));
        $this->forward404Unless($association, sprintf("L'association n'existe pas (%s).", $request->getParameter('id')));
        $this->form = new AssociationForm($association);
    }

    /**
     * Perform update of fields
     *
     * @param   sfWebRequest    $request
     */
    public function executeUpdate(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
        $association = AssociationPeer::retrieveByPk($request->getParameter('id'));
        $this->forward404Unless($association, sprintf('Association does not exist (%s).', $request->getParameter('id')));
        $this->form = new AssociationForm($association);

        if ($this->processForm($request, $this->form))
        {
            $this->redirect('membre/index');
        }
        else
        {
            $this->setTemplate('edit');
        }
    }

    /**
     * Perform the deletion
     *
     * @param   sfWebRequest    $request
     */
    public function executeDelete(sfWebRequest $request)
    {
        $request->checkCSRFProtection();
        $association = AssociationPeer::retrieveByPk($request->getParameter('id'));
        $this->forward404Unless($association, sprintf('Association does not exist (%s).', $request->getParameter('id')));
        $association->delete();
        $this->redirect('association/index');
    }

    /*
     * Process data sent from the form
     */
    protected function processForm(sfWebRequest $request, sfForm $form)
    {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

        if ($form->isValid())
        {
            $this->_association = $form->save();

            if ($request->getParameter('association[ping_piwam]', false))
            {
                $this->getUser()->setAttribute('ping_piwam', '1', 'temp');
            }

            return true;
        }
        return false;
    }

    /*
     * Check if we can register another new association. Because this method
     * is called in the default action, we check if PDO is correctly set up.
     *
     * If not, we redirect to install module
     */
    private function _canRegisterAnotherAssociation()
    {
        if (sfConfig::get('app_multi_association'))
        {
            return true;
        }
        else
        {
            try
            {
                if (AssociationPeer::doCount(new Criteria()) === 0)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            catch (PropelException $e)
            {
                $this->redirect('@setup');
            }
        }
    }
}
