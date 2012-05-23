<html>
<meta http-equiv="Cache-Control" content="no-cache,no-store,must-revalidate,max-age=0"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<head>
<script type="text/javascript" charset="utf-8" src="../script/examine/exam_main.js"></script>

<script language="javascript" src="../script/nlstree/nlstree.js"></script>
<!-- script language="javascript" src="../script/nlstree/nlsctxmenu.js"></script -->
<!-- script language="javascript" src="../script/nlstree/nlstreeext_ctx.js"></script -->
<!-- script language="javascript" src="../script/nlstree/nlstreeext_sel.js"></script -->
<!-- script language="javascript" src="../script/nlstree/nlsconnection.js"></script -->
<!-- script language="javascript" src="../script/nlstree/reorder.js"></script -->
<!-- script language="javascript" src="../script/nlstree/nlstreeext_dd.js"></script -->
<!-- script language="javascript" src="../script/nlstree/nlstreeext_state.js"></script -->
<!-- script language="javascript" src="../script/survey.js"></script -->

{if !empty($banks)}
{literal}
<script type="text/javascript">
<!--
	var tree = new NlsTree("tree");
	tree.opt.sort = "no";
function init()
{
    //assign(tree);  //in survey.js
	//setTree();     //in survey.js
{/literal}
    tree.add("root", 0, "※教材{$content_name}<br/>題庫列表", "", "../script/nlstree/img/root.gif", true);

{foreach from=$banks item=bank name=banks_loop}
	/* {$bank.bank_id}-{$bank.bank_name} */
	tree.add({$bank.bank_id}00, "root", "{$bank.bank_name}", "exam_main.php?test_bank_id={$bank.bank_id}&test_type={$test_type}", "../script/nlstree/img/folder.gif", false);
	tree.add({$bank.bank_id}02, {$bank.bank_id}00, "簡易", "exam_main.php?level=0&test_bank_id={$bank.bank_id}&test_type={$test_type}", "../script/nlstree/img/leaf.gif", false);
	tree.add({$bank.bank_id}03, {$bank.bank_id}00, "中等", "exam_main.php?level=1&test_bank_id={$bank.bank_id}&test_type={$test_type}", "../script/nlstree/img/leaf.gif", false);
	tree.add({$bank.bank_id}04, {$bank.bank_id}00, "困難", "exam_main.php?level=2&test_bank_id={$bank.bank_id}&test_type={$test_type}", "../script/nlstree/img/leaf.gif", false);
	tree.add({$bank.bank_id}05, {$bank.bank_id}00, "編輯題庫", "../Test_Bank/test_bank_content.php?content_cd={$content_cd}&test_bank_id={$bank.bank_id}", "../script/nlstree/img/leaf.gif", false);
{/foreach}
{literal}
	tree.add("random", "root", "亂數出題", "random.php", "../script/nlstree/img/root.gif", false);
	
	
};
{/literal}
-->
</script>
{/if}

<link rel="StyleSheet" href="../script/nlstree/nlstree.css" type="text/css" />
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
<title>Create a new exam</title>
</head>
<body>
{if !empty($banks)}
<script>
{literal}
	init();
	tree.renderAttributes();
	
{/literal}
</script>
{/if}

<div style="width:15%; float:left; border:1px solid #CCCCCC; " id="nltree">
{if !empty($banks)}
	<script>
		tree.render();
		tree.expandNode({$current_bank_id}00);
	</script>
{else}
	<p class="intro"><span class="imp">沒有題庫，請先編輯題庫</span></p>
{/if}
</div>


