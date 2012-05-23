<?PHP
/////////////////////////////////////////////////////////////// 
//
//		X7 Chat Version 2.0.0
//		Released July 27, 2005
//		Copyright (c) 2004-2005 By the X7 Group
//		Website: http://www.x7chat.com
//
//		Tämä on ilmainen ohjelma. Voit
//		muokata ja/tai jakaa sitä mukana olevien 
//		X7 Groupin lisenssiehtojen mukaisesti.
//  
//		Käyttämällä tätä ohjelmaa suostut	     
//		ehtoihimme, jotka ovat nähtävissä mukana 
//		tulevassa tiedostossa "license.txt".  Jos et saanut
//		tätä tiedostoa, vieraile nettisivullamme
//		ja hanki virallinen kopio X7 Chatista.
//		
//		Tämän copyrightin ja/tai minkä tahansa
//		X7 Groupin tai X7 Chatin copyrightin poistaminen 
//		mistä tahansa tämän ohjelman tiedostosta
//		on kiellettyä ja poistaminen päättää oikeutesi käyttää
//		tätä ohjelmaa.
//	
////////////////////////////////////////////////////////////////EOH
?><?PHP

$language_iso = "iso-8859-1";	// Jos tarvitset apua, lähetä sähköpostia webmaster@x7chat.com niin annan kielellesi oikean arvon

// Huom:
//	Jos tarvitset apua jonkin kääntämisessä, meilaa minulle niin yritän parhaani.  Mieluummin 
//	vastaanotan sähköpostia kuin arvailen mitä se on.
//
//	"<br>" lisää rivinvaihdon. Voit lisätä <br>ä mutta jätä sinne ne jotka siellä jo on.
//	"<b>" muuttaa tekstin lihavoiduksi kunnes kirjoitat "</b>" joka lopettaa tekstin lihavoinnin.
//	"<i>" kursivoi tekstin kunnes kirjoitat "</i>" joka lopettaa tekstin kursivoinnin.

$txt[0] = "Kirjaudu sisään";
$txt[1] = "Anna käyttäjätunnus ja salasana";
$txt[2] = "Käyttäjätunnus";
$txt[3] = "Salasana";
$txt[4] = "&nbsp;&nbsp; Kirjaudu &nbsp;&nbsp;";	// "&nbsp;" on sama kuin tyhjä väli
$txt[5] = "Lähetä salasana";
$txt[6] = "Rekisteröidy";
$txt[7] = "Tilastot";
$txt[8] = "Käyttäjiä palvelussa";
$txt[9] = "Huoneiden lukumäärä";
$txt[10] = "Rekisteröityneet käyttäjät";
$txt[11] = "Online käyttäjät";
$txt[12] = "Tulevat tapahtumat";
$txt[13] = "Antamasi salasana tai käyttäjätunnus on virheellinen";
$txt[14] = "Virhe";

$txt[15] = "Sori, ylläpito on poistanut rekisteröinnin";
$txt[16] = "Kirjaudu ulos";
$txt[17] = "Olet kirjautunut ulos.";
$txt[18] = "Rekisteröidy";
$txt[19] = "Täytä tämä rekisteröintilomake, kaikki tiedot ovat pakollisia.";
$txt[20] = "Sähköposti";
$txt[21] = "Salasana uudelleen";
$txt[22] = "Voit lisätä tietoja profiiliisi rekisteröinnin jälkeen";
$txt[23] = "Virheellinen käyttäjätunnus, käyttäjätunnuksesi voi sisältää kirjaimia ja numeroita mutta ei välejä, pilkkuja, pisteitä, heittomerkkejä, lainausmerkkejä tai puolipisteitä.  Käyttäjätunnuksesi pitää olla alle _n merkkiä pitkä.";		// _n on enimmäismerkkimäärä
$txt[24] = "Anna toimiva sähköpostiosoite.";
$txt[25] = "Anna salasana.";
$txt[26] = "Antamasi salasana ei täsmää.";
$txt[27] = "Sori, käyttäjätunnus on jo käytössä, palaa takaisin ja valitse joku toinen.";
$txt[28] = "Käyttäjätilisi on luotu, <a href=\"./index.php\">Paina tästä</a> kirjautuaksesi sisään.";

$txt[29] = "Huonelista";
$txt[30] = "Käyttäjät";
$txt[31] = "Nimi";
$txt[32] = "Aihe";

$txt[34] = "Apua";
$txt[35] = "Hallinta";
$txt[36] = "Asennetut teemat";
$txt[37] = "Hallinta (Ylläpito)";

$txt[38] = "Sori, tuntematon kehys!";
$txt[39] = "Sori, ylläpito on sulkenut huoneen!";

$txt[40] = "Tila";
$txt[41] = "Huoneen hallinta";

$txt[42] = "Et voi lähettää viestiä tähän huoneeseen ellei valvoja anna sinulle äänioikeutta.";
$txt[43] = "on saapunut huoneeseen";
$txt[44] = "on poistunut huoneesta";

$txt[45] = "Sivua ei voi näyttää, sivua ei ole.";
$txt[55] = "Oletus";
$txt[56] = "Lisää";
$txt[57] = "Valitse fontti:";

