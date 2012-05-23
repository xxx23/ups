<html>
<head>
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/teaching_material/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{$webroot}script/progress.js"></script>

<script type="text/javascript">
{literal}
function export_XHR_text(Content_cd, Export_option){
  if(window.ActiveXObject){
    xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
  }else if(window.XMLHttpRequest){
    xmlHttp = new XMLHttpRequest();
  }
  xmlHttp.open("GET","./export_textbook_action.php?content_cd="+Content_cd+"&export_option="+Export_option,true);
  xmlHttp.send(null);
  alert("程式已經處理您的匯出請求，依您教材的大小有不同的處理時間，稍待片刻回來重新整理本頁即可下載。");
}



{/literal}
</script>
</head>
<body onLoad="closeWait();">
<hr size="1">
<!-- waiting bar-->
<span id="please_wait" style="display:none; background-color:#FFFFFF;">
<div style="cursor:move;text-align:center; width:500px; height:500px;" onMouseDown="init();"  > 
<!--<img src="/images/ajax-loader.gif" /> <br />-->
<img src="{$tpl_path}/images/icon/proceeding.gif" /> <br />
  <span class="imp">處理中請稍後...</span><br />
</div>
</span>
<!-- waiting bar-->
<h1>您所選擇匯出的教材為：<span class="imp">{$content_name}</span></h1></br>
{$test}
<center><img src="{$webroot}images/edu_use_announce.png" border="1" />
<div class="export_content" id="export_content" style="width:500px;">
  <form name="export_this" id="export_this" action="textbook_export_general.php" method="post">
    <table  class="datatable">
      <tr>
        <th colspan="4" scope="col">textbook package </th>
      </tr>
      <tr>
        <td width="20%">匯出時間</td>
        <td width="50%">{$1_export_file_time}</td>
        <td width="20%" align="right">檔案大小</td>
        <td width="10%" align="center">{$1_export_file_size}&nbsp;Bytes</td>
      </tr>
      <tr>
        <td width="20%">download</td>
        <td width="50%"><a href='{$1_export_file_path}'>{$1_export_download_name}</a></td>
        <td width="20%">{if $1_export_exist == 1}
        {/if}</td>
        
        <td width="10%">
        <!--
        {if $1_export_exist == 1}
          <input class="btn" type="submit" name="export_button2" value="重新匯出" onClick="openWait();" />
          <input class="btn" type="button" name="export_button2" value="非同步重新匯出" onClick="export_XHR_text({$content_cd},1);" />
          {else}
          <input class="btn" type="submit" name="export_button2" value="匯出" onClick="openWait();" />
          <input class="btn" type="button" name="export_button2" value="非同步匯出" onClick="export_XHR_text({$content_cd},1);"/>
          {/if}
        -->  
          <input type="hidden" name="export_option" value="1" />
        </td>
        
      </tr>
    </table>
  </form>
</div>
</center>
</body>
</html>
