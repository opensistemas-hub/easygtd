<?php

/**
 * BaseNoActionableItemProject
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $no_actionable_item_id
 * @property NoActionableItem $NoActionableItem
 * @property Project $Project
 * 
 * @method integer                 getNoActionableItemId()    Returns the current record's "no_actionable_item_id" value
 * @method NoActionableItem        getNoActionableItem()      Returns the current record's "NoActionableItem" value
 * @method Project                 getProject()               Returns the current record's "Project" value
 * @method NoActionableItemProject setNoActionableItemId()    Sets the current record's "no_actionable_item_id" value
 * @method NoActionableItemProject setNoActionableItem()      Sets the current record's "NoActionableItem" value
 * @method NoActionableItemProject setProject()               Sets the current record's "Project" value
 * 
 * @package    EasyGtd
 * @subpackage model
 * @author     leobarrientosc
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseNoActionableItemProject extends ActionProject
{
    public function setTableDefinition()
    {
        parent::setTableDefinition();
        $this->setTableName('no_actionable_item_project');
        $this->hasColumn('no_actionable_item_id', 'integer', 20, array(
             'type' => 'integer',
             'length' => '20',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('NoActionableItem', array(
             'local' => 'no_actionable_item_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Project', array(
             'local' => 'project_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}