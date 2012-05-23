<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{$tpl_path}/script/survey.js"></script>
  </head>

  <body >
    <div>
      <ul id="tabnav">
        <li><a href="edit_survey.php?survey_no={$survey_no}">繼續編輯</a></li>
        <li><a href="publish_survey.php?option=view&survey_no={$survey_no}">發佈設定</a></li>
        <li><a href="tea_view.php">結束編輯</a></li>
      </ul>
    </div>
    <div>
     <form method="GET" action="edit_survey.php">
       <input type="hidden" name="option" value="grade"/>
       <input type="hidden" name="survey_no" value="{$survey_no}"/>
       {foreach from=$datas item=data}
       <table class="datatable">
         <tr>
	   <th colspan="{$data.num}">{$data.question}</th>
	 </tr>
	 {$data.description}
	 {foreach from=$data.quest item=each}
	 {$each}
	 {/foreach}
       </table>
       <br/>
       {/foreach}
       <table border="1">
       </table>
       <input type="reset" class="btn" value="清除資料"/><input type="submit" class="btn" value="確定送出"/>
     </form>
    </div>
  </body>
</html>
