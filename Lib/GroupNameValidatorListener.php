<?php

App::uses('CakeEventListener', 'Event');
App::uses('CakeEvent', 'Event');
App::uses('CakeSession', 'Model/Datasource');
App::uses("GroupNameValidator", "GroupNameValidator.Model");

class GroupNameValidatorListener implements CakeEventListener {

  public function implementedEvents() {
    return array(
      'Model.beforeSave' => 'validateGroupName'
    );
  }

  public function validateGroupName(CakeEvent $event) {
    // The subject of the event is a Model object.
    $model = $event->subject();

    // We only intend to intercept the CoGroup model.
    if(!($model->name === 'CoGroup')) {
      return true;
    }

    // Grab the data being used for the save action.
    $group = $model->data;
 
    
    // Only intercept standard groups and not auto groups.
    if(!empty($group['CoGroup']['group_type'])) {
      if($group['CoGroup']['group_type'] != GroupEnum::Standard) {
        return true;
      }
    }

    if(!empty($group['CoGroup']['auto'])) {
      if($group['CoGroup']['auto'] == true) {
        return true;
      }
    }

    //Get the Group Name Validator, if there is one, for this CO. There should only be one that is active for the COa

    $coId = $group['CoGroup']['co_id'];

    $validatorModel = new GroupNameValidator();

    $args = array();
    $args['conditions']['co_id'] = $coId;
    $args['conditions']['GroupNameValidator.status'] = SuspendableStatusEnum::Active;
    $arg['contain'] = true;
 
    $validators = $validatorModel->find('all', $args);
    
    //we should never have more than one. This shouldn't be possible but check anyway.
    if (count($validators) > 1) {
      //throw new RuntimeException(_txt('er.db.save'));
      throw new RuntimeException(_txt('er.gnv.multiple_active'));
    }
   
    //check if empty 
    if (empty($validators)) {
       return true;
    }

    // Test the group name against the configured regular expression
    // and intercept any names that do not match.
    $pattern = $validators[0]['GroupNameValidator']['name_format'];

    $match = preg_match($pattern, $group['CoGroup']['name']);

    if($match == 1) {
      return true;
    } else {
      // Set the Message stored in the session and used by the Flash component.
      // We append a new message to any existing messasges.
      $messages = (array)CakeSession::read('Message');

      $newMessage = array(
        'message' => $validators[0]['GroupNameValidator']['error_message'], 
        'key' => 'error',
        'element' => 'default',
        'params' => array()
      );

      $messages[] = $newMessage;

      CakeSession::write('Message.' . 'error', $messages);

      // Return false to prevent the save.
      return false;
    }
  }
}
