<?php
/**
 * COmanage Registry Group Name Validator Language File
 *
 */

global $cm_lang, $cm_texts;

// When localizing, the number in format specifications (eg: %1$s) indicates the argument
// position as passed to _txt.  This can be used to process the arguments in
// a different order than they were passed.

$cm_group_name_validator_texts['en_US'] = array(
  // Titles, per-controller
  'ct.group_name_validators.1'  => 'Group Name Validator',
  'ct.group_name_validators.pl' => 'Group Name Validators',

  //Fields
  'fd.gnv.error_message'	=> 'Error Message',
  'fd.gnv.error_message.desc'	=> 'Error message to display when a group name is not valid',
  'fd.gnv.name_format'		=> 'Name Format',
  'fd.gnv.name_format.desc' 	=> 'Regular expression describing the allowed format for group names, including delimiters. See <a href="https://www.php.net/manual/en/reference.pcre.pattern.syntax.php">PCRE Pattern Syntax</a> in the PHP Manual for more information',
 
  //Error messages
  'er.gnv.multiple_active'	=> 'There should only be one active Group Name Validator configured per CO. Please inform your Administrator. You will not be able to save Groups until the configuration is corrected.',
  'er.gnv.deny_multiple_active'	=> 'Only one Group Name Validator can be active at a time. Suspend validator \'%1$s\' to be able to mark this one active',

);
