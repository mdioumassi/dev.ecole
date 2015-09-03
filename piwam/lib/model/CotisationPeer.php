<?php

class CotisationPeer extends BaseCotisationPeer
{
    public static function doSelectJoinMembreId($associationId)
    {
        $c = new Criteria();
        $c->addJoin(self::MEMBRE_ID, MembrePeer::ID);
        $c->addAnd(MembrePeer::ASSOCIATION_ID, $associationId);

        return self::doSelect($c);
    }

    /**
     * Get the date of the last payment of the member in parameter
     *
     * @param   integer     $id
     * @return  Cotisation
     * @since   r1
     */
    public static function getDerniereDuMembre($id)
    {
        $c = new Criteria();
        $c->add(self::MEMBRE_ID, $id);
        $c->addDescendingOrderByColumn(self::DATE);

        return self::doSelectOne($c);
    }

    /**
     * Retrieve Cotisation paid by user $userId
     *
     * @param 	integer	$userId
     * @return 	array of Cotisation
     * @since	r14
     */
    public static function doSelectForUser($userId)
    {
        $c = new Criteria();
        $c->add(self::MEMBRE_ID, $userId);

        return self::doSelect($c);
    }

    /**
     * Compute the SUM of Cotisation for the Compte given as argument
     *
     * @param 	integer	$id : ID of Compte you want to compute the SUM
     * @return 	integer
     * @since	r40
     */
    public static function doSeletSumForAccountId($id)
    {
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addJoin(self::COTISATION_TYPE_ID, CotisationTypePeer::ID, Criteria::LEFT_JOIN);
        $c->addAnd(CotisationPeer::COMPTE_ID, $id);
        $c->addAsColumn('TOTAL_COTISATIONS', 'SUM(' . CotisationPeer::MONTANT . ')');
        $c->addGroupByColumn(self::COMPTE_ID);
        $result = self::doSelectStmt($c);
        $row = $result->fetch();

        return $row['TOTAL_COTISATIONS'];
    }


    /**
     * Compute the SUM of Cotisation for the Association given as argument
     *
     * @param 	integer	$id : ID of Association you want to compute the SUM
     * @return 	integer
     * @since	r40
     */
    public static function doSeletSumForAssociationId($id)
    {
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(self::ID);
        $c->addJoin(self::COTISATION_TYPE_ID, CotisationTypePeer::ID, Criteria::LEFT_JOIN);
        $c->addSelectColumn(CotisationTypePeer::ASSOCIATION_ID);
        $c->addAsColumn('TOTAL_COTISATIONS', 'SUM(' . CotisationPeer::MONTANT . ')');
        $c->addAnd(CotisationTypePeer::ASSOCIATION_ID, $id);
        $c->addGroupByColumn(CotisationTypePeer::ASSOCIATION_ID);
        $result = self::doSelectStmt($c);
        $row = $result->fetch();

        if ($row['TOTAL_COTISATIONS'] === null)
        {
            return 0;
        }
        else
        {
            return $row['TOTAL_COTISATIONS'];
        }
    }
}
