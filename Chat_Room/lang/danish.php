<?PHP
///////////////////////////////////////////////////////////////
//
//     X7 Chat Version 2.0.0
//     Frigivet 27 Juli 2005
//     Copyright (c) 2004-2005 X7 Group
//     Website: http://www.x7chat.com
//
//     Programmet er freeware.  Du m� �ndre det og 
//     vidre dele det if�lge den inkluderede licens,
//     skrevet og udgivet af X7 Group.
//     Ved at bruge dette software accepterer du reglerne
//     som st�r beskrevet i filen "license.txt".  
//     Hvis du ikke modtog filen "license.txt" med denne pakke
//     s� bes�g venligst vores website og f� en officiel kopi.
//
//     At fjerne denne copyright og/eller andre X7 Group
//     eller X7 Chat copyright fra nogle eller alle filerne er forbudt.
//     G�r du det frasiger du dig retten til at bruge dette produkt.
//
////////////////////////////////////////////////////////////////EOH
?><?PHP

$language_iso = "iso-8859-1";        // Hvis du har brug for hj�lp til den her s� skriv en email til webmaster@x7chat.com og jeg vil give dig det korrekte nummer.

// Notes:
//        Hvis du har bruge for hj�lp til at overs�tte noget s� skriv til mig p� email og jeg vil g�re mit bedste for at hj�lpe.
//        Jeg vil hellere have at du skriver en email end at g�tte p� hvad det er.
//
//        "<br>" laver et linjeskift. Du m� godt tilf�je nogel <br> med lad venligst dem v�re der allerede er der.
//        "<b>" vil g�re din tekst FED indtil der kommer et "</b>"
//        "<i>" vil lave din tekst til skr�skrift indtil der kommer et "</i>"
//	      "<a> og </a>" laver et link, fjern IKKE disse tags. Ved at fjerne disse tage forminsker du brugervenligheden

$txt[0] = "Log ind";
$txt[1] = "Indtast brugernavn og kodeord for at logge ind";
$txt[2] = "Brugernavn";
$txt[3] = "Kodeord";
$txt[4] = "&nbsp;&nbsp; Log ind &nbsp;&nbsp;";        // "&nbsp;" er det samme som mellemrum
$txt[5] = "Send Kodeord";
$txt[6] = "Tilmeld";
$txt[7] = "Statestik";
$txt[8] = "Brugere Online";
$txt[9] = "Total antal Rum";
$txt[10] = "Brugere Registeret";
$txt[11] = "Online brugere";
$txt[12] = "Kommende begivenheder";
$txt[13] = "Brugernavn eller kodeord var forkert";
$txt[14] = "Fejl";

$txt[15] = "Desv�rre, administratoren for denne server har lukket for tilmelding";
$txt[16] = "Log ud";
$txt[17] = "Du er nu logget ud.";
$txt[18] = "Tilmeld";
$txt[19] = "Udfyld denne formular for at tilmelde dig. Alle felter er obligatoriske.";
$txt[20] = "E-Mail";
$txt[21] = "Gentag kodeord";
$txt[22] = "Flere detaljer kan angives i din profil efter tilmeldingen";
$txt[23] = "Forkert brugernavn, dit brugernavn kan indeholde bogstaver og tal, men ikke mellemrum, komma, punktum, apostrof, anf�rselstegn eller semikolon. Dit brugernavn skal v�re under _n tegn langt.";                // _n er nummeret p� tegn som dit brugernavn skal v�re under
$txt[24] = "Skriv venligst korrekt E-Mail Adresse.";
$txt[25] = "Skriv venligst et kodeord.";
$txt[26] = "Kodeordene var ikke ens.";
$txt[27] = "Desv�rre, det brugernavn er allerede i brug g� tilbage og v�lg et andet.";
$txt[28] = "Din konto er nu oprettet, <a href=\"./index.php\">Klik Her</a> for at logge ind.";

$txt[29] = "Rum Oversigt";
$txt[30] = "Brugere";
$txt[31] = "Navn";
$txt[32] = "Emne";

$txt[34] = "Hj�lp";
$txt[35] = "Bruger Setup";
$txt[36] = "Installerede Temaer";
$txt[37] = "Admin Setup";

$txt[38] = "Desv�rre, ukendt frame!";
$txt[39] = "Desv�rre, administratoren har lukket for tilgang til det rum!";

$txt[40] = "Status";
$txt[41] = "Rum Setup";

$txt[42] = "Du kan ikke sende en besked til dette rum f�r Operat�ren har givet dig skriveret.";
$txt[43] = "er kommet";
$txt[44] = "smuttede";

$txt[45] = "Kan ikke hente siden, den findes ikke.";
$txt[55] = "Standard";
$txt[56] = "Mere";
$txt[57] = "V�lg en skrifttype:";

$txt[58] = "Hvilken skriftst�rrelse vil du have?";
$txt[59] = "Opret Rum";
$txt[60] = "Du har ikke tilladelse til at oprette et nyt rum.";
$txt[61] = "Rum navn";
$txt[62] = "Udfyld formularen for at oprette et nyt rum";
$txt[63] = "Opret";
$txt[64] = "Rum Type";
$txt[65] = "Emne";
$txt[66] = "Hilsen";
$txt[67] = "Maks chattere";
$txt[68] = "Offentlig";
$txt[69] = "Privat";
$txt[70] = "Modereret";
$txt[71] = "Udl�ber aldrig";
$txt[72] = "Forkert rumnavn, dit rumnavn kan indeholde bogstaver og tal, men ikke komma, punktum, apostrof, stjerner eller semikolon.";
$txt[73] = "Ukendt rumtype";
$txt[74] = "Du kan ikke oprette private rum";
$txt[75] = "Dit chatrum er oprettet";
$txt[76] = "Det rumnavn er allerede i brug, v�lg venligst et andet";
$txt[77] = "Tilbage";
$txt[78] = "Kodeord kr�ves";
$txt[79] = "Dette rum er beskytte med et kodeord, indtast det venligst nu.";
$txt[80] = "Dette rum er fuldt, v�lg venligst et andet, eller pr�v senere";
$txt[81] = "Fyldte rum vises ikke";
$txt[82] = "Vis fyldte rum";
$txt[83] = "Fyldte rum vises";
$txt[84] = "Skjul fyldte rum";
$txt[85] = "Profil";
$txt[86] = "Handling";
$txt[87] = "Fuld Profil";
$txt[88] = "Privat Chat";
$txt[89] = "Send Mail";
$txt[90] = "Opdaterer....";

