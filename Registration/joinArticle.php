<?php
require_once("../config.php");
require_once($HOME_PATH . 'library/smarty_init.php');
session_start();
    $role = $_GET['t'];  // role = 0 為學生註冊  
                         // role = 1 為老師註冊
    if(array_key_exists('agree', $_GET)){
       $_SESSION['agree'] = true;	
       //header('Location: registerchoose.html');
       if($role == '1'){
           //header('tea');
           header('Location: register.php?t=tea');
       }
       else{
           //header('stu');
           header('Location: register.php?t=stu');
       }
    }
    else{
        //$tpl = new Smarty();
        if($role == '1'){
            $tpl->assign("role", 1);
        }
        else{
            $tpl->assign("role", 0);
        }
        $tpl->display('joinArticle.tpl');

    }

?>
