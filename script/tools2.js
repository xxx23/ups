//
//	the javascript below is to control the toolbar
//

// reset all cell to normal button shape

function resetCell()
{
	var td = document.all.item("TOOL");
	if( td != null )
	{
		for( i = 0; i < td.length; i++ )
		{
			var o = td[i];
			o.borderColorLight	= "#808080";
			o.borderColorDark	= "#FFFFFF";
		}
	}
}

// find the cell of the tool.
function upToElement( o, str )
{
	if( o == null )
		return null;
	if( o.tagName == str )
		return o;
	if( o.tagName == "BODY" )
		return null;
	return upToElement( o.parentElement, str );
}


// make the toolbar button checked.
function Tool_MouseDown()
{
	o = event.srcElement;
	o = upToElement( o, 'TD' );
	if( o != null && o.id == 'tool' )
	{
		resetCell();
		o.borderColorLight	= "#FFFFFF";
		o.borderColorDark	= "#808080";
		activeTool = o.tool;

		with( mainWin.document.body.style )
		{
			if( o.tool == 'cursor' )
				cursor = 'auto';
			else if( o.tool == 'move' )
				cursor = 'hand';
			else
				cursor = 'crosshair';
		}
	}
}

// ctrl+? controls the toolbar buttons.
function KeyPress( win )
{
	if( win == null )
		return;
	with(win)
	{
		if( event.ctrlKey == true )		// ctrl+?
		{
			if( event.keyCode >= 49 && event.keyCode < 58 )		// '1' ~ '9'
			{
				SelectTool( event.keyCode - 49 );
				event.returnValue = false;
			}
		}
	}
}

function SelectTool( index )
{
	var t = toolWin.document.all.item('tool');
	if( t != null && t.length > 0 && index < t.length )
		t[index].click();
}

function Tool_KeyPress()
{
	KeyPress( toolWin );
}

// the object of javascript
// a rectangle object: left, top, right, bottom
function CRect( l, t, r, b )
{
	this.left	= l;
	this.top	= t;
	this.right	= r;
	this.bottom	= b;

	this.width = function()
	{	return Math.abs( this.right - this.left );	};

	this.height = function()
	{	return Math.abs( this.bottom - this.top );	};

	this.normalize = function()
	{
		var tmp;
		if( this.top > this.bottom )
		{
			tmp = this.top;
			this.top = this.bottom;
			this.bottom = tmp;
		}
		if( this.left > this.right )
		{
			tmp = this.left;
			this.left = this.right;
			this.right = tmp;
		}
	}
}

