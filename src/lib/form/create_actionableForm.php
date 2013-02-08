<?php
class CreateActionableForm extends sfForm
{
     
  public function configure()
  {
    $this->disableLocalCSRFProtection();
    $this->setWidgets(array(
      'name'   => new sfWidgetFormInputText(array('label'=>'Name')),
      'description'   => new sfWidgetFormTextarea(array('label'=>'Description')),
      'delegate_to'   => new sfWidgetFormInputText(array('label'=>'Delegate')),      

    ));
     $this->widgetSchema->setNameFormat('create_criteria[%s]');
     $this->setValidators(array(
      'name'         => new sfValidatorString(array(),array('required'=>'the_name_is_required')),
      'description' => new sfValidatorPass(),
    ));

  }
}
?>
