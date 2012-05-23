<html>
<head>
<title>ftp帳號管理</title>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
</head>
<body class="ifr">
    <form action="./ftp_manage.php" method="POST"/>
	<h1>同步化FTP帳號密碼</h1>
	<p class="intro">按下此鈕會進行同步化，平台上的教師帳號密碼與ftp登入帳號密碼ㄧ致。</p>
	<input type="hidden" name="consist_ftp" value="true"/>
	<input type="submit" class="btn" value="進行同步"/>
    </form>
    <form action="./ftp_manage.php" method="POST"/>
	<h1>新增ftp使用者</h1>
	<li>輸入登入帳號：<input type = "textarea" value="" name= "new_name" size="10"/></li>
	<li>輸入登入密碼：<input type="password" value="" name="new_pass" size="10"/></li>
	<li>輸入登入家目錄：<input type="textarea" value="" name="new_path" size="10"/></li>

	<input type="hidden" name="consist_ftp" value="true"/>
	<input type="submit" value="確定新增"/>
    </form>
    <form action="./ftp_manage.php" method="POST"/>
	<h1>修改ftp使用者</h1>
	<li>輸入登入帳號：<input type = "textarea" value="" name= "new_name" size="10"/></li>
        <!--<li>輸入登入密碼：<input type="password" value="" name="new_pass" size="10"/></li>-->
        <!--<li>輸入登入家目錄：<input type="textarea" value="" name="new_path" size="10"/></li>-->
	<br/>
	<li>輸入新登入密碼：<input type="password" value="" name="new_pass" size="10"/></li>
	<li>輸入新登入家目錄：<input type="textarea" value="" name="new_path" size="10"/></li>
	<input type="hidden" name="modify_user" value="true"/>
        <input type="submit" class="btn" value="確定修改"/>
    </form>
    <form action="./ftp_manage.php" method="POST"/>
	<h1>刪除ftp使用者</h1>
	<li>輸入登入帳號：<input type = "textarea" value="" name= "new_name" size="10"/></li>
	<input type="hidden" name="delete_user" value="true"/>
        <input type="submit" class="btn" value="確定刪除"/>
    </form>
    </body>
</html>
