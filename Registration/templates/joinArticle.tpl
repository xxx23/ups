<!--
FILE:   joinArticle.tpl
DATE:   2009/05/25
AUTHOR: tgbsa
加入會員條款
-->
{literal}
<script type="text/javascript">
  function notAgree(){
     alert('您必須同意服務平台之規範條款，才可加入其會員');
     window.close();
   } 

  function Agree(){
  {/literal}
    {if $role eq 0}
      document.location="joinArticle.php?agree=1&t=0"; 
    {elseif $role eq 1}
      document.location="joinArticle.php?agree=1&t=1";
    {/if}
  {literal}
  }

</script>
{/literal}

<html>
<head>
<title>會員規範條款</title>
<meta http-equiv="Content-Type" content="text/html;">
<!--Fireworks MX 2004 Dreamweaver MX 2004 target.  Created Mon Jul 27 16:12:52 GMT+0800 2009-->
</head>
<body bgcolor="#ffffff">
<table width="669" border="0" align="center" cellpadding="0" cellspacing="0">
<!-- fwtable fwsrc="¥¼©R¦W" fwbase="001.jpg" fwstyle="Dreamweaver" fwdocid = "2142844055" fwnested="0" -->
  <tr>
   <td><img src="../images/registration/spacer.gif" width="6" height="1" border="0" alt=""></td>
   <td><img src="../images/registration/spacer.gif" width="23" height="1" border="0" alt=""></td>
   <td><img src="../images/registration/spacer.gif" width="607" height="1" border="0" alt=""></td>
   <td><img src="../images/registration/spacer.gif" width="7" height="1" border="0" alt=""></td>
   <td><img src="../images/registration/spacer.gif" width="22" height="1" border="0" alt=""></td>
   <td><img src="../images/registration/spacer.gif" width="4" height="1" border="0" alt=""></td>
  </tr>

  <tr>
   <td colspan="6"><img name="n001_r1_c1" src="../images/registration/001_r1_c1.jpg" width="669" height="5" border="0" alt=""></td>
  </tr>
  <tr>
   <td><img name="n001_r2_c1" src="../images/registration/001_r2_c1.jpg" width="6" height="36" border="0" alt=""></td>
   <td><img name="n001_r2_c2" src="../images/registration/001_r2_c2.jpg" width="23" height="36" border="0" alt=""></td>
   <td><img name="n001_r2_c3" src="../images/registration/001_r2_c3_v2.gif" width="607" height="36" border="0" alt=""></td>
   <td><img name="n001_r2_c4" src="../images/registration/001_r2_c4.jpg" width="7" height="36" border="0" alt=""></td>
   <td><img name="n001_r2_c5" src="../images/registration/001_r2_c5.jpg" width="22" height="36" border="0" alt=""></td>
   <td><img name="n001_r2_c6" src="../images/registration/001_r2_c6.jpg" width="4" height="36" border="0" alt=""></td>
  </tr>
  <tr>
   <td><img name="n001_r3_c1" src="../images/registration/001_r3_c1.jpg" width="6" height="7" border="0" alt=""></td>
   <td rowspan="2" background="../images/registration/001_r3_c2.jpg">&nbsp;</td>
   <td colspan="2" rowspan="2"><center><b>會員規範條款</b></center>
<div align="center">

   <table border=0>
     <tr>
       <textarea id="outlink" name="outlink" cols="55" rows="30" readonly="readOnly">
                      會員規範條款
    歡迎加入「教育部數位學習服務平台」（以下簡稱「本平台」），請於註冊成為本平台會員前，須詳細閱讀本會員規範條款所有內容，當您在點選「接受」鍵後，即表示您已經詳細閱讀並同意遵守以下規範條款：

一、會員規範

（一）您同意並保證在本平台之課程討論區及留言版內不公佈或傳送任何毀謗、不實、不雅、不法或侵害他人智慧財產權的文字、圖片或任何形式的檔案。

（二）您同意並保證不在本平台之課程討論區內以超連結方式提供非法音樂、圖片和電影之連結或下載。

（三）您同意於本平台之課程討論區及留言版內所轉載之文章或圖片，請盡量註明出處或先獲得原作者之同意後方能張貼，如原作者向本平台抗議，經查證無誤後，本平台保有對該文章或圖片刪除之權利。

（四）您同意避免在本平台之課程討論區內及留言版討論私人事務，並於發表文章時，尊重他人的權益及隱私權。

