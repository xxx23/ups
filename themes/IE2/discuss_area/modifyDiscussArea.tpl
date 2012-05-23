<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<!-- saved from url=(0105)http://ecdemo.elearning.ccu.edu.tw/php/discuss/cre_discuss.php?PHPSESSID=d139ddec805f81c4f8b99d3c4930c742 -->
<HTML><HEAD><TITLE>新增討論區</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">

{literal}

<STYLE type=text/css>
BODY 
{
	SCROLLBAR-FACE-COLOR: #4d6eb2; SCROLLBAR-SHADOW-COLOR: #054878; SCROLLBAR-3DLIGHT-COLOR: black; SCROLLBAR-ARROW-COLOR: #ffffff; SCROLLBAR-TRACK-COLOR: #ddddff
}
</STYLE>
<LINK href="{$cssPath}main-body.css" type=text/css rel=stylesheet>

<SCRIPT language="javascript">
function checkinput( ) 
{
	var flag = true;
	var message = '請輸入';
	
	if( create_dis.discuss_name.value.length > 0) 
	{
		flag = true && flag;
	}
	else {
		flag = false && flag;
		message = message + ' 討論區名稱';
	}

	if(create_dis.discuss_title.value.length > 0) 
	{
		flag = true && flag;
	}
	else {
		flag = false && flag;
		message = message + ' 討論區主旨';
	}

/*
	if(create_dis.isgroup[0].checked) 
	{
		flag = true && flag;
	}
	else {
		if(isNaN(parseInt(create_dis.group_num.value))) 
		{
			flag = false && flag;
			message = message + ' 正確組別';
		}
		else
		{
			flag = true && flag;			
		}
	}
*/
	if(!flag) 
	{
		alert(message);
	}
	return flag;
}

function checkinput2( ) 
{
	var flag = true;
	var message = '請輸入';
	
	if(isNaN(parseInt(create_batch.amount.value))) 
	{
		flag = false && flag;
		message = message + ' 正確數目';
	}
	else {
		flag = true && flag;
	}

	if( create_batch.discuss_name.value.length > 0) 
	{
		flag = true && flag;
	}
	else 
	{
		flag = false && flag;
		message = message + ' 討論區名稱';
	}

	if( create_batch.discuss_name.value.indexOf("%d") == -1 )
	 {
		flag = false && flag;
		message = message + ' \%d';	
	}

	if( create_batch.discuss_title.value.length > 0) 
	{
		flag = true && flag;
	}
	else 
	{
		flag = false && flag;
		message = message + ' 討論區主旨';
	}

	if(!flag) 
	{
		alert(message);
	}
	return flag;
}
</SCRIPT>

{/literal}

<META content="MSHTML 6.00.2900.3020" name=GENERATOR>

</HEAD>
<BODY background="{$imagePath}bg.gif">

<img src="{$imagePath}b52.gif"> 

<center>

<form name="create_dis" onSubmit="return checkinput();" action="newDiscussAreaSave.php" method="post">
<table border="2">
<caption>建立單一討論區</caption>
<tr>
	<td>討論區名稱</td>
	<td><input maxLength="160" size="50" name="discuss_name"></td>
</tr>
<tr>
	<td>討論區主旨 </td>
	<td><input type="text" maxLength="255" size="50" name="discuss_title"> </td>
</tr>
<!--
<tr bgColor="#edf3fa">
	<td>是否為小組討論區 </td>
	<td bgColor="#cdeffc">
		<input type=radio CHECKED value=0 name=isgroup>否 
		<input type=radio value=1 name=isgroup>是第
		<input onfocus="create_dis.isgroup[1].checked = true;" maxLength=2 size=2 name=group_num>組 
	</td>
</tr>
<tr bgColor="#edf3fa">
	<td>討論區瀏覽權限 </td>
	<td bgColor="#cdeffc">
		<input type=radio CHECKED value=0 name=access>公開 
		<input type=radio value=1 name=access>私人(只有小組成員可以看) 
	</td>
</tr>
-->
</table>

<input type="submit" value="確定新增" name="submit">
<input type="reset" value="重設" name="reset"> 

</form>

<HR>

<input onClick="location.href='showDiscussAreaList.php'" type="button" value="回討論區一覽"> 

</center>

</BODY>
</HTML>
