<?php

/**
 * NextActionInfo form base class.
 *
 * @method NextActionInfo getObject() Returns the current form's model object
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseNextActionInfoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'next_action_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('NextAction'), 'add_empty' => false)),
      'value'          => new sfWidgetFormInputText(),
      'type'           => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'next_action_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('NextAction'))),
      'value'          => new sfValidatorString(array('max_length' => 120, 'required' => false)),
      'type'           => new sfValidatorPass(),
    ));

    $this->widgetSchema->setNameFormat('next_action_info[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'NextActionInfo';
  }

}
