<?php //require_once('../config.php'); ?>
<?php require_once('Connections/guestbook_db.php'); ?>
<?php
$currentPage = $_SERVER["PHP_SELF"];
$currentPage = htmlentities($currentPage, ENT_QUOTES, 'UTF-8');

$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
    $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_guestbook_db, $guestbook_db);
$query_Recordset1 = "SELECT * FROM message WHERE `parent_id` = -1 and `release` = 1 and `date` != '2005-10-21' ORDER BY `date` DESC";

$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
//$Recordset1 = db_query($query_limit_Recordset1);
//$row_Recordset1 = db_getOne($query_limit_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $guestbook_db) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
    $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $query_Recordset1 = "SELECT count(*) FROM message WHERE `parent_id` = -1 and `release` = 1 and `date` != '2005-10-21' ORDER BY `date` DESC";
  $totalRows_Recordset1= db_getOne($query_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

$queryString_Recordset1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset1") == false && 
        stristr($param, "totalRows_Recordset1") == false) {
      $param = htmlentities($param, ENT_QUOTES, 'UTF-8');
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset1 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset1 = sprintf("&totalRows_Recordset1=%d%s", $totalRows_Recordset1, $queryString_Recordset1);
?>
<!--<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> -->
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>留言版</title>
<link href="../themes/IE2/css/content.css" rel="stylesheet" type="text/css" />

<STYLE type=text/css>
 @import url("./creatop.css");
</STYLE>

<STYLE type=text/css>
.style3 {color: #009999}
.style4 {color: #666666}
.style6 {color: #FF0000}
</STYLE>

<script language="JavaScript" type="text/JavaScript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
</head>

<body STYLE='OVERFLOW:SCROLL;OVERFLOW-X:HIDDEN' onLoad="MM_preloadImages('../images/guestbook/button01a.gif')" >
<h1>留言板</h1>
<table width="518" height="170" border="1" align="center" bordercolor="#AAAAAA" bgcolor="#E6E6E6" style="margin-left:10px;margin-top:10px;margin-right:10px; margin-button:10px;">
  <tr>
  <td style="padding:20px;" >親愛的學員，大家好： <br>
    <br>
 留言板 為提供大家一個對於平台問題進行發言及提問的園地，若是您 對本平台 有任何問題及建議都可以在此發表，我們也將竭誠為您服務。另外，提醒您，此 留言板 為公開園地， 為保護您的個人資料安全，請勿在此張貼您的帳號及密碼等相關基本資料 ，若你提出的問題中有含個人隱私資料，建議您電洽 或mail給我們，將會 由專人為您處理。
</td>
  </tr>
</table>
<hr width="90%" color="#EAF3F4" style="dashed">
　　　<a href="leave_message.php" target="_self" onMouseOver="MM_swapImage('Image5','','../images/guestbook/button01a.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../images/guestbook/button01.gif" alt="我要留言" name="Image5" width="91" height="21" border="0"></a>
<?php do { ?>
<?php //while ($row_Recordset1 = $Recordset1->fetchRow(DB_FETCHMODE_ASSOC)){ ?>
<table width="519" height="159" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="36" colspan="2" valign="top" background="../images/guestbook/guestbook3_r1_c1.jpg"><div align="right">留言日期: <span class="style3"><?php echo $row_Recordset1['date']; ?></span></div></td>
  <td height="36" valign="top" background="../images/guestbook/guestbook0_r2_c5.jpg"><img src="../images/guestbook/guestbook1.jpg" width="16" height="36"></td>
  </tr>
  <tr>
    <td width="14" height="104" background="../images/guestbook/guestbook_r2_c1.jpg">&nbsp;</td>
    <td width="489" bgcolor="#F8F8F8"><table width="489" style="border-color:#666666; border-style:dotted; border-width:1px;" align="center" cellpadding="0" cellspacing="0" bordercolor="#B9DFFF" >
      <!--DWLayoutTable-->
      <tr>
        <td width="91" height="20" valign="top" bordercolor="#6699FF" background="../images/table_bg.gif" style="border-color:#666666; border-right-style: dotted ; border-right-width: 1px;><div align="center"><div align="center">姓　名
              </div>
        </div></td>
        <td width="147" valign="top" bgcolor="#FFFFFF" style="border-right-style: dotted; border-right-width: 1px;> 　 <span class="style4"><?php echo $row_Recordset1['name']; ?>
            </span>
          <div align="center"></div></td>
      <td width="88" valign="top" background="../images/table_bg.gif" bgcolor="#FFFFFF" style="border-right-style: dotted; border-right-width: 1px;><div align="center"><div align="center">E-mail</div>        </div></td>
        <td width="161" valign="top" bgcolor="#FFFFFF">　<a href="mailto:<?php echo $row_Recordset1['email']; ?>"><?php echo $row_Recordset1['email']; ?></a></td>
      </tr>
      <tr>
        <td height="84" colspan="4" valign="top" bgcolor="#FFFFFF" style="border-top-style: dotted; border-top-width: 1px;><div align="left"><img src="../images/guestbook/bookitem.gif" width="20" height="20"> 留言內容：<span class="style4"><?php echo $row_Recordset1['content']; ?></span> </div>          </td>
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
<br>
<?php //} ?>
<?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
<div align="center">
<form name="form1" method="post" action="leave_message.php">
</form>
<form method="post" action="login.php">
</form>
</div>
<p align="center">
  <?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
  <a href="<?php htmlentities(printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1), ENT_QUOTES, 'UTF-8'); ?>">第一頁</a> | <a href="<?php htmlentities(printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1), ENT_QUOTES, 'UTF-8'); ?>">上一頁</a> |
  <?php } // Show if not first page ?>
  <?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
  <a href="<?php htmlentities(printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1), ENT_QUOTES, 'UTF-8'); ?>">下一頁</a> | <a href="<?php htmlentities(printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1), ENT_QUOTES, 'UTF-8'); ?>">最後一頁</a>
  <?php } // Show if not last page ?>
</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
