<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>數位學習平台</title>
<script language="JavaScript">
<!--
-->
</script>
</head>

<body background="{$imagePath}bg.gif">

<div align="center">
<table>
<tr>
	{if $isLeft == 1}
	<td align="left" valign="top">
<!-------------------------------------start file left----------------------------------------------->
		{include_php file="$left"}
<!-------------------------------------end file left----------------------------------------------->
	</td>
	{/if}
	{if $isMiddle == 1}
	<td align="left" valign="top">
<!--------------------------------------start file Middle---------------------------------------------->
		{include_php file="$middle"}
<!--------------------------------------end file Middle---------------------------------------------->
	</td>
	{/if}
	{if $isRight == 1}
	<td align="left" valign="top">
<!--------------------------------------start file Right---------------------------------------------->
		{include_php file="$right"}
<!--------------------------------------end file Right---------------------------------------------->
	</td>
	{/if}
</tr>
</table>
</div>

</body>

</html>
