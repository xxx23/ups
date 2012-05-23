<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
  </head>

  <body class="ifr">
    <h1>問卷名稱：{$survey_name}</h1>
    <div>
    {foreach from=$groups item=group}
    <table class="datatable">
      <tr><th colspan="{$group.num}" style="text-align:center;">{$group.question}</th></tr>
      {$group.description}
        {foreach from=$group.questions item=question}
	  {$question}
        {/foreach}
    </table>
    {/foreach}
    </div>
   <p class="al-left"><a href="javascript:history.back();"><img src="{$tpl_path}/images/icon/return.gif" />回上頁</a></p> 
  </body>
</html>
