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
  xmlHttp.open("GET","./export_textbook_asyn.php?content_cd="+Content_cd+"&export_option="+Export_option,true);
  xmlHttp.send(null);
  alert("程式已經處理您的匯出請求，依您教材的大小有不同的處理時間，稍待片刻回來重新整理本頁即可下載。");
}

function callBack(){
  if(xmlHttp.readyState == 4){
    if(xmlHttp.status == 200){
       alert("備份教材已經刪除");  
       window.location.href=self.location.href;
    }
}
																																										}
function delfile(Content_cd, Del_option){

var answer = confirm("是否確定要刪除備份教材?")

if(answer){
    if(window.ActiveXObject){
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP"); 
    }else if(window.XMLHttpRequest){
        xmlHttp = new XMLHttpRequest();
    } 
    xmlHttp.onreadystatechange = function(){
       callBack();
    };
    
    xmlHttp.open("GET","./export_textbook_action.php?content_cd="+Content_cd+"&del_option="+Del_option,false);
    xmlHttp.send(null);
  }
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
<strong>點選<span class="imp">非同步匯出</span>後，後端程式會自動執行匯出動作，教師可以進行其他動作，片刻後回到本頁即可進行下載動作。<br></strong>
若匯出的教材檔案太大時，請使用FTP軟體連上系統FTP的<span class="imp">export_data</span>資料夾，再進行下載。<br>
{$test}
<div class="export_content" id="export_content" style="width:450px">
  <form name="export_this" id="export_this" action="export_textbook.php" method="post">
    <table  class="datatable">
      <tr>
        <th colspan="4" scope="col">textbook package </th>
      </tr>
      <tr>
        <td width="20%">匯出時間</td>
        <td width="60%">{$1_export_file_time}</td>
        <td width="10%">檔案大小</td>
        <td width="10%">{$1_export_file_size}&nbsp;Bytes</td>
      </tr>
      <tr>
        <td width="20%">download</td>
        <td width="60%"><a href='{$1_export_file_path}'>{$1_export_download_name}</a></td>
        <td width="10%">{if $1_export_exist == 1}
<input class="btn" type="button" name="del_export_file" value="刪除檔案" onClick="delfile({$content_cd},1)"/>{/if}</td>
        <td width="10%">{if $1_export_exist == 1}
          <input class="btn" type="submit" name="export_button2" value="重新匯出" onClick="openWait();" />
          <input class="btn" type="button" name="export_button2" value="非同步重新匯出" onClick="export_XHR_text({$content_cd},1);" />
          {else}
          <input class="btn" type="submit" name="export_button2" value="匯出" onClick="openWait();" />
          <input class="btn" type="button" name="export_button2" value="非同步匯出" onClick="export_XHR_text({$content_cd},1);"/>
          {/if}
          <input type="hidden" name="export_option" value="1" />
        </td>
      </tr>
    </table>
  </form>
  <form name="export_scorm12" id="export_scorm12" action="export_textbook.php" method="post">
    <table class="datatable">
      <tr>
        <th colspan="4" scope="col">SCORM v1.2 package </th>
      </tr>
      <tr>
        <td width="20%">匯出時間</td>
        <td width="60%">{$2_export_file_time}</td>
        <td width="10%">檔案大小</td>
        <td width="10%">{$2_export_file_size}&nbsp;Bytes</td>
      </tr>
      <tr>
        <td width="20%">download</td>
        <td width="60%"><a href='{$2_export_file_path}'>{$2_export_download_name}</a></td>
        <td width="10%">{if $2_export_exist == 1}
<input class="btn" type="button" name="del_export_file" value="刪除檔案" onClick="delfile({$content_cd},2)"/>{/if}</td>
        <td width="10%"> {if $2_export_exist == 1}
          <input class="btn" type="submit" name="export_button3" value="重新匯出" onClick="openWait();" />
          <input class="btn" type="button" name="export_button3" value="非同步重新匯出" onClick="export_XHR_text({$content_cd},2);"/>
          {else}
          <input class="btn" type="submit" name="export_button3" value="匯出" onClick="openWait();" />
          <input class="btn" type="button" name="export_button3" value="非同步匯出" onClick="export_XHR_text({$content_cd},2);"/>
          {/if}
          <input type="hidden" name="export_option" value="2" /></td>
      </tr>
    </table>
  </form>
  <form name="export_scorm13" id="export_scorm13" action="export_textbook.php" method="post">
    <table class="datatable">
      <tr>
        <th colspan="4" scope="col">SCORM 2004 package </th>
      </tr>
      <tr>
        <td width="20%">匯出時間</td>
        <td width="60%">{$3_export_file_time}</td>
        <td width="10%">檔案大小</td>
        <td width="10%">{$3_export_file_size}&nbsp;Bytes</td>
      </tr>
      <tr>
        <td width="20%">download</td>
        <td width="60%"><a href='{$3_export_file_path}'>{$3_export_download_name}</a></td>
        <td width="10%">{if $3_export_exist == 1}
<input class="btn" type="button" name="del_export_file" value="刪除檔案" onClick="delfile({$content_cd},3)"/>{/if}</td>
        <td width="10%"> {if $3_export_exist == 1} 
          <input class="btn" type="submit" name="export_button" value="重新匯出" onClick="openWait();" />
          <input class="btn" type="button" name="export_button" value="非同步重新匯出" onClick="export_XHR_text({$content_cd},3);" />
          {else}
          <input class="btn" type="submit" name="export_button" value="匯出" onClick="openWait();" />
          <input class="btn" type="button" name="export_button" value="非同步匯出" onClick="export_XHR_text({$content_cd},3);" />
          {/if}
          <input type="hidden" name="export_option" value="3" /></td>
      </tr>
    </table>
  </form>
</div>
</body>
</html>
