<html>
<head>
<title>文章內容</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
<link href="../css/tabs.css" rel="stylesheet" type="text/css" />
<link href="../css/content.css" rel="stylesheet" type="text/css" />
<link href="../css/table.css" rel="stylesheet" type="text/css" />
<link href="../css/form.css" rel="stylesheet" type="text/css" />
{literal}
<script language="JavaScript" type="text/javascript">

//把加號取消掉
function plus_over(reply_content_cd)
{
	document.getElementById("plus_"+reply_content_cd).style.display = 'none';
}

function replyLoadContent(reply_content_cd)
{
	var reply_content_table = eval("document.all.reply_content_table_" + reply_content_cd);
	//eval 是 執行

	if(reply_content_table.style.display == 'none')
	{
		//開啟文章內容
		
		reply_content_table.style.display = "block";
		//window.alert("block");	//for test
		
		//增加瀏覽次數
		updateViewNum(reply_content_cd);
		insert_reply_content_cd(reply_content_cd);
		plus_over(reply_content_cd);
	}
	else
	{
		//關閉文章內容
		
		reply_content_table.style.display = "none";
		//window.alert("none");	//for test
	}
}

var xmlHttp = createXMLHttpRequest();
var url = "article_updateViewNum.php";
var cache = new Array();
var url_1 = "updateReplyViewed.php";

//建立XMLHttp物件 判斷瀏覽器是哪一種
function createXMLHttpRequest()
{
	var xmlHttp;

	if(window.ActiveXObject)
	{
		xmlHttp = new ActiveXObject("Microsoft.XMLHTTP"); // FOR IE
	}
	else if(window.XMLHttpRequest)
	{
		xmlHttp = new XMLHttpRequest(); // FOR Firefox
	}
	
	return xmlHttp;
}

function insert_reply_content_cd(reply_content_cd)
{
	cache.push("reply_content_cd="+reply_content_cd); // cache 是一個 array ， index為參數的變數名稱
	xmlHttp.open("POST",url_1, true);
	xmlHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//xmlHttp.onreadystatechange = test;
	xmlHttp.send(cache.shift());
}

function test()
{
	if(xmlHttp.readyState == 4)
	{
		if(xmlHttp.status == 200)
		{
			alert('ok');
		}
	}
}

//增加瀏覽次數Request
function updateViewNum(reply_content_cd)
{	
	cache.push("reply_content_cd=" + reply_content_cd);

	xmlHttp.open("POST", url, true);
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlHttp.onreadystatechange = updateViewNumCallBack;
	xmlHttp.send( cache.shift()); //把reply_content_cd 移出cache
}

//增加瀏覽次數Reponse
function updateViewNumCallBack()
{
	if(xmlHttp.readyState == 4)
	{
		if(xmlHttp.status == 200)
		{
			
			responseXml = xmlHttp.responseXML;
			xmlDoc = responseXml.documentElement;
			
			reply_content_cd = xmlDoc.getElementsByTagName("reply_content_cd")[0].firstChild.data;
			viewNum = xmlDoc.getElementsByTagName("viewNum")[0].firstChild.data;
			
			//alert("viewNum:" + viewNum);	//for test
			
			//document.getElementById('viewNum_' + news_cd).innerHTML = viewNum;
			
			//alert('viewNum_' + news_cd);
		}
	}
}

</script>
{/literal}
</head>
<body>
<h1>觀看文章</h1>
{if $isShowMenu == 1}
<span class="imp">{$message}</span>
<div class="al-left">
<a href="newArticle.php?behavior={$behavior}&action=new&type={$type}"> <img src="{$tpl_path}/images/icon/article_new.gif" alt="發表新文章" /></a> 
<a href="newArticle.php?behavior={$behavior}&action=reply&reply_content_cd={$replyList[$currentReplyArrayNumber].reply_content_cd}&type={$type}"> <img src="{$tpl_path}/images/icon/article_reply.gif" alt="回覆文章" /></a> 
{*<a href="collectArticle.php?behavior={$behavior}&target=oneReply&reply_content_cd={$replyList[$currentReplyArrayNumber].reply_content_cd}"><img src="{$tpl_path}/images/icon/article_collect.gif" alt="收藏此文章" /></a> 
<a href="collectArticle.php?behavior={$behavior}&target=oneTopic&reply_content_cd={$replyList[$currentReplyArrayNumber].reply_content_cd}"><img src="{$tpl_path}/images/icon/article_collect_all.gif" alt="收藏整個主題" /></a>*}</div>
{/if}
<script type="text/javascript">insert_reply_content_cd(1);</script>
<table class="datatable">
  <tr>
    <th colspan="3">主題：{$replyList[$currentReplyArrayNumber].discuss_title}</th>
  </tr>
  <tr>
    <td width="120" rowspan="2" bgcolor="#E3F1FD">
		<div align="center">{if $replyList[$currentReplyArrayNumber].photo != ""} <img src="{$replyList[$currentReplyArrayNumber].photo}" alt="" width="100" height="100" style="border:1px solid black;"><br>
		{/if}
		 <a>{$replyList[$currentReplyArrayNumber].reply_person}</a><br>
         {$replyList[$currentReplyArrayNumber].student_name}<br>        
    	{$replyList[$currentReplyArrayNumber].feedback}
    </div></td>
    <td colspan="2">{$replyList[$currentReplyArrayNumber].content_body}</td>
  </tr>
  
  <tr>
    <td colspan="2">相關檔案： <a href="{$replyList[$currentReplyArrayNumber].file_picture_name_url}">{$replyList[$currentReplyArrayNumber].file_picture_name}</a>( {$replyList[$currentReplyArrayNumber].file_picture_name_size} bytes )</td>
  </tr>
