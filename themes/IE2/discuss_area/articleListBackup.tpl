<html>
<head>
<title> 現有的討論主題 </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<link href="tabs.css" rel="stylesheet" type="text/css" />
<link href="content.css" rel="stylesheet" type="text/css" />
<link href="table.css" rel="stylesheet" type="text/css" />
<link href="form.css" rel="stylesheet" type="text/css" />

{literal}

<script language="Javascript">

</script>

{/literal}


</head>

<body>



{if $articleNum > 0}


<table class="datatable">
<tr>
  <th>主題</th>
  <th>張貼</th>
  <th>張貼日</th>
  <th>最近回覆日</th>
  <th>點閱次</th>
  <th>回覆次數</th>
</tr>
<!---------------------文章列表------------------------->
{section name=counter loop=$articleList}


<tr class="{cycle values=",tr2"}">
	<td><a href="showArticle{$articleList[counter].discuss_content_cd}.html">{$articleList[counter].discuss_title}</a></td>
	<td>{$articleList[counter].discuss_author}</td>
	<td>{$articleList[counter].d_created}</td>
	<td>{$articleList[counter].d_replied}</td>
	<td>{$articleList[counter].viewed}</td>
	<td>{$articleList[counter].reply_count}</td>
</tr>

{/section}
<!------------------------------------------------------->
</table>

<hr>


{/if}

</body>
</html>

