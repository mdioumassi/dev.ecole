<?php

class AclCredentialPeer extends BaseAclCredentialPeer
{
    /**
     * Select AclCredentials for the Membre $id
     *
     * @param   integer $id
     * @return  array of AclCredential
     * @since   r60
     */
    public static function doSelectForMembreId($id)
    {
        $c = new Criteria();
        $c->add(self::MEMBRE_ID, $id);

        return self::doSelect($c);
    }

    /**
     * Delete AclCredentials for the Membre $id
     *
     * @param   integer $id
     * @return  array of AclCredential
     * @since   r60
     */
    public static function doDeleteForMembreId($id)
    {
        $c = new Criteria();
        $c->add(self::MEMBRE_ID, $id);

        self::doDelete($c);
    }
}
