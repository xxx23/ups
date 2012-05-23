<?php 
// 變身功能 
// 輸入 personal_id 即可以變身成那個人的狀態登入 

require_once("../config.php");
require_once("../session.php");
require_once("../library/filter.php"); 

if( isset($_SESSION['setuid']) ) {
//將舊的session存起來 
    $_SESSION = unserialize($_SESSION['setuid']); 
}

header("Location: {$HOMEURL}{$WEBROOT}Personal_Page/index.php");

return ; 

?>

