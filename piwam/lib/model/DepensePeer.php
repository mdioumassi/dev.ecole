<?php

class DepensePeer extends BaseDepensePeer
{
    /**
     * Retrieve data only for the association referenced by $associationId
     *
     * @param 	integer	$associationId
     * @return 	sfPropelPager
     * @since	r14
     */
    public static function doSelectPagerForAssociation($associationId, $page = 1)
    {
        $c = new Criteria();
        $c->add(self::ASSOCIATION_ID, $associationId);
        $c->addDescendingOrderByColumn(self::DATE);

        $pager = new sfPropelPager('Depense', 20);
        $pager->setCriteria($c);
        $pager->setPage($page);
        $pager->init();

        return $pager;
    }

    /**
     * Retrieve data only for the association referenced by $associationId
     *
     * @param 	integer	$associationId
     * @return 	array of Depense
     */
    public static function doSelectForAssociation($associationId, $page = 1)
    {
        $c = new Criteria();
        $c->add(self::ASSOCIATION_ID, $associationId);
        $c->addDescendingOrderByColumn(self::DATE);

        return self::doSelect($c);
    }

    /**
     * Retrieve data for the association given in argument
     *
     * @param 	integer	$id
     * @return 	array of Depense
     * @since	r57
     */
    public static function doSelectForActiviteId($id)
    {
        $c = new Criteria();
        $c->add(self::ACTIVITE_ID, $id);
        $c->add(self::PAYEE, 1);

        return self::doSelect($c);
    }

    /**
     * Get the amount of debts
     *
     * @param  integer $associationId
     * @return float
     * @since  r66
     */
    public static function getAmountOfDettes($associationId)
    {
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addAsColumn('TOTAL_DETTES', 'SUM(' . self::MONTANT . ')');
        $c->add(self::ASSOCIATION_ID, $associationId);
        $c->addAnd(self::PAYEE, 0);
        $result = DepensePeer::doSelectStmt($c);
        $row = $result->fetch();

        if (is_null($row['TOTAL_DETTES']))
        {
            return 0;
        }
        else
        {
            return $row['TOTAL_DETTES'];
        }
    }

    /**
     * Get the amount of debts for the activite $activiteId
     *
     * @param  integer    $activiteId
     * @return float
     * @since  r71
     */
    public static function getAmountOfDettesForActivite($activiteId)
    {
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addAsColumn('TOTAL_DETTES', 'SUM(' . self::MONTANT . ')');
        $c->add(self::ACTIVITE_ID, $activiteId);
        $c->addAnd(self::PAYEE, 0);
        $result = DepensePeer::doSelectStmt($c);
        $row = $result->fetch();

        if (is_null($row['TOTAL_DETTES']))
        {
            return 0;
        }
        else
        {
            return $row['TOTAL_DETTES'];
        }
    }

    /**
     * Build/Complete a Criteria object
     *
     * @param  Criteria    $c
     * @param  Mixed       $params     array
     * @return Criteria
     * @since  r71
     */
    public static function buildCriteria(&$c, $params)
    {
        if (is_array($params))
        {
            if ($activite_id = ParamsTools::get_ifset($params, 'activite_id')) {
                $c->addAnd(self::ACTIVITE_ID, $activite_id);
            }
        }

        return $c;
    }
}