</table>
{if $isBackOn==1}
<p class="al-left">
<a href="{$backLink}"><img src="{$tpl_path}/images/icon/return.gif" />回[上一頁]</a></p>
{/if}
<h1>相關討論文章</h1>
<ul>
  <!--第一篇回覆文章-->
  <li> {if $replyList[0].reply_content_cd == $current_reply_content_cd}
    {$replyList[0].discuss_title} | {$replyList[0].reply_person} | {$replyList[0].d_reply}<br />
    {else} {if $replyList[0].viewed_before == ''} <!-- 表示沒有被讀過 --> <font id="plus_{$replyList[0].reply_content_cd}" color="red"> + </font>{/if} 
    <a href="#reply_content_{$replyList[0].reply_content_cd}" name="reply_content_{$replyList[0].reply_content_cd}" onClick="replyLoadContent({$replyList[0].reply_content_cd});">{$replyList[0].discuss_title}</a> | {$replyList[0].reply_person} | {$replyList[0].d_reply}<br />
    <table id="reply_content_table_{$replyList[0].reply_content_cd}" style="display:none" border="1" cellpadding="0" cellspacing="0" class="datatable">
      <tr>
        <td> 
		{if $isShowMenu == 1}
          <table border="0" width="10">
            <tr>
              <td><a href="newArticle.php?behavior={$behavior}&action=reply&reply_content_cd={$replyList[0].reply_content_cd}"><img src="{$tpl_path}/images/icon/article_reply.gif" alt="回覆文章" /></a></td>
              <td><a href="collectArticle.php?behavior={$behavior}&target=oneReply&reply_content_cd={$replyList[0].reply_content_cd}"><img src="{$tpl_path}/images/icon/article_collect.gif" alt="收藏此文章" /></a></td>
	    </tr>
          </table>
          {/if}
          <table class="datatable">
            <tr>
              <th rowspan="4" width="150"> <p align="center"> 
				  <a href="{$replyList[0].personal_home}" target="_blank">{$replyList[0].reply_person}</a><br>
                  {$replyList[0].student_name}<br>
				  {if $replyList[0].photo != ""}
                  <img src="{$replyList[0].photo}" width="60" height="65" border="0" alt=""><br>
				  {/if}
                  {$replyList[0].feedback} </p></th>
              <th width="100">主題</th>
              <td>{$replyList[0].discuss_title}</td>
            </tr>
            <tr>
              <th>內文</th>
              <td>{$replyList[0].content_body}</td>
            </tr>
            <tr>
              <th>相關檔案</th>
              <td><a href="{$replyList[0].file_picture_name_url}">{$replyList[0].file_picture_name}</a>( {$replyList[0].file_picture_name_size} bytes )</td>
            </tr>
            <!--
				<tr>
				  <th>附加語音檔案</th>
				  <td><object classid="clsid:A809FC66-1FEB-11D5-A00F-00D0B74E04B7" id="AudioBoard1" width="46" height="32" codebase="http://cyberccu.ccu.edu.tw/learn/packages/audioboard.cab#version=2,0,0,2" standby="Loading AudioBoard Components" type="application/x-oleobject">
					  <param name="Server" value="cyberccu.ccu.edu.tw" />
					  <param name="Url" value="discuss/attach/123965724.gsm" />
					  <param name="FilePath" value="c:\_download.gsm" />
					  <param name="SystemMode" value="101" />
					  <param name="Codec" value="1" />
					</object>          </td>
				</tr>
				-->
          </table></td>
      </tr>
    </table>
    {/if} </li>
  <!------------------------------------------------------------>
  <!---------------------回覆的文章列表------------------------->
  {section name=counter loop=$replyList start=1}
  {if $replyList[counter].level == 1}
  <ul>
    <li>
    {else} <!-- {literal} if $replyList[counter].level == 2} --> {/literal}
    <ul>
      <ul>
        <li>
	<!-- {literal}
        {elseif $replyList[counter].level == 3} 
        <ul>
          <ul>
            <ul>
              <li>
              {elseif $replyList[counter].level == 4}
              <ul>
                <ul>
                  <ul>
                    <ul>
                      <li>
                      {elseif $replyList[counter].level == 5}
                      <ul>
                        <ul>
                          <ul>
                            <ul>
                              <ul>
                                <li>
                                {elseif $replyList[counter].level == 6}
                                <ul>
                                  <ul>
                                    <ul>
                                      <ul>
                                        <ul>
                                          <ul>
                                            <li>
                                            {elseif $replyList[counter].level == 7}
                                            <ul>
                                              <ul>
                                                <ul>
                                                  <ul>
                                                    <ul>
                                                      <ul>
                                                        <ul>
                                                          <li>
                                                          {elseif $replyList[counter].level == 8}
                                                          <ul>
                                                            <ul>
                                                              <ul>
                                                                <ul>
                                                                  <ul>
                                                                    <ul>
                                                                      <ul>
                                                                        <ul>
                                                                          <li>
                                                                          {elseif $replyList[counter].level == 9}
                                                                          <ul>
                                                                            <ul>
                                                                              <ul>
                                                                                <ul>
                                                                                  <ul>
                                                                                    <ul>
                                                                                      <ul>
                                                                                        <ul>
                                                                                          <ul>
                                                                                            <li>
                                                                                            {else}
                                                                                            <ul>
                                                                                              <ul>
                                                                                                <ul>
                                                                                                  <ul>
                                                                                                    <ul>
                                                                                                      <ul>
                                                                                                        <ul>
                                                                                                          <ul>
                                                                                                            <ul>
                                                                                                              <ul>
                                                                                                                <li> -->{/literal}{/if}
                                                                                                                  
                                                                                                                  {if $replyList[counter].reply_content_cd == $current_reply_content_cd} 
                                                                                                                  ==>{$replyList[counter].discuss_title} | {$replyList[counter].reply_person} | {$replyList[counter].d_reply}<br>
                                                                                                                  {else} 
														  {if $replyList[counter].viewed_before == ''} <font id="plus_{$replyList[counter].reply_content_cd}" color="red">+</font>{/if}
	                                                            {if $replyList[counter].file_picture_name != null}<img src="images/file.gif" alt="file" />{/if}
													  <a href="#reply_content_{$replyList[counter].reply_content_cd}" name="reply_content_{$replyList[counter].reply_content_cd}" onClick="replyLoadContent({$replyList[counter].reply_content_cd})">{$replyList[counter].discuss_title}</a> | {$replyList[counter].reply_person} | {$replyList[counter].d_reply}<br />
                                                                                                                  <table id="reply_content_table_{$replyList[counter].reply_content_cd}" style="display:none" border="1" cellpadding="0" cellspacing="0" class="w-table">
                                                                                                                    <tr>
                                                                                                                      <td> {if $isShowMenu == 1}
                                                                                                                        <table border="0">
                                                                                                                          <tr>
                                                                                                                            <td><a href="newArticle.php?behavior={$behavior}&action=reply&reply_content_cd={$replyList[counter].reply_content_cd}"><img src="{$tpl_path}/images/icon/article_reply.gif" alt="回覆文章" /></a></td>
                                                                                                                            <td><a href="collectArticle.php?behavior={$behavior}&target=oneReply&reply_content_cd={$replyList[counter].reply_content_cd}"><img src="{$tpl_path}/images/icon/article_collect.gif" alt="收藏此文章" /></a></td>
															    {if $personal_id == $replyList[counter].author_id}
															    	<td><a href="deleteReplyArticle.php?behavior={$behavior}&reply_content_cd={$replyList[counter].reply_content_cd}"><img src="{$tpl_path}/images/icon/delete.gif" alt="刪除此回覆" /></a></td>{/if} 
                                                                                                                        </table>
                                                                                                                        {/if}
                                                                                                                        <table class="datatable">
                                                                                                                          <tr>
                                                                                                                            <th rowspan="4" width="150"> <p align="center"> <a href="{$replyList[counter].personal_home}" target="_blank">{$replyList[counter].reply_person}</a><br>
                                                                                                                                {$replyList[counter].student_name}<br>
																																{if $replyList[counter].photo != ""}
                                                                                                                                <img src="{$replyList[counter].photo}" width="60" height="65" border="0" alt=""><br>
                                                                                                                                {/if}
																																{$replyList[counter].feedback}
                                                                                                                                </div>
                                                                                                                            </th>
                                                                                                                            <th width="80">主題</th>
                                                                                                                            <td width="500">{$replyList[counter].discuss_title}</td>
                                                                                                                          </tr>
                                                                                                                          <tr>
                                                                                                                            <th>內文</th>
                                                                                                                            <td width="500">{$replyList[counter].content_body}</td>
                                                                                                                          </tr>
                                                                                                                          <tr>
                                                                                                                            <th>相關檔案</th>
                                                                                                                            <td><a href="{$replyList[counter].file_picture_name_url}">{$replyList[counter].file_picture_name}</a>( {$replyList[counter].file_picture_name_size} bytes )</td>
                                                                                                                          </tr>
                                                                                                                          <!--
				<tr>
					<th>附加語音檔案</th>
					<td><object classid="clsid:A809FC66-1FEB-11D5-A00F-00D0B74E04B7" id="AudioBoard1" width="46" height="32" codebase="http://cyberccu.ccu.edu.tw/learn/packages/audioboard.cab#version=2,0,0,2" standby="Loading AudioBoard Components" type="application/x-oleobject">
					  <param name="Server" value="cyberccu.ccu.edu.tw" />
					  <param name="Url" value="discuss/attach/123965724.gsm" />
					  <param name="FilePath" value="c:\_download.gsm" />
					  <param name="SystemMode" value="101" />
					  <param name="Codec" value="1" />
					</object>          
					</td>
				</tr>
				-->
                                                                                                                        </table></td>
                                                                                                                    </tr>
                                                                                                                  </table>
                                                                                                                  {/if}		
                                                                                                                  
                                                                                                                  {if $replyList[counter].level == 1} </li>
                                                                                                              </ul>
                                                                                                              {else} <!-- if $replyList[counter].level == 2} -->
                                                                                                              </li>
                                                                                                            </ul>
                                                                                                          </ul>
													  <!-- 
													  {literal}
                                                                                                          {elseif $replyList[counter].level == 3}
                                                                                                          </li>
                                                                                                        </ul>
                                                                                                      </ul>
                                                                                                    </ul> 
                                                                                                    {elseif $replyList[counter].level == 4}
                                                                                                    </li>
                                                                                                  </ul>
                                                                                                </ul>
                                                                                              </ul>
                                                                                            </ul>
                                                                                            {elseif $replyList[counter].level == 5}
                                                                                            </li>
                                                                                          </ul>
                                                                                        </ul>
                                                                                      </ul>
                                                                                    </ul>
                                                                                  </ul>
                                                                                  {elseif $replyList[counter].level == 6}
                                                                                  </li>
                                                                                </ul>
                                                                              </ul>
                                                                            </ul>
                                                                          </ul>
                                                                        </ul>
                                                                      </ul>
                                                                      {elseif $replyList[counter].level == 7}
                                                                      </li>
                                                                    </ul>
                                                                  </ul>
                                                                </ul>
                                                              </ul>
                                                            </ul>
                                                          </ul>
                                                        </ul>
                                                        {elseif $replyList[counter].level == 8}
                                                        </li>
                                                      </ul>
                                                    </ul>
                                                  </ul>
                                                </ul>
                                              </ul>
                                            </ul>
                                          </ul>
                                        </ul>
                                        {elseif $replyList[counter].level == 9}
                                        </li>
                                      </ul>
                                    </ul>
                                  </ul>
                                </ul>
                              </ul>
                            </ul>
                          </ul>
                        </ul>
                      </ul>
                      {else}
                      </li>
                    </ul>
                  </ul>
                </ul>
              </ul>
            </ul>
          </ul>
        </ul>
      </ul>
    </ul>
  </ul> --> {/literal}
  {/if} 
  {/section}
  <!------------------------------------------------------->
</ul>

{if $isShowMenu == 1}
<p class="intro"> 圖示說明：<br />
<img src="{$tpl_path}/images/icon/article_new.gif" />表發表新文章。
<img src="{$tpl_path}/images/icon/article_reply.gif" />表回覆文章。
{*<img src="{$tpl_path}/images/icon/article_collect.gif" />表收藏此篇文章。
<img src="{$tpl_path}/images/icon/article_collect_all.gif" />表收藏整個主題。*}
</p>
{/if}
</body>
</html>
