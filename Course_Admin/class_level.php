<?php
/*******
FILE:   class_level.php
DATE:   2007/1/25
AUTHOR: zqq

將高師大的資料匯入
**/
// level 1
	$level_one = array( array("10","高中（含完全中學高中部及綜合中學高中部）"),
						array("20","高職（含綜合中學高職部）"),
						array("30","國中（含完全中學國中部）"),
						array("40","國小"),
						array("50","幼稚園"),
						array("60","特殊教育學校"),
						array("71","高中及高職"),
						array("72","高中、高職及國中"),
						array("73","國中及國小"),
						array("74","國小及幼稚園"),
						array("75","全部"));

// level 2						
	$level_two = array( array("1","行政"),
						array("2","教學"),
						array("999","其他"));

// level 3						
	$level_three_1 = array(array("1","教務類"),
							 array("2","訓輔類"),
							 array("3","總務類"),
							 array("4","圖書管理類"),
							 array("5","實習就業類"),
							 array("7","人事會計類"),
							 array("999","其他"));

	$level_three_2 = array(array("1","教務類"),
							 array("2","訓輔類"),
							 array("3","總務類"),
							 array("4","圖書管理類"),
							 array("5","實習就業類"),
							 array("7","人事會計類"),
							 array("999","其他"));
	
	$level_three_3 = array(array("1","教務類"),
							 array("2","訓輔類"),
							 array("3","總務類"),
							 array("4","圖書管理類"),
							 array("7","人事會計類"),
							 array("999","其他"));
							 
	$level_three_4 = array(array("1","教務類"),
							 array("2","訓輔類"),
							 array("3","總務類"),
							 array("4","圖書管理類"),
							 array("7","人事會計類"),
							 array("999","其他"));							 
							 
	$level_three_5 = array(array("3","總務類"),
							 array("6","教保類"));
							 
	$level_three_6 = array(array("1","教務類"),
							 array("2","訓輔類"),
							 array("3","總務類"),
							 array("4","圖書管理類"),
							 array("7","人事會計類"),
							 array("999","其他"));
							 
	$level_three_7 = array(array("10","語文"),
							 array("11","數學"),
							 array("12","社會"),
							 array("13","自然"),
							 array("15","藝術"),
							 array("16","家政與生活科技"),
							 array("17","健康與體育"),
							 array("18","綜合活動"),
							 array("19","國家安全通識"),
							 array("999","其他"));	
							 
	$level_three_8 = array(array("20","工業類科"),
							 array("21","商業類科"),
							 array("22","農業類科"),
							 array("23","家政類科"),
							 array("24","海事類科"),
							 array("25","醫技衛生類科"),
							 array("26","藝術類科"),
							 array("27","語文類科"),
							 array("999","其他"));						 						 
	
	$level_three_9 = array(array("10","語文"),
							 array("11","數學"),
							 array("12","社會"),
							 array("14","自然與生活科技"),
							 array("15","藝術"),
							 array("17","健康與體育"),
							 array("18","綜合活動"),
							 array("50","資訊教育"),
							 array("51","環境教育"),
							 array("52","人權教育"),
							 array("53","生涯發展教育"),
							 array("54","家政教育"),
							 array("55","兩性教育"),
							 array("999","其他"));	
							 
	$level_three_10 = array(array("10","語文"),
							 array("11","數學"),
							 array("12","社會"),
							 array("14","自然與生活科技"),
							 array("15","藝術"),
							 array("17","健康與體育"),
							 array("18","綜合活動"),
							 array("50","資訊教育"),
							 array("51","環境教育"),
							 array("52","人權教育"),
							 array("53","生涯發展教育"),
							 array("54","家政教育"),
							 array("55","兩性教育"),
							 array("999","其他"));								 

	$level_three_11 = array(array("60","語文"),
							 array("61","數學"),
							 array("62","健康"),
							 array("63","遊戲"),
							 array("64","音樂"),
							 array("65","工作"),
							 array("66","藝術"),
							 array("67","自然與社會"),
							 array("70","身心障礙"),
							 array("71","資賦優異"),
							 array("999","其他"));	
							 
	$level_three_12 = array(array("70","身心障礙"),
							 array("71","資賦優異"),
							 array("999","其他"));

	$level_three_13 = array(array("10","語文"),
							 array("11","數學"),
							 array("12","社會"),
							 array("13","自然"),
							 array("15","藝術"),
							 array("16","家政與生活科技"),
							 array("17","健康與體育"),
							 array("18","綜合活動"),
							 array("19","國家安全通識"),
							 array("20","工業類科"),
							 array("21","商業類科"),
							 array("22","農業類科"),
							 array("23","家政類科"),
							 array("24","海事類科"),
							 array("25","醫技衛生類科"),
							 array("26","藝術類科"),
							 array("27","語文類科"),
							 array("999","其他"));							 

	$level_three_14 = array(array("10","語文"),
							 array("11","數學"),
							 array("12","社會"),
							 array("13","自然"),
							 array("15","藝術"),
							 array("16","家政與生活科技"),
							 array("17","健康與體育"),
							 array("18","綜合活動"),
							 array("19","國家安全通識"),
							 array("20","工業類科"),
							 array("21","商業類科"),
							 array("22","農業類科"),
							 array("23","家政類科"),
							 array("24","海事類科"),
							 array("25","醫技衛生類科"),
							 array("26","藝術類科"),
							 array("27","語文類科"),
							 array("999","其他"));								 							 

	$level_three_15 = array(array("10","語文"),
							 array("11","數學"),
							 array("12","社會"),
							 array("14","自然與生活科技"),
							 array("15","藝術"),
							 array("17","健康與體育"),
							 array("18","綜合活動"),
							 array("50","資訊教育"),
							 array("51","環境教育"),
							 array("52","人權教育"),
							 array("53","生涯發展教育"),
							 array("54","家政教育"),
							 array("55","兩性教育"),
							 array("999","其他"));
							 
	$level_three_16 = array(array("10","語文"),
							 array("11","數學"),
							 array("12","社會"),
							 array("14","自然與生活科技"),
							 array("15","藝術"),
							 array("17","健康與體育"),
							 array("18","綜合活動"),
							 array("50","資訊教育"),
							 array("51","環境教育"),
							 array("52","人權教育"),
							 array("53","生涯發展教育"),
							 array("54","家政教育"),
							 array("55","兩性教育"),
							 array("60","語文"),
							 array("61","數學"),
							 array("62","健康"),
							 array("63","遊戲"),
							 array("64","音樂"),
							 array("65","工作"),
							 array("66","藝術"),
							 array("67","自然與社會"),
							 array("70","身心障礙"),
							 array("71","資賦優異"),
							 array("999","其他"));	
										
	$level_three_17 = array(array("10","語文"),
							 array("11","數學"),
							 array("12","社會"),
							 array("14","自然與生活科技"),
							 array("15","藝術"),
							 array("17","健康與體育"),
							 array("18","綜合活動"),
							 array("50","資訊教育"),
							 array("51","環境教育"),
							 array("52","人權教育"),
							 array("53","生涯發展教育"),
							 array("54","家政教育"),
							 array("55","兩性教育"),
							 array("999","其他"));
							 

	$level_three_18 = array(array("999","其他"));		

