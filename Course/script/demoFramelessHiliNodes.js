//
// Copyright (c) 2006 by Conor O'Mahony.
// For enquiries, please email GubuSoft@GubuSoft.com.
// Please keep all copyright notices below.
// Original author of TreeView script is Marcelino Martins.
//
// This document includes the TreeView script.
// The TreeView script can be found at http://www.TreeView.net.
// The script is Copyright (c) 2006 by Conor O'Mahony.
//
// You can find general instructions for this file at www.treeview.net.
//

USETEXTLINKS = 1
STARTALLOPEN = 1
USEFRAMES = 0
USEICONS = 0
WRAPTEXT = 1
PRESERVESTATE = 1
HIGHLIGHT = 1


//
// The following code constructs the tree.
//
foldersTree = gFld("<b>課程瀏覽</b>", "course_broswer.php")
  aux2 = insFld(foldersTree, gFld("第一章", ""))
    insDoc(aux2, gLnk("S", "第一節", "course_broswer.php"))
    insDoc(aux2, gLnk("S", "第二節", "course_broswer.php"))
    insDoc(aux2, gLnk("S", "第三節", "course_broswer.php"))
  aux2 = insFld(foldersTree, gFld("第一章", "javascript:undefined"))
    insDoc(aux2, gLnk("S", "第一節", "course_broswer.php"))
    insDoc(aux2, gLnk("S", "第二節", "course_broswer.php"))

//
// Set this string if TreeView and other configuration files may also be loaded 
// in the same session.
//
foldersTree.treeID = "FramelessHili" 
 