<?php
/*********************************************************/
/*   Author : w60292                                     */
/*     Date : 2009.08.31                                 */
/* Function : Make the validation picture for questbook  */
/*********************************************************/ 

Header("Content-type: image/gif");

/**********/
/* 初始化 */
/**********/

$border = 0; 	//是否要邊框 1要:0不要
$how = 4; 	//驗證碼
$w = $how*15; 	//圖片寬度
$h = 20; 	//圖片高度
$fontsize = 40; //字體大小
$alpha = "abcdefghijkmnopqrstuvwxyz"; 	//驗證碼內容 1:字母
$number = "023456789"; 			//驗證碼内容 2:数字
$randcode = ""; //驗證碼字串初始化
srand((double)microtime()*1000000); 	//初始化亂數種子

$im = ImageCreate($w, $h); 		//創建驗證碼圖片

/****************/
/* 繪製基本框架 */
/****************/

$bgcolor = ImageColorAllocate($im, 255, 255, 255); 	//設置背景顏色
ImageFill($im, 0, 0, $bgcolor); 			//填充背景色
if($border)
{
      $black = ImageColorAllocate($im, 0, 0, 0); 	//設置邊框颜色
          ImageRectangle($im, 0, 0, $w-1, $h-1, $black);//繪製邊框
}

/********************/
/* 逐位產生隨機字元 */
/********************/

for($i=0; $i<$how; $i++)
{   
      $alpha_or_number = mt_rand(0, 1); 	//字母還是數字
          $str = $alpha_or_number ? $alpha : $number;
          $which = mt_rand(0, strlen($str)-1); 	//取哪個字元
	      $code = substr($str, $which, 1); 	//取字元
	      $j = !$i ? 4 : $j+15; 		//繪字元位置
	          $color3 = ImageColorAllocate($im, mt_rand(0,100), mt_rand(0,100), mt_rand(0,100)); //字員隨機顏色
	          ImageChar($im, $fontsize, $j, 3, $code, $color3); //繪字元
		      $randcode .= $code; 	//逐位加入驗證碼字串
}

/************/
/* 添加干擾 */
/************/

for($i=0; $i<5; $i++)		//繪背景干擾線
{   
      $color1 = ImageColorAllocate($im, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255)); 			//干擾線顏色
          ImageArc($im, mt_rand(-5,$w), mt_rand(-5,$h), mt_rand(20,300), mt_rand(20,200), 55, 44, $color1); 	//干擾線
}   
for($i=0; $i<$how*40; $i++)	//繪背景干擾點
{   
      $color2 = ImageColorAllocate($im, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255)); 			//干擾點顏色 
          ImageSetPixel($im, mt_rand(0,$w), mt_rand(0,$h), $color2); 						//干擾點
}

//把驗證碼字串寫入session

session_start();
$_SESSION['randcode'] = $randcode;

/*繪圖結束*/

Imagegif($im);
ImageDestroy($im);

/*繪圖結束*/

?> 
