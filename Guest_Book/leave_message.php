<?php 
    require_once('../config.php') ; 
    require_once($HOME_PATH.'library/filter.php');
    require_once($HOME_PATH.'library/mail.php'); 
    require_once('Connections/guestbook_db.php'); 
    //add for pure html
    require_once $HOME_PATH.'library/purifier/HTMLPurifier.auto.php';
    $purifier = new HTMLPurifier();
    //end
    
    //modify by w60292 @ 2009.08.31 於留言板中加入驗證碼功能
    session_start();
    $ara = explode("|", $_SESSION['randcode']);
    $v = optional_param("v", 0, PARAM_INT);
    if(validate_email(optional_param("email", "", PARAM_TEXT)))
        $email = optional_param("email", "", PARAM_TEXT);
    else
        $email = "";
    $valid = -1;
    $title = "<div><font color=\"gray\">點擊圖片可刷新驗證碼</font></div>";
    if($v == 1)
    {
        $name = required_param("name", PARAM_TEXT);
        //$say = required_param("content", PARAM_TEXT);
        $say = $purifier->purify("content");
        if($ara[0] == required_param("valid", PARAM_TEXT)){
		    $valid = 1;
    	}else{
	  	    $valid = 0;
            $title = "<font color=\"red\"size=\"5\">驗證碼錯誤</font>";
	    }
    }
    //modify end @ 2009.08.31

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

//intree@20080227 移除特定的tag
function rmTag($str)
{
    $farr = array(
//過濾多餘的空白
        "/\s+/",
//過濾 <script 等可能引入惡意內容或惡意改變顯示佈局的code,如果不需要插入flash等,還可以加入<object的過濾
        "/<(\/?)(script|i?frame|style|html|img|object|body|title|link|meta|\?|\%)([^>]*?)>/isU",
//過濾javascript的on事件
        "/(<[^>]*)on[a-zA-Z]+\s*=([^>]*>)/isU",

  );
  $tarr = array(
        " ",
        "＜\\1\\2\\3＞",          //如果要直接清除不安全的標籤，這裡可以留空
        "\\1\\2",
  );

  $str = preg_replace( $farr,$tarr,$str);
  return $str;
}