// the drawing shape of html, including <DIV>[<SHAPE>|<SPAN>]</DIV>
function CShape()
{
	this.html = '';
	this.tool = '';
	this.objShape = null;
	this.rect = null;

	this.check = function()
	{
		if( this.tool == 'freehand' )
		{
			return;
		}
		if( this.rect.width() < 20 && this.rect.height() < 20 )
		{
			this.objShape.style.visibility = 'hidden';
			this.objShape.removeNode( true );
		}
	}

	this.final = function()
	{
		with( this.objShape )
		{
			onmouseover = Main_MouseOver;
			onmouseout = Main_MouseOut;
			onmousedown = Shape_MouseDown;
			onmouseup = Shape_MouseUp;
			style.filter = 'alpha(opacity=70)';
		}
	}

	this.create = function( shape )
	{
		var vml = '';
		with( this.rect )
		{
			if( shape == 'arrow' )
			{
				vml+= '<v:line style="position:absolute" id="_shape" from="'+left+'px,'+top+'px" to="'+(right+1)+'px,'+(bottom+1)+'px" ';
				vml+= 'strokeweight="'+ strokeWeight+'px" strokecolor="'+strokeColor+'">';
				vml+= '<v:stroke endarrow="classic" /></v:line>';
			}
			else if( shape == 'line' )
			{
				vml+= '<v:line style="position:absolute" id="_shape" from="'+left+'px,'+top+'px" to="'+(right+1)+'px,'+(bottom+1)+'px" ';
				vml+= 'strokeweight="'+ strokeWeight+'px" strokecolor="'+strokeColor+'" />';
			}
			else if( shape == 'rect' )
			{
				vml+= '<v:rect id="_shape" style="position:absolute; top:'+top+'px; left:'+left+'px; width:'+width()+'px; height:'+height()+'px" ';
				vml+= 'stroked="t" strokecolor="'+strokeColor+'" strokeweight="'+strokeWeight+'px" ';
				vml+= 'filled="'+filled+'" fillcolor="'+fillColor+'" />';
			}
			else if( shape == 'circle' )
			{
				vml+= '<v:oval id="_shape" style="position:absolute; top:'+top+'px; left:'+left+'px; width:'+width()+'px; height:'+height()+'px" ';
				vml+= 'stroked="t" strokecolor="'+strokeColor+'" strokeweight="'+strokeWeight+'px" ';
				vml+= 'filled="'+filled+'" fillcolor="'+fillColor+'" />';
			}
			else if( shape == 'rrect' )
			{
				vml+= '<v:roundrect id="_shape" arcsize="0.2" style="position:absolute; top:'+top+'px; left:'+left+'px; width:'+width()+'px; height:'+height()+'px" ';
				vml+= 'stroked="t" strokecolor="'+strokeColor+'" strokeweight="'+strokeWeight+'px" ';
				vml+= 'filled="'+filled+'" fillcolor="'+fillColor+'" />';
			}
			else if( shape == 'right' )
			{
				vml+= '<v:shape id="_shape" coordsize="3 2" style="position:absolute; top:'+top+'px; left:'+left+'px; width:'+width()+'px; height:'+height()+'px" ';
				vml+= 'filled="f" stroked="t" strokecolor="'+strokeColor+'" strokeweight="'+strokeWeight+'px" path="m0,1 l1,2,3,0 e" />';
			}
			else if( shape == 'wrong' )
			{
				vml+= '<v:shape id="_shape" coordsize="3 3" style="position:absolute; top:'+top+'px; left:'+left+'px; width:'+width()+'px; height:'+height()+'px" ';
				vml+= 'filled="f" stroked="t" strokecolor="'+strokeColor+'" strokeweight="'+strokeWeight+'px" path="m0,0 l3,3 m0,3 l3,0 e" />';
			}
			else if( shape == 'quest' )
			{
				vml+= '<v:shape id="_shape" coordsize="10 20" style="position:absolute; top:'+top+'px; left:'+left+'px; width:'+width()+'px; height:'+height()+'px" ';
				vml+= 'filled="f" stroked="t" strokecolor="'+strokeColor+'" strokeweight="'+strokeWeight+'px" path="wr0,0,10,10,0,5,5,10 l5,13 m5,14 l5,16 e" />';
			}
			else if( shape == 'freehand' )
			{
				w = mainWin.document.body.scrollWidth;
				h = mainWin.document.body.scrollHeight;

				vml+= '<v:shape id="_shape" coordsize="'+w+','+h+'" style="position:absolute; top:0px; left:0px; width:'+w+'px; height:'+h+'px" ';
				vml+= 'filled="f" stroked="t" strokecolor="'+strokeColor+'" strokeweight="'+strokeWeight+'px" path="m'+left+','+top+'l'+left+','+top+'e" />';
			}
		}
		this.html = vml;
		delete vml;
	}

	this.insert = function( obj )
	{
		obj.insertAdjacentHTML( "BeforeEnd", this.html );		// insert HTML & get object control
		this.objShape = obj.lastChild;
		if( this.objShape == null )
		{
			alert( 'cannot get object' );
			return;
		}
	}

	this.adjust = function( x, y )
	{
		if( this.tool == 'line' || this.tool == 'arrow' )
		{
			this.objShape.to = x + 'px,' + y + 'px';
			with( this.rect )
			{
				right = x;
				bottom = y;
			}
		}
		else if( this.tool == 'freehand' )
		{
			var re = / *e/i;
			var str = new String(this.objShape.path);
			this.objShape.path = str.replace( re, ',' + x + ',' + y + 'e' );
		}
		else
		{
			this.rect.right = x;
			this.rect.bottom = y;
			with( this.rect )
				var r = new CRect( left, top, right, bottom );

			with( r )
			{
				normalize();
				this.objShape.style.top = top;
				this.objShape.style.left = left;
				this.objShape.style.width = width();
				this.objShape.style.height = height();
			}
		}
	}
}

