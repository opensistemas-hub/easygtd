<?php

/**
 * SomeDayMaybe filter form base class.
 *
 * @package    EasyGtd
 * @subpackage filter
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseSomeDayMaybeFormFilter extends NoActionableItemFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('some_day_maybe_filters[%s]');
  }

  public function getModelName()
  {
    return 'SomeDayMaybe';
  }
}
