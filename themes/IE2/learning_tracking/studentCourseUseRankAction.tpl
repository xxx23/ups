<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript" src="{$webroot}script/default.js"></script>
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
{literal}
<script type="text/javascript">
function mailselect()
{
    var check = document.getElementsByName("pid[]");
    var mail = document.getElementsByName("mail[]");
    var num = check.length;
    var maillist = "";
    for(i = 0 ; i < num ; i++){
      if(check[i].checked && mail[i].value != "")
         maillist += mail[i].value + ",";
    }
    if(maillist == "")
      alert("您尚未選取任何學生");
    else
      document.location.replace("mailto:"+maillist);
}													
</script>
{/literal}
<title></title>
</head>

<body>

<center>

{if $dataNum > 0}
<form name="studentCourseUseRank">
<table class="datatable">
<tr>
	<th><input type="checkbox" name="" onclick="clickAll('studentCourseUseRank',this);"></th>
	<th>排名</th>
	<th>姓名</th>
	<th>{$rankTypeName}</th>
</tr>
{section name=counter loop=$dataList}
<tr class="{cycle values=",tr2"}">
	<td align><input type="checkbox" name="pid[]" value="{$user.personal_id}"/></td>
	<td align="center">{$dataList[counter].rank}</td>
	<td>{$dataList[counter].name}<input type="hidden" name="mail[]" value="{$dataList[counter].email | strip:'&nbsp';}"></td>
	<td>{$dataList[counter].data}</td>
</tr>
{/section}
</table>
</form>
{/if}
</center>
<input type="button"  class="btn" value="群組寄信" name="sendmail" onclick="mailselect();" />
</body>
</html>