// level 4		
	
	$level_four_1 = array(array("1","無"),
							array("999","其他"));
							
	$level_four_2 = array(array("1","無"),
							array("999","其他"));	
						 														
	$level_four_3 = array(array("1","無"),
							array("999","其他"));																				 			

	$level_four_4 = array(array("1","無"),
							array("999","其他"));

	$level_four_5 = array(array("1","無"),
							array("999","其他"));
							
	$level_four_6 = array(array("1","無"),
							array("999","其他"));
							
	$level_four_7 = array(array("1","無"),
							array("999","其他"));		
							
	$level_four_8 = array(array("1","無"),
							array("999","其他"));

	$level_four_9 = array(array("999","其他"));	
	
	$level_four_10 = array(array("2","國語文"),
							array("3","英語文"),
							array("5","第二外國語"),
							array("999","其他"));
																										
	$level_four_11 = array(array("1","無"),
							array("999","其他"));

	$level_four_12 = array(array("6","歷史"),
							array("7","地理"),
							array("8","公民與社會"),
							array("9","三民主義"),
							array("999","其他"));
							
	$level_four_13 = array(array("10","物理"),
							array("11","化學"),
							array("12","生物"),
							array("13","地球科學"),
							array("999","其他"));	
							
	$level_four_14 = array(array("15","音樂"),
							array("16","美術"),
							array("17","藝術生活"),
							array("999","其他"));								

	$level_four_15 = array(array("18","家政"),
							array("19","生活科技"),
							array("999","其他"));
							
	$level_four_16 = array(array("20","體育"),
							array("21","健康與護理"),
							array("999","其他"));
										
	$level_four_17 = array(array("1","無"),
							array("999","其他"));							

	$level_four_18 = array(array("1","無"),
							array("999","其他"));												

	$level_four_19 = array(array("999","其他"));																
	
	$level_four_20 = array(array("40","土木科"),
							array("41","化工科"),
							array("42","印刷科"),
							array("43","冷凍空調科"),
							array("44","汽車科"),
							array("45","板金科"),
							array("46","室內空間設計科"),
							array("47","金屬工藝科"),
							array("48","建築科"),
							array("49","染髮科"),
							array("50","美工科"),
							array("51","重機科"),
							array("52","飛機修護科"),
							array("53","家具木工科"),	
							array("54","紡織科"),
							array("55","航空電子科"),
							array("56","配管科"),
							array("57","控制科"),
							array("57","控制科"),
							array("58","陶瓷科"),
							array("59","資訊科"),
							array("60","電子科"),
							array("61","電機科"),
							array("62","製圖科"),
							array("63","模具科"),
							array("64","機械木模科"),
							array("65","機械科"),
							array("66","機電科"),
							array("67","環境檢驗科"),
							array("68","鑄造科"),		
							array("999","其他"));		

	$level_four_21 = array(array("69","不動產事務科"),
							array("70","文書事務科"),
							array("71","商業經營科"),
							array("72","國貿科"),
							array("73","會計事務科"),
							array("74","資料處理科"),
							array("75","廣告設計科"),
							array("76","觀光事務科"),
							array("999","其他"));
							
	$level_four_22 = array(array("77","食品加工科"),
							array("78","畜產保健科"),
							array("79","造園科"),
							array("80","森林科"),
							array("81","園藝科"),
							array("82","農產行銷科"),
							array("83","農場經營科"),
							array("84","農產土木科"),
							array("85","農產機械科"),
							array("999","其它"));
							
	$level_four_23 = array(array("86","幼保科"),
							array("87","服裝科"),
							array("88","室內設計科"),
							array("89","美容科"),
							array("90","食品科"),
							array("91","家政科"),
							array("999","其它"));
							
	$level_four_24 = array(array("92","水產食品科"),
							array("93","水產經營科"),
							array("94","水產養殖科"),
							array("95","航海科"),
							array("96","航管科"),
							array("97","電子通信科"),
							array("98","漁業科"),
							array("99","輪機科"),
							array("999","其它"));
							
	$level_four_25 = array(array("100","醫事技術科"),
							array("101","護理科"),
							array("102","幼兒保育科"),
							array("103","醫務管理科"),
							array("104","應用化學科"),
							array("105","食品衛生科"),
							array("106","工業安全衛生科"),
							array("107","食品營養科"),
							array("108","環境工程衛生科"),
							array("109","公害防治科"),
							array("110","放射技術科"),
							array("999","其它"));
														
	$level_four_26 = array(array("111","國樂科"),
							array("112","電影電視科"),
							array("113","舞蹈科"),
							array("114","影劇科"),
							array("115","戲劇科"),
							array("116","藝術科"),
							array("117","美術科"),
							array("999","其它"));
							
	$level_four_27 = array(array("118","英國語文科"),
							array("119","法國語文科"),
							array("120","德國語文科"),
							array("121","西班牙語文科"),
							array("122","日本語文科"),
							array("999","其它"));
							
	$level_four_28 = array(array("999","其他"));
	
	$level_four_29 = array(array("2","國語文"),
							array("3","英語文"),
							array("4","鄉土語文"),
							array("999","其它"));
							
	$level_four_30 = array(array("1","無"),							
							array("999","其它"));
							
	$level_four_31 = array(array("6","歷史"),
							array("7","地理"),
							array("8","公民與社會"),
							array("999","其它"));
							
	$level_four_32 = array(array("10","物理"),
							array("11","化學"),
							array("12","生物"),
							array("13","地球科學"),
							array("14","理化"),
							array("19","生活科技"),
							array("999","其它"));
							
	$level_four_33 = array(array("15","音樂"),
							array("16","美術"),
							array("22","視覺藝術"),
							array("23","表演藝術"),
							array("999","其它"));
							
	$level_four_34 = array(array("1","無"),
							array("20","體育"),
							array("24","健康"),
							array("999","其它"));
							
	$level_four_35 = array(array("1","無"),
							array("18","家政"),
							array("25","輔導活動"),
							array("26","童軍教育"),
							array("999","其它"));
							
	$level_four_36 = array(array("1","無"),
							array("999","其它"));							
						
	$level_four_37 = array(array("1","無"),
							array("999","其它"));	
							
	$level_four_38 = array(array("1","無"),
							array("999","其它"));			
							
	$level_four_39 = array(array("1","無"),
							array("999","其它"));		

	$level_four_40 = array(array("1","無"),
							array("999","其它"));
							
	$level_four_41 = array(array("1","無"),
							array("999","其它"));									

	$level_four_42 = array(array("999","其它"));
	
	$level_four_43 = array(array("2","國語文"),
							array("3","英語文"),
							array("4","鄉土語文"),
							array("999","其它"));

	$level_four_44 = array(array("1","無"),
							array("999","其它"));	
							
	$level_four_45 = array(array("1","無"),
							array("999","其它"));															
							
	$level_four_46 = array(array("1","無"),
							array("13","地球科學"),
							array("999","其它"));
							
	$level_four_47 = array(array("1","無"),
							array("999","其它"));																

	$level_four_48 = array(array("1","無"),
							array("999","其它"));									
							
	$level_four_49 = array(array("1","無"),
							array("999","其它"));
							
	$level_four_50 = array(array("1","無"),
							array("999","其它"));	
							
	$level_four_51 = array(array("1","無"),
							array("999","其它"));		
							
	$level_four_52 = array(array("1","無"),
							array("999","其它"));	

	$level_four_53 = array(array("1","無"),
							array("999","其它"));
							
	$level_four_54 = array(array("1","無"),
							array("999","其它"));	

	$level_four_55 = array(array("1","無"),
							array("999","其它"));																														
							
	$level_four_56 = array(array("999","其它"));	
	
	$level_four_57 = array(array("1","無"),
							array("999","其它"));	
																								
	$level_four_58 = array(array("1","無"),
							array("999","其它"));

	$level_four_59 = array(array("1","無"),
							array("999","其它"));
							
	$level_four_60 = array(array("1","無"),
							array("999","其它"));							
							
	$level_four_61 = array(array("1","無"),
							array("999","其它"));		
							
	$level_four_62 = array(array("1","無"),
							array("999","其它"));
													
	$level_four_63 = array(array("1","無"),
							array("999","其它"));									
							
	$level_four_64 = array(array("1","無"),
							array("999","其它"));									
							
	$level_four_65 = array(array("1","無"),
							array("999","其它"));									
							
	$level_four_66 = array(array("1","無"),
							array("999","其它"));									
																
	$level_four_67 = array(array("999","其它"));
	
	$level_four_68 = array(array("150","智能障礙"),
							array("151","視覺障礙"),
							array("152","聽覺障礙"),
							array("153","語言障礙"),
							array("154","肢體障礙"),
							array("155","身體病弱"),
							array("156","嚴重情緒障礙"),
							array("157","學習障礙"),
							array("158","多重障礙"),
							array("159","自閉症"),
							array("160","發展遲緩"),
							array("161","其他顯著障礙"),
							array("999","其它"));
							
	$level_four_69 = array(array("162","一般智能"),
							array("163","學術性向"),
							array("164","藝術才能"),
							array("165","創造能力"),
							array("166","領導能力"),
							array("167","其他特殊才能"),
							array("999","其它"));
							
	$level_four_70 = array(array("999","其它"));
	
	$level_four_71 = array(array("999","其它"));								
	

?>