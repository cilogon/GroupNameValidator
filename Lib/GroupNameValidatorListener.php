<?php

App::uses('CakeEventListener', 'Event');
App::uses('CakeEvent', 'Event');
App::uses('CakeSession', 'Model/Datasource');

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

    // Only intercept CoGroup for our configured CO.
    $coId = Configure::read('GroupNameValidator.co_id');
    if($group['CoGroup']['co_id'] != $coId) {
      return true;
    }

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

    // Test the group name against the configured regular expression
    // and intercept any names that do not match.
    $pattern = Configure::read('GroupNameValidator.pattern');

    $match = preg_match($pattern, $group['CoGroup']['name']);

    if($match == 1) {
      return true;
    } else {
      // Set the Message stored in the session and used by the Flash component.
      // We append a new message to any existing messasges.
      $messages = (array)CakeSession::read('Message.' . $options['key']);

      $newMessage = array(
        'message' => Configure::read('GroupNameValidator.flash_error_text'),
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
