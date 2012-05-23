function Menu(strObjName, strEID, strCallback)
{
	this.itemNum = 0;
	this.items = Array();
	this.curSel = 0;
	this.objName = strObjName;
	this.elementID = strEID;
	this.callback = strCallback;
	
	this.selClassName = "son";
	this.unselClassName = "soff";
	
	if(arguments.length >= 5){
		this.selClassName = arguments[3];
		this.unselClassName = arguments[4];
	}
	
}

Menu.prototype.clear = function(){
	var tmpElement = document.getElementById(this.elementID);
	//document.getElementById(this.elementID).innerHTML = "";	
	while(tmpElement.hasChildNodes()) tmpElement.removeChild(tmpElement.firstChild);	
	this.itemNum = 0;
	this.items.clear();
	this.curSel = 0;
}

Menu.prototype.add_item = function($content){
	var curObj = document.getElementById(this.elementID);
	//var newNode = document.createElement("option");
	//newNode.style.cursor = "pointer";
	//newNode.className = this.unselClassName;
	//newNode.id = 'MENU_ITEM_' + this.itemNum;
	//newNode.appendChild(document.createTextNode($content));	
	//curObj.appendChild(newNode);
	curObj.innerHTML +=
		'<div style="cursor:pointer;" class="'+ this.unselClassName + '"onmouseover="'+ this.objName+'.highlight(\'' + this.itemNum + '\')" onclick = "' + this.callback + '(\''+ this.itemNum+'\')"  id="MENU_ITEM_' + this.itemNum + '">' + $content + '</div>';
	this.items.push($content);
	//alert(curObj.parentNode.innerHTML);	
	this.itemNum ++;
}

Menu.prototype.highlight = function(id) {
	for(var i=0; i < this.itemNum; i++){
		var d = document.getElementById('MENU_ITEM_' + i);
		if(id == i){
			d.className = this.selClassName;
			this.curSel = i;
		}else{
			d.className = this.unselClassName;
		}
	}
}

Menu.prototype.sel_next = function(){
	if(this.itemNum == 0)
		return;
	if(this.curSel < this.itemNum - 1){
		this.highlight(this.curSel + 1);
	}
}

Menu.prototype.sel_prev = function(){
	if(this.itemNum == 0)
		return;
	if(this.curSel > 0){
		this.highlight(this.curSel - 1);
	}
}

Menu.prototype.get_content = function(id){
	if(id >=0 && id < this.itemNum){
			return document.getElementById('MENU_ITEM_'+id).firstChild.nodeValue;
	}else{
			return false;
	}
}

Menu.prototype.get_current_content = function(){
		return this.get_content(this.curSel);
}