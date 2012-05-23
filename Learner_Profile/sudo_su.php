<?php 
// 變身功能 
// 輸入 personal_id 即可以變身成那個人的狀態登入 

require_once("../config.php");
require_once("../session.php");
require_once("../library/filter.php"); 
checkAdmin(); 

$personal_id = required_param('pid', PARAM_INT); 



$person = db_getRow(" select * from register_basic where personal_id=" . $personal_id );

//將舊的session存起來 
$temp = serialize($_SESSION); 

//變身囉
$_SESSION = array();
$_SESSION['personal_id']    = $person['personal_id'] ; 
$_SESSION['role_cd']        = $person['role_cd'] ; 
$_SESSION['template_path']  = $HOME_PATH . "themes/";
$_SESSION['template']       = db_getOne("select personal_style from `personal_basic` where personal_id=$personal_id;");
setMenu($person['personal_id'], $person['role_cd']);
//把舊的存起來 等待變身回來
$_SESSION['setuid']         = $temp ; 


//變身完轉跳到登入頁面
header("Location: {$HOMEURL}{$WEBROOT}Personal_Page/index.php");

return ; 
function setMenu($pid, $role){
    global $DB_CONN;
    $_SESSION['menu'] = array();
    
    $sql =  "select menu_link from `lrtmenu_` where menu_id in "
          ." (select menu_id from `menu_role` where role_cd=$role and is_used='y')  "
          ."  and menu_level > 0 and menu_link like '%php%'; " ; 

    echo $sql ;
    $result = $DB_CONN->query($sql);
    while($row = $result->fetchRow())
        array_push($_SESSION['menu'], $row[0]);
}

?>

