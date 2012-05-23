var x, y, z, down=false, obj, par, puppet, uplimit, downlimit;
var body = document.getElementsByTagName("body");

function getObject(id){
  if(document.all)
    return document.all(id);
  return document.getElementById(id);
}

function init(){
  obj = event.srcElement.parentNode;
  obj.setCapture(); 
  par = obj.parentNode;
  z = obj.style.zIndex; 
  obj.style.zIndex = 100;
  x = event.offsetX;
  y = event.offsetY;
  down = true; 
  setPuppet();
  setObj();
}

function move(){
  if(down){
//    var tmp = getObject("output");
    with(obj.style){
//這兩行是莫名奇妙，不知原因但卻會對此template造成影響
//      posLeft = document.body.scrollLeft + event.x - x;
//      posTop = document.body.scrollTop + event.y - y;
      posLeft = event.x - x;
      posTop = event.y - y;
      uplimit = upLimit(puppet);
      downlimit = downLimit(puppet);
//      tmp.innerHTML = uplimit+" "+posTop+" "+downlimit;
      if(posTop < uplimit && puppet != par.firstChild)
	moveUp();
      if(posTop > downlimit && obj != par.lastChild)
        moveDown();
    }
  }
}

function stopdrag(){
	if(down){
		down=false; 
		obj.style.zIndex=z; 
		obj.releaseCapture(); 
		resetObj();
		resetPuppet();
		var seq = getSequence();
	}
} 

function setPuppet(){
  puppet = document.createElement("div");
  puppet.style.width = obj.style.width;
  puppet.style.height = obj.style.height;
  puppet.style.border = "2px dashed #808080";
  par.insertBefore(puppet, obj);
}

function setObj(){
  with(obj.style){
    position = "absolute";
//這兩行是莫名奇妙，不知原因但卻會對此template造成影響
//    posLeft = document.body.scrollLeft + event.x - x;
//    posTop = document.body.scrollTop + event.y - y;
    posLeft = event.x - x;
    posTop = event.y - y;
    filter = "alpha(opacity=50)";
  }
}

function resetObj(){
  var tmp = obj.cloneNode(true);
  tmp.style.position = puppet.style.position;
  tmp.style.filter = "alpha(opacity=100)";
  par.insertBefore(tmp, puppet);
  par.removeChild(obj);
}

function resetPuppet(){
  par.removeChild(puppet);
}

function moveUp(){
  var tmp = puppet.cloneNode(true);
  par.insertBefore(tmp, puppet.previousSibling);
  par.removeChild(puppet);
  puppet = tmp;

  tmp = puppet.nextSibling.nextSibling.cloneNode(true);
  par.insertBefore(tmp, puppet.nextSibling);
  par.removeChild(obj);
  obj = tmp;
}

function moveDown(){
  var tmp = puppet.nextSibling.nextSibling.cloneNode(true);
  par.insertBefore(tmp, puppet);
  par.removeChild(puppet.nextSibling.nextSibling);
}

function getTop(obj){
  var y = 0;
  do{
    y += obj.offsetTop;
    obj = obj.offsetParent;
  }while(obj); 
  return y;
}

function upLimit(){
  if(puppet == par.firstChild)
    return puppet.offsetTop;
  return puppet.previousSibling.offsetTop + PXtoInt(puppet.previousSibling.style.height) * 0.5;
}
/*
function upLimit(tmp){
  if(tmp == tmp.parentNode.firstChild)
    return getTop(tmp);
  return getTop(tmp.previousSibling);
}
*/
function downLimit(){
  if(obj == par.lastChild)
    return PXtoInt(puppet.style.height);
  return obj.nextSibling.offsetTop + PXtoInt(obj.nextSibling.style.height) * 0.5;
}
/*
function downLimit(tmp){
  if(tmp.nextSibling == tmp.parentNode.lastChild)
    return getTop(tmp) + PXtoInt(tmp.style.height); 
  //tmp.nextSibling是正在移動的物件，故需要再取一次的nextSibling
  return getTop(tmp.nextSibling.nextSibling);
}
*/
function PXtoInt(str){
  return parseInt(str.substr(0, str.length - 2))
}

function function_div(seq){
	var input = seq.split("^");
	var tmp = getObject("tmp_content");
	var par = tmp.parentNode;

	move_div(input, 0, 2, "menu_left");
	move_div(input, 3, 5, "menu_right");
	par.removeChild(tmp);
}

function move_div(input, start, end, div_name){
	var div = getObject(div_name);
	var tmp = null;
	var insert = null;
	//var obj_temp = null ;
	
	for(i = start ; i <= end ; i++){
		tmp = getObject("function_" + input[i]);
		insert = tmp.cloneNode(true);
		//insert.mergeAttributes(tmp);
		div.appendChild(insert);
		div.lastChild.mergeAttributes(tmp,false);
	}
	/*
	obj_temp = getElementsByTagName("div");
	obj_temp[2].mergeAttributes(obj_temp[1],true);
	obj_temp[2].click();*/
}

function getSequence(){
	var str = "";
	var xmlHttp = createXMLHttpRequest();
	var _url = "ajax/setDiv.php";

	str = getPart(str, "menu_left");
	str = getPart(str, "menu_right");

	xmlHttp.open("GET", _url + "?seq=" + str, false);
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;");
	xmlHttp.send(null);
}

function getPart(str, div){
	var tmp = getObject(div);
	var chi = tmp.firstChild;

	while(chi != null){
		if(chi.getAttribute("id") != null)
			str = str + chi.getAttribute("id").charAt(9) + "^";
		chi = chi.nextSibling;
	}
	return str;
}

function createXMLHttpRequest(){
	if(window.ActiveXObject){
		return new ActiveXObject("Microsoft.XMLHTTP");
	}else if(window.XMLHttpRequest){
		return new XMLHttpRequest();
	}
}
