<?php

class ActivitePeer extends BaseActivitePeer
{
    /**
     * Retrieve list of Activite for the Association/bilan action
     *
     * @param	integer	$associationId
     * @return	array of Activite
     */
    public static function doSelectEnabled($associationId)
    {
        $c = new Criteria();
        $c->add(self::ACTIF, ENABLED);
        $c->addAnd(self::ASSOCIATION_ID, $associationId);

        return self::doSelect($c);
    }

    /**
     * Get a Criteria to select only entities which belong to the
     * association $id
     *
     * @param 	integer $id
     * @return 	Criteria
     * @since	r21
     */
    public static function getCriteriaForAssociationId($id)
    {
        $c = new Criteria();
        $c->add(self::ASSOCIATION_ID, $id);
        $c->add(self::ACTIF, ENABLED);

        return $c;
    }
}
