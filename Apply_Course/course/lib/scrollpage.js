function lib_bwcheck(){ //Browsercheck (needed)
	this.ver=navigator.appVersion
	this.agent=navigator.userAgent
	this.dom=document.getElementById?1:0
	this.opera5=this.agent.indexOf("Opera 5")>-1
	this.ie5=(this.ver.indexOf("MSIE 5")>-1 && this.dom && !this.opera5)?1:0; 
	this.ie6=(this.ver.indexOf("MSIE 6")>-1 && this.dom && !this.opera5)?1:0;
	this.ie7=(this.ver.indexOf("MSIE 7")>-1 && this.dom && !this.opera5)?1:0;
	this.ie4=(document.all && !this.dom && !this.opera5)?1:0;
	this.ie=this.ie4||this.ie5||this.ie6||this.ie7
	this.mac=this.agent.indexOf("Mac")>-1
	this.ns6=(this.dom && parseInt(this.ver) >= 5) ?1:0; 
	this.ns4=(document.layers && !this.dom)?1:0;
	this.bw=(this.ie7 || this.ie6 || this.ie5 || this.ie4 || this.ns4 || this.ns6 || this.opera5)
	return this
}
var bw=new lib_bwcheck()

var numScrollPages = 11; //pages 
var transitionOut = 1;        
var transitionIn = 2;        
var slideAcceleration = 0.3;   
var transitionOnload = 1;      

// A unit of measure that will be added when setting the position of a layer.
var px = bw.ns4||window.opera?"":"px";

if(document.layers){ //NS4 resize fix...
	scrX= innerWidth; scrY= innerHeight;
	onresize= function(){if(scrX!= innerWidth || scrY!= innerHeight){history.go(0)} }
}

//object constructor...
function scrollerobj(obj,nest){
	nest = (!nest)?"":'document.'+nest+'.'
	this.elm = bw.ie4?document.all[obj]:bw.ns4?eval(nest+'document.'+obj):document.getElementById(obj)
	this.css = bw.ns4?this.elm:this.elm.style
	this.doc = bw.ns4?this.elm.document:document
	this.obj = obj+'scrollerobj'; eval(this.obj+'=this')
	this.x = (bw.ns4||bw.opera5)?this.css.left:this.elm.offsetLeft
	this.y = (bw.ns4||bw.opera5)?this.css.top:this.elm.offsetTop
	this.w = (bw.ie4||bw.ie5||bw.ie6||bw.ie7||bw.ns6)?this.elm.offsetWidth:bw.ns4?this.elm.clip.width:bw.opera5?this.css.pixelWidth:0
	this.h = (bw.ie4||bw.ie5||bw.ie6||bw.ie7||bw.ns6)?this.elm.offsetHeight:bw.ns4?this.elm.clip.height:bw.opera5?this.css.pixelHeight:0
}

//object methods...
scrollerobj.prototype.moveTo = function(x,y){
	if(x!=null){this.x=x; this.css.left=x+px}
	if(y!=null){this.y=y; this.css.top=y+px}
}
scrollerobj.prototype.moveBy = function(x,y){this.moveTo(this.x+x,this.y+y)}
scrollerobj.prototype.hideIt = function(){this.css.visibility='hidden'}
scrollerobj.prototype.showIt = function(){this.css.visibility='visible'}

var scrollTimer = null;
function scroll(step){
	clearTimeout(scrollTimer);
	if ( !busy && (step<0&&activePage.y+activePage.h>scroller1.h || step>0&&activePage.y<0) ){
		activePage.moveBy(0,step);
		scrollTimer = setTimeout('scroll('+step+')',40);
	}
}
function stopScroll(){
	clearTimeout(scrollTimer);
}

var activePage = null;
var busy = 0;
function activate(num){
	//edit by sky  ---- move to the header
	if (num == 5 && activePage == pages[num])
		activePage.moveTo(0,0);
	// ----
	
	if (activePage!=pages[num] && !busy){
		busy = 1;
		if (transitionOut==0 || !bw.opacity){ activePage.hideIt(); activateContinue(num); }
		else if (transitionOut==1) activePage.blend('hidden', 'activateContinue('+num+')');
	}
}
function activateContinue(num){
	busy = 1;
	activePage = pages[num];
	activePage.moveTo(0,0);
	if (transitionIn==0 || !bw.opacity){ activePage.showIt(); busy=0; }
	else if (transitionIn==1) activePage.blend('visible', 'busy=0');
	else if (transitionIn==2) activePage.slide(0, slideAcceleration, 40, 'busy=0');
}