$txt[91] = "Ignorer";
$txt[92] = "Fjern Ignorer";
$txt[93] = "Mundkurv";
$txt[94] = "Giv Ops";
$txt[95] = "Tag Ops";
$txt[96] = "Fjern mundkurv";
$txt[97] = "Smid ud";
$txt[98] = "Se IP";
$txt[99] = "Giv skriveret";
$txt[100] = "Tag skriveret";

$txt[101] = "Brugeren bliver nu ignoreret.";
$txt[102] = "Brugeren ignoreres ikke mere.";
$txt[103] = "V�lg en bruger";
$txt[104] = "Du har ikke tilladelse til at udf�re dette";
$txt[105] = "Brugeren har f�et Operat�r Status";
$txt[106] = "Brugerens Operat�r Status er inddraget";
$txt[107] = "Denne brugers IP adresse er: ";
$txt[108] = "Skriv venligst en �rsag til at smide denne bruger ud:";
$txt[109] = "Brugeren er smidt ud af rummet, og kan ikke komme ind igen de n�ste 60 sekunder.";
$txt[110] = "_u er smidt ud pga. _r";        // _u bliver erstattet af brugernavn og _r bliver erstattet med en grund

$txt[111] = "Denne bruger har f�et mundkurv p�.";
$txt[112] = "Denne bruger har ikke l�ngere mundkurv p�.";
$txt[113] = "Denne bruger har f�et skriveret.";
$txt[114] = "Denne brugers skriveret er fjernet.";

$txt[115] = "Du er smidt ud af rummet pga. _r";        // _r bliver erstattet med en grund
$txt[116] = "Du er bannet fra dette rum pga. _r";        // _r bliver erstattet med en grund
$txt[117] = "Du er bannet fra denne server pga. _r";        // _r bliver erstattet med en grund
$txt[118] = "Du er fjernet fra dette rum, Venligst <a href='./index.php'>klik her</a> for at komme til rum oversigten.";

$txt[119] = "Se Profil";
$txt[120] = "(skjult)";
$txt[121] = "Sted";
$txt[122] = "Hobby";
$txt[123] = "Brugergruppe";
$txt[124] = "Biografi";
$txt[125] = "Avatar";

$txt[126] = "_u er nu Chat Rum Operat�r";                // _u bliver erstattet af det brugernavn der er blevet operat�r
$txt[127] = "_u er ikke l�ngere Chat Rum Operat�r";                // _u bliver erstattet af det brugernavn hvor operat�r status er blevet fjernet
$txt[128] = "v�lg en skriftfarve";
$txt[129] = "_u har f�et skriveret";          
$txt[130] = "_us skriveret er inddraget";             
$txt[131] = "_u har f�et mundkurv p�";             
$txt[132] = "_u har ikke l�ngere mundkurv p�";          
$txt[133] = "Luk";
$txt[134] = "Din tekstfarve er �ndret.";
$txt[135] = "Bruger Setup";
$txt[136] = "Velkommen til din Setup.  Her kan du skifte indstillinger, sende beskeder og �ndre mange ting for din chat.";

$txt[137] = "Hjem";
$txt[138] = "Profil";
$txt[139] = "Indstillinger";
$txt[140] = "Status";
$txt[141] = "Block liste";
$txt[142] = "Offline beskeder";
$txt[143] = "Ord Filter";
$txt[144] = "N�gleord";
$txt[145] = "F�lgende ord er filtreret, klik p� et for at fjerne det.";

$txt[146] = "Din nuv�rende Status";
$txt[147] = "S�t Status";
$txt[148] = "Din status er �ndret til";
$txt[149] = "V�k";
$txt[150] = "Online";
$txt[151] = "Kommer om lidt";
$txt[152] = "Kommer senere";
$txt[153] = "Special";
$txt[154] = "Skift";
$txt[155] = "Maks bogstaver";
$txt[156] = "F�lgende brugere bliver ignoreret, klik p� en for at fjerne ignoreringen.";
$txt[158] = "_u er fjernet fra din ignorer liste.";       
$txt[159] = "Ignorer en bruger";
$txt[160] = "Tilf�j";
$txt[161] = "_u er tilf�jet din ignorer liste.";      
$txt[162] = "_w er blevet filtreret.";                // _w bliver erstattet af det ord der er blevet filtreret fra
$txt[163] = "_w er ikke l�ngere filtreret.";             
$txt[164] = "Filtrer ord";
$txt[165] = "Tekst";
$txt[166] = "vises i stedet";
$txt[167] = "Dine n�gleords indstillinger er opdateret";
$txt[168] = "N�gleord er specielle ord som automatisk bliver formateret til links n�r de sendes til et chat rum.<Br><Br>F�lgende er n�gleord, klik p� et for at fjerne det.";   
$txt[169] = "Tilf�j n�gleord";
$txt[170] = "URL";
$txt[171] = "Din besked er sendt.";
$txt[172] = "herunder er alle beskeder du har modtaget.";
$txt[173] = "[Ingen]";
$txt[174] = "------- Original Besked -------";
$txt[175] = "Slet";
$txt[176] = "Svar: ";
$txt[177] = "Beskeden er slettet";
$txt[178] = "Emne";
$txt[179] = "Fra";
$txt[180] = "Dato";
$txt[181] = "Send";
$txt[182] = "Send til";
$txt[183] = "Emne";
$txt[184] = "Din besked kunne ikke sendes fordi brugerens indbakke er fuld.";
$txt[185] = "Du bruger _p af din indbakkes plads. Du har endnu plads til _n beskeder.";        // _p er antal procent af brugt plads og _n er nummeret p� beskeder der stadig er plads til
$txt[186] = "K�n";
$txt[187] = "Opdater";
$txt[188] = "Din profil er opdateret.";

