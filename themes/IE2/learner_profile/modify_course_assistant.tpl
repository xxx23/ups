<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<script type="text/javascript" src="{$webroot}script/learner_profile/assistant.js"></script>
	<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
	<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
	<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
	<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
</head>

<body class="ifr">
	<form action="manage_course_assistant.php" method="GET" name="update">
	{if $person.action_type != "modify"}
	<h1>新增助教</h1>
	<input type="hidden" name="option" value="create"/>
	{else}
	<h1>修改助教資料</h1>
	<input type="hidden" name="option" value="modify"/>
	<input type="hidden" name="pid" value="{$person.personal_id}"/>
	{/if}
	<p class="intro">
	此功能可為教師新增助教帳號並指派為本課程的助教，若教師欲從已存在的助教帳號中指派本課程助教，可從名單中選取。
	</p>
	{if $done == 1}
	<center><strong style="color:red;">助教帳號新增完成</strong></center>
	{/if}
	<ul id="tabnav">
		<li><a href="manage_course_assistant.php?option=list_assistants">助教查詢與修改</a></li>
	</ul>
	<table class="datatable"><tbody>
		<tr>
			<th>助教帳號：</th>
			{if $person.action_type != "modify"}
			<td>
			<input type="text" name="login_id" value="{$person.login_id}"/>
				{if $select == 1}&nbsp;&nbsp;從名單選取：
				<select onclick="assign_data(this);">
				{foreach from=$data item=entry}
				<option value="{$entry.login_id};{$entry.personal_name};{$entry.email};{$entry.tel};{$entry.pass}">{$entry.login_id}</option>
				{/foreach}
				</select>
				{/if}
			</td>
			{else}
			<td><input type="text" name="login_id" value="{$person.login_id}" class="btn" readonly/></td>
			{/if}
		</tr>
		<tr>
			<th>助教名稱：</th>
			<td><input type="text" name="user_name" value="{$person.personal_name}"/></td>
		</tr>
		<tr>
			<th>E-mail：</th>
			<td><input type="text" name="email" value="{$person.email}"/></td>
		</tr>
		<tr>
			<th>連絡電話：</th>
			<td><input type="text" name="phone" value="{$person.tel}"/></td>
		</tr>
		<tr>
			<th>密碼：</th>
			<td><input type="password" name="password" value="{$person.pass}"/></td>
		</tr>
		<tr>
			<td colspan="2"><input type="reset" class="btn" value="清除資料"/><input type="submit" class="btn" value="確定送出"/></td>
		</tr>
	</tbody></table>
	</form>
</body>
</html>
