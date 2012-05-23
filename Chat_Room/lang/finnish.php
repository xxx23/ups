<?PHP
/////////////////////////////////////////////////////////////// 
//
//		X7 Chat Version 2.0.0
//		Released July 27, 2005
//		Copyright (c) 2004-2005 By the X7 Group
//		Website: http://www.x7chat.com
//
//		T�m� on ilmainen ohjelma. Voit
//		muokata ja/tai jakaa sit� mukana olevien 
//		X7 Groupin lisenssiehtojen mukaisesti.
//  
//		K�ytt�m�ll� t�t� ohjelmaa suostut	     
//		ehtoihimme, jotka ovat n�ht�viss� mukana 
//		tulevassa tiedostossa "license.txt".  Jos et saanut
//		t�t� tiedostoa, vieraile nettisivullamme
//		ja hanki virallinen kopio X7 Chatista.
//		
//		T�m�n copyrightin ja/tai mink� tahansa
//		X7 Groupin tai X7 Chatin copyrightin poistaminen 
//		mist� tahansa t�m�n ohjelman tiedostosta
//		on kielletty� ja poistaminen p��tt�� oikeutesi k�ytt��
//		t�t� ohjelmaa.
//	
////////////////////////////////////////////////////////////////EOH
?><?PHP

$language_iso = "iso-8859-1";	// Jos tarvitset apua, l�het� s�hk�postia webmaster@x7chat.com niin annan kielellesi oikean arvon

// Huom:
//	Jos tarvitset apua jonkin k��nt�misess�, meilaa minulle niin yrit�n parhaani.  Mieluummin 
//	vastaanotan s�hk�postia kuin arvailen mit� se on.
//
//	"<br>" lis�� rivinvaihdon. Voit lis�t� <br>� mutta j�t� sinne ne jotka siell� jo on.
//	"<b>" muuttaa tekstin lihavoiduksi kunnes kirjoitat "</b>" joka lopettaa tekstin lihavoinnin.
//	"<i>" kursivoi tekstin kunnes kirjoitat "</i>" joka lopettaa tekstin kursivoinnin.

$txt[0] = "Kirjaudu sis��n";
$txt[1] = "Anna k�ytt�j�tunnus ja salasana";
$txt[2] = "K�ytt�j�tunnus";
$txt[3] = "Salasana";
$txt[4] = "&nbsp;&nbsp; Kirjaudu &nbsp;&nbsp;";	// "&nbsp;" on sama kuin tyhj� v�li
$txt[5] = "L�het� salasana";
$txt[6] = "Rekister�idy";
$txt[7] = "Tilastot";
$txt[8] = "K�ytt�ji� palvelussa";
$txt[9] = "Huoneiden lukum��r�";
$txt[10] = "Rekister�ityneet k�ytt�j�t";
$txt[11] = "Online k�ytt�j�t";
$txt[12] = "Tulevat tapahtumat";
$txt[13] = "Antamasi salasana tai k�ytt�j�tunnus on virheellinen";
$txt[14] = "Virhe";

$txt[15] = "Sori, yll�pito on poistanut rekister�innin";
$txt[16] = "Kirjaudu ulos";
$txt[17] = "Olet kirjautunut ulos.";
$txt[18] = "Rekister�idy";
$txt[19] = "T�yt� t�m� rekister�intilomake, kaikki tiedot ovat pakollisia.";
$txt[20] = "S�hk�posti";
$txt[21] = "Salasana uudelleen";
$txt[22] = "Voit lis�t� tietoja profiiliisi rekister�innin j�lkeen";
$txt[23] = "Virheellinen k�ytt�j�tunnus, k�ytt�j�tunnuksesi voi sis�lt�� kirjaimia ja numeroita mutta ei v�lej�, pilkkuja, pisteit�, heittomerkkej�, lainausmerkkej� tai puolipisteit�.  K�ytt�j�tunnuksesi pit�� olla alle _n merkki� pitk�.";		// _n on enimm�ismerkkim��r�
$txt[24] = "Anna toimiva s�hk�postiosoite.";
$txt[25] = "Anna salasana.";
$txt[26] = "Antamasi salasana ei t�sm��.";
$txt[27] = "Sori, k�ytt�j�tunnus on jo k�yt�ss�, palaa takaisin ja valitse joku toinen.";
$txt[28] = "K�ytt�j�tilisi on luotu, <a href=\"./index.php\">Paina t�st�</a> kirjautuaksesi sis��n.";

$txt[29] = "Huonelista";
$txt[30] = "K�ytt�j�t";
$txt[31] = "Nimi";
$txt[32] = "Aihe";

$txt[34] = "Apua";
$txt[35] = "Hallinta";
$txt[36] = "Asennetut teemat";
$txt[37] = "Hallinta (Yll�pito)";

$txt[38] = "Sori, tuntematon kehys!";
$txt[39] = "Sori, yll�pito on sulkenut huoneen!";

$txt[40] = "Tila";
$txt[41] = "Huoneen hallinta";

$txt[42] = "Et voi l�hett�� viesti� t�h�n huoneeseen ellei valvoja anna sinulle ��nioikeutta.";
$txt[43] = "on saapunut huoneeseen";
$txt[44] = "on poistunut huoneesta";

$txt[45] = "Sivua ei voi n�ytt��, sivua ei ole.";
$txt[55] = "Oletus";
$txt[56] = "Lis��";
$txt[57] = "Valitse fontti:";

$txt[58] = "Mink� kokoisen fontin haluaisit?";
$txt[59] = "Luo huone";
$txt[60] = "Sinulla ei ole lupaa luoda uutta huonetta.";
$txt[61] = "Huoneen nimi";
$txt[62] = "T�yt� t�m� lomake luodaksesi uuden huoneen";
$txt[63] = "Luo";
$txt[64] = "Huoneen tyyppi";
$txt[65] = "Aihe";
$txt[66] = "Tervehdys";
$txt[67] = "Enimm�isk�ytt�j�m��r�";
$txt[68] = "Julkinen";
$txt[69] = "Yksityinen";
$txt[70] = "Moderoitu";
$txt[71] = "Vanhentumaton";
$txt[72] = "Virheellinen huoneen nimi, huoneen nimess� voi olla kirjaimia ja numeroita mutta ei pisteit�, pilkkuja, heittomerkkej�, t�hti� tai puolipisteit�.";
$txt[73] = "Tuntematon huonetyyppi";
$txt[74] = "Et voi luoda yksityishuoneita";
$txt[75] = "Huoneesi on luotu";
$txt[76] = "Huonenimi on jo k�yt�ss�, valitse joku toinen";
$txt[77] = "Takaisin";
$txt[78] = "Salasana vaaditaan";
$txt[79] = "T�m� huone on salasanasuojattu. Anna salasana.";
$txt[80] = "T�m� huone on t�ynn�";
$txt[81] = "T�ysi� huoneita ei n�ytet�";
$txt[82] = "N�yt� t�ydet huoneet";
$txt[83] = "T�ydet huoneet ovat n�kyviss�";
$txt[84] = "Piilota t�ydet huoneet";
$txt[85] = "Profiili";
$txt[86] = "Toiminta";
$txt[87] = "Koko profiili";
$txt[88] = "Yksityinen keskustelu";
$txt[89] = "L�het� s�hk�postia";
$txt[90] = "P�ivitet��n....";

