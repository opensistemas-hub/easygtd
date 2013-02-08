<?php

/**
 * BaseFolder
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property integer $user_id
 * @property sfGuardUser $sfGuardUser
 * @property Doctrine_Collection $FolderNoActionables
 * 
 * @method integer             getId()                  Returns the current record's "id" value
 * @method string              getName()                Returns the current record's "name" value
 * @method integer             getUserId()              Returns the current record's "user_id" value
 * @method sfGuardUser         getSfGuardUser()         Returns the current record's "sfGuardUser" value
 * @method Doctrine_Collection getFolderNoActionables() Returns the current record's "FolderNoActionables" collection
 * @method Folder              setId()                  Sets the current record's "id" value
 * @method Folder              setName()                Sets the current record's "name" value
 * @method Folder              setUserId()              Sets the current record's "user_id" value
 * @method Folder              setSfGuardUser()         Sets the current record's "sfGuardUser" value
 * @method Folder              setFolderNoActionables() Sets the current record's "FolderNoActionables" collection
 * 
 * @package    EasyGtd
 * @subpackage model
 * @author     leobarrientosc
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseFolder extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('folder');
        $this->hasColumn('id', 'integer', 20, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '20',
             ));
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '255',
             ));
        $this->hasColumn('user_id', 'integer', 20, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => '20',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('sfGuardUser', array(
             'local' => 'user_id',
             'foreign' => 'id'));

        $this->hasMany('NoActionableItemFolder as FolderNoActionables', array(
             'local' => 'id',
             'foreign' => 'folder_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $sluggable0 = new Doctrine_Template_Sluggable(array(
             'fields' => 
             array(
              0 => 'id',
              1 => 'name',
             ),
             'name' => 'normalized_name',
             'type' => 'string',
             'length' => 255,
             ));
        $this->actAs($timestampable0);
        $this->actAs($sluggable0);
    }
}