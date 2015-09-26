<?php

require_once dirname(__FILE__) . '/../lib/vendor/symfony/1.2/lib/autoload/sfCoreAutoload.class.php';

sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
    public function setup()
    {
        /*
         * Configuration
         * -------------
         * If you want to set your own /cache and /logs folders,
         * un comment the 2 following lines and set values with your owns
         */
        //$this->setCacheDir('/tmp/symfony_cache');
        //$this->setLogDir('/tmp/symfony_logs');

        // End of editable area. Do NOT edit following lines

        // for compatibility / remove and enable only the plugins you want
        $this->enableAllPluginsExcept(array('sfDoctrinePlugin', 'sfCompat10Plugin'));
    }
}
