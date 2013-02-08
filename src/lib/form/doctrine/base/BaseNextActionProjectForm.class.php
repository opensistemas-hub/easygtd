<?php

/**
 * NextActionProject form base class.
 *
 * @method NextActionProject getObject() Returns the current form's model object
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseNextActionProjectForm extends ActionProjectForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['next_action_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('NextAction'), 'add_empty' => true));
    $this->validatorSchema['next_action_id'] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('NextAction'), 'required' => false));

    $this->widgetSchema->setNameFormat('next_action_project[%s]');
  }

  public function getModelName()
  {
    return 'NextActionProject';
  }

}
