<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * AclAction filter form base class.
 *
 * @package    piwam
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseAclActionFormFilter extends BaseFormFilterPropel
{
    public function setup()
    {
        $this->setWidgets(array(
      'acl_module_id' => new sfWidgetFormPropelChoice(array('model' => 'AclModule', 'add_empty' => true)),
      'libelle'       => new sfWidgetFormFilterInput(),
      'code'          => new sfWidgetFormFilterInput(),
        ));

        $this->setValidators(array(
      'acl_module_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'AclModule', 'column' => 'id')),
      'libelle'       => new sfValidatorPass(array('required' => false)),
      'code'          => new sfValidatorPass(array('required' => false)),
        ));

        $this->widgetSchema->setNameFormat('acl_action_filters[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        parent::setup();
    }

    public function getModelName()
    {
        return 'AclAction';
    }

    public function getFields()
    {
        return array(
      'id'            => 'Number',
      'acl_module_id' => 'ForeignKey',
      'libelle'       => 'Text',
      'code'          => 'Text',
        );
    }
}
