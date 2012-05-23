<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<link href="{$tpl_path}/css/content_course.css" rel="stylesheet" type="text/css" />

<link href="{$tpl_path}/css/layout.css" rel="stylesheet" type="text/css" />

<link href="{$tpl_path}/css/font_style_course.css" rel="stylesheet" type="text/css" />

<script src="{$webroot}script/jquery-1.3.2.min.js" type="text/javascript"></script>



<title>申請開課帳號</title>



{literal}

<script language="javascript" type="text/javascript">
{/literal}
var personal_str = ['開課帳號', '密碼', '再次確認密碼' ,'所屬縣市', '所屬學校', '申請開課人姓名', '聯絡人', '職稱', '聯絡電話' ,'E-mail', '帳號申請用途<br />(請詳填，供審核人員檢核)'];
 
 var organziation_str = ['開課帳號' , '密碼', '再次確認密碼', '所屬縣市','所屬單位名稱', '申請開課人姓名', '聯絡人', '職稱' , '聯絡電話', 'E-mail', '帳號申請用途<br />(請詳填，供審核人員檢核)'];
    
{literal}


</script>



<style>

	.forms { margin:0 auto}

	#d1{display:none;color:#122333;}

	#d2{display:none;color:#122333;}

	#d3{display:none;color:#122333;}

</style>

{/literal}

</head>

<body>


<h1>開課帳號申請</h1> 

<div class="describe" style="padding-left:30px">

 此開課帳號申請後會由管理者審核。通過後，可課程管理系統中『申請開課』。
</div>

	
<h2>step1.請先選擇開課帳號隸屬機構or單位</h2> 

    <div style="padding-left:50px">
<select name="sel_category" id="sel_category"> 
 
        <option selected>請選擇</option> 
 
        <option value="1">縣市政府 (開課對象為國民中小學教師)</option> 
 
        <option value="2">大專院校 (開課對象為大專院校教師/學生)</option> 
 
        <option value="3">數位機會中心輔導團隊 (開課對象為一般民眾)</option> 
 
        </select> 
 

		</div>

<br/>

<br/>

<br/>





<div id='d1'  class='forms'>

<form name="apply_begincourse_account1" action="apply_begincourse_account_add.php" method="post">

<input type="hidden" name="category" value="1">

<h2>填寫詳細申請資料</h2>
	<table class="t1" width="600" align="center" style="font-size:14px;background:#EFD5BC;border:dashed #FFFFFF thin">

		<caption>縣市政府</caption>

		<tr><th width="300" style="background:#E8C2AA;border:dashed #FFFFFF 1px">帳號</td><td><input type="text" name="account" id="account" /></td></tr>

		<tr><th style="background:#E8C2AA;border:dashed #FFFFFF 1px">密碼</th><td><input type="password" name="password" id="password" /></td></tr>

		<tr><th style="background:#E8C2AA;border:dashed #FFFFFF 1px">再次輸入密碼</th><td><input type="password" name="check_password" id="check_password" /></td></tr>		
                                        
                                        <tr><th style="background:#E8C2AA;border:dashed #FFFFFF 1px">所屬縣市</th><td>
                                                <select  name="city_cd" id="city_cd" />
                                                <option value="">請選擇</option>
                                                {foreach  from=$citys item=city}
                                                <option value="{$city.city_cd}">{$city.city}</option>
                                                {/foreach}
                                                </select>
                                            </td></tr>
       <tr><th style="background:#E8C2AA;border:dashed #FFFFFF 1px">縣市政府單位名稱<br/>(承辦單位)</th><td><input type="text" name="org_title" id="org_title" /></td></tr> 
 
        <tr><th style="background:#E8C2AA;border:dashed #FFFFFF 1px">聯絡人(承辦人姓名)</th><td><label><input type="text" name="undertaker" id="undertaker" /></label></td></tr> 
 
        <tr><th style="background:#E8C2AA;border:dashed #FFFFFF 1px">職稱</th><td><input type="text" name="title" id="title" /></td></tr> 
 
        <tr><th style="background:#E8C2AA;border:dashed #FFFFFF 1px">聯絡電話</th><td><input type="text" name="tel" id="tel" /></td></tr> 
 
        <tr><th style="background:#E8C2AA;border:dashed #FFFFFF 1px">E-mail</th><td><input type="text" name="email" id="email" /></td></tr> 
 
        <tr><th style="background:#E8C2AA;border:dashed #FFFFFF 1px">帳號申請用途<br/>(請詳填，供審核人員檢核)</th>  

		<td><label><textarea name="usage_note" id="usage_note" cols="45" rows="5"></textarea></label></td> </tr>

	</table>

<p align="center"><label><input type="submit" name="button" id="button" value="送出"></label></p>

</form>

</div>

	

<div id='d2'  class='forms' >

<form name="apply_begincourse_account2" action="apply_begincourse_account_add.php" method="post">

