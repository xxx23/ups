{config_load file='common.lang'} 
{config_load file='discuss_area/discussAreaInput.lang'}

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>{#add_discuss_area#}</TITLE>
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
    {/literal}
	var message = '{#please_enter#}';
    {literal}
	var discuss_name = document.getElementsByName('discuss_name');
    var discuss_title = document.getElementsByName('discuss_title');
//	if( create_dis.discuss_name.value.length > 0) 
    if(discuss_name[0].value.length > 0)
	{
		flag = true && flag;
	}
	else {
		flag = false && flag;
        {/literal}
		message = message + ' {#discuss_area_name#}';
        {literal}
	}

	//if(create_dis.discuss_title.value.length > 0) 
    if(discuss_title[0].value.length > 0)
	{
		flag = true && flag;
	}
	else {
		flag = false && flag;
        {/literal}
		message = message + ' {#discuss_area_subject#}';
        {literal}
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
    {/literal}
	var message = '{#please_enter#}';
    {literal}
	var discuss_name = document.getElementsByName('discuss_name');
    var discuss_title = document.getElementsByName('discuss_title');
    var amount = document.getElementsByName('amount');
	var amount_len = amount[0].value.length;
      
    
    //if(isNaN(parseInt(create_batch.amount.value)))
    if(isNaN(parseInt(amount[0].value))) 
    {
		flag = false && flag;
        {/literal}
		message = message + ' {#right_number#}';
        {literal}
	}
	else {
        for(var i=0;i<amount_len;i++)
        {
             
            if(isNaN(parseInt(amount[0].value[i])))
            {
                flag = false && flag;
                {/literal}
                message = message + '{#right_number#}';
                {literal}
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
        {/literal}
		message = message + ' {#discuss_area_name#}';
        {literal}
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
        {/literal}
		message = message + ' {#discuss_area_subject#}';
        {literal}
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
<h1>{#add_discuss_area#}</h1>
{else}
<h1>{#modify_discuss_area#}</h1>
{/if}

{if $action == "new"}	
<div class="tab">
	<ul id="tabnav">
		<li class="tabA" onClick="display(1)">{#create_single_discuss_area#}</li>	
{if $displayType != 'onlyGroup'}
		<li class="tabB" onClick="display(2)">{#create_multiple_discuss_area#}</li>
{/if}
	</ul>
</div>
{/if}

{if $action == "new"}
<div class="form" id="inner_contentA">
	<form name="create_dis" onsubmit="return checkinput();" action="newDiscussAreaSave.php" method="post">
{else}
<div class="form" id="inner_contentA">
	<form name="create_dis" onSubmit="return checkinput();" action="modifyDiscussAreaSave.php" method="post">
{/if}

<table class="datatable">
<tr>
	<th>{#discuss_area_name#}</th>
	<td><input maxLength="160" size="50" name="discuss_name" value="{$discuss_name}"></td>
</tr>
<tr>
	<th>{#discuss_area_subject#} </th>
	<td><input type="text" maxLength="255" size="50" name="discuss_title" value="{$discuss_title}"></td>
</tr>
<tr>
	<th>{#discuss_area_type#} </th>
	<td>
	{if $displayType != 'onlyGroup'}
		<input type="radio" {if $discuss_type==0}checked{/if} value="0" name="discuss_type" onClick="styleDisplay('none', 'tr_access1')&styleDisplay('none', 'tr_studentList1')">{#normal#}
	{/if}
		<input type="radio" {if $discuss_type==1}checked{/if} value="1" name="discuss_type" onClick="styleDisplay('block', 'tr_access1')&styleDisplay('block', 'tr_studentList1')">{#group#}
	{if $displayType != 'onlyGroup'}
		<input type="radio" {if $discuss_type==2}checked{/if} value="2" name="discuss_type" onClick="styleDisplay('none', 'tr_access1')&styleDisplay('none', 'tr_studentList1')">{#digest#}	</td>
	{/if}
</tr>
<tr id="tr_access1" style="display:{if $discuss_type==1}block{else}none{/if}">
	<th>{#discuss_area_view_permission#} </th>
	<td>
		<input type="radio" {if $access==0}checked{/if} value="0" name="access">{#public#} 
		<input type="radio" {if $access==1}checked{/if} value="1" name="access">{#private_only_group_member_can_see_it#}
	</td>
</tr>
<tr id="tr_studentList1" style="display:{if $discuss_type==1}block{else}none{/if}">
	<th>{#group_member#}</th>
	<td>
		<input type="hidden" name="studentNum" value="{$studentNum}">
		{section name=counter loop=$studentList}
		<input type="checkbox" name="student_{$studentList[counter].counter}" value="{$studentList[counter].student_id}" {if $studentList[counter].isInGroup == 1}checked onclick="this.checked=!this.checked;" {/if}>{$studentList[counter].student_name}
		{/section}
	</td>
</tr>
</table>
<p class="al-left">
<input type="hidden" name="behavior" value="{$behavior}">
<input type="hidden" name="action" value="{$action}">
<input type="hidden" name="discuss_cd" value="{$discuss_cd}">
{if $action == "new"}
<input type="submit" value="{#add_discuss_area#}" name="submit" class="btn">
{else}
<input type="submit" value="{#modify_discuss_area#}" name="submit" class="btn">
{/if}
<input type="reset" value="{#reset#}" name="reset" class="btn"> 
{if $action == "modify"}
<input type="button"  value="{#back_to_previous_page#}" name="back" onClick="location.href = '{$webroot}Discuss_Area/showDiscussAreaList.php?behavior={$behavior}'" class="btn"> 
{/if}
</p>
</form>
</div>

{if $action == "new"}
<div class="form" id="inner_contentB" style="display:none;"> 
<form name="create_batch" onSubmit="return checkinput2();" action="newDiscussAreaSave.php" method="post">
<table class="datatable">
<tr>
	<th>{#number_of_discuss_area_you_want_create#} </th>
	<td><input maxLength="8" size="5" name="amount"> </td>
</tr>
<tr>
	<th>{#discuss_area_name#}</th> 
	<td><input maxLength="100" size="30" name="discuss_name"> <br />{#please_use_d_to_replace_the_number#}</td>
</tr>
<tr>
	<th>{#discuss_area_subject#} </th>
	<td><input type="text" maxLength="100" size="30" name="discuss_title"> </td>
</tr>
<tr>
	<th>{#discuss_area_type#} </th>
	<td>
		<input type="radio" checked value="0" name="discuss_type" onClick="styleDisplay('none', 'tr_access2')&styleDisplay('none', 'tr_studentList2')">{#normal#}
		<input type="radio"  value="1" name="discuss_type" onClick="styleDisplay('block', 'tr_access2')&styleDisplay('block', 'tr_studentList2')">{#group#}
		<input type="radio"  value="2" name="discuss_type" onClick="styleDisplay('none', 'tr_access2')&styleDisplay('none', 'tr_studentList2')">{#digest#}
	</td>
</tr>
<tr id="tr_access2" style="display:none">
	<th>{#discuss_area_view_permission#} </th>
	<td>
		<input type="radio" CHECKED value="0" name="access">{#public#}
		<input type="radio" value="1" name="access">{#private_only_group_member_can_see_it#}
	</td>
</tr>
<tr id="tr_studentList2" style="display:none">
	<th>{#group_member#}</th>
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
<input type="submit" value="{#add_discuss_area#}" name="submit" class="btn">
<input type="reset" value="{#reset#}" name="reset" class="btn"> 
</p>
</form>

</div>
{/if}

</BODY>
</HTML>
