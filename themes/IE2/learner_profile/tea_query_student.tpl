<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>觀看帳號</title>

<script type="text/javascript" src="{$webroot}script/prototype.js"></script>
<script type="text/javascript" src="{$webroot}script/default.js"></script>
<script type="text/javascript" src="{$webroot}script/learner_profile/verify.js"></script>

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
	for(i = 0 ; i < num ; i++)
	{
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
</head>

<body class="ifr">
<!-- 內容說明 -->
<p class="intro">
圖示說明：<br />
 <img src="{$tpl_path}/images/icon/pass.gif"/>&nbsp;核准&nbsp;&nbsp;
 <img src="{$tpl_path}/images/icon/fail.gif"/>&nbsp;不核准<br/>
 <img src="{$tpl_path}/images/icon/major.gif"/>&nbsp;正修生&nbsp;&nbsp;
 <img src="{$tpl_path}/images/icon/auditor.gif"/>&nbsp;旁聽生<br/>
</p>


<!--功能部分 -->
<div style="width:80%;">  <!-- 限制大小 -->
<form action="verify_student.php" method="POST" name="set_student">
<table class="datatable">
<tr>
	<th><input type="checkbox" name="" onclick="clickAll('set_student', this);" />
	<th>帳號</th>
	<th>姓名</th>
	<th>個人網頁連結</th>
	<th>信箱</th>
	<th>修課</th>
	<th>正修/旁聽</th>
</tr>
{foreach from=$user item=user}
<tr class="{cycle values="tr2,"}" >
	<td><input type="checkbox" name="pid[]" value="{$user.personal_id}"/></td>
	<td>{$user.login_id}</td>
	<td>{$user.personal_name}</td>
	<td style="curson:pointer; text-align:center;">
	{if $user.personal_home|strip:'&nbsp;' != ""}<a href="{$user.personal_home}" target="_black">觀看個人首頁</a>{/if}<input type="hidden" name="home[]" value="{$user.personal_home|strip:'&nbsp;'}"/></td>
	<td>{if $user.email|strip:'&nbsp;' != ""}<a href="mailto:{$user.email}"><img src="{$tpl_path}/images/icon/mail.gif" /><a>{/if}<input type="hidden" name="mail[]" value="{$user.email|strip:'&nbsp;'}" /></td>
	<td onclick="verify_single('{$user.personal_id}', this);" style="cursor:pointer; text-align:center;">{if $user.allow_course == 1}<img src="{$tpl_path}/images/icon/pass.gif"/>
	{else}<img src="{$tpl_path}/images/icon/fail.gif"/>{/if}
	</td>
	<td onclick="status_single('{$user.personal_id}', this);" style="cursor:pointer; text-align:center;">
	{if $user.status_student == 1}<img src="{$tpl_path}/images/icon/major.gif"/>
	{else}<img src="{$tpl_path}/images/icon/auditor.gif"/>{/if}
	</td>
	<!--<td><a href='./tea_query_student.php?action=status&personal_id={$user.personal_id}&status={$user.status_student}'>{$user.status}</a></td>-->
</tr>
{/foreach}
</table>
<input type="hidden" name="flag" value="-1"/>
<input type="button" class="btn" value="核准" onclick="verify('1');"/>
<input type="button" class="btn" value="不核准" onclick="verify('0');"/>
<input type="button" class="btn" value="刪除" onclick="verify('2');"/>
<input type="button" class="btn" value="群組寄信" onclick="mailselect();return false;"/>
</form>
</div>

</body>
</html>