$txt[58] = "Minkä kokoisen fontin haluaisit?";
$txt[59] = "Luo huone";
$txt[60] = "Sinulla ei ole lupaa luoda uutta huonetta.";
$txt[61] = "Huoneen nimi";
$txt[62] = "Täytä tämä lomake luodaksesi uuden huoneen";
$txt[63] = "Luo";
$txt[64] = "Huoneen tyyppi";
$txt[65] = "Aihe";
$txt[66] = "Tervehdys";
$txt[67] = "Enimmäiskäyttäjämäärä";
$txt[68] = "Julkinen";
$txt[69] = "Yksityinen";
$txt[70] = "Moderoitu";
$txt[71] = "Vanhentumaton";
$txt[72] = "Virheellinen huoneen nimi, huoneen nimessä voi olla kirjaimia ja numeroita mutta ei pisteitä, pilkkuja, heittomerkkejä, tähtiä tai puolipisteitä.";
$txt[73] = "Tuntematon huonetyyppi";
$txt[74] = "Et voi luoda yksityishuoneita";
$txt[75] = "Huoneesi on luotu";
$txt[76] = "Huonenimi on jo käytössä, valitse joku toinen";
$txt[77] = "Takaisin";
$txt[78] = "Salasana vaaditaan";
$txt[79] = "Tämä huone on salasanasuojattu. Anna salasana.";
$txt[80] = "Tämä huone on täynnä";
$txt[81] = "Täysiä huoneita ei näytetä";
$txt[82] = "Näytä täydet huoneet";
$txt[83] = "Täydet huoneet ovat näkyvissä";
$txt[84] = "Piilota täydet huoneet";
$txt[85] = "Profiili";
$txt[86] = "Toiminta";
$txt[87] = "Koko profiili";
$txt[88] = "Yksityinen keskustelu";
$txt[89] = "Lähetä sähköpostia";
$txt[90] = "Päivitetään....";

$txt[91] = "Torju";
$txt[92] = "Salli";
$txt[93] = "Vaienna";
$txt[94] = "Anna Opit";
$txt[95] = "Ota Opit";
$txt[96] = "Poista vaiennus";
$txt[97] = "Potkaise";
$txt[98] = "Näytä IP";
$txt[99] = "Anna ääni oikeus";
$txt[100] = "Ota ääni oikeus";

$txt[101] = "Käyttäjä on torjuttu.";
$txt[102] = "Käyttäjä on taas sallittu.";
$txt[103] = "Valitse käyttäjä";
$txt[104] = "Sinulla ei ole lupaa suorittaa tätä toimintoa loppuun";
$txt[105] = "Käyttäjälle on annettu Opit";
$txt[106] = "Käyttäjän Opit on peruutettu";
$txt[107] = "Tämän käyttäjän IP osoite on: ";
$txt[108] = "Anna syy tämän käyttäjän potkaisemiselle:";
$txt[109] = "Käyttäjä on potkaistu huoneesta, eikä voi palata 60 sekuntiin.";
$txt[110] = "_u on potkaistu _r";	// _u korvataan käyttäjänimellä ja _r korvataan syyllä

$txt[111] = "Tämä käyttäjä on vaiennettu.";
$txt[112] = "Tämä käyttäjä ei ole enää vaiennettu.";
$txt[113] = "Tämä käyttäjä on saanut äänenoikeuden.";
$txt[114] = "Tämän käyttäjän äänioikeus on otettu pois.";

$txt[115] = "Sinut on potkaistu tästä huoneesta koska _r";	// _r korvataan potkun syyllä
$txt[116] = "Sinut on bannattu tästä huoneesta koska _r";	// _r korvataan bannin syyllä
$txt[117] = "Sinut on bannattu tältä palvelimelta koska _r";	// _r korvataan bannin syyllä
$txt[118] = "Sinut on poistettu tästä huoneesta, <a href='./index.php'>klikkaa tästä</a> palataksesi huonelistalle ja valitaksesi toisen huoneen.";

$txt[119] = "Näytä profiili";
$txt[120] = "(piilotettu)";
$txt[121] = "Sijainti";
$txt[122] = "Harrastukset";
$txt[123] = "Käyttäjäryhmä";
$txt[124] = "Bio";
$txt[125] = "Avatar-kuva";

$txt[126] = "_u on nyt Chat Huone Operaattori";		// _u käyttäjä josta tehtiin operaattori.
$txt[127] = "_u ei ole enää Chat Huone Operaattori";		// _u käyttäjä jonka oikeudet poistettiin.
$txt[128] = "Valitse väri";		
$txt[129] = "_u on saanut äänenoikeuden";		// _u käyttäjä jolle annettiin ääni.
$txt[130] = "_us äänioikeus on otettu pois";		// _u käyttäjä jonka ääni poistettiin.
$txt[131] = "_u on vaiennettu";		// _u käyttäjä joka vaiennettiin.
$txt[132] = "_u ei ole enää vaiennettu";		// _u käyttäjä jonka vaiennus poistettiin.
$txt[133] = "Sulje";		
$txt[134] = "Viestisi väri on päivitetty.";		
$txt[135] = "Käyttäjän hallintapaneeli";
$txt[136] = "Tervetuloa hallintapaneeliisi. Täällä voit muuttaa asetuksiasi, lähettää viestejä ja muokata chattia.";

$txt[137] = "Etusivu";
$txt[138] = "Profiili";
$txt[139] = "Asetukset";
$txt[140] = "Tila";
$txt[141] = "Blokkilista";
$txt[142] = "Offline viestit";
$txt[143] = "Sanasuodatin";
$txt[144] = "Avainsanat";
$txt[145] = "Seuraavat sanat on suodatettu, klikkaa sanaa poistaaksesi sen.";

