<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title></title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>


<body>


<div id="header" style="margin: 0;padding: 0;background-color: #FFFFFF;color: #000066;font-family: Georgia, '新細明體'; background-image: url({$imagePath}images/epaperSample1/bg.jpg);background-repeat: repeat-x;background-position: left top;font-size: medium;	height: 1.5em;border-bottom-width: 1px;border-bottom-style: solid;font-size: xx-large;font-weight: bold;color: #000099;text-align: right;padding: 10px;border-bottom-color: #FFFFFF; ">
	<span class="strapline">
		<a name="top" id="top"></a>{$begin_course_name}電子報 - 第{$periodical_cd}期
	</span>
</div>


<div id="nav" style="position: absolute;top: 5em;left: 1em;width: 14em; ">
		<h2 style="font-size: large;font-weight: bold;color: #0033FF;border-bottom-width: 1px;border-bottom-style: solid;border-bottom-color: #0033FF; 	color: #0033FF;background-color: transparent;border-bottom: 1px dotted #cccccc;font-size: x-large;font-weight: bold;">
			相關連結：
		</h2>
		<ul style="list-style: none;margin-left: 1em;padding-left: 0; ">
{section name=counter loop=$releatedLinkNameList}
		  <li style="border-bottom: 1px dotted #B2BCC6;margin-bottom: 0.3em; ">
		  	<a href="{$releatedLinkList[counter]}">{$releatedLinkNameList[counter]}</a>
		</li>
{/section}
	</ul>
</div>


<div id="content" style="margin-left: 18em;margin-right: 2em; ">
	<h1 style="font-size: xx-large;font-weight: bold;color: #CC0000; ">本期主題：</h1>
	<p style="line-height: 1.6em; padding-left: 1.2em; ">{$topic}</p>
	<h1 style="font-size: xx-large;font-weight: bold;color: #CC0000; ">本期新聞：</h1>
	<ul>
{section name=counter loop=$titleList}
      <li><a href="#{counter}">{$titleList[counter]}</a></li>
{/section}
  </ul>
	<p style="line-height: 1.6em; padding-left: 1.2em; ">&nbsp; </p>
{section name=counter loop=$titleList}
	<h2 style="font-size: large;font-weight: bold;color: #0033FF;border-bottom-width: 1px;border-bottom-style: solid;border-bottom-color: #0033FF; ">
		<a name="{counter}" id="{counter}"></a>{$titleList[counter]}
	</h2>
    <p style="line-height: 1.6em; padding-left: 1.2em;">{$contentList[counter]}</p>
    <p class="top" style="line-height: 1.6em; padding-left: 1.2em;color: #666666;text-align: right;margin: 10px; ">
		<a href="#top">top</a>
	</p>
{/section}
	<p class="footer" style="line-height: 1.6em; padding-left: 1.2em;	font-size: small;color: #666666;border-top-width: 1px;border-top-style: dashed;border-top-color: #666666; ">
		版權宣告
	</p>
</div>

</body>
</html>