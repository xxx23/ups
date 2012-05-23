<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>留言版管理</title>
<link href="../themes/IE2/css/content.css" rel="stylesheet" type="text/css" />
<STYLE type=text/css>
 @import url("./creatop.css");
</STYLE>

<STYLE type=text/css>
.style3 {color: #009999}
.style4 {color: #666666}
.style6 {color: #FF0000}
</STYLE>
<script language="javascript" type="text/javascript" src="../script/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="../script/tiny_mce/usable_proprities_guest.js"></script>
</head>
<?php
//由Ecourse直接移植過來 by w60292
//管理者登入管理留言

require 'Connections/guestbook_db.php';
require_once("../session.php");
//add for pure html
require_once '../library/purifier/HTMLPurifier.auto.php';
$config = HTMLPurifier_Config::createDefault();
//$config->set('HTML', 'Allowed', 'p,br,strong,em,u,
  //span[style|class],a[href|target]');
$config->set( 'CSS.AllowTricky',true);
$purifier = new HTMLPurifier($config);
//end
checkAdmin();
//$id = $_POST['id'];
//$passwd = $_POST['passwd'];
$mid = $_POST['mid'];
$action = $_POST['action'];
$text_reply = $purifier->purify(str_ireplace("\\\"","",$_POST['text_reply']));
//print_r($_POST['text_reply']);
//print_r(str_ireplace("\\\"","",$_POST['text_reply']));
$rid = $_POST['rid'];

global $database_guestbook_db;

//if($id=="cyber2_admin" && $passwd=="elearn")
//{	//id, parent_id, content, name, email, date
	if($action=="delete")
	{
		$Q0 = "delete from message where id=$mid";
        //die($Q0);
		mysql_db_query($database_guestbook_db, $Q0);
    }
    if($action=="release")
    {
        $yn = $_POST['yn'];
        if($yn == 0)
            $Q0 = "update `message` set `release` = '1' where `id` = $mid";
        else
            $Q0 = "update `message` set `release` = '0' where `id` = $mid";
        mysql_db_query($database_guestbook_db, $Q0);
    }
	if($action=="reply_done")
	{
		$Q = "select content from message where id=$rid";
		$result = mysql_db_query($database_guestbook_db, $Q);
		$row = mysql_fetch_array($result);
		//$row= db_getOne($Q);
		
		//$reply_content = $row['content']."<br><br>回覆：<br><font color=green>".$text_reply."</font>";
		$reply_content = $row['content']."<br><br>回覆：<br>".$text_reply."";
		$Q0 = "update message set content='$reply_content' where id=$rid";
		mysql_db_query($database_guestbook_db, $Q0);
    }
    if($action=="reply_del")
    {
        $Q = "select content from message where id=$mid";
		$result = mysql_db_query($database_guestbook_db, $Q);
		$row = mysql_fetch_array($result);
		//$row= db_getOne($Q);
        //$del_reply_content = $row;
        $del_reply_content = $row['content'];
        $content = split('<br><br>', $del_reply_content);
        //原始留言為$content[0]，第一次回覆為$content[1]，以此類推...
        
        $Q0 = "update message set content='$content[0]' where id=$mid";
        mysql_db_query($database_guestbook_db, $Q0);
    }
	echo "<head><title>管理留言板</title></head><body><h1>留言板管理</h1><center>";
	$Q1 = "select * from message where date!='2009-09-01' order by date desc";
    //deal with lantin and utf8
    //$Q1 = "select * from message where date!='2009-09-01' 
     //   and DATEDIFF('2011-01-21 19:57:12',date ) <= 0
      //  order by date desc";
	//$result1 = db_query($Q1);
	//while($row1 = $result1->fetchRow(DB_FETCHMODE_ASSOC))
    //mysql_query("SET CHARACTER SET latin1"); 
   // mysql_query("SET CHARACTER SET UTF8"); 
    //mysql_query("SET CHARACTER_SET_RESULTS=UTF8'");

    $Q1 = "select * from message where date!='2009-09-01' 
        and DATEDIFF('2011-01-20 17:06:47',date ) <= 0
        order by date desc";
	$result1 = mysql_db_query($database_guestbook_db,$Q1);
    $gu = array();
	while($row1 = mysql_fetch_array($result1))
        array_push($gu,$row1);
    $Q1 = "select * from message where date!='2009-09-01' 
        "//and DATEDIFF('2011-01-20 17:06:47',date ) > 0
        //and DATEDIFF('2011-01-24 20:33:15',date ) <= 0
        ."and date between '2011-01-20 17:06:47' and '2011-01-24 20:33:15'
        order by date desc";
    mysql_query("SET CHARACTER SET UTF8"); 

	$result1 = mysql_db_query($database_guestbook_db,$Q1);
	while($row1 = mysql_fetch_array($result1))
        array_push($gu,$row1);
        print_r($row1);
    $Q1 = "select * from message where date!='2009-09-01' 
        and DATEDIFF('2011-01-24 20:33:15',date ) > 0
        order by date desc";
    mysql_query("SET CHARACTER SET latin1");
	$result1 = mysql_db_query($database_guestbook_db,$Q1);
	while($row1 = mysql_fetch_array($result1))
        array_push($gu,$row1);
	//while($row1 = mysql_fetch_array($result1))
    foreach($gu as $row1)
	{
	  	echo "<table width=\"555\" height=\"161\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
		
		  <tr>
    <td height=\"36\" colspan=\"2\" valign=\"top\" background=\"../images/guestbook/guestbook3_r1_c1.jpg\"><div align=\"right\">留言日期:".$row1['date']."</div></td>
  <td height=\"36\" valign=\"top\" background=\"../images/guestbook/guestbook0_r2_c5.jpg\"><img src=\"../images/guestbook/guestbook1.jpg\" width=\"16\" height=\"36\"></td>
  </tr>
			<tr> 
			<td width=\"16\" height=\"109\" background=\"../images/guestbook/guestbook_r2_c1.jpg\">&nbsp;</td>
		      <td width=\"523\" bgcolor=\"#F8F8F8\"><table width=\"497\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#B9DFFF\">
			<table width=\"497\" style=\"border-color:#666666; border-style:dotted; border-width:1px;\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#B9DFFF\" >
			  <tr>
			    <td width=\"92\" height=\"20\" valign=\"top\" bordercolor=\"#6699FF\" background=\"../images/table_bg.gif\" style=\"border-color:#666666; border-right-style: dotted ; border-right-width: 1px;\"><div align=\"center\">姓　名</div></td>
				<td width=\"148\" valign=\"top\" bgcolor=\"#FFFFFF\" style=\"border-right-style: dotted; border-right-width: 1px;\"> 　 ".$row1['name']."</td>
				<div align=\"center\"></div></td>
      			<td width=\"89\" valign=\"top\" background=\"../images/table_bg.gif\" bgcolor=\"#FFFFFF\" style=\"border-right-style: dotted; border-right-width: 1px;\"><div align=\"center\">E-mail</div></td>
        		<td width=\"168\" valign=\"top\" bgcolor=\"#FFFFFF\">　<a href=\"mailto:".$row1['email']."\">".$row1['email']."</a></td>
     		 </tr>
			 
			<tr>
				<td height=\"82\" colspan=\"4\" valign=\"top\" bgcolor=\"#FFFFFF\" style=\"border-top-style: dotted; border-top-width: 1px;\"><div align=\"left\"><img src=\"../images/guestbook/bookitem.gif\" width=\"20\" height=\"20\">留言內容 : ".($row1['content'])."</div></td> 
			</tr>
			</table></td>
			<td width=\"16\" background=\"../images/guestbook/guestbook_r2_c3.jpg\">&nbsp;</td></tr>
		<tr><td width=\"16\" background=\"../images/guestbook/guestbook_r2_c1.jpg\"></td>
		<td bgcolor=\"#B9DFFF\"><div align=\"center\"><form method=post action=reply.php>
			    <input type=hidden name=id value=admin>
			    <input type=hidden name=passwd value=test>
			    <input type=hidden name=mid value=".$row1['id'].">
			    <input type=hidden name=action value=reply>
			    <input type=submit name=reply value=管理者回覆>
                </form>
            <form method=post action=login.php>
                 <input type=hidden name=id value=cyber2_admin>
                 <input type=hidden name=passwd value=elearn>
                 <input type=hidden name=mid value=".$row1[id].">
                 <input type=hidden name=yn value=".$row1[release].">
                 <input type=hidden name=action value=release>";
        if($row1['release'] == 0)
                 echo "<input type=submit name=release value=公開留言 onclick=\"return confirm('確定要公開此留言嗎?')\">";
        else
                 echo "<input type=submit name=release value=不公開留言 onclick=\"return confirm('確定不要公開此留言嗎?')\">";
        echo "
            </form>
             <form method=post action=login.php>
             <input type=hidden name=id value=cyber2_admin>
             <input type=hidden name=passwd value=elearn>
             <input type=hidden name=mid value=".$row1[id].">
             <input type=hidden name=action value=reply_del>
             <input type=submit name=delete value=刪除回覆 onclick=\"return confirm('確定要刪除此則留言的回覆訊息嗎?')\">
             </form>
             <form method=post action=login.php>
			 <input type=hidden name=id value=cyber2_admin>
			 <input type=hidden name=passwd value=elearn>
			 <input type=hidden name=mid value=".$row1[id].">
			 <input type=hidden name=action value=delete>
			 <input type=submit name=delete value=刪除留言 onclick=\"return confirm('確定要刪除此留言嗎?')\">		
			</form></div></td>
			<td width=\"16\" background=\"../images/guestbook/guestbook_r2_c3.jpg\"></td>
			</tr>
			<tr>
			    <td width=\"16\" height=\"14\" background=\"../images/guestbook/guestbook_r4_c1.jpg\"><img src=\"../images/guestbook/guestbook_r4_c1.jpg\" width=\"16\" height=\"14\"></td>
    <td background=\"../images/guestbook/guestbook_r4_c2.jpg\"><img src=\"../images/guestbook/guestbook_r4_c2.jpg\" width=\"523\" height=\"14\"></td>
    <td width=\"16\"><img src=\"../images/guestbook/guestbook_r4_c3.jpg\" width=\"16\" height=\"14\"></td>
  </tr>
</table><br>
			";
	}
//}
/*
else
{
	echo "<head>
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
	<title>管理者登入</title>
	</head>
	<body>
	<center>
	<p>管理者登入</p>
	<form method=\"post\" action=\"login.php\">
	帳號：
	  <input type=\"text\" name=\"id\" size=\"15\">
	<br>
	密碼：
	  <input type=\"password\" name=\"passwd\" size=\"15\">
	<br>
	  <input type=\"submit\" name=\"submit\" value=\"登入\">
	  <input type=\"reset\" name=\"reset\" value=\"清除\">
	</form>
	</center>
	</body>
	</html>";
}
 */
?>
