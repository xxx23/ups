<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
  </head>

  <body class="ifr">
    <h1>統計資料</h1>
    <div>
      <table class="datatable">
        <tr>
	  <th>學號</th>
	  <th>姓名</th>
	  <th>是否填寫</th>
	</tr>
	{foreach from=$people item=person}
	<tr class="{cycle values=" ,tr2"}">
	  <td>{$person.login_id}</td>
	  <td>
	    {if $person.survey_flag == 1}
	    <a href="compile_survey.php?personal_id={$person.personal_id}&survey_no={$survey_no}">{$person.personal_name}</a>
	    {else}
	    {$person.personal_name}
	    {/if}
	  </td>
	  <td>{if $person.survey_flag == 1}已填寫{else}未填寫{/if}</td>
	</tr>
	{/foreach}
      </table>
    </div>
    <p class="al-left"><a href="tea_view.php"><img src="{$tpl_path}/images/icon/return.gif" />回上頁</a></p>
  </body>
</html>
