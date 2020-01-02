<?php
use CRM_Multiplechildren_ExtensionUtil as E;

class CRM_Multiplechildren_BAO_MultipleChildren extends CRM_Multiplechildren_DAO_MultipleChildren {

  /**
   * Create a new MultipleChildren based on array-data
   *
   * @param array $params key-value pairs
   * @return CRM_Multiplechildren_DAO_MultipleChildren|NULL
   *
  public static function create($params) {
    $className = 'CRM_Multiplechildren_DAO_MultipleChildren';
    $entityName = 'MultipleChildren';
    $hook = empty($params['id']) ? 'create' : 'edit';

    CRM_Utils_Hook::pre($hook, $entityName, CRM_Utils_Array::value('id', $params), $params);
    $instance = new $className();
    $instance->copyValues($params);
    $instance->save();
    CRM_Utils_Hook::post($hook, $entityName, $instance->id, $instance);

    return $instance;
  } */

}
