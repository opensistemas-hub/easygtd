<?php

/**
 * NextActionCriteria filter form base class.
 *
 * @package    EasyGtd
 * @subpackage filter
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseNextActionCriteriaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'next_action_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('NextAction'), 'add_empty' => true)),
      'criteria_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Criteria'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'next_action_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('NextAction'), 'column' => 'id')),
      'criteria_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Criteria'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('next_action_criteria_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'NextActionCriteria';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'next_action_id' => 'ForeignKey',
      'criteria_id'    => 'ForeignKey',
    );
  }
}
