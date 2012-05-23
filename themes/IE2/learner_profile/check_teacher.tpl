<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>

	<script type="text/javascript" src="{$webroot}script/default.js"></script>

	<link href="{$tpl_path}/css/font_style.css" rel="stylesheet" type="text/css" />
	<link href="{$tpl_path}/css/layout.css" rel="stylesheet" type="text/css" />
	
	<title>審核教師</title>
</head>

<body class="ifr">
	<h1>審核教師</h1>
	<form action="check_teacher.php" method="GET" name="check_teacher">
	<table class="datatable"><tbody>
		<tr>
			<th>
			<img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>
			<input type="checkbox" onClick="clickAll('check_teacher', this);"/></th>
			<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>姓名</th>
			<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>身份證字號</th>
			<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>服務單位</th>
			<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>教師證編號</th>
			<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>E-mail</th>
			<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>連絡電話</th>
		</tr>
		{foreach from=$data_list item=data}
		<tr>
			<td><input type="checkbox" name="list[]" value="{$data.personal_id}"/></td>
			<td>{$data.personal_name}</td>
			<td>{$data.identify_id}</td>
			<td>{$data.organization}</td>
			<td>{$data.teacher_doc}</td>
			<td>{$data.email}</td>
			<td>{$data.tel}</td>
		</tr>
		{foreachelse}
		<tr>
			<td colspan="7" style="text-align:center;">目前無任何資料</td>
		</tr>
		{/foreach}
	</tbody></table>
	<input type="hidden" name="option" value="update"/>
	<input type="reset" value="清除資料"/><input type="submit" value="確定送出"/>
	</form>
</body>
</html>
