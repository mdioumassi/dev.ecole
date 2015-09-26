<?php
/**
 * Represents the current user session. myUser is able to manage temporary
 * information (when user is registering a new association and so he's not
 * registered yet) and persistent information about him (once he's registered)
 *
 * @author Adrien Mogenet
 */
class myUser extends sfBasicSecurityUser
{
    /**
     * Defines the name of cookie that will be created
     *
     * @var string
     */
    const COOKIE_NAME = 'Piwam';

    /**
     * Performs all the required actions when user just
     * logged in
     *
     * @param	Membre	$user
     * @since	r6
     */
    public function login(Membre $user)
    {
        $this->setAuthenticated(true);
        $this->setCulture('fr_FR');
        $this->setAttribute('association_id',   $user->getAssociationId(),          'user');
        $this->setAttribute('association_name', $user->getAssociation()->getNom(),  'user');
        $this->setAttribute('user_id',          $user->getId(),                     'user');
        $this->setAttribute('user_name',        $user->getPseudo(),	                'user');
        $this->removeTemporaryData();
        $this->setCredentials();
    }

    /**
     * Performs all required actions when user would like to log out
     * or when we force him to log out
     *
     * @since	r6
     */
    public function logout()
    {
        $this->setAuthenticated(false);
        $this->getAttributeHolder()->removeNamespace('user');
        $this->getAttributeHolder()->removeNamespace('temp');
        $this->clearCredentials();
    }

    /**
     * Get the current association ID of the user
     *
     * @param	integer	$default (optional)
     * @return	integer
     * @since	r140
     */
    public function getAssociationId($default = null)
    {
        return $this->getAttribute('association_id', $default, 'user');
    }

    /**
     * Get the current user ID of the user
     *
     * @param	integer	$default (optional)
     * @return	integer
     * @since	r140
     */
    public function getUserId($default = null)
    {
        return $this->getAttribute('user_id', $default, 'user');
    }

    /**
     * Store temporary an Association ID in session. It's just usefull
     * when we want to register a new association, to store easily
     * the ID between the different steps of registration
     *
     * @param 	integer	$id
     * @since	r16
     */
    public function setTemporaryAssociationId($id)
    {
        $this->setAttribute('association_id', $id, 'temp');
    }

    /**
     * Retrieve the temporary Association ID in session, previously set
     * by setTemporaryAssociationId
     *
     * @return  integer
     * @since   r159
     */
    public function getTemporaryAssociationId()
    {
        return $this->getAttribute('association_id', null, 'temp');
    }

    /**
     * Store temporary values about user
     *
     * @param 	Membre	$value
     * @since	r16
     */
    public function setTemporarUserInfo($user)
    {
        $this->setAttribute('user_info', serialize($user), 'temp');
    }

    /**
     * Retrieve temporary Membre value
     *
     * @return 	Membre
     * @since	r16
     */
    public function getTemporaryUserInfo()
    {
        return unserialize($this->getAttribute('user_info', null, 'temp'));
    }

    /**
     * Remove all data which were stored temporary
     *
     * @since	r16
     */
    public function removeTemporaryData()
    {
        $this->getAttributeHolder()->removeNamespace('temp');
    }

    /*
     * Retrieve the credentials granted to the user
     */
    protected function setCredentials()
    {
        $credentials = AclCredentialPeer::doSelectForMembreId($this->getAttribute('user_id', null, 'user'));

        foreach ($credentials as $credential)
        {
            $this->addCredential($credential->getCode());
        }
    }
}
