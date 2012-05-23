<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
  </head>

  <body class="ifr">
  <h1>編輯題目細項</h1>
    <div>
      <fieldset>
      <form method="POST" action="tea_update.php">
        <input type="hidden" name="block_id" value="{$block_id}"/>
        <input type="hidden" name="option" value="{$option}"/>
	    <input type="hidden" name="survey_cd" value="{$survey_cd}"/>
        <legend>題目內容：</legend>
        <textarea id="clear_textarea" cols="50" rows="10" name="question">{$content}</textarea><br/>
	    <input type="button" class="btn" value="清除資料" onclick="javascript:document.getElementById('clear_textarea').value='';"/>
        <input type="reset" class="btn" value="復原資料"/>
        <input type="submit" class="btn" value="確定送出"/><br/>
      </form>
      </fieldset>
    </div>
  <p class="al-left"><a href="javascript:history.back();"><img src="{$tpl_path}/images/icon/return.gif" />回上頁</a></p>
  </body>
</html>
