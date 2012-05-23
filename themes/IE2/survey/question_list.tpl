<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{$tpl_path}/script/survey.js"></script>
    <script type="text/javascript" src="{$tpl_path}/script/default.js"></script>
    <script type="text/javascript" src="{$webroot}script/survey/question_list.js"></script>
    {if $reload == 1}
    <script type="text/javascript"><!--
      parent.location.reload();
    --></script>
    {/if}
  </head>

  <body class="ifr" id="tabA">
    <div class="tab">
      <ul id="tabnav">
      <li class="tabA" onClick="view('view', 'tabA');" style="cursor:pointer;">瀏覽題目細項</li>
      <li class="tabB" onClick="view('update', 'tabB');" style="cursor:pointer;">新增題目細項</li>
      </ul>
    </div>
    <div id="update" style="display: none;">
      <form method="POST" action="tea_update.php">
        <input type="hidden" name="block_id" value="{$block_id}"/>
        <input type="hidden" name="option" value="{$option}"/>
        題目細項內容：<br/>
        <textarea cols="50" rows="10" name="question">{$content}</textarea><br/>
	<input type="reset" class="btn" value="清除資料"/>&nbsp;&nbsp;<input type="submit" class="btn" value="確定送出"/><br/>
      </form>
    </div>
    <div id="view" style="display: none;">
      {if $num == 0}
      本題目沒有任何細項<br/>
      {else}
      <table class="datatable">
        <tr>
	  <th>索引</th>
	  <th>題目細項內容</th>
	  <th>檢視</th>
	  <th>編輯</th>
	  <th>刪除</th>
        </tr>
	{foreach from=$question item=quest}
	<tr class="{cycle values=" ,tr2"}">
	  <td>{$quest.num}</td>
	  <td>{$quest.question|truncate:60:"...":true}</td>
	  <td><a href="question_view.php?block_id={$quest.block_id}&survey_cd={$quest.survey_cd}"><img src="{$tpl_path}/images/icon/view.gif"/></a></td>
	  <td><a href="tea_view_edit.php?block_id={$quest.block_id}&survey_cd={$quest.survey_cd}"><img src="{$tpl_path}/images/icon/edit.gif"/></a></td>
	  <td><a href="#" onclick="delete_question({$quest.survey_cd});"><img src="{$tpl_path}/images/icon/delete.gif" width="24" height="26" border="0"/></a></td>
	</tr>
	{/foreach}
      </table>
      {/if}
    </div>

    <script type="text/javascript" language="JavaScript"><!--
    document.getElementById("{$appear}").style.display = "";
    --></script>
  </body>
</html>
