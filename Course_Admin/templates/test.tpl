<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 <script src="../script/prototype.js" type="text/javascript"></script>


<title>TEST</title>
</head>

<body>

<center>
<table width="717" border=1>
	<tr>
		<td>unit_cd</td>
		<td>unit_name</td>
		<td>unit_abbrev</td>
		<td>unit_e_name</td>
		<td>unit_e_abbrev</td>
		<td>unit_state</td>
		<td>department</td>
	</tr>
	
	{foreach from=$Department item=dep}
	<tr>
		<td>{$dep.unit_cd}</td>
		<td>
		{if $dep.under == 1}
			<a href=test.php?cd={$dep.unit_cd}>{$dep.unit_name}</a>
		{else}
			{$dep.unit_name}
		{/if}
		</td>
		<td>{$dep.unit_abbrev}</td>
		<td>{$dep.unit_e_name}</td>
		<td>{$dep.unit_e_abbrev}</td>
		<td>{$dep.unit_state}</td>
		<td>{$dep.department}</td>
	</tr>
	{/foreach}
</table>
<a href=test.php?cd={$pre}>List</a>
</center>

</body>
</html>
