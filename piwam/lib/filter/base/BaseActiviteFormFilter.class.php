<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Activite filter form base class.
 *
 * @package    piwam
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseActiviteFormFilter extends BaseFormFilterPropel
{
    public function setup()
    {
        $this->setWidgets(array(
      'libelle'        => new sfWidgetFormFilterInput(),
      'actif'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'association_id' => new sfWidgetFormPropelChoice(array('model' => 'Association', 'add_empty' => true)),
      'enregistre_par' => new sfWidgetFormPropelChoice(array('model' => 'Membre', 'add_empty' => true)),
      'mis_a_jour_par' => new sfWidgetFormPropelChoice(array('model' => 'Membre', 'add_empty' => true)),
      'created_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
        ));

        $this->setValidators(array(
      'libelle'        => new sfValidatorPass(array('required' => false)),
      'actif'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'association_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Association', 'column' => 'id')),
      'enregistre_par' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Membre', 'column' => 'id')),
      'mis_a_jour_par' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Membre', 'column' => 'id')),
      'created_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
        ));

        $this->widgetSchema->setNameFormat('activite_filters[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        parent::setup();
    }

    public function getModelName()
    {
        return 'Activite';
    }

    public function getFields()
    {
        return array(
      'id'             => 'Number',
      'libelle'        => 'Text',
      'actif'          => 'Boolean',
      'association_id' => 'ForeignKey',
      'enregistre_par' => 'ForeignKey',
      'mis_a_jour_par' => 'ForeignKey',
      'created_at'     => 'Date',
      'updated_at'     => 'Date',
        );
    }
}
