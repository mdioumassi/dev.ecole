<?php

class RecettePeer extends BaseRecettePeer
{
    /**
     * Select only data which belong to the association
     * in argument
     *
     * @param 	integer	$id
     * @return 	sfPropelPager
     * @since	r23
     */
    public static function doSelectPagerForAssociation($associationId, $page = 1)
    {
        $c = new Criteria();
        $c->add(self::ASSOCIATION_ID, $associationId);

        $pager = new sfPropelPager('Recette', 20);
        $pager->setCriteria($c);
        $pager->setPage($page);
        $pager->init();

        return $pager;
    }

    /**
     * Select only data which belong to the association
     * in argument
     *
     * @param 	integer	$id
     * @return 	sfPropelPager
     * @since	r23
     */
    public static function doSelectForAssociation($associationId, $page = 1)
    {
        $c = new Criteria();
        $c->add(self::ASSOCIATION_ID, $associationId);

        return self::doSelect($c);
    }

    /**
     * Retrieve data for the association given in argument
     *
     * @param 	integer	$id
     * @return 	array of Recette
     * @since	r57
     */
    public static function doSelectForActiviteId($id)
    {
        $c = new Criteria();
        $c->add(self::ACTIVITE_ID, $id);
        $c->add(self::PERCUE, 1);

        return self::doSelect($c);
    }

    /**
     * Get the amount of creances
     *
     * @param  integer $associationId
     * @return float
     * @since  r66
     */
    public static function getAmountOfCreances($associationId)
    {
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addAsColumn('TOTAL_CREANCES', 'SUM(' . self::MONTANT . ')');
        $c->add(self::ASSOCIATION_ID, $associationId);
        $c->addAnd(self::PERCUE, 0);
        $result = RecettePeer::doSelectStmt($c);
        $row = $result->fetch();

        if (is_null($row['TOTAL_CREANCES']))
        {
            return 0;
        }
        else
        {
            return $row['TOTAL_CREANCES'];
        }
    }

    /**
     * Get the amount of creances for the activite $activiteId
     *
     * @param  integer    $activiteId
     * @return float
     * @since  r71
     */
    public static function getAmountOfCreancesForActivite($activiteId)
    {
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addAsColumn('TOTAL_CREANCES', 'SUM(' . self::MONTANT . ')');
        $c->add(self::ACTIVITE_ID, $activiteId);
        $c->addAnd(self::PERCUE, 0);
        $result = RecettePeer::doSelectStmt($c);
        $row = $result->fetch();

        if (is_null($row['TOTAL_CREANCES']))
        {
            return 0;
        }
        else
        {
            return $row['TOTAL_CREANCES'];
        }
    }
}
