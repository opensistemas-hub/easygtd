<?php

/**
 * BaseSavedSearchInfo
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $saved_search_id
 * @property string $value
 * @property varchar $type
 * @property SavedSearch $SavedSearch
 * 
 * @method integer         getSavedSearchId()   Returns the current record's "saved_search_id" value
 * @method string          getValue()           Returns the current record's "value" value
 * @method varchar         getType()            Returns the current record's "type" value
 * @method SavedSearch     getSavedSearch()     Returns the current record's "SavedSearch" value
 * @method SavedSearchInfo setSavedSearchId()   Sets the current record's "saved_search_id" value
 * @method SavedSearchInfo setValue()           Sets the current record's "value" value
 * @method SavedSearchInfo setType()            Sets the current record's "type" value
 * @method SavedSearchInfo setSavedSearch()     Sets the current record's "SavedSearch" value
 * 
 * @package    EasyGtd
 * @subpackage model
 * @author     leobarrientosc
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseSavedSearchInfo extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('saved_search_info');
        $this->hasColumn('saved_search_id', 'integer', 20, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => '20',
             ));
        $this->hasColumn('value', 'string', 120, array(
             'type' => 'string',
             'length' => '120',
             ));
        $this->hasColumn('type', 'varchar', 30, array(
             'type' => 'varchar',
             'notnull' => true,
             'length' => '30',
             ));

        $this->setSubClasses(array(
             'TypeFocus' => 
             array(
              'type' => 'TYPE_FOCUS',
             ),
             'ProjectFocus' => 
             array(
              'type' => 'PROJECT_FOCUS',
             ),
             'ContextFocus' => 
             array(
              'type' => 'CONTEXT_FOCUS',
             ),
             'TimeFocus' => 
             array(
              'type' => 'TIME_FOCUS',
             ),
             'EnergyFocus' => 
             array(
              'type' => 'ENERGY_FOCUS',
             ),
             'PriorityFocus' => 
             array(
              'type' => 'PRIORITY_FOCUS',
             ),
             'DoneFocus' => 
             array(
              'type' => 'DONE_FOCUS',
             ),
             'DueTodayFocus' => 
             array(
              'type' => 'DUE_TODAY_FOCUS',
             ),
             'OnlyDateFocus' => 
             array(
              'type' => 'ONLY_DATE_FOCUS',
             ),
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('SavedSearch', array(
             'local' => 'saved_search_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}