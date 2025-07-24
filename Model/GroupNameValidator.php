<?php

class GroupNameValidator extends AppModel {
  // Required by COmanage Plugins

  public $name = "GroupNameValidator";

  public $belongsTo = array(
    "Co",
  );

  public $cmPluginHasMany = array(
    "Co" => array("GroupNameValidator")
  );

  public $cmPluginType = "other";

  // Validation rules for table elements
  public $validate = array(
    'co_id' => array(
      'rule' => 'numeric',
      'required' => true,
      'message' => 'A CO ID must be provided'
    ),
    'description' => array(
      'rule' => array('validateInput'),
      'required' => false,
      'allowEmpty' => true
    ),
    'status' => array(
      'content' => array(
        'rule' => array('inList', array(SuspendableStatusEnum::Active,
                                        SuspendableStatusEnum::Suspended)),
        'required' => true,
        'allowEmpty' => false
      ),
      'oneActive' => array(
        'rule' => array('avoidMultipleActives', 'co_id', 'id'),
        'message' => ""
      )
    ),
    'name_format' => array(
      'rule' => '/.*/',
      'required' => true,
      'allowEmpty' => false
    ),
    'error_message' => array(
      'rule' => array('validateInput'),
      'required' => true,
      'allowEmpty' => false
    )
  );
        


  public function cmPluginMenus() {
    return array(
      "coconfig" => array(_txt('ct.group_name_validators.1') =>
        array('icon'       => 'playlist_add_check',
              'controller' => 'group_name_validators',
              'action'     => 'index')
      )
    );
  }

  /**
   * Actions to take before a save operation is executed.
   *
   */

/*  public function beforeSave($options = array()) { 

    if ($this->data['GroupNameValidator']['status'] == SuspendableStatusEnum::Active) {

      $coId = $this->data['GroupNameValidator']['co_id'];

      $args = array();
      $args['conditions']['co_id'] = $coId;
      $args['conditions']['GroupNameValidator.status'] = SuspendableStatusEnum::Active;
      $args['contain'] = false;

      $activeValidators = $this->find('all', $args);
    
      foreach($activeValidators as $validator) {
        if($validator['GroupNameValidator']['id'] != $this->data['GroupNameValidator']['id']) {
          $messages = (array)CakeSession::read('Message.' . $options['key']);
          $newMessage = array(
            'message' => _txt('er.gnv.deny_multiple_active', array($validator['GroupNameValidator']['description'])),
            'key' => 'error',
            'element' => 'default',
            'params' => array()
          );
          $messages[] = $newMessage;
          CakeSession::write('Message.' . 'error', $messages);
          
          return false;
        }
      }
    }
    return true;
  } */


  public function avoidMultipleActives($check, $coId, $id) { 

    if ($check['status'] == SuspendableStatusEnum::Active) {

      $args = array();
      $args['conditions']['co_id'] = $this->data['GroupNameValidator'][$coId];
      $args['conditions']['GroupNameValidator.status'] = SuspendableStatusEnum::Active;
      $args['contain'] = false;

      $activeValidators = $this->find('all', $args);
      foreach($activeValidators as $validator) {
        if($validator['GroupNameValidator']['id'] != $this->data['GroupNameValidator'][$id]) {
          return _txt('er.gnv.deny_multiple_active', array($validator['GroupNameValidator']['description']));
        }
      }
    }
    return true;
  }
}
