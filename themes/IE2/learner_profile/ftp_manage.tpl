<html>
<head>
<title>ftp帳號管理</title>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
</head>
<body class="ifr">
{if $action eq query}

 <h1>查詢的結果</h1>
 <table class="datatable">
   <tr><th>名稱</th><th>登入帳號</th><th>修改ftp使用者</th><th>刪除ftp使用者</th></tr>
   <tr><td>{$user.personal_name}</td><td>{$user.id}</td><td>修改</td><td>刪除</td></tr>
 </table>
 </br>
<center> <input type="button" class="btn" value="回上一頁" onClick="window.location.href='ftp_manage.php'"></center>

{else}
    <form action="./ftp_manage.php" method="POST"/>
	<h1>同步化FTP帳號密碼</h1>
	<p class="intro">按下此鈕會進行同步化，平台上的教師帳號密碼與ftp登入帳號密碼ㄧ致。<br/>
	教師預設家目錄為：<span class="imp">{$data_file_path}[教師personal_id]</span></p>
	<input type="hidden" name="consist_ftp" value="true"/>
	<input type="submit" class="btn" value="進行同步"/>
    </form>

{*
    <form action="./ftp_manage.php" method="POST"/>
	<h1>請輸入ftp使用者帳號</h1>
	<li>帳號：<input type = "textarea" value="" name= "new_name" size="10"/></li>
	<input type="hidden" name="query_user" value="true"/>&nbsp;&nbsp;&nbsp;
	<input type="submit" class="btn" value="確定"/>
    </form>
    <form action="./ftp_manage.php" method="POST"/>
	<h1>新增ftp使用者</h1>
	<li>登入帳號：<input type = "textarea" value="" name= "new_name" size="10"/></li>
	<li>登入密碼：<input type="password" value="" name="new_pass" size="10"/></li>
	<li>登入家目錄：<input type="textarea" value="" name="new_path" size="10"/>
	&nbsp;&nbsp;(選項留空預設為教師目錄)</li>

	<input type="hidden" name="new_user" value="true"/><br/>&nbsp;&nbsp;&nbsp;
	<input type="submit" class="btn" value="確定新增"/>
    </form>

    <form action="./ftp_manage.php" method="POST"/>
	<h1>修改ftp使用者</h1>
	<li>登入帳號：<input type = "textarea" value="" name= "new_name" size="10"/></li>
        <!--<li>輸入登入密碼：<input type="password" value="" name="new_pass" size="10"/></li>-->
        <!--<li>輸入登入家目錄：<input type="textarea" value="" name="new_path" size="10"/></li>-->
	<br/>
	<li>新登入密碼：<input type="password" value="" name="new_pass" size="10"/></li>
	<li>新登入家目錄：<input type="textarea" value="" name="new_path" size="10"/></li>
	(此欄位留空為不更改，依照原來的家目錄。)
	<input type="hidden" name="modify_user" value="true"/><br/>&nbsp;&nbsp;&nbsp;
        <input type="submit" class="btn" value="確定修改"/>
    </form>


    <form action="./ftp_manage.php" method="POST"/>
	<h1>刪除ftp使用者</h1>
	<li>登入帳號：<input type = "textarea" value="" name= "new_name" size="10"/></li>
	<input type="hidden" name="delete_user" value="true"/><br/>&nbsp;&nbsp;&nbsp;
        <input type="submit" class="btn" value="確定刪除"/>
    </form>
*}
{/if}
    </body>
</html>
