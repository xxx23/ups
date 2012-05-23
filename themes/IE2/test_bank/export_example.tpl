<html>
<head>
<title>匯入範例</title>
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="{$webroot}script/prototype.js"></script>
<script type="text/javascript" src="{$webroot}script/test_bank/import.js"></script>
<script type="text/javascript" src="{$webroot}script/test_bank/test_related.js"></script>
</head>

<body class="ifr">
<div class="searchlist">
    1.匯入檔案必須為rar壓縮檔
</div>
<div class="searchlist">

    2.壓縮檔檔名請取為英文檔名
</div>
<div class="searchlist">
    3.檔案結構如範例檔:請把各檔直接壓縮，勿放入資料夾後再壓縮
</div>
<div class="searchlist">
    4.附圖檔名請命名為 題號_pic.附檔名  (ex: 1_pic.png)
</div>
<div class="searchlist">
    5.影片檔名請命名為 題號_av.附檔名 (ex: 2_av.mp4)
</div>
<div class="searchlist">
    <div class="button001">    
    <a href="./{$file_name}">下載範例檔</a>
    </div>
</div>

<a href="./test_bank.php"><img src="{$tpl_path}/images/icon/return.gif">返回</a>

<div class="searchbar" style="width:95%">
    <h2>範例檔內容說明</h2>
    <img src="../images/test_bank_format.png" alt="範例檔說明">
    <div class="describe"> 
    <ol> 
         <li>[題型]:分別有<b>選擇題、是非題、填充題、簡答題</b></li> 
         <li>[題目內容]:填入你要出的題目</li> 
         <li>[選項數]:選擇題填入選項數，填充題填入需填答案數，是非與簡答題填<b>0</b></li> 
         <li>[第*選項]:選擇題依照你的題數填入選項，填充題填入各空格答案，是非與選擇免填</li> 
         <li>[單複選]:除了選擇題希望出成複選題需填<b>複選</b>外，其餘填<b>單選</b></li> 
         <li>[答案]:單選填入答案為哪一選項(例:答案為選項二填入2)，<br/> 複選填入答案組以分號隔開(例:答案為選項二、三填入 2;3)<br/>是非題答案為是填1反之填0，其餘題型則不填</li> 
         <li>[詳解]:可以填入題目詳細解釋</li> 
         <li>[題目難易]:題目難度需填入<b>易、中、難</b>三個等級其中之一</li> 
         <li>[順序性]:填充題如果答案有順序性則填依序，其餘填不依序</li> 
         <li>[圖片檔名]:填入該題對應圖檔的檔名，如無圖檔則不填(如有圖檔需加入欲上傳的壓縮包內)</li> 
         <li>[影音檔名]:填入該題對應的影片或音樂檔名，如無影音則不填(如有影音檔需加入欲上傳的壓縮包內)</li> 

    </ol> 
    </div> 
</div>

</body>

</html>
