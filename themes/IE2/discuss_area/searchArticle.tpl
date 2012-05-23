<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>討論區文章搜尋</title>


<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

</head>

<body>
<h1>搜尋討論區文章</h1>
<form action="searchArticleResult.php" method="post">
  <table class="datatable">
  <tr>
    <th>搜尋字串</th>
	  <td><input type="text" name="keyword" size="30"><br>&nbsp;可輸入多個查詢字(以空白鍵隔開)</td>
  </tr>
  <tr>
    <th>搜尋目標</th>
	  <td>
	    <input type="radio" name="searchType" value="1" checked>文章標題
	    <input type="radio" name="searchType" value="2">作者
	    <input type="radio" name="searchType" value="3">文章內容	</td>
  </tr>
  </table>
<p class="al-left">  
<input type="submit" value="開始搜尋" class="btn">
  <input type="reset" value="重新輸入" class="btn">
  </p>
</form>
</body>
</html>
