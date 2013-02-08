<?php
class settingsForm extends sfForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'name'   => new sfWidgetFormInputText(array('label'=>'What is your name?')),
      'password' => new sfWidgetFormInputPassword(array('label'=>'Password')),
      'password_2' => new sfWidgetFormInputPassword(array('label'=>'Repeat password')),
      'server_name' => new sfWidgetFormInputText(array('label'=>'Server')),
      'username_server'=> new sfWidgetFormInputText(array('label'=>'Username')),
      'password_server'=> new sfWidgetFormInputPassword(array('label'=>'Password')),
      'tipo'=>new sfWidgetFormSelect(array('choices'=>array('POP3','IMAP'))),

    ));

     $this->setValidators(array(
      
      'name' => new sfValidatorString(array(),array('required'=>'the_name_is_required')),

    ));

    $this->widgetSchema->setNameFormat('show_settings[%s]');

  }
}
?>
