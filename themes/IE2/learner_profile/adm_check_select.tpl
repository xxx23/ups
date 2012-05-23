<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title>觀看帳號</title>

<link href="{$tpl_path}/css/font_style.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/layout.css" rel="stylesheet" type="text/css" />

<script language="JavaScript" type="text/JavaScript">

<!--

{literal}
function changePage(page)
{
    var myForm=document.forms['searchForm'];
    if(myForm.page)myForm.page.value =page;
    myForm.action = "./adm_check_select.php?action=search";
    myForm.submit();

return;
}

function pageContorlSubmin(form)
{
    var myForm=document.forms['searchForm'];
    myForm.action = "./adm_check_select.php?action=search";
    myForm.submit();
    return;
}

function doCheckAll(string){

	var nodes = document.getElementsByName(string);

	//alert(nodes[1].innerHTML);

	//alert(nodes.length);

	if(nodes.item(0).checked){

		for(var i=0; i < nodes.length ; i++)

			nodes.item(i).checked = false;

	}else{

		for(var i=0; i < nodes.length ; i++)

			nodes.item(i).checked = true;	

	}

}

{/literal}

-->

</script>

</head>



<body>

<h1>選課列表</h1>

<h2>內容說明</h2>

<div class="intro">

</div>

<!--功能部分 -->

<form id="searchForm" name="searchForm" action="./adm_check_select.php?action=output" method="post">
  <table class="datatable">
    <tr>
      <th width="8%"> 
        <input type="checkbox" name="checkAll" onClick="doCheckAll('check[]');" />

      全選 </th>

      <th> 課程編號</th>

      <th width="12%"> 開課單位</th>

      <th> 開課名稱</th>

      <th> 授課教師</th>

	  <th width="5%"> 核准修課人數</th>

	  <th width="5%"> 選課人數</th>	 

      <th> 修改名單</th>

    </tr>

    {foreach from=$course_data item=course}

    <tr>

      <td><input type="checkbox" name="check[]" value="{$course.begin_course_cd}" /></td>

      <td>{$course.inner_course_cd}</td>

      <td>{$course.unit_name}</td>

      <td>{$course.begin_course_name}</td>

      <td>{$course.personal_name}</td>

	  <td>{$course.ok_num}</td>

	  <td>{$course.all_num}</td>

      <td><a href="./adm_check_select_course_stu.php?begin_course_cd={$course.begin_course_cd}" >觀看修課名單</a></td>

    </tr>

	{/foreach}  

  </table>
  <div id="pageControl" align="center" >
    {if $page_cnt ne 0}
     <span>第
     <select name="page" onChange="pageContorlSubmin(this)" >
    {html_options values=$page_ids output=$page_names  selected=$page_sel}
     </select>/{$page_cnt}頁
      </span>
      <br><a href="javascript:changePage({$previous_page})">上一頁</a>
      <a href="javascript:changePage({$next_page})"  >下一頁</a>
    {/if}
  </div>

<input type="submit" value="匯出選課名單" />
</form>



{if $file==1}

<h1>匯出檔案下載</h1>

<table class="datatable">

<tr>

  <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/> 課程編號</th>

  <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/> 開課名稱</th>

  <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/> 下載</th>

</tr>

{foreach from=$output_data item=output}

<tr>

 <td>{$output.inner_course_cd}</td>

 <td>{$output.begin_course_name}</td>

 <td>{$output.file}</td>	

</tr>

{/foreach}  

</table>

{/if}

<br />

<br />

<br />

<br />

<br />



</body>

</html>

