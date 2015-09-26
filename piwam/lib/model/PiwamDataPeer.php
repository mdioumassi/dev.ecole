<?php

/**
 * Manage private Piwam data. The linked table is used to hide information
 * that user has not to deal with.
 *
 * @author  adrien
 * @since   r100
 */
class PiwamDataPeer extends BasePiwamDataPeer
{
    /**
     * Get the value associated to the key $key
     *
     * @param   string  $key
     * @return  Mixed   string if key exists, null otherwise
     */
    public static function get($key)
    {
        $piwamData = self::retrieveByKey($key);

        if ($piwamData) {
            return $piwamData->getValue();
        }
        else {
            return null;
        }
    }

    /**
     * Store a new value. Create the new key if it doesn't exist.
     * If $override is set to false, we just create the key entry if it does
     * not exist, but we don't override an existing key
     *
     * @param   string  $key
     * @param   string  $value
     * @param   bool    $override
     * @return  bool    Success or failure
     */
    public static function set($key, $value, $override = true)
    {
        $existingKey = self::retrieveByKey($key);

        if (is_null($existingKey))
        {
            $piwamData = new PiwamData();
            $piwamData->setKey($key);
            $piwamData->setValue($value);
            $piwamData->save();
        }
        else
        {
            if ($override)
            {
                $existingKey->setValue($value);
                $existingKey->save();
            }
        }
    }

    /**
     * Retrieve a unique PiwamData object according to the $key
     *
     * @param   string  $key
     * @return  PiwamData
     */
    public static function retrieveByKey($key)
    {
        $c = new Criteria();
        $c->add(self::KEY, $key);

        return self::doSelectOne($c);
    }
}