（五）您同意不在本平台之課程討論區及留言版內從事廣告或販賣商品之行為。

（六）您同意遵守、台灣學術網路使用規範及相關管理公約以及一切國際網際網路規定與慣例，會員如違反法律規定之情事，需應自行負擔法律上之責任。

（七）若當本平台認定您的行為已違反會員規範條款或任何法令時，您同意本平台可隨時終止您會員資格及在平台內使用各項服務之權利。

（八）對於您所登錄之個人資料，同意本平台得於合理之範圍內使用該等資料，進行會員學習之資料統計或關於網路學習行為之調查或研究。本平台保證除配合法律調查之需求外，絕不會任意出售、交換、或出租任何關於您的個人識別資料給其他機關團體或個人。

（九）您同意本平台保留隨時修改本會員規範條款之權利，並於修改會員規範條款時，將於平台首頁公告修改之內容，但不另作會員之個別通知。

（十）您瞭解本平台完全未對本服務內容加以事先審查，對會員的使用行為於技術上也無法進行全面控制，您使用任何內容時，包括依賴前述內容之正確性、完整性或實用性時，您同意將自行加以判斷並承擔所有風險，而不依賴於本平台。但本平台及其指定人有權（但無義務）依其自行之考慮，得拒絕和刪除可經由本服務提供之違反本條款的內容。您瞭解並同意，如本平台依據法律法規的要求，或基於誠信為了以下目的或在合理必要範圍內，認定必須將內容加以保存或揭露時，得加以保存或揭露：

1.遵守法律程序
2.執行本服務條款
3.回應任何第三人提出的權利主張
4.保護本平台、其用戶及公眾之權利、財產或個人安全
5.其他本平台認為有必要的情況。

二、隱私權

    您所提供的登記資料及本平台保留的有關您的若干其他資料，將受到我國有關隱私權保護及本平台《隱私權政策》之規範。請參閱以下網站隱私權政策；您個人的隱私權，本平台絕對尊重並予以保護。請務必詳細閱讀下列資訊，瞭解本平台如何蒐集、應用及保護您所提供的個人資訊。
以下的隱私權政策，適用於您在本平台活動時，所涉及的個人資料蒐集、運用與保護，且亦適用於本平台所提供之單一帳號密碼簽入功能，但不適用於與本平台功能鏈結之其他網站。
如果您不同意隱私權政策之內容，或者您所屬的國家或地方排除隱私權政策內容之一部或全部時，請您立即停止使用本平台。

（一）個人資料之蒐集
    當您註冊加入本平台後，平台會請您提供個人隱私資訊。另外，本平台將保留您在上網瀏覽或查詢時，伺服器自行產生的相關記錄，包括但不限於您的 IP 地址、停留時間、瀏覽網頁及及點選資料紀錄等。除非您願意告知他人您的個人資料或是違反會員註冊同意事項、本平台使用規定或中華民國相關法令，否則本平台不會將此項紀錄提供他人。

（二）本平台資料庫搜集上述資料之運用政策
    本平台不會任意出售、交換、或出租任何您的個人資料給其他團體或個人。只有在以下狀況，本平台會在「隱私權保護政策」原則之下，運用您的個人資料。

1.提供其他服務
    日後若為了提供您其他服務，需要與提供該服務之第三者共用您的資料時，本平台在提供其他服務時會充分說明，並且在資料收集之前通知您，您可以自由選擇是否接受該項特定服務或優惠。

2.統計與分析
    本平台根據使用者註冊、問卷調查，對使用者的人數、興趣和行為進行內部研究。此研究是根據全體使用者的資料進行統計分析與整理，做為本平台提升服務品質之參考，不會對各別使用者進行分析，亦不會提供特定對象個別資料之分析報告。

3.配合司法調查
    司法單位因公眾安全，要求本平台公開特定個人資料時，本平台將視司法單位合法正式的程序，以及對本資訊網所有使用者安全考量下做可能必要之配合。

（三）修改個人帳號資料及相關設定的權利
    本平台賦予您在任何時候修改個人帳號資料及任何相關設定的權利，但是當您的行為違反使用規範時或是法律規定時不在此限。

（四）自我保護措施
    請妥善保管您的密碼及或任何個人資訊，不要將任何個人資訊，尤其是密碼提供給任何人。在您欲離開電腦前或不再使用本平台的服務時，務必記得登出(Log-out)會員帳號，若您是與他人共用電腦或使用公共電腦，切記要關閉瀏覽器視窗，以防止他人讀取您的個人資料或信件。 

