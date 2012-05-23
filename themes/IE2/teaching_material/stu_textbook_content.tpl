<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>教材頁面</title>
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
<!--<link href="/css/v2/table.css" rel="stylesheet" type="text/css" />-->
<!--<link href="/css/v2/navigation.css" rel="stylesheet" type="text/css" />-->
{literal}
<script language="JavaScript">
//-- 重算iframe-test的寬高 (frame撐不開) 要等到frame載入後才知道寬高
function calcHeight()
{
  //find the height of the internal pages
  if(document.getElementById('test')!=null)
  {
    var the_height=document.getElementById('test').contentWindow.document.body.scrollHeight;
    var the_width=document.getElementById('test').contentWindow.document.body.scrollWidth;
    //var outer_height = document.getElementById('test_container').style.height; 
    //change the height of the iframe
    //alert(outer_height); 
    //alert(the_height+" " + outer_height); 
     if(the_height < 650 ) 
        the_height = 650 ; 
    document.getElementById('test').height= the_height;
    document.getElementById('test').Width = the_width;
    //alert(the_height+"==W"+the_width);
   }
}
</script>

<script type="text/JavaScript">
function tracking(Menu_id,Personal_id,Begin_course_cd)
{
//	alert(Personal_id);
    //alert(Begin_course_cd);
    xmlHttp=GetXmlHttpObject();
    var type = 0;
    if (window.XMLHttpRequest)
        type = 1;

      if (xmlHttp==null)
      {
         alert ("Browser does not support HTTP Request");
         return;
      }

    {/literal}var Frame = {$Frame};{literal}
	
    //等待server傳回給node_id後，才往下執行
    var url = "./ajax/learning_tracking.php?Menu_id="+Menu_id+"&Personal_id="+Personal_id+"&Begin_course_cd="+Begin_course_cd+"&Frame="+Frame;
	xmlHttp.open("GET",url,false);

      xmlHttp.onReadyStateChange = (type == 0)?callBack : callBack();
      xmlHttp.send(null);
      xmlHttp.onReadyStateChange = (type == 0)?callBack : callBack();
      xmlHttp.send(null);
}

function callBack()
{
	if(xmlHttp.readyState == 4){
		if(xmlHttp.status == 200){
			echo_str = xmlHttp.responseText;
            if(echo_str == 0)
            {
                alert("由於您有課程的教材瀏覽視窗尚未關閉\n\n就前往了別門課程\n\n故系統不會記錄該未關閉視窗之閱讀時數");
                parent.window.close(); 
            }

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
{/literal}
</script>
<script type="text/javascript" src="{$tpl_path}/script/default.js"></script>
<script language="javascript" type="text/javascript" src="{$webroot}script/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="./script/tinyMCE.js"></script>

</head>
<body onUnload="tracking({$Menu_id},{$Personal_id},{$Begin_course_cd});" onload="calcHeight();" style="height:100%; margin:0; padding:0">
<!--<h1>檢視課程教材</h1>-->
<p class="address">目前所在位置:
{foreach from = $content item=element}
	{$element} <!--&gt;&gt;-->
{/foreach}
</p>


{if $index_show == 0}
<div id="inner_contentC">
	<table width="100%" border="1" class="datatable">
        <caption>此目錄下的檔案</caption>
    	        <tr>
        	    	<th>檔名 </th>
              		<th>檔案大小 </th>
		            <th>最後修改日期 </th>
            	</tr>
				{foreach from = $content2 item = element name=content2loop}
            	<tr  class="{cycle values=" ,tr2"}">
		{if $element.dir == 0}
              		<td><a href="{$webroot}Teaching_Material/redirect_file.php?file_name={$element.file_name_encode}"><img src="{$tpl_path}/images/icon/download.gif">{$element.content_name}</a> </td>
		{else}
		<td><img src="{$webroot}images/folderopen.gif">{$element.content_name} </td>
		{/if}
              		<td align="center">{$element.file_size} </td>
              		<td align="center">{$element.file_time} </td>
            	</tr>
				{foreachelse}
				此目錄下沒有任何檔案。
				{/foreach}
          </table>
<!--指定到目錄 index.html-->
</div>
{elseif $index_show == 1} 
<div style="width:100%; hieght:100%; border:0; margin:0; padding:0; ">
		  <iframe id="test" style="width:100%;height:680px; overflow-x:scroll;  overflow-y:scroll;"   scrolling="yes" src="{$current_path}/index.html" ></iframe>
		  <!--<script>location.href="{$current_path}/index.html"</script>-->
</div>
          <!--index.htm-->
{elseif $index_show == 2}
            <div  style="width:100%; hieght:100%">
                <iframe id="test"  style="width:100%;height:680px; overflow-x:scroll; overflow-y:scroll;" scrolling="yes" src="{$current_path}/index.htm" ></iframe>
            </div>
        <!--index.swf-->
{elseif $index_show == 3}
            <div  style="width:100%; hieght:100%">
               <iframe id="test" style="width:100%;height:680px; overflow-x:scroll; overflow-y:scroll;" scrolling="yes" src="{$current_path}/index.swf" ></iframe>
            </div>
        <!--指定到檔案-->
{elseif $index_show == 4}
            <div id="test_container"  style="width:100%; hieght:100%">
                <iframe id="test"  style="width:100%;height:680px;  overflow-x:scroll; overflow-y:scroll;" scrolling="yes" src="{$current_path}" ></iframe>
            </div>
         <!--無實際目錄存在-->
{elseif $index_show == 5}
<div  style="width:100%; hieght:100%">
            <font color="red"><br>請進一步選擇子章節來閱讀</font>
</div>
{/if}
<!-- div id="bdPanel" class="builderPanel">
  <iframe id="frmBuilder" name="frmBuilder" frameborder=0 scrolling="no" width="100%" height="100%" src="javascript:void(0)" style="display:none"></iframe>
 </div --> 
</body>
</html>
