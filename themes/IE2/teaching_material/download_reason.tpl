<html>
<head>
{literal}
{/literal}
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="{$tpl_path}/css/font_style.css" rel="stylesheet" type="text/css" />
            <link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
                <link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
                    <link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
                        <link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>教材下載申請說明</h1>
<form name="download_reason" action="textbook_export.php?share={$share}" method="post">
<table  class="datatable"  width="100%" border="1">
    <tr>
        <td width="20%" >登入帳號:</td>
        <td width="80%" align="left">
            <input id="login_id" name="login_id" type="text" value="{$login_id}" disabled />
        </td>
    </tr>
    <tr>
        <td width="20%">會員姓名:</td>
        <td width="80%" align="left">
            <input id="personal_name" name="personal_name" type="text" value="{$personal_name}"  disabled />
		</td>
    </tr>	
	<tr>
        <td width="20%" >身份證字號:</td>
        <td width="80%" align="left">
            <input id="identify_id" name="identify_id" type="text" value="{$identify_id}"  disabled />
        </td>
    </tr>		
	<tr>
        <td width="20%" >單位:</td>
        <td width="80%" align="left">
            <input id="organization" name="organization" type="text" value="{$organization}" />
        </td>
    </tr>				
	<tr>
        <td width="20%" >下載理由:</td>
        <td width="80%" align="left">
            <textarea cols="30" rows="10" id="download_reason" name="download_reason"></textarea>
        </td>
    </tr>				
</table>
<input class="btn" type="submit" value="送出" />
</form>
</body>
</html>

