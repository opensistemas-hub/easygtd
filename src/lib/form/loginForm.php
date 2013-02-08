<?php
class loginForm extends sfForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'email'   => new sfWidgetFormInputText(array('label'=>'Email')),
      'password' => new sfWidgetFormInputPassword(array('label'=>'Password')),

    ));

  }
}
?>
