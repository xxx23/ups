<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="StyleSheet" href="{$webroot}script/nlstree/nlsctxmenu.css" type="text/css" />
    <link rel="StyleSheet" href="{$webroot}script/nlstree/nlstree.css" type="text/css" />

    <script language="javascript" src="{$webroot}script/prototype.js"></script>
    <script language="javascript" src="{$webroot}script/nlstree/nlstree.js"></script>
    <script language="javascript" src="{$webroot}script/nlstree/nlsctxmenu.js"></script>
    <script language="javascript" src="{$webroot}script/nlstree/nlstreeext_ctx.js"></script>
    <script language="javascript" src="{$webroot}script/nlstree/nlstreeext_sel.js"></script>
    <script language="javascript" src="{$webroot}script/nlstree/nlsconnection.js"></script>
    <script language="javascript" src="{$webroot}script/nlstree/reorder.js"></script>
    <script language="javascript" src="{$webroot}script/nlstree/nlstreeext_dd.js"></script>
    <script language="javascript" src="{$webroot}script/nlstree/nlstreeext_state.js"></script>
    {*放在各個themes底是合理的，因為其中發生錯誤時的訊息，是中文的*}
    <script language="javascript" src="{$tpl_path}/script/survey.js"></script>

    <script type="text/javascript"><!--
      var tree = new NlsTree("tree");
      var ctx = new NlsCtxMenu("ctx");
      var ctx2 = new NlsCtxMenu("ctx2");

      {literal}
      function rootCtxMenu(selNode, menuId, itemId){
        switch(itemId){
	  case "1":
	    createNewGroup(1);
	    break;
	  default:
	    break;
	}
      }
      function globalCtxMenu(selNode, menuId, itemId){
	switch(itemId){
	  case "1":
	    editGroup(selNode);
	    break;
	  case "2":
	    delete_all(selNode);
	    break;
	  default:
	    break;
	}
      }
      
      function init(){
      {/literal}
        assign(tree);  //in survey.js
	get_webroot(); //in survey.js
	setTree();     //in survey.js

        tree.add("root", 0, "問卷題目", "", "{$webroot}script/nlstree/img/root.gif", true);
        {foreach from=$question_data item=quest}
        tree.add({$quest.survey_cd}, "root", "{$quest.question}", "question_list.php?block_id={$quest.survey_cd}", "{$webroot}script/nlstree/img/folder.gif", false);
        {/foreach}

	ctx.absWidth = 150;
	ctx.add("1", "編輯題目", null, "{$webroot}script/nlstree/img/config.gif");
	ctx.add("2", "刪除此題目", null, "{$webroot}script/nlstree/img/deletenode.gif");

        tree.opt.icAsSel = false; 
        tree.opt.trg = "question";
        ctx.menuOnClick = globalCtxMenu;
	tree.setGlobalCtxMenu(ctx);

	ctx2.absWidth = 150;
        ctx2.add("1", "新增題目", null, "{$webroot}script/nlstree/img/newnode.gif");
        ctx2.menuOnClick = rootCtxMenu;
	tree.setNodeCtxMenu("root", ctx2);
      {literal}
      }
      {/literal}
    --></script>
  </head>

  <body class="ifr">
    <div id="information" style="display:none;">WEBROOT={$webroot}</div>
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
      <iframe id="question" src="question_list.php?block_id={$first_block}" name="question" frameborder="no" style="width:100%; height:100%;"></iframe>
    </div>
  </body>
</html>
