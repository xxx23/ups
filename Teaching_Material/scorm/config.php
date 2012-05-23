<?php  /// Moodle Configuration File 
/*Modified by Zoe
 * echo getcwd是$HOME_PATH/Teaching_Material/scorm/mod/scorm
 */
include_once('../../config.php');
include_once('../../../../config.php');
unset($CFG);

$CFG->dbtype    = $DB_TYPE;
$CFG->dbhost    = $DB_HOST;
$CFG->dbname    = $DB_NAME;
$CFG->dbuser    = $DB_USERNAME;
$CFG->dbpass    = $DB_USERPASSWORD;
$CFG->dbpersist =  false;
$CFG->prefix    = 'mdl_';

$CFG->wwwroot   = $WEBROOT . 'Teaching_Material/scorm';
$CFG->dirroot   = $HOME_PATH 	. 'Teaching_Material/scorm';
$CFG->dataroot  = $CFG->dirroot . '/nccudata';
$CFG->admin     = 'admin';

$CFG->directorypermissions = 00777;  // try 02777 on a server in Safe Mode
//var_dump($CFG);

require_once($CFG->dirroot.'/lib/setup.php');
// MAKE SURE WHEN YOU EDIT THIS FILE THAT THERE ARE NO SPACES, BLANK LINES,
// RETURNS, OR ANYTHING ELSE AFTER THE TWO CHARACTERS ON THE NEXT LINE.
?>
