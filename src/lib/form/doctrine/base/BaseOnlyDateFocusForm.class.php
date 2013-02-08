<?php

/**
 * OnlyDateFocus form base class.
 *
 * @method OnlyDateFocus getObject() Returns the current form's model object
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseOnlyDateFocusForm extends SavedSearchInfoForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('only_date_focus[%s]');
  }

  public function getModelName()
  {
    return 'OnlyDateFocus';
  }

}
