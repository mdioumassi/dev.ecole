<?php

class Activite extends BaseActivite
{
    // Store the total amount of Depense and Recette related to
    // this Activite
    protected $_totalDepenses = null;
    protected $_totalRecettes = null;

    /**
     * We display the label of the activity if we would like to display the
     * value of the object
     *
     * @return  string
     * @since   r5
     */
    public function __toString()
    {
        return $this->getLibelle();
    }


    /**
     * Retrieve the total amount of Depenses for this Activite
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
            $c->add(DepensePeer::ACTIVITE_ID, $this->getId());
            $c->addAnd(DepensePeer::PAYEE, 1);
            $result = DepensePeer::doSelectStmt($c);
            $row = $result->fetch();
            $this->_totalDepenses = $row['TOTAL_DEPENSES'];
        }

        return ($this->_totalDepenses == null) ? 0 : $this->_totalDepenses;
    }


    /**
     * Retrieve the total amount of Recettes within the Compte
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
            $c->add(RecettePeer::ACTIVITE_ID, $this->getId());
            $c->addAnd(RecettePeer::PERCUE, 1);
            $result = RecettePeer::doSelectStmt($c);
            $row = $result->fetch();
            $this->_totalRecettes = $row['TOTAL_RECETTES'];
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
}
