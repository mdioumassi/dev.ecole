<?php

class StatutPeer extends BaseStatutPeer
{
    const IS_ACTIF = 1;

    /**
     * Select all enabled Statut for the specified associationId
     *
     * @param 	integer	$associationId
     * @return 	array of Statut
     */
    public static function doSelectEnabled($associationId)
    {
        $c = new Criteria();
        $c->add(self::ACTIF, self::IS_ACTIF);
        $c->addAnd(self::ASSOCIATION_ID, $associationId);

        return parent::doSelect($c);
    }


    /**
     * Build a specific Criteria to get only enabled statuts. It is
     * useful to customize our forms
     *
     * @return  Criteria
     *
     */
    public static function getCriteriaEnabledForAssociation($associationId)
    {
        $c = new Criteria();
        $c->add(self::ACTIF, self::IS_ACTIF);
        $c->addAnd(self::ASSOCIATION_ID, $associationId);
        $c->addAscendingOrderByColumn(self::NOM);

        return $c;
    }
}
