<?php
/**
 * Configure some parameters for the front application
 *
 * @author adrien
 */
class frontConfiguration extends sfApplicationConfiguration
{
    /**
     * Configure global constants and messages
     *
     * @see lib/vendor/symfony/1.2/lib/config/sfApplicationConfiguration#configure()
     */
	public function configure()
	{
		// Represents the states of `actif` fields
		define('ENABLED',		1);
		define('DISABLED',		0);

		// Symbol which is used as CSV separator when exporting files
		define('CSV_SEPARATOR',	',');

		// Define error messages for required/invalid fields
		sfValidatorBase::setRequiredMessage('Requis');
		sfValidatorBase::setInvalidMessage('Invalide');
	}
}
