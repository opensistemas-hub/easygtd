<?php

/**
 * ToDoInDateEnd form base class.
 *
 * @method ToDoInDateEnd getObject() Returns the current form's model object
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseToDoInDateEndForm extends NextActionInfoForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('to_do_in_date_end[%s]');
  }

  public function getModelName()
  {
    return 'ToDoInDateEnd';
  }

}
