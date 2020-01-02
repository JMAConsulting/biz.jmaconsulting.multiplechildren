<?php

/**
 * @package CRM
 * @copyright CiviCRM LLC https://civicrm.org/licensing
 *
 * Generated from /Users/monish/src/civi-extensions/biz.jmaconsulting.multiplechildren/xml/schema/CRM/Multiplechildren/MultipleChildren.xml
 * DO NOT EDIT.  Generated by CRM_Core_CodeGen
 * (GenCodeChecksum:8ede7b129ce73ae1861607209909fb72)
 */

/**
 * Database access object for the MultipleChildren entity.
 */
class CRM_Multiplechildren_DAO_MultipleChildren extends CRM_Core_DAO {

  /**
   * Static instance to hold the table name.
   *
   * @var string
   */
  public static $_tableName = 'civicrm_multiple_children';

  /**
   * Should CiviCRM log any modifications to this table in the civicrm_log table.
   *
   * @var bool
   */
  public static $_log = TRUE;

  /**
   * Unique MultipleChildren ID
   *
   * @var int
   */
  public $id;

  /**
   * FK to Contact
   *
   * @var int
   */
  public $event_id;

  /**
   * FK to Contact
   *
   * @var int
   */
  public $multiple_child;

  /**
   * Class constructor.
   */
  public function __construct() {
    $this->__table = 'civicrm_multiple_children';
    parent::__construct();
  }

  /**
   * Returns foreign keys and entity references.
   *
   * @return array
   *   [CRM_Core_Reference_Interface]
   */
  public static function getReferenceColumns() {
    if (!isset(Civi::$statics[__CLASS__]['links'])) {
      Civi::$statics[__CLASS__]['links'] = static::createReferenceColumns(__CLASS__);
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'contact_id', 'civicrm_contact', 'id');
      CRM_Core_DAO_AllCoreTables::invoke(__CLASS__, 'links_callback', Civi::$statics[__CLASS__]['links']);
    }
    return Civi::$statics[__CLASS__]['links'];
  }

  /**
   * Returns all the column names of this table
   *
   * @return array
   */
  public static function &fields() {
    if (!isset(Civi::$statics[__CLASS__]['fields'])) {
      Civi::$statics[__CLASS__]['fields'] = [
        'id' => [
          'name' => 'id',
          'type' => CRM_Utils_Type::T_INT,
          'description' => ts('Unique MultipleChildren ID'),
          'required' => TRUE,
          'where' => 'civicrm_multiple_children.id',
          'table_name' => 'civicrm_multiple_children',
          'entity' => 'MultipleChildren',
          'bao' => 'CRM_Multiplechildren_DAO_MultipleChildren',
          'localizable' => 0,
        ],
        'event_id' => [
          'name' => 'event_id',
          'type' => CRM_Utils_Type::T_INT,
          'description' => ts('FK to Event'),
          'where' => 'civicrm_multiple_children.event_id',
          'table_name' => 'civicrm_multiple_children',
          'entity' => 'MultipleChildren',
          'bao' => 'CRM_Multiplechildren_DAO_MultipleChildren',
          'localizable' => 0,
        ],
        'multiple_child' => [
          'name' => 'multiple_child',
          'type' => CRM_Utils_Type::T_INT,
          'description' => ts('Is multiple child?'),
          'where' => 'civicrm_multiple_children.multiple_child',
          'table_name' => 'civicrm_multiple_children',
          'entity' => 'MultipleChildren',
          'bao' => 'CRM_Multiplechildren_DAO_MultipleChildren',
          'localizable' => 0,
        ],
      ];
      CRM_Core_DAO_AllCoreTables::invoke(__CLASS__, 'fields_callback', Civi::$statics[__CLASS__]['fields']);
    }
    return Civi::$statics[__CLASS__]['fields'];
  }

  /**
   * Return a mapping from field-name to the corresponding key (as used in fields()).
   *
   * @return array
   *   Array(string $name => string $uniqueName).
   */
  public static function &fieldKeys() {
    if (!isset(Civi::$statics[__CLASS__]['fieldKeys'])) {
      Civi::$statics[__CLASS__]['fieldKeys'] = array_flip(CRM_Utils_Array::collect('name', self::fields()));
    }
    return Civi::$statics[__CLASS__]['fieldKeys'];
  }

  /**
   * Returns the names of this table
   *
   * @return string
   */
  public static function getTableName() {
    return self::$_tableName;
  }

  /**
   * Returns if this table needs to be logged
   *
   * @return bool
   */
  public function getLog() {
    return self::$_log;
  }

  /**
   * Returns the list of fields that can be imported
   *
   * @param bool $prefix
   *
   * @return array
   */
  public static function &import($prefix = FALSE) {
    $r = CRM_Core_DAO_AllCoreTables::getImports(__CLASS__, 'multiple_children', $prefix, []);
    return $r;
  }

  /**
   * Returns the list of fields that can be exported
   *
   * @param bool $prefix
   *
   * @return array
   */
  public static function &export($prefix = FALSE) {
    $r = CRM_Core_DAO_AllCoreTables::getExports(__CLASS__, 'multiple_children', $prefix, []);
    return $r;
  }

  /**
   * Returns the list of indices
   *
   * @param bool $localize
   *
   * @return array
   */
  public static function indices($localize = TRUE) {
    $indices = [];
    return ($localize && !empty($indices)) ? CRM_Core_DAO_AllCoreTables::multilingualize(__CLASS__, $indices) : $indices;
  }

}
