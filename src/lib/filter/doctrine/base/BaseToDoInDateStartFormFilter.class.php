<?php

/**
 * ToDoInDateStart filter form base class.
 *
 * @package    EasyGtd
 * @subpackage filter
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseToDoInDateStartFormFilter extends NextActionInfoFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('to_do_in_date_start_filters[%s]');
  }

  public function getModelName()
  {
    return 'ToDoInDateStart';
  }
}
