<?php

/**
 * Projects form base class.
 *
 * @method Projects getObject() Returns the current form's model object
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseProjectsForm extends IndexSearchForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('projects[%s]');
  }

  public function getModelName()
  {
    return 'Projects';
  }

}
