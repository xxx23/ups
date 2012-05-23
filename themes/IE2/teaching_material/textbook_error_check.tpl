<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>教材勘誤頁面</title>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
{literal}
<script type="text/JavaScript">
function confirmError(id,action) 
{
    var url; 
    //action = 1為接受，2是拒絕，3刪除，0暫不處理

    xmlHttp=GetXmlHttpObject();

      if (xmlHttp==null)
      {
         alert ("Browser does not support HTTP Request");
         return;
      }

    if (action == 1) 
    {
        alert("系統將會標記此筆勘誤內容為:已接受");
    }
    else if(action == 2)
    {
        alert("系統將會標記此筆勘誤內容為:未接受"); 
    }
    else if(action == 3)
    {
          alert("系統將會從資料庫中刪除此筆勘誤內容");
    }
    else
    {
        //window.location.reload();
        document.getElementById("check_"+id).style.display="none";
        return;
    }

    url = "./ajax/confirm_error_content.php?id="+id+"&action="+action;
    xmlHttp.open("GET",url,false);
    xmlHttp.send(null);

    window.location.reload();

}
function callBack()
{
    if(xmlHttp.readyState == 4){
        if(xmlHttp.status == 200){
            echo_str = xmlHttp.responseText;
               alert(echo_str);
                //parent.window.close();
        }
    }
}

function GetXmlHttpObject()
{
    if (window.XMLHttpRequest)// code for IE7+, Firefox, Chrome, Opera, Safari
      {
          return new XMLHttpRequest();
      }
    if (window.ActiveXObject)// IE 6 or previous
      {
          return new ActiveXObject("Microsoft.XMLHTTP");
      }
    return null;
}

function checkError(id)
{
    if(document.getElementById("check_"+id).style.display=="none")
        document.getElementById("check_"+id).style.display="";
    else
        document.getElementById("check_"+id).style.display="none";
}


</script>
{/literal}


</head>

<body class="ifr" id="tabA">
<h1>教材勘誤回報與管理頁面</h1>

<p class="intro">
勘誤訊息處理方式：<br />
<span class="imp">接受:</span> 確認此筆勘誤訊息的正確性，並將此訊息展示於該教材之[已確認]勘誤列表中。<br />
<span class="imp">拒絕:</span> 拒絕此筆勘誤訊息的正確性，並將此訊息展示於該教材之[被拒絕]勘誤列表中。<br />
<span class="imp">刪除:</span> 拒絕此筆勘誤訊息，並且於資料庫中刪除。<br />
</p>

<div class="describe">待確認教材勘誤列表 </div><br>

 <div class="tab">
<!--
      <ul id="tabnav">
        <li class="tabA" >待確認教材勘誤列表</li>
      </ul>
-->
      <div class="inner_contentA" id="inner_contentA">
		<legend></legend>
          <table class="datatable" width="100%" border="1">
                <caption>                       以下列表順序依回報時間排序(共{$cnt}筆)              </caption>
                <tr>
						<th width="10%">教材名稱 </th>
                        <th width="10%">製作教師 </th>
                        <th width="20%">章節 </th>
                        <th width="5%">頁數 </th>
						<th width="10%">勘誤者 </th>
						<th width="25%">勘誤內容 </th>
						<th width="15%">回報時間 </th>
                        <th width="5%">處理 </th>

                        
                </tr>
                
				{foreach from = $content2 item = element name=contentloop}
                <tr  class="{cycle values=" ,tr2"}">
                    <td>{$element.name} </td>
                    <td>{$element.te_name} </td>
					<td>{$element.caption}</td>
                    <td>{$element.page}</td>
					<td>{$element.checker}</td>
					<td>{$element.content}</td>
					<td>{$element.reportdate}</td>
                    <td><a href="javascript:checkError({$element.id})"><img src="{$webroot}images/arrow_116.gif"></a></td>

                </tr>

                <tr id="check_{$element.id}" style="display:none;">
                    <td BGCOLOR="#FFCCCC" COLSPAN="8"> 請確認此筆勘誤內容的處理方式:&nbsp;&nbsp;
                     <input type=button value="接受" size="1" onClick="confirmError({$element.id},1);">&nbsp;&nbsp;
                     <input type=button value="拒絕" size="1" onClick="confirmError({$element.id},2);">&nbsp;&nbsp;
                     <input type=button value="刪除" size="1" onClick="confirmError({$element.id},3);">&nbsp;&nbsp;
                    {* <input type=button value="暫不處理" size="1" onClick="confirmError({$element.id},0);"> *}
                    </td>
                </tr>
				{/foreach}
                
          </table>
      </div>
</div>




</body>
</html>
