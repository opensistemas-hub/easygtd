<?php

/**
 * FollowUpDate form base class.
 *
 * @method FollowUpDate getObject() Returns the current form's model object
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseFollowUpDateForm extends NextActionInfoForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('follow_up_date[%s]');
  }

  public function getModelName()
  {
    return 'FollowUpDate';
  }

}