（五）隱私權保護政策修訂
    本平台會不定時修訂本項政策，以符合最新之隱私權保護規範。當我們在使用個人資料的規定做較大幅度修改時，我們會在網頁上張貼告示，通知您相關修訂事項。

三、責任規範

（一）本平台無法控制經由本服務傳送之內容，因此不保證內容的正確性、完整性或具有相當品質。您已預知使用本服務時，可能會接觸到令人不快、不適當或令人厭惡之內容。在任何情況下，本平台均不為任何內容負責，包含但不限於任何內容之任何錯誤或遺漏。但本平台有權依法停止傳輸任何前述內容並採取相應行動，包括但不限於暫停用戶使用本服務的全部或部分，保存有關記錄，並向有關機關報告以及協助其調查。

（二）您同意如因本平台出現中斷或故障等現象，而造成使用者使用上的不便、資料喪失、錯誤、或其他損害時，本平台及其管理者毋須負任何法律責任。

（三）由於您通過本服務所提供、張貼或傳送之內容，違反本服務條款、或您侵害他人任何權利因而衍生或導致任何第三人提出任何索賠或請求，包括但不限於合理的律師費，您同意賠償本平台，並使其免受損害。

（四）本服務或第三人可提供與其他網際網路上之網站或資源之連結。由於本平台無法控制這些網站及資源，您瞭解並同意，此類網站或資源是否可供利用，本平台不予負責，存在或源於此類網站或資源之任何內容、廣告、產品或其他資料，本平台亦不予保證或負責。因使用或依賴任何此類網站或資源或經由此類網站或資源獲得的任何內容、商品或服務所產生的任何損害或損失，本平台不負任何直接或間接之責任。

（五）本服務條款的任何規定不會免除本平台依照法律規定，或因故意或重大過失造成您損失的任何責任。

（六）您使用本服務之風險由您個人負擔。本服務係依「現狀」及「現有」基礎提供。本平台對本服務不提供任何明示或默示的擔保或保證，包含但不限於特定目的之適用性、一定品質及未侵害他人權利等擔保或保證。

（七）是否經由本服務連至外部網站進行下載或取得任何資料應由您自行考慮且自負風險，因任何資料之下載而導致的您電腦系統之任何損壞或資料流程失等後果由您自行承擔，而與本平台無涉。

（八）本平台不保證以下事項：
1.  本平台之服務將符合您的要求。
2.  本平台之服務將不受干擾、及時提供、安全可靠或沒有任何錯誤及問題。
3.  使用本平台服務取得之結果正確可靠。
4.  您經由本服務取得之任何資訊符合您的期望。
5.  本服務軟體中任何錯誤都將得到更正。

四、個人資料保護法

 請參閱連結：
   http://www.moj.gov.tw/lp.asp?ctNode=28007&CtUnit=805&BaseDSD=7&mp=001
       
       </textarea>
       <br><a href="http://www.moj.gov.tw/lp.asp?ctNode=28007&CtUnit=805&BaseDSD=7&mp=001">個人資料保護法連結</a></br>

     </tr>	
     <tr>
         <td align="center"><input type="button" class="btn" value="接受" size="30" onClick="Agree()"></td>
         <td align="center"><input type="button" class="btn" value="不接受" onClick="notAgree();"></td>
     </tr>
  </table>
</div> </td>
   <td colspan="2" rowspan="2" background="../images/registration/001_r3_c5.jpg"><img name="n001_r3_c6" src="../images/registration/001_r3_c6.jpg" width="4" height="7" border="0" alt=""></td>
  </tr>
  <tr>
   <td rowspan="3">&nbsp;</td>
  </tr>
  <tr>
   <td><img name="n001_r5_c2" src="../images/registration/001_r5_c2.jpg" width="23" height="21" border="0" alt=""></td>
   <td colspan="2" background="../images/registration/001_r5_c4.jpg"><img name="n001_r5_c4" src="../images/registration/001_r5_c4.jpg" width="7" height="21" border="0" alt=""></td>
   <td><img name="n001_r5_c5" src="../images/registration/001_r5_c5.jpg" width="22" height="21" border="0" alt=""></td>
   <td><img name="n001_r5_c6" src="../images/registration/001_r5_c6.jpg" width="4" height="21" border="0" alt=""></td>
  </tr>
  <tr>
   <td colspan="5">&nbsp;</td>
  </tr>
</table>
</body>
</html>

