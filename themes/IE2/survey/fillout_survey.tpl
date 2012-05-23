<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
  </head>

  <body>
    <div>
      <h1>問卷名稱：{$survey_name}</h1>
      {if $editable == 1}
      <div><ul id="tabnav">
      <li><a href="edit_survey.php?survey_no={$survey_no}">編輯問卷內容</a></li>
      <li><a href="tea_view.php">返回線上問卷</a></li>
      </ul></div>
      {/if}
      <form method="POST" action="fillout_survey.php">
        <input type="hidden" name="option" value="fillout"/>
        <input type="hidden" name="survey_no" value="{$survey_no}"/>
        {foreach from=$groups item=group}
	<table class="datatable">
	<tr>
	  <th colspan="{$group.num}">{$group.question}</th>
	</tr>
	{$group.description}
	  {foreach from=$group.questions item=question}
	    {$question}
	  {/foreach}
	</table>
	{/foreach}
      {if $fillout == 1}
      <input type="reset" class="btn" value="清除資料"/><input type="submit" class="btn" value="確定送出"/>
      {/if}
      </form>
    </div>
    {if $editable != 1}
  <p class="al-left"><a href="stu_view.php"><img src="{$tpl_path}/images/icon/return.gif" />取消填寫</a></p>
    {/if}
  </body>
</html>
