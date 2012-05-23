<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="StyleSheet" href="{$webroot}script/nlstree/nlsctxmenu.css" type="text/css" />
    <link rel="StyleSheet" href="{$webroot}script/nlstree/nlstree.css" type="text/css" />
    <link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

    <script language="javascript" src="{$webroot}script/nlstree/nlstree.js"></script>
    <script language="javascript" src="{$webroot}script/nlstree/nlsctxmenu.js"></script>
    <script language="javascript" src="{$webroot}script/nlstree/nlstreeext_ctx.js"></script>
    <script language="javascript" src="{$webroot}script/nlstree/nlstreeext_sel.js"></script>
    <script language="javascript" src="{$webroot}script/nlstree/nlsconnection.js"></script>
    <script language="javascript" src="{$webroot}script/nlstree/reorder.js"></script>
    <script language="javascript" src="{$webroot}script/nlstree/nlstreeext_dd.js"></script>
    <script language="javascript" src="{$webroot}script/nlstree/nlstreeext_state.js"></script>

    <script language="javascript" src="{$webroot}script/default.js"></script>
    <script language="javascript" src="{$tpl_path}/script/default.js"></script>
    <script language="javascript" src="{$tpl_path}/script/survey.js"></script>

    <script type="text/javascript"><!--
      var tree = new NlsTree("tree");
      
      {literal}
      function init(){
      {/literal}
        assign(tree);  //in survey.js
	setTree();     //in survey.js

        tree.add("root", 0, "問卷題組", "", "{$webroot}script/nlstree/img/root.gif", true);
        {foreach from=$question_data item=quest}
        tree.add({$quest.survey_cd}, "root", "{$quest.question}", "edit_survey.php?survey_no={$survey_no}&block_id={$quest.survey_cd}", "{$webroot}script/nlstree/img/folder.gif", false);
        {/foreach}
      {literal}
      }
      {/literal}
    --></script>
  </head>

  <body class="ifr">
  <script>
  {literal}
    init();
    tree.renderAttributes();
  {/literal}
  </script>
    <div style="width:200px; border:1px outset green; float:left;" id="nltree">
    <script>
      tree.render();
    </script>
    </div>
    <div style="width:100%; height:100%;" id="main_content">
      <div>
	{if $num != 0}
	選擇題目：<br/>
        <form method="GET" action="edit_survey.php" name="form_add">
	  <input type="hidden" name="option" value="insert"/>
	  <input type="hidden" name="block_id" value="{$block_id}"/>
	  <input type="hidden" name="survey_no" value="{$survey_no}"/>
	  <input type="hidden" name="continue_add" id="continue_add"/>
          <table class="datatable">
            <tr>
              <th><input type="checkbox" onclick="clickAll('form_add', this);"/></th>
              <th>索引</th>
              <th>題目內容</th>
            </tr>
            {foreach from=$unchecked item=quest}
            <tr class="{cycle values=" ,tr2"}">
              <td><input type="checkbox" name="survey_cd[]" value="{$quest.survey_cd}"/></td>
              <td style="text-align:center;">{$quest.index}</td>
              <td>{$quest.question}</td>
            </tr>  
            {/foreach}
	  </table>
	  <input type="reset" class="btn" value="清除資料"/><input type="button" class="btn" value="確定送出" onClick="_onsubmit('add');"/>
	</form>
        {else}
          本題組目前無任何題目可選擇<br/>
        {/if}
      </div>
      <hr/>
      <div>
       {if $num2 != 0}
       刪除已選定的題目：<br/>
       <form method="GET" action="edit_survey.php" name="form_del">
	  <input type="hidden" name="option" value="delete"/>
	  <input type="hidden" name="block_id" value="{$block_id}"/>
	  <input type="hidden" name="survey_no" value="{$survey_no}"/>
	  <input type="hidden" name="continue_del"/>
          <table class="datatable">
            <tr>
              <th><input type="checkbox" onclick="clickAll('form_del', this);"/></th>
              <th>索引</th>
              <th>題目內容</th>
            </tr>
            {foreach from=$checked item=quest}
            <tr class="{cycle values=" ,tr2"}">
              <td><input type="checkbox" name="survey_cd[]" value="{$quest.survey_cd}"/></td>
              <td style="text-align:center;">{$quest.index}</td>
              <td>{$quest.question}</td>
            </tr>  
            {/foreach}
	  </table>
	  <input type="reset" class="btn" value="清除資料"/><input type="button" class="btn" value="確定送出" onClick="_onsubmit('del');"/>
       </form>
       {/if}
      </div>
    </div>
  </body>
</html>
