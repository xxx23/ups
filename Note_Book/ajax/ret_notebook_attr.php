<?php
/**********************************************************************************/
/* id: ret_notebook_attr.php v1.0 hushpuppy 2007/10/5  Exp.		          */
/* function: 在筆記本修改頁面中，根據使用者選擇的教材編號，動態取回筆記本屬性回傳 */
/**********************************************************************************/
include "../../config.php";
require_once("../../session.php");

$Notebook_cd = $_GET['notebook_cd'];
$sql = "select * from personal_notebook where notebook_cd = '$Notebook_cd';";
$result = $DB_CONN->query($sql);
if(PEAR::isError($result))	die($result->getMessage());

$row = $result->fetchRow(DB_FETCHMODE_ASSOC);

print "notebook_name:".$row['notebook_name'].";";
print "is_public:".$row['is_public'];
?>
