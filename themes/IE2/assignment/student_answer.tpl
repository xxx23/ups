<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
  </head>

  <body class="ifr">
    <fieldset>
    <legend><h1>學生答案：</h1></legend>
    {if $isupload == '1'}
    <a href="{$webroot}library/redirect_file.php?file_name={$path}">{$answer}</a>
    {else}
    <!--<textarea cols="50" rows="20">-->{$answer}
    <!--</textarea><br/>-->
    {/if}
      <table class="datatable" style="width:50%;"><tbody>
        <tr>
	  <th>相關檔案</th>
	</tr>
	{foreach from=$file_data item=file}
	<tr class="{cycle values=" ,tr2"}">
	  <td><a href="{$webroot}library/redirect_file.php?file_name={$file.path}" target="_blank">{$file.name}</a></td>
	</tr>
	{/foreach}
      </tbody></table>
      </fieldset>
<p class="al-left"><a href="javascript:history.back();"><img src="{$tpl_path}/images/icon/return.gif" /> 返回線上作業列表</a></p>
  </body>
</html>
