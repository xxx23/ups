<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<script type="text/javascript" src="{$webroot}script/course/function.js"></script>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

</head>
<body>
{if $done == 1}<script>parent.location = "course.php";</script>{/if}
<!--<p class="address">目前所在位置: <a href="#">首頁</a> &gt;&gt; <a href="#">課程</a> &gt;&gt; <a href="#">系統工具</a> &gt;&gt; <a href="#">功能設定</a></p>
--><h1>系統功能顯示設定</h1>
<p class="intro">
勾選功能項目，則系統選單會顯示該連結。<br/>
取消勾選則不顯示該功能連結。
</p>

<form method="GET" action="function.php">
  <table class="datatable">
    {foreach from=$level_0 item=fun_0}
    <tr class="tr2">
      <td colspan="3"><input type="checkbox" name="menu_0[]" value="{$fun_0.menu_id}" onClick="clickChildren(this);" {if $fun_0.checked == 1}checked{/if} {if $fun_0.disabled == 1}DISABLED{/if}/>
        {$fun_0.menu_name}</td>
    </tr>
    {foreach from=$fun_0.next item=fun_1}
    <tr>
      <td style="width:5%;">&nbsp;</td>
      <td colspan="2"><input type="checkbox" name="menu_{$fun_0.menu_id}[]" value="{$fun_1.menu_id}" onClick="clickChildren(this);" {if $fun_1.checked == 1}checked{/if} {if $fun_1.disabled == 1}DISABLED{/if}/>
        {$fun_1.menu_name}</td>
    </tr>
    {*這裡插入程式, 如果沒有第三層選單就不印<tr>...</tr>這段的內容*}
    <tr class="tr3">
      <td colspan="2" style="width:10%;">&nbsp;</td>
      <td>
	  {foreach from=$fun_1.next item=fun_2}
        <input type="checkbox" name="menu_{$fun_1.menu_id}[]" value="{$fun_2.menu_id}" {if $fun_2.checked == 1}checked{/if} {if $fun_2.disabled == 1}DISABLED{/if}/>
        {$fun_2.menu_name} 
	  {/foreach} </td>
    </tr>
    {/foreach}
    {/foreach}
  </table>
<div class="buttons">
  <input type="reset" class="btn" value="清除資料"/>
  <input type="submit" class="btn" value="確定送出"/>
</div>
</form>
</body>
</html>
