<?php

require_once '../config.php';
require_once 'session.php';
require_once '../library/filter.php';
require_once 'lib.php';
require_once '../library/smarty_init.php';
$category = $_SESSION['category'];
$no = $_SESSION['no'];
$action = optional_param('action','showForm',PARAM_TEXT);

if(in_array($action,array('updateData','showForm')))
    call_user_func($action);

//update data
function updateData()
{
    global $tpl;
    global $no;
    $city_cd = optional_param('city_cd',0,PARAM_INT );
    $school_cd = optional_param('school_cd',0,PARAM_INT);
    if($_SESSION['category']==1 && empty($city_cd))
    {
        $tpl->assign('error',1);
        showForm();
    }
    else if($_SESSION['category']==2 && (empty($city_cd)||empty($school_cd)))
    {
        $tpl->assign('error',1);
        showForm();
    }
    //update account 
    $sql = "UPDATE `register_applycourse` SET `city_cd` = '{$city_cd}', `school_cd` = '{$school_cd}' WHERE no = {$no}";
    db_query($sql);
    thanks();
}
//show form

function showForm()
{
    global $tpl;
    global $category;
    global $no;
    $citys = db_getAll("SELECT DISTINCT city_cd,city as name FROM location WHERE 1;");
    $tpl->assign('citys',$citys);


    $tpl->assign('category',$category);
    assignTemplate($tpl,'/apply_course/fill_up_account_showForm.tpl');
    exit();
}
function thanks()
{
    global $tpl;
    assignTemplate($tpl,'/apply_course/fill_up_account_redirect.tpl');
    exit();
}

//end of fill_up_account.php
