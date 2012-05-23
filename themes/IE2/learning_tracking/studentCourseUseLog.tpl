<HTML>
<head>
<title>各項排名</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

{literal}

<script language="JavaScript">

</script>

{/literal}

</head>
<body>

<center>

<div class="form">

<FORM ACTION="{$currentPage}" METHOD="POST" name="FORM">

<fieldset>
<legend>學生個別使用紀錄</legend>

<div align="left">

學生：
<SELECT NAME="student_id">
{section name=counter loop=$studentList}
<OPTION VALUE="{$studentList[counter].personal_id}" {if $student_id==$studentList[counter].personal_id}Selected{/if}>{$studentList[counter].name}
{/section}
</SELECT>
<br>

{if $studentNum > 0}
<INPUT TYPE="SUBMIT" VALUE="OK" class="btn">
{/if}

<input name="action" type="hidden" value="showStudentLog">

</div>

</FORM>

</fieldset>
</div>


<iframe src="{$content}" scrolling="no" frameborder="no" height="100%" width="100%">

</center>


</BODY>
