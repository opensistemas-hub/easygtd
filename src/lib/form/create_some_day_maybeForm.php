<?php
class CreateSomeDayMaybeForm extends sfForm
{
     
  public function configure()
  {
    $this->disableLocalCSRFProtection();
    $this->setWidgets(array(

      'calendar'   => new sfWidgetFormInputText(array('label'=>'Calendar')),

      

    ));
     $this->widgetSchema->setNameFormat('create_some_day_maybe[%s]');
     $this->setValidators(array(

      'calendar' => new sfValidatorPass(),



    ));

  }
}
?>
