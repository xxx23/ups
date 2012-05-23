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
    $scoid = required_param('scoid', PARAM_INT);     // sco ID
    $mode = optional_param('mode', '', PARAM_ALPHA); // navigation mode
    $attempt = required_param('attempt', PARAM_INT); // new attempt

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

    if ($usertrack = scorm_get_tracks($scoid,$personal_id,$attempt)) {
        if ((isset($usertrack->{'cmi.exit'}) && ($usertrack->{'cmi.exit'} != 'time-out')) || ($scorm->version != "SCORM_1.3")) {
            foreach ($usertrack as $key => $value) {
                $userdata->$key = addslashes_js($value);
            }
        } else {
            $userdata->status = '';
            $userdata->score_raw = '';
        }
    } else {
        $userdata->status = '';
        $userdata->score_raw = '';
    }
    $userdata->student_id = addslashes_js($USER->username);
    $userdata->student_name = addslashes_js($USER->lastname .', '. $USER->firstname);
    $userdata->mode = 'normal';
    if (isset($mode)) {
        $userdata->mode = $mode;
    }
    if ($userdata->mode == 'normal') {
        $userdata->credit = 'credit';
    } else {
        $userdata->credit = 'no-credit';
    }
    if ($scodatas = scorm_get_sco($scoid, SCO_DATA)) {
        foreach ($scodatas as $key => $value) {
            $userdata->$key = addslashes_js($value);
        }
    } else {
        error('Sco not found');
    }
    if (!$sco = scorm_get_sco($scoid)) {
        error('Sco not found');
    }
    $scorm->version = strtolower(clean_param($scorm->version, PARAM_SAFEDIR));   // Just to be safe
    if (file_exists($CFG->dirroot.'/mod/scorm/datamodels/'.$scorm->version.'.js.php')) {
        include_once($CFG->dirroot.'/mod/scorm/datamodels/'.$scorm->version.'.js.php');
    } else {
        include_once($CFG->dirroot.'/mod/scorm/datamodels/scorm_12.js.php');
    }
    
    // set the start time of this SCO
    scorm_insert_track($personal_id,$scorm->id,$scoid,$attempt,'x.start.time',time());

?>

var errorCode = "0";
function underscore(str) {
    str = String(str).replace(/.N/g,".");
    return str.replace(/\./g,"__");
}
