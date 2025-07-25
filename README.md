## Group Name Validator Plugin

The Group Name Validator Plugin is used with COmanage Registry to restrict regular group names to a specified format. 

The plugin should be installed/enabled in the [traditional way](https://spaces.at.internet2.edu/display/COmanage/Installing+and+Enabling+Registry+Plugins).

Once enabled, a Platform or CO admin can create a Group Name Validator from the CO Configuration menu. 

The configurable fields are: 

 * Description
 * Status - whether this validator is enabled or disabled
 * Name Format - the regular expression describing the required regular group name format. See the [PHP Manual](https://www.php.net/manual/en/reference.pcre.pattern.syntax.php) for Regular Expression syntax. 
 * Error Message - the error message that should be displayed if a group name does not meet the requirments.

Only one group validator may be active at a time. The "add" button above the index page will not be active when there is already an active Group Name Validator. 

The Group Name Validator only checks regular group names at Save time. It does not change regular group names that have already been created. However,the currently active validator will display an error if an already created regular group is edited and, upon save, the name does not match the required name format. 

The Group Name Validator and the Group Name Reservation plugins should not be used on the same CO at the same time. 
