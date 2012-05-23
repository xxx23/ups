{config_load file='common.lang'}
{config_load file='course_admin/show_all_begin_course.lang'}
{config_load file='personal_page/personal_page.lang'}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"

"http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" >

<link href="{$tpl_path}/css/font_style.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/layout.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />


<script src="{$webroot}script/prototype.js" type="text/javascript" ></script>

<script type="text/javascript" src="{$tpl_path}/script/course_admin/show_all_begin_course.js"></script>

<script language="javascript">

<!--

{literal}

var formname = "show_all_begin_course";
var pageurl = "./show_all_begin_course.php?action=search";
function changePage(page)
{
    var myForm=document.forms[formname];
    if(myForm.page)myForm.page.value =page;
    myForm.action = pageurl;
    myForm.submit();

return;
}

function pageContorlSubmin(form)
{
    var myForm=document.forms[formname];
    var query = document.getElementsByName("query\[\]");
    var query_array = [];
    for(var i = 0;i<query.length;i++)
    {
      if(query[i].checked)
      {
        query_array.push(i);
      }
    }
    myForm.action = window.location.href + "&query[] = "+query_array;
    myForm.submit();
    return;
}
function showInput(name){



	var tmp =  "query_"+name;

	if($(tmp).style.display == "none")

		$(tmp).style.display = "";

	else

		$(tmp).style.display = "none";

}



function showInputAll(obj){

	var tmp = obj.value;	

}



function showProfile(name){

	var tmp = "course_"+name;

	if($(tmp).style.display =="")

		$(tmp).style.display = "none";

	else

		$(tmp).style.display = "";

}



function modifyProfile(name){

	var tmp = "modify_"+name;

	var len = document.getElementsByName(tmp).length;

	var all_data = document.getElementsByName(tmp);

	var	index;

	for(index=0; index<len; index++){

		if(all_data[index].disabled == true){

			all_data[index].disabled = false;		

		}

		else{

			all_data[index].disable = true;	

		}	

	}

	if($(tmp+"_button").style.display == "none")

		$(tmp+"_button").style.display = "";

	else

		$(tmp+"_button").style.display = "none";

}

function doCheckAll(string){

	var nodes = document.getElementsByName(string);

	if(nodes.item(0).checked){

		for(var i=0; i < nodes.length ; i++)

			nodes.item(i).checked = false;

	}else{

		for(var i=0; i < nodes.length ; i++)

			nodes.item(i).checked = true;	

	}

}

{/literal}

-->

</script>

<title>{#view_course_condition#}</title>

</head>



{if $show_search == 1}

<body onload="init();">

{else}

<body>

{/if}


<h1>{#search_course#}</h1>
<div class="describe">{#search_describe#}</div>

<form name="show_all_begin_course" method="get" action="show_all_begin_course.php">

  <div class="searchbar" style="margin-left:60px;"><table class="datatable" >

    <tr>

      <th width="40%">
        <input type="checkbox" name="query[]" value="0" onclick="showInputAll(this);" checked />

      {#search_all_course#}</th>

        <td>&nbsp;</td>

    </tr>

    <tr>

      <th width="40%"><input type="checkbox" name="query[]" value="1" {if $name_check eq 1}checked="checked"{/if} onclick="showInput(this.value);">

        {#by_course_name#}</th>

      <td><div id="query_1" {if $name_check eq 0}style="display:none;"{/if}><input type="text" name="begin_course_name_input" value="{$begin_course_name_input}" />        ({#use_keyword_search#}) </div></td>

    </tr>

    <tr>

      <th width="40%"><input type="checkbox" name="query[]" value="2" {if $unit_check eq 1} checked="checked"{/if}  onclick="showInput(this.value);">{#by_course_unit#}</th>

      <td><div id="query_2" {if $unit_check eq 0}style="display:none;"{/if}><input type="text" name="unit_input" value="{$unit_input}" /></div></td>

    </tr>

    <tr>

      <th width="40%"><input type="checkbox" name="query[]" value="3" {if $teacher_check eq 1} checked="checked"{/if}  onclick="showInput(this.value);">{#by_instructor#}</th>

      <td><div id="query_3" {if $teacher_check eq 0}style="display:none;"{/if} ><input type="text" name="teacher_input" value="{$teacher_input}"/>      </div></td>

    </tr>

    <tr>

      <td colspan="2"><p class="al-left">  <input type="hidden" name="search" value="yes" />

        <input type="submit" value="{#search_course_info#}">

      </p></td>

    </tr>

  </table></div>

    <div id="pageControl" >
	{if $page_cnt ne 0}
	<span>{#page#}
	 <select name="page" onChange="pageContorlSubmin(this)" >
     {html_options values=$page_ids output=$page_names  selected=$page_sel}
     </select>/{$page_cnt}{#null_page#}
	 </span>
	 <a href="javascript:changePage({$previous_page})">{#page_up#}</a>
	 <a href="javascript:changePage({$next_page})"  >{#page_down#}</a>
	{/if}
	</div>


</form>

<hr width="100%" style="color: #fff; background-color: #fff; border: 1px dotted #6699FF; border-style: none none dotted;">


{if $show_search == 1}

<h2>{#search_result#}</h2>

<form action="delete_course.php" method="POST" name="delete_course">

  <table class="datatable" style="width:95%">

    <tr>

      <th> 

        <input type="checkbox" name="checkAll" onClick="doCheckAll('check[]');" />

      </th>

      <th> {#course_number#}</th>

      <th width="12%"> <div align="center">{#course_unit#}</div></th>
      <th width="5%"> <div align="center">{#course_property#}</div></th>

      <th> {#course_name#}</th>

      <th width="9%"> <div align="center">{#instructor#}</div></th>

	  <th width="5%"> <div align="center">{#certificate#}</div></th>

      <th width="9%"> <div align="center">{#course_info#}</div></th>

      <th width="9%"> <div align="center">{#instructor#}</div></th>

      <th width="9%"> <div align="center">{#reset_course#}</div></th>

    </tr>

    {foreach from=$course_data item=course}

    <tr>

      <td><input type="checkbox" name="check[]" value="{$course.begin_course_cd}" /></td>

      <td>{$course.inner_course_cd}</td>

      <td><div align="center">{$course.unit_name}</div></td>
      <td><div align="center">{if $course.attribute == 0}{#self_learning#}
{else}{#teaching#}{/if}</div></td>

      <td>{$course.begin_course_name|escape}</td>

      <td><div align="center">{$course.personal_name}</div></td>

	  <td><div align="center"><a href="../Certificate/certificateManagement.php?begin_course_cd={$course.begin_course_cd}&incomingPage=../Course_Admin/show_all_begin_course.php" >{#setting#}</a></div></td>

      <td><div align="center"><a href="./view_course.php?begin_course_cd={$course.begin_course_cd}" >{#modify#}</a></div></td>

      <td><div align="center"><a href="./add_teacher_to_course.php?begin_course_cd={$course.begin_course_cd}" >{#modify#}</a></div></td>

      <td><div align="center"><a href="reset_course.php?begin_course_cd={$course.begin_course_cd}">{#reset#}</a></div></td>

    </tr>

	{/foreach}

    <tr>

      <td colspan="9"><p class="al-left">

      	<input type="hidden" id="option" name="option" value=""/>

	<input id="_delete_course" type="button" value="{#delete_course#}"/></p></td>

    </tr>

  </table>



</form>

{/if}

</body>

</html>

