{config_load file='common.lang'}
{config_load file='footer.lang'}



<hr/> {#copyright#}｜{#best_resolution#}｜
<!--先把語系選單隱藏起來,因為沒用到
<span id="lang_choose">
	<select id="setting_lang" onchange="set_lang()">
		<option value="zh_tw" {if $lang=='zh_tw'}selected{/if}>{#chinese#}</option>
		<option value="en" 	{if $lang=='en'}selected{/if}>{#english#}</option>
	</select>
</span>
-->

<br/>

{#any_problem#}｜ {#contact#} 
{literal}<script language="JavaScript">
function set_lang(){//切換語言
	lang = $('#setting_lang').val(); 
	$.post("ajax_setting_lang.php", {lang:lang}, 
		function (data){
			location = location ; //重新整理
		}
	)
}
</script>{/literal}
