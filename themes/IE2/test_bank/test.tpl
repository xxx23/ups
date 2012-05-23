<HTML>
 <HEAD>
  <TITLE>TreeView Demo: Frameless Layout with Highlighting</TITLE>
  <STYLE>
   SPAN.TreeviewSpanArea A {
     font-size: 10pt; 
     font-family: verdana,helvetica; 
     text-decoration: none;
     color: black;}
   SPAN.TreeviewSpanArea A:hover {
     color: '#820082';}

   /*                                                          */
   /* Styles for the remainder of the document.                */
   /*                                                          */
   BODY {
     background-color: white;}
   TD {
     font-size: 10pt; 
     font-family: verdana,helvetica;}

  </STYLE>
  <SCRIPT>
  // Note that this script is not related with the tree itself.  
  // It is just used for this example.
  function getQueryString(index) {
    var paramExpressions;
    var param
    var val
    paramExpressions = window.location.search.substr(1).split("&");
    if (index < paramExpressions.length) {
      param = paramExpressions[index]; 
      if (param.length > 0) {
        return eval(unescape(param));
      }
    }
    return ""
  }
  </SCRIPT>


  <!------------------------------------------------------------>
  <!-- SECTION 3:                                             -->
  <!-- Code for browser detection. DO NOT REMOVE.             -->
  <!------------------------------------------------------------>
  <SCRIPT src="ua.js"></SCRIPT>

  <!-- Infrastructure code for the TreeView. DO NOT REMOVE.   -->
  <SCRIPT src="ftiens4.js"></SCRIPT>

  <!-- Scripts that define the tree. DO NOT REMOVE.           -->
  

 </HEAD>


 <!------------------------------------------------------------->
 <!-- SECTION 4:                                              -->
 <!-- Change the <BODY> tag for use with your site.           -->
 <!------------------------------------------------------------->
 <BODY bgcolor="white" leftmargin="0" topmargin="0" marginheight="0" marginwidth="0"  onResize="if (navigator.family == 'nn4') window.location.reload()">


 <!----- ------------------------------------------------------->
 <!-- SECTION 5:                                              -->
 <!-- The main body of the page, including the table          -->
 <!-- structure that contains the tree and the contents.      -->
 <!---- -------------------------------------------------------->
 <TABLE cellpadding="0" cellspacing="0" border="0" width="772">
  <TR>
   <TD width="178" valign="top">

    <TABLE cellpadding="4" cellspacing="0" border="0" width="100%">
     <TR>
      <TD bgcolor="#ECECD9">

        <TABLE cellspacing="0" cellpadding="2" border="0" width="100%">
         <TR>
          <TD bgcolor="white">


 <!------------------------------------------------------------->
 <!-- SECTION 6:                                              -->
 <!-- Build the tree.                                         -->
 <!------------------------------------------------------------->

 <!------------------------------------------------------------->
 <!-- IMPORTANT NOTICE:                                       -->
 <!-- Removing the following link will prevent this script    -->
 <!-- from working.  Unless you purchase the registered       -->
 <!-- version of TreeView, you must include this link.        -->
 <!-- If you make any unauthorized changes to the following   -->
 <!-- code, you will violate the user agreement.  If you want -->
 <!-- to remove the link, see the online FAQ for instructions -->
 <!-- on how to obtain a version without the link.            -->
 <!------------------------------------------------------------->
 <TABLE border=0><TR><TD><FONT size=-2><A style="font-size:7pt;text-decoration:none;color:silver" href="http://www.treemenu.net/" target=_blank>Javascript Tree Menu</A></FONT></TD></TR></TABLE>


 <SPAN class=TreeviewSpanArea>
  <SCRIPT>initializeDocument()</SCRIPT>
  <NOSCRIPT>
   A tree for site navigation will open here if you enable JavaScript in your browser.
  </NOSCRIPT>
 </SPAN>


 <!------------------------------------------------------------->
 <!-- SECTION 7:                                              -->
 <!-- And now we have the continuation of the body of the     -->
 <!-- page, after the tree.  Replace this entire section with -->
 <!-- your site's HTML.                                       -->
 <!------------------------------------------------------------->
          </TD>
         </TR>
        </TABLE>

       </TD>
      </TR>
     </TABLE>

    </TD>
    <TD bgcolor="white" valign="top">

     <TABLE cellpadding="10" cellspacing="0" border="0" width="100%">
      <TR>
       <TD>

        <SCRIPT>
         // This code is needed only for this demo, not for your site
         var picURL
         picURL = getQueryString(0)
         if (picURL.length > 0)
           document.write("<img src=http://www.treeview.net/treemenu/demopics/" + picURL + "><br><br>");
        </SCRIPT>

        <H4>Frameless Layout For Treeview with Highlighting</H4>
	<P>This demo is based on the <A HREF="demoFrameless.html">TreeView: Frameless Layout</A> demo. 
        For information about frameless layout configurations, see that demo.</P>
        <P>Two options are being shown here:</P>
        <UL>
         <LI>The selected-node highlight (HIGHLIGHT) option.</LI>
         <LI>The opening of the tree with all branches expanded (STARTALLOPEN).</LI>
        </UL>
        <P>These variables can be configured independently of each other.  They also work just as well 
        with frame-based layouts.  They are only being set together here for the purposes of this
        demonstration.</P>
        <P>Note how clicking on nodes that are themselves connected to pages (such as Unites States) 
        highlights the text of the node.  Clicking on the +/- sign or on a node that does not load a 
        page (such as Europe) does not highlight it.</P>
        <P>Note also that, in the case of this demo, the page loads with all nodes visible.  Some 
        webmasters prefer it that way.  This is not recommended for very large trees.</P>

       </TD>
      </TR>
     </TABLE>

    </TD>
   </TR>
  </TABLE>

 </BODY>

</HTML>