scrollerobj.prototype.slide = function(target, acceleration, time, fn){
	this.slideFn= fn?fn:null;
	this.moveTo(0,scroller1.h);
	if (bw.ie4&&!bw.mac) this.css.filter = 'alpha(opacity=100)';
	if (bw.ns6) this.css.MozOpacity = 1;
	this.showIt();
	this.doSlide(target, acceleration, time);
}
scrollerobj.prototype.doSlide = function(target, acceleration, time){
	this.step = Math.round(this.y*acceleration);
	if (this.step<1) this.step = 1;
	if (this.step>this.y) this.step = this.y;
	this.moveBy(0, -this.step);
	if (this.y>0) this.slideTim = setTimeout(this.obj+'.doSlide('+target+','+acceleration+','+time+')', time);
	else {	
		eval(this.slideFn);
		this.slideFn = null;
	}
}

scrollerobj.prototype.blend= function(vis, fn){
	if (bw.ie5||bw.ie6||bw.ie7 && !bw.mac) {
		if (vis=='visible') this.css.filter= 'blendTrans(duration=0.9)';
		else this.css.filter= 'blendTrans(duration=0.6)';
		this.elm.onfilterchange = function(){ eval(fn); };
		this.elm.filters.blendTrans.apply();
		this.css.visibility= vis;
		this.elm.filters.blendTrans.play();
	}
	else if (bw.ns7 || bw.ns6 || bw.ie&&!bw.mac){
		this.css.visibility= 'visible';
		vis=='visible' ? this.fadeTo(100, 7, 40, fn) : this.fadeTo(0, 9, 40, fn);
	}
	else {
		this.css.visibility= vis;
		eval(fn);
	}
};

scrollerobj.prototype.op= 100;
scrollerobj.prototype.opacityTim= null;
scrollerobj.prototype.setOpacity= function(num){
	this.css.filter= 'alpha(opacity='+num+')';
	this.css.MozOpacity= num/100;
	this.op= num;
}
scrollerobj.prototype.fadeTo= function(target, step, time, fn){
	clearTimeout(this.opacityTim);
	this.opacityFn= fn?fn:null;
	this.op = target==100 ? 0 : 100;
	this.fade(target, step, time);
}
scrollerobj.prototype.fade= function(target, step, time){
	if (Math.abs(target-this.op)>step){
		target>this.op? this.setOpacity(this.op+step):this.setOpacity(this.op-step);
		this.opacityTim= setTimeout(this.obj+'.fade('+target+','+step+','+time+')', time);
	}
	else {
		this.setOpacity(target);
		eval(this.opacityFn);
		this.opacityFn= null;
	}
}

var pageslidefadeLoaded = 0;
function initPageSlideFade(){
	scroller1 = new scrollerobj('divScroller');
	
	pages = new Array();
	for (var i=0; i<numScrollPages; i++){
		pages[i] = new scrollerobj('dynPage'+i, 'divScroller');
		pages[i].moveTo(0,0);
	}
	bw.opacity = ( bw.ie && !bw.ie4 && navigator.userAgent.indexOf('Windows')>-1 ) || bw.ns6
	if (bw.ie5||bw.ie6||bw.ie7 && !bw.mac) pages[0].css.filter= 'blendTrans(duration=0.6)'; // Preloads the windows filters.
	
	if (transitionOnload) activateContinue(0);
	else{
		activePage = pages[0];
		activePage.showIt();
	}

	if (bw.ie) for(var i=0;i<document.links.length;i++) document.links[i].onfocus=document.links[i].blur;
	pageslidefadeLoaded = 1;
}
//if the browser is ok, the script is started onload..
if(bw.bw && !pageslidefadeLoaded) onload = initPageSlideFade;
