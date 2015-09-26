<?php
/**
 * Represents a member of an association
 *
 * @author Adrien Mogenet
 */
class Membre extends BaseMembre
{
    /**
     * Overrides getter for Ville field.
     *
     * @see     lib/model/om/BaseMembre#getVille()
     * @return  string  well-formated city
     */
    public function getVille()
    {
        return strtoupper(parent::getVille());
    }

    /**
     * Format the name of the member
     *
     * @see     lib/model/om/BaseMembre#getNom()
     * @return  string
     */
    public function getNom()
    {
        return mb_convert_case(parent::getNom(), MB_CASE_TITLE, "UTF8");
    }

    /**
     * Format last-name of the member
     *
     * @see     lib/model/om/BaseMembre#getPrenom()
     * @return  string
     */
    public function getPrenom()
    {
        return mb_convert_case(parent::getPrenom(), MB_CASE_TITLE, "UTF8");
    }

    /**
     * Overrides the setPseudo() method. Store NULL if value
     * is an empty string
     *
     * @param 	string	$v
     * @since	r35
     */
    public function setPseudo($v)
    {
        if ($v == "")
        {
            parent::setPseudo(null);
        }
        else
        {
            parent::setPseudo($v);
        }
    }

    /**
     * Convert the object to a displayable string
     *
     * @return  string
     * @since   r1
     */
    public function __toString()
    {
        return $this->getPrenom() . ' ' . $this->getNom();
    }

    /**
     * Returns a boolean showing if the member has to pay or not
     *
     * @return  boolean
     * @since   r1
     */
    public function isAjourCotisation()
    {
        if ($this->getExempteCotisation())
        {
            return true;
        }
        else
        {
            $lastPayment = CotisationPeer::getDerniereDuMembre($this->getId());

            if ($lastPayment)
            {
                $dateCalculator = new DateTools($lastPayment->getDate(), 'Y-m-d');
                $expire_date    = $dateCalculator->add('mo', $lastPayment->getValidity());
                $today          = strtotime(date('Y-m-d'));
                $expiration     = strtotime($expire_date);

                return ($expiration >= $today);
            }
            else
            {
                return false;
            }
        }
    }

    /**
     * Disable the account of the member
     */
    public function disable()
    {
        $this->setPseudo(null);
        $this->setPassword(null);
        $this->setActif(false);
        $this->save();
    }


    /**
     * Override the delete methods. We have to not be able to delete
     *
     */
    public function delete(PropelPDO $con = null)
    {
        $this->disable();
    }


    /**
     * Get the whole address of the Membre (street, city, zipcode...)
     * This is address may be used for Google Map localization
     *
     * @return 	string
     * @since	r17
     */
    public function getCompleteAddress()
    {
        return StringTools::to7bit($this->getRue()) . ', ' . $this->getCp() . ' ' . StringTools::to7bit($this->getVille());
    }

    /**
     * Returns a complete displayable string, with all
     * interesting information about him.
     *
     * @return 	string
     * @since	r18
     */
    public function getInfoForGmap()
    {
        $result = '<b>' . $this->__toString() . '</b>';
        $result .= ' (<i>' . $this->getPseudo() . '</i>)<br /><br />';
        $result .= $this->getRue() . ',<br />';
        $result .= $this->getCp() . ' ' . $this->getVille() . '<br />';
        $result .= $this->getPays() . '<br /><br />';

        return $result;
    }

    /**
     * Overrides setPassword method in order to manage empty values,
     * encryption...
     *
     * @see 	lib/model/om/BaseMembre#setPassword()
     * @since	r20
     */
    public function setPassword($password)
    {
        if (strlen($password) > 0)
        {
            parent::setPassword(sha1($password));
        }
    }

    /**
     * Delete all existing ACL for the Membre
     *
     * @since   r60
     */
    public function resetAcl()
    {
        $credentials = AclCredentialPeer::doDeleteForMembreId($this->getId());
    }

    /**
     * Add a new credential for the Membre
     *
     * @param   string  $code
     * @since   r60
     * @throw   Exception if invalid $code
     */
    public function addCredential($code)
    {
        $action = AclActionPeer::retrieveByCode($code);

        if (is_null($action))
        {
            throw new Exception('No action has been found for code ' . $code);
        }
        $acl = new AclCredential();
        $acl->setMembreId($this->getId());
        $acl->setAclActionId($action->getId());
        $acl->save();
    }

    /**
     * Get the complete URI of the user's picture
     *
     * @return	string	complete URI
     * @since	r139
     */
    public function getPictureURI()
    {
        if ($this->getPicture())
        {
            return '/uploads/trombinoscope/' . $this->getPicture();
        }
        else
        {
            return 'no_picture';
        }
    }
}