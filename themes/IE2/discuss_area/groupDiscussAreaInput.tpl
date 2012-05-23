<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>新增討論區</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
{literal}

<SCRIPT language="javascript">


function styleDisplay(value, id)
{

	document.getElementById(id).style.display = value;

}

function checkinput( ) 
{
	var flag = true;
	var message = '請輸入';
	var discuss_name = document.getElementsByName('discuss_name');
    var discuss_title = document.getElementsByName('discuss_title');
//	if( create_dis.discuss_name.value.length > 0) 
    if(discuss_name[0].value.length > 0)
	{
		flag = true && flag;
	}
	else {
		flag = false && flag;
		message = message + ' 討論區名稱';
	}

	//if(create_dis.discuss_title.value.length > 0) 
    if(discuss_title[0].value.length > 0)
	{
		flag = true && flag;
	}
	else {
		flag = false && flag;
		message = message + ' 討論區主旨';
	}


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
	var discuss_name = document.getElementsByName('discuss_name');
    var discuss_title = document.getElementsByName('discuss_title');
    var amount = document.getElementsByName('amount');
	var amount_len = amount[0].value.length;
      
    //if(isNaN(parseInt(create_batch.amount.value)))
    if(isNaN(parseInt(amount[0].value))) 
    {
		flag = false && flag;
		message = message + ' 正確數目';
	}
	else {
        for(var i=0;i<amount_len;i++)
        {
            if(isNaN(parseInt(amount[0].value.charAt(i))))
            {
                flag = false && flag;
                message = message + '正確數目';
                break;
            }
            else
            {
                if(i==(amount-1))
                    flag = true && flag;
            }
        }    
        //flag = true && flag;
	}

	//if( create_batch.discuss_name.value.length > 0) 
	if( discuss_name[1].value.length > 0) 
	{
		flag = true && flag;
	}
	else 
	{
		flag = false && flag;
		message = message + ' 討論區名稱';
	}

	//if( create_batch.discuss_name.value.indexOf("%d") == -1 )
    if( discuss_name[1].value.indexOf("%d") == -1 )
	{
		flag = false && flag;
		message = message + ' \%d';	
	}

	//if( create_batch.discuss_title.value.length > 0) 
	if( discuss_title[1].value.length > 0) 
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


</HEAD>
<body id="tabA">
{if $action == "new"}
<h1>新增教師社群討論區</h1>
{else}
<h1>修改教師社群討論區</h1>
{/if}

{if $action == "new"}	
<div class="tab">
	<ul id="tabnav">
		<li class="tabA" onClick="display(1)">建立單一教師社群討論區</li>	
{if $displayType != 'onlyGroup'}
		<li class="tabB" onClick="display(2)">批次建立多個教師社群討論區</li>
{/if}
	</ul>
</div>
{/if}

{if $action == "new"}
<div class="form" id="inner_contentA">
	<form name="create_dis" onsubmit="return checkinput();" action="newGroupDiscussAreaSave.php" method="post">
{else}
<div class="form" id="inner_contentA">
	<form name="create_dis" onSubmit="return checkinput();" action="modifyGroupDiscussAreaSave.php" method="post">
{/if}

<table class="datatable">
<tr>
	<th>教師社群討論區名稱</th>
	<td><input maxLength="160" size="50" name="discuss_name" value="{$discuss_name}"></td>
</tr>
<tr>
	<th>教師社群討論區主旨 </th>
	<td><input type="text" maxLength="255" size="50" name="discuss_title" value="{$discuss_title}"></td>
</tr>
<!-- edit by carlcarl
<tr>
	<th>討論區類型 </th>
	<td>
	{if $displayType != 'onlyGroup'}
		<input type="radio" {if $discuss_type==0}checked{/if} value="0" name="discuss_type" onClick="styleDisplay('none', 'tr_access1')&styleDisplay('none', 'tr_studentList1')">一般
	{/if}
		<input type="radio" {if $discuss_type==1}checked{/if} value="1" name="discuss_type" onClick="styleDisplay('block', 'tr_access1')&styleDisplay('block', 'tr_studentList1')">小組
	{if $displayType != 'onlyGroup'}
		<input type="radio" {if $discuss_type==2}checked{/if} value="2" name="discuss_type" onClick="styleDisplay('none', 'tr_access1')&styleDisplay('none', 'tr_studentList1')">精華區	</td>
	{/if}
</tr>-->
<!--<input type="hidden" value="3" name="discuss_type" />-->


<tr id="tr_access1" style="display:{if $discuss_type==1}block{else}none{/if}">
	<th>討論區瀏覽權限 </th>
	<td>
		<input type="radio" {if $access==0}checked{/if} value="0" name="access">公開 
		<input type="radio" {if $access==1}checked{/if} value="1" name="access">私人(只有小組成員可以看)
	</td>
</tr>
<tr id="tr_studentList1" style="display:{if $discuss_type==1}block{else}none{/if}">
	<th>小組成員</th>
	<td>
		<input type="hidden" name="studentNum" value="{$studentNum}">
		{section name=counter loop=$studentList}
		<input type="checkbox" name="student_{$studentList[counter].counter}" value="{$studentList[counter].student_id}" {if $studentList[counter].isInGroup == 1}checked{/if}>{$studentList[counter].student_name}
		{/section}
	</td>
</tr>
</table>
<p class="al-left">
<input type="hidden" name="behavior" value="{$behavior}">
<input type="hidden" name="action" value="{$action}">
<input type="hidden" name="discuss_cd" value="{$discuss_cd}">
{if $action == "new"}
<input type="submit" value="新增教師社群討論區" name="submit" class="btn">
{else}
<input type="submit" value="修改教師社群討論區" name="submit" class="btn">
{/if}
<input type="reset" value="重設" name="reset" class="btn"> 
{if $action == "modify"}
<input type="button"  value="回上一頁" name="back" onClick="location.href='{$absoluteURL}showGroupDiscussAreaList.php?behavior={$behavior}'" class="btn"> 
{/if}
</p>
</form>
</div>

{if $action == "new"}
<div class="form" id="inner_contentB" style="display:none;"> 
<form name="create_batch" onSubmit="return checkinput2();" action="newGroupDiscussAreaSave.php" method="post">
<table class="datatable">
<tr>
	<th>欲建立討論區數目 </th>
	<td><input maxLength="8" size="5" name="amount"> </td>
</tr>
<tr>
	<th>討論區名稱</th> 
	<td><input maxLength="100" size="30" name="discuss_name"> <br />(請將要用數字取代的地方用 %d 代替)</td>
</tr>
<tr>
	<th>討論區主旨 </th>
	<td><input type="text" maxLength="100" size="30" name="discuss_title"> </td>
</tr>
<!-- edit by carlcarl
<tr>
	<th>討論區類型 </th>
	<td>
		<input type="radio" checked value="0" name="discuss_type" onClick="styleDisplay('none', 'tr_access2')&styleDisplay('none', 'tr_studentList2')">一般
		<input type="radio"  value="1" name="discuss_type" onClick="styleDisplay('block', 'tr_access2')&styleDisplay('block', 'tr_studentList2')">小組
		<input type="radio"  value="2" name="discuss_type" onClick="styleDisplay('none', 'tr_access2')&styleDisplay('none', 'tr_studentList2')">精華區
	</td>
</tr>
-->
<tr id="tr_access2" style="display:none">
	<th>討論區瀏覽權限 </th>
	<td>
		<input type="radio" CHECKED value="0" name="access">公開 
		<input type="radio" value="1" name="access">私人(只有小組成員可以看) 
	</td>
</tr>
<tr id="tr_studentList2" style="display:none">
	<th>小組成員</th>
	<td>
		<input type="hidden" name="studentNum" value="{$studentNum}">
		{section name=counter loop=$studentList}
		<input type="checkbox" name="student_{$studentList[counter].counter}" value="{$studentList[counter].student_id}" >{$studentList[counter].student_name}
		{/section}
	</td>
</tr>
</table>
<p class="al-left">
<input type="hidden" name="action" value="batch">
<input type="submit" value="新增討論區" name="submit" class="btn">
<input type="reset" value="重設" name="reset" class="btn"> 
</p>
</form>

</div>
{/if}

</BODY>
</HTML>
