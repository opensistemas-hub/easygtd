<?php
class editStuffForm extends sfForm
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
    $this->widgetSchema->setNameFormat('edit_stuff[%s]');
    $this->setValidators(array(
      'id'           => new sfValidatorPass(),
      'name'         => new sfValidatorString(array(),array('required'=>'the_name_is_required')),
      'description' => new sfValidatorPass(),
      //'stuff_attachments' => new sfValidatorFile(array('required' => true, 'max_size' => '20971520' )),



    ));



}
}
