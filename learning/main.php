<?php

ini_set('default_charset', 'utf-8');
        $config_path = "config.php";
	if(!file_exists($config_path) ||  filesize($config_path) == 0 ){
		header('location: Install/install1.php');
		return ;
	}


	include($config_path);
	     
	
	$tpl = new Smarty();
        $city = array
        (
            1 => array("name"=>"基隆市",
            "url" => "http://",
            "englishname"=>"Keelung",
            "coords"=>"298, 17, 295, 20, 290, 20, 289, 24, 295, 32, 305, 37, 308, 34, 307, 29, 305, 27, 308, 26, 314, 22, 327, 20, 327, 16, 298, 15"),//
            2 => array("name"=>"台北縣",
            "url" => "https://140.123.105.16/~sinjun/",
            "englishname"=>"Taipei",
            "coords"=>"296, 32, 292, 32, 290, 31, 288, 29, 288, 24, 288, 21, 284, 19, 283, 15, 278, 15, 275, 18, 268, 21, 268, 23, 268, 29, 271, 29, 271, 31, 271, 37, 271, 41, 275, 40, 275, 44, 283, 49, 288, 49, 288, 43, 293, 43, 303, 41, 304, 38, 308, 38, 313, 37, 310, 30, 311, 29, 318, 26, 323, 26, 326, 31, 327, 36, 335, 37, 337, 38, 337, 41, 327, 41, 320, 41, 316, 46, 316, 52, 311, 53, 303, 56, 295, 59, 291, 63, 286, 68, 284, 72, 284, 75, 277, 77, 270, 81, 268, 80, 266, 75, 264, 72, 264, 67, 264, 64, 260, 63, 256, 63, 253, 61, 248, 55, 248, 49, 251, 46, 257, 47, 258, 38, 258, 37, 257, 32, 252, 29, 247, 29, 254, 26, 259, 21, 259, 17, 260, 13, 266, 11, 274, 6, 277, 6, 283, 6, 284, 6, 285, 11, 291, 13, 293, 13, 295, 18, 298, 21, 294, 21, 291, 21, 290, 26, 291, 30"),
            3 => array("name"=>"台北市",
            "englishname"=>"Taipei city",
            "url" => "https://140.123.105.16/~sinjun/",
            "coords"=>"286, 33, 286, 31, 284, 31, 286, 24, 282, 23, 281, 18, 279, 18, 277, 20, 274, 20, 273, 21, 272, 22, 267, 23, 266, 27, 266, 31, 269, 31, 273, 33, 271, 36, 271, 39, 271, 42, 273, 40, 273, 43, 279, 48, 283, 48, 288, 48, 284, 44, 288, 42, 298, 41, 303, 41, 303, 40, 303, 36, 290, 37, 289, 35, 287, 33"),
            4 => array("name" =>"桃園縣",
            "englishname" =>"Taoyuan",
            "url" => "http://",
            "coords"=>"208, 50, 217, 39, 219, 38, 223, 38, 231, 32, 238, 31, 241, 30, 245, 29, 252, 30, 257, 34, 257, 38, 257, 43, 254, 45, 247, 45, 246, 53, 250, 55, 252, 63, 259, 63, 263, 64, 263, 71, 263, 75, 266, 75, 266, 80, 267, 80, 269, 82, 266, 85, 265, 91, 264, 94, 260, 94, 257, 90, 254, 89, 249, 85, 249, 83, 247, 76, 246, 75, 243, 69, 239, 70, 238, 68, 232, 67, 232, 64, 228, 59, 225, 56, 221, 55, 215, 53, 209, 51"),
            5 => array("name"=>"新竹縣",
            "englishname"=>"Hsinchu",
            "url" => "http://",
            "coords"=>"210, 53, 217, 55, 219, 56, 223, 57, 228, 63, 229, 67, 235, 68, 239, 71, 244, 71, 245, 73, 247, 77, 247, 84, 249, 88, 257, 92, 259, 94, 262, 96, 263, 100, 260, 105, 257, 106, 254, 110, 252, 112, 248, 115, 243, 115, 244, 112, 244, 109, 241, 106, 241, 104, 238, 101, 235, 100, 232, 100, 226, 95, 220, 94, 218, 92, 214, 90, 210, 87, 205, 85, 201, 82, 202, 78, 205, 75, 208, 74, 210, 75, 211, 73, 211, 69, 210, 68, 207, 68, 202, 63, 202, 61, 208, 54"),
            6 => array("name"=>"新竹市",
            "englishname"=>"Hsinchu city",
            "url" => "http://",
            "coords"=>"180, 63, 197, 63, 200, 61, 202, 64, 207, 67, 210, 68, 209, 74, 205, 72, 201, 75, 201, 76, 200, 81, 195, 81, 191, 76, 194, 75, 193, 72, 181, 72, 180, 63"),//no
            7 => array("name"=>"苗栗縣",
            "englishname"=>"Miaoli",
            "url" => "http://",
            "coords"=>"191, 83, 186, 94, 180, 94, 177, 95, 173, 103, 161, 123, 179, 132, 190, 129, 199, 132, 206, 133, 211, 133, 216, 133, 221, 132, 225, 128, 234, 125, 239, 124, 242, 113, 236, 102, 217, 97, 205, 87, 193, 83"),
            8 => array("name"=>"台中縣",
            "englishname"=>"Taichung",
            "url" => "http://",
            "coords"=>"180, 135, 160, 125, 154, 139, 151, 143, 147, 147, 146, 151, 161, 151, 164, 151, 172, 151, 177, 151, 182, 151, 185, 152, 185, 157, 181, 159, 175, 159, 174, 160, 168, 163, 164, 162, 161, 160, 158, 160, 161, 167, 163, 169, 167, 169, 170, 171, 173, 173, 179, 174, 182, 174, 183, 173, 186, 168, 190, 162, 192, 160, 199, 160, 200, 159, 206, 159, 209, 159, 213, 156, 216, 155, 218, 151, 221, 151, 221, 148, 224, 149, 230, 146, 233, 145, 238, 152, 242, 152, 254, 152, 257, 152, 257, 151, 256, 146, 256, 143, 256, 138, 257, 135, 260, 132, 263, 131, 263, 128, 264, 125, 261, 125, 256, 125, 254, 124, 250, 118, 245, 118, 241, 118, 240, 121, 239, 125, 236, 125, 228, 128, 224, 131, 221, 133, 217, 134, 215, 135, 209, 135, 203, 134, 200, 134, 190, 132"),
            9 => array("name"=>"台中市",
            "englishname"=>"Taichung city",
            "url" => "http://",
            "coords"=>"146, 151, 157, 151, 164, 151, 168, 151, 174, 151, 175, 151, 177, 151, 178, 151, 183, 151, 185, 153, 185, 158, 182, 158, 177, 158, 176, 159, 176, 160, 171, 161, 165, 161, 164, 160, 163, 160, 160, 160, 160, 162, 156, 160, 152, 157, 146, 151"),//no
            10 => array("name"=>"彰化縣",
            "englishname"=>"Changhua",
            "url" => "http://",
            "coords"=>"208, 50, 217, 39, 219, 38, 223, 38, 231, 32, 238, 31, 241, 30, 245, 29, 252, 30, 257, 34, 257, 38, 257, 43, 254, 45, 247, 45, 246, 53, 250, 55, 252, 63, 259, 63, 263, 64, 263, 71, 263, 75, 266, 75, 266, 80, 267, 80, 269, 82, 266, 85, 265, 91, 264, 94, 260, 94, 257, 90, 254, 89, 249, 85, 249, 83, 247, 76, 246, 75, 243, 69, 239, 70, 238, 68, 232, 67, 232, 64, 228, 59, 225, 56, 221, 55, 215, 53, 209, 51"),
            11 => array("name"=>"雲林縣",
            "englishname"=>"Yunlin",
            "url" => "http://",
            "coords"=>"116, 205, 125, 209, 129, 209, 136, 207, 139, 207, 145, 207, 152, 209, 158, 209, 163, 209, 168, 209, 168, 213, 167, 225, 169, 226, 173, 226, 179, 226, 182, 226, 183, 228, 182, 231, 182, 232, 174, 230, 168, 230, 163, 230, 158, 230, 154, 230, 146, 226, 144, 226, 137, 228, 134, 230, 129, 234, 112, 244, 106, 244, 106, 226"),
            12 => array("name"=>"嘉義市",
            "englishname"=>"Chiayi city",
            "url" => "http://",
            "coords"=>"120, 244, 151, 245, 156, 252, 130, 256, 123, 243"),//no
            13 => array("name"=>"嘉義縣",
            "englishname"=>"Chiayi",
            "url" => "http://",
            "coords"=>"106, 271, 108, 251, 106, 246, 112, 248, 116, 245,       119, 244, 122, 244, 128, 252, 130, 255, 145, 255, 152, 255, 156, 255, 158, 251, 156, 245, 148,     244, 138, 244, 128, 243, 129, 237, 131, 237, 135, 234, 140, 231, 146, 229, 149, 228, 155, 231, 
                156, 234, 164, 234, 168, 234, 177, 234, 183, 235, 186, 231, 192, 232, 195, 236, 195, 239, 202,     245, 210, 248, 204, 252, 198, 260, 190, 267, 182, 271, 176, 278, 173, 283, 166, 277, 164, 283, 
                    163, 277, 160, 271, 160, 264, 155, 262, 148, 257, 142, 259, 138, 259, 135, 260, 129, 263, 124,     264, 124, 267, 124, 273, 120, 269, 120, 274, 117, 275, 111, 273, 106, 271"),
            14 => array("name"=>"台南縣",
            "englishname"=>"Tainan",
            "url" => "http://",
            "coords"=>"105, 276, 101, 296, 101, 299, 103, 310, 107, 307, 111, 307, 114, 306, 115, 309, 117, 310, 120, 310, 126, 312, 130, 312, 134, 312, 134, 317, 134, 320, 130, 320, 126, 320, 123, 320, 119, 322, 125, 325, 128, 328, 132, 328, 137, 328, 143, 328, 145, 323, 145, 321, 147, 320, 149, 317, 155, 317, 157, 312, 159, 308, 162, 305, 164, 300, 170, 294, 174, 291, 174, 287, 170, 285, 168, 285, 164, 285, 162, 284, 159, 278, 159, 274, 159, 268, 154, 265, 149, 262, 147, 262, 143, 261, 137, 261, 132, 261, 130, 264, 126, 266, 124, 267, 124, 272, 123, 275, 119, 274, 119, 276, 119, 278, 116, 278, 114, 278, 106, 276"),
            15 => array("name"=>"台南市",
            "englishname"=>"Tainan city",
            "url" => "http://",
            "coords"=>"103, 311, 107, 309, 111, 307, 113, 308, 116, 308, 117, 310, 120, 311, 124, 311, 128, 311, 135, 312, 134, 320, 127, 319, 118, 326, 107, 320"),//no
            16 => array("name"=>"高雄縣",
            "englishname"=>"Kaohsiung",
            "url" => "http://",
            "coords"=>"117, 330, 119, 326, 133, 330, 142, 329, 144, 325, 146, 324, 148, 318, 154, 317, 157, 313, 173, 293, 175, 286, 181, 277, 189, 272, 197, 264, 203, 259, 209, 253, 221, 254, 223, 255, 217, 258, 218, 263, 224, 264, 225, 267, 215, 275, 209, 284, 209, 288, 208, 306, 203, 313, 202, 318, 206, 326, 201, 324, 195, 329, 190, 326, 186, 329, 182, 325, 178, 327, 173, 326, 164, 335, 154, 335, 154, 339, 154, 360, 154, 365, 155, 369, 150, 381, 145, 378, 148, 376, 149, 373, 145, 367, 142, 367, 142, 361, 140, 357, 143, 350, 139, 345, 135, 347, 129, 345, 129, 349, 118, 330"),
            17 => array("name"=>"高雄市",
            "englishname"=>"Kaohsiung",
            "url" => "http://",
            "coords"=>"119, 358, 129, 358, 132, 354, 132, 349, 137, 350, 139, 349, 143, 350, 139, 357, 143, 359, 141, 367, 140, 367, 144, 371, 146, 375, 147, 376, 144, 378, 135, 367, 119, 367, 119, 358"),//no
            18 => array("name"=>"屏東縣",
            "englishname"=>"Pingtung",
            "url" => "http://",
            "coords"=>"151, 384, 155, 369, 153, 365, 154, 339, 162, 339, 172, 330, 176, 332, 180, 330, 183, 333, 189, 331, 194, 334, 200, 329, 206, 332, 210, 338, 210, 346, 200, 352, 193, 370, 199, 385, 199, 396, 204, 397, 207, 405, 208, 409, 216, 409, 221, 415, 221, 427, 222, 431, 222, 433, 219, 439, 220, 446, 220, 453, 216, 453, 209, 448, 207, 452, 201, 447, 196, 441, 198, 434, 198, 429, 191, 420, 185, 410, 174, 399, 164, 393, 160, 387, 154, 387, 153, 385"),
            19 => array("name"=>"澎湖縣",
            "englishname"=>"Penghu",
            "url" => "http://",
            "coords"=>"0, 202, 46, 302"),
            20 => array("name"=>"南投縣",
            "englishname"=>"Nantou",
            "url" => "http://",
            "coords"=>"164, 176, 174, 179, 183, 179, 191, 165, 200, 166, 202, 163, 209, 164, 211, 161, 216, 162, 216, 159, 222, 156, 222, 154, 227, 154, 234, 149, 241, 157, 256, 159, 256, 164, 247, 174, 251, 183, 249, 191, 243, 204, 247, 210, 245, 225, 240, 227, 240, 236, 231, 238, 225, 246, 209, 245, 200, 243, 195, 238, 195, 235, 189, 230, 183, 229, 183, 226, 176, 227, 169, 226, 169, 212, 174, 209, 174, 206, 169, 203, 164, 200, 164, 182, 164, 174"),
            21 => array("name" => "宜蘭縣",
            "englishname" => "Yilan",
            "url" => "http://",
             "coords"=> "328, 47, 324, 47, 319, 48, 317, 51, 313, 53, 313, 56, 312, 59, 308, 59, 306, 59, 304, 60, 302, 62, 297, 63, 284, 74, 281, 78, 281, 82, 277, 84, 272, 87, 267, 87, 264, 90, 263, 96, 262, 99, 261, 102, 261, 106, 257, 110, 255, 110, 250, 116, 255, 121, 255, 124, 261, 126, 265, 126, 272, 126, 278, 128, 285, 130, 289, 130, 295, 127, 302, 128, 308, 129, 312, 129, 312, 126, 317, 117, 317, 109, 320, 109, 320, 100, 323, 96, 318, 91, 317, 86, 317, 78, 317, 70, 319, 60, 326, 52"),
            22 => array("name"=>"花蓮縣",
            "englishname"=>"Hualien",
            "url" => "http://",
            "coords"=>"268, 129, 280, 130, 285, 132, 288, 134, 294, 130,299, 130, 310, 133, 311, 137, 299, 146, 299, 154, 297, 163, 298, 170, 294, 179, 287, 226, 283, 
                233, 285, 239, 288, 242, 281, 241, 272, 244, 272, 248, 265, 272, 261, 281, 246, 274, 242, 274,     226, 263, 226, 258, 219, 256, 218, 252, 226, 251, 223, 246, 228, 236, 239, 234, 238, 226, 244,     224, 250, 208, 245, 207, 243, 202, 250, 189, 250, 178, 249, 173, 257, 163, 256, 158, 260, 154, 
                    256, 141, 267, 129"),
            23 => array("name"=>"台東縣",
            "englishname"=>"Taitung",
            "url" => "http://",
            "coords"=>"287, 249, 283, 247, 274, 250, 274, 255, 263, 286, 259, 286, 257, 285, 251, 282, 246, 281, 241, 279, 238, 277, 235, 275, 230, 270, 226, 269, 218, 275, 212, 279, 210, 286, 210, 294, 210, 298, 210, 306, 203, 313, 203, 321, 208, 326, 212, 334, 212, 341, 213, 342, 208, 345, 205, 348, 202, 352, 201, 358, 196, 366, 199, 377, 202, 383, 201, 392, 208, 394, 210, 401, 219, 406, 219, 403, 221, 395, 224, 391, 228, 383, 228, 374, 228, 365, 235, 358, 239, 357, 243, 347, 246, 340, 254, 334, 257, 326, 260, 322, 266, 318, 268, 312, 273, 303, 275, 300, 278, 294, 280, 293, 280, 286, 280, 278, 282, 271, 285, 262, 287, 254, 287, 249"),
            24 => array("name"=>"金門縣",
            "englishname"=>"Kinmen",
            "url" => "http://",
            "coords"=>"9, 132, 7, 142, 17, 142, 19, 146, 19, 160, 46, 159, 40, 142, 45, 139, 43, 133, 45, 127, 35, 123, 28, 132, 19, 127, 17, 132, 9, 132"),
            25 => array("name"=>"連江縣",
            "englishname"=>"Lienchiang",
            "url" => "http://",
            "coords"=>"40, 51, 28, 58, 33, 61, 33, 73, 19, 79, 16, 78, 13, 85, 13, 91, 19, 94, 19, 103, 44, 102, 40, 91, 33, 81, 40, 69, 56, 66, 53, 53, 40, 51")
            
        ); 

        foreach($city as $key=>$value)
        {
          $sql = "SELECT town, doc, url 
            FROM docs
            WHERE city_cd = " . $key;
	  $result = db_query($sql);
	
                $town = $doc = $url = array();
          while( $result->fetchInto($row, DB_FETCHMODE_ASSOC) )
          {
                array_push($town ,$row['town']);
                array_push($doc ,$row['doc']);
                array_push($url ,$row['url']);
	  }       
          $city[$key] = array_merge($city[$key],
            array('town'=>$town),
            array('doc'=>$doc),
            array('doc_url'=>$url)
          );
        } 

        $tpl->assign("city",$city);
	$tpl->display("main.php.reduce");
?>
