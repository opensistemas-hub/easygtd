<?php

/**
 * Project form base class.
 *
 * @method Project getObject() Returns the current form's model object
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
class ProjectForm extends BaseProjectForm
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'name'             => new sfWidgetFormInputText(),
      'description'      => new sfWidgetFormInputText(),
      'purpose'          => new sfWidgetFormInputText(),
      'vision'           => new sfWidgetFormInputText(),
      'brainstorming'    => new sfWidgetFormInputText(),
      'project_state_id' => new sfWidgetFormInputHidden(),
      'user_id'          => new sfWidgetFormInputHidden(),
      'created_at'       => new sfWidgetFormInputHidden(),
      'updated_at'       => new sfWidgetFormInputHidden(),
      'normalized_name'  => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'name'             => new sfValidatorPass(),
      'description'      => new sfValidatorPass(),
      'purpose'          => new sfValidatorPass(),
      'vision'           => new sfValidatorPass(),
      'brainstorming'    => new sfValidatorPass(),
      'project_state_id' => new sfValidatorPass(),
      'user_id'          => new sfValidatorPass(),
      'created_at'       => new sfValidatorPass(),
      'updated_at'       => new sfValidatorPass(),
      'normalized_name'  => new sfValidatorPass(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Project', 'column' => array('normalized_name')))
    );

    $this->widgetSchema->setNameFormat('project[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::configure();
  }

  public function getModelName()
  {
    return 'Project';
  }

}
