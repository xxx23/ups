<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <script type="text/javascript" src="{$tpl_path}/script/survey/check.js"></script>
    <script type="text/javascript"><!--
    	function setDisplay(){literal}{{/literal}
		setType({$type_select}, {$no_select});
		document.getElementsByName("s_type")[0].onchange = changeType;
		document.getElementsByName("s_no")[0].onchange = changeNum;
	{literal}}{/literal}
    --></script>

    <link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
  </head>

  <body class="ifr" onload="setDisplay();">
    <div>
      <h1>編輯問卷題目內容</h1>
      <form method="POST" action="tea_update.php">
	<input type="hidden" name="survey_cd" value="{$survey_cd}"/>
	題組型態：
	{html_options name=s_type options=$survey_type selected=$type_select}<br/>
        題組標題：<br/>
        <input type="text" size="40" name="question" value="{$content}"/><br/>
	<div id="num" style="display:none;">
	回答選項個數：
	{html_options name=s_no options=$survey_no selected=$no_select}<br/>
	{foreach from=$strings item=str}
	<div id="opt_{$str.index}" style="display:none;">第{$str.num}個選項：<input type="text" name="selection[]" value="{$str.content}"/></div>
	{/foreach}
	</div>
	<input type="reset" class="btn" value="清除資料"/>
	<input type="submit" class="btn" value="確定送出"/>
      </form>
    </div>
    <p class="al-left"><a href="javascript:history.back();"><img src="{$tpl_path}/images/icon/return.gif" />回上頁</a></p>
  </body>
</html>
