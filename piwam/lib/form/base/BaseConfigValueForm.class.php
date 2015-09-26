<?php

/**
 * ConfigValue form base class.
 *
 * @package    piwam
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseConfigValueForm extends BaseFormPropel
{
    public function setup()
    {
        $this->setWidgets(array(
      'config_variable_id' => new sfWidgetFormInputHidden(),
      'association_id'     => new sfWidgetFormInputHidden(),
      'custom_value'       => new sfWidgetFormInput(),
        ));

        $this->setValidators(array(
      'config_variable_id' => new sfValidatorPropelChoice(array('model' => 'ConfigVariable', 'column' => 'id', 'required' => false)),
      'association_id'     => new sfValidatorPropelChoice(array('model' => 'Association', 'column' => 'id', 'required' => false)),
      'custom_value'       => new sfValidatorString(array('max_length' => 255)),
        ));

        $this->widgetSchema->setNameFormat('config_value[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        parent::setup();
    }

    public function getModelName()
    {
        return 'ConfigValue';
    }


}