$txt[91] = "Torju";
$txt[92] = "Salli";
$txt[93] = "Vaienna";
$txt[94] = "Anna Opit";
$txt[95] = "Ota Opit";
$txt[96] = "Poista vaiennus";
$txt[97] = "Potkaise";
$txt[98] = "N�yt� IP";
$txt[99] = "Anna ��ni oikeus";
$txt[100] = "Ota ��ni oikeus";

$txt[101] = "K�ytt�j� on torjuttu.";
$txt[102] = "K�ytt�j� on taas sallittu.";
$txt[103] = "Valitse k�ytt�j�";
$txt[104] = "Sinulla ei ole lupaa suorittaa t�t� toimintoa loppuun";
$txt[105] = "K�ytt�j�lle on annettu Opit";
$txt[106] = "K�ytt�j�n Opit on peruutettu";
$txt[107] = "T�m�n k�ytt�j�n IP osoite on: ";
$txt[108] = "Anna syy t�m�n k�ytt�j�n potkaisemiselle:";
$txt[109] = "K�ytt�j� on potkaistu huoneesta, eik� voi palata 60 sekuntiin.";
$txt[110] = "_u on potkaistu _r";	// _u korvataan k�ytt�j�nimell� ja _r korvataan syyll�

$txt[111] = "T�m� k�ytt�j� on vaiennettu.";
$txt[112] = "T�m� k�ytt�j� ei ole en�� vaiennettu.";
$txt[113] = "T�m� k�ytt�j� on saanut ��nenoikeuden.";
$txt[114] = "T�m�n k�ytt�j�n ��nioikeus on otettu pois.";

$txt[115] = "Sinut on potkaistu t�st� huoneesta koska _r";	// _r korvataan potkun syyll�
$txt[116] = "Sinut on bannattu t�st� huoneesta koska _r";	// _r korvataan bannin syyll�
$txt[117] = "Sinut on bannattu t�lt� palvelimelta koska _r";	// _r korvataan bannin syyll�
$txt[118] = "Sinut on poistettu t�st� huoneesta, <a href='./index.php'>klikkaa t�st�</a> palataksesi huonelistalle ja valitaksesi toisen huoneen.";

$txt[119] = "N�yt� profiili";
$txt[120] = "(piilotettu)";
$txt[121] = "Sijainti";
$txt[122] = "Harrastukset";
$txt[123] = "K�ytt�j�ryhm�";
$txt[124] = "Bio";
$txt[125] = "Avatar-kuva";

$txt[126] = "_u on nyt Chat Huone Operaattori";		// _u k�ytt�j� josta tehtiin operaattori.
$txt[127] = "_u ei ole en�� Chat Huone Operaattori";		// _u k�ytt�j� jonka oikeudet poistettiin.
$txt[128] = "Valitse v�ri";		
$txt[129] = "_u on saanut ��nenoikeuden";		// _u k�ytt�j� jolle annettiin ��ni.
$txt[130] = "_us ��nioikeus on otettu pois";		// _u k�ytt�j� jonka ��ni poistettiin.
$txt[131] = "_u on vaiennettu";		// _u k�ytt�j� joka vaiennettiin.
$txt[132] = "_u ei ole en�� vaiennettu";		// _u k�ytt�j� jonka vaiennus poistettiin.
$txt[133] = "Sulje";		
$txt[134] = "Viestisi v�ri on p�ivitetty.";		
$txt[135] = "K�ytt�j�n hallintapaneeli";
$txt[136] = "Tervetuloa hallintapaneeliisi. T��ll� voit muuttaa asetuksiasi, l�hett�� viestej� ja muokata chattia.";

$txt[137] = "Etusivu";
$txt[138] = "Profiili";
$txt[139] = "Asetukset";
$txt[140] = "Tila";
$txt[141] = "Blokkilista";
$txt[142] = "Offline viestit";
$txt[143] = "Sanasuodatin";
$txt[144] = "Avainsanat";
$txt[145] = "Seuraavat sanat on suodatettu, klikkaa sanaa poistaaksesi sen.";

$txt[146] = "T�m�n hetkinen tilasi";
$txt[147] = "Aseta tila";
$txt[148] = "Tilasi on muutettu";
$txt[149] = "Poissa";
$txt[150] = "Paikalla";
$txt[151] = "Palaan pian";
$txt[152] = "Palaan my�hemmin";
$txt[153] = "Oma tila";
$txt[154] = "Muuta";
$txt[155] = "Kirjainten enimm�ism��r�";
$txt[156] = "Seuraavat k�ytt�j�t on torjuttu, klikkaa salliaksesi heid�t.";
$txt[158] = "_u on poistettu blokkilistaltasi.";	// _u korvataan k�ytt�j�nimell�
$txt[159] = "Torju k�ytt�j�";
$txt[160] = "Lis��";
$txt[161] = "_u on lis�tty blokkilistallesi.";	// _u korvataan k�ytt�j�nimell�
$txt[162] = "_w on suodatettu.";		// _w korvataan sanalla joka suodattui
$txt[163] = "_w ei en�� suodateta.";		// _w korvataan sanalla josta suodatus poistettiin
$txt[164] = "Suodata sana";
$txt[165] = "Teksti";
$txt[166] = "Korvaava";
$txt[167] = "Avainsana-asetuksesi on p�ivitetty";
$txt[168] = "Avainsanat ovat erityisi� sanoja jotka muutetaan automaattisesti linkeiksi chat huoneeseen l�hetett�ess�.<Br><Br>Seuraavat ovat avainsanoja, klikkaa sanaa poistaaksesi sen.";		// <br> tarkoittaa ett� se menee uudelle riville, samoin kuin enter tekee
$txt[169] = "Lis�� avainsana";
$txt[170] = "URL";
$txt[171] = "Viestisi on l�hetetty.";
$txt[172] = "Alla ovat kaikki vastaanottamasi viestit.";
$txt[173] = "[Tyhj�]";
$txt[174] = "------- Alkuper�inen viesti -------";	
$txt[175] = "Poista";
$txt[176] = "VS: ";
$txt[177] = "Viesti on poistettu";
$txt[178] = "Aihe";
$txt[179] = "L�hett�j�";
$txt[180] = "P�iv�ys";
$txt[181] = "L�het�";
$txt[182] = "Vastaanottaja";
$txt[183] = "Aihe";
$txt[184] = "Viesti�si ei voitu l�hett�� koska vastaanottajan postilaatikko on t�ynn�.";
$txt[185] = "K�yt�ss�si on _p laatikkosi tilasta.  Sinulla on tilaa _n uudelle viestille.";	// _p on k�ytetty tila prosentteina ja _n on laatikkoon viel� mahtuvien viestien m��r�
$txt[186] = "Sukupuoli";
$txt[187] = "P�ivit�";
$txt[188] = "Profiilisi on p�ivitetty.";

