<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<script type="text/javascript" src="{$webroot}script/prototype.js"></script>
    	<script type="text/javascript" src="{$tpl_path}/script/survey.js"></script>
    	<script type="text/javascript" src="{$tpl_path}/script/default.js"></script>
    	<script type="text/javascript" src="{$webroot}script/default.js"></script>
	<script type="text/javascript" src="{$webroot}script/survey/register_name.js"></script>
    {literal}
    <script type="text/javascript" language="JavaScript"><!--
    function _delete(){
      if(confirm("確定刪除選定問卷？"))
        document.deleteSurvey.submit();
    }
    function _view(str, str2){
      document.getElementById("view").style.display = "none";
      document.getElementById("create").style.display = "none";
      document.getElementById(str).style.display = "";
      var tmp = document.getElementsByTagName("body")[0];
      tmp.setAttribute("id", str2);
    }
    --></script>
    {/literal}

    <link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
  </head>

  <body class="ifr" onload="_view('view', 'tabA');">
    <div class="tab">
      <ul id="tabnav">
        <li class="tabA" style="cursor:pointer;" onClick="_view('view', 'tabA');">瀏覽問卷</li>
        <li class="tabB" style="cursor:pointer;" onClick="_view('create', 'tabB');">新增問卷</li>
      </ul>
    </div>
    <div id="view" style="display:none;">
      <form method="GET" name="deleteSurvey" action="delete_survey.php">
      <table class="datatable">
        <tbody>
        <tr>
	  {if $editable == 1}
	  <th style="text-align:center;"><input type="checkbox" onclick="clickAll('deleteSurvey', this);"/></th>
	  {/if}
	  <th>問卷名稱</th>
	  <th>開始日期</th>
	  <th>結束日期</th>
	  <th>是否記名</th>
	  {if $editable == 1}
	  <th>修改問卷設定</th>
	  <th>統計資料</th>
	  <th>匯出統計</th>
	  {/if}
        </tr>
	{foreach from=$surveys item=survey}
	<tr class="{cycle values=" ,tr2}">
	  {if $editable == 1}
	  <td style="text-align:center;"><input type="checkbox" name="survey_no[]" value="{$survey.survey_no}"/></td>
	  {/if}
	  <td><a href="view_survey.php?survey_no={$survey.survey_no}">{$survey.survey_name}</a></td>
	  <td>{$survey.d_survey_beg}</td>
	  <td>{$survey.d_survey_end}</td>
	  <!--<td onclick="register_single('{$survey.survey_no}', this);" style="cursor:pointer; text-align:center;">-->
	  <td style="text-align:center;">
	  	{if $survey.is_register == 1}<img src="{$tpl_path}/images/icon/name.gif"/>
	  	{else}<img src="{$tpl_path}/images/icon/name_x.gif"/>{/if}</td>
	  {if $editable == 1}
	  <td><a href="update_survey.php?survey_no={$survey.survey_no}&option=modify_view"/><img src="{$tpl_path}/images/icon/setup.gif"/></a></td>
	  <td><a href="compile_survey.php?survey_no={$survey.survey_no}"><img src="{$tpl_path}/images/icon/view.gif"/></a></td>
	  <td><a href="download.php?survey_no={$survey.survey_no}"><img src="{$tpl_path}/images/export.gif"/></a></td>
	  {/if}
        </tr>
	{/foreach}
	</tbody>
     </table>
     <input class="btn" type="button" value="刪除選取問卷" onClick="_delete();"/>
     </form>
   </div>

    <div id="create" style="display:none;">
    <h1>新增問卷設定</h1>
    <form method="GET" action="update_survey.php">
      <input type="hidden" name="option" value="create"/>
      問卷名稱：<input type="text" name="survey_name"/><br/>
      是否記名：{html_options name=is_register options=$register selected=$reg_select}<br/>
      <input class="btn" type="reset" value="清除資料">&nbsp;<input class="btn" type="submit" value="確定送出"/>
    </form>
    </div>
  </body>
</html>