$txt[189] = "Mand";
$txt[190] = "Kvinde";
$txt[191] = "------";

$txt[192] = "Send";
$txt[193] = "Du kan bruge denne formular til at sende en avatar. Du kan kun have �n avatar gemt p� serveren ad gangen.
Din avatar skal v�re et .gif, .png eller .jpg billede og skal v�re under _b bytes store.  Din avatar skal v�re _d px.";   // _b bliver erstattet med byte gr�nsen og _d bliver erstattet af st�rrelsen som admin har sat

$txt[194] = "Din avatar er blevet uploadet og din profil er opdateret.";
$txt[195] = "Avatar uploads er sl�et fra.";
$txt[196] = "Din avatar er for stor.";
$txt[197] = "Dit avatar's billedformat blev ikke genkendt.  Anvend venligst PNG, GIF eller JPG.";
$txt[198] = "Avatar uploads er sat til men administratoren har ikke gjort uploads mappen skrivbart.  kontakt venligst administratoren og fort�l om dette problem.  Din avatar blev IKKE sendt.";

$txt[199] = "Log ind Tid(timer)";
$txt[200] = "Opdateringsfrekvens (sekunder)";
$txt[201] = "Tids forskydning (timer)";
$txt[202] = "Tids forskydning (minutter)";
$txt[203] = "Tema";
$txt[204] = "Sprog";
$txt[205] = "Sl� stil fra";
$txt[206] = "Sl� Smilies fra";
$txt[207] = "Sl� lyd fra";
$txt[208] = "Sl� Tidsm�rkning fra";
$txt[209] = "Skjul E-Mail";
$txt[210] = "Dine indstillinger er opdateret";

$txt[211] = "Ukendt kommando";
$txt[212] = "_u ruller _d _s-sidede terninger.";                // _u bliver brugernavnet, _d er antal �jne p� terningen og _s antallet af sider
$txt[213] = "Resultatet er:";
$txt[214] = "Resultatet er �ndret af en _a.";        // _a er nummeret det er �ndret med

