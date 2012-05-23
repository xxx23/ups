<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="refresh" content="300;./online.php">
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{$tpl_path}/css/facebox/MooDialog.css" type="text/css" media="screen" charset="utf-8" />
<script src="../script/TextboxList/mootools-1.2.4-core.js" type="text/javascript" charset="utf-8"></script>		
<script src="../script/TextboxList/Overlay.js" type="text/javascript" charset="utf-8"></script>		
<script src="../script/TextboxList/MooDialog.js" type="text/javascript" charset="utf-8"></script>		
<script src="../script/TextboxList/MooDialog.Confirm.js" type="text/javascript" charset="utf-8"></script>		
<script src="../script/TextboxList/MooDialog.Alert.js" type="text/javascript" charset="utf-8"></script>		

<!--<script src="../script/prototype.js" type="text/javascript" ></script>-->

<script language="javascript">
<!--
{$HAVE}alert("您有訊息傳送進來。");
{$CLOSE}self.close();
    function includjs(){ldelim}alert("");{rdelim}
-->
</script>
<title>線上即時訊息</title>
</head>

<body class="ifr">
{if $action == "validated"} 
<script language="javascript" defer="defer">
<!--
window.addEvent('domready',function(){ldelim}
{foreach from=$validated_name item=people}	
    new MooDialog.Confirm(
'您確定要加{$people.name}為好友嗎？'
,function(){ldelim}
                        new Request({ldelim}url: 'messager.php?action=validated_id&id='+{$people.id}, method: 'get', onSuccess: function(responseText, responseXML) {ldelim}
                            new MooDialog.Alert('謝謝，{$people.name}現在是您的朋友了');{rdelim}{rdelim}).send();
    {rdelim},function(){ldelim}
new MooDialog.Alert('謝謝，別人不知道您拒絕了');
    {rdelim});
{/foreach}	
{rdelim});
-->
</script>
{/if } 
{if $action == "validated"} 
{foreach from=$validated_name item=people}	
您確定要加{$people.name}為好友嗎？
<a href="#" id="id1_{$people.id}" onclick="includjs2('{$people.id}','{$people.name}','id1_{$people.id}')">是</a>
<a href="#" id="id0_{$people.id}" onclick="includjs()">否</a>
<script language="javascript" defer="defer">
$('id1_{$people.id}').addEvent('click',function(e){ldelim}
    e.stop();
    new Request({ldelim}url: 'messager.php?action=validated_id&id='+{$people.id}, method: 'get', onSuccess: function(responseText, responseXML) {ldelim}
      new MooDialog.Alert('謝謝，{$people.name}現在是您的朋友了');{rdelim}{rdelim}).send();
  {rdelim});
$('id0_{$people.id}').addEvent('click',function(e){ldelim}
    new MooDialog.Alert('謝謝，別人不知道您拒絕了');
  {rdelim});

</script>
<br />
{/foreach}
{/if}
{if $action == "receive"} 
<table class="datatable">
<tr>
	<th>
	{$receive}
	</th>
</tr>
</table>
{/if } 
<form action='./messager.php?action=doSend' method = 'post' >
<input type="hidden" name='receiver_pid' value="{$receiver_pid}" />
{foreach from=$multi item=m}
<input type="hidden" name='multi[]' value="{$m}" />
{/foreach}
<table class="datatable">
<tr>
	<th><b> {$receiver_name}  </b></th>
</tr>
{if $action != "receive" && $action != "validated"} 
<tr>
	<td>
	<input type='submit' value=傳送 name="submit" />
	<input type='reset' value=清除 name="reset" />
	<input type='button' value=關閉 onClick="self.close();" />
	</td>
</tr>
<tr>
	<td>
	<textarea name='message' rows=10 cols=35 >{$message}</textarea>
	</td>
</tr>
{/if}
</table>
</form>

</body>
</html>
