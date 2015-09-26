<?php

/**
 * ConfigVariable form base class.
 *
 * @package    piwam
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseConfigVariableForm extends BaseFormPropel
{
    public function setup()
    {
        $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'code'              => new sfWidgetFormInput(),
      'categorie_code'    => new sfWidgetFormPropelChoice(array('model' => 'ConfigCategorie', 'add_empty' => false)),
      'libelle'           => new sfWidgetFormInput(),
      'description'       => new sfWidgetFormTextarea(),
      'type'              => new sfWidgetFormInput(),
      'default_value'     => new sfWidgetFormInput(),
      'config_value_list' => new sfWidgetFormPropelChoiceMany(array('model' => 'Association')),
        ));

        $this->setValidators(array(
      'id'                => new sfValidatorPropelChoice(array('model' => 'ConfigVariable', 'column' => 'id', 'required' => false)),
      'code'              => new sfValidatorString(array('max_length' => 20)),
      'categorie_code'    => new sfValidatorPropelChoice(array('model' => 'ConfigCategorie', 'column' => 'code')),
      'libelle'           => new sfValidatorString(array('max_length' => 255)),
      'description'       => new sfValidatorString(array('required' => false)),
      'type'              => new sfValidatorString(array('max_length' => 255)),
      'default_value'     => new sfValidatorString(array('max_length' => 255)),
      'config_value_list' => new sfValidatorPropelChoiceMany(array('model' => 'Association', 'required' => false)),
        ));

        $this->widgetSchema->setNameFormat('config_variable[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        parent::setup();
    }

    public function getModelName()
    {
        return 'ConfigVariable';
    }


    public function updateDefaultsFromObject()
    {
        parent::updateDefaultsFromObject();

        if (isset($this->widgetSchema['config_value_list']))
        {
            $values = array();
            foreach ($this->object->getConfigValues() as $obj)
            {
                $values[] = $obj->getAssociationId();
            }

            $this->setDefault('config_value_list', $values);
        }

    }

    protected function doSave($con = null)
    {
        parent::doSave($con);

        $this->saveConfigValueList($con);
    }

    public function saveConfigValueList($con = null)
    {
        if (!$this->isValid())
        {
            throw $this->getErrorSchema();
        }

        if (!isset($this->widgetSchema['config_value_list']))
        {
            // somebody has unset this widget
            return;
        }

        if (is_null($con))
        {
            $con = $this->getConnection();
        }

        $c = new Criteria();
        $c->add(ConfigValuePeer::CONFIG_VARIABLE_ID, $this->object->getPrimaryKey());
        ConfigValuePeer::doDelete($c, $con);

        $values = $this->getValue('config_value_list');
        if (is_array($values))
        {
            foreach ($values as $value)
            {
                $obj = new ConfigValue();
                $obj->setConfigVariableId($this->object->getPrimaryKey());
                $obj->setAssociationId($value);
                $obj->save();
            }
        }
    }

}
