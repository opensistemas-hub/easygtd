<?php

/**
 * FollowUpTime form base class.
 *
 * @method FollowUpTime getObject() Returns the current form's model object
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseFollowUpTimeForm extends NextActionInfoForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('follow_up_time[%s]');
  }

  public function getModelName()
  {
    return 'FollowUpTime';
  }

}
