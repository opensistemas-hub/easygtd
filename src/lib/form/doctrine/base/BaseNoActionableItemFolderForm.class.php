<?php

/**
 * NoActionableItemFolder form base class.
 *
 * @method NoActionableItemFolder getObject() Returns the current form's model object
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseNoActionableItemFolderForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'no_actionable_item_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('NoActionableItem'), 'add_empty' => false)),
      'folder_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Folder'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'no_actionable_item_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('NoActionableItem'))),
      'folder_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Folder'))),
    ));

    $this->widgetSchema->setNameFormat('no_actionable_item_folder[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'NoActionableItemFolder';
  }

}