$txt[189] = "Mies";
$txt[190] = "Nainen";
$txt[191] = "------";

$txt[192] = "Upload";
$txt[193] = "Voit k�ytt�� t�t� lomaketta ladataksesi avatar-kuvan. Voit pit�� palvelimella vain yht� avatar-kuvaa kerrallaan.
Avatar-kuvasi pit�� olla .gif, .png tai .jpeg muodossa ja sen pit�� olla kooltaan alle _b bitti�. Kuvasi tulee olla  _d pikseli�.";		// _b korvataan bittirajalla ja _d korvataan kokorajalla jonka yll�pito on m��ritt�nyt

$txt[194] = "Avatar-kuvasi on ladattu onnistuneesti ja profiilisi on p�ivitetty.";
$txt[195] = "Avatar-kuvan lataus on poistettu k�yt�st�.";
$txt[196] = "Tiedoston koko on liian suuri.";
$txt[197] = "Avatar-kuvasi tiedostomuotoa ei tunnistettu. Muuta kuvasi PNG, GIF tai JPEG muotoon.";
$txt[198] = "Kuvan lataus on k�yt�ss� mutta yll�pito ei ole antanut kuvahakemistoon kirjoitusoikeuksia. Ota yhteytt� yll�pitoon ja ilmoita ongelmasta. Kuvaasi ei ladattu.";

$txt[199] = "Keskusteluaika (tuntia)";
$txt[200] = "P�ivitysv�li (sekuntia)";
$txt[201] = "Aikaero (tuntia)";
$txt[202] = "Aikaero (minuuttia)";
$txt[203] = "Skin";
$txt[204] = "Kieli";
$txt[205] = "Poista tyylit k�yt�st�";
$txt[206] = "Poista hymi�t k�yt�st�";
$txt[207] = "Poista ��net k�yt�st�";
$txt[208] = "Poista aikaleimat";
$txt[209] = "Piilota s�hk�posti";
$txt[210] = "Asetuksesi on p�ivitetty";

$txt[211] = "Tuntematon komento";
$txt[212] = "_u heitt�� _d _s-sivuista noppaa.";		// _u k�ytt�j�nimi, _d noppien m��r� ja _s sivujen lukum��r�
$txt[213] = "Tulokset ovat:";
$txt[214] = "Tulokset modifioidaan numerolla _a.";	// _a numero jolla ne modifioidaan

