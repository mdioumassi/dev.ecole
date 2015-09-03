<?php

class AclCredential extends BaseAclCredential
{
    /**
     * Get the code corresponding to the current credential
     *
     * @return  string
     * @since   r61
     */
    public function getCode()
    {
        return $this->getAclAction()->getCode();
    }

    /**
     * Get the module which this credential is linked to
     *
     * @return  integer
     * @since   r61
     */
    public function getModuleId()
    {
        return $this->getAclAction()->getAclModuleId();
    }
}
