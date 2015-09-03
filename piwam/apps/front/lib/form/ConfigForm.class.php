<?php
/**
 * Allows to edit Piwam's configuration, for a specific association
 *
 * @since   r75
 */
class ConfigForm extends sfForm
{
    /*
     * Store the description for each field if exists
     * Associative array 'code => description'
     */
    private $_descriptions = array();

    /**
     * Set the different widgets and validators
     *
     */
    public function configure()
    {
        $categories = ConfigCategoriePeer::doSelect(new Criteria());
        foreach ($categories as $category)
        {
            $variables = ConfigVariablePeer::doSelectByCategorieCode($category->getCode());
            foreach ($variables as $variable)
            {
                $this->widgetSchema[$variable->getCode()] = $this->getWidgetForType($variable->getType());
                $this->widgetSchema->setLabel($variable->getCode(), $variable->getLibelle());
                if ($variable->getDescription()) {
                    $this->_descriptions[$variable->getCode()] = $variable->getDescription();
                }

                $associationId  = sfContext::getInstance()->getUser()->getAttribute('association_id', null, 'user');
                $defaultValue   = Configurator::get($variable->getCode(), $associationId);
                $this->setDefault($variable->getCode(), $defaultValue);
            }
        }
        $this->widgetSchema->setNameFormat('config[%s]');
    }

    /**
     * Get the description which is stored in private array
     *
     * @param   string  $widget_code
     * @return  Mixed   False if none, description as string otherwise
     */
    public function getDescription($widget_code)
    {
        if (array_key_exists($widget_code, $this->_descriptions)) {
            return $this->_descriptions[$widget_code];
        }
        else {
            return false;
        }
    }

    /**
     * Manage the different type we can find in database
     *
     * @param   string  $type
     * @return  sfWidget
     * @throw   Exception if $type is empty
     */
    protected function getWidgetForType($type)
    {
        if ($type == '') {
            throw new Exception('Empty type');
        }
        if ($type[0] == '{') {
            $choices = $this->parseChoices($type);
            return new sfWidgetFormChoice(array('choices' => $choices), array('class'=>'formInputNormal'));
        }
        if ($type == 'VARCHAR') {
            return new sfWidgetFormInput(array(), array('class'=>'formInputNormal'));
        }
        if ($type == 'INTEGER') {
            return new sfWidgetFormInput(array(), array('class'=>'formInputShort'));
        }
        if ($type == 'EMAIL') {
            return new sfWidgetFormInput(array(), array('class'=>'formInputNormal'));
        }


        throw new Exception('No associated widget for type : ' . $type);
    }

    /*
     * Parse string representing list of choices. This list must be follow this
     * syntax :
     *
     *      {choice1,choice2,choiceX}
     *
     * @param   string  $choices
     * @return  array
     */
    protected function parseChoices($choices)
    {
        if ($choices[0] != '{' || $choices[strlen($choices) - 1] != '}') {
            throw new Exception('Invalid choices string : ' . $choices);
        }

        $result     = array();
        $choices    = explode(',', trim($choices, '{}'));

        foreach ($choices as $choice) {
            $result[$choice] = $choice;
        }

        return $result;
    }
}
?>