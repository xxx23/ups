
<html>
<head>

<link rel="SHORTCUT ICON" href="http://www.sis-kj.com/images/ina.gif" type="image"></head>
<html><head><title>Hacked By Gmpb30</title>
<script language="JavaScript">
var numraindrops="150";
var speed="5";
var rainsize="2";
var wind="left";
var genxgallery="";

function tb5_makeArray(n){ this.length = n; return this.length;
}
tb5_messages = new tb5_makeArray(2);
tb5_messages[0] = "[+]Hacked By Newbie[+]";
tb5_messages[1] = "[+]RAVAZ CyberTeam[+]";
tb5_rptType = 'infinite';
tb5_rptNbr = 10;
tb5_speed = 50;
tb5_delay = 2000;
var tb5_counter=1;
var tb5_currMsg=0;
var tb5_stsmsg="";
function tb5_shuffle(arr){
var k;
for (i=0; i<arr.length; i++){ k = Math.round(Math.random() * (arr.length - i - 1)) + i; temp = arr[i];arr[i]=arr[k];arr[k]=temp;
}
return arr;
}
tb5_arr = new tb5_makeArray(tb5_messages[tb5_currMsg].length);
tb5_sts = new tb5_makeArray(tb5_messages[tb5_currMsg].length);
for (var i=0; i<tb5_messages[tb5_currMsg].length; i++){ tb5_arr[i] = i; tb5_sts[i] = "_";
}
tb5_arr = tb5_shuffle(tb5_arr);
function tb5_init(n){
var k;
if (n == tb5_arr.length){ if (tb5_currMsg == tb5_messages.length-1){ if ((tb5_rptType == 'finite') && (tb5_counter==tb5_rptNbr)){ clearTimeout(tb5_timerID); return; } tb5_counter++; tb5_currMsg=0; } else{ tb5_currMsg++; } n=0; tb5_arr = new tb5_makeArray(tb5_messages[tb5_currMsg].length); tb5_sts = new tb5_makeArray(tb5_messages[tb5_currMsg].length); for (var i=0; i<tb5_messages[tb5_currMsg].length; i++){ tb5_arr[i] = i; tb5_sts[i] = "_"; } tb5_arr = tb5_shuffle(tb5_arr); tb5_sp=tb5_delay;
}
else{ tb5_sp=tb5_speed; k = tb5_arr[n]; tb5_sts[k] = tb5_messages[tb5_currMsg].charAt(k); tb5_stsmsg = ""; for (var i=0; i<tb5_sts.length; i++) tb5_stsmsg += tb5_sts[i]; document.title = tb5_stsmsg; n++; } tb5_timerID = setTimeout("tb5_init("+n+")", tb5_sp);
}
function tb5_randomizetitle(){ tb5_init(0);
}
tb5_randomizetitle();

</script>

<center><img src="http://sphotos-b.ak.fbcdn.net/hphotos-ak-ash3/156805_375823572530429_400165522_n.jpg" height="500" width="900"></center>


  <<body style="background-color:#000000;background> <br><br><!--by Antonio hacker Sakit Hati Feat xLonz-->
</body></html><br>
<script language="JavaScript1.2">


<div align="center"><table border="0" width="70%"><tr><td>

<h1><font face="Poor Richard"><center><SCRIPT>



farbbibliothek = new Array();



farbbibliothek[0] = new Array("#FF0000","#FF1100","#FF2200","#FF3300","#FF4400","#FF5500","#FF6600","#FF7700","#FF8800","#FF9900","#FFaa00","#FFbb00","#FFcc00","#FFdd00","#FFee00","#FFff00","#FFee00","#FFdd00","#FFcc00","#FFbb00","#FFaa00","#FF9900","#FF8800","#FF7700","#FF6600","#FF5500","#FF4400","#FF3300","#FF2200","#FF1100");



farbbibliothek[1] = new Array("#FF0000","#FFFFFF","#FFFFFF","#FF0000");



farbbibliothek[2] = new Array("#FFFFFF","#FF0000","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF");



farbbibliothek[3] = new Array("#FF0000","#FF4000","#FF8000","#FFC000","#FFFF00","#C0FF00","#80FF00","#40FF00","#00FF00","#00FF40","#00FF80","#00FFC0","#00FFFF","#00C0FF","#0080FF","#0040FF","#0000FF","#4000FF","#8000FF","#C000FF","#FF00FF","#FF00C0","#FF0080","#FF0040");



farbbibliothek[4] = new Array("#FF0000","#EE0000","#DD0000","#CC0000","#BB0000","#AA0000","#990000","#880000","#770000","#660000","#550000","#440000","#330000","#220000","#110000","#000000","#110000","#220000","#330000","#440000","#550000","#660000","#770000","#880000","#990000","#AA0000","#BB0000","#CC0000","#DD0000","#EE0000");


