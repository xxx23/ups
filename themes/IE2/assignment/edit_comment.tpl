<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="{$webroot}script/tiny_mce_new/tiny_mce.js"></script>
<script type="text/javascript" src="{$webroot}script/editor_simple.js"></script>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css"/>
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css"/>
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css"/>
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css"/>
</head>

<body>
<h1>編輯評語</h1>
  <form method="POST" action="tea_comment.php">
<fieldset><legend>  作業名稱：{$name}</legend>
評語<br/>
  <input type="hidden" name="pid" value="{$pid}"/>
  <input type="hidden" name="option" value="update"/>
  <textarea name="comment" cols="75" rows="6">{$comment}</textarea>
  <br/>
  </fieldset>
  <p class="al-left">
  <input type="reset" class="btn" value="清除資料"/>
  <input type="submit" class="btn" value="確定送出"/></p>
  </form>
  <p class="al-left"><a href="javascript:history.back();"><img src="{$tpl_path}/images/icon/return.gif" />返回學生列表</a></p>
</body>
</html>
