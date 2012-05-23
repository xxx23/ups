<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>登入</title>
<link href="css/login.css" rel="stylesheet" type="text/css" />

</head>
<body onload='document.form1.login_id.focus()'>
<div>

<form name='form1' action="login_check.php" method="POST" target="_top">
    <label>ID: <input class="text" type="text" name="login_id" /> </label><br/>
    <label>Password:<input class="text" type="password" name="password" size="15" /></label><br/>
    <input class="botton" type="submit" name="login" value="LOGIN"><br/>
    <!--<a href="./Registration/register.php">加入會員</a>&nbsp;&nbsp;-->
    <a href="./Registration/joinArticle.php" target=_blank>加入會員</a>&nbsp;&nbsp;
    <a href="./Registration/forgetpasswd.php" target="_blank">忘記密碼</a>
</form>
</div>

<div class="news">
	{foreach from=$news item=news_item name=news_loop}
	<div style="border-bottom:1px dotted #BBBBBB">
		<span style="font-size:10px">{$news_item.date}</span>&nbsp;&nbsp;
		<span>{$news_item.subject}</span>
	</div>
	</tr>
	{foreachelse}
	<div style="text-align:center">目前沒有公告</div>
	{/foreach}
</div>
</body>
</html>
