<!--
document.write("<div id='meizzCalendarLayer' name='meizzCalendarLayer' style='position: absolute; z-index: 9999; width: 144px; height: 193px; display: none'>");
document.write('<iframe id="meizzCalendarIframe" scrolling="no" frameborder="0" width="100%" height="100%"></iframe></div>');


var Browser = new Object();
Browser.isMozilla = (typeof document.implementation != 'undefined') && (typeof document.implementation.createDocument != 'undefined') && (typeof HTMLDocument != 'undefined');
Browser.isIE = window.ActiveXObject ? true : false;
Browser.isFirefox = (navigator.userAgent.toLowerCase().indexOf("firefox") != - 1);
Browser.isSafari = (navigator.userAgent.toLowerCase().indexOf("safari") != - 1);
Browser.isOpera = (navigator.userAgent.toLowerCase().indexOf("opera") != - 1);

function writeIframe()
{

	//var strIframe = "<html><head><meta http-equiv='Content-Type' content='text/html; charset=gb2312'><style>"+
	var strIframe = "<html><head><style>"+
		"*{font-size: 12px; font-family: 宋體}"+
		".bg{color: "+ WebCalendar.lightColor +"; cursor: default; background-color: "+ WebCalendar.darkColor +";}"+
		"table#tableMain{ width: 142; height: 180;}"+
		"table#tableWeek td{ color: "+ WebCalendar.lightColor +";}"+
		"table#tableDay  td{ font-weight: bold;}"+
		"td#meizzYearHead, td#meizzYearMonth{color: "+ WebCalendar.wordColor +"}"+
		".out { text-align: center; border-top: 1px solid "+ WebCalendar.DarkBorder +"; border-left: 1px solid "+ WebCalendar.DarkBorder +";"+
		"border-right: 1px solid "+ WebCalendar.lightColor +"; border-bottom: 1px solid "+ WebCalendar.lightColor +";}"+
		".over{ text-align: center; border-top: 1px solid #FFFFFF; border-left: 1px solid #FFFFFF;"+
		"border-bottom: 1px solid "+ WebCalendar.DarkBorder +"; border-right: 1px solid "+ WebCalendar.DarkBorder +"}"+
		"input{ border: 1px solid "+ WebCalendar.darkColor +"; padding-top: 1px; height: 18; cursor: hand;"+
		"       color:"+ WebCalendar.wordColor +"; background-color: "+ WebCalendar.btnBgColor +"}"+
		"</style></head><body onselectstart='return false' style='margin: 0px' oncontextmenu='return false'><form name=meizz>";

	if (WebCalendar.drag){ 
		strIframe += "<scr"+"ipt language=javascript>\n"+
			"var drag=false, cx=0, cy=0, o = parent.WebCalendar.calendar;\n"+
			/*
			   "document.onmousemove=function(evt){"+
			   "if(parent.WebCalendar.drag && drag){if(o.style.left=='')o.style.left=0; if(o.style.top=='')o.style.top=0;"+
			   "o.style.left = parseInt(o.style.left) + window.event.clientX-cx;"+
			   "o.style.top  = parseInt(o.style.top)  + window.event.clientY-cy;}}"+
			 */
			//

			"document.onkeyup=function(){\n"+
			//"   var keyValue=Browser.isIE? evt.keyCode:evt.which;\n"
			//"   alert(keyValue);\n"
			"   switch(window.event.keyCode){\n"+
			"       case 27 : parent.hiddenCalendar(); break;\n"+
			"       case 37 : parent.prevM(); break; \n"+
			"       case 38 : parent.prevY(); break; \n"+
			"       case 39 : parent.nextM(); break; \n"+
			"       case 40 : parent.nextY(); break;\n"+
			"       case 84 : document.forms[0].today.click(); break;\n"+
			"   } window.event.keyCode = 0; window.event.returnValue= false;}\n"+

			"function dragStart(){cx=window.event.clientX; cy=window.event.clientY; drag=true;}</scr"+"ipt>"}

	strIframe += "<select name=tmpYearSelect  onblur='parent.hiddenSelect(this)' style='z-index:1;position:absolute;top:3;left:18;display:none'"+
		" onchange='parent.WebCalendar.thisYear =this.value; parent.hiddenSelect(this); parent.writeCalendar();'></select>"+
		"<select name=tmpMonthSelect onblur='parent.hiddenSelect(this)' style='z-index:1; position:absolute;top:3;left:74;display:none'"+
		" onchange='parent.WebCalendar.thisMonth=this.value; parent.hiddenSelect(this); parent.writeCalendar();'></select>"+

		"<table id=tableMain class=bg border=0 cellspacing=2 cellpadding=0>"+
		"<tr><td width=140 height=19 bgcolor='"+ WebCalendar.lightColor +"'>"+
		"    <table width=140 id=tableHead border=0 cellspacing=1 cellpadding=0><tr align=center>"+
		"    <td width=15 height=19 class=bg title='向前翻 1 月&#13;快速鍵：←' style='cursor: hand' onclick='parent.prevM()'><b>&lt;</b></td>"+
		"    <td width=60 id='meizzYearHead'  title='點擊此處選擇年份' onclick='parent.funYearSelect(parseInt(this.innerHTML, 10))'"+
		"        onmouseover='this.bgColor=parent.WebCalendar.darkColor; this.style.color=parent.WebCalendar.lightColor'"+
		"        onmouseout='this.bgColor=parent.WebCalendar.lightColor; this.style.color=parent.WebCalendar.wordColor'></td>"+
		"    <td width=50 id=meizzYearMonth title='點擊此處選擇月份' onclick='parent.funMonthSelect(parseInt(this.innerHTML, 10))'"+
		"        onmouseover='this.bgColor=parent.WebCalendar.darkColor; this.style.color=parent.WebCalendar.lightColor'"+
		"        onmouseout='this.bgColor=parent.WebCalendar.lightColor; this.style.color=parent.WebCalendar.wordColor'></td>"+
		"    <td width=15 class=bg title='向後翻 1 月&#13;快速鍵：→' onclick='parent.nextM()' style='cursor: hand'><b>&gt;</b></td></tr></table>"+
		"</td></tr><tr><td height=20><table id=tableWeek border=0 width=140 cellpadding=0 cellspacing=0 ";
	if(WebCalendar.drag){strIframe += "onmousedown='dragStart()' onmouseup='drag=false' onmouseout='drag=false'";}
	strIframe += " borderColorLight='"+ WebCalendar.darkColor +"' borderColorDark='"+ WebCalendar.lightColor +"'>"+
		"    <tr align=center><td height=20>日</td><td>一</td><td>二</td><td>三</td><td>四</td><td>五</td><td>六</td></tr></table>"+
		"</td></tr><tr><td valign=top width=140 bgcolor='"+ WebCalendar.lightColor +"'>"+
		"    <table id=tableDay height=120 width=140 border=0 cellspacing=1 cellpadding=0>";
	for(var x=0; x<5; x++){ strIframe += "<tr>";
		for(var y=0; y<7; y++)  strIframe += "<td class=out id='meizzDay"+ (x*7+y) +"'></td>"; strIframe += "</tr>";}
		strIframe += "<tr>";
		for(var x=35; x<39; x++) strIframe += "<td class=out id='meizzDay"+ x +"'></td>";
		strIframe +="<td colspan=3 class=out><input style=' background-color: "+
			WebCalendar.btnBgColor +";cursor: hand; padding-top: 4px; width: 100%; height: 100%; border: 0' onfocus='this.blur()'"+
			" type=button value='&nbsp;清空&nbsp;' onclick='parent.emptying()'></td></tr></table>"+
			"</td></tr><tr><td height=20 width=140 bgcolor='"+ WebCalendar.lightColor +"'>"+
			"    <table border='1' cellpadding=1 cellspacing=0 width=140>"+
			"    <tr><td><input style='width: 19' name=prevYear title='向前翻 1 年&#13;快速鍵：↑' onclick='parent.prevY()' type=button value='&lt;&lt;'"+
			"    onfocus='this.blur()' style='meizz:expression(this.disabled=parent.WebCalendar.thisYear==1000)'><input  style='width: 19' "+
			"    onfocus='this.blur()' name=prevMonth title='向前翻 1 月&#13;快速鍵：←' onclick='parent.prevM()' type=button value='&lt;&nbsp;'>"+
			"    </td><td align=center><input name=today type=button value='今天' onfocus='this.blur()' style='width: 50' title='當前日期&#13;快速鍵：T'"+
			"    onclick=\"parent.returnDate(event,new Date().getDate() +'/'+ (new Date().getMonth() +1) +'/'+ new Date().getFullYear())\">"+
			"    </td><td align=right><input  style='width: 19'  title='向後翻 1 月&#13;快速鍵：→' name=nextMonth onclick='parent.nextM()' type=button value='&nbsp;&gt;'"+
			"    onfocus='this.blur()'><input  style='width: 19'  name=nextYear title='向後翻 1 年&#13;快速鍵：↓' onclick='parent.nextY()' type=button value='&gt;&gt;'"+
			"    onfocus='this.blur()' style='meizz:expression(this.disabled=parent.WebCalendar.thisYear==9999)'></td></tr></table>"+
			"</td></tr><table></form></body></html>";


		with(WebCalendar.iframe2)
		{
			//alert(strIframe);

			document.writeln(strIframe); 

			document.close();
			for(var i=0; i<39; i++)
			{
				//WebCalendar.dayObj[i] = eval("meizzDay"+ i);
				WebCalendar.dayObj[i]=document.getElementById("meizzDay"+i);
				WebCalendar.dayObj[i].onmouseover = dayMouseOver;
				WebCalendar.dayObj[i].onmouseout  = dayMouseOut;
				WebCalendar.dayObj[i].onclick     = returnDate;
			}
		}

}

