<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="{$webroot}script/prototype.js"></script>
    <script type="text/javascript" src="{$webroot}script/calendar.js"></script>
    <script type="text/javascript" src="{$tpl_path}/script/survey/check.js" language="javascript"></script>
  </head>

  <body class="ifr">
    <h1>修改問卷設定</h1>
    <div>
    <form method="GET" action="update_survey.php" onsubmit="return modify_view(this);">
      <input type="hidden" name="option" value="modify"/>
      <input type="hidden" name="survey_no" value="{$survey_no}"/>
      問卷名稱：<input type="text" name="survey_name" value="{$survey_name}"/><br/>
      是否記名：{if $is_register == 1}記名{else}不記名{/if}<br/>
      問卷起始時間：<br/>
      <input type="text" class="btn" id="beg" size="10" value="{$beg}" name="beg" readonly/>
      <script type="text/javascript" language=javascript><!--
      var beg=new dateSelector();
      beg.inputName='beg';
      beg.display();
      --></script>
      <br/>
      問卷結束時間：<br/>
      <input type="text" class="btn" id="end" size="10" value="{$end}" name="end" readonly/>
      <script type="text/javascript" language=javascript><!--
      var end=new dateSelector();
      end.inputName='end';
      end.display();
      --></script>
      <br/>
      <input type="reset" class="btn" value="清除資料">&nbsp;<input type="submit" class="btn" value="確定送出"/>
    </form>
    </div>
    <p class="al-left"><a href="tea_view.php"><img src="{$tpl_path}/images/icon/return.gif" />回上頁</a></p>
  </body>
</html>
