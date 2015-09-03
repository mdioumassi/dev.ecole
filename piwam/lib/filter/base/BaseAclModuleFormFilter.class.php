<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * AclModule filter form base class.
 *
 * @package    piwam
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseAclModuleFormFilter extends BaseFormFilterPropel
{
    public function setup()
    {
        $this->setWidgets(array(
      'libelle' => new sfWidgetFormFilterInput(),
        ));

        $this->setValidators(array(
      'libelle' => new sfValidatorPass(array('required' => false)),
        ));

        $this->widgetSchema->setNameFormat('acl_module_filters[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        parent::setup();
    }

    public function getModelName()
    {
        return 'AclModule';
    }

    public function getFields()
    {
        return array(
      'id'      => 'Number',
      'libelle' => 'Text',
        );
    }
}
