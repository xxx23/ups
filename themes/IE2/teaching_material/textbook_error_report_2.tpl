<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../themes/IE2/css/font_style.css" rel="stylesheet" type="text/css" />
<title>教材勘誤頁面</title>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
<link rel="StyleSheet" href="{$script_path}nlstree/nlsctxmenu.css" type="text/css" />
<link rel="StyleSheet" href="{$script_path}nlstree/nlstree.css" type="text/css" />
<script language="javascript" src="{$script_path}nlstree/nlstree.js"></script>
<script language="javascript" src="{$script_path}nlstree/nlsctxmenu.js"></script>
<script language="javascript" src="{$script_path}nlstree/nlstreeext_ctx.js"></script>
<script language="javascript" src="{$script_path}nlstree/nlstreeext_sel.js"></script>
<script language="javascript" src="{$script_path}nlstree/nlsconnection.js"></script>
<script language="javascript" src="{$script_path}nlstree/reorder.js"></script>
<script language="javascript" src="{$script_path}nlstree/nlstreeext_dd.js"></script>
<script language="javascript" src="{$script_path}nlstree/nlstreeext_state.js"></script>
{literal}
<script>

function check(){

    var page=document.getElementById("page").value;
    var content=document.getElementById("content").value;

    re = /^\d+$/;
    //content=content.replace(/^[ \t\n\r]+/g, "");
    //content=content.replace(/[ \t\n\r]+$/g, "");
    //content=str_replace("<!--","", content);
    //content=trim(content);
    if(page=="")
    {
        alert("您尚未填入頁數");
        return false;
    }                        
    else if(!(re.test(page)))
    {
        alert("頁數請填入數字");
        return false;
    }
    else if(content=="")
    {
        alert("您尚未填入勘誤內容");
        return false;
    }
    else if(content.match(/<\S[^><]*>/g)!=null)
    {
        alert("請勿輸入 HTML TAG!!");
        return false;
    }
    else
    {
        content=content.replace(/&/g, '&amp;');
        content=content.replace(/</g, '&lt;');
        content=content.replace(/>/g, '&gt;');
        content=content.replace(/"/g, '&quot;');
        content=content.replace(/\'/g, '&#039;');
        document.getElementById("content").value=content;
        return true;
        }

}
/*function moveUp(selNodes) {
    //move before previous node of selected node.
    var prev=(selNodes[0]?selNodes[0].pv:null);
    if (!prev) return;
    tree.ctx_moveChild(selNodes, prev, 2);
    tree.selectNodeById(selNodes[0].orgId);
}

function moveDown(selNodes) {
    //move after next node of selected node.
    var next=(selNodes[0]?selNodes[0].nx:null);
    if (!next) return;
    tree.ctx_moveChild(selNodes, next, 3);
    tree.selectNodeById(selNodes[0].orgId);
}

function rootCtxMenu(selNode, menuId, itemId) {
    switch (itemId) {
        case "1":
            tree.expandNode(selNode.orgId);
        break;
        case "2":
            tree.collapseNode(selNode.orgId);
        break;
    }
}
function init(){

    tree.opt.mntState = true;
    tree.opt.icAsSel = false;
    tree.opt.trg = "textbook";
    //tree.treeOnNodeChange = function(node){changeNode(node)};
    {/literal}
    tree.opt.sort = "no" ;
    tree.opt.selRow = true;
    {$addNode} //build tree

    content_cd = {$Content_cd};

    tree.opt.editable = false;
    ctx.absWidth = 150;

    ctx.add("1", "全部展開", "", "{$script_path}nlstree/img/arrowdown.gif");
    ctx.add("2", "全部縮緊", "", "{$script_path}nlstree/img/arrowright.gif");
    ctx.addSeparator();
    //ctx.add("3", "上移", "");
    //ctx.add("4", "下移", "");

    ctx.menuOnClick = globalCtxMenu;
    tree.setGlobalCtxMenu(ctx);

    ctx2.add("1", "全部展開", "", "{$script_path}nlstree/img/arrowdown.gif");
    ctx2.add("2", "全部縮緊", "", "{$script_path}nlstree/img/arrowright.gif");

    ctx2.menuOnClick = rootCtxMenu;
}
*/
</script>

</head>
<script>
  /*init();
    //tree.treeOnNodeChange=onNodeChange;
    {literal}
        tree.treeOnNodeChange = function(id){changeNode(id)};
    {/literal}
        tree.renderAttributes();
        */
</script>

<body class="ifr" id="tabA">
<h1>教材勘誤頁面</h1>
<div class="tab">
    <ul id="tabnav">
    <li class="tabA" >{$Caption}&nbsp;教材錯誤回報</li>
    </ul>
</div>
    {*<div class="area" id="message" style="width:150px; height:500px; overflow:auto;">*}
    {if $menu_id!=-1}
    <div>
        
        <form method="post" onsubmit="return check();" action="textbook_error_report_3.php?menu_id={$menu_id}&&content_cd={$Content_cd}">
       {* <table class="datatable" align="center" width="400" height="300" border="1">*}
        <table class="datatable">
        <tr>
        <td width=100 align="center"> 回報者</td> 
        <td><input type="text"id="reporter"  name="reporter" value={$reporter} readonly></td></tr>
        <tr>
        <td width=100 align="center"> 章節</td>
        <td><input type="text" size="30" id="chapter" name="chapter" value={$chapter} readonly></td></tr>
        <tr>
        <td width=100 align="center"> 頁數</td>
        <td><input type="text" id="page" name="page"></td></tr>
        <tr>
        <td width=100 align="center"> 內容</td>
        <td><textarea name="content" id="content" cols="20" rows="5"></textarea></td></tr>
        <tr>
        <td colspan="2" width=400 align="center"><input type="submit" value="確定送出"></td></tr>
        </table>
    </form>
    {else} <font size="5">請先點選左側子章節</font>
    {/if}
    </div>
</body>
</html>
