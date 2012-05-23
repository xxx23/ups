<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>

  <body style="margin:0px; overflow:auto;">
	{foreach from=$menu0 item=hyper}
	{$hyper.menu_name}<br/>
	 {foreach from=$menu1 item=sub}
	 {$sub.menu_link}&nbsp;&nbsp;{$sub.menu_name}<br/>
	 {/foreach}
	{/foreach}
  </body>
</html>
