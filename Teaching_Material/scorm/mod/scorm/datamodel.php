<?php
//下面這行就可以使用 cyberccu2 原本的 session
//require('/home/zoe/WWW/session.php');
require('../../../../session.php');
$begin_course_cd_before = $_SESSION['begin_course_cd'];
$personal_id_before = $_SESSION['personal_id'];

//下面這行就會改採用 moodle 的 session
require_once("../../config.php");
require_once('locallib.php');

$_SESSION['begin_course_cd']= $begin_course_cd_before ; 
$_SESSION['personal_id']= $personal_id_before ;
$begin_course_cd=$_SESSION['begin_course_cd'];
$personal_id=$_SESSION['personal_id'];
        
    $id = optional_param('id', '', PARAM_INT);       // Course Module ID, or
    $a = optional_param('a', '', PARAM_INT);         // scorm ID
    $scoid = required_param('scoid', PARAM_INT);  // sco ID
    $attempt = required_param('attempt', PARAM_INT);  // attempt number
    if (!empty($id)) {
        if (! $cm = get_coursemodule_from_id('scorm', $id)) {
            error("Course Module ID was incorrect");
        }
        if (! $course = get_record("course", "id", $cm->course)) {
            error("Course is misconfigured");
        }
        if (! $scorm = get_record("scorm", "id", $cm->instance)) {
            error("Course module is incorrect");
        }
    } else if (!empty($a)) {
        if (! $scorm = get_record("scorm", "id", $a)) {
            error("Course module is incorrect");
        }
        if (! $course = get_record("course", "id", $scorm->course)) {
            error("Course is misconfigured");
        }
        if (! $cm = get_coursemodule_from_instance("scorm", $scorm->id, $course->id)) {
            error("Course Module ID was incorrect");
        }
    } else {
        error('A required parameter is missing');
    }

    //require_login($course->id, false, $cm);

    if (confirm_sesskey() && (!empty($scoid))) {
        $result = true;
        $request = null;
        if (has_capability('mod/scorm:savetrack', get_context_instance(CONTEXT_MODULE,$cm->id))) {
            foreach (data_submitted() as $element => $value) {
                $element = str_replace('__','.',$element);
                if (substr($element,0,3) == 'cmi') {
                    $netelement = preg_replace('/\.N(\d+)\./',"\.\$1\.",$element);
                    $result = scorm_insert_track($personal_id, $scorm->id, $scoid, $attempt, $netelement, $value) && $result;
                }
                if (substr($element,0,15) == 'adl.nav.request') {
                    // SCORM 2004 Sequencing Request
                    require_once('datamodels/sequencinglib.php');

                    $search = array('@continue@', '@previous@', '@\{target=(\S+)\}choice@', '@exit@', '@exitAll@', '@abandon@', '@abandonAll@');
                    $replace = array('continue_', 'previous_', '\1', 'exit_', 'exitall_', 'abandon_', 'abandonall');
                    $action = preg_replace($search, $replace, $value);

                    if ($action != $value) {
                        // Evaluating navigation request
                        $valid = scorm_seq_overall ($scoid,$personal_id,$action,$attempt);
                        $valid = 'true';

                        // Set valid request
                        $search = array('@continue@', '@previous@', '@\{target=(\S+)\}choice@');
                        $replace = array('true', 'true', 'true');
                        $matched = preg_replace($search, $replace, $value);
                        if ($matched == 'true') {
                            $request = 'adl.nav.request_valid["'.$action.'"] = "'.$valid.'";';
                        }
                    }
                }
                // Log every datamodel update requested
                if (substr($element,0,15) == 'adl.nav.request' || substr($element,0,3) == 'cmi') {
                    if (debugging('',DEBUG_DEVELOPER)) {
                        add_to_log($course->id, 'scorm', 'trk: '.trim($scorm->name).' at: '.$attempt, 'view.php?id='.$cm->id, "$element => $value", $cm->id);
                    }
                }
            }
        }
        if ($result) {
            echo "true\n0";
        } else {
            echo "false\n101";
        }
        if ($request != null) {
            echo "\n".$request;
        }
    }
?>
