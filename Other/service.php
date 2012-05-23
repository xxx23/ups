<?php
require_once('../config.php');
    
    // create smarty object
    $tpl = new Smarty();

    
    //display

    $tpl->assign('servicePhoneMOE','02-7712-9098');
    $tpl->assign('servicePhoneCCU','05-2720411 #33131' );
    $tpl->assign('serviceMail','ups_moe@mail.moe.gov.tw');
            //尚未申請開通port 1433 MSSQL先註解起來
    assignTemplate($tpl,'/other/service.tpl');
?>
