<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">


<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

{literal}


{/literal}

</head>
<body>

<table class="datatable">
<caption>個人訂閱討論區列表</caption>
<tr>
    <th>討論區名稱</th>
    <th>主旨</th>
	<th>種類</th>
    <th>所屬課程</th>
	{if $isDeleteOn == 1}
	<th>刪除</th>
	{/if}
</tr>

<!---------------------討論區列表------------------------->
{section name=counter loop=$disscussAreaList}
  <form method="post" action="{$absoluteURL}deleteSubscribeDiscussArea.php?begin_course_cd={$disscussAreaList[counter].begin_course_cd}&argument={$disscussAreaList[counter].discuss_cd}&finishPage=showSubscribeDiscussArea.php">
    <tr>
      <td><a href="{$absoluteURL}discussAreaList_intoArticleList.php?behavior={$behavior}&ArticleList=DisableReturn&begin_course_cd={$disscussAreaList[counter].begin_course_cd}&discuss_cd={$disscussAreaList[counter].discuss_cd}">{$disscussAreaList[counter].discuss_name}</a></td>
      <td>{$disscussAreaList[counter].discuss_title}</td>
      <td>{$disscussAreaList[counter].discuss_type}</td>
      <td>{$disscussAreaList[counter].begin_course_name}</td>
      {if $isDeleteOn == 1}
      <td><input type="submit" name="submit" onClick="return confirm('確定刪除訂閱這個討論區')" value="刪除" class="btn"></td>
      {/if} </tr>
  </form>
  {/section}
<!------------------------------------------------------->

</table>


</body>
</html>
