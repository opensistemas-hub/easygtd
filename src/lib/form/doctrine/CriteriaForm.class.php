<?php

/**
 * Criteria form.
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CriteriaForm extends BaseCriteriaForm
{
  public function configure()
  {
      $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('criteria_form');

      $this->setWidgets(array(
      'id'      => new sfWidgetFormInputHidden(),
      'value'   => new sfWidgetFormInputText(array(), array('maxlength' =>40)),
      'type'    => new sfWidgetFormChoice(array('label'=>'Criteria','choices'=>array('CONTEXT'=>'Context','ENERGY'=>'Energy','TIME_AVAILABLE'=>'Time','PRIORITY'=>'Priority'))),
      'unit'    => new sfWidgetFormChoice(array('choices'=>array('NULL'=>'--','MINUTES'=>'MINUTES','HOURS'=>'HOURS','POMODOROS'=>'POMODOROS'))),
      'user_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'id'      => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'value'   => new sfValidatorAnd(array(
                                            new sfValidatorString(array('max_length' => 120)),
                                            new sfValidatorRegex(array('pattern' => '/^NONE$/', 'must_match' => false),
	    		                                         array('invalid' => 'Invalid name - The word NONE is reserved'))
                                            )),
      'unit'    => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'type'    => new sfValidatorString(array('max_length' => 30)),
      'user_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('sfGuardUser'))),
    ));

    $this->widgetSchema->setNameFormat('criteria[%s]');
  }
}
