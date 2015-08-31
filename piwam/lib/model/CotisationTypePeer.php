<?php

class CotisationTypePeer extends BaseCotisationTypePeer
{
    /**
     * Get the amount of a Cotisation according to its ID
     *
     * @param   integer $id : type id
     * @return  integer     : amount
     * @since   r51
     */
    public static function getAmountForTypeId($id)
    {
        $type = self::retrieveByPK($id);
        return $type->getMontant();
    }

    /**
     * Retrieve CotisationType only for the $associationId in argument
     *
     * @param 	integer	$associationId
     * @return 	array of CotisationType
     * @since 	r14
     */
    public static function doSelectEnabled($associationId)
    {
        $c = new Criteria();
        $c->add(self::ACTIF, ENABLED);
        $c->addAnd(self::ASSOCIATION_ID, $associationId);

        return self::doSelect($c);
    }

    /**
     * Indicates if at least one type has already been set or not
     * for the associationId in argument
     *
     * @param 	integer	$associationId
     * @return	boolean
     * @since	r20
     */
    public static function doesOneTypeExist($associationId)
    {
        $c = new Criteria();
        $c->add(self::ACTIF, ENABLED);
        $c->addAnd(self::ASSOCIATION_ID, $associationId);
        $numberOfTypes = self::doCount($c);

        return $numberOfTypes > 0;
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

        return $c;
    }
}