<input type="hidden" name="category" value="2">

<h2>填寫詳細申請資料</h2>
	<table class="t1" width="600" align="center" style="font-size:14px;background:#EFD5BC;border:dashed #FFFFFF thin">
<caption>大專院校
 
            <select id="campus_type"> 
 
                <option value="personal" selected="selected">個人</option> 
 
                <option value="organziation">單位</option> 
 
            </select> 
 
        </caption> 
<tr><th  width="300" class="filed_str" style="background:#E8C2AA;border:dashed #FFFFFF 1px">開課帳號</th> 
        <td><input type="text" name="account" id="account" /></td></tr> 
 
        <tr><th class="filed_str" style="background:#E8C2AA;border:dashed #FFFFFF 1px">密碼</th> 
        <td><input type="password" name="password" id="password" /></td></tr> 
 
        <tr><th class="filed_str" style="background:#E8C2AA;border:dashed #FFFFFF 1px">再次確認密碼</th> 
        <td><input type="password" name="check_password" id="check_password" /></td></tr>       
		                        <tr><th  class="filed_str" style="background:#E8C2AA;border:dashed #FFFFFF 1px">所屬縣市</th><td>
                                                                                    <select  name="city_cd" id="city_cd2" />
                                                                                        <option value="">請選擇</option>
                                                                                        {foreach  from=$citys item=city}
                                                                                        <option value="{$city.city_cd}">{$city.city}</option>
                                                                                        {/foreach}
                                                                                    </select>
                                                                                </td></tr>
                                     <tr><th  class="filed_str" style="background:#E8C2AA;border:dashed #FFFFFF 1px">所屬學校</th><td>
                                                                                    <select  name="school_cd" id="school_cd" />
                                                                                        <option value="">請選擇</option>
                                                                                        
                                                                                    </select>
                                                                                </td></tr>
<tr><th class="filed_str" style="background:#E8C2AA;border:dashed #FFFFFF 1px">申請開課人姓名</th> 
        <td><input type="text" name="org_title" id="org_title" /></td></tr> 
 
        <tr id="tr_undertaker"><th class="filed_str" style="background:#E8C2AA;border:dashed #FFFFFF 1px" >聯絡人</th> 
        <td><label><input type="text" name="undertaker" id="undertaker" /></label></td></tr> 
 
        <tr><th class="filed_str" style="background:#E8C2AA;border:dashed #FFFFFF 1px">職稱</th> 
        <td><input type="text" name="title" id="title" /></td></tr> 
 
        <tr><th class="filed_str" style="background:#E8C2AA;border:dashed #FFFFFF 1px">聯絡電話</th> 
        <td><input type="text" name="tel" id="tel" /></td></tr> 
 
        <tr><th class="filed_str" style="background:#E8C2AA;border:dashed #FFFFFF 1px">E-mail</th> 
        <td><input type="text" name="email" id="email" /></td></tr> 
 
        <tr><th class="filed_str" style="background:#E8C2AA;border:dashed #FFFFFF 1px">帳號申請用途</br>(請詳填，供審核人員檢核)</th> 
  
		<td><label><textarea name="usage_note" id="usage_note" cols="45" rows="5"></textarea></label></td> </tr>

	</table>

<p align="center"><label><input type="submit" name="button" id="button" value="送出"></label></p>

</form>

</div>

    

<div id='d3'  class='forms' style=" width:650px">

<h2>數位機會中心輔導團隊:帳號已核發至各輔導團隊,若有問題請洽該輔導團隊,或與我們連絡。</h2>

</div>

	

</div>





{literal}	

<script language="javascript" type="text/javascript">

$("#sel_category").change(function() {

		var n=$("#sel_category").val();

		$('.forms').hide();

		$('#d'+n).show();

});





//大專院校根據 申請身分~改變表單欄位的title  (注意不要改變 table <tr><td>的格式 否則DOM不match會失效)

$("#campus_type").change(function(){

	var type = $(this).val();

	var form_fields ; 

	if( type == 'personal'){

		form_fields = personal_str ; 	

		//$('#tr_undertaker').hide();

	}

	if( type == 'organziation' ){

		form_fields = organziation_str ; 

		$('#tr_undertaker').show();

	}

		

	$('.filed_str').each(

		function(index){ 

			$(this).html(form_fields[index]);

		} 

		

	);

});
$("#city_cd2").change(function(){
    var value = $(this).val();
    $.get('ajax_stat_school_fetch.php',{"type":"5","city_cd":value},function(data){
{/literal}
         var option = '<option value="-1">請選擇</option>';
{literal}

        for(var i in data)
        {
            if(i != '-1')
            option += "<option value=\""+ i +"\">"+data[i]+"</option>";
        }
        
        $("select[name=school_cd]").html(option);
        
    },'json');
});
</script>

{/literal}		

	

</body>

</html>