$txt[215] = "P��sy ev�tty";
$txt[216] = "Sinulla ei ole valtuuksia tulla t�h�n osaan.";
$txt[217] = "T�ss� paneelissa voit muokata monia chat huoneesi asetuksia.";
$txt[218] = "Yleiset asetukset";
$txt[219] = "Operaattorilista";
$txt[220] = "��nilista";
$txt[221] = "Blokkilista";
$txt[222] = "Uusi Banni";
$txt[223] = "Syy";
$txt[224] = "K�ytt�j� / IP / s�hk�posti";
$txt[225] = "Pituus";
$txt[226] = "Ikuinen";
$txt[227] = "TAI";
$txt[228] = "Minuuttia";
$txt[229] = "Tuntia";
$txt[230] = "P�iv��";
$txt[231] = "Viikkoa";
$txt[232] = "Kuukautta";
$txt[233] = "Klikkaa k�ytt�j��, IPt� tai s�hk�postiosoitetta poistaakseni bannin";
$txt[234] = "Uusi banni on voimassa.";
$txt[235] = "Banni on poistettu.";
$txt[236] = "Seuraavilla k�ytt�jill� on operaattorioikeudet t�ss� huoneessa. Klikkaa k�ytt�j�� poistaaksesi operaattorioikeudet.";
$txt[237] = "Seuraavilla k�ytt�jill� on ��ni t�ss� huoneessa. Klikkaa k�ytt�j�� poistaaksesi ��nen.";
$txt[238] = "Seuraavat k�ytt�j�t on vaiennettu. Klikkaa k�ytt�j�� poistaaksesi vaiennuksen.";
$txt[239] = "Kyseist� k�ytt�j�� ei l�ytynyt.";
$txt[240] = "Logit";
$txt[241] = "Yksityisviestien logi";
$txt[242] = "Logi on k�yt�ss�";
$txt[243] = "Logi on poistettu k�yt�st�";
$txt[244] = "Ota logi k�ytt��n";
$txt[245] = "Poista logi k�yt�st�";
$txt[246] = "Logitiedoston koko: _s kb (_p)";		// _s on koko,_p on prosentti
$txt[247] = "Tyhj�� tilaa j�ljell�: _s kb (_p)";		// _s on j�ljell� oleva vapaa tila, _p on prosentti
$txt[248] = "Rajoittamaton";
$txt[249] = "Alla on login sis�lt�.";
$txt[250] = "Poista logi";
$txt[251] = "Valitse logi alapuolelta tarkastellaksesi sit�.";
$txt[252] = "Viesti�si ei l�hetetty, se oli liian pitk�.";
$txt[253] = "Taustakuva";
$txt[254] = "Logo";
$txt[255] = "Salasana muistutus";
$txt[256] = "Hei _u,\n\nVierailija jonka IP osoite on _i salasanasi vaihtoa _s Chatissa.\n\nUusi salasanasi on _p.\n\nKiitos,\n_s Tuki";			// Us "\n" enter/uusi rivi, _u k�ytt�j�nimi, _i IP, _s sivun nimi, _p uusi salasana
$txt[257] = "Anna k�ytt�j�tunnuksesi tai s�hk�postiosoitteesi saadaksesi uuden salasanan. Uusi salasana l�hetet��n tiedossamme olevaan osoitteeseen.";
$txt[258] = "Uusi salasanasi on l�hetetty.";
$txt[259] = "Uutta salasanaasi ei l�hetetty. K�ytt�j�tunnuksella tai s�hk�postiosoitteella ei l�ytynyt yht��n k�ytt�j�tili�.";
$txt[260] = "Uutta salasanaasi ei l�hetetty. K�ytt�j�tili l�ytyi mutta tietokannassamme ei ole s�hk�postiosoitetta.";
$txt[261] = "Yll�pito on poistanut salasana muistutukset k�yt�st�.";
$txt[262] = "Uutiset";
$txt[263] = "Sorry, ongelmaasi ei l�ydy aihetta apuhakemistostamme.";
$txt[264] = "Huoneet vanhenevat automaattisesti: _t";		// _t on aika jonka j�lkeen ne vanhenevat
$txt[265] = "Ei koskaan";
$txt[266] = "";
$txt[267] = "Sinulla ei ole valtuuksia k�ytt�� t�t� komentoa.";
$txt[268] = "Toimintoa ei voitu suorittaa kyseisen k�ytt�j�n kohdalla.";
$txt[269] = "<b>Syntax:</b> /kick <i>k�ytt�j�nimi</i> <i>syy</i><Br>Komento poistaa k�ytt�j�n huoneesta.";
$txt[270] = "<b>Syntax:</b> /ban <i>k�ytt�j�nimi</i> <i>syy</i><Br>Poistaa k�ytt�j�n huoneesta ja est�� tulemasta takaisin.";
$txt[271] = "<b>Syntax:</b> /unban <i>k�ytt�j�nimi</i> <Br>Poistaa bannin.";
$txt[272] = "<b>Syntax:</b> /op <i>k�ytt�j�nimi</i> <Br>Antaa k�ytt�j�lle operaattorioikeudet.";
$txt[273] = "<b>Syntax:</b> /deop <i>k�ytt�j�nimi</i> <Br>Poistaa operaattorioikeudet.";
$txt[274] = "<b>Syntax:</b> /ignore <i>k�ytt�j�nimi</i> <Br>Blokkaa kaikki viestit kyseiselt� k�ytt�j�lt�.";
$txt[275] = "<b>Syntax:</b> /unignore <i>k�ytt�j�nimi</i> <Br>Poistaa blokin kyseiselt� k�ytt�j�lt�.";
$txt[276] = "Seuraavat henkil�t ovat chatissa kanssasi: ";
$txt[277] = "<b>Syntax:</b> /me <i>toiminto</i> <Br>Kertoo toisille k�ytt�jille suorittamasi <i>toiminnon</i>.";
$txt[278] = "<b>Syntax:</b> /admin <i>k�ytt�j�nimi</i> <Br>Antaa k�ytt�j�lle admin oikeudet.";
$txt[279] = "_u On nyt chat huone admin";	// _u on k�ytt�j�nimi
$txt[280] = "_u ei ole en�� chat huone admin";	// _u on k�ytt�j�nimi
$txt[281] = "<b>HEI!!</b>, Yritit juuri poistaa itselt�si admin oikeudet! Jos haluat jatkaa t�t� toimintoa, kirjoita /deadmin <i>oma k�ytt�j�nimesi</i> 1";
$txt[282] = "<b>Syntax:</b> /voice <i>k�ytt�j�nimi</i> <Br>Antaa k�ytt�j�lle ��nen ja oikeuden puhua moderoiduissa huoneissa.";
$txt[283] = "<b>Syntax:</b> /devoice <i>k�ytt�j�nimi</i> <Br>T�m� komento ottaa k�ytt�j�lt� ��nen jottei k�ytt�j� voisi en�� puhua moderoiduissa huoneissa.";
$txt[284] = "<b>Syntax:</b> /mute <i>k�ytt�j�nimi</i> <Br>T�m� komento est�� k�ytt�j�� l�hett�m�st� viestej� huoneeseen.";
$txt[285] = "<b>Syntax:</b> /unmute <i>k�ytt�j�nimi</i> <Br>Komento sallii vaiennetun k�ytt�j�n l�hett�� taas viestej� huoneeseen.";
$txt[286] = "<b>Syntax:</b> /wallchan <i>viesti</i> <Br>Komento l�hett�� viestej� kaikkiin huoneisiin.";
$txt[287] = "<a>[Paina t�st�]</a> avataksesi huoneen hallintapaneelin uuteen ikkunaan.";		// J�t� <a> ja </a> tagit rauhaan
$txt[288] = "<b>Syntax:</b> /log <i>toiminto</i> <Br>T�m� komento sallii sinun lopettaa, tarkastella kokoa, aloittaa ja tyhjent�� login.  <i>Toiminto</i> voi olla:<Br><b>Stop</b>: Lopettaa login<Br><b>Start</b>: Aloittaa login<br><b>Clear</b>: Tyhjent�� olemassa olevan login<Br><b>Size</b>: Kertoo kuinka paljon logista on k�ytetty";
$txt[289] = "Olet k�ytt�nyt _s KB  _m KB:n logitilastasi.";	// _s on k�ytt�m�si m��r� ja _m on paljonko voit k�ytt��
$txt[290] = "K�ytit mode komentoa v��rin.  <a>Paina t�st�</a> saadaksesi ohjeet sen k�ytt��n.";
$txt[291] = "";
$txt[292] = "Chatin keskeytys.";
$txt[293] = "_u on ottanut operaattoristatuksen pois kaikilta operaattoreilta.";		// _u on k�ytt�j�nimi
$txt[294] = "P�iv�n viesti on tyhj�.";	
$txt[295] = "<b>Syntax:</b> /userip <i>k�ytt�j�nimi</i> <Br>T�m� komento n�ytt�� kyseisen k�ytt�j�nimen IP osoitteen.";
$txt[296] = "_u on kutsunut sinut huoneeseen: _r";	// _u on kutsujan k�ytt�j�nimi ja _r on huone
$txt[297] = "<b>Syntax:</b> /invite <i>k�ytt�j�nimi</i> <Br>T�m� komento kutsuu k�ytt�j�n samaan huoneeseen jossa itse olet.";
$txt[298] = "<b>Syntax:</b> /join <i>huone</i> <Br>T�ll� komennolla p��set uuteen huoneeseen.";
$txt[299] = "<a>[Paina t�st�]</a> liitty�ksesi _r";	// j�t� <a> ja </a> rauhaan, _r on huone
$txt[300] = "Kyseist� huonetta ei ole olemassa.";
$txt[301] = "<a>[Paina t�st�]</a> luodaksesi sen.";	// j�t� <a> ja </a> rauhaan
$txt[302] = "<b>Syntax:</b> /msg <i>k�ytt�j�nimi</i> <Br>T�ll� komennolla voit l�hett�� yksityisen viestin tietylle k�ytt�j�lle.";
$txt[303] = "<a>[Paina t�st�]</a> l�hett��ksesi viestin k�ytt�j�lle _u";	// _u on vastaanottajan k�ytt�j�nimi, j�t� <a> ja </a> rauhaan
$txt[304] = "<b>Syntax:</b> /wallchop <i>viesti</i> <Br>T�m� komento l�hett�� viestisi kaikille huoneen operaattoreille.";
$txt[305] = "(Viesti huoneen _r operaattoreille k�ytt�j�lt� _u)";	// _r on huone, _u on l�hett�j�

