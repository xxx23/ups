//Version 1.4 July 13, 2004, (c) Peter Jipsen http://www.chapman.edu/~jipsen
//License: GNU General Public License (http://www.gnu.org/copyleft/gpl.html)

AMinitSymbols();

function math_display() {
  var str = document.getElementById("inputText").value;
  var outnode = document.getElementById("outputNode");
  var n = outnode.childNodes.length;
  for (var i=0; i<n; i++)
    outnode.removeChild(outnode.firstChild);
  outnode.appendChild(document.createTextNode(str));
  AMprocessNode(outnode);
}