<div style="position:absolute; left:17%; ">
  <h1>編輯測驗題目</h1>
  <p class="intro"><span class="imp">請由左列教材選擇測驗題目</span><br>
    <br />
      <strong>測驗狀態：</strong><br />
  目前測驗總分: {$exam_total}。目前測驗總題數: {$exam_checked}。 <a href="display_exams.php?option=delete&test_no={$test_no}">[取消此次測驗]</a></p>


  <hr size="1">
  <h1>目前檢視題庫：{$current_bank_name}</h1>
  <p class="intro"><strong>題庫狀態： {$test_type_char} － {$difficulty}<br/>
  </strong>此題庫目前所佔配分: {$checked}。此教材目前已選擇的題數: {$total}。</p>
  <div class="tab">
  <ul id="tabnav">
	<li style="background-image:none; border:none; cursor:text;"><strong></strong>教材題型列表：</li>
    <li class="tabA"><div onClick="myredirect({$content_cd}, {$current_bank_id}, 1, 'tabA')">選擇題</div></li>
    <li class="tabB"><div onClick="myredirect({$content_cd}, {$current_bank_id}, 2, 'tabB')">是非題</div></li>
    <li class="tabC"><div onClick="myredirect({$content_cd}, {$current_bank_id}, 3, 'tabC')">填充題</div></li>
    <li class="tabD"><div onClick="myredirect({$content_cd}, {$current_bank_id}, 4, 'tabD')">簡答題</div></li>
  </ul>
</div>
  <form method="GET" action="">
  <table class="datatable">
    <tr>
      <th width="10%">題號索引</th>
      <th>問題描述</th>
      <th width="10%">核選</th>
      <th>配分</th>
    </tr>
    <input type="hidden" name="test_type" value="{$test_type}"/>
    {foreach from=$content item=item1}
    <tr class="{cycle values=" ,tr2"}">
      <td>{$item1.num}</td>
      <td><span onMouseOver="show(event,'{$item1.question}')" onMouseOut="hide()"> <a target=_blank href="../Test_Bank/show_test.php?test_bankno={$item1.test_bankno}">{$item1.question|truncate:45:"...":true}</a> </span> </td>
      <td><input type="checkbox" name="quest[]" value="{$item1.test_bankno}" id="ch_box{$item1.ind}" onClick="clicked({$item1.ind})" {if $item1.disable == "disabled"}disabled checked{/if}/></td>
      <td><input type="text" name="percentage[]" size="4" value="{$item1.percentage}" id="in_box{$item1.ind}" disabled/></td>
    </tr>
    {foreachelse}
    <tr>
      <td colspan="2" style="text-align:center;">本題型目前無任何題目</td>
      <td colspan="2" style="text-align:center;">{if !empty($banks) || $current_bank_id != null} <a href="../Test_Bank/test_bank_content.php?content_cd={$content_cd}&test_bank_id={$current_bank_id}">編輯本題庫</a>{/if}</td>
    </tr>
    {/foreach}
    <tr align="center">
      <td colspan="4"><p class="al-left">總配分為:
        <input name="text" type="text" id="auto_score" onKeyUp="scoreChange(this.id)" size="5"/>
        <input name="button" type="button" class="btn" onClick="auto_distribute()" value="平均配分"/>
         <br>
        (ex: 共核選5題，總配分50分，則系統將平均配分為每題10分)</p></td>
      </tr>
    <input type="hidden" name="checkScore" value="1"/>
    <input type="hidden" name="content_cd" value='{$content_cd}'/>
    <tr>
      <td colspan="4"><p class="al-left">
          <input type="reset" class="btn" value="清除資料"/>
          <input type="submit" class="btn" value="下一步"/>
        </p></td>
    </tr>
  </table>
</form>
<p class="al-left"><a href="tea_view.php"><img src="{$tpl_path}/images/icon/return.gif" />返回線上測驗列表</a>&nbsp;&nbsp;&nbsp;<a href="display_exam.php?test_no={$test_no}"><img src="{$tpl_path}/images/icon/return.gif" />返回測驗題目列表</a></p>
<br/>
<br/>
  <layer visibility="hide" bgcolor="#FFCC00"/>
  <div id="lay" style="position:absolute; background-color:#FFCC00;"></div>
</div>	
</body>
</html>