function TWebCalendar() //初始化日曆的設置
{
	this.regInfo    = "WEB Calendar ver 3.0&#13;作者：meizz(梅花雪疏影橫斜)&#13;網站：http://www.meizz.com/&#13;關閉的快速鍵：[Esc]";
	this.regInfo   += "&#13;&#13;Ver 2.0：walkingpoison(水晶龍)&#13;Ver 1.0：meizz(梅花雪疏影橫斜)";
	this.daysMonth  = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
	this.day        = new Array(39);            //定義日曆展示用的陣列
	this.dayObj     = new Array(39);            //定義日期展示控制項陣列
	this.dateStyle  = null;                     //保存格式化後日期陣列
	this.objExport  = null;                     //日曆回傳的顯示控制項
	this.eventSrc   = null;                     //日曆顯示的觸發控制項
	this.inputDate  = null;                     //轉化外的輸入的日期(d/m/yyyy)
	this.thisYear   = new Date().getFullYear(); //定義年的變數的初始值
	this.thisMonth  = new Date().getMonth()+ 1; //定義月的變數的初始值
	this.thisDay    = new Date().getDate();     //定義日的變數的初始值
	this.today      = this.thisDay +"/"+ this.thisMonth +"/"+ this.thisYear;   //今天(d/m/yyyy)
	//this.iframe2     = window.frames["meizzCalendarIframe"]; //日曆的 iframe 載體
	this.iframe2='document.getElementById("meizzCalendarIframe").contentWindow.document';
	this.calendar   = getObjectById("meizzCalendarLayer");  //日曆的層
	this.dateReg    = "";           //日曆格式驗證的正則式

	this.yearFall   = 50;           //定義年下拉清單的年差值
	this.format2     = "yyyy-mm-dd"; //回傳日期的格式
	this.timeShow   = false;        //是否返回時間
	this.drag       = true;         //是否允許拖動
	this.darkColor  = "#639ECB";    //控制項的暗色
	this.lightColor = "#FFFFFF";    //控制項的亮色
	this.btnBgColor = "#FFFFF5";    //控制項的按鈕背景色
	this.wordColor  = "#666666";    //控制項的文字顏色
	this.wordDark   = "#DCDCDC";    //控制項的暗文字顏色
	this.dayBgColor = "#E0E0E0";    //日期數字背景色
	this.todayColor = "#DE5E50";    //今天在日曆上的標示背景色
	this.DarkBorder = "#D4D0C8";    //日期顯示的立體表達色
}   
var WebCalendar = new TWebCalendar();




