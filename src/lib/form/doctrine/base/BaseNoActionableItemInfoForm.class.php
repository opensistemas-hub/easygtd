<?php

/**
 * NoActionableItemInfo form base class.
 *
 * @method NoActionableItemInfo getObject() Returns the current form's model object
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseNoActionableItemInfoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'no_actionable_item_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('NoActionableItem'), 'add_empty' => false)),
      'value'                 => new sfWidgetFormInputText(),
      'type'                  => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'no_actionable_item_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('NoActionableItem'))),
      'value'                 => new sfValidatorString(array('max_length' => 120, 'required' => false)),
      'type'                  => new sfValidatorString(array('max_length' => 30)),
    ));

    $this->widgetSchema->setNameFormat('no_actionable_item_info[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'NoActionableItemInfo';
  }

}
