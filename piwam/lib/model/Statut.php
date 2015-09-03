<?php

class Statut extends BaseStatut
{
    /**
     * Returns the name of the statut as a string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->nom;
    }

    /**
     * Disable the account of the member
     */
    public function disable()
    {
        $this->setActif(false);
        $this->save();
    }

    /**
     * Count active Membres
     *
     * @return  integer
     * @since   r130
     */
    public function countActiveMembres()
    {
        $c = new Criteria();
        $c->add(MembrePeer::ACTIF, MembrePeer::IS_ACTIF);

        return $this->countMembres($c);
    }

    /**
     * Override the delete methods.
     *
     * r87: 	we also can't delete if there are Membres who belong
     * 			to the statut
     */
    public function delete(PropelPDO $con = null)
    {
        if ($this->countMembres() == 0) {
            parent::delete($con);
        }
        elseif ($this->countActiveMembres($c)) {
            $this->disable();
        }
        else {
            sfContext::getInstance()->getUser()->setFlash('notice', "Le statut n'a pas pu être supprimé car il est encore utilisé");
        }
    }
}
