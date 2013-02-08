<?php

/**
 * PriorityFocus form base class.
 *
 * @method PriorityFocus getObject() Returns the current form's model object
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BasePriorityFocusForm extends SavedSearchInfoForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('priority_focus[%s]');
  }

  public function getModelName()
  {
    return 'PriorityFocus';
  }

}
