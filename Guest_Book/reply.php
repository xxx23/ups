<?php
//devon
//回覆留言用
require 'Connections/guestbook_db.php';
$mid = $_POST['mid'];
$action = $_POST['action'];

if($action == "reply")
{
	$Q0 = "select * from message where id=$mid";
    //mysql_query("SET CHARACTER SET UTF8");
	$result0 = mysql_db_query($database_guestbook_db, $Q0);
	$row0 = mysql_fetch_array($result0);
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>回覆留言</title>
<link href="../themes/IE2/css/content.css" rel="stylesheet" type="text/css" />
<STYLE type=text/css>
 @import url("./creatop.css");
</STYLE>
<style type="text/css">
<!--
.style3 {color: #009999}
.style4 {color: #666666}
-->
</style>
<script language="javascript" type="text/javascript" src="../script/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="../script/tiny_mce/usable_proprities_guest.js"></script>
</head>

<body>

<h1>留言板管理-回覆留言</h1>
<table width="519" height="159" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="36" colspan="2" valign="top" background="../images/guestbook/guestbook3_r1_c1.jpg"><div align="right">留言日期:<?php echo $row0['date']; ?> </div></td>
    <td height="36" valign="top" background="../images/guestbook/guestbook0_r2_c5.jpg"><img src="../images/guestbook/guestbook1.jpg" width="16" height="36"></td>
  </tr>
  <tr>
    <td width="14" height="104" background="../images/guestbook/guestbook_r2_c1.jpg">&nbsp;</td>
    <td width="489" bgcolor="#F8F8F8"><table width="489" style="border-color:#666666; border-style:dotted; border-width:1px;" align="center" cellpadding="0" cellspacing="0" bordercolor="#B9DFFF" >
        <!--DWLayoutTable-->
        <tr>
          <td width="91" height="20" valign="top" bordercolor="#6699FF" background="../images/table_bg.gif" style="border-color:#666666; border-right-style: dotted ; border-right-width: 1px;><div align="center"><div align="center">姓　名 </div></td>
          <td width="147" valign="top" bgcolor="#FFFFFF" style="border-right-style: dotted; border-right-width: 1px;> 　 <span class="style4">
              <div align="left"><?php echo $row0['name']; ?></div></td>
          <td width="88" valign="top" background="../images/table_bg.gif" bgcolor="#FFFFFF" style="border-right-style: dotted; border-right-width: 1px;><div align="center"><div align="center">E-mail</div></td>
          <td width="161" valign="top" bgcolor="#FFFFFF"><a href="mailto:<?php echo $row0['email']; ?>"><?php echo $row0['email']; ?></a></td>
        </tr>
        <tr>
          <td height="84" colspan="4" valign="top" bgcolor="#FFFFFF" style="border-top-style: dotted; border-top-width: 1px;><div align="left"><p><img src="../images/guestbook/bookitem.gif" width="20" height="20"> 留言內容：<br>
          <?php echo $row0['content']; ?>          </p>          </td>
        </tr>
    </table></td>
    <td width="16" background="../images/guestbook/guestbook_r2_c3.jpg">&nbsp;</td>
  </tr>
  <tr>
    <td width="14" height="19" background="../images/guestbook/guestbook_r4_c1.jpg" margin="0px">&nbsp;</td>
    <td background="../images/guestbook/guestbook_r4_c2.jpg">&nbsp;</td>
    <td width="16" background="../images/guestbook/guestbook_r4_c3.jpg">&nbsp;</td>
  </tr>
</table>
<center>
<form method="post" action="login.php">
<table width="519" height="159" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="36" colspan="2" valign="top" background="../images/guestbook/guestbook3_r1_c1.jpg"><div align="right">: </div></td>
    <td height="36" valign="top" background="../images/guestbook/guestbook0_r2_c5.jpg"><img src="../images/guestbook/guestbook1.jpg" width="16" height="36"></td>
  </tr>
  <tr>
    <td width="14" height="104" background="../images/guestbook/guestbook_r2_c1.jpg">&nbsp;</td>
    <td width="489" bgcolor="#F8F8F8">   <table width="489" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F8F8F8"   >
        <!--DWLayoutTable-->
        <tr>
          <td width="487" height="84" valign="top" bgcolor="" ><div align="left">
            　請輸入回覆內容：            
              <p align="center">
            <textarea name="text_reply" cols="30" rows="10"></textarea>
            </p>
            <p align="center">
              <input type="hidden" name="action" value="reply_done">
              <input type="hidden" name="id" value="cyber2_admin">
              <input type="hidden" name="passwd" value="elearn">
              <input type="hidden" name="rid" value=<?php echo $row0[id]?>>
              <input type="submit" name="submit" value="確定">
              <input type="reset" name="reset" value="清除">
<br>
                              </p></td>
        </tr>
    </table></td>
    <td width="16" background="../images/guestbook/guestbook_r2_c3.jpg">&nbsp;</td>
  </tr>
  <tr>
    <td width="14" height="19" background="../images/guestbook/guestbook_r4_c1.jpg" margin="0px">&nbsp;</td>
    <td background="../images/guestbook/guestbook_r4_c2.jpg">&nbsp;</td>
    <td width="16" background="../images/guestbook/guestbook_r4_c3.jpg">&nbsp;</td>
  </tr>
</table>
<p>
<p><br>
    <br>
    </form>
</center>
</body>
</html>
