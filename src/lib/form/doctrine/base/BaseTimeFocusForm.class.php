<?php

/**
 * TimeFocus form base class.
 *
 * @method TimeFocus getObject() Returns the current form's model object
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseTimeFocusForm extends SavedSearchInfoForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('time_focus[%s]');
  }

  public function getModelName()
  {
    return 'TimeFocus';
  }

}
