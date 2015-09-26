<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * ConfigValue filter form base class.
 *
 * @package    piwam
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseConfigValueFormFilter extends BaseFormFilterPropel
{
    public function setup()
    {
        $this->setWidgets(array(
      'custom_value'       => new sfWidgetFormFilterInput(),
        ));

        $this->setValidators(array(
      'custom_value'       => new sfValidatorPass(array('required' => false)),
        ));

        $this->widgetSchema->setNameFormat('config_value_filters[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        parent::setup();
    }

    public function getModelName()
    {
        return 'ConfigValue';
    }

    public function getFields()
    {
        return array(
      'config_variable_id' => 'ForeignKey',
      'association_id'     => 'ForeignKey',
      'custom_value'       => 'Text',
        );
    }
}
