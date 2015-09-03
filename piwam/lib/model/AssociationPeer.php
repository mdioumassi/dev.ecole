<?php

class AssociationPeer extends BaseAssociationPeer
{
    const ASSOCIATIONS_BY_PAGE = 20;

    /**
     * Retrieve the list of associations which have at least one active member
     *
     * @param   integer         $page
     * @return  sfPropelPager
     */
    public static function doSelectActiveAssociations($page = 1)
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(self::NOM);

        $pager = new sfPropelPager('Association', self::ASSOCIATIONS_BY_PAGE);
        $pager->setCriteria($c);
        $pager->setPage($page);
        $pager->init();

        return $pager;
    }

    /**
     * Get the _FIRST_ Association which is named $name
     *
     * @param   string  $name
     * @return  Association
     */
    public static function retrieveByName($name)
    {
        $c = new Criteria();
        $c->add(self::NOM, $name);

        return self::doSelectOne($c);
    }
}
