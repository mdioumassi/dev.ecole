<?php

/**
 * Peer class for managing members
 *
 * @author adrien
 */
class MembrePeer extends BaseMembrePeer
{
    /**
     * Set upload directory for user's pictures
     *
     * @var string
     */
    const PICTURE_DIR = 'uploads/trombinoscope';

    /**
     * Set constant for active members
     *
     * @var integer
     */
    const IS_ACTIF = 1;

    /**
     * Set constant for pending subscriptions
     *
     * @var integer
     */
    const IS_PENDING = 2;

    /**
     * Retrieve all the members. Order the list according to the first
     * parameter.
     *
     * r9 : we check the validity of the field name given as argument
     *
     * @author  Adrien Mogenet <adrien@frenchcomp.net>
     * @param	integer	$associationId
     * @param   string  $column
     * @return  sfPropelPager
     * @since   r1
     */
    public static function doSelectOrderBy($associationId, $page = 1, $column = self::PSEUDO)
    {
        if (! in_array($column, array('NOM', 'PRENOM', 'PSEUDO', 'STATUT_ID', 'VILLE')))
        {
            $column = self::NOM;
        }

        $c = self::buildCriteria(array(), true, $associationId);
        $c->addAscendingOrderByColumn($column);

        $pager = new sfPropelPager('Membre', Configurator::get('users_by_page', $associationId, 20));
        $pager->setCriteria($c);
        $pager->setPage($page);
        $pager->init();

        return $pager;
    }

    /**
     * Retrieve the member who have a pending subscription
     *
     * @param   integer $associationId
     * @return  array of Membre
     * @since   r160
     */
    public static function doSelectPending($associationId)
    {
        $c = new Criteria();
        $c->add(self::ACTIF, self::IS_PENDING);
        $c->addAnd(self::ASSOCIATION_ID, $associationId);
        $c->addDescendingOrderByColumn(self::CREATED_AT);

        return self::doSelect($c);
    }

    /**
     * Try to select users matching $username and $password.
     *
     * @param 	string	$username
     * @param 	string	$password
     * @return 	Membre
     * @since	r7
     */
    public static function doSelectByUsernameAndPassword($username, $password)
    {
        $c = new Criteria();
        $c->add(self::PSEUDO, $username);
        $c->addAnd(self::PASSWORD, sha1($password));
        $c->addAnd(self::ACTIF, self::IS_ACTIF);

        return self::doSelectOne($c);
    }

    /**
     * Perform a research
     *
     * @params  array           $params
     * @return  array of Membre
     */
    public static function doSearch($params)
    {
        $c = self::buildCriteria($params, true);

        return self::doSelect($c);
    }

    /**
     * Display Membre matching our query (actually this may
     * only be AJAX query for autompleted fields)
     *
     * @param	string	$q : query
     * @param	integer	$limit
     * @return 	array of Membre
     * @since	r15
     */
    static public function retrieveForSelect($q, $limit, $associationId)
    {
        $criteria = new Criteria();
        $criteria->setIgnoreCase(true);
        //$criteria->add(self::PRENOM, '%' . $q . '%', Criteria::LIKE);
        $criteria->add(self::ID, "LOWER(CONCAT(CONCAT(" . self::PRENOM . ", ' '), " . self::NOM . ")) LIKE '%" . strtolower($q) . "%'", Criteria::CUSTOM);
        $criteria->addAnd(self::ASSOCIATION_ID, $associationId);
        $criteria->addAscendingOrderByColumn(self::PRENOM);
        $criteria->setLimit($limit);
        $membres = self::doSelect($criteria);
        $aMembres = array();

        foreach ($membres as $membre)
        {
            $aMembres[$membre->getId()] = (string) $membre;
        }

        return $aMembres;
    }

    /**
     * Retrieve a Membre according to his pseudo
     *
     * @param 	string	$pseudo
     * @return 	Membre
     * @since	r16
     */
    public static function retrieveByPseudo($pseudo)
    {
        $c = new Criteria();
        $c->add(self::PSEUDO, $pseudo);

        return self::doSelectOne($c);
    }

    /**
     * Retrieve all members who belongs to the association in parameter.
     * This is different from the method `doSelectOrderBy` which selects
     * members within a sfPropelPager.
     *
     * @param 	integer	     $id : association ID
     * @return 	array of Membre
     * @since	r17
     */
    public static function doSelectForAssociation($id)
    {
        $c = self::getCriteriaForAssociationId($id);

        return self::doSelect($c);
    }

    /**
     * Return a Criteria to select only data which belong to the association
     * in argument
     *
     * @param 	integer      $id : association ID
     * @return 	Criteria
     * @since	r23
     */
    public static function getCriteriaForAssociationId($id)
    {
        $c = self::buildCriteria(array(), true, $id);
        $c->addAscendingOrderByColumn(self::PRENOM);

        return $c;
    }

    /**
     * Retrieve Membre who have an email address that had been set and who
     * belong to association in argument
     *
     * @param 	integer	    $associationId
     * @return 	array of Membre
     * @since	r25
     */
    public static function doSelectWithEmailForAssociation($associationId)
    {
        $c = new Criteria();
        $c->add(self::ASSOCIATION_ID, $associationId);
        $c->addAnd(self::EMAIL, null, Criteria::ISNOTNULL);
        $c->addAnd(self::EMAIL, "", Criteria::NOT_EQUAL);
        $c->addAnd(self::ACTIF, self::IS_ACTIF);

        return self::doSelect($c);
    }

    /**
     * Build a search Critera based on params
     * Available filters :
     *
     *      o magic             : search on email, name, lastname, username
     *      o associationId
     *
     * @param   array       $params
     * @param   boolean     $active         : search only active members
     * @param   integer     $associationId  : override $params['associationId']
     * @return  Criteria
     * @since   r212
     */
    private static function buildCriteria($params, $active = true, $associationId = null)
    {
        $c = new Criteria();

        if (isset($params['magic']))
        {
            $criterion1 = $c->getNewCriterion(self::PSEUDO, $params['magic'], Criteria::LIKE);
            $criterion2 = $c->getnewCriterion(self::ID, "LOWER(CONCAT(CONCAT(" . self::PRENOM . ", ' '), " . self::NOM . ")) LIKE '" . strtolower($params['magic']) . "'", Criteria::CUSTOM);
            $criterion3 = $c->getNewCriterion(self::EMAIL, $params['magic'], Criteria::LIKE);
            $criterion1->addOr($criterion2);
            $criterion1->addOr($criterion3);
            $c->add($criterion1);
        }

        if (isset($params['associationId']))
        {
            $c->addAnd(self::ASSOCIATION_ID, $params['associationId']);
        }

        // override $params['associationId']
        if (! is_null($associationId))
        {
           $c->addAnd(self::ASSOCIATION_ID, $associationId);
        }

        if ($active)
        {
            $c->addAnd(self::ACTIF, self::IS_ACTIF);
        }

        return $c;
    }
}
