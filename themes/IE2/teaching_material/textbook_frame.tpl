<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    	<title>瀏覽教材開啟，請注意：為避免閱讀時數無法記錄，請於登出前將閱讀子視窗關閉!</title>
    </head>

{literal}
  <script src="../library/splitter/jquery.js" type="text/javascript" language="JavaScript"></script>
  <script src="../library/splitter/jquery.ingeny.splitter.js" type="text/javascript" language="JavaScript"></script>
  <script  type="text/javascript" language="JavaScript">
  $(document).ready(function(){
    
    $("#panes").splitter({
            "defwidth": {
                "left":200,
                "right":200
                        },
            "minwidth": {
                "left":10,
                "right":10
                        },
            "maxwidth": {
                "left":500,
                "right":500
            },
            "collapse":{
                "left":"left",
                "right":"right"
            }
        }); 
    });
    $(window).load(function(){
{/literal} 
       $(window).resize();
       $('#left').append("<iframe style=\"width:100%;height:100%\" src=\"tree_frame.php?content_cd={$Content_cd}\">"); 
{literal} 
    });

//alert ("請注意!瀏覽跳出教材時請勿把原視窗關閉，否時會無法紀錄您的時數！");
//alert ("請注意!為使您的時數正確紀錄，彈出視窗在教材播放時，原視窗請不要任意點選其他連結！");

</script>
  
  <style type="text/css">
  <!--
    body{
        margin:0;
        padding:0;
    }
    #head{
        background:#ccc; 
        width:100%;
        height:35px;
        float:left;
        overflow:visible;
    }
    #container{
        margin:0;
        padding:0;
        height:300px;
    }
    .splitter{
        width:10px;
        cursor:W-resize;
        background-color:#ccc;
        vertical-align:middle;
        cursor:pointer;
    
    }

    select{
        width:100%;
    }

    #panes{
        margin:0;
        padding:0;
        height:300px;
        float:left;
        width:100%;
    }
    #left{
        background-color:#fee;
    }    
    #center{
        background-color:#efe;
    }    
    #right{
        background-color:#eef;
    }    
{/literal}
  //-->
  </style>

<body>
        <div id="panes" style="border:#00CCFF 3px solid;">
                <div id="left"> 
                <!--在這證入iframe會有問題,所以在load resize完之後再塞入iframe, tgbsa-->
                   <!-- iframe style="width:200px" src="tree_frame.php?content_cd={$Content_cd}" name="tree_frame" /-->
                </div>

                <div class="splitter"alt="雙擊可伸縮教材目錄" ><center><img src="../images/pull.GIF" alt="雙擊可伸縮教材目錄" style="position:absolute;left:0px; top:320px; width:15px; height:30px;"></center></div>

                <div id="center">
                    <table align="center">
                        <tr>
                            <td>
                                <iframe style="width:1000px;height:700px;"  src="stu_start.php?content_cd={$Content_cd}&frame=1" name="textbook_frame">
                            </td>
                        </tr>
                    </table>
                </div>
        
        </div>
</body>
</html>
