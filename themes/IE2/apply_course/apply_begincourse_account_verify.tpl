<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="{$tpl_path}/css/content_course.css" rel="stylesheet" type="text/css" />

<link href="{$tpl_path}/css/layout.css" rel="stylesheet" type="text/css" />

<link href="{$tpl_path}/css/font_style_course.css" rel="stylesheet" type="text/css" />
{* 

<script src="{$webroot}script/jquery-1.3.2.min.js" type="text/javascript"></script>

*}



<title>申請開課帳號</title>

{literal}

<script language="javascript" type="text/javascript">

</script>



<style>



</style>

{/literal}

</head>

<body>



<h1>開課帳號申請</h1>



<div>

	<table class="datatable" width="600px" align="center">

		<caption>開課帳號身份類別：{$account_data.category}</caption>

		<tr><th  width="200">開課帳號</th>

	  <td>{$account_data.account}</td></tr>

		<tr><th>申請開課人姓名</th>

	  <td>{$account_data.org_title}</td></tr>

		<tr id="tr_undertaker"><th>聯絡人</th>

	  <td><label>{$account_data.undertaker}</label></td></tr>

		<tr><th class="filed_str">職稱</th>

	  <td>{$account_data.title}</td></tr>

		<tr><th class="filed_str">聯絡電話</th>

	  <td>{$account_data.tel}</td></tr>

		<tr><th class="filed_str">E-mail</th>

	  <td>{$account_data.email}</td></tr>

		<tr><th class="filed_str">帳號申請用途</th>

	  <td><label>{$account_data.usage_note|escape|nl2br}</textarea></label></td> </tr>

        <tr><th class="filed_str">申請日期</th>

      <td>{$account_data.apply_date}</td></tr>

	</table>

</div>



<hr/>

    


  <form action="apply_begincourse_account_verify.php"  method="post">

	  <table class="datatable" align="center" width="600px"><tr><th width="100px"><input name="no" type="hidden" value="{$account_data.no}"/>

		  <input name="pass" type="hidden" value="true"/>

		  <input type="submit" value="通過" /></th>
		<td>通過的帳號將可以申請開課。</td></tr>
	  </table>
  </form>


		<form action="apply_begincourse_account_verify.php"  method="post">
				<table class="datatable" align="center" width="600px"><tr><th width="100px">
				<input name="no" type="hidden" value="{$account_data.no}"/>

				<input name="pass" type="hidden" value="false">

				<input  type="submit" value="不通過" method="post"></th>
				<td>

			原因：

			<textarea id="state_reason" name="state_reason" cols="45" rows="5"></textarea>			</td></tr></table>

		</form>

</div>



</body>

</html>
