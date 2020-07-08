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

function multiplechildren_civicrm_validateForm($formName, &$fields, &$files, &$form, &$errors) {
  if ($formName == "CRM_Event_Form_Registration_Register") {
    if (!empty($fields['multiple_child'])) {
      $checkFields = [
        'child_first_name' => 'Child First Name',
        'child_last_name' => 'Child Last Name',
        'child_dob' =>  'Child Birth Date',
        'child_gender' => 'Child Gender',
      ];
      for ($i = 1; $i <= $fields['multiple_child']; $i++) {
        foreach ($checkFields as $field => $label) {
          if (empty($fields[$field][$i])) {
            $errors[$field . '[' . $i . ']'] = ts($label . ' is a required field');
          }
        }
      }
    }
  }
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
    if (1 || empty($templateId) && empty($form->getVar('_templateId'))) {
      // This is not a ministry reportable event, so we show the register multiple children checkbox.
      $form->addYesNo('multiple_children', ts('Register Multiple Children?'));
      CRM_Core_Region::instance('page-body')->add(array(
        'template' => 'CRM/MultipleChildren.tpl',
      ));
    }
  }
  if ($formName == "CRM_Event_Form_Registration_Register") {
    $isActive = FALSE;
    if (!empty($form->_eventId)) {
      $mulChild = new CRM_Multiplechildren_DAO_MultipleChildren();
      $mulChild->event_id = $form->_eventId;
      $mulChild->find(TRUE);
      if ($mulChild->multiple_child) {
        $isActive = TRUE;
      }
    }
    $priceSetId = CRM_Price_BAO_PriceSet::getFor('civicrm_event', $form->_eventId);
    // Check if child price set is inactive.
    $childPrice = $maxTickets = NULL;
    if (!empty($priceSetId)) {
      $childPrice = CRM_Core_DAO::executeQuery("SELECT id FROM civicrm_price_field WHERE name LIKE '%Child%' AND price_set_id = %1", [1 => [$priceSetId, "Integer"]])->fetchAll()[0]['id'];
    }
    if ($childPrice) {
      $maxTickets = CRM_Core_DAO::singleValueQuery("SELECT max_value FROM civicrm_max_tickets WHERE price_field_id = %1", [1 => [$childPrice, "Integer"]]);
    }
    if ($isActive && (empty($childPrice) || !$maxTickets)) {
      CRM_Core_Region::instance('page-body')->add(array(
        'template' => 'CRM/MultipleChildrenRegister.tpl',
      ));
      $fields = [
        'child_first_name' => ts('Child First Name'),
        'child_last_name' => ts('Child Last Name'),
        'child_dob' => ts('Child Birth Date'),
        'child_gender' => ts('Child Gender'),
      ];
      for ($rowNumber = 0; $rowNumber <= 25; $rowNumber++) {
        $children[$rowNumber] = $rowNumber;
        foreach ($fields as $fieldName => $fieldLabel) {
          $name = sprintf("%s[%d]", $fieldName, $rowNumber);
          if ($fieldName == 'child_dob') {
            $form->add('datepicker', $name, $fieldLabel, ['formatType' => 'activityDate'], FALSE);
          }
          else if ($fieldName == 'child_gender') {
            $form->add('select', $name, $fieldLabel, [1 => 'Male', 2 => 'Female', 3 => 'Other']);
          }
          else {
            $form->add('text', $name, $fieldLabel, NULL);
          }
        }
      }
      $form->add('select', 'multiple_child',
        ts('Are you bringing children to this event? If so, how many?'), $children, FALSE, array('class' => 'crm-select2 ')
      );
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
  if ($formName == "CRM_Event_Form_Registration_Confirm") {
    $participantId = $form->getVar('_participantId');
    $parent = $form->_values['participant']['participant_contact_id'];
    $address = civicrm_api3('Address', 'get', ['contact_id' => $parent])['values'];
    if (!empty($form->_values['params'][$participantId]['multiple_child'])) {
      for ($i = 1; $i <= $form->_values['params'][$participantId]['multiple_child']; $i++) {
        $childParams = [
          'contact_type' => 'Individual', 
          'first_name' => $form->_values['params'][$participantId]['child_first_name'][$i],
          'last_name' => $form->_values['params'][$participantId]['child_last_name'][$i],
          'birth_date' => $form->_values['params'][$participantId]['child_dob'][$i],
          'gender' => $form->_values['params'][$participantId]['child_gender'][$i],
        ];
        $dedupeParams = CRM_Dedupe_Finder::formatParams($childParams, 'Individual');
        $dedupeParams['check_permission'] = FALSE;
        $rule = CRM_Core_DAO::singleValueQuery("SELECT max(id) FROM civicrm_dedupe_rule_group WHERE name = 'Child_Rule_10'");
        $dupes = CRM_Dedupe_Finder::dupesByParams($dedupeParams, 'Individual', NULL, array(), $rule);
        $cid = CRM_Utils_Array::value('0', $dupes, NULL);
        $childParams['contact_sub_type'] = 'Child';
        if ($cid) {
          $childParams['contact_id'] = $cid;
        }
        $child = civicrm_api3('Contact', 'create', $childParams);
        $children[] = $child['id'];

        $isFilled = CRM_Core_DAO::executeQuery("SELECT entity_id FROM civicrm_value_newsletter_cu_3 WHERE entity_id IN (" . $child['id'] . ") AND (first_contacted_358 IS NOT NULL OR first_contacted_358 != '')")->fetchAll();
        if (empty($isFilled)) {
          civicrm_api3('CustomValue', 'create', [
            'entity_id' => $child['id'],
            'custom_29' => date('Ymd'),
          ]);
        }

        civicrm_api3('Participant', 'create', [
          'contact_id' => $child['id'],
          'event_id' => $form->_eventId,
          'registered_by_id' => $participantId,
          'status_id' => 17,
          'role_id' => 1,
        ]);

        foreach ($address as $k => &$val) {
          unset($val['id']);
          $val['contact_id'] = $child['id'];
          $val['master_id'] = $k;
          civicrm_api3('Address', 'create', $address[$k]);
        }


        if (!empty($form->_values['params'][$participantId]['postal_code-Primary'])) {

          list($chapter, $region) = getChapRegCodes($form->_values['params'][$participantId]['postal_code-Primary']);
          if ($chapter || $region) {
            $cParams = [
              'chapter' => $chapter,
              'region' => $region,
              'contact_id' => $child['id'],
            ];
            setChapRegCodes($cParams);
          }
        }

        // Create relationship.
        $relType = CRM_Core_DAO::getFieldValue('CRM_Contact_DAO_RelationshipType', 'Child of', 'id', 'name_a_b');
        createRelationship($child['id'], $parent, $relType);
      }
      // Check if contact has child with lead family member. If he doesn't then add first child as lead member.
      $isLeadFamilyPresent = CRM_Core_DAO::singleValueQuery("SELECT n.lead_family_member__28 FROM civicrm_value_newsletter_cu_3 n INNER JOIN civicrm_relationship r ON n.entity_id = r.contact_id_a WHERE r.relationship_type_id = 1 AND r.contact_id_b = %1 AND n.lead_family_member__28 = 1 LIMIT 1", [1 => [$parent, 'Integer']]);
      if (empty($isLeadFamilyPresent) && !empty($children[0])) {
        civicrm_api3('Contact', 'create', ['id' => $children[0], 'custom_28' => 1]);
      }
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
