<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
  </head>

  <body class="ifr">
    <h1>問卷列表</h1>
    <div>
      <table class="datatable">
        <tr>
	  <th>問卷名稱</th>
	  <th>開始日期</th>
	  <th>結束日期</th>
	  <th>是否記名</th>
	  <th>填寫問卷</th>
        </tr>
	{foreach from=$surveys item=survey}
	<tr class="{cycle values=" ,tr2"}">
	  <td>{$survey.survey_name}</td>
	  <td>{$survey.d_survey_beg}</td>
	  <td>{$survey.d_survey_end}</td>
	  {if $survey.is_register == 1}<td>記名</td>{else}<td>不記名</td>{/if}
	  {if $survey.due == 1}
	  <td>&nbsp;</td>
	  {elseif $survey.survey_flag != 1}
	  <td><a href="fillout_survey.php?survey_no={$survey.survey_no}">填寫問卷</a></td>
	  {else}
	  <td>已填寫</td>
	  {/if}
        </tr>
	{/foreach}
     </table>
   </div>
  </body>
</html>