farbbibliothek[5] = new Array("#FF0000","#FF0000","#FF0000","#FFFFFF","#FFFFFF","#FFFFFF");


farbbibliothek[6] = new Array("#FF0000","#FDF5E6");



farben = farbbibliothek[4];



function farbschrift()



{



for(var i=0 ; i<Buchstabe.length; i++)



{



document.all["a"+i].style.color=farben[i];



}



farbverlauf();



}



function string2array(text)



{



Buchstabe = new Array();



while(farben.length<text.length)



{



farben = farben.concat(farben);



}



k=0;



while(k<=text.length)



{



Buchstabe[k] = text.charAt(k);



k++;



}



}



function divserzeugen()



{



for(var i=0 ; i<Buchstabe.length; i++)



{



document.write("<span id='a"+i+"' class='a"+i+"'>"+Buchstabe[i] + "</span>");



}



farbschrift();



}



var a=1;



function farbverlauf()



{



for(var i=0 ; i<farben.length; i++)



{



farben[i-1]=farben[i];



}



farben[farben.length-1]=farben[-1];







setTimeout("farbschrift()",30);



}



//



var farbsatz=1;



function farbtauscher()



{



farben = farbbibliothek[farbsatz];



while(farben.length<text.length)



{



farben = farben.concat(farben);



}



farbsatz=Math.floor(Math.random()*(farbbibliothek.length-0.0001));



}



setInterval("farbtauscher()",10000);



text ="HACKED BY RAVAZ'CyberTeam The Newbie";//h



string2array(text);



divserzeugen();



//document.write(text);
</SCRIPT></center></h1></font>

<object data="http://flash-mp3-player.net/medias/player_mp3.swf" width="0" height="0"

type="application/x-shockwave-flash"><param value="#ffffff" name="bgcolor" /><param

value="mp3=&amp;loop=1&amp;autoplay=1&amp;volume=125"

name="FlashVars" /></object><object data="http://flash-mp3-player.net/medias/player_mp3.swf" width="0" height="0"

type="application/x-shockwave-flash"><param value="#ffffff" name="bgcolor" /><param

value="mp3=http://cdn.x.indowebster.com/embed-v5/r4o3z5a4s4y5g4j4j4a2d4j2e4s5h5x5n454c474x5e433w5p4l5r5t5z54424h4j444b413c4a4e214a2x5l5n4v4k5p434e444p373g284d4n3l2a2m5n5t5a474w5p4r5n5t5e5s5j5i223p3h4u2x2s584n5p2l57423k454w21374v2q5l48424k514e4p2d4l554w2u2u5n494q3z3n3l5n5k494e5k4p4i4x554o554s5h5i4e4p353e2l4p294m4a4j554k5s2x2r5446423a4c4i4u5i544h534r5x213m5p2w2p2s5k484a2y3q3p4y4v5c4e233a216i4a4i5v5n3u4.mp3';
&amp;loop=1&amp;autoplay=1&amp;volume=125" name="FlashVars"

/></object></center>>
/></object></center>>
<br>
<br>
<b><font color="green">Thengkyu To :</font></b><marquee behavior="scroll"><center><b><font color="green"> [Ravaz'CyberTeam] [N0ny_J3p4ng] [IFC INDONESIA FIGHTER CYBER] [xLOnz 23] [HczN_OSerror09] </font></b></center></marquee>

  <embed src="http://www.indowebster.com/templates/object/mediaplayer.swf" width="0" height="0"


wmode="\'transparent\'"



FlashVars="file=http://www58.indowebster.com/ejtiirh1xsfmlg1t6ysz2rqzmij91tdk.mp3&amp;frontcolor=0xffffff&amp;backcolor=0xe6e6dc&amp;ligh



tcolor=0xffffff&amp;logo=http://www.indowebster.com/images/idws.png&amp;autostart=true&amp;usefullscreen=false&amp;showeq=false"



width='0' height='0' type='application/x-shockwave-flash' pluginspage='http://www.macromedia.com/go/getflashplayer'



menu='false' allowfullscreen='false' scale='noborder' quality='high'></embed>





<EMBED SRC="http://divine-music.info/musicfiles/03 Y'all Want a Single.swf" AUTOSTART="TRUE" LOOP="TRUE" WIDTH="1" HEIGHT="1" ALIGN="CENTER"></EMBED>

<script language="javascript">
nd_mode="bomb";
nd_dest="massive";
nd_control="on";
nd_sound="on";
nd_vAlign="top";
nd_hAlign="right";
nd_vMargin="10";
nd_hMargin="10";
nd_target="_top";




</script>
<script language="javascript" src="http://www.netdisaster.com/js/mynd.js"></script>