$txt[146] = "Tämän hetkinen tilasi";
$txt[147] = "Aseta tila";
$txt[148] = "Tilasi on muutettu";
$txt[149] = "Poissa";
$txt[150] = "Paikalla";
$txt[151] = "Palaan pian";
$txt[152] = "Palaan myöhemmin";
$txt[153] = "Oma tila";
$txt[154] = "Muuta";
$txt[155] = "Kirjainten enimmäismäärä";
$txt[156] = "Seuraavat käyttäjät on torjuttu, klikkaa salliaksesi heidät.";
$txt[158] = "_u on poistettu blokkilistaltasi.";	// _u korvataan käyttäjänimellä
$txt[159] = "Torju käyttäjä";
$txt[160] = "Lisää";
$txt[161] = "_u on lisätty blokkilistallesi.";	// _u korvataan käyttäjänimellä
$txt[162] = "_w on suodatettu.";		// _w korvataan sanalla joka suodattui
$txt[163] = "_w ei enää suodateta.";		// _w korvataan sanalla josta suodatus poistettiin
$txt[164] = "Suodata sana";
$txt[165] = "Teksti";
$txt[166] = "Korvaava";
$txt[167] = "Avainsana-asetuksesi on päivitetty";
$txt[168] = "Avainsanat ovat erityisiä sanoja jotka muutetaan automaattisesti linkeiksi chat huoneeseen lähetettäessä.<Br><Br>Seuraavat ovat avainsanoja, klikkaa sanaa poistaaksesi sen.";		// <br> tarkoittaa että se menee uudelle riville, samoin kuin enter tekee
$txt[169] = "Lisää avainsana";
$txt[170] = "URL";
$txt[171] = "Viestisi on lähetetty.";
$txt[172] = "Alla ovat kaikki vastaanottamasi viestit.";
$txt[173] = "[Tyhjä]";
$txt[174] = "------- Alkuperäinen viesti -------";	
$txt[175] = "Poista";
$txt[176] = "VS: ";
$txt[177] = "Viesti on poistettu";
$txt[178] = "Aihe";
$txt[179] = "Lähettäjä";
$txt[180] = "Päiväys";
$txt[181] = "Lähetä";
$txt[182] = "Vastaanottaja";
$txt[183] = "Aihe";
$txt[184] = "Viestiäsi ei voitu lähettää koska vastaanottajan postilaatikko on täynnä.";
$txt[185] = "Käytössäsi on _p laatikkosi tilasta.  Sinulla on tilaa _n uudelle viestille.";	// _p on käytetty tila prosentteina ja _n on laatikkoon vielä mahtuvien viestien määrä
$txt[186] = "Sukupuoli";
$txt[187] = "Päivitä";
$txt[188] = "Profiilisi on päivitetty.";

$txt[189] = "Mies";
$txt[190] = "Nainen";
$txt[191] = "------";

$txt[192] = "Upload";
$txt[193] = "Voit käyttää tätä lomaketta ladataksesi avatar-kuvan. Voit pitää palvelimella vain yhtä avatar-kuvaa kerrallaan.
Avatar-kuvasi pitää olla .gif, .png tai .jpeg muodossa ja sen pitää olla kooltaan alle _b bittiä. Kuvasi tulee olla  _d pikseliä.";		// _b korvataan bittirajalla ja _d korvataan kokorajalla jonka ylläpito on määrittänyt

$txt[194] = "Avatar-kuvasi on ladattu onnistuneesti ja profiilisi on päivitetty.";
$txt[195] = "Avatar-kuvan lataus on poistettu käytöstä.";
$txt[196] = "Tiedoston koko on liian suuri.";
$txt[197] = "Avatar-kuvasi tiedostomuotoa ei tunnistettu. Muuta kuvasi PNG, GIF tai JPEG muotoon.";
$txt[198] = "Kuvan lataus on käytössä mutta ylläpito ei ole antanut kuvahakemistoon kirjoitusoikeuksia. Ota yhteyttä ylläpitoon ja ilmoita ongelmasta. Kuvaasi ei ladattu.";

$txt[199] = "Keskusteluaika (tuntia)";
$txt[200] = "Päivitysväli (sekuntia)";
$txt[201] = "Aikaero (tuntia)";
$txt[202] = "Aikaero (minuuttia)";
$txt[203] = "Skin";
$txt[204] = "Kieli";
$txt[205] = "Poista tyylit käytöstä";
$txt[206] = "Poista hymiöt käytöstä";
$txt[207] = "Poista äänet käytöstä";
$txt[208] = "Poista aikaleimat";
$txt[209] = "Piilota sähköposti";
$txt[210] = "Asetuksesi on päivitetty";

$txt[211] = "Tuntematon komento";
$txt[212] = "_u heittää _d _s-sivuista noppaa.";		// _u käyttäjänimi, _d noppien määrä ja _s sivujen lukumäärä
$txt[213] = "Tulokset ovat:";
$txt[214] = "Tulokset modifioidaan numerolla _a.";	// _a numero jolla ne modifioidaan

