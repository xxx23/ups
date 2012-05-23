<?php

    require_once('../config.php');
    require_once('../session.php');

    
    $tpl = new Smarty();
    $tpl->assign('file_name',urlencode('example.rar'));
    assignTemplate($tpl,'/test_bank/export_example.tpl');

//end of php

