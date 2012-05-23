<html>
<head>
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/teaching_material/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{$webroot}script/progress.js"></script>
</head>
<body>

<h1>您所選擇的教材為：<span class="imp">{$content_name}</span></h1></br>

<center>{$edu_use_announce}</center>

<table  class="datatable"   width="100%" border="1">
      <tr>
        <th colspan="2" scope="col">textbook package </th>
      </tr>
      <tr>
        <td width="20%">匯出時間</td>
        <td width="60%">{$export_file_time}</td>
      </tr>
      
      <tr>
        <td width="20%">檔案大小</td>
        <td width="60%">{$export_file_size}&nbsp;Bytes</td>
      </tr>

<!-- 1108增，判斷下載格式 -->
       {if isset($export_file_tpye)} 
       <tr>
        <td width="20%">下載格式</td>
        <td width="60%">{$export_file_tpye}</td>
      </tr> 
       {/if}

      <tr>
        <td width="20%">下載</td>
        <td width="60%">
        {if isset($export_download_name)}
            <a href='{$export_file_path}'>{$export_download_name}</a>
        {else}
            很抱歉，該教材格式尚未提供載點。
        {/if}
        </td>
      </tr>
</table>

</body>
</html>
