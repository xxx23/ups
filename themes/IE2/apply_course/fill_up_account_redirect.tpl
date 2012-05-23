{config_load file = 'common.lang'}
{config_load file = 'apply_course/fill_up_account.lang'}
<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<link href="{$tpl_path}/css/content_course.css" rel="stylesheet" type="text/css" />

<link href="{$tpl_path}/css/layout.css" rel="stylesheet" type="text/css" />

<link href="{$tpl_path}/css/font_style_course.css" rel="stylesheet" type="text/css" />


{literal}

<style>

	.forms { margin:0 auto}

	#d1{display:none;color:#122333;}

	#d2{display:none;color:#122333;}

	#d3{display:none;color:#122333;}

</style>

{/literal}

</head>

<body>

<h1>{#fill_up_title#}</h1>

{if $error eq 1}
{#fill_up_error#}
{else}
{#fill_up_thanks#}
{/if}
</body>

</html>

