<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <script type="text/javascript" src="{$webroot}script/prototype.js"></script>
    <script type="text/javascript" src="{$webroot}script/calendar.js"></script>

    <link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
  </head>

  <body class="ifr">
    <h1>設定問卷時間</h1>
    <form method="GET" action="publish_survey.php">
      <input type="hidden" name="option" value="update"/>
      <input type="hidden" name="survey_no" value="{$survey_no}"/>
      問卷起始時間：<br/>
      <input type="text" id="beg_date" name="beg_date" value="{$beg_date}" readonly/>
        <script type="text/javascript" language=javascript><!--
		var beg=new dateSelector();
		beg.inputName='beg_date';
		beg.display();
		--></script>
      <br/>
      問卷結束時間：<br/>
      <input type="text" id="end_date" name="end_date" value="{$end_date}" readonly/>
        <script type="text/javascript" language=javascript><!--
		var end=new dateSelector();
		end.inputName='end_date';
		end.display();
		--></script>
      <br/>
      <input type="reset" class="btn" value="清除資料"/>&nbsp;<input type="submit" class="btn" value="確定送出"/>
    </form>
    <p class="al-left"><a href="javascript:history.back();"><img src="{$tpl_path}/images/icon/return.gif" />回上頁</a></p>
  </body>
</html>
