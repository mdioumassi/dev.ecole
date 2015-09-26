<?php
/**
 * I created this custom class to perform user authentication automatically
 *
 * @since   r64
 */
class sfGuardTestFunctional extends sfTestFunctional
{
    const LOGIN_OK          = "demo";       // set a valid login
    const PASSWORD_OK       = "demo";       // set a valid password
    var $userId             = null;
    var $associationId      = null;
    var $foreignAssociation = null;


    /**
     * Custom Ctor, overriding parent ctor
     *
     * @param           $browser
     * @param boolean   $login      (optional) Do we have to perform user login
     * @param           $lime		(optional)
     * @param           $testers	(optional)
     * @return			sfGuardTestFunctional $this
     */
    public function __construct($browser, $login = true, $lime = null, $testers = array())
    {
        parent::__construct($browser, $lime, $testers);

        $this->signout();

        if ($login)
        {
            $this->signin(array('username' => self::LOGIN_OK, 'password' => self::PASSWORD_OK));
        }
    }

    /**
     * Perform user athentication
     *
     * @param   array of String         $user_data
     * @return  sfGuardTestFunctional   $this
     */
    public function signin($user_data)
    {
        $this->info(sprintf('Connection with login: "%s" and password: "%s".', $user_data['username'], $user_data['password']))->
        get('/association/login')->
        click("S'identifier", array('login' => $user_data))->

        with('form')->begin()->
            hasErrors(false)->
        end()->

        with('user')->begin()->
            isCulture('fr_FR')->
            isAuthenticated(true)->
        end()->

        with('request')->begin()->
            isParameter('module', 'association')->
            isParameter('action', 'login')->
        end()->

        isRedirected()->
        followRedirect()->

        with('request')->hasCookie('Piwam');

        $this->userId = $this->getContext()->getUser()->getUserId();
        $this->associationId = $this->getContext()->getUser()->getAssociationId();
        $this->foreignAssociation = $this->associationId + 1;

        return $this;
    }

    /**
     * Logout the current user
     *
     * @return sfGuardTestFunctional $this
     */
    public function signout()
    {
        return $this->get('/association/logout');
    }

    /**
     * Creation of an account which belongs to another
     * association
     *
     * @return	integer	 ID of the new account
     */
    public function addForeignAccount()
    {
        $foreignAccount = new Compte();
        $foreignAccount->setAssociationId($this->foreignAssociation);
        $foreignAccount->setLibelle('Foreign account');
        $foreignAccount->setReference('FA');
        $foreignAccount->setActif(1);
        $foreignAccount->save();

        return $foreignAccount->getId();
    }

    /**
     * When testing cotisations, we need to create at least one valid
     * type
     */
    public function addNewCotisationType()
    {

    }
}

?>