$txt[215] = "Adgang n�gtet";
$txt[216] = "Du har ikke adgang til denne afdeling.";
$txt[217] = "Dette panel giver dig mulighed for at �ndre indstillinger for dit chatrum.";
$txt[218] = "Generelle indstillinger";
$txt[219] = "Op Liste";
$txt[220] = "Skriver Liste";
$txt[221] = "Mundkurvs Liste";
$txt[222] = "Ny Ban";
$txt[223] = "�rsag";
$txt[224] = "Bruger / IP / E-Mail";
$txt[225] = "L�ngde";
$txt[226] = "For evigt";
$txt[227] = "ELLER";
$txt[228] = "Minutter";
$txt[229] = "Timer";
$txt[230] = "Dage";
$txt[231] = "Uger";
$txt[232] = "M�neder";
$txt[233] = "Klik p� en bruger, IP eller E-Mail adresse for at fjerne ban";
$txt[234] = "den nye ban er sat p�.";
$txt[235] = "ban er fjernet.";
$txt[236] = "F�lgende brugere har operat�r status i dette rum. Klik p� en for at fjerne dennes operat�r status.";
$txt[237] = "F�lgende brugere har skriverettigheder i dette rum. Klik p� en for at fjerne dennes skriverettighed.";
$txt[238] = "F�lgende brugere har mundkurv p�. Klik p� en for at fjerne dennes mundkurv.";
$txt[239] = "Kan ikke finde en bruger med det brugernavn.";
$txt[240] = "Logs";
$txt[241] = "Log Private beskeder";
$txt[242] = "Logging er sat til";
$txt[243] = "Logging er fjernet";
$txt[244] = "Sl� logging til";
$txt[245] = "Sl� logging fra";
$txt[246] = "Log fil st�rrelse: _s kb (_p)";                // _s er st�rrelsen,_p er antal procent
$txt[247] = "Fri plads tilbage: _s kb (_p)";                // _s den ledige plads, _p er antal procent
$txt[248] = "ubegr�nset";
$txt[249] = "Herunder er loggens indhold.";
$txt[250] = "Slet Log";
$txt[251] = "V�lg en log herunder for at se den.";
$txt[252] = "Din besked blev ikke sendt, den var for lang.";
$txt[253] = "Baggrundsbillede";
$txt[254] = "Logo billede";
$txt[255] = "Kodeordshusker";
$txt[256] = "Hej _u,\n\nEn g�st med ip adresse _i har bedt om at f� dit kodeord �ndret p� _s Chat.\n\nDit nye kodeord er _p.\n\nTak,\n_s Support Teamet";          // Us "\n" for ny linje, _u er brugernavn, _i for IP, _s er navnet, _p er det nye kodeord
$txt[257] = "Indtast dit brugernavn eller E-Mail adresse for at modtaget et nyt kodeord.  Det nye koderod bliver sendt p� den E-Mail adresse du registrerede dig med.";
$txt[258] = "Dit nye kodeord er sendt.";
$txt[259] = "Dit nye kodeord blev IKKE sendt.  vi kan ikke finde en konto med det brugernavn eller E-Mail adresse.";
$txt[260] = "Dit nye kodeord blev IKKE sendt.  Vi fandt dit brugernavn, men der er ikke en E-Mail adresse knyttet til.";
$txt[261] = "Administratoren har fjernet kodeordshuskeren.";
$txt[262] = "Nyheder";
$txt[263] = "Desv�rre, Ingen hj�lpe emner for det emne.";
$txt[264] = "Chatrum udl�ber automatisk efter: _t";                // _t er tiden
$txt[265] = "Aldrig";
$txt[266] = "";
$txt[267] = "Du har ikke rettigheder til at anvende den kommando.";
$txt[268] = "Kan ikke udf�re den kommando p� den valgte bruger.";
$txt[269] = "<b>Syntax:</b> /kick <i>brugernavn</i> <i>�rsag</i><Br>Denne kommando fjerner en bruger fra chatrummet.";
$txt[270] = "<b>Syntax:</b> /ban <i>brugernavn</i> <i>�rsag</i><Br>Denne kommando fjerner en bruger fra chatrummet og forhindrer at kunne komme ind igen.";
$txt[271] = "<b>Syntax:</b> /unban <i>brugernavn</i> <Br>Denne kommando vil tillade en bannet bruger at kunne komme ind igen.";
$txt[272] = "<b>Syntax:</b> /op <i>brugernavn</i> <Br>Denne kommando vil give operat�r adgang for en bruger.";
$txt[273] = "<b>Syntax:</b> /deop <i>brugernavn</i> <Br>Denne kommando vil fjerne operat�r status fra en bruger.";
$txt[274] = "<b>Syntax:</b> /ignore <i>brugernavn</i> <Br>Denne kommando vil blokere alle beskeder fra en bruger.";
$txt[275] = "<b>Syntax:</b> /unignore <i>brugernavn</i> <Br>Denne kommando vil fjerne blokeringen af alle beskeder fra en bruger.";
$txt[276] = "Du chatter med f�lgende: ";
$txt[277] = "<b>Syntax:</b> /me <i>handling</i> <Br>Denne kommando vil fort�lle andre brugere at du udf�rer <i>handling</i>.";
$txt[278] = "<b>Syntax:</b> /admin <i>brugernavn</i> <Br>Denne kommando vil give brugeren administrator adgang.";
$txt[279] = "_u er nu chat rum administrator";        // _u er brugernavnet
$txt[280] = "_u er ikke l�ngere chat rum administrator";   
$txt[281] = "<b>HEY!!</b>, Du fors�gte at fjerne admin status fra dig selv!  Hvis du vil forts�tte denne handling s� skriv /deadmin <i>dit brugernavn</i> 1";
$txt[282] = "<b>Syntax:</b> /voice <i>brugernavn</i> <Br>Denne kommando vil give brugeren skriverettigheder og tilladelse til at skrive i modererede rum";
$txt[283] = "<b>Syntax:</b> /devoice <i>brugernavn</i> <Br>Denne kommando vil fjerne brugerens skriverettighed  s� denne ikke ikke l�ngere kan skrive i modererede rum.";
$txt[284] = "<b>Syntax:</b> /mute <i>brugernavn</i> <Br>Denne kommando vil n�gte brugeren ret til at sende beskeder til rummet.";
$txt[285] = "<b>Syntax:</b> /unmute <i>brugernavn</i> <Br>Denne kommando vil tillade en bruger med mundkurv igen at sende beskeder i rummet. (Fjerner mundkurv)";
$txt[286] = "<b>Syntax:</b> /wallchan <i>besked</i> <Br>Denne kommando vil sende en besked til alle rum.";
$txt[287] = "<a>[Klik her]</a> for at �bne Rum Setup i et nyt vindue.";                // Lad <a> og </a> v�re
$txt[288] = "<b>Syntax:</b> /log <i>handling</i> <Br>Denne kommando tillader dig at stoppe, se st�rrelse, starte og nulstille loggen.  <i>handling</i> kan v�re:<Br><b>Stop</b>: Stopper logging<Br><b>Start</b>: Starter logging<br><b>Clear</b>: nulstiller loggen. log<Br><b>Size</b>: fort�ller hvor meget af loggen er brugt";
$txt[289] = "Du har brugt _s KB af _m KB log plads.";        // _s er hvad du har brugt og _m er hvor meget du kan bruge
$txt[290] = "Du anvendte kommandoen forkert.  venligst <a>Klik Her</a> for at l�re at bruge den.";
$txt[291] = "";
$txt[292] = "Afbryder chat.";
$txt[293] = "_u har overtaget operat�r status fra alle operat�rer.";          
$txt[294] = "Dagens besked er tom.";     
$txt[295] = "<b>Syntax:</b> /userip <i>brugernavn</i> <Br>Denne kommando vil vise dig IP adressen for <i>brugernavn</i>.";
$txt[296] = "_u har inviteret dig til at chatte i rummet _r";        // _u er den person der inviterer dig og _r er rummet
$txt[297] = "<b>Syntax:</b> /invite <i>brugernavn</i> <Br>Denne kommando vil invitere brugeren til at chatte med i det rum du er i.";
$txt[298] = "<b>Syntax:</b> /join <i>rum</i> <Br>Denne kommando vil lade dig deltage i et andet rum.";
$txt[299] = "<a>[Klik Her]</a> for at chatte i _r";        // Lad <a> og </a> v�re, _r er rummet
$txt[300] = "Det rum eksisterer ikke.";
$txt[301] = "<a>[Klik Her]</a> for at oprette det.";        // Lad <a> og </a> v�re
$txt[302] = "<b>Syntax:</b> /msg <i>brugernavn</i> <Br>Denne kommando vil lade dig sende en privat besked til en bruger.";
$txt[303] = "<a>[Klik Her]</a> for at sende en besked til _u";        // Lad <a> og </a> v�re
$txt[304] = "<b>Syntax:</b> /wallchop <i>besked</i> <Br>Denne kommando vil sende din besked til alle chatrums operat�rer.";
$txt[305] = "(Besked til _r Operat�rer Fra _u)";        // _r er rummet, _u er brugeren der sender beskeden

