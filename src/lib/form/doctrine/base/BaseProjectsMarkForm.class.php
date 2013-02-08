<?php

/**
 * ProjectsMark form base class.
 *
 * @method ProjectsMark getObject() Returns the current form's model object
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseProjectsMarkForm extends BookmarkForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('projects_mark[%s]');
  }

  public function getModelName()
  {
    return 'ProjectsMark';
  }

}
