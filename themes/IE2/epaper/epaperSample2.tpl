<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>

<body style="margin: 0;	padding: 0;	background-color: #F5F5ED;	color: #000000;	font-family: Geneva, Arial, Helvetica, sans-serif;	background-image: url({$imagePath}images/epaperSample2/bg.jpg);	background-repeat: repeat-y;	background-position: left top;	font-size: 10pt;">

<div id="header" style="height: 120px;	background-color: #F5F5ED;	background-image:url({$imagePath}images/epaperSample2/title.jpg);	background-repeat: no-repeat;	background-position: left top;	margin: 0px;	padding: 0px;	width: 100%;	line-height: 95px;	text-indent: 580px;	letter-spacing: 0.2em;	word-spacing: 15px;">

<span class="number"><a name="top" id="top"></a>{$begin_course_name}電子報 ｜ 第{$periodical_cd}期</span></div>


<div id="nav" style="position: absolute;	top: 120px;	left: 0px;	width: 266px;	background-color: #F5F5ED;	background-image: url({$imagePath}images/epaperSample2/nav_bg.jpg);	background-repeat: repeat-y;	background-position: left top;	margin: 0px;	padding: 0px;	line-height: 45px;">
  <ul style="	list-style: none;	margin: 0px;	padding-top: 0px;	padding-right: 0px;	padding-bottom: 0px;	padding-left: 80px;	line-height: 45px; 	list-style-image: url({$imagePath}images/epaperSample2/li_pic.jpg);	line-height: 1.5em;">
{section name=counter loop=$releatedLinkNameList}
		  <li style="margin: 0px;	padding: 0px;	list-style-image: none;	list-style-type: none;">
		  	<a href="{$releatedLinkList[counter]}" style="text-decoration: none;	color: #FFFFFF;">{$releatedLinkNameList[counter]}</a>
		</li>
{/section}	
  </ul>
</div>


<div id="content" style="width: 530px;	padding-left: 310px;	margin: 0px;	padding-top: 0px;	padding-right: 0px;	padding-bottom: 0px;">
  <p style="padding-left: 1.2em;">{$topic}</p>
  
	<img src="{$imagePath}images/epaperSample2/news.jpg" width="177" height="41" />
	<ul style="	list-style-image: url({$imagePath}images/epaperSample2/li_pic.jpg);	line-height: 1.5em;">
{section name=counter loop=$titleList}
	  <li><a href="#{counter}">{$titleList[counter]}</a></li>
{/section}
  </ul>
  
	<p style="padding-left: 1.2em;">&nbsp; </p>

{section name=counter loop=$titleList}
	<h2 style="	color: #CC0000;	background-image: url({$imagePath}images/epaperSample2/h2_bg.jpg);	font-size: 10pt;	background-color: #FFFFFF;	background-repeat: no-repeat;	background-position: left center;	line-height: 30px;	font-weight: normal;	text-indent: 20px;">
		<a name="1" id="1"></a>{$titleList[counter]}
	</h2>
    <p style="padding-left: 1.2em;">{$contentList[counter]}</p>
    <p class="top" style="padding-left: 1.2em;	color: #666666;	text-align: right;	margin: 10px;">
		<a href="#top">top</a>
	</p>
{/section}	
</div>



<div class="footer" style="color: #666666;	bottom: 0px;	background-color: #EDEDE3;	background-image: url({$imagePath}images/epaperSample2/footer_img.jpg);	background-repeat: no-repeat;	background-position: left top;	top: 0px;	padding-left: 380px;	margin: 0px;	padding-top: 15px;	padding-right: 0px;	padding-bottom: 0px;">
版權宣告
</div>


</body>
</html>