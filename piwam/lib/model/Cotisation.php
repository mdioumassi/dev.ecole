<?php

class Cotisation extends BaseCotisation
{
    /**
     * Indicates the number of years of validity of the payment
     *
     * @return  integer
     * @since   r1
     */
    public function getValidity()
    {
        return $this->getCotisationType()->getValide();
    }

    /**
     * Get the association that this current Cotisation belongs to
     *
     * @return  integer
     * @since   r81
     */
    public function getAssociationId()
    {
        return $this->getCotisationType()->getAssociationId();
    }
}
