<?php

/**
 * NextAction form base class.
 *
 * @method NextAction getObject() Returns the current form's model object
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseNextActionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'name'                 => new sfWidgetFormInputText(),
      'description'          => new sfWidgetFormInputText(),
      'next_action_state_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('NextActionState'), 'add_empty' => false)),
      'user_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('sfGuardUser'), 'add_empty' => false)),
      'type'                 => new sfWidgetFormInputText(),
      'hash'                 => new sfWidgetFormInputText(),
      'original'             => new sfWidgetFormInputText(),
      'created_at'           => new sfWidgetFormDateTime(),
      'updated_at'           => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'name'                 => new sfValidatorPass(),
      'description'          => new sfValidatorPass(array('required' => false)),
      'next_action_state_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('NextActionState'))),
      'user_id'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('sfGuardUser'))),
      'type'                 => new sfValidatorPass(),
      'hash'                 => new sfValidatorPass(),
      'original'             => new sfValidatorInteger(),
      'created_at'           => new sfValidatorDateTime(),
      'updated_at'           => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('next_action[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'NextAction';
  }

}
