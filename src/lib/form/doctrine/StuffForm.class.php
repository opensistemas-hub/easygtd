<?php

/**
 * Stuff form.
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class StuffForm extends BaseStuffForm
{
  public function configure()
  {
  
    $this->disableLocalCSRFProtection();

    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'name'            => new sfWidgetFormInputText(array('label' => 'What is in your head?')),
      'description'     => new sfWidgetFormTextArea(),
      'user_id'         => new sfWidgetFormInputHidden(),
      'stuff_state_id'  => new sfWidgetFormInputHidden(),
      'created_at'      => new sfWidgetFormInputHidden(),
      'updated_at'      => new sfWidgetFormInputHidden(),
      'normalized_name' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'name'            => new sfValidatorString(array('max_length' => 255, 'required' => true),array('required'=>'The name is required.')),
      'description'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
     // 'user_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'))),
      'user_id'         => new sfValidatorPass(),
      'stuff_state_id'  => new sfValidatorPass(),
      'created_at'      => new sfValidatorPass(),
      'updated_at'      => new sfValidatorPass(),
      'normalized_name' => new sfValidatorPass(),
    ));

    $this->widgetSchema->setNameFormat('stuff[%s]');
  }
}