$txt[215] = "Pääsy evätty";
$txt[216] = "Sinulla ei ole valtuuksia tulla tähän osaan.";
$txt[217] = "Tässä paneelissa voit muokata monia chat huoneesi asetuksia.";
$txt[218] = "Yleiset asetukset";
$txt[219] = "Operaattorilista";
$txt[220] = "Äänilista";
$txt[221] = "Blokkilista";
$txt[222] = "Uusi Banni";
$txt[223] = "Syy";
$txt[224] = "Käyttäjä / IP / sähköposti";
$txt[225] = "Pituus";
$txt[226] = "Ikuinen";
$txt[227] = "TAI";
$txt[228] = "Minuuttia";
$txt[229] = "Tuntia";
$txt[230] = "Päivää";
$txt[231] = "Viikkoa";
$txt[232] = "Kuukautta";
$txt[233] = "Klikkaa käyttäjää, IPtä tai sähköpostiosoitetta poistaakseni bannin";
$txt[234] = "Uusi banni on voimassa.";
$txt[235] = "Banni on poistettu.";
$txt[236] = "Seuraavilla käyttäjillä on operaattorioikeudet tässä huoneessa. Klikkaa käyttäjää poistaaksesi operaattorioikeudet.";
$txt[237] = "Seuraavilla käyttäjillä on ääni tässä huoneessa. Klikkaa käyttäjää poistaaksesi äänen.";
$txt[238] = "Seuraavat käyttäjät on vaiennettu. Klikkaa käyttäjää poistaaksesi vaiennuksen.";
$txt[239] = "Kyseistä käyttäjää ei löytynyt.";
$txt[240] = "Logit";
$txt[241] = "Yksityisviestien logi";
$txt[242] = "Logi on käytössä";
$txt[243] = "Logi on poistettu käytöstä";
$txt[244] = "Ota logi käyttöön";
$txt[245] = "Poista logi käytöstä";
$txt[246] = "Logitiedoston koko: _s kb (_p)";		// _s on koko,_p on prosentti
$txt[247] = "Tyhjää tilaa jäljellä: _s kb (_p)";		// _s on jäljellä oleva vapaa tila, _p on prosentti
$txt[248] = "Rajoittamaton";
$txt[249] = "Alla on login sisältö.";
$txt[250] = "Poista logi";
$txt[251] = "Valitse logi alapuolelta tarkastellaksesi sitä.";
$txt[252] = "Viestiäsi ei lähetetty, se oli liian pitkä.";
$txt[253] = "Taustakuva";
$txt[254] = "Logo";
$txt[255] = "Salasana muistutus";
$txt[256] = "Hei _u,\n\nVierailija jonka IP osoite on _i salasanasi vaihtoa _s Chatissa.\n\nUusi salasanasi on _p.\n\nKiitos,\n_s Tuki";			// Us "\n" enter/uusi rivi, _u käyttäjänimi, _i IP, _s sivun nimi, _p uusi salasana
$txt[257] = "Anna käyttäjätunnuksesi tai sähköpostiosoitteesi saadaksesi uuden salasanan. Uusi salasana lähetetään tiedossamme olevaan osoitteeseen.";
$txt[258] = "Uusi salasanasi on lähetetty.";
$txt[259] = "Uutta salasanaasi ei lähetetty. Käyttäjätunnuksella tai sähköpostiosoitteella ei löytynyt yhtään käyttäjätiliä.";
$txt[260] = "Uutta salasanaasi ei lähetetty. Käyttäjätili löytyi mutta tietokannassamme ei ole sähköpostiosoitetta.";
$txt[261] = "Ylläpito on poistanut salasana muistutukset käytöstä.";
$txt[262] = "Uutiset";
$txt[263] = "Sorry, ongelmaasi ei löydy aihetta apuhakemistostamme.";
$txt[264] = "Huoneet vanhenevat automaattisesti: _t";		// _t on aika jonka jälkeen ne vanhenevat
$txt[265] = "Ei koskaan";
$txt[266] = "";
$txt[267] = "Sinulla ei ole valtuuksia käyttää tätä komentoa.";
$txt[268] = "Toimintoa ei voitu suorittaa kyseisen käyttäjän kohdalla.";
$txt[269] = "<b>Syntax:</b> /kick <i>käyttäjänimi</i> <i>syy</i><Br>Komento poistaa käyttäjän huoneesta.";
$txt[270] = "<b>Syntax:</b> /ban <i>käyttäjänimi</i> <i>syy</i><Br>Poistaa käyttäjän huoneesta ja estää tulemasta takaisin.";
$txt[271] = "<b>Syntax:</b> /unban <i>käyttäjänimi</i> <Br>Poistaa bannin.";
$txt[272] = "<b>Syntax:</b> /op <i>käyttäjänimi</i> <Br>Antaa käyttäjälle operaattorioikeudet.";
$txt[273] = "<b>Syntax:</b> /deop <i>käyttäjänimi</i> <Br>Poistaa operaattorioikeudet.";
$txt[274] = "<b>Syntax:</b> /ignore <i>käyttäjänimi</i> <Br>Blokkaa kaikki viestit kyseiseltä käyttäjältä.";
$txt[275] = "<b>Syntax:</b> /unignore <i>käyttäjänimi</i> <Br>Poistaa blokin kyseiseltä käyttäjältä.";
$txt[276] = "Seuraavat henkilöt ovat chatissa kanssasi: ";
$txt[277] = "<b>Syntax:</b> /me <i>toiminto</i> <Br>Kertoo toisille käyttäjille suorittamasi <i>toiminnon</i>.";
$txt[278] = "<b>Syntax:</b> /admin <i>käyttäjänimi</i> <Br>Antaa käyttäjälle admin oikeudet.";
$txt[279] = "_u On nyt chat huone admin";	// _u on käyttäjänimi
$txt[280] = "_u ei ole enää chat huone admin";	// _u on käyttäjänimi
$txt[281] = "<b>HEI!!</b>, Yritit juuri poistaa itseltäsi admin oikeudet! Jos haluat jatkaa tätä toimintoa, kirjoita /deadmin <i>oma käyttäjänimesi</i> 1";
$txt[282] = "<b>Syntax:</b> /voice <i>käyttäjänimi</i> <Br>Antaa käyttäjälle äänen ja oikeuden puhua moderoiduissa huoneissa.";
$txt[283] = "<b>Syntax:</b> /devoice <i>käyttäjänimi</i> <Br>Tämä komento ottaa käyttäjältä äänen jottei käyttäjä voisi enää puhua moderoiduissa huoneissa.";
$txt[284] = "<b>Syntax:</b> /mute <i>käyttäjänimi</i> <Br>Tämä komento estää käyttäjää lähettämästä viestejä huoneeseen.";
$txt[285] = "<b>Syntax:</b> /unmute <i>käyttäjänimi</i> <Br>Komento sallii vaiennetun käyttäjän lähettää taas viestejä huoneeseen.";
$txt[286] = "<b>Syntax:</b> /wallchan <i>viesti</i> <Br>Komento lähettää viestejä kaikkiin huoneisiin.";
$txt[287] = "<a>[Paina tästä]</a> avataksesi huoneen hallintapaneelin uuteen ikkunaan.";		// Jätä <a> ja </a> tagit rauhaan
$txt[288] = "<b>Syntax:</b> /log <i>toiminto</i> <Br>Tämä komento sallii sinun lopettaa, tarkastella kokoa, aloittaa ja tyhjentää login.  <i>Toiminto</i> voi olla:<Br><b>Stop</b>: Lopettaa login<Br><b>Start</b>: Aloittaa login<br><b>Clear</b>: Tyhjentää olemassa olevan login<Br><b>Size</b>: Kertoo kuinka paljon logista on käytetty";
$txt[289] = "Olet käyttänyt _s KB  _m KB:n logitilastasi.";	// _s on käyttämäsi määrä ja _m on paljonko voit käyttää
$txt[290] = "Käytit mode komentoa väärin.  <a>Paina tästä</a> saadaksesi ohjeet sen käyttöön.";
$txt[291] = "";
$txt[292] = "Chatin keskeytys.";
$txt[293] = "_u on ottanut operaattoristatuksen pois kaikilta operaattoreilta.";		// _u on käyttäjänimi
$txt[294] = "Päivän viesti on tyhjä.";	
$txt[295] = "<b>Syntax:</b> /userip <i>käyttäjänimi</i> <Br>Tämä komento näyttää kyseisen käyttäjänimen IP osoitteen.";
$txt[296] = "_u on kutsunut sinut huoneeseen: _r";	// _u on kutsujan käyttäjänimi ja _r on huone
$txt[297] = "<b>Syntax:</b> /invite <i>käyttäjänimi</i> <Br>Tämä komento kutsuu käyttäjän samaan huoneeseen jossa itse olet.";
$txt[298] = "<b>Syntax:</b> /join <i>huone</i> <Br>Tällä komennolla pääset uuteen huoneeseen.";
$txt[299] = "<a>[Paina tästä]</a> liittyäksesi _r";	// jätä <a> ja </a> rauhaan, _r on huone
$txt[300] = "Kyseistä huonetta ei ole olemassa.";
$txt[301] = "<a>[Paina tästä]</a> luodaksesi sen.";	// jätä <a> ja </a> rauhaan
$txt[302] = "<b>Syntax:</b> /msg <i>käyttäjänimi</i> <Br>Tällä komennolla voit lähettää yksityisen viestin tietylle käyttäjälle.";
$txt[303] = "<a>[Paina tästä]</a> lähettääksesi viestin käyttäjälle _u";	// _u on vastaanottajan käyttäjänimi, jätä <a> ja </a> rauhaan
$txt[304] = "<b>Syntax:</b> /wallchop <i>viesti</i> <Br>Tämä komento lähettää viestisi kaikille huoneen operaattoreille.";
$txt[305] = "(Viesti huoneen _r operaattoreille käyttäjältä _u)";	// _r on huone, _u on lähettäjä