$txt[306] = "Dette er din Administrator Setup.  herfra kan du konfigurere indstillinger, installere mods, opdatere temaer, og styre mange andre aspekter af dine chatrum.";
$txt[307] = "Nyheder fra X7Chat";
$txt[308] = "Temaer";
$txt[309] = "Bruger Gruppen";
$txt[310] = "H�ndter brugere";
$txt[311] = "H�ndter Rum";
$txt[312] = "Ban Liste";
$txt[313] = "B�ndbredde";
$txt[314] = "H�ndter Logs";
$txt[315] = "Kalender";
$txt[316] = "Multi Mail";
$txt[317] = "Smilies";
$txt[318] = "Mods";
$txt[319] = "XUpdater er sl�et fra. Dette modul er n�dvendigt for at anvende denne feature.  Du kan sl� den til ved at rette i config.php.";
$txt[320] = "Der er ingen nyheder lige for tiden.";
$txt[321] = "V�lg venligst en sektions indstillinger til opdatering.";
$txt[322] = "Tid og Dato";
$txt[323] = "Udl�bstider";
$txt[324] = "Banner URL";
$txt[325] = "Stil og beskeder";
$txt[326] = "Avatars";
$txt[327] = "Log ind side";
$txt[328] = "Avanceret";
$txt[329] = "Sl� Chatten fra";
$txt[330] = "tillad Registrering";
$txt[331] = "tillad G�ster";
$txt[332] = "Site navn";
$txt[333] = "Admin E-Mail";
$txt[334] = "Log ud Side";
$txt[335] = "Maks tegn i Status";
$txt[336] = "Maks tegn i beskeder";
$txt[337] = "Maks offline beskeder";
$txt[338] = "Minimum opdateringstid";
$txt[339] = "Maksimum opdateringstid";
$txt[340] = "Kan s�tte til 0 for ingen begr�nsning.";
$txt[341] = "Standard sprog";
$txt[342] = "Standard tema";
$txt[343] = "Dine indstillinger er opdateret.  <a>Klik Her</a> for at vende tilbage til indstillingspanelet.";         
$txt[344] = "Minimums opdateringsfrekvens kan ikke v�re st�rre end maksimumsindstillingen, tsk tsk.";
$txt[345] = "Log sti";
$txt[346] = "Maks Rum Log St�rrelse (KB)";
$txt[347] = "Maks bruger Log St�rrelse (KB)";
$txt[348] = "Tids Format";
$txt[349] = "Dato Format";
$txt[350] = "Fuld Dato/Tids Format";
$txt[351] = "i sekunder";
$txt[352] = "Maks Inaktiv Tid";
$txt[353] = "Beskeder slettes efter";
$txt[354] = "Rum slettes efter";
$txt[355] = "G�stekonti slettes efter";
$txt[356] = "i minutter";
$txt[357] = "Cookie Tid";
$txt[358] = "Baggrunds billede";
$txt[359] = "tillad special rum baggrund";
$txt[360] = "tillad special rum logo";
$txt[361] = "Standard skrifttype";
$txt[362] = "Standard St�rrelse";
$txt[363] = "Standard skriftfarve";
$txt[364] = "Minimum skriftst�rrelse";
$txt[365] = "Maksimum skriftst�rrelse";
$txt[366] = "Sl� Smilies fra";
$txt[367] = "Sl� besked stil fra";
$txt[368] = "Sl� Auto-Linking fra";
$txt[369] = "System skriftfarve";
$txt[370] = "Tilladte skrifttyper*";
$txt[371] = "Adskilt af kommaer";
$txt[372] = "Tillad Avatar Uploads";
$txt[373] = "Auto-forst�r mindre Avatars";
$txt[374] = "Maks Uploaded Avatar St�rrelse (i bytes)";
$txt[375] = "Maks Avatar St�rrelse (bredde x h�jde)";
$txt[376] = "Upload sti";
$txt[377] = "Upload URL";
$txt[378] = "Vis begivenhedskalender";
$txt[379] = "Vis Stats";
$txt[380] = "Sl� kodeordshusker til";
$txt[381] = "Antal viste dage i DagsKalender (1-3)";
$txt[382] = "Vis m�nedskalender";
$txt[383] = "Vis dagskalender";
$txt[384] = "Sl� brugen af GD Library fra";        // GD Info: http://www.boutell.com/gd/
$txt[385] = "Hvis du ikke ved hvad det er, s� lad det v�re sat til. Hvis ikke dit system underst�tter der, bliver det sl�et fra automatisk.";
$txt[386] = "Et rum med det navn eksisterer ikke.";
$txt[387] = "Du kan <a>klikke her</a> for at chatte i det rum.";    
$txt[388] = "Deltag i et privat rum";
$txt[389] = "Deltag";
$txt[390] = "Tema Navn";
$txt[391] = "Er du sikker p� at ville slette dette tema?";
$txt[392] = "Ja";
$txt[393] = "Nej";
$txt[394] = "det valgte tema er nu slettet.";
$txt[395] = "Vi kunne ikke fjerne det valgte tema. Slet venligst mappen _d (det findes i themes mappen) via dit FTP program.";                //_d bliver �ndret til mappe navnet
$txt[396] = "Hvis du satte CHMOD 777 p� tema mappen, er det h�jest anbefalet at lave CHMOD; p� temamappen; til hvad de var f�r.  (normalt 755)";
$txt[397] = "Venligst s�t CHMOD 777 p� teammappen.";
$txt[398] = "CHMOD udf�rt";
$txt[399] = "De f�lgende nye temaer er fundet.";
$txt[400] = "Installer";
$txt[401] = "Fejl: venligst s�t CHMOD 777 p� mods mappen.";
$txt[402] = "Det valgte tema er installeret.";
$txt[403] = "Udgivet";
$txt[404] = "Forfatter";
$txt[405] = "Beskrivelse";
$txt[406] = "Download Nye Temaer";
$txt[407] = "Du er nu rum operat�r, for at komme til Rum Setup skriv: /roomcp";
$txt[408] = "Standard Grupper";
$txt[409] = "Nyt medlem";
$txt[410] = "G�st";
$txt[411] = "Administrator";
$txt[412] = "Din gruppe indstilling er opdateret.";
$txt[413] = "Medlemmer";
$txt[414] = "Ny gruppe";
$txt[415] = "Gruppeskiftet var OK.";
$txt[416] = "Skift gruppe";
$txt[417] = "med valgte, skift gruppe til";
$txt[418] = "F�lgende brugere er i denne gruppe";
$txt[419] = "V�lg/Frav�lg alle";
$txt[420] = "Fjern venligst alle brugere fra brugergruppe F�R du sletter den.";
$txt[421] = "Brugergruppen er slettet.";
$txt[422] = "Kan oprette rum";
$txt[423] = "Kan oprette private rum";
$txt[424] = "Her kan du �ndre de ting en brugergruppe kan g�re.";
$txt[425] = "Kan S�tte Rum til aldrig at udl�be";
$txt[426] = "Kan S�tte Rum til at v�re Modereret";
$txt[427] = "Kan se IP";
$txt[428] = "Kan smide brugere ud";
$txt[429] = "Kan IKKE blive bannet eller smidt ud";
$txt[430] = "Har operat�r status i alle rum";
$txt[431] = "Har skriveret i alle rum";
$txt[432] = "Kan se skjulte E-Mail adresser";
$txt[433] = "Kan tilf�je/slette n�gleord";
$txt[434] = "Kan kontrollere rum logging";
$txt[435] = "Kan logge private beskeder";
$txt[436] = "Kan s�tte rum baggrunde";
$txt[437] = "Kan s�tte rum logoer";
$txt[438] = "Kan give Administrator adgang";
$txt[439] = "Kan sende server beskeder";
$txt[440] = "Kan bruge /mdeop kommando";
$txt[441] = "Kan bruge /mkick kommando";
$txt[442] = "Kan anvende Admin Setup : Indstillinger";
$txt[443] = "Kan anvende Admin Setup : Temaer";
$txt[444] = "Kan anvende Admin Setup : Ord Filter";
$txt[445] = "Kan anvende Admin Setup : BrugerGrupper";
$txt[446] = "Kan anvende Admin Setup : H�ndter brugere";
$txt[447] = "Kan anvende Admin Setup : Ban Liste";
$txt[448] = "Kan anvende Admin Setup : B�ndbredde";
$txt[449] = "Kan anvende Admin Setup : Log Manager";
$txt[450] = "Kan anvende Admin Setup : Multi Mail";
$txt[451] = "Kan anvende Admin Setup : Mods";
$txt[452] = "Kan anvende Admin Setup : Smilies";
$txt[453] = "Kan anvende Admin Setup : Rum";
$txt[454] = "Kan anvende chatrum der er sl�et fra";
$txt[455] = "bruger skal have operat�r status for at bruge funktion";
$txt[456] = "bruger skal have operat�r status og denne funktion skal v�re sl�et til i indstillingssektionen af admin setup.";
$txt[457] = "Kan anvende Admin Panel : Kalender";
$txt[458] = "Rettighederne for denne brugergruppe er opdateret.";
$txt[459] = "Ret";
$txt[460] = "LynRet";
$txt[461] = "Er du sikker p� at ville fjerne denne brugerkonto?";
$txt[462] = "den valgte brugerkonto er nu fjernet.";
$txt[463] = "Brugerkonto ikke fundet.";
$txt[464] = "Brugerkontoen er opdateret.";
$txt[465] = "Er du sikker p� at ville slette dette rum?";
$txt[466] = "Det valgte rum er nu slettet.";
$txt[467] = "Dette rum er slettet.";
$txt[468] = "Log b�ndbredde forbrug";
$txt[469] = "B�ndbredde logging er sl�et fra.  <a>Klik her</a> for at sl� det til.";      
$txt[470] = "B�ndbredde logging er sl�et til.  <a>Klik her</a> for at sl� det fra.";    
$txt[471] = "Standard B�ndbredde begr�nsning (i MegaBytes)";
$txt[472] = "Begr�ns brugere til <i>x</i> MBs pr _t";        //  _t bliver en drop down menu med m�nede og dag
$txt[473] = "M�ned";     
$txt[474] = "Dag";      
$txt[475] = "Brugt";
$txt[476] = "Maks (MB)";
$txt[477] = "V�rdier for anvende b�ndbredde t�ller kun p� 'i chat' sider og inkluderer ikke transmissions headeren. B�ndbredde for andre sider er ikke medregnet.";
$txt[478] = "Kan s�ttes til 0 for ubegr�nset eller -1 for standard";
$txt[479] = "Total B�ndbredde";
$txt[480] = "Du har overskredet maksimumsgr�nsen for tilladt b�ndbreddeforbrug idag, kom venligst igen i morgen.";
$txt[481] = "Du har overskredet maksimumsgr�nsen for tilladt b�ndbreddeforbrug for denne m�ned.  Kom igen i n�ste m�ned.";
$txt[482] = "Logget";
$txt[483] = "H�ndter/Se";
$txt[484] = "Logging er sl�et fra, <a>Klik Her</a> for at sl� det til.";       
$txt[485] = "Logging er sl�et til, <a>Klik Her</a> for at sl� det til.";    
$txt[486] = "Ret log indstillinger";
$txt[487] = "Ret begivenheder";
$txt[488] = "Begivenheder";
$txt[489] = "Tilf�j en begivenhed";
$txt[490] = "Tid (TT:MM)";
$txt[491] = "Anvend 24-timers format";
$txt[492] = "Dato (DD/MM/YYYY)";
$txt[493] = "Du kan skrive en E-Mail her og sende til alle dine registrerede medlemmer.";
$txt[494] = "E-Mail er sendt til alle dine registrerede medlemmer.";
$txt[495] = "Tilf�j Smiley";
$txt[496] = "Kode";
$txt[497] = "Billed URL";
$txt[498] = "F�lgende smilies er installeret.";
$txt[499] = "F�lgende smiley filer blev fundet i Smiley mappen men bliver ikke anvendt.";
$txt[500] = "Du kan tilf�je mange smilies p� �n gang ved at uploade alle billeder du vil bruge til smilies mappen.";
$txt[501] = "Smiley";
$txt[502] = "Bes�g <a href=\"http://x7chat.com/support.php\" target=\"_blank\">vores support side</a> for at se X7 Chat Administrator dokumentation, og f� teknisk support.<Br><br>bruger slutdokumentation er inkluderet i X7 Chat og kan ses p� <a href=\"./help/\" target=\"_blank\">denne side</a>."; 
$txt[503] = "<a>[Klik Her]</a> for at se dokumentationen";    
$txt[504] = "<a>[Klik Her]</a> for at �bne admin setup i et nyt vindue.";          
$txt[505] = "Bliv Usynlig";
$txt[506] = "Se usynlige brugere";
$txt[507] = "Du har ikke tilladelse til at blive usynlig";
$txt[508] = "Du er nu usynlig i dette rum";
$txt[509] = "Du er ikke l�ngere usynlig i dette rum";
$txt[510] = "Tilg� alle rum som usynlig";
$txt[511] = "Du har modtaget en privat besked. Hvis ikke den �bner i et nyt vindue automatisk, s� <a>[Klik Her]</a>";                // Leave <a> and </a> alone
$txt[512] = "_u er blevet bannet fra rummet pga. _r.";        // _u er brugernavn, _r er �rsag
$txt[513] = "_u har f�et fjernet ban fra dette rum.";
$txt[514] = "Ul�st Mail";
$txt[515] = "Maks tegn i brugernavne";
$txt[516] = "Ved at deltage i chatten, erkender du og vil f�lge <a>bruger erkl�ringen</a>.";     
$txt[517] = "Bruger Erkl�ring";
$txt[518] = "Hvis ikke du �nsker at anvende brugererkl�ringen skal du undg� at skrive i feltet. Du kan anvende HTML.";
$txt[519] = "Sl� IP Adressen op";
$txt[520] = "Sl� Op";
$txt[521] = "Du kan slette ekstra r�kker ved at k�re <a>Ryd op</a>";     
$txt[522] = "Du skal s�tte CHMOD 777 f�r loggen vil virke.";
$txt[523] = "Bliv usynlig";
$txt[524] = "Bliv synlig";
$txt[525] = "For at oprette eller rette et team skal du s�tte CHMOD 777 p� mappen 'themes'.  <Br><Br><b>HVIS DU RETTER ET TEMA</b><Br> Hvis du retter et eksisterende tema s�t s� CHMOD 777 p� mappen for temaet som du retter og alle filer i den mappe ogs�. Hvis du ikke g�r det gemmes dine rettelser ikke.  For yderligere hj�lp kan du bes�ge X7 Chat websitet.";
$txt[526] = "Opret nyt tema";
$txt[527] = "Vinduets Baggrunds farve";
$txt[528] = "Hovedsidens Baggrunds farve";
$txt[529] = "Sekund�r sidens Baggrunds farve";
$txt[530] = "Skriftfarve";
$txt[531] = "Menu knap skriftfarve";
$txt[532] = "Header skriftfarve";
$txt[533] = "Skrifttype Familie";
$txt[534] = "Lille skriftst�rrelse";
$txt[535] = "Normal skriftst�rrelse";
$txt[536] = "Stor skriftst�rrelse";
$txt[537] = "St�rre skriftst�rrelse";
$txt[538] = "Kant farve";
$txt[539] = "Sideliggende kant farve";
$txt[540] = "Link farve";
$txt[541] = "Link hover farve";
$txt[542] = "Aktiv link farve";
$txt[543] = "Tekst boks baggrunds farve";
$txt[544] = "Tekst boks kant farve";
$txt[545] = "Tekst boks skriftst�rrelse";
$txt[546] = "Tekst boks skriftfarve";
$txt[547] = "Andre personers navne farve";
$txt[548] = "Dit navns farve";
$txt[549] = "Chat vinduets baggrunds farve";
$txt[550] = "Privat besked vinduets kant farve";
$txt[551] = "Hjemside URL";
$txt[552] = "Tema Navn";
$txt[553] = "Tabel header baggrund";
$txt[554] = "Tema Forfatter";
$txt[555] = "Tema Beskrivelse";
$txt[556] = "Tema Version";
$txt[557] = "Kan ikke finde tema skabelon mappen.";
$txt[558] = "Dit tema er opdateret.";
$txt[559] = "Du skal angive et navn for dit tema.";
$txt[560] = "Chatter i..";
$txt[561] = "Medlemsliste";
$txt[562] = "Header baggrund";
$txt[563] = "Kalender skriftfarve";
$txt[564] = "<b>Syntax:</b> /mkick <i>�rsag</i> <Br>Denne kommando vil smide alle ud af rummet samtidigt.";
$txt[565] = "S�t venligst CHMOD 777 p� mods mappen. For hj�lp til CHMOD bes�g venligst vores hjemmeside.";
$txt[566] = "Hent Mods";
$txt[567] = "Installerede Mods";
$txt[568] = "Afinstaller";
$txt[569] = "Nye Mods";
$txt[570] = "Mod Navn";
$txt[571] = "S�t venligst CHMOD 777 p� f�lgende filer og mapper:";
$txt[572] = "Start Installationen";
$txt[573] = "Sikkerhedskopier Filer & Start";
$txt[574] = "Installationsprocessen fuldf�rt, du kan nu reversere enhver CHMOD kommando du har sat.";
$txt[575] = "Start Afinstallation";
$txt[576] = "Afinstallationsprocess fuldf�rt, du kan nu reversere enhver CHMOD kommando du har sat.";
$txt[577] = "Kan anvende Admin Setup : N�gleord";
$txt[578] = "Tema Information";
$txt[579] = "Tema skrifttyper";
$txt[580] = "Tema Baggrunde";
$txt[581] = "Tema kanter";
$txt[582] = "Tema Links";
$txt[583] = "Tema Input Bokse";
$txt[584] = "Diverser Tema farver";
$txt[585] = "Baggrunds farve 4";
$txt[586] = "Kant stil";
$txt[587] = "Kant st�rrelse";
$txt[588] = "Tekstboks kant stil";
$txt[589] = "Tekstboks kant St�rrelse";
$txt[590] = "Server Rum Type";
$txt[591] = "Multirum Mode";
$txt[592] = "Enkelt Rum";
$txt[593] = "Hvis du s�tter det til Enkelt Rum bliver brugerne tvunget til at anvende det valgte rum efter log ind og kan ikke skifte v�k fra det.";
$txt[594] = "Dette rum anvendes af Enkelt Rums indstillingen, du m� ikke slette det. Sl� venligst Enkelt Rums indstillingern fra under Generelle indstillinger.";
$txt[595] = "* Support Session *";
$txt[596] = "vent venligst, der kommer en supporter lige om lidt.";
$txt[597] = "En fatal fejl opstod. Kontakt venligst chatrum administratoren.  Kopier fejl meddelelsen herunder, og send til admin.";
$txt[598] = "Henter ...";
$txt[599] = "Support Center";
$txt[600] = "Den nye bruger konto er oprettet.";
$txt[601] = "Opret bruger konto";
$txt[602] = "Anvend kodeordsbeskyttede rum uden koderod";
$txt[603] = "Du skal lade dette vindue v�re �bent, support sp�rgsm�l vil fremkomme automatisk i et nyt vindue. Hvis du har en popup blocker sat til, SKAL du fjerne blokeringen for dette site.";
$txt[604] = "Dette panel giver dig mulighed for at tilrette indstillinger for brugen af X7 Chat specifikt som et support chat rum.  Det er anbefalet at du l�ser dokumentationen for at forst� de f�lgende muligheder.";
$txt[605] = "Support Konti";
$txt[606] = "Besked der skal vises hvis supporten ikke er til stede";
$txt[607] = "Online Support billede";
$txt[608] = "Offline Support billede";
$txt[609] = "List brugernavne adskilt af semikolon (;), disse brugere vil have adgang til support centeret";
$txt[610] = "Kontoen du fors�ger at sende besked til eksisterer ikke.";
$txt[611] = "Special RGB V�rdi";
$txt[612] = "Du kan ikke slette standard temaet.";

