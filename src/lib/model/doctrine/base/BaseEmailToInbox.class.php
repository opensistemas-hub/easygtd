<?php

/**
 * BaseEmailToInbox
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property varchar $value
 * @property integer $user_id
 * @property sfGuardUser $sfGuardUser
 * 
 * @method varchar      getValue()       Returns the current record's "value" value
 * @method integer      getUserId()      Returns the current record's "user_id" value
 * @method sfGuardUser  getSfGuardUser() Returns the current record's "sfGuardUser" value
 * @method EmailToInbox setValue()       Sets the current record's "value" value
 * @method EmailToInbox setUserId()      Sets the current record's "user_id" value
 * @method EmailToInbox setSfGuardUser() Sets the current record's "sfGuardUser" value
 * 
 * @package    EasyGtd
 * @subpackage model
 * @author     leobarrientosc
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseEmailToInbox extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('email_to_inbox');
        $this->hasColumn('value', 'varchar', 255, array(
             'type' => 'varchar',
             'notnull' => false,
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
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}