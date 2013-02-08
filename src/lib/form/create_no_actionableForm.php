<?php
class CreateNoActionableForm extends sfForm
{
     
  public function configure()
  {
      $this->disableLocalCSRFProtection();
    $this->setWidgets(array(
      'date'   => new sfWidgetFormInputHidden(array('label'=>'date')),
      

    ));
    
    //si se habilita el validador de fecha aqui, solo ingresa fecha actual 
     $this->widgetSchema->setNameFormat('create_no_actionable[%s]');
     $this->setValidators(array(
       'date' => new sfValidatorPass(),
    ));

  }
}
?>
