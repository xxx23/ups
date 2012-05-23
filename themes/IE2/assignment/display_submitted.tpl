<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
	<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
	<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
	<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

</head>

<body class="ifr">
<h1>批閱線上作業</h1>
  <form method="POST" action="excellent.php">
<table class="datatable"><tbody>
  <tr>
    <th>帳號</th>
    <th>學生姓名</th>
    <th>繳交時間</th>
    <th>觀看答案</th>
    <th>成績</th>
    <th>評分</th>
    <th>評語</th>
    <th>優良作業</th>
  </tr>
  {foreach from=$ass_data item=ass}
  <tr class="{cycle values=" ,tr2"}">
    <td>{$ass.login_id}</td>
    <td>{$ass.personal_name}</td>
    <td>{$ass.handin_time}</td>
    <td>
    {if $ass.is_handin == 1}
    <a href="tea_correct.php?view=true&option=single&pid={$ass.personal_id}" target="_blank"><img src="{$tpl_path}/images/icon/view.gif" /></a>
    {else}
    未繳交
    {/if}
    </td>
    <td>{$ass.concent_grade}</td>
	  <td><input type="hidden" size="1" name="personal_id[]" value="{$ass.personal_id}"/>
	      <input type="text" size="1" name="grade[]"/></td>
    <td>
    <a href="tea_comment.php?option=view&pid={$ass.personal_id}"/>評語</a>
    </td>
    <td>
    {if $ass.is_handin == 1}
    <input type="checkbox" name="excell[]" value="{$ass.personal_id}" 
    {if $ass.public == "1"}checked{/if}/>
    {/if}
    </td>
  </tr>
  {foreachelse}
  <tr><td colspan="8">目前無資料</td></tr>
  {/foreach}
</tbody></table>  
  <input type="hidden" name="option" value=""/>
<p class="al-left">
  <input type="reset" class="btn" value="清除資料"/>
  <input type="submit" class="btn" value="確定送出"/></p>
  <p class="al-left"><a href="tea_view.php"><img src="{$tpl_path}/images/icon/return.gif"/> 返回線上作業列表</a></p>
  </form>
</body>

</html>
