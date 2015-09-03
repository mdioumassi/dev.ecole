<?php

class ComptePeer extends BaseComptePeer
{
    public static function doSelectEnabled($associationId)
    {
        $c = new Criteria();
        $c->add(self::ACTIF, 1);
        $c->addAnd(self::ASSOCIATION_ID, $associationId);

        return self::doSelect($c);
    }

    /**
     * Return a Criteria to select only data which belong to the association
     * in argument
     *
     * @param 	integer	$id
     * @return 	Criteria
     * @since	r23
     */
    public static function getCriteriaForAssociationId($id)
    {
        $c = new Criteria();
        $c->add(self::ASSOCIATION_ID, $id);
        $c->add(self::ACTIF, ENABLED);

        return $c;
    }
}
