<?php
/**
 * COmanage Registry Group Name Validators Controller
 *
 */

App::uses("StandardController", "Controller");
 
class GroupNameValidatorsController extends StandardController {
  // Class name, used by Cake
  public $name = "GroupNameValidators";
 
  // This controller needs a CO to be set
  public $requires_co = true;

  /**
   * Authorization for this Controller, called by Auth component
   * - precondition: Session.Auth holds data used for authz decisions
   * - postcondition: $permissions set with calculated permissions
   *
   * @since  COmanage Registry v0.6
   * @return Array Permissions
   */

  function isAuthorized() {
    $roles = $this->Role->calculateCMRoles();

    // Construct the permission set for this user, which will also be passed to the view.
    $p = array();

    // Determine what operations this user can perform

    // Add a new Group Name Validator?
    $p['add'] = ($roles['cmadmin'] || $roles['coadmin']);

    // Delete an existing Group Name Validator?
    $p['delete'] = ($roles['cmadmin'] || $roles['coadmin']);

    // Edit an existing Group Name Validator?
    $p['edit'] = ($roles['cmadmin'] || $roles['coadmin']);

    // View all existing Group Name Validators?
    $p['index'] = ($roles['cmadmin'] || $roles['coadmin']);

    // View an existing Group Name Validator?
    $p['view'] = ($roles['cmadmin'] || $roles['coadmin']);

    $this->set('permissions', $p);

    return $p[$this->action];
  }

  function index() {

    //See it there are any active GroupNameValidators for the current CO

    $coId = $this->cur_co['Co']['id'];

    $args = array();
    $args['conditions']['co_id'] = $coId;
    $args['conditions']['GroupNameValidator.status'] = SuspendableStatusEnum::Active;
    $args['contain'] = false;

    $activeValidators = $this->GroupNameValidator->find('first', $args);

    //If there is an active validator, set the view variable so we can disable the add button in the View
    if (!empty($activeValidators)) {
        $this->set('vv_active_validator', true);
    } else {
        $this->set('vv_active_validator', false);
    }

    //call the parent index function
    parent::index();
  }
}
