<?php

class ConfigVariablePeer extends BaseConfigVariablePeer
{
    /**
     * Retrieve a row according to the code $code
     *
     * @param   string  $code
     * @return  ConfigVariable
     */
    public static function retrieveByCode($code)
    {
        $c = new Criteria();
        $c->add(self::CODE, $code);

        return self::doSelectOne($c);
    }

    /**
     * Retrieve a list of variables which belong to the module code $code
     *
     * @param   string  $code
     * @return  array of ConfigVariable
     * @since   r75
     */
    public static function doSelectByCategorieCode($code)
    {
        $c = new Criteria();
        $c->add(self::CATEGORIE_CODE, $code);

        return self::doSelect($c);
    }
}
