<?php

class AclActionPeer extends BaseAclActionPeer
{
    /**
     * Retrieve the list of actions related to the module
     * given in argument
     *
     * @param   integer $moduleId
     * @return  array of AclAction
     */
    public static function doSelectForModuleId($moduleId)
    {
        $c = new Criteria();
        $c->add(self::ACL_MODULE_ID, $moduleId);

        return self::doSelect($c);
    }

    /**
     * Retrieve an action thanks to its code
     *
     * @param   string  $code
     * @return  AclAction
     */
    public static function retrieveByCode($code)
    {
        $c = new Criteria();
        $c->add(self::CODE, $code);

        return self::doSelectOne($c);
    }
}
