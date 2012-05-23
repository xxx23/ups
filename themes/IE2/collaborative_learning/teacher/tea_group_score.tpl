<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>分組資訊</title> 
<script type="text/javascript" src="{$webroot}script/prototype_window/javascripts/prototype.js"> </script>
<script type="text/javascript" src="{$webroot}script/prototype_window/javascripts/effects.js"> </script>
<script type="text/javascript" src="{$webroot}script/prototype_window/javascripts/window.js"> </script>
<script type="text/javascript" src="{$webroot}script/prototype_window/javascripts/window_effects.js"> </script>
<script type="text/javascript" src="{$webroot}script/prototype_window/javascripts/debug.js"> </script>

<link href="{$webroot}script/prototype_window/themes/default.css" rel="stylesheet" type="text/css"/>
<link href="{$webroot}script/prototype_window/themes/spread.css" rel="stylesheet" type="text/css" />
<link href="{$webroot}script/prototype_window/themes/alert.css" rel="stylesheet" type="text/css"/>
<link href="{$webroot}script/prototype_window/themes/alert_lite.css" rel="stylesheet" type="text/css" />
<link href="{$webroot}script/prototype_window/themes/alphacube.css" rel="stylesheet" type="text/css"/>
<link href="{$webroot}script/prototype_window/themes/debug.css" rel="stylesheet" type="text/css" />

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

{literal}
<script type="text/javascript">

function test(html,group_name,group_no,homework_no){
win = new Window({className: "alphacube", title: group_name, 
                      top:70, left:100, width:400, height:450, 
                      url: "./inter_group_score.php?group_no="+group_no+"&homework_no="+homework_no, showEffectOptions: {duration:0.5}})
win.show();     
}

function update_submit(){
	document.getElementById("update").value = "true";
}

</script>
{/literal}
</head>
<body id="tabA">

<h1>以組為單位評分</h1>
<form action="tea_group_score.php" method="post" name="">
  <table class="datatable">
    <tr>
      <th>組別</th>
	  <th>作業下載</th>
	  <th>老師評分</th>
    </tr>	
    {foreach from = $group_list item = element name=contentloop}
    <tr class="{cycle values=",tr2"}">
      <td><input class="btn" type="button" value="第{$element.group_no}組" onclick="test(this,'第{$element.group_no}組成績',{$element.group_no},{$homework_no});" /></td>
	  <td>
	  {if $element.upload == 'f'}未上傳
	  {else}<a href="{$webroot}library/redirect_file_path.php?h_no={$homework_no}&g_no={$element.group_no}"><img src="{$tpl_path}/images/icon/download.gif"></a>
	  {/if}
	  </td>
	  <td><input type="textarea" size="2" name="group_score[]" value="{$element.group_score}" /></td>
    </tr>
    
    {foreachelse}
    目前沒有任何已分組學生。
    {/foreach}
    </table>
	<p class="al-left">
      <input type="hidden" name="update" id="update" value="false" />
  <input class="btn" type="submit" value="更新分數" onclick="update_submit();"/>
<input type="hidden" name="homework_no" value="{$homework_no}" /></p>
</form>
</body>
</html>