$txt[306] = "T�m� on Admin hallintapaneelisi. T��lt� voit muuttaa asetuksia, asentaa modeja, p�ivitt�� teemoja ja hallita huoneesi monia muita ominaisuuksia.";
$txt[307] = "Uutisia meilt�";
$txt[308] = "Teemat";
$txt[309] = "K�ytt�j�ryhm�t";
$txt[310] = "Hallitse k�ytt�ji�";
$txt[311] = "Hallitse huoneita";
$txt[312] = "Bannilista";
$txt[313] = "Kaista";
$txt[314] = "Hallitse logeja";
$txt[315] = "Kalenteri";
$txt[316] = "Massapostitus";
$txt[317] = "Hymi�t";
$txt[318] = "Modit";
$txt[319] = "XUpdater on poissa k�yt�st�. T�m� moduuli vaaditaan jos haluat k�ytt�� t�t� ominaisuutta. Voit ottaa sen k�ytt��n editoimalla config.php-tiedostoa.";
$txt[320] = "Ei uusia uutisia t�ll� hetkell�.";
$txt[321] = "Valitse mink� osan asetuksia haluat p�ivitt��.";
$txt[322] = "Aika ja p�iv�m��r�";
$txt[323] = "Vanhenemisajat";
$txt[324] = "Bannerin URL";
$txt[325] = "Tyylit ja viestit";
$txt[326] = "Avatar-kuvat";
$txt[327] = "Kirjautumissivu";
$txt[328] = "Lis�asetukset";
$txt[329] = "Poista chat k�yt�st�";
$txt[330] = "Salli rekister�ityminen";
$txt[331] = "Salli vieraat";
$txt[332] = "Sivun nimi";
$txt[333] = "Admin s�hk�posti";
$txt[334] = "Uloskirjautumissivu";
$txt[335] = "Merkkien enimm�ism��r� tilassa";
$txt[336] = "Merkkien enimm�ism��r� viestiss�";
$txt[337] = "Offline viestien enimm�ism��r�";
$txt[338] = "Minimi p�ivitysaika";
$txt[339] = "Maksimi p�ivitysaika";
$txt[340] = "Laita 0 jos haluat rajattoman.";
$txt[341] = "Oletuskieli";
$txt[342] = "Oletusteema";
$txt[343] = "Asetuksesi on p�ivitetty.  <a>Paina t�st�</a> palataksesi asetuspaneeliin.";		// J�t� <a> ja </a>
$txt[344] = "Minimi virkistystaajuus ei voi olla suurempi kuin suurin virkistystaajuus, haloo.";
$txt[345] = "Logipolku";
$txt[346] = "Huoneen maksimi logikoko (KB)";
$txt[347] = "K�ytt�j�n maksimi logikoko (KB)";
$txt[348] = "Ajan muoto";
$txt[349] = "P�iv�yksen muoto";
$txt[350] = "Pitk� p�iv�yksen/ajan muoto";
$txt[351] = "sekunneissa";
$txt[352] = "Maksimi idle aika";
$txt[353] = "Viestit vanhenevat:";
$txt[354] = "Huoneet vanhenevat:";
$txt[355] = "Vierastilit vanhenevat:";
$txt[356] = "minuuteissa";
$txt[357] = "Keksin aika";
$txt[358] = "Taustakuva";
$txt[359] = "Salli omavalintainen huoneen taustakuva";
$txt[360] = "Salli omavalintaiset huoneen logot";
$txt[361] = "Oletusfontti";
$txt[362] = "Oletuskoko";
$txt[363] = "Oletusv�ri";
$txt[364] = "Minimi fonttikoko";
$txt[365] = "Maksimi fonttikoko";
$txt[366] = "Poista hymi�t k�yt�st�";
$txt[367] = "Poista viestityylit k�yt�st�";
$txt[368] = "Poista automaattilinkitys k�yt�st�";
$txt[369] = "J�rjestelm�n viestin v�ri";
$txt[370] = "Sallitut fontit*";
$txt[371] = "Eroteltuna pilkulla";
$txt[372] = "Ota avatar-lataukset k�ytt��n";
$txt[373] = "Pienenn� suuret avatarit automaattisesti";
$txt[374] = "Suurin sallittu ladatun avatar-kuvan koko (biteiss�)";
$txt[375] = "Suurin sallittu avatar koko (leveys x korkeus )";
$txt[376] = "Latauspolku";
$txt[377] = "Upload URL";
$txt[378] = "N�yt� tapahtumakalenteri";
$txt[379] = "N�yt� tilastot";
$txt[380] = "Ota salasanamuistutus k�ytt��n";
$txt[381] = "N�ytett�vien p�ivien m��r� p�iv�kohtaisessa kalenterissa (1-3)";
$txt[382] = "N�yt� kuukausikohtainen kalenteri";
$txt[383] = "N�yt� p�iv�kohtainen kalenteri";
$txt[384] = "Poista GD Kirjaston k�ytt� k�yt�st�";	// GD Info: http://www.boutell.com/gd/
$txt[385] = "Jos et tied� mik� se on, �l� poista sit� k�yt�st�. Jos j�rjestelm�si ei tue sit�, se poistetaan k�yt�st� automaattisesti.";
$txt[386] = "Etsim��si huonetta ei ole olemassa.";
$txt[387] = "<a>Paina t�st�</a> astuaksesi kyseiseen huoneeseen.";		// J�t� <a> ja </a> rauhaan
$txt[388] = "Mene yksityiseen huoneeseen";
$txt[389] = "Astu sis��n";
$txt[390] = "Teeman nimi";
$txt[391] = "Oletko varma ett� haluat poistaa t�m�n teeman?";
$txt[392] = "Kyll�";
$txt[393] = "Ei";
$txt[394] = "Valittu teema on poistettu.";
$txt[395] = "Valitsemaasi teemaa ei voitu poistaa. Poista _d kansio (se on teemakansiossa) FTP ohjelmastasi.";		//_d korvataan hakemiston nimell�
$txt[396] = "Jos asetit CHMOD 777:n teemahakemistoon, on eritt�in suositeltavaa ett� palautat sen tilaan jossa se oli ennen muutosta.  (Tavallisesti 755)";
$txt[397] = "Aseta CHMOD 777 teemahakemistolle.";
$txt[398] = "CHMOD valmis";
$txt[399] = "Seuraavat uudet teemat l�ytyiv�t.";
$txt[400] = "Asenna";
$txt[401] = "Virhe: Aseta CHMOD 777 modihakemistolle.";
$txt[402] = "Seuraava teema on asennettu.";
$txt[403] = "Julkaistu";
$txt[404] = "Tekij�";
$txt[405] = "Kuvaus";
$txt[406] = "Lataa uusia teemoja";
$txt[407] = "Olet nyt huoneen operaattori, p��st�ksesi huoneen hallintapaneeliin kirjoita /roomcp";
$txt[408] = "Oletusryhm�t";
$txt[409] = "Uusi j�sen";
$txt[410] = "Vieras";
$txt[411] = "Yll�pit�j�";
$txt[412] = "Ryhm�asetuksesi on p�ivitetty.";
$txt[413] = "J�senet";
$txt[414] = "Uusi ryhm�";
$txt[415] = "Ryhm�n vaihto onnistui.";
$txt[416] = "Vaihda ryhm��";
$txt[417] = "Vaida valittujen ryhm�";
$txt[418] = "Seuraavat k�ytt�j�t ovat t�ss� ryhm�ss�";
$txt[419] = "Valitse kaikki/poista kaikki valinnat";
$txt[420] = "Poista kaikki k�ytt�j�t k�ytt�j�ryhm�st� ennen kuin poistat sen.";
$txt[421] = "K�ytt�j�ryhm� on poistettu.";
$txt[422] = "Voi luoda huoneen";
$txt[423] = "Voi luoda yksityisen huoneen";
$txt[424] = "T��ll� voit muuttaa asioita joita t�m� k�ytt�j�ryhm� voi tehd�.";
$txt[425] = "Voi asettaa huoneen vanhenemattomaksi";
$txt[426] = "Voi asettaa huoneen moderoiduksi";
$txt[427] = "Voi katsoa IP osoitteen";
$txt[428] = "Voi potkaista k�ytt�ji� ulos";
$txt[429] = "Ei voida potkaista ulos tai bannata";
$txt[430] = "On operaattorioikeudet joka huoneessa";
$txt[431] = "On ��ni kaikissa huoneissa";
$txt[432] = "N�kee piilotetut s�hk�postiosoitteet";
$txt[433] = "Voi asettaa/poistaa avainsanoja";
$txt[434] = "Voi hallita huoneeseen kirjautumista";
$txt[435] = "Voi tallentaa yksityisviestej� logiin";
$txt[436] = "Voi asettaa huoneen taustakuvia";
$txt[437] = "Voi asettaa huoneen logoja";
$txt[438] = "Voi my�nt�� yll�pit�j�n oikeudet";
$txt[439] = "Voi l�hett�� palvelinviestej�";
$txt[440] = "Voi k�ytt�� /mdeop komentoa";
$txt[441] = "Voi k�ytt�� /mkick komentoa";
$txt[442] = "P��see yll�pidon hallintapaneeliin : Asetukset";
$txt[443] = "P��see yll�pidon hallintapaneeliin : Teemat";
$txt[444] = "P��see yll�pidon hallintapaneeliin : Sanasuodatin";
$txt[445] = "P��see yll�pidon hallintapaneeliin : K�ytt�j�ryhm�t";
$txt[446] = "P��see yll�pidon hallintapaneeliin : Hallitse k�ytt�ji�";
$txt[447] = "P��see yll�pidon hallintapaneeliin : Bannilista";
$txt[448] = "P��see yll�pidon hallintapaneeliin : Kaista";
$txt[449] = "P��see yll�pidon hallintapaneeliin : Logimanageri";
$txt[450] = "P��see yll�pidon hallintapaneeliin : Massaposti";
$txt[451] = "P��see yll�pidon hallintapaneeliin : Modit";
$txt[452] = "P��see yll�pidon hallintapaneeliin : Hymi�t";
$txt[453] = "P��see yll�pidon hallintapaneeliin : Huoneet";
$txt[454] = "P��see huoneeseen kun se on poissa k�yt�st�";
$txt[455] = "K�ytt�j�ll� pit�� olla operaattorioikeudet k�ytt��kseen t�t� ominaisuutta";
$txt[456] = "K�ytt�j�ll� pit�� olla operaattorioikeudet ja t�m� ominaisuus pit�� olla otettuna k�ytt��n yll�pidon hallintapaneelin asetuksista.";
$txt[457] = "P��see yll�pidon hallintapaneeliin : Kalenteri";
$txt[458] = "T�m�n k�ytt�j�ryhm�n luvat on p�ivitetty.";
$txt[459] = "Muokkaa";
$txt[460] = "Pikamuokkaus";
$txt[461] = "Oletko varma ett� haluat poistaa t�m�n k�ytt�j�tilin?";
$txt[462] = "Valittu k�ytt�j�tili on poistettu.";
$txt[463] = "K�ytt�j�tili� ei l�ydy.";
$txt[464] = "K�ytt�j�tili on p�ivitetty.";
$txt[465] = "Oletko varma ett� haluat poistaa t�m�n huoneen?";
$txt[466] = "Valittu huone on poistettu.";
$txt[467] = "T�m� huone on poistettu.";
$txt[468] = "Tallenna kaistan k�ytt� logiin";
$txt[469] = "Kaistan logi on pois k�yt�st�.  <a>Paina t�st�</a> ottaaksesi sen k�ytt��n.";	// J�t� <a> ja </a> rauhaan
$txt[470] = "Kaistan logi on k�yt�ss�.  <a>Paina t�st�</a> poistaaksesi sen k�yt�st�.";	// J�t� <a> ja </a> rauhaan
$txt[471] = "Oletus kaistaraja (megabiteiss�)";
$txt[472] = "Rajoita k�ytt�j�t <i>x</i> MB per _t";	//  _t on pudotusvalikko josta voi valita kuukauden tai p�iv�n
$txt[473] = "Kuukausi";	// Joo olet n�hnyt t�m�n ennenkin, t�ll� kertaa se ei ole monikko
$txt[474] = "P�iv�";	// Joo olet n�hnyt t�m�n ennenkin, t�ll� kertaa se ei ole monikko
$txt[475] = "K�ytetty";
$txt[476] = "Max (MB)";
$txt[477] = "K�ytetyn kaistan arvot p�tev�t vain chatti-ikkunoissa eik� niihin sis�lly tiedonsiirtoja. Muiden sivujen kaistank�ytt�� ei lasketa.";
$txt[478] = "Voidaan asettaa 0 rajoittamattomaksi tai -1 oletukseksi";
$txt[479] = "Kokonaiskaista";
$txt[480] = "Olet ylitt�nyt suurimman sallitun kaistank�yt�n t�m�n p�iv�n osalta. Palaa asiaan huomenna.";
$txt[481] = "Olet ylitt�nyt suurimman sallitun kaistank�yt�n t�m�n kuukauden osalta. Palaa asiaan ensi kuussa.";
$txt[482] = "Logattu";
$txt[483] = "Hallitse/katsele";
$txt[484] = "Loggaus on t�ll� hetkell� pois k�yt�st�, <a>Paina t�st�</a> ottaaksesi sen k�ytt��n.";	// J�t� <a> ja </a> rauhaan
$txt[485] = "Loggaus on t�ll� hetkell� k�yt�ss�, <a>Paina t�st�</a> poistaaksesi sen k�yt�st�.";	// J�t� <a> ja </a> rauhaan
$txt[486] = "Muokkaa login asetuksia";
$txt[487] = "Muokkaa tapahtumaa";
$txt[488] = "Tapahtuma";
$txt[489] = "Lis�� tapahtuma";
$txt[490] = "Aika (tt:mm)";
$txt[491] = "K�yt� 24 tunnin aikamuotoa";
$txt[492] = "P�iv�ys (KK/PP/VVVV)";
$txt[493] = "Voit sy�tt�� s�hk�postiviestisi t�h�n ja l�hett�� sen kaikille rekister�ityneille j�senillesi.";
$txt[494] = "S�hk�posti on l�hetetty kaikille rekister�ityneille j�senillesi.";
$txt[495] = "Lis�� hymi�";
$txt[496] = "Koodi";
$txt[497] = "Kuvan URL";
$txt[498] = "Seuraavat hymi�t on asennettu.";
$txt[499] = "Seuraavat hymi�tiedostot l�ytyiv�t Hymi�hakemistosta eiv�tk� ne t�ll� hetkell� ole k�yt�ss�.";
$txt[500] = "Voit lis�t� useita hymi�it� samanaikaisesti lataamalla kaikki haluamasi hymi�t hymi�hakemistoon.";
$txt[501] = "Hymi�";
$txt[502] = "K�y osoitteessa <a href=\"http://x7chat.com/support.php\" target=\"_blank\">our support page</a> n�hd�ksesi X7 Chat Administrator dokumentaation ja saadaksesi teknist� tukea.<Br><br>User end documentation is included with X7 Chat and is available <a href=\"./help/\" target=\"_blank\">here</a>.";		// T�t� ei tarvitse v�ltt�m�tt� k��nt��
$txt[503] = "<a>[Paina t�st�]</a> avataksesi dokumentaation";	// J�t� <a> ja </a> rauhaan
$txt[504] = "<a>[Paina t�st�]</a> avataksesi yll�pidon hallintapaneelin uudessa ikkunassa.";		// J�t� <a> ja </a> tagit rauhaan
$txt[505] = "Muutu n�kym�tt�m�ksi";
$txt[506] = "N�e n�kym�tt�m�t k�ytt�j�t";
$txt[507] = "Sinulla ei ole lupaa muuttua n�kym�tt�m�ksi";
$txt[508] = "Olet nyt n�kym�t�n t�ss� huoneessa";
$txt[509] = "Et ole en�� n�kym�t�n t�ss� huoneessa";
$txt[510] = "Astu sis��n kaikkiin huoneisiin n�kym�tt�m�n�";
$txt[511] = "Olet saanut yksityisen viestin. Jos se ei avaudu uudessa ikkunassa automaattisesti, <a>[Paina t�st�]</a>";		// J�t� <a> ja </a> rauhaan
$txt[512] = "_u on bannattu koska _r.";	// _u k�ytt�j�nimi, _r bannin syy
$txt[513] = "K�ytt�j�n _u banni on poistettu.";
$txt[514] = "Lukematon posti";
$txt[515] = "Merkkien enimm�ism��r� k�ytt�j�nimess�";
$txt[516] = "Chattiin tuleminen tarkoittaa ett� suostut noudattamaan <a>K�ytt�ehtoja</a>.";	// J�t� <a> ja </a> rauhaan
$txt[517] = "K�ytt�ehdot";
$txt[518] = "Jos haluat poistaa k�ytt�ehdot k�yt�st�, voit j�tt�� t�m�n tyhj�ksi. Voit k�ytt�� HTML-kielt�.";
$txt[519] = "Etsi IP osoite";
$txt[520] = "Etsi";
$txt[521] = "Voit poistaa ylim��r�isi� rivej� ajamalla <a>Siivouksen</a>";	// J�t� <a> ja </a> rauhaan
$txt[522] = "Sinun t�ytyy asettaa CHMOD 777 t�lle hakemistolle ett� loki toimii .";
$txt[523] = "Muutu n�kym�tt�m�ksi";
$txt[524] = "Muutu n�kyv�ksi";
$txt[525] = "Voidaksesi luoda tai muokata teemoja sinun pit�� asettaa CHMOD 777 teemahakemistoon.  <Br><Br><b>JOS MUOKKAAT TEEMAA</b><Br> Jos muokkaat olemassa olevaa teemaa, aseta CHMOD 777 muokattavan teeman hakemistoon ja my�s kaikkiin hakemiston muihin tiedostoihin. Jos et tee niin, muutostesi p�ivitys voi ep�onnistua. Vieraile X7 Chatin nettisivulla saadaksesi apua.";
$txt[526] = "Luo uusi teema";
$txt[527] = "Ikkunan taustav�ri";
$txt[528] = "P��ikkunan rungon taustav�ri";
$txt[529] = "P��ikkunan rungon vaihtoehtoinen taustav�ri";
$txt[530] = "Fontin v�ri";
$txt[531] = "Valikkonapin tekstin v�ri";
$txt[532] = "Otsikon fonttiv�ri";
$txt[533] = "Fontti";
$txt[534] = "Pieni fonttikoko";
$txt[535] = "Normaali fonttikoko";
$txt[536] = "Suuri fonttikoko";
$txt[537] = "Suurempi fonttikoko";
$txt[538] = "Reunav�ri";
$txt[539] = "Vaihtoehtoinen reunav�ri";
$txt[540] = "Linkin v�ri";
$txt[541] = "Linkin v�ri osoitettaessa";
$txt[542] = "Aktiivisen linkin v�ri";
$txt[543] = "Tekstikent�n taustav�ri";
$txt[544] = "Tekstikent�n reunav�ri";
$txt[545] = "Tekstikent�n fonttikoko";
$txt[546] = "Tekstikent�n fonttiv�ri";
$txt[547] = "Toisen henkil�n nimen v�ri";
$txt[548] = "Oman nimesi v�ri";
$txt[549] = "Chatti-ikkunan taustav�ri";
$txt[550] = "Yksityisviesti-ikkunan reunav�ri";
$txt[551] = "Kotisivun URL";
$txt[552] = "Teeman nimi";
$txt[553] = "Taulukon otsikkorivin taustav�ri";
$txt[554] = "Teeman luoja";
$txt[555] = "Teeman kuvaus";
$txt[556] = "Teeman versio";
$txt[557] = "Malliteemahakemistoa ei l�ytynyt.";
$txt[558] = "Teemasi on p�ivitetty.";
$txt[559] = "Sinun pit�� antaa teemallesi nimi.";
$txt[560] = "Chattaan huoneessa..";
$txt[561] = "J�senlista";
$txt[562] = "Otsikon taustakuva";
$txt[563] = "Kalenterin fonttiv�ri";
$txt[564] = "<b>Syntax:</b> /mkick <i>Syy</i> <Br>T�m� komento potkaisee kaikki huoneessa olijat ulos.";
$txt[565] = "Aseta CHMOD 777 modihakemistoon. Jos tarvitset apua CHMODaamisessa, k�y nettisivullamme.";
$txt[566] = "Lataa modeja";
$txt[567] = "Asennetut modit";
$txt[568] = "Poista asennus";
$txt[569] = "Uudet modit";
$txt[570] = "Modin nimi";
$txt[571] = "Aseta CHMOD 777 seuraaviin tiedostoihin ja hakemistoihin:";
$txt[572] = "Aloita asennus";
$txt[573] = "Varmuuskopioi tiedostot & Aloita";
$txt[574] = "Asennus suoritettu, voit peruuttaa kaikki CHMOD komennot jotka teit.";
$txt[575] = "Aloita asennuksen poisto";
$txt[576] = "Asennuksen poisto suoritettu, voit peruuttaa kaikki CHMOD komennot jotka teit.";
$txt[577] = "P��see yll�pidon hallintapaneeliin : Avainsanat";
$txt[578] = "Teeman tiedot";
$txt[579] = "Teeman fontit";
$txt[580] = "Teeman taustat";
$txt[581] = "Teeman reunat";
$txt[582] = "Teeman linkit";
$txt[583] = "Teeman sy�tt�kentt�";
$txt[584] = "Sekalaiset teemav�rit";
$txt[585] = "Taustav�ri 4";
$txt[586] = "Reunan tyyli";
$txt[587] = "Reunan koko";
$txt[588] = "Tekstikent�n reunan tyyli";
$txt[589] = "Tekstikent�n reunan koko";
$txt[590] = "Palvelimen huonetyyppi";
$txt[591] = "Multiroom Mode";
$txt[592] = "Single Room";
$txt[593] = "Kun Single Room -tila on p��ll�, k�ytt�j�t pakotetaan sis��n kirjautuessaan valittuun huoneeseen eiv�tk� he voi vaihtaa sielt� pois.";
$txt[594] = "T�ss� huoneessa on k�yt�ss� Single Room-tila, et voi poistaa sit�. Poista Single Room-tila k�yt�st� Asetusten yleisist� asetuksista.";
$txt[595] = "* Uusi avustusistunto *";
$txt[596] = "Odota hetki, joku auttaa sinua kohta.";
$txt[597] = "On ilmennyt kohtalokas virhe. Ota yhteytt� chat-huoneen yll�pitoon. Kopioi virheilmoitus ja l�het� se heille.";
$txt[598] = "Lataa...";
$txt[599] = "Tukikeskus";
$txt[600] = "Uusi k�ytt�j�tili on luotu.";
$txt[601] = "Luo k�ytt�j�tili";
$txt[602] = "Kirjaudu salasanasuojattuihin huoneisiin ilman salasanaa";
$txt[603] = "Sinun pit�� j�tt�� t�m� ikkuna auki, tuen pyynn�t aukeavat automaattisesti uuteen ikkunaan. Jos sinulla on ponnahdusikkunoiden esto p��ll�, sinun PIT�� ottaa se pois k�yt�st�.";
$txt[604] = "T�m� paneeli sallii sinun muuttaa asetuksia k�ytt��ksesi X7 Chattia erityisesti tukipalveluhuoneena. On eritt�in suositeltavaa ett� luet dokumentaation jotta ymm�rt�isit seuraavat vaihtoehdot.";
$txt[605] = "Tukitilit";
$txt[606] = "Viesti joka ilmestyy jos tuki ei ole k�ytett�viss�";
$txt[607] = "Tuki k�yt�ss�-kuva";
$txt[608] = "Tuki ei k�ytett�viss�-kuva";
$txt[609] = "Listaa k�ytt�j�nimet erottaen ne toisistaan puolipilkuilla (;), n�ill� k�ytt�jill� on p��sy tukikeskukseen";
$txt[610] = "Tili�, jolle yritit viestisi l�hett��, ei ole olemassa.";
$txt[611] = "Oma RGB arvo";
$txt[612] = "Et voi poistaa oletusteemaa.";

