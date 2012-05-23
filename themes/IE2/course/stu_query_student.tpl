<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>修課成員</title>

<script type="text/javascript" src="{$webroot}script/prototype.js"></script>
<script type="text/javascript" src="{$webroot}script/default.js"></script>
<script type="text/javascript" src="{$webroot}script/learner_profile/verify.js"></script>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

</head>

<body class="ifr">

<h1>老師</h1>
<table class="datatable">
{foreach from=$tea item=item}
	<tr class="">	
		<th rowspan="4" width="15%" align="center">
			{if $item!=''}<img width="120px" height="160px" src="{$item.photo}" />{/if}
		</th>
		<th width="8%">帳號</th><td>{$item.login_id}</td>
	</tr>
	<tr class="tr2">
		<th>姓名</th><td>{$item.personal_name}</td>
	</tr>
	<tr class="">
		<th>信箱</th><td><a href="mailto:{$item.email}">{$item.email}</a></td>
	</tr>
	<tr class="tr2">
		<th>電話</th><td>{$item.tel}</td>
	</tr>
{/foreach}
</table>

<br/>
<br/>
<br/>

<h1>助教</h1>
<table class="datatable">
{foreach from=$TA item=item}
	<tr class="">	
		<th rowspan="4" width="15%" align="center">
			{if $item!=''}<img width="120px" height="160px" src="{$item.photo}" />{/if}
		</th>
		<th width="8%">帳號</th><td>{$item.login_id}</td>
	</tr>
	<tr class="tr2">
		<th>姓名</th><td>{$item.personal_name}</td>
	</tr>
	<tr class="">
		<th>信箱</th><td><a href="mailto:{$item.email}">{$item.email}</a></td>
	</tr>
	<tr class="tr2">
		<th>電話</th><td>{$item.tel}</td>
	</tr>
{foreachelse}
	<tr><td>目前沒有資料喔!!</td></tr>
{/foreach}

</table>

<br/>
<br/>
<br/>


<h1>修課學生</h1>

<p class="intro">圖示說明：<br />
	<img src="{$tpl_path}/images/icon/major.gif"/>&nbsp;正修生&nbsp;&nbsp;
	<img src="{$tpl_path}/images/icon/auditor.gif"/>&nbsp;旁聽生<br/>
</p>


<table class="datatable">
<tr>
	<th>帳號</th>
	<th>姓名</th>
	<th width="50%">信箱</th>
	<th width="100px">正修/旁聽</th>
</tr>
{foreach from=$stu item=user}
<tr class="{cycle values="tr2,"}" >
	<td>{$user.login_id}</td>
	<td>{$user.personal_name}</td>
	<td>
{if $user.email|strip:'&nbsp;' != ""}
	<a href="mailto:{$user.email}"><img src="{$tpl_path}/images/icon/mail.gif" /></a>
{/if}
	</td>
	<td style="text-align:center;">
	{if $user.status_student == 1}<img src="{$tpl_path}/images/icon/major.gif"/>
	{else}<img src="{$tpl_path}/images/icon/auditor.gif"/>{/if}
	</td>
</tr>
{foreachelse}
        <tr><td colspan="4">目前沒有資料喔</td></tr>
{/foreach}
</table>

</body>
</html>
