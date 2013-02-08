<?php

/**
 * ToDoInDateStart form base class.
 *
 * @method ToDoInDateStart getObject() Returns the current form's model object
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseToDoInDateStartForm extends NextActionInfoForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('to_do_in_date_start[%s]');
  }

  public function getModelName()
  {
    return 'ToDoInDateStart';
  }

}
