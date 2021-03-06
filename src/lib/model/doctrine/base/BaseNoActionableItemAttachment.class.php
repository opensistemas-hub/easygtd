<?php

/**
 * BaseNoActionableItemAttachment
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property varchar $value
 * @property integer $no_actionable_item_id
 * @property NoActionableItem $NoActionableItem
 * 
 * @method integer                    getId()                    Returns the current record's "id" value
 * @method varchar                    getValue()                 Returns the current record's "value" value
 * @method integer                    getNoActionableItemId()    Returns the current record's "no_actionable_item_id" value
 * @method NoActionableItem           getNoActionableItem()      Returns the current record's "NoActionableItem" value
 * @method NoActionableItemAttachment setId()                    Sets the current record's "id" value
 * @method NoActionableItemAttachment setValue()                 Sets the current record's "value" value
 * @method NoActionableItemAttachment setNoActionableItemId()    Sets the current record's "no_actionable_item_id" value
 * @method NoActionableItemAttachment setNoActionableItem()      Sets the current record's "NoActionableItem" value
 * 
 * @package    EasyGtd
 * @subpackage model
 * @author     leobarrientosc
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseNoActionableItemAttachment extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('no_actionable_item_attachment');
        $this->hasColumn('id', 'integer', 20, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '20',
             ));
        $this->hasColumn('value', 'varchar', 255, array(
             'type' => 'varchar',
             'notnull' => true,
             'length' => '255',
             ));
        $this->hasColumn('no_actionable_item_id', 'integer', 20, array(
             'type' => 'integer',
             'notnull' => true,
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

        $timestampable0 = new Doctrine_Template_Timestampable();
        $sluggable0 = new Doctrine_Template_Sluggable(array(
             'fields' => 
             array(
              0 => 'value',
             ),
             'name' => 'normalized_value',
             'type' => 'string',
             'length' => 255,
             ));
        $this->actAs($timestampable0);
        $this->actAs($sluggable0);
    }
}