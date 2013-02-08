<?php

/**
 * NoActionableItemAttachment form base class.
 *
 * @method NoActionableItemAttachment getObject() Returns the current form's model object
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseNoActionableItemAttachmentForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'value'                 => new sfWidgetFormInputText(),
      'no_actionable_item_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('NoActionableItem'), 'add_empty' => false)),
      'created_at'            => new sfWidgetFormDateTime(),
      'updated_at'            => new sfWidgetFormDateTime(),
      'normalized_value'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'value'                 => new sfValidatorPass(),
      'no_actionable_item_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('NoActionableItem'))),
      'created_at'            => new sfValidatorDateTime(),
      'updated_at'            => new sfValidatorDateTime(),
      'normalized_value'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'NoActionableItemAttachment', 'column' => array('normalized_value')))
    );

    $this->widgetSchema->setNameFormat('no_actionable_item_attachment[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'NoActionableItemAttachment';
  }

}
