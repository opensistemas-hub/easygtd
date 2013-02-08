<?php

/**
 * BaseStuffState
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property varchar $name
 * @property Doctrine_Collection $Stuffs
 * 
 * @method integer             getId()     Returns the current record's "id" value
 * @method varchar             getName()   Returns the current record's "name" value
 * @method Doctrine_Collection getStuffs() Returns the current record's "Stuffs" collection
 * @method StuffState          setId()     Sets the current record's "id" value
 * @method StuffState          setName()   Sets the current record's "name" value
 * @method StuffState          setStuffs() Sets the current record's "Stuffs" collection
 * 
 * @package    EasyGtd
 * @subpackage model
 * @author     leobarrientosc
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseStuffState extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('stuff_state');
        $this->hasColumn('id', 'integer', 20, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '20',
             ));
        $this->hasColumn('name', 'varchar', 50, array(
             'type' => 'varchar',
             'notnull' => true,
             'length' => '50',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Stuff as Stuffs', array(
             'local' => 'id',
             'foreign' => 'stuff_state_id'));
    }
}