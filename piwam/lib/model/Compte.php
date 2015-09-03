<?php

class Compte extends BaseCompte
{
    // Allow to store total amounts in order to avoid re-computing if it
    // has been already done
    protected	$_totalDepenses = null;
    protected	$_totalRecettes = null;


    /**
     * We display the reference of the account if we would like to
     * display it
     *
     * @return  string
     * @since   r5
     */
    public function __toString()
    {
        return $this->getReference();
    }


    /**
     * Retrieve the total amount of Depenses within the Compte
     *
     * @return	integer
     * @since	r9
     */
    public function getTotalDepenses()
    {
        if (is_null($this->_totalDepenses))
        {
            $c = new Criteria();
            $c->clearSelectColumns();
            $c->addAsColumn('TOTAL_DEPENSES', 'SUM(' . DepensePeer::MONTANT . ')');
            $c->add(DepensePeer::COMPTE_ID, $this->getId());
            $c->addAnd(DepensePeer::PAYEE, 1);
            $result = DepensePeer::doSelectStmt($c);
            $rows = $result->fetchAll();
            $row = $rows[0];
            $this->_totalDepenses = $row['TOTAL_DEPENSES'];
        }

        return ($this->_totalDepenses == null) ? 0 : $this->_totalDepenses;
    }


    /**
     * Retrieve the total amount of Recettes within the Compte. We also
     * compute the SUM of Cotisation which are related to this Compte
     *
     * @return	integer
     * @since	r9
     */
    public function getTotalRecettes()
    {
        if (is_null($this->_totalRecettes))
        {
            $c = new Criteria();
            $c->clearSelectColumns();
            $c->addAsColumn('TOTAL_RECETTES', 'SUM(' . RecettePeer::MONTANT . ')');
            $c->add(RecettePeer::COMPTE_ID, $this->getId());
            $c->addAnd(RecettePeer::PERCUE, 1);
            $result = RecettePeer::doSelectStmt($c);
            $rows = $result->fetchAll();
            $row = $rows[0];

            $totalCotisations = CotisationPeer::doSeletSumForAccountId($this->getId());
            $this->_totalRecettes = $row['TOTAL_RECETTES'] + $totalCotisations;
        }

        return ($this->_totalRecettes == null) ? 0 : $this->_totalRecettes;
    }


    /**
     * Retrieve the actual total (recettes - depenses) of the current account
     *
     * @return 	integer
     * @since	r9
     */
    public function getTotal()
    {
        $total = $this->getTotalRecettes() - $this->getTotalDepenses();
        return ($total == null) ? 0 : $total;
    }


    /**
     * Determines if the Compte is negative of not
     *
     * @return	boolean
     */
    public function isNegative()
    {
        return $this->getTotal() < 0;
    }

    /**
     * Set the reference of the Compte but force the upper case
     *
     * @param 	string		$value
     * @param	PropelPDO	$con
     * @since	r25
     */
    public function setReference($value)
    {
        parent::setReference(strtoupper($value));
        if (false) {
            parent::delete($con);
        }
        else {
            $this->setActif(DISABLED);
            $this->save();
        }

    }

    /**
     * Delete the current Compte logically
     *
     * @param 	PropelPDO	$con
     * @since	r38
     */
    public function delete(PropelPDO $con = null)
    {
        $this->setActif(DISABLED);
        $this->save();
    }
}
