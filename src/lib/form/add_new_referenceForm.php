<?php
class AddNewReferenceForm extends sfForm
{
  public function configure()
  {
      $this->disableLocalCSRFProtection();

     $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'name'         => new sfWidgetFormInputText(array('label'=>'Name')),
      'description' => new sfWidgetFormTextarea(array('label'=>'Description')),
      //'stuff_attachments' => new sfWidgetFormInputFile(),
      

    ));
    $this->widgetSchema->setNameFormat('add_new_reference[%s]');
    $this->setValidators(array(
      'id'           => new sfValidatorPass(),
      'name'         => new sfValidatorString(array(),array('required'=>'the_name_is_required')),
      'description' => new sfValidatorPass(),
      //'stuff_attachments' => new sfValidatorFile(),
        
      

    ));


    
}
}
