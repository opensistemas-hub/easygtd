<?php

/**
 * BaseActionProject
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $project_id
 * 
 * @method integer       getId()         Returns the current record's "id" value
 * @method integer       getProjectId()  Returns the current record's "project_id" value
 * @method ActionProject setId()         Sets the current record's "id" value
 * @method ActionProject setProjectId()  Sets the current record's "project_id" value
 * 
 * @package    EasyGtd
 * @subpackage model
 * @author     leobarrientosc
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseActionProject extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('action_project');
        $this->hasColumn('id', 'integer', 20, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '20',
             ));
        $this->hasColumn('project_id', 'integer', 20, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => '20',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}