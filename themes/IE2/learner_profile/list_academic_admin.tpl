<html>

<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>



	<script type="text/javascript" src="{$webroot}script/default.js"></script>

<link href="{$tpl_path}/css/font_style.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/layout.css" rel="stylesheet" type="text/css" />

	

	<title>教務管理者名單</title>

	<script language="JavaScript" type="text/JavaScript">

	<!--

	{literal}

	

	function changeSelect(obj, index){

		var id =  obj.childNodes.item(index*2+1).getAttribute("value");	

		document.getElementById('login_id').style.display="none";

		document.getElementById('personal_name').style.display="none";

		document.getElementById('state').style.display="none";

		document.getElementById('validate').style.display="none";

		if(id != 'all')

			document.getElementById(id).style.display="";

	}

	

	

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

	

	function doSubmit(id, flag){

		document.getElementById('flag').value = flag;

		document.getElementById('id').value = id;

		document.myform.submit();

	}

	

	{/literal}

	-->

	</script>

</head>



<body class="ifr">

	<h1>教務管理者帳號管理</h1>

	<center>
	  <table border="0" align="right" cellpadding="0" cellspacing="0" style="font-size:14px;">
        <tr>
          <td width="90" height="27" ><div class="button001" align="center"><a href="new_academic_admin.php">新增</a></div></td>
          <td width="90" height="27" ><div class="button001" align="center"><a href="check_academic_admin.php?option=view">審核</a></div></td>
        </tr>
      </table>
	</center>
  <hr width="100%" style="color: #fff; background-color: #fff; border: 1px dotted #6699FF; border-style: none none dotted;">
	<form method="post" action="./list_academic_admin.php?action=search">

	<h2>搜尋</h2>

	<div class="searchbar" style="margin-left:60px;width:90%;padding:20px;"><table class="datatable" style="width:90%;margin:20px;">

	<tr>

		<th width="30%"><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>搜尋依據

		</th>

		<td width="50%"><select name="search" onChange="changeSelect(this, this.selectedIndex);">
            <option value"all" selected="selected">全部</option>
            <option value="login_id">帳號</option>
            <option value="personal_name">姓名</option>
            <option value="state">使用狀況</option>
            <option value="validate">是否核准</option>
          </select>
		</td>		

	</tr>

	<tr >

		<th ><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>輸入 </th>	

		<td >

			<div id="login_id" style="display:none;">

				<input type="text" name="login_id" />

			</div>

			<div id="personal_name" style="display:none;">

				<input type="text" name="personal_name" />

			</div>

			<div id="state" style="display:none;">

				<select name="state">

					<option value="1" selected="selected">使用</option>

					<option value="0">不使用</option>

				</select>

			</div>

			<div id="validate" style="display:none;">

				<select name="validate">

					<option value="0" selected="selected">不核准</option>

					<option value="1">核准</option>			

				</select>

		</div>		</td>
	</tr>

	<tr >

		<td colspan="2">

		<p class="al-left"> <input type="submit" name="送出搜尋" /></p>		</td>

	</tr>

	</table></div>

	</form>

	{if $show==1}
<hr width="100%" style="color: #fff; background-color: #fff; border: 1px dotted #6699FF; border-style: none none dotted;">

	<form action="check_teacher.php" method="GET" name="check_teacher">

	<h2>搜尋結果</h2>

  <table class="datatable" style="margin-left:50px">
	  <tbody>

		<tr>

			<th>

			<img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>帳號</th>

			<th valign="middle">

			<img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>姓名</th>

			<th valign="middle">

			<img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>身份證字號</th>

			<th valign="middle">

			<img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>服務單位</th>

			<!--<th>

			<img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>教師證編號</th>-->

			<th valign="middle">

			<img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>E-mail</th>

			<th valign="middle">

			<img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>連絡電話</th>

			<th valign="middle">

			<img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>使用</th>

		</tr>

		{foreach from=$data_list item=data}

		<tr>

			<td>{$data.login_id}</td>

			<td>{$data.personal_name}</td>

			<td>{$data.identify_id}</td>

			<td>{$data.organization}</td>

			<!--<td>{$data.teacher_doc}</td>-->

			<td>{$data.email}</td>

			<td>{$data.tel}</td>

			<td>{$data.state}</td> 

		</tr>

		{foreachelse}

		<tr>

			<td colspan="7" style="text-align:center;">目前無任何資料</td>

		</tr>

		{/foreach}

  </tbody></table>

	<input type="hidden" id="flag" name="flag" value="" />

	<input type="hidden" id="id" name="id" value="" />

	{/if}

</form>

</body>

</html>

