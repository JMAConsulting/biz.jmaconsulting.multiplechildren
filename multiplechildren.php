<?php
  define('MINISTRY', 327);

require_once 'multiplechildren.civix.php';
use CRM_Multiplechildren_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/ 
 */
function multiplechildren_civicrm_config(&$config) {
  _multiplechildren_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function multiplechildren_civicrm_xmlMenu(&$files) {
  _multiplechildren_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function multiplechildren_civicrm_install() {
  _multiplechildren_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function multiplechildren_civicrm_postInstall() {
  _multiplechildren_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function multiplechildren_civicrm_uninstall() {
  _multiplechildren_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function multiplechildren_civicrm_enable() {
  _multiplechildren_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function multiplechildren_civicrm_disable() {
  _multiplechildren_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function multiplechildren_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _multiplechildren_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
 */
function multiplechildren_civicrm_managed(&$entities) {
  _multiplechildren_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_caseTypes
 */
function multiplechildren_civicrm_caseTypes(&$caseTypes) {
  _multiplechildren_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules
 */
function multiplechildren_civicrm_angularModules(&$angularModules) {
  _multiplechildren_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function multiplechildren_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _multiplechildren_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function multiplechildren_civicrm_entityTypes(&$entityTypes) {
  _multiplechildren_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_buildForm().
 */
function multiplechildren_civicrm_buildForm($formName, &$form) {
  if ($formName == "CRM_Event_Form_ManageEvent_EventInfo") {
    $templateId = NULL;
    if (!empty($form->_id)) {
      $template = civicrm_api3('Event', 'get', [
        'id' => $form->_id,
        'return.custom_' . MINISTRY => 1,
      ])['values'][$form->_id];
      if (!empty($template['custom_' . MINISTRY])) {
        $templateId = $template['custom_' . MINISTRY];
      }
      $mulChild = new CRM_Multiplechildren_DAO_MultipleChildren();
      $mulChild->event_id = $form->_id;
      $mulChild->find(TRUE);
      if ($mulChild->multiple_child) {
        $form->setDefaults(['multiple_children' => 1]);
      }
      else {
        $form->setDefaults(['multiple_children' => 0]);
      }
    }
    if (empty($templateId) && empty($form->getVar('_templateId'))) {
      // This is not a ministry reportable event, so we show the register multiple children checkbox.
      $form->addYesNo('multiple_children', ts('Register Multiple Children?'));
      CRM_Core_Region::instance('page-body')->add(array(
        'template' => 'CRM/MultipleChildren.tpl',
      ));
    }
  }
  if ($formName == "CRM_Event_Form_Registration_Register") {
    return;
    $isActive = FALSE;
    if (!empty($form->_eventId)) {
      $mulChild = new CRM_Multiplechildren_DAO_MultipleChildren();
      $mulChild->event_id = $form->_eventId;
      $mulChild->find(TRUE);
      if ($mulChild->multiple_child) {
        $isActive = TRUE;
      }
    }
    if ($isActive) {
      CRM_Core_Region::instance('page-body')->add(array(
        'template' => 'CRM/MultipleChildrenRegister.tpl',
      ));
      $fields = [
        'child_first_name' => ts('Child First Name'),
        'child_last_name' => ts('Child Last Name'),
        'child_dob' => ts('Child Birth Date'),
        'child_gender' => ts('Child Gender'),
      ];
      for ($rowNumber = 1; $rowNumber <= 25; $rowNumber++) {
        foreach ($fields as $fieldName => $fieldLabel) {
          $name = sprintf("%s[%d]", $fieldName, $rowNumber);
          if ($fieldName == 'child_dob') {
            $form->addDate($fieldName, $fieldLabel, FALSE, ['formatType' => 'activityDate']);
          }
          else if ($fieldName == 'child_gender') {
            $form->add('select', $fieldName, $fieldLabel, [1 => 'Male', 2 => 'Female', 3 => 'Other']);
          }
          else {
            $form->add('text', $name, $fieldLabel, NULL);
          }
        }
      }
    }
  }
}

function multiplechildren_civicrm_post($op, $objectName, $objectId, &$objectRef) {
  if (($op == 'create' || $op == 'edit') && $objectName == 'Event') {
    CRM_Core_Session::singleton()->set('eventID', $objectId);
  }
}

/**
 * Implements hook_civicrm_buildForm().
 */
function multiplechildren_civicrm_postProcess($formName, &$form) {
  if ($formName == "CRM_Event_Form_ManageEvent_EventInfo") {
    if (array_key_exists('multiple_children', $form->_submitValues)) {
      $eventId = CRM_Core_Session::singleton()->get('eventID');
      $mulChild = new CRM_Multiplechildren_DAO_MultipleChildren();
      $mulChild->event_id = $eventId;
      $mulChild->find(TRUE);
      $mulChild->multiple_child = $form->_submitValues['multiple_children'];
      $mulChild->save();
    }
  }
}
// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 *
function multiplechildren_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 *
function multiplechildren_civicrm_navigationMenu(&$menu) {
  _multiplechildren_civix_insert_navigation_menu($menu, 'Mailings', array(
    'label' => E::ts('New subliminal message'),
    'name' => 'mailing_subliminal_message',
    'url' => 'civicrm/mailing/subliminal',
    'permission' => 'access CiviMail',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _multiplechildren_civix_navigationMenu($menu);
} // */