var prevCursor = 'auto';
var selShape = null;

function Shape_OnFocus( obj )
{
	if( selShape == obj )
		return;
	if( selShape != null )
		Shape_OnBlur( selShape );

	with( obj.style )
	{
		borderStyle = 'dotted';
		borderWidth = 2;
	}
	selShape = obj;
}

function Shape_OnBlur( obj )
{
	if( obj == null )
		return;
	with( obj.style )
	{
		borderWidth = 0;
		borderStyle = 'none';
	}
	selShape = null;
}

var shapeTop, shapeLeft;

function Shape_MouseUp()
{
	mainWin.document.onmousemove = Main_MouseMove;
	mainWin.event.cancelBubble = true;
	mainWin.event.returnValue = false;
	return false;
}


function Shape_Drag()
{
	with( mainWin )
	{
		if( event.button == 1 )
		{
			x = event.clientX + document.body.scrollLeft - document.body.clientLeft;
			y = event.clientY + document.body.scrollTop - document.body.clientTop;
			selShape.style.pixelTop = y - shapeTop;
			selShape.style.pixelLeft = x - shapeLeft;
			return false;
		}
	}
}

function Shape_MouseDown()
{
	with( mainWin )
	{
		if( event.srcElement != null && event.srcElement.id == '_shape' )
		{
			Shape_OnFocus( event.srcElement );
			event.cancelBubble = true;
			event.returnValue = false;

			x = event.clientX + document.body.scrollLeft - document.body.clientLeft;
			y = event.clientY + document.body.scrollTop - document.body.clientTop;
			shapeTop = y - selShape.style.pixelTop;
			shapeLeft = x - selShape.style.pixelLeft;
			document.onmousemove = Shape_Drag;

			return false;
		}
	}
}

function Main_MouseOver()
{
	if( bMouseDown )
		return;
	with( mainWin.document.body.style )
	{
		prevCursor = cursor;
		cursor = 'move';
	}
}

function Main_MouseOut()
{
	with( mainWin.document.body.style )
		cursor = prevCursor;
}

// the javascript that control the mouse & shapes in the main frame.
// Global variable
var mainWin = null;
var insertArea = null;
var toolWin = null;

var activeShape = null;
var activeTool = 'cursor';				// the tool of paint
var bMouseDown = new Boolean( false );

var strokeColor = 'red';
var strokeWeight = 4;
var filled = new Boolean( false );
var fillColor = 'black';
var imagePos = '';

function changeStrokeColor( color )
{
	strokeColor = color;
	document.body.focus();
}

function changeStrokeWeight( n )
{
	strokeWeight = n;
	document.body.focus();
}

function changeFilled( b )
{
	filled = (b == 0) ? false : true;
	document.body.focus();
}

function changeFillColor( color )
{
	fillColor = color;
	document.body.focus();
}

function dump( e )
{
	str = '';
	for( var p in e )
		str += p + ': "' + e[p] + '"\t';
	alert( str );
}

function Tool_OnLoad()
{
	toolWin = window.parent.tools;

	toolWin.document.onclick	= Tool_MouseDown;
	toolWin.document.onkeydown	= Tool_KeyPress;
	window.parent.bLoad = true;
}