if($valid == 1)
{
	//--防止垃圾留言20070717_jp_
	$is_local=0;
	$referer=$_SERVER['HTTP_REFERER'];
    $myser=$_SERVER['SERVER_NAME'];
    if(strpos($referer, ':') == 4)
    {
	    if(substr($referer,7,strlen($myser)) == $myser) //http
            $is_local=1;
    }
    else if(strpos($referer, ':') == 5)
    {
	    if(substr($referer,8,strlen($myser)) == $myser) //https
		    $is_local=1;
    }
    //------------------------------------
    //寄信給系統管理者
    $from = "guestbook@hsng.cs.ccu.edu.tw";  
    $fromName = "教育部數位學習平台留言版";  
    //$to = "sinjun@mail.moe.gov.tw";
    $to = "ups_moe@mail.moe.gov.tw";
    //$to = "test_moe@mail.moe.gov.tw";
    $subject = "留言內容審核"; 

	$editFormAction = $_SERVER['PHP_SELF'];
	if (isset($_SERVER['QUERY_STRING'])) {
	  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
	}	
	//echo $editFormAction;
	//if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1") && $is_local) {	//--9607jp-加上防垃圾留言
		$insertSQL = sprintf("INSERT INTO message (content, name, email, `date`) VALUES (%s, %s, %s, %s)",
			     rmTag(  GetSQLValueString(required_param("content", PARAM_TEXT), "text") ),
                     	     rmTag(  GetSQLValueString(required_param("name", PARAM_TEXT), "text") ),
                     	     rmTag(  GetSQLValueString(optional_param("email", PARAM_TEXT), "text") ),
                     	     rmTag(  GetSQLValueString($_POST['date'], "date")) );


		mysql_select_db($database_guestbook_db, $guestbook_db);
 	 	$Result1 = mysql_query($insertSQL, $guestbook_db) or die(mysql_error());

        $thisid = mysql_insert_id($dbcx);  
                     
        $Q1 = "select * from `message` where `id`=".$thisid." `date`!='2009-09-01' order by `date` desc";  
        $result1 = mysql_db_query($database_guestbook_db, $Q1);  
        $row1 = mysql_fetch_array($result1);               

        $message = "             
            親愛的系統管理者您好：<br><br>  
            以下為最新的留言內容，<br>  
            <br>  
            <table width=\"555\" height=\"161\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">  
            <tr>  
            <td height=\"36\" colspan=\"2\" valign=\"top\" background=\"http://".$HOST.$WEBROOT."images/guestbook/guestbook3_r1_c1.jpg\"><div align=\"right\">留言日期:".$row1['date']."</div></td>  
            <td height=\"36\" valign=\"top\" background=\"http://".$HOST.$WEBROOT."images/guestbook/guestbook0_r2_c5.jpg\"><img src=\"http://".$HOST.$WEBROOT."images/guestbook/guestbook1.jpg\" width=\"16\" height=\"36\"></td>  
            </tr>  
            <tr>  
            <td width=\"16\" height=\"109\" background=\"http://".$HOST.$WEBROOT."images/guestbook/guestbook_r2_c1.jpg\">&nbsp;</td>  
            <td width=\"523\" bgcolor=\"#F8F8F8\"><table width=\"497\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#B9DFFF\">  
            <table width=\"497\" style=\"border-color:#666666; border-style:dotted; border-width:1px;\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#B9DFFF\" >  
            <tr>  
            <td width=\"92\" height=\"20\" valign=\"top\" bordercolor=\"#6699FF\" background=\"http://".$HOST.$WEBROOT."images/table_bg.gif\" style=\"border-color:#666666; border-right-style: dotted ; border-right-width: 1px;\"><div align=\"center\">姓　名</div></td>  
            <td width=\"148\" valign=\"top\" bgcolor=\"#FFFFFF\" style=\"border-right-style: dotted; border-right-width: 1px;\"> 　 ".$row1['name']."</td>  
            <div align=\"center\"></div>  
            <td width=\"89\" valign=\"top\" background=\"http://".$HOST.$WEBROOT."images/table_bg.gif\" bgcolor=\"#FFFFFF\" style=\"border-right-style: dotted; border-right-width: 1px;\"><div align=\"center\">E-mail</div></td>  
            <td width=\"168\" valign=\"top\" bgcolor=\"#FFFFFF\">　<a href=\"mailto:".$row1['email']."\">".$row1['email']."</a></td>  
            </tr>  
             
            <tr>  
            <td height=\"82\" colspan=\"4\" valign=\"top\" bgcolor=\"#FFFFFF\" style=\"border-top-style: dotted; border-top-width: 1px;\"><div align=\"left\"><img src=\"http://".$HOST.$WEBROOT."images/guestbook/bookitem.gif\" width=\"20\" height=\"20\">留言內容 : ".$row1['content']."</div></td>  
            </tr>  
            </table></td>  
            <td width=\"16\" background=\"http://".$HOST.$WEBROOT."images/guestbook/guestbook_r2_c3.jpg\">&nbsp;</td></tr>  
            <tr><td width=\"16\" background=\"http://".$HOST.$WEBROOT."images/guestbook/guestbook_r2_c1.jpg\"></td>  
            <td width=\"16\" background=\"http://".$HOST.$WEBROOT."images/guestbook/guestbook_r2_c3.jpg\"></td>  
            </tr>  
            <tr>  
            <td width=\"16\" height=\"14\" background=\"http://".$HOST.$WEBROOT."images/guestbook/guestbook_r4_c1.jpg\"><img src=\"http://".$HOST.$WEBROOT."images/guestbook/guestbook_r4_c1.jpg\" width=\"16\" height=\"14\"></td>  
            <td background=\"http://".$HOST.$WEBROOT."images/guestbook/guestbook_r4_c2.jpg\"><img src=\"http://".$HOST.$WEBROOT."images/guestbook/guestbook_r4_c2.jpg\" width=\"523\" height=\"14\"></td>  
            <td width=\"16\"><img src=\"http://".$HOST.$WEBROOT."images/guestbook/guestbook_r4_c3.jpg\" width=\"16\" height=\"14\"></td>  
            </tr>  
            </table><br><br>  
            如欲公開該留言請點選下面連結：<br>  
            <a href=\"http://".$HOST.$WEBROOT."Guest_Book/mail_act.php?mid=".$row1[id]."&action=release\">http://".$HOST.$WEBROOT."Guest_Book/mail_act.php?mid=".$row1[id]."&action=release</a><br>  
            如欲刪除該留言請點選下面連結：<br>  
            <a href=\"http://".$HOST.$WEBROOT."Guest_Book/mail_act.php?mid=".$row1[id]."&action=delete\">http://".$HOST.$WEBROOT."Guest_Book/mail_act.php?mid=".$row1[id]."&action=delete</a><br><br>  
            這是系統自動發出的信件，請勿回覆。<br>  
            ";  
         
        $check = mailto($from, $fromName, $to, $subject, $message); 

  		$insertGoTo = "index.php";
  		if (isset($_SERVER['QUERY_STRING'])) {
    			$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    			$insertGoTo .= $_SERVER['QUERY_STRING'];
		}
  		header(sprintf("Location: %s", $insertGoTo));
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<script language="javascript" type="text/javascript" src="../script/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="../script/tiny_mce/usable_proprities_guest.js"></script>
<script language=javascript>

function check_field() {
  if(!confirm("你確定要留言嗎!!"))
  	return;
  
  re = /^[ ]+|[ ]+$/g;
  if (document.form1.name.value.replace(re, "") == "" ){ 
    alert("請輸入姓名 !");
	return ;
  }
  //if (document.form1.content.value.replace(re, "") == "" ){ 
  if (tinyMCE.getContent()== "" ){ 
    alert("請輸入內容 !");
	return ;
  }
  window.alert("為促使留言板的使用與管理更有效率，您所留下的訊息將不會立即呈現於版面上。\n所以請不要重複留言！訊息將經由系統管理者謹慎蒐集整理相關的資訊後，再一併呈現出來。");
  document.form1.submit();
}
</script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>留言</title>
<link href="../themes/IE2/css/content.css" rel="stylesheet" type="text/css" />

<STYLE type=text/css>
@import url("./creatop.css");
.style3 {color: #009999}
.style4 {color: #666666}
</STYLE>
</head>

<body>
<div align="center">
<form name="form1" method="POST" action="<?php echo $editFormAction; ?>" onSubmit="return check_field()" >
<h1 align="left">留言板</h1>
<table width="519" height="159" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="36" colspan="2" valign="top" background="../images/guestbook/guestbook3_r1_c1.jpg"><div align="right"></div></td>
    <td height="36" valign="top" background="../images/guestbook/guestbook0_r2_c5.jpg"><img src="../images/guestbook/guestbook1.jpg" width="16" height="36"></td>
  </tr>
  <tr>
    <td width="14" height="104" background="../images/guestbook/guestbook_r2_c1.jpg">&nbsp;</td>
    <td width="489" bgcolor="#F8F8F8"><table width="489" style="border-color:#666666; border-style:dotted; border-width:1px;" align="center" cellpadding="0" cellspacing="0" bordercolor="#B9DFFF" >
        <!--DWLayoutTable-->
        <tr>
          <td width="91" height="20" valign="top" bordercolor="#6699FF" background="../images/table_bg.gif" style="border-color:#666666; border-right-style: dotted ; border-right-width: 1px;><div align="center"><div align="center">姓　名 </div></td>
          <td width="147" valign="top" bgcolor="#FFFFFF" style="border-right-style: dotted; border-right-width: 1px;> 　 <span class="style4">
              <div align="center">
                <input name="name" type="text" maxlength="10" value="<?php echo $name; ?>">
              </div></td>
          <td width="88" valign="top" background="../images/table_bg.gif" bgcolor="#FFFFFF" style="border-right-style: dotted; border-right-width: 1px;><div align="center"><div align="center">E-mail</div></td>
          <td width="161" valign="top" bgcolor="#FFFFFF"><input name="email" type="text" maxlength="50" value="<?php echo $email; ?>"></td>
        </tr>
        <tr bgcolor="#F0F0F0">
          <td height="84" colspan="4" valign="top" style="border-top-style: dotted; border-top-width: 1px;><div align="left"><p align="left"><img src="../images/guestbook/bookitem.gif" width="20" height="20"> 留言內容： </p>
            <p align="center">              <textarea name="content" cols="50" rows="25"><?php echo $say; ?></textarea>
</p>
            <p align="left">&nbsp; </p>
            <table border="0" align="center" class="datatable" margin-right="20px">
              <tr>
                <th colspan="2"><div align="left">"請填入驗證碼，驗證碼為圖形顯示數字!!"
                  </div>                  </th>
                </tr>
              <tr>
                <th width="60">驗證碼</th>
                <td width="344" align="left"><table border=0>
                    <tr>
                      <input name="valid" type="text" maxlength="4">
                    </tr>
                    <img src="ImgGenerator.php" alt="點此刷新驗證碼" name="verify_code" width="100" height="40" border="0" id="verify_code"onclick="document.getElementById('verify_code').src='ImgGenerator.php?' + Math.random();">
                  </table>
            <?php echo $title; ?></td>
              </tr>
            </table>
            <p align="center">&nbsp;           </p></td>
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
<input type="button" name="Submit" value="送出"  onClick="check_field()">
  <input type="reset" name="Submit" value="重設">
  <input type="hidden" name="MM_insert" value="form1">
  <input type="hidden" name="date" value="<?php echo date('Y-m-d-H-i-s') ?>"> 
  <input type="hidden" name="v" value="1">
</form>
</div>
</body>
</html>
