<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Association filter form base class.
 *
 * @package    piwam
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseAssociationFormFilter extends BaseFormFilterPropel
{
    public function setup()
    {
        $this->setWidgets(array(
      'nom'               => new sfWidgetFormFilterInput(),
      'description'       => new sfWidgetFormFilterInput(),
      'site_web'          => new sfWidgetFormFilterInput(),
      'enregistre_par'    => new sfWidgetFormPropelChoice(array('model' => 'Membre', 'add_empty' => true)),
      'mis_a_jour_par'    => new sfWidgetFormPropelChoice(array('model' => 'Membre', 'add_empty' => true)),
      'created_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'config_value_list' => new sfWidgetFormPropelChoice(array('model' => 'ConfigVariable', 'add_empty' => true)),
        ));

        $this->setValidators(array(
      'nom'               => new sfValidatorPass(array('required' => false)),
      'description'       => new sfValidatorPass(array('required' => false)),
      'site_web'          => new sfValidatorPass(array('required' => false)),
      'enregistre_par'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Membre', 'column' => 'id')),
      'mis_a_jour_par'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Membre', 'column' => 'id')),
      'created_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'config_value_list' => new sfValidatorPropelChoice(array('model' => 'ConfigVariable', 'required' => false)),
        ));

        $this->widgetSchema->setNameFormat('association_filters[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        parent::setup();
    }

    public function addConfigValueListColumnCriteria(Criteria $criteria, $field, $values)
    {
        if (!is_array($values))
        {
            $values = array($values);
        }

        if (!count($values))
        {
            return;
        }

        $criteria->addJoin(ConfigValuePeer::ASSOCIATION_ID, AssociationPeer::ID);

        $value = array_pop($values);
        $criterion = $criteria->getNewCriterion(ConfigValuePeer::CONFIG_VARIABLE_ID, $value);

        foreach ($values as $value)
        {
            $criterion->addOr($criteria->getNewCriterion(ConfigValuePeer::CONFIG_VARIABLE_ID, $value));
        }

        $criteria->add($criterion);
    }

    public function getModelName()
    {
        return 'Association';
    }

    public function getFields()
    {
        return array(
      'id'                => 'Number',
      'nom'               => 'Text',
      'description'       => 'Text',
      'site_web'          => 'Text',
      'enregistre_par'    => 'ForeignKey',
      'mis_a_jour_par'    => 'ForeignKey',
      'created_at'        => 'Date',
      'updated_at'        => 'Date',
      'config_value_list' => 'ManyKey',
        );
    }
}
