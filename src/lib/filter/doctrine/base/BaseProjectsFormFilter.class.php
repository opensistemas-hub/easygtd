<?php

/**
 * Projects filter form base class.
 *
 * @package    EasyGtd
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseProjectsFormFilter extends IndexSearchFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('projects_filters[%s]');
  }

  public function getModelName()
  {
    return 'Projects';
  }
}
