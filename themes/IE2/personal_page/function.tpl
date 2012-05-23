<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>

  <body style="text-align:left;">
    <form method="GET" action="function.php">
    <table border="1">
      {foreach from=$level_0 item=fun_0}
      <tr style="text-align:left;">
        <th colspan="3">
	<input type="checkbox" name="menu_0[]" value="{$fun_0.menu_id}" {if $fun_0.checked == 1}checked{/if}/>
	{$fun_0.menu_name}</th>
      </tr>
      {foreach from=$fun_0.next item=fun_1}
      <tr>
        <td style="width:20%;">&nbsp;</td>
	<td colspan="2">
	<input type="checkbox" name="menu_{$fun_0.menu_id}[]" value="{$fun_1.menu_id}" {if $fun_1.checked == 1}checked{/if}/>
	{$fun_1.menu_name}</td>
      </tr>
      {foreach from=$fun_1.next item=fun_2}
      <tr>
        <td colspan="2" style="width:40%;">&nbsp;</td>
	<td>
	<input type="checkbox" name="menu_{$fun_1.menu_id}[]" value="{$fun_2.menu_id}" {if $fun_2.checked == 1}checked{/if}/>
	{$fun_2.menu_name}</td>
      </tr>
      {/foreach}
      {/foreach}
      {/foreach}
    </table>
    <input type="submit" value="確定"/>&nbsp;&nbsp;<input type="reset" value="清除"/>
    </form>
  </body>
</html>
