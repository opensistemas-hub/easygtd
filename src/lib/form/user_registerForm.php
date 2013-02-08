<?php
class UserRegisterForm extends sfForm
{
  public function configure()
  {
      $this->disableLocalCSRFProtection();

     $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'name'         => new sfWidgetFormInputText(array('label'=>'Name')),
      'email' => new sfWidgetFormInputText(array('label'=>'Email')),
      'password'     => new sfWidgetFormInputPassword(array('label'=>'Password')),
      'repeat_password' => new sfWidgetFormInputPassword(array('label'=>'Repeat Password')),
     
    ));
    $this->widgetSchema->setNameFormat('show_register[%s]');
    $this->setValidators(array(
      'id'           => new sfValidatorPass(),
      'name'         => new sfValidatorString(array(),array('required'=>'The name is required')),
      'email' => new sfValidatorEmail(array(),array('required'=>'The email is required','invalid'=>'this email is not valid')),
      'password'     => new sfValidatorString(array(),array('required'=>'The password is required')),
      'repeat_password' =>new sfValidatorString(array(),array('required'=>'The confirm password is required')),
      
    ));


    $this->validatorSchema->setPostValidator(new sfValidatorAnd(array(
	  new sfValidatorSchemaCompare('password', '==', 'repeat_password',
		    array(),
		    array('invalid' => 'Passwords do not match')
		  ),
	    )));
}
}
