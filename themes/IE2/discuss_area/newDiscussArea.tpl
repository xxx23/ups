<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>新增討論區</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">

<link href="/themes/cutestyle1/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="/themes/cutestyle1/css/content.css" rel="stylesheet" type="text/css" />
<link href="/themes/cutestyle1/css/table.css" rel="stylesheet" type="text/css" />
<link href="/themes/cutestyle1/css/form.css" rel="stylesheet" type="text/css" />

{literal}

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
		message = message + '正確數目';
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

function display(option){
	document.getElementById("inner_contentA").style.display="none";
	document.getElementById("inner_contentB").style.display="none";

	if(option == 1){
		document.getElementById("inner_contentA").style.display = "";
		document.getElementsByTagName("body")[0].id = "tabA";
	}
	else if(option == 2){
		//document.getElementById("inner_contentB").style.visibility = "visible";
		document.getElementById("inner_contentB").style.display = "";
		//document.getElementById("_content").style.width = "100%";
		document.getElementsByTagName("body")[0].id = "tabB";
	}
}

</SCRIPT>

{/literal}

<META content="MSHTML 6.00.2900.3020" name=GENERATOR>

</HEAD>
<body class="ifr" id="tabA">

<div class="tab">
	<ul id="tabnav">
		<li class="tabA" onClick="display(1)">建立單一討論區</li>
		<li class="tabB" onClick="display(2)">批次建立多個討論區</li>
	</ul>
</div>

<div class="inner_contentA" id="inner_contentA">
	<fieldset>
	<legend><h1>建立單一討論區</h1></legend>
	
<form name="create_dis" onsubmit="return checkinput();" action="newDiscussAreaSave.php" method="post">
<table width="75%" border="2">
<caption>建立單一討論區</caption>
<tr bgColor="#edf3fa">
	<td>討論區名稱</td>
	<td bgColor="#cdeffc"><input maxLength="160" size="50" name="discuss_name" value="{$discuss_name}"></td>
</tr>
<tr bgColor="#edf3fa">
	<td>討論區主旨 </td>
	<td bgColor="#cdeffc"><input type="text" maxLength="255" size="50" name="discuss_title" value="{$discuss_title}"></td>
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

	</fieldset>
</div>

<div class="inner_contentB" id="inner_contentB" style="display:none;"> 
	<fieldset>
	<legend><h1>批次建立多個討論區</h1></legend>
	
<form name=create_batch onsubmit="return checkinput2();" action=cre_discuss.php method=post>

<table width="75%" border=2>
<CAPTION>批次建立討論區</CAPTION>
<tr bgColor=#edf3fa>
	<td>欲建立討論區數目 </td>
	<td bgColor=#cdeffc><input maxLength=8 size=5 name=amount> </td>
</tr>
<tr bgColor=#edf3fa>
	<td>討論區名稱(請將要用數字取代的地方用 %d 代替)</td> 
	<td bgColor=#cdeffc><input maxLength=100 size=30 name=discuss_name> </td>
</tr>
<tr bgColor=#edf3fa>
	<td>討論區主旨 </td>
	<td bgColor=#cdeffc><input type="text" maxLength=100 size=30 name="discuss_title"> </td>
</tr>
<tr bgColor=#edf3fa>
	<td>是否為小組討論區 </td>
	<td bgColor=#cdeffc>
		<input type=radio CHECKED value=0 name=isgroup>否 
		<input type=radio value=1 name=isgroup>是 
	</td>
</tr>
<tr bgColor=#edf3fa>
	<td>討論區瀏覽權限 </td>
	<td bgColor=#cdeffc>
		<input type=radio CHECKED value=0 name=access>公開 
		<input type=radio value=1 name=access>私人(只有小組成員可以看) 
	</td>
</tr>
</table>

<input type=submit value=確定新增 name=submit>
<input type=reset value=重設 name=reset> 

</form>
	</fieldset>
</div>

</BODY>
</HTML>
