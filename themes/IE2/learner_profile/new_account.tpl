<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="{$tpl_path}/css/font_style.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/layout.css" rel="stylesheet" type="text/css" />
<title>新增教務管理者</title>
<script src="../script/prototype.js" type="text/javascript" ></script>
<script type="text/JavaScript">
{literal}
<!--	function init(){		document.getElementById('account_name').setFocus;	}
-->{/literal}
</script>
</head>
<body onLoad="init();" >
<h1>新增帳號</h1>{if $MSG != null }
<div style="text-algin:center; color:red">{$MSG}</div>{/if} 
<form method="post" action="new_account.php?action=new">
<table class="datatable">
<tr>
   <th style="width:70px; text-align:center; vertical-align:middle" >角色</th>
        <td>	
            <select name="role">			
            <option value="1" selected="selected">教師</option>		
            <!--<option value="2">助教</option>-->			
            <option value="3">學生</option>			
            <option value="4">訪客</option>			
           <!-- <option value="5">測試人員</option>-->			
            <option value="6" >教務管理者</option>		
            </select>	
        </td>
</tr>
<tr>	
   <th style="width:70px; text-align:center; vertical-align:middle" >帳號</th>
    <td>		
         <input type="text" id="account_name" name="account_name" value="{$valueOfAccount_name}" />	
    </td>
</tr>
<tr>
  <th style="width:70px; text-align:center; vertical-align:middle">密碼</th>	
    <td>		
      <input type="text" name="password" value="{$valueOfPasseord}" />(請至少輸入八碼)	
    </td>
  </tr>{*<tr>	<th style="width:70px; text-align:center; vertical-align:middle">再次確認</th>	<td>		<input type="password" name="password_check" value="{$valueOfPasseord_check}" />	</td>
</tr>*}
<tr>	
<!--（1:國民中小學教師、2:高中職教師、4:大專院校教師、5:數位機會中心輔導團隊講師、6:縣市政府研習課程老師、7:其他-->
   <th style="width:70px; text-align:center; vertical-align:middle" >身份</th>
    <td>
        <select id="selRole" name="selRole"  length="30">
                  <option value="-1">請選擇</option>
                  <option value="0">一般民眾</option>
                  <option value="1">國民中小學教師</option>
                  <option value="2">高中職教師</option>
                  <option value="3">大專院校學生</option>
                  <option value="4">大專院校教師</option>
                  <option value="5">數位機會中心輔導團隊講師</option>
                  <option value="6">縣市政府研習課程老師</option>
                  <option value="7">其他</option>
        </select>
    </td>
</tr>

<tr>	<td colspan="2" style="text-align:center">	<input type="reset" value="重設">	<input name="submit" type="submit" value="確定">	<input type="button" value="返回" onclick="document.location='adm_query_user.php';return false;">	</td></tr>
</table></form>
</body></html>
