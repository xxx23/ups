{config_load file = 'common.lang'}
{config_load file = 'apply_course/fill_up_account.lang'}
<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<link href="{$tpl_path}/css/content_course.css" rel="stylesheet" type="text/css" />

<link href="{$tpl_path}/css/layout.css" rel="stylesheet" type="text/css" />

<link href="{$tpl_path}/css/font_style_course.css" rel="stylesheet" type="text/css" />

<script src="{$webroot}script/jquery-1.3.2.min.js" type="text/javascript"></script>



<title></title>



{literal}





<style>

	.forms { margin:0 auto}

</style>

{/literal}

</head>

<body>

<h1>{#fill_up_title#}</h1>

{#fill_up_description#}
{if $category eq 1}
<div id='d1'  class='forms'>

<form name="apply_begincourse_account1" action="fill_up_account.php?action=updateData" method="post">

<input type="hidden" name="category" value="1">

	<table class="t1" width="600" align="center" style="font-size:14px;background:#EFD5BC;border:dashed #FFFFFF thin">

		<caption>{#county_gov#}</caption>


        
        <tr><th style="background:#E8C2AA;border:dashed #FFFFFF 1px">{#city#}</th><td>
                <select  name="city_cd" id="city_cd" />
                <option value="">{#select#}</option>
                {foreach  from=$citys item=city}
                <option value="{$city.city_cd}">{$city.name}</option>
                {/foreach}
                </select>
            </td></tr>

	</table>

<p align="center"><label><input type="submit" name="button" id="button" value="{#submit#}"></label></p>

</form>

</div>
{elseif $category eq 2}
	
<div id='d2'  class='forms' >

<form name="apply_begincourse_account2" action="fill_up_account.php?action=updateData" method="post">

<input type="hidden" name="category" value="2">


	<table class="t1" width="600" align="center" style="font-size:14px;background:#EFD5BC;border:dashed #FFFFFF thin">

         <tr><th  class="filed_str" style="background:#E8C2AA;border:dashed #FFFFFF 1px">{#city#}</th><td>
                                                        <select  name="city_cd" id="city_cd2" />
                                                            <option value="">{#select#}</option>
                                                            {foreach  from=$citys item=city}
                                                            <option value="{$city.city_cd}">{$city.name}</option>
                                                            {/foreach}
                                                        </select>
                                                    </td></tr>
         <tr><th  class="filed_str" style="background:#E8C2AA;border:dashed #FFFFFF 1px">{#school#}</th><td>
                                                        <select  name="school_cd" id="school_cd" />
                                                            <option value="">{#select#}</option>
                                                            
                                                        </select>
                                                    </td></tr>

	</table>

<p align="center"><label><input type="submit" name="button" id="button" value="{#submit#}"></label></p>

</form>

</div>
<script type="text/javascript">
{literal}
$("#city_cd2").change(function(){
    var value = $(this).val();
    $.get('ajax_stat_school_fetch.php',{"type":"5","city_cd":value},function(data){
{/literal}
         var option = '<option value="-1">{#select#}</option>';
{literal}

        for(var i in data)
        {
            if(i != '-1')
            option += "<option value=\""+ i +"\">"+data[i]+"</option>";
        }
        
        $("select[name=school_cd]").html(option);
        
    },'json');
});

{/literal}
</script>
{/if}
	

</body>

</html>