$txt[306] = "Tämä on Admin hallintapaneelisi. Täältä voit muuttaa asetuksia, asentaa modeja, päivittää teemoja ja hallita huoneesi monia muita ominaisuuksia.";
$txt[307] = "Uutisia meiltä";
$txt[308] = "Teemat";
$txt[309] = "Käyttäjäryhmät";
$txt[310] = "Hallitse käyttäjiä";
$txt[311] = "Hallitse huoneita";
$txt[312] = "Bannilista";
$txt[313] = "Kaista";
$txt[314] = "Hallitse logeja";
$txt[315] = "Kalenteri";
$txt[316] = "Massapostitus";
$txt[317] = "Hymiöt";
$txt[318] = "Modit";
$txt[319] = "XUpdater on poissa käytöstä. Tämä moduuli vaaditaan jos haluat käyttää tätä ominaisuutta. Voit ottaa sen käyttöön editoimalla config.php-tiedostoa.";
$txt[320] = "Ei uusia uutisia tällä hetkellä.";
$txt[321] = "Valitse minkä osan asetuksia haluat päivittää.";
$txt[322] = "Aika ja päivämäärä";
$txt[323] = "Vanhenemisajat";
$txt[324] = "Bannerin URL";
$txt[325] = "Tyylit ja viestit";
$txt[326] = "Avatar-kuvat";
$txt[327] = "Kirjautumissivu";
$txt[328] = "Lisäasetukset";
$txt[329] = "Poista chat käytöstä";
$txt[330] = "Salli rekisteröityminen";
$txt[331] = "Salli vieraat";
$txt[332] = "Sivun nimi";
$txt[333] = "Admin sähköposti";
$txt[334] = "Uloskirjautumissivu";
$txt[335] = "Merkkien enimmäismäärä tilassa";
$txt[336] = "Merkkien enimmäismäärä viestissä";
$txt[337] = "Offline viestien enimmäismäärä";
$txt[338] = "Minimi päivitysaika";
$txt[339] = "Maksimi päivitysaika";
$txt[340] = "Laita 0 jos haluat rajattoman.";
$txt[341] = "Oletuskieli";
$txt[342] = "Oletusteema";
$txt[343] = "Asetuksesi on päivitetty.  <a>Paina tästä</a> palataksesi asetuspaneeliin.";		// Jätä <a> ja </a>
$txt[344] = "Minimi virkistystaajuus ei voi olla suurempi kuin suurin virkistystaajuus, haloo.";
$txt[345] = "Logipolku";
$txt[346] = "Huoneen maksimi logikoko (KB)";
$txt[347] = "Käyttäjän maksimi logikoko (KB)";
$txt[348] = "Ajan muoto";
$txt[349] = "Päiväyksen muoto";
$txt[350] = "Pitkä päiväyksen/ajan muoto";
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
$txt[363] = "Oletusväri";
$txt[364] = "Minimi fonttikoko";
$txt[365] = "Maksimi fonttikoko";
$txt[366] = "Poista hymiöt käytöstä";
$txt[367] = "Poista viestityylit käytöstä";
$txt[368] = "Poista automaattilinkitys käytöstä";
$txt[369] = "Järjestelmän viestin väri";
$txt[370] = "Sallitut fontit*";
$txt[371] = "Eroteltuna pilkulla";
$txt[372] = "Ota avatar-lataukset käyttöön";
$txt[373] = "Pienennä suuret avatarit automaattisesti";
$txt[374] = "Suurin sallittu ladatun avatar-kuvan koko (biteissä)";
$txt[375] = "Suurin sallittu avatar koko (leveys x korkeus )";
$txt[376] = "Latauspolku";
$txt[377] = "Upload URL";
$txt[378] = "Näytä tapahtumakalenteri";
$txt[379] = "Näytä tilastot";
$txt[380] = "Ota salasanamuistutus käyttöön";
$txt[381] = "Näytettävien päivien määrä päiväkohtaisessa kalenterissa (1-3)";
$txt[382] = "Näytä kuukausikohtainen kalenteri";
$txt[383] = "Näytä päiväkohtainen kalenteri";
$txt[384] = "Poista GD Kirjaston käyttö käytöstä";	// GD Info: http://www.boutell.com/gd/
$txt[385] = "Jos et tiedä mikä se on, älä poista sitä käytöstä. Jos järjestelmäsi ei tue sitä, se poistetaan käytöstä automaattisesti.";
$txt[386] = "Etsimääsi huonetta ei ole olemassa.";
$txt[387] = "<a>Paina tästä</a> astuaksesi kyseiseen huoneeseen.";		// Jätä <a> ja </a> rauhaan
$txt[388] = "Mene yksityiseen huoneeseen";
$txt[389] = "Astu sisään";
$txt[390] = "Teeman nimi";
$txt[391] = "Oletko varma että haluat poistaa tämän teeman?";
$txt[392] = "Kyllä";
$txt[393] = "Ei";
$txt[394] = "Valittu teema on poistettu.";
$txt[395] = "Valitsemaasi teemaa ei voitu poistaa. Poista _d kansio (se on teemakansiossa) FTP ohjelmastasi.";		//_d korvataan hakemiston nimellä
$txt[396] = "Jos asetit CHMOD 777:n teemahakemistoon, on erittäin suositeltavaa että palautat sen tilaan jossa se oli ennen muutosta.  (Tavallisesti 755)";
$txt[397] = "Aseta CHMOD 777 teemahakemistolle.";
$txt[398] = "CHMOD valmis";
$txt[399] = "Seuraavat uudet teemat löytyivät.";
$txt[400] = "Asenna";
$txt[401] = "Virhe: Aseta CHMOD 777 modihakemistolle.";
$txt[402] = "Seuraava teema on asennettu.";
$txt[403] = "Julkaistu";
$txt[404] = "Tekijä";
$txt[405] = "Kuvaus";
$txt[406] = "Lataa uusia teemoja";
$txt[407] = "Olet nyt huoneen operaattori, päästäksesi huoneen hallintapaneeliin kirjoita /roomcp";
$txt[408] = "Oletusryhmät";
$txt[409] = "Uusi jäsen";
$txt[410] = "Vieras";
$txt[411] = "Ylläpitäjä";
$txt[412] = "Ryhmäasetuksesi on päivitetty.";
$txt[413] = "Jäsenet";
$txt[414] = "Uusi ryhmä";
$txt[415] = "Ryhmän vaihto onnistui.";
$txt[416] = "Vaihda ryhmää";
$txt[417] = "Vaida valittujen ryhmä";
$txt[418] = "Seuraavat käyttäjät ovat tässä ryhmässä";
$txt[419] = "Valitse kaikki/poista kaikki valinnat";
$txt[420] = "Poista kaikki käyttäjät käyttäjäryhmästä ennen kuin poistat sen.";
$txt[421] = "Käyttäjäryhmä on poistettu.";
$txt[422] = "Voi luoda huoneen";
$txt[423] = "Voi luoda yksityisen huoneen";
$txt[424] = "Täällä voit muuttaa asioita joita tämä käyttäjäryhmä voi tehdä.";
$txt[425] = "Voi asettaa huoneen vanhenemattomaksi";
$txt[426] = "Voi asettaa huoneen moderoiduksi";
$txt[427] = "Voi katsoa IP osoitteen";
$txt[428] = "Voi potkaista käyttäjiä ulos";
$txt[429] = "Ei voida potkaista ulos tai bannata";
$txt[430] = "On operaattorioikeudet joka huoneessa";
$txt[431] = "On ääni kaikissa huoneissa";
$txt[432] = "Näkee piilotetut sähköpostiosoitteet";
$txt[433] = "Voi asettaa/poistaa avainsanoja";
$txt[434] = "Voi hallita huoneeseen kirjautumista";
$txt[435] = "Voi tallentaa yksityisviestejä logiin";
$txt[436] = "Voi asettaa huoneen taustakuvia";
$txt[437] = "Voi asettaa huoneen logoja";
$txt[438] = "Voi myöntää ylläpitäjän oikeudet";
$txt[439] = "Voi lähettää palvelinviestejä";
$txt[440] = "Voi käyttää /mdeop komentoa";
$txt[441] = "Voi käyttää /mkick komentoa";
$txt[442] = "Pääsee ylläpidon hallintapaneeliin : Asetukset";
$txt[443] = "Pääsee ylläpidon hallintapaneeliin : Teemat";
$txt[444] = "Pääsee ylläpidon hallintapaneeliin : Sanasuodatin";
$txt[445] = "Pääsee ylläpidon hallintapaneeliin : Käyttäjäryhmät";
$txt[446] = "Pääsee ylläpidon hallintapaneeliin : Hallitse käyttäjiä";
$txt[447] = "Pääsee ylläpidon hallintapaneeliin : Bannilista";
$txt[448] = "Pääsee ylläpidon hallintapaneeliin : Kaista";
$txt[449] = "Pääsee ylläpidon hallintapaneeliin : Logimanageri";
$txt[450] = "Pääsee ylläpidon hallintapaneeliin : Massaposti";
$txt[451] = "Pääsee ylläpidon hallintapaneeliin : Modit";
$txt[452] = "Pääsee ylläpidon hallintapaneeliin : Hymiöt";
$txt[453] = "Pääsee ylläpidon hallintapaneeliin : Huoneet";
$txt[454] = "Pääsee huoneeseen kun se on poissa käytöstä";
$txt[455] = "Käyttäjällä pitää olla operaattorioikeudet käyttääkseen tätä ominaisuutta";
$txt[456] = "Käyttäjällä pitää olla operaattorioikeudet ja tämä ominaisuus pitää olla otettuna käyttöön ylläpidon hallintapaneelin asetuksista.";
$txt[457] = "Pääsee ylläpidon hallintapaneeliin : Kalenteri";
$txt[458] = "Tämän käyttäjäryhmän luvat on päivitetty.";
$txt[459] = "Muokkaa";
$txt[460] = "Pikamuokkaus";
$txt[461] = "Oletko varma että haluat poistaa tämän käyttäjätilin?";
$txt[462] = "Valittu käyttäjätili on poistettu.";
$txt[463] = "Käyttäjätiliä ei löydy.";
$txt[464] = "Käyttäjätili on päivitetty.";
$txt[465] = "Oletko varma että haluat poistaa tämän huoneen?";
$txt[466] = "Valittu huone on poistettu.";
$txt[467] = "Tämä huone on poistettu.";
$txt[468] = "Tallenna kaistan käyttö logiin";
$txt[469] = "Kaistan logi on pois käytöstä.  <a>Paina tästä</a> ottaaksesi sen käyttöön.";	// Jätä <a> ja </a> rauhaan
$txt[470] = "Kaistan logi on käytössä.  <a>Paina tästä</a> poistaaksesi sen käytöstä.";	// Jätä <a> ja </a> rauhaan
$txt[471] = "Oletus kaistaraja (megabiteissä)";
$txt[472] = "Rajoita käyttäjät <i>x</i> MB per _t";	//  _t on pudotusvalikko josta voi valita kuukauden tai päivän
$txt[473] = "Kuukausi";	// Joo olet nähnyt tämän ennenkin, tällä kertaa se ei ole monikko
$txt[474] = "Päivä";	// Joo olet nähnyt tämän ennenkin, tällä kertaa se ei ole monikko
$txt[475] = "Käytetty";
$txt[476] = "Max (MB)";
$txt[477] = "Käytetyn kaistan arvot pätevät vain chatti-ikkunoissa eikä niihin sisälly tiedonsiirtoja. Muiden sivujen kaistankäyttöä ei lasketa.";
$txt[478] = "Voidaan asettaa 0 rajoittamattomaksi tai -1 oletukseksi";
$txt[479] = "Kokonaiskaista";
$txt[480] = "Olet ylittänyt suurimman sallitun kaistankäytön tämän päivän osalta. Palaa asiaan huomenna.";
$txt[481] = "Olet ylittänyt suurimman sallitun kaistankäytön tämän kuukauden osalta. Palaa asiaan ensi kuussa.";
$txt[482] = "Logattu";
$txt[483] = "Hallitse/katsele";
$txt[484] = "Loggaus on tällä hetkellä pois käytöstä, <a>Paina tästä</a> ottaaksesi sen käyttöön.";	// Jätä <a> ja </a> rauhaan
$txt[485] = "Loggaus on tällä hetkellä käytössä, <a>Paina tästä</a> poistaaksesi sen käytöstä.";	// Jätä <a> ja </a> rauhaan
$txt[486] = "Muokkaa login asetuksia";
$txt[487] = "Muokkaa tapahtumaa";
$txt[488] = "Tapahtuma";
$txt[489] = "Lisää tapahtuma";
$txt[490] = "Aika (tt:mm)";
$txt[491] = "Käytä 24 tunnin aikamuotoa";
$txt[492] = "Päiväys (KK/PP/VVVV)";
$txt[493] = "Voit syöttää sähköpostiviestisi tähän ja lähettää sen kaikille rekisteröityneille jäsenillesi.";
$txt[494] = "Sähköposti on lähetetty kaikille rekisteröityneille jäsenillesi.";
$txt[495] = "Lisää hymiö";
$txt[496] = "Koodi";
$txt[497] = "Kuvan URL";
$txt[498] = "Seuraavat hymiöt on asennettu.";
$txt[499] = "Seuraavat hymiötiedostot löytyivät Hymiöhakemistosta eivätkä ne tällä hetkellä ole käytössä.";
$txt[500] = "Voit lisätä useita hymiöitä samanaikaisesti lataamalla kaikki haluamasi hymiöt hymiöhakemistoon.";
$txt[501] = "Hymiö";
$txt[502] = "Käy osoitteessa <a href=\"http://x7chat.com/support.php\" target=\"_blank\">our support page</a> nähdäksesi X7 Chat Administrator dokumentaation ja saadaksesi teknistä tukea.<Br><br>User end documentation is included with X7 Chat and is available <a href=\"./help/\" target=\"_blank\">here</a>.";		// Tätä ei tarvitse välttämättä kääntää
$txt[503] = "<a>[Paina tästä]</a> avataksesi dokumentaation";	// Jätä <a> ja </a> rauhaan
$txt[504] = "<a>[Paina tästä]</a> avataksesi ylläpidon hallintapaneelin uudessa ikkunassa.";		// Jätä <a> ja </a> tagit rauhaan
$txt[505] = "Muutu näkymättömäksi";
$txt[506] = "Näe näkymättömät käyttäjät";
$txt[507] = "Sinulla ei ole lupaa muuttua näkymättömäksi";
$txt[508] = "Olet nyt näkymätön tässä huoneessa";
$txt[509] = "Et ole enää näkymätön tässä huoneessa";
$txt[510] = "Astu sisään kaikkiin huoneisiin näkymättömänä";
$txt[511] = "Olet saanut yksityisen viestin. Jos se ei avaudu uudessa ikkunassa automaattisesti, <a>[Paina tästä]</a>";		// Jätä <a> ja </a> rauhaan
$txt[512] = "_u on bannattu koska _r.";	// _u käyttäjänimi, _r bannin syy
$txt[513] = "Käyttäjän _u banni on poistettu.";
$txt[514] = "Lukematon posti";
$txt[515] = "Merkkien enimmäismäärä käyttäjänimessä";
$txt[516] = "Chattiin tuleminen tarkoittaa että suostut noudattamaan <a>Käyttöehtoja</a>.";	// Jätä <a> ja </a> rauhaan
$txt[517] = "Käyttöehdot";
$txt[518] = "Jos haluat poistaa käyttöehdot käytöstä, voit jättää tämän tyhjäksi. Voit käyttää HTML-kieltä.";
$txt[519] = "Etsi IP osoite";
$txt[520] = "Etsi";
$txt[521] = "Voit poistaa ylimääräisiä rivejä ajamalla <a>Siivouksen</a>";	// Jätä <a> ja </a> rauhaan
$txt[522] = "Sinun täytyy asettaa CHMOD 777 tälle hakemistolle että loki toimii .";
$txt[523] = "Muutu näkymättömäksi";
$txt[524] = "Muutu näkyväksi";
$txt[525] = "Voidaksesi luoda tai muokata teemoja sinun pitää asettaa CHMOD 777 teemahakemistoon.  <Br><Br><b>JOS MUOKKAAT TEEMAA</b><Br> Jos muokkaat olemassa olevaa teemaa, aseta CHMOD 777 muokattavan teeman hakemistoon ja myös kaikkiin hakemiston muihin tiedostoihin. Jos et tee niin, muutostesi päivitys voi epäonnistua. Vieraile X7 Chatin nettisivulla saadaksesi apua.";
$txt[526] = "Luo uusi teema";
$txt[527] = "Ikkunan taustaväri";
$txt[528] = "Pääikkunan rungon taustaväri";
$txt[529] = "Pääikkunan rungon vaihtoehtoinen taustaväri";
$txt[530] = "Fontin väri";
$txt[531] = "Valikkonapin tekstin väri";
$txt[532] = "Otsikon fonttiväri";
$txt[533] = "Fontti";
$txt[534] = "Pieni fonttikoko";
$txt[535] = "Normaali fonttikoko";
$txt[536] = "Suuri fonttikoko";
$txt[537] = "Suurempi fonttikoko";
$txt[538] = "Reunaväri";
$txt[539] = "Vaihtoehtoinen reunaväri";
$txt[540] = "Linkin väri";
$txt[541] = "Linkin väri osoitettaessa";
$txt[542] = "Aktiivisen linkin väri";
$txt[543] = "Tekstikentän taustaväri";
$txt[544] = "Tekstikentän reunaväri";
$txt[545] = "Tekstikentän fonttikoko";
$txt[546] = "Tekstikentän fonttiväri";
$txt[547] = "Toisen henkilön nimen väri";
$txt[548] = "Oman nimesi väri";
$txt[549] = "Chatti-ikkunan taustaväri";
$txt[550] = "Yksityisviesti-ikkunan reunaväri";
$txt[551] = "Kotisivun URL";
$txt[552] = "Teeman nimi";
$txt[553] = "Taulukon otsikkorivin taustaväri";
$txt[554] = "Teeman luoja";
$txt[555] = "Teeman kuvaus";
$txt[556] = "Teeman versio";
$txt[557] = "Malliteemahakemistoa ei löytynyt.";
$txt[558] = "Teemasi on päivitetty.";
$txt[559] = "Sinun pitää antaa teemallesi nimi.";
$txt[560] = "Chattaan huoneessa..";
$txt[561] = "Jäsenlista";
$txt[562] = "Otsikon taustakuva";
$txt[563] = "Kalenterin fonttiväri";
$txt[564] = "<b>Syntax:</b> /mkick <i>Syy</i> <Br>Tämä komento potkaisee kaikki huoneessa olijat ulos.";
$txt[565] = "Aseta CHMOD 777 modihakemistoon. Jos tarvitset apua CHMODaamisessa, käy nettisivullamme.";
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
$txt[577] = "Pääsee ylläpidon hallintapaneeliin : Avainsanat";
$txt[578] = "Teeman tiedot";
$txt[579] = "Teeman fontit";
$txt[580] = "Teeman taustat";
$txt[581] = "Teeman reunat";
$txt[582] = "Teeman linkit";
$txt[583] = "Teeman syöttökenttä";
$txt[584] = "Sekalaiset teemavärit";
$txt[585] = "Taustaväri 4";
$txt[586] = "Reunan tyyli";
$txt[587] = "Reunan koko";
$txt[588] = "Tekstikentän reunan tyyli";
$txt[589] = "Tekstikentän reunan koko";
$txt[590] = "Palvelimen huonetyyppi";
$txt[591] = "Multiroom Mode";
$txt[592] = "Single Room";
$txt[593] = "Kun Single Room -tila on päällä, käyttäjät pakotetaan sisään kirjautuessaan valittuun huoneeseen eivätkä he voi vaihtaa sieltä pois.";
$txt[594] = "Tässä huoneessa on käytössä Single Room-tila, et voi poistaa sitä. Poista Single Room-tila käytöstä Asetusten yleisistä asetuksista.";
$txt[595] = "* Uusi avustusistunto *";
$txt[596] = "Odota hetki, joku auttaa sinua kohta.";
$txt[597] = "On ilmennyt kohtalokas virhe. Ota yhteyttä chat-huoneen ylläpitoon. Kopioi virheilmoitus ja lähetä se heille.";
$txt[598] = "Lataa...";
$txt[599] = "Tukikeskus";
$txt[600] = "Uusi käyttäjätili on luotu.";
$txt[601] = "Luo käyttäjätili";
$txt[602] = "Kirjaudu salasanasuojattuihin huoneisiin ilman salasanaa";
$txt[603] = "Sinun pitää jättää tämä ikkuna auki, tuen pyynnöt aukeavat automaattisesti uuteen ikkunaan. Jos sinulla on ponnahdusikkunoiden esto päällä, sinun PITÄÄ ottaa se pois käytöstä.";
$txt[604] = "Tämä paneeli sallii sinun muuttaa asetuksia käyttääksesi X7 Chattia erityisesti tukipalveluhuoneena. On erittäin suositeltavaa että luet dokumentaation jotta ymmärtäisit seuraavat vaihtoehdot.";
$txt[605] = "Tukitilit";
$txt[606] = "Viesti joka ilmestyy jos tuki ei ole käytettävissä";
$txt[607] = "Tuki käytössä-kuva";
$txt[608] = "Tuki ei käytettävissä-kuva";
$txt[609] = "Listaa käyttäjänimet erottaen ne toisistaan puolipilkuilla (;), näillä käyttäjillä on pääsy tukikeskukseen";
$txt[610] = "Tiliä, jolle yritit viestisi lähettää, ei ole olemassa.";
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

// Viikonpäivät ja kuukaudet, selvästi helpompaa ja tehokkaampaa tehdä näin 
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
$txt['June'] = "Kesäkuu";
$txt['July'] = "Heinäkuu";
$txt['August'] = "Elokuu";
$txt['September'] = "Syyskuu";
$txt['October'] = "Lokakuu";
$txt['November'] = "Marraskuu";
$txt['December'] = "Joulukuu";

?>
