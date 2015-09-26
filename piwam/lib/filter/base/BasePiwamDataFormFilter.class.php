<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * PiwamData filter form base class.
 *
 * @package    piwam
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BasePiwamDataFormFilter extends BaseFormFilterPropel
{
    public function setup()
    {
        $this->setWidgets(array(
      'key'   => new sfWidgetFormFilterInput(),
      'value' => new sfWidgetFormFilterInput(),
        ));

        $this->setValidators(array(
      'key'   => new sfValidatorPass(array('required' => false)),
      'value' => new sfValidatorPass(array('required' => false)),
        ));

        $this->widgetSchema->setNameFormat('piwam_data_filters[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        parent::setup();
    }

    public function getModelName()
    {
        return 'PiwamData';
    }

    public function getFields()
    {
        return array(
      'id'    => 'Number',
      'key'   => 'Text',
      'value' => 'Text',
        );
    }
}
