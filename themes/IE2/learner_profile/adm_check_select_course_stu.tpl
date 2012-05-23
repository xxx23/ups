<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>觀看帳號</title>
<link href="{$tpl_path}/css/font_style.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/layout.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" type="text/JavaScript">
<!--
{literal}
function doCheckAll(string){
        var nodes = document.getElementsByName(string);

        if(nodes.item(0).checked){
                for(var i=0; i < nodes.length ; i++)
                        nodes.item(i).checked = false;
        }else{
                for(var i=0; i < nodes.length ; i++)
                        nodes.item(i).checked = true;
        }
}

function doSubmit(flag){
        document.getElementById('flag').value = flag;
        document.myform.submit();
        /*switch(id){
                case 'state':

                        break;
                case 'validate':

                        break;
                default:

                        break;
        }*/
}
{/literal}
-->
</script>
</head>

<body>
<h1>{$begin_course_name}選課學生列表</h1>
  <!-- 內容說明
<p class="intro">
說明：<br />
</p>
 -->

  <!--功能部分 -->

  <form method="post" name="myform" action="./adm_check_select_course_stu.php?action=modify&begin_course_cd={$begin_course_cd_tag}">
  <table class="datatable">
    <tr>
      <th><input type="checkbox" name="checkAll" onClick="doCheckAll('check[]');" />全選 </th>
      <th>姓名</th>
	  <th>審核狀態</th>
	  <th>審核操作</th>
	  <th></th>
    </tr>
    {foreach from=$stu_data item=stu}
    <tr>
      <td><input type="checkbox" name="check[]" value="{$stu.personal_id}"/></td>
	  <td><a target="_blank" href="../Learner_Profile/user_profile.php?id={$stu.personal_id}">{$stu.personal_name}</a></td>
	  <td>{$stu.allow}</td>
      <td>
		{if $stu.allow eq '核准'}
			<a href="./adm_edit_reject_reason.php?personal_id={$stu.personal_id}&begin_course_cd={$begin_course_cd}" >[變更為不核准]</a>
		{elseif $stu.allow eq '不核准'}
			<a href="./adm_check_select_course_stu.php?action=allow_course&personal_id={$stu.personal_id}&begin_course_cd={$begin_course_cd}" >[變更為核准]</a>
		{else}
		<a href="./adm_check_select_course_stu.php?action=allow_course&personal_id={$stu.personal_id}&begin_course_cd={$begin_course_cd}" >[核准]</a>
		<a href="./adm_edit_reject_reason.php?personal_id={$stu.personal_id}&begin_course_cd={$begin_course_cd}" >[不核准]</a>
		{/if}
	  </td>
	  <td>
	    {if $stu.allow eq '不核准'}
			不核准理由(<a href="./adm_edit_reject_reason.php?personal_id={$stu.personal_id}&begin_course_cd={$begin_course_cd}">修改</a>) :<br/>{$stu.note}
		{/if}
	   </td>
    </tr>
	{/foreach}
  </table>
  	<input type="hidden" id="flag" name="flag" value="" />
	<input type="button" value="核准" onClick="doSubmit(1)" />
	<input type="button" value="不核准" onClick="doSubmit(0)" />
	<input type="button" value="返回" onClick="location.href='./adm_check_select.php'" />
  </form>
<br />
<br />
<br />
<br />
<br />

</body>
</html>