function calendar(e) //主調函數
{
	//alert(1);
	// WebCalendar.iframe2=document.getElementById("meizzCalendarIframe");
	//alert(document.getElementById("meizzCalendarLayer"))
	//alert(WebCalendar.iframe2);
	//alert(document.getElementById("meizzCalendarIframe").contentWindow);
	//alert(document.getElementById("meizzCalendarIframe").contentWindow);
	//WebCalendar.iframe2=window.frames["meizzCalendarIframe"];
	WebCalendar.iframe2=document.getElementById("meizzCalendarIframe").contentWindow;
	WebCalendar.calendar=document.getElementById("meizzCalendarLayer");

	//alert(window.frames["meizzCalendarIframe"]);
	/*
	   var event=e||window.event;
	   var ele=e?event.target:event.srcElement;
	   alert(ele);
	 */

	e=Browser.isIE?window.event.srcElement:e.target;

	//var e=evt?e.target:e.srcElement;
	//alert(e);


	//e = window.event.srcElement;

	writeIframe();

	var o = WebCalendar.calendar.style; 
	WebCalendar.eventSrc = e;
	//alert(arguments.length);
	//alert(eval(arguments[1]));
	if (arguments.length == 0 || arguments.length == 1){
		WebCalendar.objExport = e;
	}else{
		if(typeof(arguments[1])=='object'){
			WebCalendar.objExport=arguments[1];
		}else{
			WebCalendar.objExport = document.getElementById(arguments[1]);
		}
	}


	//alert(WebCalendar.iframe2.tableWeek);
	//WebCalendar.iframe2.tableWeek.style.cursor = WebCalendar.drag ? "move" : "default";
	var t = e.offsetTop,  h = e.clientHeight, l = e.offsetLeft, p = e.type;
	while (e = e.offsetParent){t += e.offsetTop; l += e.offsetLeft;}
	o.display = ""; WebCalendar.iframe2.document.body.focus();


	var cw = WebCalendar.calendar.clientWidth, ch = WebCalendar.calendar.clientHeight;
	var dw = document.body.clientWidth, dl = document.body.scrollLeft, dt = document.body.scrollTop;


	if (document.body.clientHeight + dt - t - h >= ch) {

		o.top = ((p=="image")? t + h : t + h + 6)+'px';

	}else {

		o.top  = ((t - dt < ch) ? ((p=="image")? t + h : t + h + 6) : t - ch)+'px';
	}

	if (dw + dl - l >= cw){
		o.left = l+'px'; 
	}else{ 
		o.left = ((dw >= cw) ? dw - cw + dl : dl)+'px';
	}

	if  (!WebCalendar.timeShow) WebCalendar.dateReg = /^(\d{1,4})(-|\/|.)(\d{1,2})\2(\d{1,2})$/;
	else WebCalendar.dateReg = /^(\d{1,4})(-|\/|.)(\d{1,2})\2(\d{1,2}) (\d{1,2}):(\d{1,2}):(\d{1,2})$/;

	try{
		if (WebCalendar.objExport.value.trim() != ""){
			WebCalendar.dateStyle = WebCalendar.objExport.value.trim().match(WebCalendar.dateReg);

			if (WebCalendar.dateStyle == null)
			{
				WebCalendar.thisYear   = new Date().getFullYear();
				WebCalendar.thisMonth  = new Date().getMonth()+ 1;
				WebCalendar.thisDay    = new Date().getDate();
				alert("原文字方塊裡的日期有錯誤！\n可能與你定義的顯示時分秒有衝突！");
				writeCalendar(); return false;
			}
			else
			{
				WebCalendar.thisYear   = parseInt(WebCalendar.dateStyle[1], 10);
				WebCalendar.thisMonth  = parseInt(WebCalendar.dateStyle[3], 10);
				WebCalendar.thisDay    = parseInt(WebCalendar.dateStyle[4], 10);
				WebCalendar.inputDate  = parseInt(WebCalendar.thisDay, 10) +"/"+ parseInt(WebCalendar.thisMonth, 10) +"/"+ 
					parseInt(WebCalendar.thisYear, 10); writeCalendar();
			}
		}  else{

			writeCalendar();
		}
	}  catch(e){writeCalendar();}

}
function funMonthSelect() //月份的下拉清單
{
	var m = isNaN(parseInt(WebCalendar.thisMonth, 10)) ? new Date().getMonth() + 1 : parseInt(WebCalendar.thisMonth);
	var e = WebCalendar.iframe2.document.forms[0].tmpMonthSelect;
	for (var i=1; i<13; i++) e.options.add(new Option(i +"月", i));
	e.style.display = ""; e.value = m; e.focus(); window.status = e.style.top;
}
function funYearSelect() //年份的下拉清單
{
	var n = WebCalendar.yearFall;
	var e = WebCalendar.iframe2.document.forms[0].tmpYearSelect;
	var y = isNaN(parseInt(WebCalendar.thisYear, 10)) ? new Date().getFullYear() : parseInt(WebCalendar.thisYear);
	y = (y <= 1000)? 1000 : ((y >= 9999)? 9999 : y);
	var min = (y - n >= 1000) ? y - n : 1000;
	var max = (y + n <= 9999) ? y + n : 9999;
	min = (max == 9999) ? max-n*2 : min;
	max = (min == 1000) ? min+n*2 : max;
	for (var i=min; i<=max; i++)
	{
		//alert(e.options.length);
		e.options[e.options.length] = new Option(i +"年", i+"", true, true);//e.options.add(new Option(i +"年", i));
	}
	e.style.display = "";
	e.value = y; e.focus();
}
function prevM()  //往前翻月份
{
	WebCalendar.thisDay = 1;
	if (WebCalendar.thisMonth==1)
	{
		WebCalendar.thisYear--;
		WebCalendar.thisMonth=13;
	}
	WebCalendar.thisMonth--; writeCalendar();
}
function nextM()  //往後翻月份
{
	WebCalendar.thisDay = 1;
	if (WebCalendar.thisMonth==12)
	{
		WebCalendar.thisYear++;
		WebCalendar.thisMonth=0;
	}
	WebCalendar.thisMonth++; writeCalendar();
}
function prevY(){WebCalendar.thisDay = 1; WebCalendar.thisYear--; writeCalendar();}//往前翻 Year
function nextY(){WebCalendar.thisDay = 1; WebCalendar.thisYear++; writeCalendar();}//往後翻 Year
function hiddenSelect(e){for(var i=e.options.length; i>-1; i--)e.remove(i); e.style.display="none";}
//function getObjectById(id){ if(document.all) return(eval("document.all."+ id)); return(eval(id)); }
function getObjectById(id){return(document.getElementById(id)); return(eval(id)); }
function hiddenCalendar(){getObjectById("meizzCalendarLayer").style.display = "none";};
function appendZero(n){return(("00"+ n).substr(("00"+ n).length-2));}//日期自動補零程式
String.prototype.trim=function()
{
	return this.replace(/(^\s*)|(\s*$)/g,"");
}
function dayMouseOver()
{
	this.className = "over";
	this.style.backgroundColor = WebCalendar.darkColor;
	if(WebCalendar.day[this.id.substr(8)].split("/")[1] == WebCalendar.thisMonth)
		this.style.color = WebCalendar.lightColor;
}
function dayMouseOut()
{
	this.className = "out"; var d = WebCalendar.day[this.id.substr(8)], a = d.split("/");
	//alert(this.parentNode.innerHTML);
	//this.style.removeAttribute('backgroundColor');
	//alert(this.style.backgroundColor);
	//this.style.setAttribute('backgroundColor','');
	this.style.backgroundColor='';
	if(a[1] == WebCalendar.thisMonth && d != WebCalendar.today)
	{
		if(WebCalendar.dateStyle && a[0] == parseInt(WebCalendar.dateStyle[4], 10))
			this.style.color = WebCalendar.lightColor;
		this.style.color = WebCalendar.wordColor;
	}
}
function writeCalendar() //對日曆顯示的資料的處理常式
{
	var y = WebCalendar.thisYear;
	var m = WebCalendar.thisMonth; 
	var d = WebCalendar.thisDay;
	WebCalendar.daysMonth[1] = (0==y%4 && (y%100!=0 || y%400==0)) ? 29 : 28;
	if (!(y<=9999 && y >= 1000 && parseInt(m, 10)>0 && parseInt(m, 10)<13 && parseInt(d, 10)>0)){
		alert("對不起，你輸入了錯誤的日期！");
		WebCalendar.thisYear   = new Date().getFullYear();
		WebCalendar.thisMonth  = new Date().getMonth()+ 1;
		WebCalendar.thisDay    = new Date().getDate(); }
		y = WebCalendar.thisYear;
		m = WebCalendar.thisMonth;
		d = WebCalendar.thisDay;

		WebCalendar.iframe2.document.getElementById("meizzYearHead").innerHTML  = y +" 年";
		WebCalendar.iframe2.document.getElementById("meizzYearMonth").innerHTML  = parseInt(m, 10) +" 月";
		//WebCalendar.iframe2.meizzYearHead.innerHTML  = y +" 年";
		//WebCalendar.iframe2.meizzYearMonth.innerHTML = parseInt(m, 10) +" 月";

		WebCalendar.daysMonth[1] = (0==y%4 && (y%100!=0 || y%400==0)) ? 29 : 28; //閏年二月為29天
		var w = new Date(y, m-1, 1).getDay();
		var prevDays = m==1  ? WebCalendar.daysMonth[11] : WebCalendar.daysMonth[m-2];
		for(var i=(w-1); i>=0; i--) //這三個 for 迴圈為日曆賦資料來源（陣列 WebCalendar.day）格式是 d/m/yyyy
		{
			WebCalendar.day[i] = prevDays +"/"+ (parseInt(m, 10)-1) +"/"+ y;
			if(m==1) WebCalendar.day[i] = prevDays +"/"+ 12 +"/"+ (parseInt(y, 10)-1);
			prevDays--;
		}
		for(var i=1; i<=WebCalendar.daysMonth[m-1]; i++) WebCalendar.day[i+w-1] = i +"/"+ m +"/"+ y;
		for(var i=1; i<39-w-WebCalendar.daysMonth[m-1]+1; i++)
		{
			WebCalendar.day[WebCalendar.daysMonth[m-1]+w-1+i] = i +"/"+ (parseInt(m, 10)+1) +"/"+ y;
			if(m==12) WebCalendar.day[WebCalendar.daysMonth[m-1]+w-1+i] = i +"/"+ 1 +"/"+ (parseInt(y, 10)+1);
		}

		for(var i=0; i<39; i++)    //這個迴圈是根據源陣列寫到日曆裡顯示
		{
			var a = WebCalendar.day[i].split("/");
			WebCalendar.dayObj[i].innerHTML    = a[0];
			WebCalendar.dayObj[i].title        = a[2] +"-"+ appendZero(a[1]) +"-"+ appendZero(a[0]);
			WebCalendar.dayObj[i].bgColor      = WebCalendar.dayBgColor;
			WebCalendar.dayObj[i].style.color  = WebCalendar.wordColor;
			if ((i<10 && parseInt(WebCalendar.day[i], 10)>20) || (i>27 && parseInt(WebCalendar.day[i], 10)<12))
				WebCalendar.dayObj[i].style.color = WebCalendar.wordDark;
			if (WebCalendar.inputDate==WebCalendar.day[i])    //設置輸入框裡的日期在日曆上的顏色
			{WebCalendar.dayObj[i].bgColor = WebCalendar.darkColor; WebCalendar.dayObj[i].style.color = WebCalendar.lightColor;}
			if (WebCalendar.day[i] == WebCalendar.today)      //設置今天在日曆上反應出來的顏色
			{WebCalendar.dayObj[i].bgColor = WebCalendar.todayColor; WebCalendar.dayObj[i].style.color = WebCalendar.lightColor;}
		}
}
function returnDate() //根據日期格式等返回使用者選定的日期
{
	if(WebCalendar.objExport)
	{
		var returnValue;
		var a;
		//alert(arguments.length);
		if(Browser.isIE){
			if(arguments.length==0){
				a=WebCalendar.day[this.id.substr(8)].split("/");
			}else{
				a=arguments[1].split("/");
			}
		} else{
			if(arguments.length==1){
				a=WebCalendar.day[this.id.substr(8)].split("/");
			}else{
				a=arguments[1].split("/");
			}
		}      
		//var a = (Browser.isIE?arguments.length==0:arguments.length==1) ? WebCalendar.day[this.id.substr(8)].split("/") : Browser.isIE?arguments[0].split("/"):arguments[1].split("/");
		//alert(a);
		var d = WebCalendar.format2.match(/^(\w{4})(-|\/|.|)(\w{1,2})\2(\w{1,2})$/);
		if(d==null){alert("你設定的日期輸出格式不對！\r\n\r\n請重新定義 WebCalendar.format2 ！"); return false;}
		var flag = d[3].length==2 || d[4].length==2; //判斷返回的日期格式是否要補零
		returnValue = flag ? a[2] +d[2]+ appendZero(a[1]) +d[2]+ appendZero(a[0]) : a[2] +d[2]+ a[1] +d[2]+ a[0];
		if(WebCalendar.timeShow)
		{
			var h = new Date().getHours(), m = new Date().getMinutes(), s = new Date().getSeconds();
			returnValue += flag ? " "+ appendZero(h) +":"+ appendZero(m) +":"+ appendZero(s) : " "+  h  +":"+ m +":"+ s;
		}
		WebCalendar.objExport.value = returnValue;
		hiddenCalendar();
	}
}

//清空
function emptying()
{
	if(WebCalendar.objExport)
	{
		WebCalendar.objExport.value = "";
		hiddenCalendar();
	}
}




document.onclick=function(e)
{
	//alert(WebCalendar.eventSrc!= window.event.srcElement);
	//if(WebCalendar.eventSrc !=Browser.isIE?window.event.srcElement:e.target) 
	if(WebCalendar.eventSrc !=(Browser.isIE?window.event.srcElement:e.target)) 
		hiddenCalendar();
}


//-->