/* Added in 2.0.1 */
$txt[613] = "This chat room requires E-Mail activation before you can use your account.  Please check the inbox of the E-Mail account that you registered with.";
$txt[614] = "Thank you, your account has been activated.";
$txt[615] = "Unable to activate account, the activation code you entered was not found.";
$txt[616] = "Require Account Activation";
$txt[617] = "Please visit this URL to activate your chatroom account: ";
$txt[618] = "Chatroom Account Activation";

/** Speciale strenge **/

// Dage og m�neder, det er nemmerere og mere effiktivt at g�re det p� denne m�de
$txt['Sunday'] = "S�ndag";
$txt['Monday'] = "Mandag";
$txt['Tuesday'] = "Tirsdag";
$txt['Wednesday'] = "Onsdag";
$txt['Thursday'] = "Torsdag";
$txt['Friday'] = "Fredag";
$txt['Saturday'] = "L�rdag";
$txt['January'] = "Januar";
$txt['February'] = "Februar";
$txt['March'] = "Marts";
$txt['April'] = "April";
$txt['May'] = "Maj";
$txt['June'] = "Juni";
$txt['July'] = "Juli";
$txt['August'] = "August";
$txt['September'] = "September";
$txt['October'] = "Oktober";
$txt['November'] = "November";
$txt['December'] = "December";

?>
