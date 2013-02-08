<?php
class AlertForm extends sfForm
{
  public function configure()
  {
      $this->disableLocalCSRFProtection();

     $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'email'         => new sfWidgetFormInputText(array('label'=>'Email')),

    ));
    $this->widgetSchema->setNameFormat('alert_configuration[%s]');
    $this->setValidators(array(
      'id'           => new sfValidatorPass(),
      'email' => new sfValidatorEmail(array(),array('required'=>'the_email_is_required','invalid'=>'this_email_is_not_valid')),

    ));


    
}
}
