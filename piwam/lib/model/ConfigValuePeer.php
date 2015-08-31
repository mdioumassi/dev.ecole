<?php

class ConfigValuePeer extends BaseConfigValuePeer
{
    /**
     * Retrieve a row matching the code $code for the association
     * $association_id
     *
     * @param   string  $code
     * @param   integer $association_id
     * @return  ConfigValue
     */
    public static function retrieveByCode($code, $association_id)
    {
        $c = new Criteria();
        $c->add(self::ASSOCIATION_ID, $association_id);
        $c->addJoin(self::CONFIG_VARIABLE_ID, ConfigVariablePeer::ID, Criteria::LEFT_JOIN);
        $c->addAnd(ConfigVariablePeer::CODE, $code);

        return self::doSelectOne($c);
    }
}
