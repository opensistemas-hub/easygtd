<?php

/**
 * TicklerDate filter form base class.
 *
 * @package    EasyGtd
 * @subpackage filter
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseTicklerDateFormFilter extends NoActionableItemInfoFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('tickler_date_filters[%s]');
  }

  public function getModelName()
  {
    return 'TicklerDate';
  }
}