function Main_OnLoad()
{
	mainWin = window.parent.main;
	if( mainWin == null )				// main frame was not found
	{
		alert( 'cannot found main frame' );
		return;
	}

	try		// hook the handler of main iframe. if fails, the iframe is not a subset of the URL of this.
	{
		with( mainWin.document )
		{
			if( all.item( '_insertArea' ) == null )		// it's not exists
			{
				// insert the div tag to contain our controls
				vml = '<div id="_insertArea" style="z-index:65536; position:absolute;top:0;left:0;width:100%"></div>';
				body.insertAdjacentHTML( 'BeforeEnd', vml );
				insertArea = all.item( '_insertArea' );
				if( insertArea == null )
					throw 'error';

				// insert VML control to HTML
				vml = '<xml:namespace ns="urn:schemas-microsoft-com:vml" prefix="v"/>\n';
				vml+= '<object id="VMLRender" codebase="vgx.dll" classid="CLSID:10072CEC-8CC1-11D1-986E-00A0C955B42E"></object>\n';
				vml+= '<style>v\\:* { behavior: url(#VMLRender); }</style>\n';
				body.insertAdjacentHTML( 'AfterBegin', vml );
				
/*				if( old_vml != '' )
				{
					insertArea.insertAdjacentHTML( 'BeforeEnd', old_vml );
					
					var shape = insertArea.firstChild;
					while( shape != null )
					{
						if( shape.id == '_shape' )
						{
							shape.onmouseover = Main_MouseOver;
							shape.onmouseout = Main_MouseOut;
							shape.onmousedown = Shape_MouseDown;
							shape.onmouseup = Shape_MouseUp;
						}
 						shape = shape.nextSibling;
					}
				}*/
				// insert XML namespace between div
				//vml = '<?xml:namespace prefix=v />\n';
				//insertArea.insertAdjacentHTML('AfterBegin', vml );
			}
			else
			{
				insertArea = all.item( '_insertArea' );
				var shape = insertArea.firstChild;
				while( shape != null )
				{
					if( shape.id == '_shape' )
					{
						shape.onmouseover = Main_MouseOver;
						shape.onmouseout = Main_MouseOut;
						shape.onmousedown = Shape_MouseDown;
						shape.onmouseup = Shape_MouseUp;
					}
					else if( shape.id == '_grade' )
					{
						var obj = shape;
						shape = shape.nextSibling;
						obj.removeNode( true );
						continue;
					}
					shape = shape.nextSibling;
				}
			}

			onmousedown	= Main_MouseDown;		// set the mouse handler
			onmouseup	= Main_MouseUp;
			onmousemove	= Main_MouseMove;
			onkeydown	= Main_KeyPress;
		}
	}
	catch( e ) {
		dump( e );
		return;
	}
}

function Main_MouseDown()
{
	if( mainWin.event.clientX >= mainWin.document.body.clientWidth )
		return;
	if( mainWin.event.clientY >= mainWin.document.body.clientHeight )
		return;

	if( selShape != null )
		Shape_OnBlur( selShape );

	if( mainWin.event.button != 1 )
		return;

	if( activeTool == 'image' )
	{
		return false;
	}

	if( activeTool == 'font')
	{
		mainWin.event.returnValue = false;
		fontStr = parent.showModalDialog( "font.html" );
		if( fontStr != '' )
		{
			with( mainWin )
			{
				x = event.clientX + document.body.scrollLeft - document.body.clientLeft;
				y = event.clientY + document.body.scrollTop - document.body.clientTop;

				insertArea.insertAdjacentHTML( 'BeforeEnd', fontStr );
				with( insertArea.lastChild.style )
				{
					position = 'absolute';
					top = y + 'px';
					left = x + 'px';
				}
				with( insertArea.lastChild )
				{
					id = '_shape';
					onmouseover = Main_MouseOver;
					onmouseout = Main_MouseOut;
					onmousedown = Shape_MouseDown;
					onmouseup = Shape_MouseUp;
				}
			}
		}
		return false;
	}
	else if( activeTool != 'cursor' && activeTool != 'image')
	{
		with( mainWin )
		{
			prevCursor = document.body.style.cursor;
			event.returnValue = false;
			event.cancelBubble = true;

			x = event.clientX + document.body.scrollLeft - document.body.clientLeft;
			y = event.clientY + document.body.scrollTop - document.body.clientTop;
		}

		activeShape = new CShape();
		activeShape.tool = activeTool;
		activeShape.rect = new CRect( x, y, x, y );
		activeShape.create( activeTool );
		activeShape.insert( insertArea );
		bMouseDown = true;
		return false;
	}
}