/* Added in 2.0.1 */
$txt[613] = "This chat room requires E-Mail activation before you can use your account.  Please check the inbox of the E-Mail account that you registered with.";
$txt[614] = "Thank you, your account has been activated.";
$txt[615] = "Unable to activate account, the activation code you entered was not found.";
$txt[616] = "Require Account Activation";
$txt[617] = "Please visit this URL to activate your chatroom account: ";
$txt[618] = "Chatroom Account Activation";

/** Special strings **/

// Viikonp�iv�t ja kuukaudet, selv�sti helpompaa ja tehokkaampaa tehd� n�in 
$txt['Sunday'] = "Sunnuntai";
$txt['Monday'] = "Maanantai";
$txt['Tuesday'] = "Tiistai";
$txt['Wednesday'] = "Keskiviikko";
$txt['Thursday'] = "Torstai";
$txt['Friday'] = "Perjantai";
$txt['Saturday'] = "Lauantai";
$txt['January'] = "Tammikuu";
$txt['February'] = "Helmikuu";
$txt['March'] = "Maaliskuu";
$txt['April'] = "Huhtikuu";
$txt['May'] = "Toukokuu";
$txt['June'] = "Kes�kuu";
$txt['July'] = "Hein�kuu";
$txt['August'] = "Elokuu";
$txt['September'] = "Syyskuu";
$txt['October'] = "Lokakuu";
$txt['November'] = "Marraskuu";
$txt['December'] = "Joulukuu";

?>
