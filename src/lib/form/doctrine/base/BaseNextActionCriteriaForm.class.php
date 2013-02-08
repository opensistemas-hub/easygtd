<?php

/**
 * NextActionCriteria form base class.
 *
 * @method NextActionCriteria getObject() Returns the current form's model object
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseNextActionCriteriaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'next_action_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('NextAction'), 'add_empty' => false)),
      'criteria_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Criteria'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'next_action_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('NextAction'))),
      'criteria_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Criteria'))),
    ));

    $this->widgetSchema->setNameFormat('next_action_criteria[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'NextActionCriteria';
  }

}