function Main_MouseUp()
{
	if( bMouseDown == true )
	{
		mainWin.event.returnValue = false;
		mainWin.event.cancelBubble = true;
		bMouseDown = false;
		activeShape.final();
		activeShape.check();
		delete activeShape;
		activeShape = null;

		mainWin.focus();
		return false;
	}
	
	if( activeTool == 'image' && mainWin.event.button == 1)
	{
		with( mainWin )
		{
			x = event.clientX + document.body.scrollLeft - document.body.clientLeft;
			y = event.clientY + document.body.scrollTop - document.body.clientTop;
		}
		open( "image.php", "image", "width=750,height=480,resizable=1, toolbar=no,menubar=no,location=no,status=no" );
		imagePos = 'top:' + y + ';left:' + x;
		return false;
	}
}

function Main_MouseMove()
{
	if( bMouseDown == false && mainWin.event.srcElement.id == '_shape' )
	{
		mainWin.document.body.style.cursor = "move";
		return false;
	}

	if( activeTool == 'cursor' )
		mainWin.document.body.style.cursor = 'auto';
	else
		mainWin.document.body.style.cursor = 'crosshair';

	if( bMouseDown == true )
	{
		mainWin.event.cancelBubble = true;
		mainWin.event.returnValue = false;
		with( mainWin )
		{
			x = event.clientX + document.body.scrollLeft - document.body.clientLeft;
			y = event.clientY + document.body.scrollTop - document.body.clientTop;
			if( x < 0 )	x = 0;
			if( y < 0 )	y = 0;
		}
		activeShape.adjust( x, y );
		return false;
	}
}

function Main_KeyPress()
{
	if( selShape != null && mainWin.event.keyCode == 46 )
	{
		selShape.style.visibility = 'hidden';
		selShape.removeNode( true );
		selShape = null;
	}
	KeyPress( mainWin );
}

function viewSource()
{
	alert( insertArea.innerHTML );
	mainWin.document.body.focus();
}

function Tool_InsertGrade()
{
	s = '<span id="_grade" style="position:absolute; top:0; left:0; font-size:24pt; color:red">';
	s+= vml_form.grade.value + '</span>';
	insertArea.insertAdjacentHTML( 'BeforeEnd', s );
}

function Tool_OnSubmit()
{
	alert("成績已修改，請重新整理頁面。");
	with( document )
	{
		if( vml_form.grade.value == '' )
		{
			alert( 'please key in grade' );
			return ;
		}
		Shape_OnBlur( selShape );
		mainWin.document.body.style.cursor = '';
		Tool_InsertGrade();
		vml_form.vml.value = mainWin.document.body.outerHTML;
		vml_form.submit();
	}
}

function Image_Paste( url )
{
	vml = '<img id="_shape" src="'+url+'" style="position:absolute;'+imagePos+'">';
	insertArea.insertAdjacentHTML( 'BeforeEnd', vml );
	obj = insertArea.lastChild;
	if( obj != null )
	{
		with( obj )
		{
			onmouseover = Main_MouseOver;
			onmouseout = Main_MouseOut;
			onmousedown = Shape_MouseDown;
			onmouseup = Shape_MouseUp;
		}
	}
}

