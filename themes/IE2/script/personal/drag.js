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
    var tmp = getObject("output");
    with(obj.style){
      posLeft=document.body.scrollLeft+event.x-x;
      posTop=document.body.scrollTop+event.y-y;
      uplimit = upLimit(puppet);
      downlimit = downLimit(puppet);
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
    posLeft=document.body.scrollLeft+event.x-x;
    posTop=document.body.scrollTop+event.y-y;
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

function upLimit(tmp){
  if(tmp == tmp.parentNode.firstChild)
    return getTop(tmp);
  return getTop(tmp.previousSibling);
}

function downLimit(tmp){
  if(tmp.nextSibling == tmp.parentNode.lastChild)
    return getTop(tmp) + PXtoInt(tmp.style.height); 
  //tmp.nextSibling是正在移動的物件，故需要再取一次的nextSibling
  return getTop(tmp.nextSibling.nextSibling);
}

function PXtoInt(str){
  return parseInt(str.substr(0, str.length - 2))
}
