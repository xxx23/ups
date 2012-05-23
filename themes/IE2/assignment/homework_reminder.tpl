
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
<script type="text/javascript" src="{$tpl_path}/script/assignment/delete.js"></script>
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
</head>
<body class="ifr">
<a href="tea_view.php">回到作業列表</a><br />
已寄給下列學生：
<table border="1">
       <tr>
	   <th>帳號</th>
	   <th>姓名</th>
	   <th>email</th>
	   </tr>
{foreach from=$ass_data key=myId item=i name=foo}
		   <tr>
		   <td>{$i.login_id}</td>
		   <td>{$i.personal_name}</td>
		   <td>{$i.email}</td>
		   </tr>
{/foreach}
若 email 欄位為空，代表這名學生目前沒有 email 可通知。
</table>
</body>
</html>
