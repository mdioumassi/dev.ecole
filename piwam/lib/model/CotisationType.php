<?php

class CotisationType extends BaseCotisationType
{
    /**
     * Convert the object as a string
     *
     * @return 	string
     * @since	r6
     */
    public function __toString()
    {
        return $this->getLibelle();
    }
}
