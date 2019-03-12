<?php
	ob_start();
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	session_start();
	include 'config.php';
	$date = date("Y-m-d H:i:s"); 
	include 'functions.php';
	/* 
	* Defining Time data's ending words array for extracting the time data 
	*/
	$timeStringEndTagArray = array(
		'St)',
		'St).',
		'St.)',
		'St. )',
		'St.).',
		'Tagen.)',
		'Tagen.).',
		'Tagen)',
		'Tagen).',
		'Nacht)',
		'Tag)',
		'Tag).',
		'Tag.)',
		'Tag.).',
		'T)',
		'T).',
		'T.)',
		'T.).',
		'Uhr.).',
		'Uhr).',
		'Uhr)',
		'Uhr.)',
		'Uhr),',
		'Uhr.),',
		'hour.).',
		'hour).',
		'hour)',
		'hour.)',
		'hour),',
		'hour.),',
		'hours)',
		'hours).',
		'hours.)',
		'hours.).',
		'hours),',
		'hours.),',
		'Hour.).',
		'Hour).',
		'Hour)',
		'Hour.)',
		'Hour),',
		'Hour.),',
		'Hours)',
		'Hours).',
		'Hours.)',
		'Hours.).',
		'Hours),',
		'Hours.),',
		'minute.).',
		'minute).',
		'minute.)',
		'minute)',
		'minute),',
		'minute.),',
		'minutes)',
		'minutes).',
		'minutes.)',
		'minutes.).',
		'minutes),',
		'minutes.),',
		'Minute.).',
		'Minute).',
		'Minute.)',
		'Minute)',
		'Minute),',
		'Minute.),',
		'Minutes)',
		'Minutes).',
		'Minutes.)',
		'Minutes.).',
		'Minutes),',
		'Minutes.),',
		'Noon)',
		'Noon).',
		'Noon.)',
		'Noon.).',
		'Noon),',
		'Noon.),',
		'noon)',
		'noon).',
		'noon.)',
		'noon.).',
		'noon),',
		'noon.),',
		'Afternoon)',
		'Afternoon).',
		'Afternoon.)',
		'Afternoon.).',
		'Afternoon),',
		'Afternoon.),',
		'afternoon)',
		'afternoon).',
		'afternoon.)',
		'afternoon.).',
		'afternoon),',
		'afternoon.),'
	);

	for ($i=0; $i < 10; $i++) { 
		$am = $i." am)";
		$amWdot = $i." am).";
		$amEndingDot = $i." am.)";
		$amEndingDotWdot = $i." am.).";
		$amBothDot = $i." a.m.)";
		$amBothDotWdot = $i." a.m.).";
		$amNoSpace = $i."am)";
		$amNoSpaceWdot = $i."am).";
		$amNoSpaceEndingDot = $i."am.)";
		$amNoSpaceEndingDotWdot = $i."am.).";
		$amNoSpaceBothDot = $i."a.m.)";
		$amNoSpaceBothDotWdot = $i."a.m.).";

		$AM = $i." AM)";
		$AMWdot = $i." AM).";
		$AMEndingDot = $i." AM.)";
		$AMEndingDotWdot = $i." AM.).";
		$AMBothDot = $i." A.M.)";
		$AMBothDotWdot = $i." A.M.).";
		$AMNoSpace = $i."AM)";
		$AMNoSpaceWdot = $i."AM).";
		$AMNoSpaceEndingDot = $i."AM.)";
		$AMNoSpaceEndingDotWdot = $i."AM.).";
		$AMNoSpaceBothDot = $i."A.M.)";
		$AMNoSpaceBothDotWdot = $i."A.M.).";

		$pm = $i." pm)";
		$pmWdot = $i." pm).";
		$pmEndingDot = $i." pm.)";
		$pmEndingDotWdot = $i." pm.).";
		$pmBothDot = $i." p.m.)";
		$pmBothDotWdot = $i." p.m.).";
		$pmNoSpace = $i."pm)";
		$pmNoSpaceWdot = $i."pm).";
		$pmNoSpaceEndingDot = $i."pm.)";
		$pmNoSpaceEndingDotWdot = $i."pm.).";
		$pmNoSpaceBothDot = $i."p.m.)";
		$pmNoSpaceBothDotWdot = $i."p.m.).";

		$PM = $i." PM)";
		$PMWdot = $i." PM).";
		$PMEndingDot = $i." PM.)";
		$PMEndingDotWdot = $i." PM.).";
		$PMBothDot = $i." P.M.)";
		$PMBothDotWdot = $i." P.M.).";
		$PMNoSpace = $i."PM)";
		$PMNoSpaceWdot = $i."PM).";
		$PMNoSpaceEndingDot = $i."PM.)";
		$PMNoSpaceEndingDotWdot = $i."PM.).";
		$PMNoSpaceBothDot = $i."P.M.)";
		$PMNoSpaceBothDotWdot = $i."P.M.).";


		array_push($timeStringEndTagArray, $am, $amWdot, $amEndingDot, $amEndingDotWdot, $amBothDot, $amBothDotWdot, $amNoSpace, $amNoSpaceWdot, $amNoSpaceEndingDot, $amNoSpaceEndingDotWdot, $amNoSpaceBothDot, $amNoSpaceBothDotWdot, $AM, $AMWdot, $AMEndingDot, $AMEndingDotWdot, $AMBothDot, $AMBothDotWdot, $AMNoSpace, $AMNoSpaceWdot, $AMNoSpaceEndingDot, $AMNoSpaceEndingDotWdot, $AMNoSpaceBothDot, $AMNoSpaceBothDotWdot, $pm, $pmWdot, $pmEndingDot, $pmEndingDotWdot, $pmBothDot, $pmBothDotWdot, $pmNoSpace, $pmNoSpaceWdot, $pmNoSpaceEndingDot, $pmNoSpaceEndingDotWdot, $pmNoSpaceBothDot, $pmNoSpaceBothDotWdot, $PM, $PMWdot, $PMEndingDot, $PMEndingDotWdot, $PMBothDot, $PMBothDotWdot, $PMNoSpace, $PMNoSpaceWdot, $PMNoSpaceEndingDot, $PMNoSpaceEndingDotWdot, $PMNoSpaceBothDot, $PMNoSpaceBothDotWdot);
	}

	if(isset($_POST['submit'])){

		if(isset($_POST['settings']) && $_POST['settings'] == "default_setting"){

			/* Rule 1 Start */
			$CleanedText = str_replace ( '</em><em>', '', $_POST['symptomtext'] );

			// $string = 'Haaaa <em>JJJJ</em><span>Hello..</span><span  class="heading" data-mce-style="letter-spacing: 3.0pt;" style="z-index:2px; font-size:5px; letter-spacing: 3.0pt; color:red;">hhhhhh</span><span style="letter-spacing: 3.0pt; font-size:5px;">Pabo</span> <span style="letter-spacing: 3.0pt;" data-mce-style="letter-spacing: 3.0pt;">Hoffnungslosigkeit.</span> heloww mew <a>hjgsd</a><span style="letter-spacing: 3.0pt;">Hoffnungslosigkeit.</span><span>How are you</span>';

			// $string = '<span >Helllo World</span><span style="font-size:12.0pt;font-family:&quot;Times New Roman&quot;,&quot;serif&quot;;
			// 	mso-fareast-font-family:&quot;Times New Roman&quot;;color:red;mso-ansi-language:EN-US;
			// 	mso-fareast-language:DE;mso-bidi-language:AR-SA">Stupor, with involuntary
			// 	discharge of feces.</span>';

			// $string .= '<span>Helllo World</span><span class="agsh" style="font-size: 12.0pt; mso-ansi-language: EN-US; mso-fareast-language: DE; mso-bidi-language: AR-SA;">PREFIX</span><span class="hecd" style="color:red;">I am Without any style</span><span style="font-size: 12.0pt; mso-ansi-language: EN-US; mso-fareast-language: DE; mso-bidi-language: AR-SA;">PREFIX</span><span style="font-size: 12.0pt; mso-ansi-language: EN-US; mso-fareast-language: DE; mso-bidi-language: AR-SA;">&nbsp;Concussion of brain.<br><strong><span style="color: blue;">Comatose, soporous, stupid states.</span></strong></span><span style="font-size: 12.0pt; mso-ansi-language: EN-US; mso-fareast-language: DE; mso-bidi-language: AR-SA;">SUFEX</span><span class="Hagt" style="color:blue;" title="heow">Last Test</span>';	

			// $count = 0; 
			// do { 
			// 	// $string = preg_replace("#<span[^>]*style=(\"|')[^>]*color:(.+?);[^>]*(\"|')>(.+?)</span>#is", "<clr style='color:$2;'>$4</clr>", $string, -1, $count ); 
			// 	$string = preg_replace("#<span[^>]*style=(\"|')[^>]*letter-spacing:[^>]*>(.+?)</span>#is", "<ss>$2</ss>", $string, -1, $count ); 
			// } while ( $count > 0 );

			// echo $string;
			// exit();

			// echo $CleanedText;
			// exit();

			$CleanedText = str_replace ( array (
				"\r",
				"\t" 
			), '', $CleanedText );
			$CleanedText = trim ( $CleanedText );
			$Lines = explode ( "\n", $CleanedText );

			// echo '<pre>';
			// print_r($Lines);
			// exit();
			if (count ( $Lines ) > 0) {
				$rownum = 1;
				$break = false;
				$Symptomnummer = 1;
				$SeiteOriginalVon = '';
				$SeiteOriginalBis = '';
				$prueferFromParray = array ();
				$prueferIDarray = array ();
				//$Pruefers = '';
				$Beschreibung = '';
				$Fussnote='';
				$Graduierung='';
				$BereichID='';
				$aLiteraturquellen = array ();
				$EntnommenAus='';
				$Verweiss = '';
				$Unklarheiten = '';
				$Kommentar = '';
				$bracketedString='';
				$timeString='';
				$parenthesesStringArray= array ();
				$timeStringArray= array ();
				$bracketedStringArray= array ();
				$strongRedStringArray= array ();
				$strongBlueStringArray= array ();
				$needApproval = 0;
				$remedyArray = array();
				$prueferArray = array();
				$referenceArray = array();
				$prueferPriority = 0;
				$remedyPriority = 0;
				$partOfSymptomPriority = 0;
				$referenceWithNoAuthorPriority = 0;
				$referencePriority = 0;
				$remedyWithSymptomPriority = 0;
				$moreThanOneTagStringPriority = 0;
				$aaoHyphenPriority = 0;
				$hyphenPrueferPriority = 0;
				$hyphenReferencePriority = 0;
				$hyphenApprovalString = "";
				$directOrderPriority = 0;
				$tagsApprovalString = "";
				$isPreDefinedTagsApproval = 0;
				$symptomOfDifferentRemedy = "";

				/* quelle_import_master table fields start */
				$importRule = (isset($_POST['settings']) AND $_POST['settings'] != "") ? mysqli_real_escape_string($db, $_POST['settings']) : null;
				/* quelle_import_master table fields end */
				//$date = date("Y-m-d H:i:s"); 


				$isThereAnyTransactionError = 0;
				/* MySQL Transaction START */
				try{
					// First of all, let's begin a transaction
    				$db->begin_transaction();

    				$masterQuery="INSERT INTO temp_quelle_import_master (import_rule, ersteller_datum) VALUES ('".$importRule."', '".$date."')";
		            $db->query($masterQuery);
		            $masterId = mysqli_insert_id($db);

		            // If we arrive here, it means that no exception was thrown
				    // i.e. no query has failed, and we can commit the transaction
				    $db->commit();

				}catch (Exception $e) {
				    // An exception has been thrown
				    // We must rollback the transaction
				    $db->rollback();
				    $isThereAnyTransactionError = 1;
 				}
				/* MySQL Transaction END */


				// If No Transaction error occur above
				if($isThereAnyTransactionError == 0){

					foreach ( $Lines as $iline => $line ) {

						/* MySQL Transaction START */
						try{
							// First of all, let's begin a transaction
							$db->begin_transaction();
							/*
							* Replacing Colored sentences's tag to our custom tag "<clr>"
							*/
							// $line = preg_replace("/<span(.*?)style=(\"|')(.*?)letter-spacing:(.+?)>(.+?)<\/span>/is", "<ss>$5</ss>", $line);
							// $line = preg_replace("/<span(.*?)style=(\"|')(.*?)color:(.+?);(.*?)>(.+?)<\/span>/is", "<clr style='color:$4;'>$6</clr>", $line);
							$coloredTextCnt = 0; 
							do { 
								$line = preg_replace("#<span[^>]*style=(\"|')[^>]*color:(.+?);[^>]*(\"|')>(.+?)</span>#is", "<clr style=\"color:$2;\">$4</clr>", $line, -1, $coloredTextCnt ); 
							} while ( $coloredTextCnt > 0 );
							/*
							* Replacing Spaced sentences's tag to our custom tag "<ss>"
							*/
							$letterSpaceCnt = 0; 
							do { 
								$line = preg_replace("#<span[^>]*style=(\"|')[^>]*letter-spacing:[^>]*>(.+?)</span>#is", "<ss>$2</ss>", $line, -1, $letterSpaceCnt ); 
							} while ( $letterSpaceCnt > 0 );
							
							
							$line = strip_tags ( $line, '<b><i><strong><em><u><sup><ss><clr>' );
							$break = false;
							$NewSymptomNr = 0;
							$line = trim ( $line );
							
							// $line = htmlentities($line);
							/*$cleanline = trim ( str_replace ( array (
								'&nbsp;',
								', a. a. O.' 
							), array (
								' ',
								'' 
							), strip_tags ( $line ) ) );*/
							$cleanline = trim ( str_replace ( '&nbsp;', ' ', htmlentities(strip_tags ( $line )) ) );
							$cleanline = html_entity_decode($cleanline);
							// $line = html_entity_decode($line);
							// $cleanline = html_entity_decode($cleanline);

							
							// Leerzeile
							if (empty ( $cleanline )) {
								$rownum ++;
								continue;
							}
							
							if (mb_strlen ( $cleanline ) < 3) { //added
								$rownum ++;
								continue;
							}
							$FirstChar = mb_substr ( $cleanline, 0, 1 );
							$LastChar = mb_substr ( $cleanline, mb_strlen ( $cleanline ) - 1 );
							$LastTwoChar = mb_substr ( $cleanline, mb_strlen ( $cleanline ) - 2 );

							$code='';
							$param='';

							if($FirstChar == '@'){
								$Beschreibung = '';
								$p = mb_strpos ( $cleanline, ':' );
								if ($p > 0) {
									$code = mb_substr ( $cleanline, 1, $p - 1 );
									$param = mb_substr ( $cleanline, $p + 1 );
								} else {
									$code = mb_substr ( $cleanline, 1 );
									$param = '';
								}
								
								$code = mb_strtoupper ( $code );

								switch ($code) {
									// Graduierung
									case 'G' :
										$Graduierung = $param;
										break;
									
									// Kapitel, setzt in DS "KapitelID"
									// case 'B' :
									case 'K' :
										$BereichID = $param;
										break;
									
									// Seite, setzt in DS "Seite"
									case 'S' :
										$tmp = explode ( '-', $param );
										$SeiteOriginalVon = $tmp [0] + 0;
										if (sizeof ( $tmp ) > 1)
											$SeiteOriginalBis = $tmp [1] + 0;
										else
											$SeiteOriginalBis = $SeiteOriginalVon;
										break;
									
									// Symptom-Nr., setzt in DS "Symptomnummer"
									case 'N' :
										$NewSymptomNr = $param + 0;
										if ($NewSymptomNr == 0) {
											//$NewSymptomNr = 1;
											$Symptomnummer = 0;
										}
										break;
									
									// Literaturquelle, setzt in DS "EntnommenAus"
									case 'L' :
										$aLiteraturquellen [] = $param;
										break;
									
									// Fußnote
									case 'F' :
										$Fussnote = $param;
										break;
									
									// Verweiss
									case 'V' :
										$Verweiss = $param;
										break;
									
									// @U: (Unklarheit, steht wie auch @F und @L VOR dem einen Symptom, welches betroffen ist)
									case 'U' :
										$Unklarheiten = $param;
										break;
									
									// @C: (Kommentar, steht wie auch @F und @L VOR dem einen Symptom, welches betroffen ist)
									case 'C' :
										$Kommentar = $param;
										break;
									
									// @P: Prüfer als Kürzel
									case 'P' :
										// $PrueferID = $this->LookupPruefer ( $param, $rownum );
										// $PrueferID = $param;
										// if ($PrueferID > 0) {
										// 	$PrueferIDs [] = $PrueferID;
										// } 
										$prueferFromParray [] = $param;
										break;
									
									default :
										continue;
								}
								//continue;
							} else if ($FirstChar == '(') {
								/* 
								* parseing symptoms nummer which has parentheses between symptom nummer 
								* Eg : (90) Fauleier-Geschmack im Munde, außer dem Essen. (Fr. Hahnemann.)
								*/
								$p = mb_strpos ( $line, ')' );
								if ($p > 0) {
									$NewSymptomNr = trim ( mb_substr ( $line, 1, $p - 1 ) );
									if (is_numeric ( $NewSymptomNr )) {
										$Beschreibung = trim ( mb_substr ( $line, $p + 1 ) );
										$cleanline = trim ( mb_substr ( $cleanline, $p + 1 ) );
									} else {
										$NewSymptomNr = 0;
										$Beschreibung = $line;
									}
								}
							} else {
								$isSymptomNum = is_numeric ( $FirstChar );
								$Beschreibung = '';
								
								if ($isSymptomNum) {
									/* 
									* parseing symptoms nummer which has space between symptom nummer and symptom string 
									* Eg : 30 Merklich vermindertes Gehör. (n. 30 St.)
									*/
									$p = mb_strpos ( $line, ' ' );
									$num = str_replace ( array (
										':',
										'.', 
										')' 
									), '', mb_substr ( $line, 0, $p ) );
									if( is_numeric($num) ){
										$NewSymptomNr = $num;
										$Beschreibung = trim ( mb_substr ( $line, $p + 1 ) );
										$cleanline = trim ( mb_substr ( $cleanline, $p + 1 ) );
									}else{
										/* 
										* parseing symptoms nummer which are attached with Synptom string 
										* Eg : 10Drückender Schmerz in der Stirne.
										*/
										$charCount = 2;
										$NewSymptomNr = $FirstChar;
										while ( $charCount > 0 ) {
											$checkSymptomNumber = mb_substr ( $line, 0, $charCount );
											if( is_numeric($checkSymptomNumber) ){
												$NewSymptomNr = $checkSymptomNumber;
												$charCount++;
											}else
												$charCount = 0;
										}

										if (mb_substr($line, 0, mb_strlen($NewSymptomNr)) == $NewSymptomNr) {
										    $Beschreibung = trim ( mb_substr($line, mb_strlen($NewSymptomNr)) );
										    $cleanline = trim ( mb_substr($cleanline, mb_strlen($NewSymptomNr)) );
										}else{
											$Beschreibung = $line;
										} 
									}
								} else {
									$NewSymptomNr = 0;
									$Beschreibung = $line;
								}
							}

							if ( $NewSymptomNr > 0 ) {
								$Symptomnummer = $NewSymptomNr;
							}
							
							if ($Beschreibung) {

								/* Creating Plain Symptom text */
								$BeschreibungPlain = trim ( str_replace ( "\t", '', strip_tags ( $Beschreibung ) ) );


								/*
								* Checking Is  symptom allready exist START
								*/
								$isSymptomAlreadyExist = 0;
								// Check Is Symptom already there in Main Table
								$checkSymptomMainResult = mysqli_query($db, "SELECT id FROM quelle_import_test where BeschreibungPlain = '".$BeschreibungPlain."'");
								if(mysqli_num_rows($checkSymptomMainResult) > 0){
									$isSymptomAlreadyExist = 1;
								}

								$checkSymptomTempResult = mysqli_query($db, "SELECT id FROM temp_quelle_import_test where BeschreibungPlain = '".$BeschreibungPlain."'");
								if(mysqli_num_rows($checkSymptomTempResult) > 0){
									$isSymptomAlreadyExist = 1;
								}

								if($isSymptomAlreadyExist == 1)
									continue;
								/*
								* Checking Is  symptom allready exist END
								*/
	
								/* Creating Source or as it is Symtom text start */
								$Beschreibung2 = str_replace ( array (
									'<ss>',
									'</ss>' 
								), array (
									"<span class=\"text-sperrschrift\">",
									"</span>" 
								), $Beschreibung );

								/* Creating Original Symptom text start */
								$BeschreibungOriginal = strip_tags ( $Beschreibung2, '<b><i><strong><em><u><sup><span>' );
								$BeschreibungOriginal = preg_replace("#<span[^>]*></span>#is", "", $BeschreibungOriginal ); 
								$BeschreibungOriginal = preg_replace("#<strong[^>]*></strong>#is", "", $BeschreibungOriginal ); 
								$BeschreibungOriginal = preg_replace("#<b[^>]*></b>#is", "", $BeschreibungOriginal ); 
								$boldCnt = 0; 
								do { 
									$BeschreibungOriginal = preg_replace("#<b[^>]*>(.+?)</b>#is", "<span class=\"text-sperrschrift\">$1</span>", $BeschreibungOriginal, -1, $boldCnt ); 
								} while ( $boldCnt > 0 );

								$strongCnt = 0; 
								do { 
									$BeschreibungOriginal = preg_replace("#<strong[^>]*>(.+?)</strong>#is", "<span class=\"text-sperrschrift\">$1</span>", $BeschreibungOriginal, -1, $strongCnt ); 
								} while ( $strongCnt > 0 );
								/* Creating Original Symptom text end */

								$Beschreibung2 = str_replace ( array (
									'<clr',
									'</clr>' 
								), array (
									"<span",
									"</span>" 
								), $Beschreibung2 );
								if ($Beschreibung2 != $Beschreibung) {
									$Beschreibung = $Beschreibung2;
								}
								/* Creating Source or as it is Symtom text end */

								/* Getting parentheses or square brackets datas start */
								$bracketP = false;

								if ($LastChar == ')' or $LastTwoChar ==').' or $LastTwoChar =='),') {
									//echo $FirstChar." ... ".$LastChar;
									// $FirstOccurrence = mb_stripos ( $cleanline, '(' );
									// if($FirstOccurrence != 0){
										$bracketP = mb_strripos ( $cleanline, '(' );
										//echo $FirstChar." ... ".$LastChar." -> ".$bracketP;
										//exit();
										if ($bracketP > 0) {
											
											/* 
											* Cheching is there any nested parentheses string, and taking the appropriate action 
											* Eg: (95) Leeres Aufstoßen. (n. 1/4 St.) (Hornburg, a. a. O. - (n. 1/2 St.)Kummer, a. a. O.) 
											*/
											$rowParenthesesString = mb_substr ( $cleanline, $bracketP );
											// Checking is the given bracketed string contains nested brackets
											$checkForNestedbrackets = isNestedBracket($cleanline, $rowParenthesesString, "(", ")");
											if(isset($checkForNestedbrackets['status']) && $checkForNestedbrackets['status'] === TRUE){
												$rowParenthesesString = $checkForNestedbrackets['bracketed_string'];
												$parenthesesStringArray[] = $rowParenthesesString;
												/*
												* Here storing the remaining from the begning to (full string minus that above found nested parentheses) for checking if there more parentheses set 
												*/
												$newString = rtrim( mb_substr ( $cleanline, 0, mb_strlen($cleanline)-mb_strlen($rowParenthesesString) ) );
											}
											else{
												/*
												* Checking if it's time data or not
												* function isTimeString
												* Parameters: compareing string, position of opening bracket, timeStringEndTagArray 
												*/
												$checkForTimeString = isTimeString($cleanline, $bracketP, $timeStringEndTagArray);
												if($checkForTimeString != false){
													// $timeStringArray[] = $checkForTimeString; // all time data extracted form the symptom below Plz check below
												}else{
													$parenthesesStringArray[] = rtrim( mb_substr ( $cleanline, $bracketP + 1, - 1 ), ')' );	
												}
												/*
												* Here storing the remaining from the begning to last occurance of "(" for checking if there more parentheses set 
												*/
												$newString = rtrim( mb_substr ( $cleanline, 0, $bracketP ) );
											}
											 
											while ($newString != "") {
												$cleanedRemainingString = rtrim($newString);
												if (mb_substr($newString,-mb_strlen('und'))==='und') 
													$cleanedRemainingString = rtrim( mb_substr($newString, 0, mb_strlen($newString)-mb_strlen('und')));
												else if (mb_substr($newString,-mb_strlen('and'))==='and') 
													$cleanedRemainingString = rtrim( mb_substr($newString, 0, mb_strlen($newString)-mb_strlen('and')));
												else if (mb_substr($newString,-mb_strlen('.'))==='.') 
													$cleanedRemainingString = rtrim( mb_substr($newString, 0, mb_strlen($newString)-mb_strlen('.')));
												else if (mb_substr($newString,-mb_strlen(','))===',') 
													$cleanedRemainingString = rtrim( mb_substr($newString, 0, mb_strlen($newString)-mb_strlen(',')));

												$cleanedRemainingString = rtrim($cleanedRemainingString);
												$newLastChar = mb_substr ( $cleanedRemainingString, mb_strlen ( $cleanedRemainingString ) - 1 );
												
												if( $newLastChar == ')' ){
													$newBracketP = mb_strripos ( $cleanedRemainingString, '(' );
													if ($newBracketP > 0) {
														/* 
														* Cheching is there any nested parentheses string, and taking the appropriate action 
														* Eg: (95) Leeres Aufstoßen. (n. (1/4) St.) (Hornburg, a. a. O. - (n. 1/2 St.)Kummer, a. a. O.) 
														*/
														$newRowParenthesesString = mb_substr ( $cleanedRemainingString, $newBracketP );
														// Checking is the given bracketed string contains nested brackets
														$checkForNestedbrackets = isNestedBracket($cleanedRemainingString, $newRowParenthesesString, "(", ")");
														if(isset($checkForNestedbrackets['status']) && $checkForNestedbrackets['status'] === TRUE){
															$newRowParenthesesString = $checkForNestedbrackets['bracketed_string'];
															$parenthesesStringArray[] = $newRowParenthesesString;
															/*
															* Here storing the remaining from the begning to (full string minus that above found nested parentheses) for checking if there more parentheses set 
															*/
															$newString = rtrim( mb_substr ( $cleanedRemainingString, 0, mb_strlen($cleanedRemainingString)-mb_strlen($newRowParenthesesString) ) );
														}
														else{
															/*
															* Checking if it's time data or not
															* function isTimeString
															* Parameters: compareing string, position of opening bracket, timeStringEndTagArray 
															*/
															$checkForTimeString = isTimeString($cleanedRemainingString, $newBracketP, $timeStringEndTagArray);
															if($checkForTimeString != false){
																// $timeStringArray[] = $checkForTimeString; // all time data extracted form the symptom below Plz check below
															}else{
																$parenthesesStringArray[] = mb_substr ( $cleanedRemainingString, $newBracketP + 1, - 1 );
															}
															/*
															* Here storing the remaining from the begning to last occurance of "(" for checking if there more parentheses set 
															*/
															$newString = rtrim( mb_substr ( $cleanedRemainingString, 0, $newBracketP ) );
														}

													}
													else
														$newString = "";
												}
												else
													$newString = "";
											}
											$bracketedString = implode('{#^#} ', $parenthesesStringArray);
											// $timeString = implode(', ', $timeStringArray);
											// echo $bracketedString." - ".$newString;
											// exit();
										}
									// }
								} else if ($LastChar == ']' or $LastTwoChar =='].') {
									// $FirstOccurrence = mb_stripos ( $cleanline, '[' );
									// if($FirstOccurrence != 0){
										$bracketP = mb_strripos ( $cleanline, '[' );
										//echo $FirstChar." ... ".$LastChar." -> ".$bracketP;
										//exit();
										if ($bracketP > 0) {
											/* 
											* Cheching is there any nested bracketed string, and taking the appropriate action 
											* Eg: (95) Leeres Aufstoßen. [n. 1/4 St.] [Hornburg, a. a. O. - [n. 1/2 St.]Kummer, a. a. O.] 
											*/
											$rowBracketedString = mb_substr ( $cleanline, $bracketP );
											// Checking is the given bracketed string contains nested brackets
											$checkForNestedbrackets = isNestedBracket($cleanline, $rowBracketedString, "[", "]");
											if(isset($checkForNestedbrackets['status']) && $checkForNestedbrackets['status'] === TRUE){
												$rowBracketedString = $checkForNestedbrackets['bracketed_string'];
												$bracketedStringArray[] = $rowBracketedString;
												/*
												* Here storing the remaining from the begning to (full string minus that above found nested bracket) for checking if there more bracket set 
												*/
												$newString = rtrim( mb_substr ( $cleanline, 0, mb_strlen($cleanline)-mb_strlen($rowBracketedString) ) );
											}
											else{
												// last characters can be ']' or '].' also so rtrim ']'
												$bracketedStringArray[] = rtrim( mb_substr ( $cleanline, $bracketP + 1, - 1 ), ']' );
												$newString = rtrim( mb_substr ( $cleanline, 0, $bracketP ) );
											}
											
											while ($newString != "") {
												$cleanedRemainingString = rtrim($newString);
												if (mb_substr($newString,-mb_strlen('und'))==='und') 
													$cleanedRemainingString = rtrim( mb_substr($newString, 0, mb_strlen($newString)-mb_strlen('und')));
												else if (mb_substr($newString,-mb_strlen('and'))==='and') 
													$cleanedRemainingString = rtrim( mb_substr($newString, 0, mb_strlen($newString)-mb_strlen('and')));
												else if (mb_substr($newString,-mb_strlen('.'))==='.') 
													$cleanedRemainingString = rtrim( mb_substr($newString, 0, mb_strlen($newString)-mb_strlen('.')));

												$cleanedRemainingString = rtrim($cleanedRemainingString);
												$newLastChar = mb_substr ( $cleanedRemainingString, mb_strlen ( $cleanedRemainingString ) - 1 );
												
												if( $newLastChar == ']' ){
													$newBracketP = mb_strripos ( $cleanedRemainingString, '[' );
													if ($newBracketP > 0) {
														/* 
														* Cheching is there any nested bracketed string, and taking the appropriate action 
														* Eg: (95) Leeres Aufstoßen. [n. [1/4] St.] [Hornburg, a. a. O. - [n. 1/2 St.]Kummer, a. a. O.] 
														*/
														$newRowBracketedString = mb_substr ( $cleanedRemainingString, $newBracketP );
														// Checking is the given bracketed string contains nested brackets
														$checkForNestedbrackets = isNestedBracket($cleanedRemainingString, $newRowBracketedString, "[", "]");
														if(isset($checkForNestedbrackets['status']) && $checkForNestedbrackets['status'] === TRUE){
															$newRowBracketedString = $checkForNestedbrackets['bracketed_string'];
															$bracketedStringArray[] = $newRowBracketedString;
															/*
															* Here storing the remaining from the begning to (full string minus that above found nested bracket) for checking if there more bracket set 
															*/
															$newString = rtrim( mb_substr ( $cleanedRemainingString, 0, mb_strlen($cleanedRemainingString)-mb_strlen($newRowBracketedString) ) );
														}
														else{
															$bracketedStringArray[] = mb_substr ( $cleanedRemainingString, $newBracketP + 1, - 1 );
															$newString = rtrim( mb_substr ( $cleanedRemainingString, 0, $newBracketP ) );
														}

													}
													else
														$newString = "";
												}
												else
													$newString = "";
											}
											$bracketedString = implode('{#^#} ', $bracketedStringArray);
											// echo $bracketedString." - ".$newString;
											// exit();
										}
									// }
								}
								/* Getting parentheses or square brackets datas end */

								/* Find all time data in the entire Symptom string */
								$allTimeStringsArray = getAllTimeData($cleanline, $timeStringEndTagArray);
								if(!empty($allTimeStringsArray)){
									$timeString = implode(', ', $allTimeStringsArray);
								}

								/* Extracting Pruefer Data and Literaturquellen data Start */
								if( count($aLiteraturquellen) > 0 AND  count($prueferFromParray) > 0 ){
									/* When @L nad @P both are present in a symptom */

									$isPreDefinedTagsApproval = 1;
									$ckeckPApproval = 0;
									$tagsApproalStringForPrue = "";
									foreach ($prueferFromParray as $prueferPkey => $prueferPval) {
										$prueferPval = trim($prueferPval);
										$tagsApproalStringForPrue .= $prueferPval."{#^#}";

										$cleanPrueferString = (mb_substr ( $prueferPval, mb_strlen ( $prueferPval ) - 1, 1 ) == '.') ? $prueferPval : $prueferPval.'.';
										$prueferReturnArr = lookupPruefer($cleanPrueferString);
										if(isset($prueferReturnArr['need_approval']) AND $prueferReturnArr['need_approval'] == 1){
											$ckeckPApproval = 1;

											if(!empty($prueferReturnArr['data'])){
												foreach ($prueferReturnArr['data'] as $prueferReturnKey => $prueferReturnVal) {
													// custom_in_array(needle, needle_field, array)
													if(custom_in_array($prueferReturnArr['data'][$prueferReturnKey]['pruefer_id'], 'pruefer_id', $prueferArray) != true)
														$prueferArray[] = $prueferReturnArr['data'][$prueferReturnKey];
												}
											}
											else{
												$dataArr = array();
												$dataArr['pruefer_id'] = null;
												$dataArr['kuerzel'] = null;
												$dataArr['suchname'] = trim($prueferPval);
												// custom_in_array(needle, needle_field, array)
												if(custom_in_array($dataArr['suchname'], 'suchname', $prueferArray) != true)
													$prueferArray[] = $dataArr;
											}
										}
										else{
											foreach ($prueferReturnArr['data'] as $prueferReturnKey => $prueferReturnVal) {
												// custom_in_array(needle, needle_field, array)
												if(custom_in_array($prueferReturnArr['data'][$prueferReturnKey]['pruefer_id'], 'pruefer_id', $prueferArray) != true)
													$prueferArray[] = $prueferReturnArr['data'][$prueferReturnKey];
											}
										}
									}

									/* Literaturquellen data */
									$ckeckRApproval = 0;
									$tagsApproalStringForRef = "";
									foreach ($aLiteraturquellen as $refKey => $refVal) {
										$tagsApproalStringForRef .= $refVal."{#^#}";

										$refVal = trim($refVal);
										$referenceReturnArr = lookupLiteratureReference($refVal);
										if(isset($referenceReturnArr['need_approval']) AND $referenceReturnArr['need_approval'] == 1){
											$ckeckRApproval = 1;

											if(!empty($referenceReturnArr['data'])){
												foreach ($referenceReturnArr['data'] as $referenceReturnKey => $referenceReturnVal) {
													// custom_in_array(needle, needle_field, array)
													if(custom_in_array($referenceReturnArr['data'][$referenceReturnKey]['reference_id'], 'reference_id', $referenceArray) != true)
														$referenceArray[] = $referenceReturnArr['data'][$referenceReturnKey];
												}
											}
											else{
												$fullReferenceInArray = explode(",", $refVal);
												if(count($fullReferenceInArray) >= 2){
													$referenceAutor = trim($fullReferenceInArray[0]);
									        		array_shift($fullReferenceInArray);
									        		$referenceTxt = rtrim(implode(",", $fullReferenceInArray), ",");
												}else{
													$referenceAutor = "";
													$referenceTxt = $refVal;
												}
												
												$dataArr = array();
												$dataArr['reference_id'] = null;
												$dataArr['full_reference'] = $refVal;
												$dataArr['autor'] = $referenceAutor;
												$dataArr['reference'] = $referenceTxt;
												// custom_in_array(needle, needle_field, array)
												if(custom_in_array($dataArr['full_reference'], 'full_reference', $referenceArray) != true)
													$referenceArray[] = $dataArr;
											}

										}else{
											foreach ($referenceReturnArr['data'] as $referenceReturnKey => $referenceReturnVal) {
												// custom_in_array(needle, needle_field, array)
												if(custom_in_array($referenceReturnArr['data'][$referenceReturnKey]['reference_id'], 'reference_id', $referenceArray) != true){
													$referenceArray[] = $referenceReturnArr['data'][$referenceReturnKey];
													$aLiteraturquellen [$refKey] = ($referenceReturnArr['data'][$referenceReturnKey]['full_reference'] != "") ? trim($referenceReturnArr['data'][$referenceReturnKey]['full_reference']) : "";
												}
											}
										}
									}

									if($ckeckPApproval == 1 OR $ckeckRApproval == 1){
										// Making Reference array empty (for not adding in symptom table column) because it's not use have clear it in Direct Order or reinsert correctly.
										$aLiteraturquellen = array();
										$referenceArray = array();

										$prueferArray = array();

										$tagsApprovalString = $tagsApproalStringForPrue.$tagsApproalStringForRef;
										$tagsApprovalString = rtrim($tagsApprovalString, "{#^#}");

										$needApproval = 1;

										$referencePriority = 0;
										$referenceWithNoAuthorPriority = 0;
										$remedyWithSymptomPriority = 0;
										$partOfSymptomPriority = 0;
										$remedyPriority = 0;
										$prueferPriority = 0;
										$aaoHyphenPriority = 0;
										$hyphenPrueferPriority = 0;
										$hyphenReferencePriority = 0;
										$moreThanOneTagStringPriority = 10;
									}else{
										$needApproval = 0;
									}

									//$EntnommenAus = join ( "\n", $aLiteraturquellen );
								}
								else if( count($aLiteraturquellen) > 0 ){
									/* When only @L is present in a symptom */	

									/* Making pruefer Array blank */
									$prueferArray = array ();

									/* Literaturquellen data */
									$isPreDefinedTagsApproval = 1;
									$tagsApproalStringForRef = ""; 
									$ckeckRApproval = 0;
									foreach ($aLiteraturquellen as $refKey => $refVal) {
										$tagsApproalStringForRef .= $refVal."{#^#}";

										$refVal = trim($refVal);
										$referenceReturnArr = lookupLiteratureReference($refVal);
										// echo "<pre>";
										// print_r($referenceReturnArr);
										
										if(isset($referenceReturnArr['need_approval']) AND $referenceReturnArr['need_approval'] == 1){
											$ckeckRApproval = 1;

											if(!empty($referenceReturnArr['data'])){
												foreach ($referenceReturnArr['data'] as $referenceReturnKey => $referenceReturnVal) {
													// custom_in_array(needle, needle_field, array)
													if(custom_in_array($referenceReturnArr['data'][$referenceReturnKey]['reference_id'], 'reference_id', $referenceArray) != true)
														$referenceArray[] = $referenceReturnArr['data'][$referenceReturnKey];
												}
											}
											else{
												$fullReferenceInArray = explode(",", $refVal);
												if(count($fullReferenceInArray) >= 2){
													$referenceAutor = trim($fullReferenceInArray[0]);
									        		array_shift($fullReferenceInArray);
									        		$referenceTxt = rtrim(implode(",", $fullReferenceInArray), ",");
												}else{
													$referenceAutor = "";
													$referenceTxt = $refVal;
												}
												
												$dataArr = array();
												$dataArr['reference_id'] = null;
												$dataArr['full_reference'] = $refVal;
												$dataArr['autor'] = $referenceAutor;
												$dataArr['reference'] = $referenceTxt;
												// custom_in_array(needle, needle_field, array)
												if(custom_in_array($dataArr['full_reference'], 'full_reference', $referenceArray) != true)
													$referenceArray[] = $dataArr;
											}

										}else{
											foreach ($referenceReturnArr['data'] as $referenceReturnKey => $referenceReturnVal) {
												// custom_in_array(needle, needle_field, array)
												if(custom_in_array($referenceReturnArr['data'][$referenceReturnKey]['reference_id'], 'reference_id', $referenceArray) != true){
													$referenceArray[] = $referenceReturnArr['data'][$referenceReturnKey];
													$aLiteraturquellen [$refKey] = ($referenceReturnArr['data'][$referenceReturnKey]['full_reference'] != "") ? trim($referenceReturnArr['data'][$referenceReturnKey]['full_reference']) : "";
												}
											}
										}
									}

									if($ckeckRApproval == 1){
										$needApproval = 1;

										$aLiteraturquellen = array(); 
										$tagsApprovalString = $tagsApproalStringForRef;
										$tagsApprovalString = rtrim($tagsApprovalString, "{#^#}");

										$foundReferenceStringArray = explode("{#^#}", $tagsApprovalString);

										if(count($foundReferenceStringArray) > 1){
											$partOfSymptomPriority = 0;
											$remedyWithSymptomPriority = 0;
											$prueferPriority = 0;
											$remedyPriority = 0;
											$referencePriority = 0;
											$referenceWithNoAuthorPriority = 0;
											$aaoHyphenPriority = 0;
											$hyphenPrueferPriority = 0;
											$hyphenReferencePriority = 0;
											$moreThanOneTagStringPriority = 10;
										}else{
											$partOfSymptomPriority = 0;
											$remedyWithSymptomPriority = 0;
											$prueferPriority = 0;
											$remedyPriority = 0;
											$aaoHyphenPriority = 0;
											$hyphenPrueferPriority = 0;
											$hyphenReferencePriority = 0;
											$moreThanOneTagStringPriority = 0;
											$referenceWithNoAuthorPriority = 0;
											$referencePriority = 10;
										}
									}else{
										$needApproval = 0;
									}
									//$EntnommenAus = join ( "\n", $aLiteraturquellen );
								}
								else if( count($prueferFromParray) > 0 ){
									/* When only @P is present in a symptom */

									$isPreDefinedTagsApproval = 1;
									$ckeckPApproval = 0;
									$tagsApproalStringForPrue = "";
									foreach ($prueferFromParray as $prueferPkey => $prueferPval) {
										$prueferPval = trim($prueferPval);
										$tagsApproalStringForPrue .= $prueferPval."{#^#}";

										$cleanPrueferString = (mb_substr ( $prueferPval, mb_strlen ( $prueferPval ) - 1, 1 ) == '.') ? $prueferPval : $prueferPval.'.'; 
										$prueferReturnArr = lookupPruefer($cleanPrueferString);
										if(isset($prueferReturnArr['need_approval']) AND $prueferReturnArr['need_approval'] == 1){
											$ckeckPApproval = 1;
											
											if(!empty($prueferReturnArr['data'])){
												foreach ($prueferReturnArr['data'] as $prueferReturnKey => $prueferReturnVal) {
													// custom_in_array(needle, needle_field, array)
													if(custom_in_array($prueferReturnArr['data'][$prueferReturnKey]['pruefer_id'], 'pruefer_id', $prueferArray) != true)
														$prueferArray[] = $prueferReturnArr['data'][$prueferReturnKey];
												}
											}
											else{
												$dataArr = array();
												$dataArr['pruefer_id'] = null;
												$dataArr['kuerzel'] = null;
												$dataArr['suchname'] = trim($prueferPval);
												// custom_in_array(needle, needle_field, array)
												if(custom_in_array($dataArr['suchname'], 'suchname', $prueferArray) != true)
													$prueferArray[] = $dataArr;
											}
										}
										else{
											foreach ($prueferReturnArr['data'] as $prueferReturnKey => $prueferReturnVal) {
												// custom_in_array(needle, needle_field, array)
												if(custom_in_array($prueferReturnArr['data'][$prueferReturnKey]['pruefer_id'], 'pruefer_id', $prueferArray) != true)
													$prueferArray[] = $prueferReturnArr['data'][$prueferReturnKey];
											}
										}
									}

									if($ckeckPApproval == 1){
										$needApproval = 1;

										$tagsApprovalString = $tagsApproalStringForPrue;
										$tagsApprovalString = rtrim($tagsApprovalString, "{#^#}");

										$foundPrueferStringArray = explode("{#^#}", $tagsApprovalString);
										if(count($foundPrueferStringArray) > 1){
											$referencePriority = 0;
											$referenceWithNoAuthorPriority = 0;
											$remedyWithSymptomPriority = 0;
											$remedyPriority = 0;
											$partOfSymptomPriority = 0;
											$prueferPriority = 0;
											$aaoHyphenPriority = 0;
											$hyphenPrueferPriority = 0;
											$hyphenReferencePriority = 0;
											$moreThanOneTagStringPriority = 10;
										}else{
											$referencePriority = 0;
											$referenceWithNoAuthorPriority = 0;
											$remedyWithSymptomPriority = 0;
											$remedyPriority = 0;
											$partOfSymptomPriority = 0;
											$moreThanOneTagStringPriority = 0;
											$aaoHyphenPriority = 0;
											$hyphenPrueferPriority = 0;
											$hyphenReferencePriority = 0;
											$prueferPriority = 10;
										}

									}else{
										$needApproval = 0;
									}
								}
								else{
									/* In this else case if the bracketed part texts is not null than examining its possibilities START */
									if($bracketedString != ""){
										//$bracketedStringForPruefer = trim($bracketedString); 
										/* Previously implemented only for Pruefer start */
										// $replacedAaoText = str_replace(", a. a. O.", "# a. a. O.", $bracketedString);
										// $bracketedDataArry = explode(', ', $replacedAaoText);
										// if(!empty($bracketedDataArry)){
										// 	foreach ($bracketedDataArry as $bracktedDataKey => $bracktedDataVal) {
										// 		$eachPrueferString = trim($bracktedDataVal);
										// 		if (mb_substr($eachPrueferString,-mb_strlen('# a. a. O.'))==='# a. a. O.'){
										// 			$expectedPrueferName = trim( mb_substr($eachPrueferString, 0, mb_strlen($eachPrueferString)-mb_strlen('# a. a. O.')));
										// 			$getIdsArray = lookupPruefer($expectedPrueferName);
										// 			if(!empty($getIdsArray['ids'])){
										// 				foreach ($getIdsArray['ids'] as $idsKey => $idsVal) {
										// 					$prueferIDarray [] = $idsVal;
										// 				}
										// 			}
										// 		}
										// 	}
										// }
										/* Previously implemented only for Pruefer end */
										
										//$replacedAaoText = str_replace(", a. a. O.", "", $bracketedString);
										$bracketedDataArry = explode('{#^#} ', $bracketedString);
										if(count($bracketedDataArry) > 1)
											$lastBracketedString = trim(array_shift($bracketedDataArry));
										else
											$lastBracketedString = trim($bracketedDataArry[0]);

										// $lastBracketedString=html_entity_decode($lastBracketedString);

										// Checking the existance of , - . ; and , a. a. O. and , a.a.O.
										$isAaoExist = mb_strpos($lastBracketedString, ', a. a. O.');
										$isAaoWithoutSpaceExist = mb_strpos($lastBracketedString, ', a.a.O.');
										$isAaoWithoutAnySpaceExist = mb_strpos($lastBracketedString, ',a.a.O.');
										$isAaoWithoutFrontSpaceExist = mb_strpos($lastBracketedString, ',a. a. O.');
										$isCommaExist = mb_substr_count($lastBracketedString,",");
										$isHyphenExist = mb_substr_count($lastBracketedString," - ");
										$isDotExist = mb_substr_count($lastBracketedString, ".");
										$isSemicolonExist = mb_substr_count($lastBracketedString,";");

										if($isCommaExist == 0 AND $isSemicolonExist == 0 AND $isHyphenExist == 0 AND $isAaoExist === false AND $isAaoWithoutSpaceExist === false AND $isAaoWithoutAnySpaceExist === false AND $isAaoWithoutFrontSpaceExist === false)
										{
											// No Comma AND No Semicolon AND No Hyphen AND No , a. a. O. START

											$workingString = trim($lastBracketedString);
											$expectedRemedyArray = array();
											/*
											* COMMON LOOKUP SECTION START
											*/
											if (mb_strpos($workingString, '.') !== false){
												// Split by dot(.)
												$makeStringToExplode = str_replace('.', '.{#^#}', $workingString);
												$expectedRemedyArray = explode("{#^#}", $makeStringToExplode);
											}
											else
												$expectedRemedyArray[] = $workingString;

											/* REMEDY START */
											$checkRemedyApprovalStatus = 0;
											foreach ($expectedRemedyArray as $expectedRemedyKey => $expectedRemedyVal) {
												
												if($expectedRemedyVal == "")
													continue;	

												$cleanExpectedRemedyName = trim($expectedRemedyVal);
												$cleanRemedyString = (mb_substr ( $cleanExpectedRemedyName, mb_strlen ( $cleanExpectedRemedyName ) - 1, 1 ) == '.') ? $cleanExpectedRemedyName : $cleanExpectedRemedyName.'.';
												$remedyReturnArr = lookupRemedy($cleanRemedyString);
												if(isset($remedyReturnArr['need_approval']) AND $remedyReturnArr['need_approval'] == 1){
													$checkRemedyApprovalStatus = 1;
													if(!empty($remedyReturnArr['data'])){
														foreach ($remedyReturnArr['data'] as $remedyReturnKey => $remedyReturnVal) {
															// custom_in_array(needle, needle_field, array)
															if(custom_in_array($remedyReturnArr['data'][$remedyReturnKey]['remedy_id'], 'remedy_id', $remedyArray) != true)
																$remedyArray[] = $remedyReturnArr['data'][$remedyReturnKey];
														}
													}
													else{
														$dataArr = array();
														$dataArr['remedy_id'] = null;
														$dataArr['name'] = $cleanExpectedRemedyName;
														// custom_in_array(needle, needle_field, array)
														if(custom_in_array($dataArr['name'], 'name', $remedyArray) != true)
															$remedyArray[] = $dataArr;
													}
												}
												else{
													foreach ($remedyReturnArr['data'] as $remedyReturnKey => $remedyReturnVal) {
														// custom_in_array(needle, needle_field, array)
														if(custom_in_array($remedyReturnArr['data'][$remedyReturnKey]['remedy_id'], 'remedy_id', $remedyArray) != true)
															$remedyArray[] = $remedyReturnArr['data'][$remedyReturnKey];
													}
												}
											}

											// Setting last operations approval status to main approval checking variable 
											$needApproval = $checkRemedyApprovalStatus; 
											/* REMEDY END */

											/* PRUEFER STRAT */
											if($needApproval == 1){
												$cleanPrueferString = (mb_substr ( $workingString, mb_strlen ( $workingString ) - 1, 1 ) == '.') ? $workingString : $workingString.'.'; 
												$prueferReturnArr = lookupPruefer($cleanPrueferString);
												if(isset($prueferReturnArr['need_approval']) AND $prueferReturnArr['need_approval'] == 1){
													if(!empty($prueferReturnArr['data'])){
														foreach ($prueferReturnArr['data'] as $prueferReturnKey => $prueferReturnVal) {
															// custom_in_array(needle, needle_field, array)
															if(custom_in_array($prueferReturnArr['data'][$prueferReturnKey]['pruefer_id'], 'pruefer_id', $prueferArray) != true)
																$prueferArray[] = $prueferReturnArr['data'][$prueferReturnKey];
														}
													}else{
														$dataArr = array();
														$dataArr['pruefer_id'] = null;
														$dataArr['kuerzel'] = null;
														$dataArr['suchname'] = $workingString;
														// custom_in_array(needle, needle_field, array)
														if(custom_in_array($dataArr['suchname'], 'suchname', $prueferArray) != true)
															$prueferArray[] = $dataArr;
													}
												}
												else{
													$needApproval = 0;
													$remedyArray = array();
													foreach ($prueferReturnArr['data'] as $prueferReturnKey => $prueferReturnVal) {
														// custom_in_array(needle, needle_field, array)
														if(custom_in_array($prueferReturnArr['data'][$prueferReturnKey]['pruefer_id'], 'pruefer_id', $prueferArray) != true)
															$prueferArray[] = $prueferReturnArr['data'][$prueferReturnKey];
													}
												}
											}
											/* PRUEFER END */

											/* REFERENCE WITH NO AUTHOR START */
											if($needApproval == 1){
												$noAuthorWorkingString = "No Author, ".trim($workingString);
												$referenceReturnArr = lookupLiteratureReference($noAuthorWorkingString);
												if(isset($referenceReturnArr['need_approval']) AND $referenceReturnArr['need_approval'] == 1){

													if(!empty($referenceReturnArr['data'])){
														foreach ($referenceReturnArr['data'] as $refKey => $refVal) {
															// custom_in_array(needle, needle_field, array)
															if(custom_in_array($referenceReturnArr['data'][$refKey]['reference_id'], 'reference_id', $referenceArray) != true)
																$referenceArray[] = $referenceReturnArr['data'][$refKey];
														}
													}
													else{
														$fullReferenceInArray = explode(",", $noAuthorWorkingString);
														if(count($fullReferenceInArray) >= 2){
															$referenceAutor = trim($fullReferenceInArray[0]);
											        		array_shift($fullReferenceInArray);
											        		$referenceTxt = rtrim(implode(",", $fullReferenceInArray), ",");
														}else{
															$referenceAutor = "No Author";
															$referenceTxt = $workingString;
														}
														
														$dataArr = array();
														$dataArr['reference_id'] = null;
														$dataArr['full_reference'] = $noAuthorWorkingString;
														$dataArr['autor'] = $referenceAutor;
														$dataArr['reference'] = $referenceTxt;
														// custom_in_array(needle, needle_field, array)
														if(custom_in_array($dataArr['full_reference'], 'full_reference', $referenceArray) != true)
															$referenceArray[] = $dataArr;
													}

												}else{
													$needApproval = 0;
													$prueferArray = array();
													$remedyArray = array();
													foreach ($referenceReturnArr['data'] as $refKey => $refVal) {
														// custom_in_array(needle, needle_field, array)
														if(custom_in_array($referenceReturnArr['data'][$refKey]['reference_id'], 'reference_id', $referenceArray) != true){
															$referenceArray[] = $referenceReturnArr['data'][$refKey];
															$aLiteraturquellen [] = ($referenceReturnArr['data'][$refKey]['full_reference'] != "") ? trim($referenceReturnArr['data'][$refKey]['full_reference']) : "";
														}
													}
												}
											}
											/* REFERENCE WITH NO AUTHOR END */

											/*
											* COMMON LOOKUP SECTION END
											*/

											$wordsInLastString = explode(" ", $lastBracketedString);
											if(!empty($wordsInLastString)){

												if(count($wordsInLastString) == 1){
													/*
													* (A) SINGLE WORD START
													*/
													
													if($isDotExist != 0){
														// Single word has dot START
														if( isFirstCharacterUppercase($workingString) === true){
															/*
															* (A1) If the word + dot has uppercase (I mean only the first character is uppercase)
															*
															* 1 = chcek for remedy
															* 2 = chcek for part of symptom
															* 3 = chcek for pruefer
															*/
															if($needApproval == 1){
																$referencePriority = 0;
																$referenceWithNoAuthorPriority = 0;
																$remedyWithSymptomPriority = 0;
																$aaoHyphenPriority = 0;
																$hyphenPrueferPriority = 0;
																$hyphenReferencePriority = 0;
																$moreThanOneTagStringPriority = 0;
																$remedyPriority = 8;
																$partOfSymptomPriority = 9;
																$prueferPriority = 10;
															}
														}else{
															/*
															* (A2) If the word + dot is lowercase
															*
															* 1 = chcek for part of symptom
															* 2 = chcek for remedy
															*/
															if($needApproval == 1){
																// As we are not going to ask Pruefer Question, making $prueferArray array empty and $prueferPriority = 0
																$prueferArray = array();
																$referencePriority = 0;
																$referenceWithNoAuthorPriority = 0;
																$remedyWithSymptomPriority = 0;
																$prueferPriority = 0;
																$aaoHyphenPriority = 0;
																$hyphenPrueferPriority = 0;
																$hyphenReferencePriority = 0;
																$moreThanOneTagStringPriority = 0;
																$partOfSymptomPriority = 9;
																$remedyPriority = 10;
															}
														}
														// Single word has dot END
													}else{
														// Single word don't have any dot START
														if( isFirstCharacterUppercase($workingString) === true){
															/*
															* (A4) Single word uppercase without dot (I mean only the first character is uppercase)
															*
															* 1 = chcek for remedy
															* 2 = chcek for part of symptom
															* 3 = chcek for pruefer
															*/
															if($needApproval == 1){
																$referencePriority = 0;
																$referenceWithNoAuthorPriority = 0;
																$remedyWithSymptomPriority = 0;
																$aaoHyphenPriority = 0;
																$hyphenPrueferPriority = 0;
																$hyphenReferencePriority = 0;
																$moreThanOneTagStringPriority = 0;
																$remedyPriority = 8;
																$partOfSymptomPriority = 9;
																$prueferPriority = 10;
															}
														}else{
															/*
															* (A3) Single word lowercase without dot
															*
															* 1 = chcek for part of symptom
															* 2 = chcek for remedy
															* 3 = chcek for pruefer
															*/
															if($needApproval == 1){
																$referencePriority = 0;
																$referenceWithNoAuthorPriority = 0;
																$remedyWithSymptomPriority = 0;
																$aaoHyphenPriority = 0;
																$hyphenPrueferPriority = 0;
																$hyphenReferencePriority = 0;
																$moreThanOneTagStringPriority = 0;
																$partOfSymptomPriority = 8;
																$remedyPriority = 9;
																$prueferPriority = 10;
															}
														}
														// Single word don't have any dot END
													}

													/*
													* (A) SINGLE WORD END
													*/
												}
												else
												{
													/* 
													* (B) MORE THAN ONE WORD (case insensitive i.e., upper or lower case does not matter) START 
													*/

													if($isDotExist != 0){
														/*
														* (B1) Words have one or more than one dot(s)
														*
														* 1 = chcek for part of symptom
														* 2 = chcek for n remedies splited by dot(.)
														* 3 = chcek for pruefer
														* 4 = chcek for reference with no author
														*/

														if($needApproval == 1){
															$remedyWithSymptomPriority = 0;
															$aaoHyphenPriority = 0;
															$hyphenPrueferPriority = 0;
															$hyphenReferencePriority = 0;
															$moreThanOneTagStringPriority = 0;
															$referencePriority = 0;
															$partOfSymptomPriority = 7;
															$remedyPriority = 8;
															$prueferPriority = 9;
															$referenceWithNoAuthorPriority = 10;
														}

													}else{
														/*
														* (B1) Words have NO dot(s)
														*
														* 1 = chcek for part of symptom
														* 2 = chcek for remedy
														* 3 = chcek for pruefer
														*/

														if($needApproval == 1){
															$referencePriority = 0;
															$referenceWithNoAuthorPriority = 0;
															$remedyWithSymptomPriority = 0;
															$aaoHyphenPriority = 0;
															$hyphenPrueferPriority = 0;
															$hyphenReferencePriority = 0;
															$moreThanOneTagStringPriority = 0;
															$partOfSymptomPriority = 8;
															$remedyPriority = 9;
															$prueferPriority = 10;
														}
													}

													/* 
													* (B) MORE THAN ONE WORD (case insensitive i.e., upper or lower case does not matter) END 
													*/
												}

											}
											// No Comma AND No Semicolon AND No Hyphen AND No , a. a. O. END
										}
										else if(($isCommaExist != 0 OR $isSemicolonExist != 0) AND $isHyphenExist == 0 AND $isAaoExist === false AND $isAaoWithoutSpaceExist === false AND $isAaoWithoutAnySpaceExist === false AND $isAaoWithoutFrontSpaceExist === false)
										{
											// With Comma OR Semicolon AND NO Hyphen AND No , a. a. O. START
											if (mb_strpos($lastBracketedString, ',') !== false) 
												$separator = ",";
											else
												$separator = ";";

											$commaFirstOccurrence = mb_stripos ( $lastBracketedString, $separator );
											$beforeTheCommaString = trim( mb_substr ( $lastBracketedString, 0, $commaFirstOccurrence ) );
											$afterTheCommaString = trim( ltrim( mb_substr ( $lastBracketedString, $commaFirstOccurrence ), $separator ));
											$beforeTheCommaStringInArray = explode(" ", $beforeTheCommaString);
											$afterTheCommaStringInArray = explode(" ", $afterTheCommaString);

											$isDotExistInBeforeTheCommaString = mb_substr_count($beforeTheCommaString,".");
											$isDotExistInAfterTheCommaString = mb_substr_count($afterTheCommaString,".");
											
											$upperCaseCheckInBeforeTheCommaStr = isThereAnyUppercase($beforeTheCommaString);
											$upperCaseCheckInAfterTheCommaStr = isThereAnyUppercase($afterTheCommaString);
											$isFirstCharUpperBeforeTheCommaStr = isFirstCharacterUppercase($beforeTheCommaString);

											$workingString = trim($lastBracketedString);

											/*
											* COMMON LOOKUP SECTION START
											*/

											/* REMEDY START */
											$checkRemedyApprovalStatus = 0;
											$expectedRemedyArray = explode($separator, $workingString);
											foreach ($expectedRemedyArray as $expectedRemedyKey => $expectedRemedyVal) {
												
												if($expectedRemedyVal == "")
													continue;	

												$cleanExpectedRemedyName = trim($expectedRemedyVal);
												$cleanRemedyString = (mb_substr ( $cleanExpectedRemedyName, mb_strlen ( $cleanExpectedRemedyName ) - 1, 1 ) == '.') ? $cleanExpectedRemedyName : $cleanExpectedRemedyName.'.'; 
												$remedyReturnArr = lookupRemedy($cleanRemedyString);
												if(isset($remedyReturnArr['need_approval']) AND $remedyReturnArr['need_approval'] == 1){
													$checkRemedyApprovalStatus = 1;
													if(!empty($remedyReturnArr['data'])){
														foreach ($remedyReturnArr['data'] as $remedyReturnKey => $remedyReturnVal) {
															// custom_in_array(needle, needle_field, array) 
															if(custom_in_array($remedyReturnArr['data'][$remedyReturnKey]['remedy_id'], 'remedy_id', $remedyArray) != true)
																$remedyArray[] = $remedyReturnArr['data'][$remedyReturnKey];
														}

													}
													else{
														$dataArr = array();
														$dataArr['remedy_id'] = null;
														$dataArr['name'] = $cleanExpectedRemedyName;
														// custom_in_array(needle, needle_field, array)
														if(custom_in_array($dataArr['name'], 'name', $remedyArray) != true)
															$remedyArray[] = $dataArr;
													}
												}
												else{
													foreach ($remedyReturnArr['data'] as $remedyReturnKey => $remedyReturnVal) {
														// custom_in_array(needle, needle_field, array)
														if(custom_in_array($remedyReturnArr['data'][$remedyReturnKey]['remedy_id'], 'remedy_id', $remedyArray) != true)
															$remedyArray[] = $remedyReturnArr['data'][$remedyReturnKey];
													}
												}
											}
											// Setting last operations approval status to main approval checking variable 
											$needApproval = $checkRemedyApprovalStatus; 
											/* REMEDY END */

											/* REFERENCE START */
											if($needApproval == 1){
												$referenceReturnArr = lookupLiteratureReference($workingString);
												if(isset($referenceReturnArr['need_approval']) AND $referenceReturnArr['need_approval'] == 1){

													if(!empty($referenceReturnArr['data'])){
														foreach ($referenceReturnArr['data'] as $referenceReturnKey => $referenceReturnVal) {
															// custom_in_array(needle, needle_field, array)
															if(custom_in_array($referenceReturnArr['data'][$referenceReturnKey]['reference_id'], 'reference_id', $referenceArray) != true)
																$referenceArray[] = $referenceReturnArr['data'][$referenceReturnKey];
														}
													}
													else{
														$fullReferenceInArray = explode(",", $workingString);
														if(count($fullReferenceInArray) >= 2){
															$referenceAutor = trim($fullReferenceInArray[0]);
											        		array_shift($fullReferenceInArray);
											        		$referenceTxt = rtrim(implode(",", $fullReferenceInArray), ",");
														}else{
															$referenceAutor = "";
															$referenceTxt = $workingString;
														}
														
														$dataArr = array();
														$dataArr['reference_id'] = null;
														$dataArr['full_reference'] = $workingString;
														$dataArr['autor'] = $referenceAutor;
														$dataArr['reference'] = $referenceTxt;
														// custom_in_array(needle, needle_field, array)
														if(custom_in_array($dataArr['full_reference'], 'full_reference', $referenceArray) != true)
															$referenceArray[] = $dataArr;
													}

												}else{
													$needApproval = 0;
													$remedyArray = array();
													foreach ($referenceReturnArr['data'] as $referenceReturnKey => $referenceReturnVal) {
														// custom_in_array(needle, needle_field, array)
														if(custom_in_array($referenceReturnArr['data'][$referenceReturnKey]['reference_id'], 'reference_id', $referenceArray) != true){
															$referenceArray[] = $referenceReturnArr['data'][$referenceReturnKey];
															$aLiteraturquellen [] = ($referenceReturnArr['data'][$referenceReturnKey]['full_reference'] != "") ? trim($referenceReturnArr['data'][$referenceReturnKey]['full_reference']) : "";
														}	
													}
												}
											}
											/* REFERENCE END */

											/* PRUEFER START */
											if($needApproval == 1){
												$cleanPrueferString = $workingString; 
												$cleanPrueferString = (mb_substr ( $workingString, mb_strlen ( $workingString ) - 1, 1 ) == '.') ? $workingString : $workingString.'.'; 
												$prueferReturnArr = lookupPruefer($cleanPrueferString);
												if(isset($prueferReturnArr['need_approval']) AND $prueferReturnArr['need_approval'] == 1){
													if(!empty($prueferReturnArr['data'])){
														foreach ($prueferReturnArr['data'] as $prueferReturnKey => $prueferReturnVal) {
															// custom_in_array(needle, needle_field, array)
															if(custom_in_array($prueferReturnArr['data'][$prueferReturnKey]['pruefer_id'], 'pruefer_id', $prueferArray) != true)
																$prueferArray[] = $prueferReturnArr['data'][$prueferReturnKey];
														}
													}
													else{
														$dataArr = array();
														$dataArr['pruefer_id'] = null;
														$dataArr['kuerzel'] = null;
														$dataArr['suchname'] = $workingString;
														// custom_in_array(needle, needle_field, array)
														if(custom_in_array($dataArr['suchname'], 'suchname', $prueferArray) != true)
															$prueferArray[] = $dataArr;
													}
												}
												else{
													$needApproval = 0;
													$remedyArray = array();
													$referenceArray = array();
													$aLiteraturquellen = array();
													foreach ($prueferReturnArr['data'] as $prueferReturnKey => $prueferReturnVal) {
														// custom_in_array(needle, needle_field, array)
														if(custom_in_array($prueferReturnArr['data'][$prueferReturnKey]['pruefer_id'], 'pruefer_id', $prueferArray) != true)
															$prueferArray[] = $prueferReturnArr['data'][$prueferReturnKey];
													}
												}
											}
											/* PRUEFER END */
											/*
											* COMMON LOOKUP SECTION END
											*/

											/* Rule 2 Conditions START */
											if(count($beforeTheCommaStringInArray) == 1 AND $isDotExistInBeforeTheCommaString != 0 AND $isDotExistInAfterTheCommaString !=0){
												/*
												* 2.1 Single word + dot before the comma and one or more words + dot after comma (no matter if upper or lower case)
												*
												* 1 = chcek for remedis by spliting by comma
												*/

												if($needApproval == 1){
													$referenceWithNoAuthorPriority = 0;
													$aaoHyphenPriority = 0;
													$hyphenPrueferPriority = 0;
													$hyphenReferencePriority = 0;
													$moreThanOneTagStringPriority = 0;
													$remedyWithSymptomPriority = 0;
													$prueferPriority = 0;
													$partOfSymptomPriority = 0;
													$referencePriority = 0;
													$remedyPriority = 10;
												}

											}else if($isCommaExist == 1 AND ((count($beforeTheCommaStringInArray) == 1 AND $isDotExistInBeforeTheCommaString == 1) OR (count($afterTheCommaStringInArray) == 1 AND $isDotExistInAfterTheCommaString == 1))){
												/*
												* 2.2. Single word + dot before the comma or after a comma (only one dot and one comma)
												*
												* 1 = check for remedy with symptom text (Eg: Opi., during the day)(Eg: small boils in crops, Sulph.)
												* 2 = part of symptom
												*/
												if(count($beforeTheCommaStringInArray) == 1 AND $isDotExistInBeforeTheCommaString == 1){
													$similarRemedyString = $beforeTheCommaString;
													$similarSymptomString = $afterTheCommaString;	
												}else{
													$similarRemedyString = $afterTheCommaString;
													$similarSymptomString = $beforeTheCommaString;
												}
												$cleanRemedyWithSymptomString = (mb_substr ( $workingString, mb_strlen ( $workingString ) - 1, 1 ) == '.') ? $workingString : $workingString.'.'; 
												$remedyWithSymptomReturnArr = lookupRemedyWithSymptom($cleanRemedyWithSymptomString, $similarRemedyString, $similarSymptomString);
												if(isset($remedyWithSymptomReturnArr['need_approval']) AND $remedyWithSymptomReturnArr['need_approval'] == 0){
													$needApproval = 0;
													$remedyArray = array();
													$referenceArray = array();
													$aLiteraturquellen = array();
													$prueferArray = array();
													if(isset($remedyWithSymptomReturnArr['data'][0]['remedy']))
														$remedyArray = $remedyWithSymptomReturnArr['data'][0]['remedy'];
													$symptomOfDifferentRemedy = (isset($remedyWithSymptomReturnArr['data'][0]['symptom_of_different_remedy'])) ? $remedyWithSymptomReturnArr['data'][0]['symptom_of_different_remedy'] : "";
												}else{
													$needApproval = 1;
												}

												if($needApproval == 1){
													$referenceWithNoAuthorPriority = 0;
													$aaoHyphenPriority = 0;
													$hyphenPrueferPriority = 0;
													$hyphenReferencePriority = 0;
													$moreThanOneTagStringPriority = 0;
													$prueferPriority = 0;
													$referencePriority = 0;
													$remedyPriority = 0;
													$remedyWithSymptomPriority = 9;
													$partOfSymptomPriority = 10;
												}

											}else if(count($beforeTheCommaStringInArray) > 1 AND $upperCaseCheckInBeforeTheCommaStr === false AND $isDotExist == 0 AND count($afterTheCommaStringInArray) > 1){
												/*
												* 2.3. More than one word before comma in lower case (no dots) and no single word + dot in the bracket
												*
												* 1 = part of symptom
												*/

												if($needApproval == 1){
													$referenceWithNoAuthorPriority = 0;
													$aaoHyphenPriority = 0;
													$hyphenPrueferPriority = 0;
													$hyphenReferencePriority = 0;
													$moreThanOneTagStringPriority = 0;
													$prueferPriority = 0;
													$referencePriority = 0;
													$remedyPriority = 0;
													$remedyWithSymptomPriority = 0;
													$partOfSymptomPriority = 10;
												}
											}else if(count($beforeTheCommaStringInArray) == 1 AND $isDotExistInBeforeTheCommaString == 0 AND $isFirstCharUpperBeforeTheCommaStr === true){ 
												/*
												* 2.4. Single word upper case without dot before the comma
												*
												* 1 = check for reference
												* 2 = part of symptom
												* 3 = chcek for remedis by spliting by comma
												* 4 = pruefer
												*/

												if($needApproval == 1){
													$referenceWithNoAuthorPriority = 0;
													$aaoHyphenPriority = 0;
													$hyphenPrueferPriority = 0;
													$hyphenReferencePriority = 0;
													$moreThanOneTagStringPriority = 0;
													$remedyWithSymptomPriority = 0;
													$referencePriority = 7;
													$partOfSymptomPriority = 8;
													$remedyPriority = 9;
													$prueferPriority = 10;
												}
											}else if($upperCaseCheckInBeforeTheCommaStr === false AND $isDotExist == 0){
												/*
												* 2.5. One or more words lower case without dot before the comma (no dot in the bracket part)
												*
												* 1 = part of symptom
												*/

												if($needApproval == 1){
													$referenceWithNoAuthorPriority = 0;
													$aaoHyphenPriority = 0;
													$hyphenPrueferPriority = 0;
													$hyphenReferencePriority = 0;
													$moreThanOneTagStringPriority = 0;
													$prueferPriority = 0;
													$referencePriority = 0;
													$remedyPriority = 0;
													$remedyWithSymptomPriority = 0;
													$partOfSymptomPriority = 10;
												}
											}else if(count($beforeTheCommaStringInArray) > 1 AND $isFirstCharUpperBeforeTheCommaStr === true AND $isDotExistInBeforeTheCommaString != 0 ){
												/*
												* 2.6. More than one word with at least one dot before the comma(all words upper case)
												*
												* 1 = check for reference
												* 2 = check for pruefer
												* 3 = chcek for remedis by spliting by comma
												*/

												if($needApproval == 1){
													$referenceWithNoAuthorPriority = 0;
													$aaoHyphenPriority = 0;
													$hyphenPrueferPriority = 0;
													$hyphenReferencePriority = 0;
													$moreThanOneTagStringPriority = 0;
													$remedyWithSymptomPriority = 0;
													$partOfSymptomPriority = 0;
													$referencePriority = 8;
													$prueferPriority = 9;
													$remedyPriority = 10;
												}
											}else if(count($beforeTheCommaStringInArray) > 1 AND $isFirstCharUpperBeforeTheCommaStr === true AND $isDotExistInBeforeTheCommaString == 0){
												/*
												* 2.7. More than one word (no dots) before comma (all words upper case)
												*
												* 1 = check for reference
												* 2 = check for pruefer
												*/

												if($needApproval == 1){
													$referenceWithNoAuthorPriority = 0;
													$aaoHyphenPriority = 0;
													$hyphenPrueferPriority = 0;
													$hyphenReferencePriority = 0;
													$moreThanOneTagStringPriority = 0;
													$remedyWithSymptomPriority = 0;
													$partOfSymptomPriority = 0;
													$remedyPriority = 0;
													$referencePriority = 9;
													$prueferPriority = 10;
												}
											}else if(count($beforeTheCommaStringInArray) > 1 AND $isDotExistInBeforeTheCommaString == 0 AND $upperCaseCheckInBeforeTheCommaStr === true){
												/*
												* 2.8. More than one word mixed lower & upper case (no dots) before comma(all the words cannot be in one case)
												*
												* 1 = part of symptom
												* 2 = check for reference
												*/
												if($needApproval == 1){
													$referenceWithNoAuthorPriority = 0;
													$aaoHyphenPriority = 0;
													$hyphenPrueferPriority = 0;
													$hyphenReferencePriority = 0;
													$moreThanOneTagStringPriority = 0;
													$remedyWithSymptomPriority = 0;
													$remedyPriority = 0;
													$prueferPriority = 0;
													$partOfSymptomPriority = 9;
													$referencePriority = 10;
												}
											}else if(count($beforeTheCommaStringInArray) > 1 AND $upperCaseCheckInBeforeTheCommaStr === true AND $isDotExistInBeforeTheCommaString != 0){
												/*
												* 2.9. More than one word mixed lower & upper case with at least one dotbefore comma(all the words cannot be in one case)
												*
												* 1 = chcek for remedis by spliting by comma
												* 2 = check for reference
												*/ 

												if($needApproval == 1){
													$referenceWithNoAuthorPriority = 0;
													$aaoHyphenPriority = 0;
													$hyphenPrueferPriority = 0;
													$hyphenReferencePriority = 0;
													$moreThanOneTagStringPriority = 0;
													$remedyWithSymptomPriority = 0;
													$prueferPriority = 0;
													$partOfSymptomPriority = 0;
													$remedyPriority = 9;
													$referencePriority = 10;
												}
											}
											/* Rule 2 Conditions END */

											// With Comma OR Semicolon AND NO Hyphen AND No , a. a. O. END
										}
										else if(($isAaoExist !== false OR $isAaoWithoutSpaceExist !== false OR $isAaoWithoutAnySpaceExist !== false OR $isAaoWithoutFrontSpaceExist !== false) AND $isHyphenExist != 0)
										{
											// When string has both ", a. a. O." and hyphen START
											$workingString = trim($lastBracketedString);
											$eachElement = explode(" - ", $workingString); 
											$referenceArray = array();
											$aLiteraturquellen = array();
											$prueferArray = array();
											$countUnknownElement = 0;
											foreach ($eachElement as $elementKey => $elementVal) {
												$innerApprovalChecking = 0;
												// Lookup in same import data 
												$elementString = str_replace(", a. a. O.", "{#^#}", $elementVal);
												$elementString = str_replace(", a.a.O.", "{#^#}", $elementString);
												$elementString = str_replace(",a.a.O.", "{#^#}", $elementString);
												$elementString = str_replace(",a. a. O.", "{#^#}", $elementString);
												$searchAuthorPreName = trim($elementString);
												$aaoPosition = mb_strpos($searchAuthorPreName, '{#^#}');
												if($aaoPosition !== false){
													$searchAuthorPreName = mb_substr($searchAuthorPreName, 0, $aaoPosition);
												}
												$searchAuthorPreName = str_replace("{#^#}", "", $searchAuthorPreName);
												$searchAuthorName = trim($searchAuthorPreName);

												if($searchAuthorName != ""){
													/* 
													* Check the last appearence of this elemet in temp_approved_pruefer and temp_approved_reference table
													* if no match data found than "aao_hyphen_priority" question will be ask
													*/
													// Checking pruefer
													$cleanPrueferString = trim($searchAuthorName); 
													$cleanPrueferString = (mb_substr ( $cleanPrueferString, mb_strlen ( $cleanPrueferString ) - 1, 1 ) == '.') ? $cleanPrueferString : $cleanPrueferString.'.'; 
													$prueferReturnArr = lookupPrueferInCurrentImport($cleanPrueferString, $masterId);
													if(isset($prueferReturnArr['need_approval']) AND $prueferReturnArr['need_approval'] == 1){
														$innerApprovalChecking = 1;
													}
													else{
														$innerApprovalChecking = 0;
														foreach ($prueferReturnArr['data'] as $prueferReturnKey => $prueferReturnVal) {
															// custom_in_array(needle, needle_field, array)
															if(custom_in_array($prueferReturnArr['data'][$prueferReturnKey]['pruefer_id'], 'pruefer_id', $prueferArray) != true)
																$prueferArray[] = $prueferReturnArr['data'][$prueferReturnKey];
														}
													}

													if($innerApprovalChecking == 1){
														// Check reference
														$cleanReferenceString = trim($searchAuthorName);
														$referenceReturnArr = lookupReferenceInCurrentImport($cleanReferenceString, $masterId);
														if(isset($referenceReturnArr['need_approval']) AND $referenceReturnArr['need_approval'] == 1){
															$innerApprovalChecking = 1;
														}else{
															$innerApprovalChecking = 0;
															foreach ($referenceReturnArr['data'] as $referenceReturnKey => $referenceReturnVal) {
																// custom_in_array(needle, needle_field, array)
																if(custom_in_array($referenceReturnArr['data'][$referenceReturnKey]['reference_id'], 'reference_id', $referenceArray) != true){
																	$referenceArray[] = $referenceReturnArr['data'][$referenceReturnKey];
																	$aLiteraturquellen [] = ($referenceReturnArr['data'][$referenceReturnKey]['full_reference'] != "") ? trim($referenceReturnArr['data'][$referenceReturnKey]['full_reference']) : "";
																}	
															}
														}
													}

													// Normal lookup
													// Check pruefer
													if($innerApprovalChecking == 1){
														$cleanPrueferString = trim($searchAuthorName); 
														$cleanPrueferString = (mb_substr ( $cleanPrueferString, mb_strlen ( $cleanPrueferString ) - 1, 1 ) == '.') ? $cleanPrueferString : $cleanPrueferString.'.'; 
														$prueferReturnArr = lookupPruefer($cleanPrueferString);
														if(isset($prueferReturnArr['need_approval']) AND $prueferReturnArr['need_approval'] == 1){
															$innerApprovalChecking = 1;
															if(!empty($prueferReturnArr['data'])){
																foreach ($prueferReturnArr['data'] as $prueferReturnKey => $prueferReturnVal) {
																	// custom_in_array(needle, needle_field, array)
																	if(custom_in_array($prueferReturnArr['data'][$prueferReturnKey]['pruefer_id'], 'pruefer_id', $prueferArray) != true){
																		$prueferReturnArr['data'][$prueferReturnKey]['is_one_unknown_element_in_hyphen'] = 1;
																		$prueferArray[] = $prueferReturnArr['data'][$prueferReturnKey];
																	}
																}
															}
														}
														else{
															$innerApprovalChecking = 0;
															foreach ($prueferReturnArr['data'] as $prueferReturnKey => $prueferReturnVal) {
																// custom_in_array(needle, needle_field, array)
																if(custom_in_array($prueferReturnArr['data'][$prueferReturnKey]['pruefer_id'], 'pruefer_id', $prueferArray) != true)
																	$prueferArray[] = $prueferReturnArr['data'][$prueferReturnKey];
															}
														}
													}

													// Checking Reference
													if($innerApprovalChecking == 1){
														$cleanReferenceString = trim($searchAuthorName);
														$referenceReturnArr = lookupLiteratureReference($cleanReferenceString);
														if(isset($referenceReturnArr['need_approval']) AND $referenceReturnArr['need_approval'] == 1){
															$innerApprovalChecking = 1;
															if(!empty($referenceReturnArr['data'])){
																foreach ($referenceReturnArr['data'] as $referenceReturnKey => $referenceReturnVal) {
																	// custom_in_array(needle, needle_field, array)
																	if(custom_in_array($referenceReturnArr['data'][$referenceReturnKey]['reference_id'], 'reference_id', $referenceArray) != true){
																		$referenceReturnArr['data'][$referenceReturnKey]['is_one_unknown_element_in_hyphen'] = 1;
																		$referenceArray[] = $referenceReturnArr['data'][$referenceReturnKey];
																	}
																}
															}
														}else{
															$innerApprovalChecking = 0;
															foreach ($referenceReturnArr['data'] as $referenceReturnKey => $referenceReturnVal) {
																// custom_in_array(needle, needle_field, array)
																if(custom_in_array($referenceReturnArr['data'][$referenceReturnKey]['reference_id'], 'reference_id', $referenceArray) != true){
																	$referenceArray[] = $referenceReturnArr['data'][$referenceReturnKey];
																	$aLiteraturquellen [] = ($referenceReturnArr['data'][$referenceReturnKey]['full_reference'] != "") ? trim($referenceReturnArr['data'][$referenceReturnKey]['full_reference']) : "";
																}	
															}
														}
													}
												}

												// If unknown Data found incrementing the counter and setting the element value to $hyphenApprovalString
												if($innerApprovalChecking == 1){
													$countUnknownElement++;
													$hyphenApprovalString = trim($elementVal);
												}
											}

											// Set need approval value if unknown data found
											if($countUnknownElement > 0){
												$needApproval = 1;
												if($countUnknownElement != 1)
													$hyphenApprovalString = "";
											}

											/*
											* Rule 3 Last bracket words:  “, a. a. O.” or ", a.a.O." and Hyphen (hyphenhasspacebeforeand after ( - )) (whenbothexist)
											*
											* 1 = Unknown data found with a. a. O. or Hyphen( - )
											*/ 
											if($needApproval == 1){
												if($countUnknownElement == 1){
													$referenceWithNoAuthorPriority = 0;
													$moreThanOneTagStringPriority = 0;
													$remedyWithSymptomPriority = 0;
													$prueferPriority = 0;
													$partOfSymptomPriority = 0;
													$remedyPriority = 0;
													$referencePriority = 0;
													$aaoHyphenPriority = 0;
													$hyphenReferencePriority = 9;
													$hyphenPrueferPriority = 10;
												}else{
													// Making pruefer and reference array empty because these elements will be cleared by direct oredr or by correcting the symptom string. Also seting aao_hyphen_priority value for asking the question
													$referenceArray = array();
													$aLiteraturquellen = array();
													$prueferArray = array();

													$referenceWithNoAuthorPriority = 0;
													$moreThanOneTagStringPriority = 0;
													$remedyWithSymptomPriority = 0;
													$prueferPriority = 0;
													$partOfSymptomPriority = 0;
													$remedyPriority = 0;
													$referencePriority = 0;
													$hyphenReferencePriority = 0;
													$hyphenPrueferPriority = 0;
													$aaoHyphenPriority = 10;
												}
											}
											// When string has both ", a. a. O." and hyphen END 
										}
										else if($isHyphenExist != 0)
										{
											// When string has hyphen only START 
											$workingString = trim($lastBracketedString);
											$eachElement = explode(" - ", $workingString);
											$referenceArray = array();
											$aLiteraturquellen = array();
											$prueferArray = array();
											$countUnknownElement = 0;
											foreach ($eachElement as $elementKey => $elementVal) {
												$innerApprovalChecking = 0;

												/* 
												* Check the last appearence of this elemet in temp_approved_pruefer and temp_approved_reference table
												* if no match data found than "aao_hyphen_priority" question will be ask
												*/
												// Checking pruefer
												$cleanPrueferString = trim($elementVal); 
												$cleanPrueferString = (mb_substr ( $cleanPrueferString, mb_strlen ( $cleanPrueferString ) - 1, 1 ) == '.') ? $cleanPrueferString : $cleanPrueferString.'.'; 
												$prueferReturnArr = lookupPruefer($cleanPrueferString);
												if(isset($prueferReturnArr['need_approval']) AND $prueferReturnArr['need_approval'] == 1){
													$innerApprovalChecking = 1;
													if(!empty($prueferReturnArr['data'])){
														foreach ($prueferReturnArr['data'] as $prueferReturnKey => $prueferReturnVal) {
															// custom_in_array(needle, needle_field, array)
															if(custom_in_array($prueferReturnArr['data'][$prueferReturnKey]['pruefer_id'], 'pruefer_id', $prueferArray) != true){
																$prueferReturnArr['data'][$prueferReturnKey]['is_one_unknown_element_in_hyphen'] = 1;
																$prueferArray[] = $prueferReturnArr['data'][$prueferReturnKey];
															}
														}
													}
												}
												else{
													$innerApprovalChecking = 0;
													foreach ($prueferReturnArr['data'] as $prueferReturnKey => $prueferReturnVal) {
														// custom_in_array(needle, needle_field, array)
														if(custom_in_array($prueferReturnArr['data'][$prueferReturnKey]['pruefer_id'], 'pruefer_id', $prueferArray) != true)
															$prueferArray[] = $prueferReturnArr['data'][$prueferReturnKey];
													}
												}

												if($innerApprovalChecking == 1){
													// Check reference
													$cleanReferenceString = trim($elementVal);
													$referenceReturnArr = lookupLiteratureReference($cleanReferenceString);
													if(isset($referenceReturnArr['need_approval']) AND $referenceReturnArr['need_approval'] == 1){
														$innerApprovalChecking = 1;
														if(!empty($referenceReturnArr['data'])){
															foreach ($referenceReturnArr['data'] as $referenceReturnKey => $referenceReturnVal) {
																// custom_in_array(needle, needle_field, array)
																if(custom_in_array($referenceReturnArr['data'][$referenceReturnKey]['reference_id'], 'reference_id', $referenceArray) != true){
																	$referenceReturnArr['data'][$referenceReturnKey]['is_one_unknown_element_in_hyphen'] = 1;
																	$referenceArray[] = $referenceReturnArr['data'][$referenceReturnKey];
																}
															}
														}
													}else{
														$innerApprovalChecking = 0;
														foreach ($referenceReturnArr['data'] as $referenceReturnKey => $referenceReturnVal) {
															// custom_in_array(needle, needle_field, array)
															if(custom_in_array($referenceReturnArr['data'][$referenceReturnKey]['reference_id'], 'reference_id', $referenceArray) != true){
																$referenceArray[] = $referenceReturnArr['data'][$referenceReturnKey];
																$aLiteraturquellen [] = ($referenceReturnArr['data'][$referenceReturnKey]['full_reference'] != "") ? trim($referenceReturnArr['data'][$referenceReturnKey]['full_reference']) : "";
															}	
														}
													}
												}

												// If unknown Data found incrementing the counter and setting the element value to $hyphenApprovalString
												if($innerApprovalChecking == 1){
													$countUnknownElement++;
													$hyphenApprovalString = trim($elementVal);
												}
											}

											// Set need approval value if unknown data found
											if($countUnknownElement > 0){
												$needApproval = 1;
												if($countUnknownElement != 1)
													$hyphenApprovalString = "";
											}

											/*
											* Rule 4 Last bracket words:  “, a. a. O.” or ", a.a.O." and Hyphen (hyphenhasspacebeforeand after ( - )) (whenbothexist)
											*
											* 1 = Unknown data found with a. a. O. or Hyphen( - )
											*/ 
											if($needApproval == 1){
												if($countUnknownElement == 1){
													$referenceWithNoAuthorPriority = 0;
													$moreThanOneTagStringPriority = 0;
													$remedyWithSymptomPriority = 0;
													$prueferPriority = 0;
													$partOfSymptomPriority = 0;
													$remedyPriority = 0;
													$referencePriority = 0;
													$aaoHyphenPriority = 0;
													$hyphenReferencePriority = 9;
													$hyphenPrueferPriority = 10;
												}else{
													// Making pruefer and reference array empty because these elements will be cleared by direct oredr or by correcting the symptom string. Also seting aao_hyphen_priority value for asking the question
													$referenceArray = array();
													$aLiteraturquellen = array();
													$prueferArray = array();

													$referenceWithNoAuthorPriority = 0;
													$moreThanOneTagStringPriority = 0;
													$remedyWithSymptomPriority = 0;
													$prueferPriority = 0;
													$partOfSymptomPriority = 0;
													$remedyPriority = 0;
													$referencePriority = 0;
													$hyphenReferencePriority = 0;
													$hyphenPrueferPriority = 0;
													$aaoHyphenPriority = 10;
												}
											}
											// When string has hyphen only START 
										}
										else if($isAaoExist !== false OR $isAaoWithoutSpaceExist !== false OR $isAaoWithoutAnySpaceExist !== false OR $isAaoWithoutFrontSpaceExist !== false)
										{
											// When string has "a. a. O." only START 
											/* 
											* Check the last appearence of this elemet in temp_approved_pruefer and temp_approved_reference table
											* if no match data found than "aao_hyphen_priority" question will be ask
											*/
											$workingString = trim($lastBracketedString);
											$elementString = str_replace(", a. a. O.", "{#^#}", $workingString);
											$elementString = str_replace(", a.a.O.", "{#^#}", $elementString);
											$elementString = str_replace(",a.a.O.", "{#^#}", $elementString);
											$elementString = str_replace(",a. a. O.", "{#^#}", $elementString);
											$searchAuthorPreName = trim($elementString);
											$aaoPosition = mb_strpos($searchAuthorPreName, '{#^#}');
											if($aaoPosition !== false){
												$searchAuthorPreName = mb_substr($searchAuthorPreName, 0, $aaoPosition);
											}
											$searchAuthorPreName = str_replace("{#^#}", "", $searchAuthorPreName);
											$searchAuthorName = trim($searchAuthorPreName);

											if($searchAuthorName != ""){
												$innerApprovalChecking = 0;
												// Checking pruefer
												$cleanPrueferString = trim($searchAuthorName); 
												$cleanPrueferString = (mb_substr ( $cleanPrueferString, mb_strlen ( $cleanPrueferString ) - 1, 1 ) == '.') ? $cleanPrueferString : $cleanPrueferString.'.'; 
												$prueferReturnArr = lookupPrueferInCurrentImport($cleanPrueferString, $masterId);
												if(isset($prueferReturnArr['need_approval']) AND $prueferReturnArr['need_approval'] == 1){
													$innerApprovalChecking = 1;
												}
												else{
													$innerApprovalChecking = 0;
													foreach ($prueferReturnArr['data'] as $prueferReturnKey => $prueferReturnVal) {
														// custom_in_array(needle, needle_field, array)
														if(custom_in_array($prueferReturnArr['data'][$prueferReturnKey]['pruefer_id'], 'pruefer_id', $prueferArray) != true)
															$prueferArray[] = $prueferReturnArr['data'][$prueferReturnKey];
													}
												}

												if($innerApprovalChecking == 1){
													// Check reference
													$cleanReferenceString = trim($searchAuthorName);
													$referenceReturnArr = lookupReferenceInCurrentImport($cleanReferenceString, $masterId);
													if(isset($referenceReturnArr['need_approval']) AND $referenceReturnArr['need_approval'] == 1){
														$innerApprovalChecking = 1;
													}else{
														$innerApprovalChecking = 0;
														foreach ($referenceReturnArr['data'] as $referenceReturnKey => $referenceReturnVal) {
															// custom_in_array(needle, needle_field, array)
															if(custom_in_array($referenceReturnArr['data'][$referenceReturnKey]['reference_id'], 'reference_id', $referenceArray) != true){
																$referenceArray[] = $referenceReturnArr['data'][$referenceReturnKey];
																$aLiteraturquellen [] = ($referenceReturnArr['data'][$referenceReturnKey]['full_reference'] != "") ? trim($referenceReturnArr['data'][$referenceReturnKey]['full_reference']) : "";
															}	
														}
													}
												}

												// Normal lookup
												// Check pruefer
												if($innerApprovalChecking == 1){
													$cleanPrueferString = trim($searchAuthorName); 
													$cleanPrueferString = (mb_substr ( $cleanPrueferString, mb_strlen ( $cleanPrueferString ) - 1, 1 ) == '.') ? $cleanPrueferString : $cleanPrueferString.'.'; 
													$prueferReturnArr = lookupPruefer($cleanPrueferString);
													if(isset($prueferReturnArr['need_approval']) AND $prueferReturnArr['need_approval'] == 1){
														$prueferArray = array();
														$innerApprovalChecking = 1;
														if(!empty($prueferReturnArr['data'])){
															foreach ($prueferReturnArr['data'] as $prueferReturnKey => $prueferReturnVal) {
																// custom_in_array(needle, needle_field, array)
																if(custom_in_array($prueferReturnArr['data'][$prueferReturnKey]['pruefer_id'], 'pruefer_id', $prueferArray) != true)
																	$prueferArray[] = $prueferReturnArr['data'][$prueferReturnKey];
															}
														}
													}
													else{
														$innerApprovalChecking = 0;
														foreach ($prueferReturnArr['data'] as $prueferReturnKey => $prueferReturnVal) {
															// custom_in_array(needle, needle_field, array)
															if(custom_in_array($prueferReturnArr['data'][$prueferReturnKey]['pruefer_id'], 'pruefer_id', $prueferArray) != true)
																$prueferArray[] = $prueferReturnArr['data'][$prueferReturnKey];
														}
													}
												}

												// Checking Reference
												if($innerApprovalChecking == 1){
													$cleanReferenceString = trim($searchAuthorName);
													$referenceReturnArr = lookupLiteratureReference($cleanReferenceString);
													if(isset($referenceReturnArr['need_approval']) AND $referenceReturnArr['need_approval'] == 1){
														$referenceArray = array();
														$aLiteraturquellen = array();
														$innerApprovalChecking = 1;
														if(!empty($referenceReturnArr['data'])){
															foreach ($referenceReturnArr['data'] as $referenceReturnKey => $referenceReturnVal) {
																// custom_in_array(needle, needle_field, array)
																if(custom_in_array($referenceReturnArr['data'][$referenceReturnKey]['reference_id'], 'reference_id', $referenceArray) != true)
																	$referenceArray[] = $referenceReturnArr['data'][$referenceReturnKey];
															}
														}
													}else{
														$innerApprovalChecking = 0;
														foreach ($referenceReturnArr['data'] as $referenceReturnKey => $referenceReturnVal) {
															// custom_in_array(needle, needle_field, array)
															if(custom_in_array($referenceReturnArr['data'][$referenceReturnKey]['reference_id'], 'reference_id', $referenceArray) != true){
																$referenceArray[] = $referenceReturnArr['data'][$referenceReturnKey];
																$aLiteraturquellen [] = ($referenceReturnArr['data'][$referenceReturnKey]['full_reference'] != "") ? trim($referenceReturnArr['data'][$referenceReturnKey]['full_reference']) : "";
															}	
														}
													}
												}

												if($innerApprovalChecking == 1)
													$needApproval = 1;

												/*
												* Rule 5 Last bracket words:  “, a. a. O.” or ", a.a.O." and Hyphen (hyphenhasspacebeforeand after ( - )) (whenbothexist)
												*
												* 1 = Unknown data found with a. a. O. or Hyphen( - )
												*/ 
												if($needApproval == 1){
													// Making pruefer and reference array empty because these elements will be cleared by direct oredr or by correcting the symptom string. Also seting aao_hyphen_priority value for asking the question
													// $referenceArray = array();
													// $aLiteraturquellen = array();
													// $prueferArray = array();

													$referenceWithNoAuthorPriority = 0;
													$moreThanOneTagStringPriority = 0;
													$remedyWithSymptomPriority = 0;
													$partOfSymptomPriority = 0;
													$remedyPriority = 0;
													$aaoHyphenPriority = 0;
													$hyphenPrueferPriority = 0;
													$hyphenReferencePriority = 0;
													$referencePriority = 9;
													$prueferPriority = 10;
												}
											}
											// When string has "a. a. O." only START 
										}

									}
									/* In this else case if the bracketed part texts is not null than examining its possibilities END */
								}
								/* Extracting Pruefer Data and Literaturquellen data End */

								if ($aLiteraturquellen) {
									$EntnommenAus = join ( "\n", $aLiteraturquellen );
								}

								// replacing the delimiter {#^#} with comma in bracketedString because otherwise it will there in DB and display table
								$bracketedString = str_replace("{#^#}", ", ", $bracketedString);
								// $lastBracketedString = str_replace("{#^#}", ", ", $lastBracketedString);
								// $tagsApprovalString = str_replace("{#^#}", ", ", $tagsApprovalString);

								$approvableString = ( isset($lastBracketedString) AND $lastBracketedString != "" ) ? $lastBracketedString : $tagsApprovalString;
								
								/* quelle_import_test table fields start */
			 					$data['Symptomnummer']= ( $Symptomnummer != "" and $Symptomnummer != 0 ) ? mysqli_real_escape_string($db, $Symptomnummer) : null;
								$data['SeiteOriginalVon']=($SeiteOriginalVon == '') ? 0 : mysqli_real_escape_string($db, $SeiteOriginalVon);
								$data['SeiteOriginalBis']=($SeiteOriginalBis == '') ? 0 : mysqli_real_escape_string($db, $SeiteOriginalBis);
								$data['Beschreibung']=mysqli_real_escape_string($db, $Beschreibung);
								$data['BeschreibungOriginal']=mysqli_real_escape_string($db, $BeschreibungOriginal);
								$data['BeschreibungPlain']=mysqli_real_escape_string($db, $BeschreibungPlain);
								$data['bracketedString']=mysqli_real_escape_string($db, $bracketedString);
								$data['timeString']=mysqli_real_escape_string($db, $timeString);
								$data['Fussnote']=mysqli_real_escape_string($db, $Fussnote);
								//$data['PrueferID']=mysqli_real_escape_string($db, $Pruefers);
								/* Checking if any pruefer needs approval */
					            if(isset($needApproval) AND $needApproval == 1){
					            	if($referenceWithNoAuthorPriority == 0 AND $moreThanOneTagStringPriority == 0 AND $aaoHyphenPriority == 0 AND $hyphenPrueferPriority == 0 AND $hyphenReferencePriority == 0 AND $remedyWithSymptomPriority == 0 AND $prueferPriority == 0 AND $partOfSymptomPriority == 0 AND $referencePriority == 0 AND $remedyPriority == 0)
					            		$data['need_approval'] = 0;
					            	else
					            		$data['need_approval'] = 1;
					            }
					            else
					            	$data['need_approval'] = 0;
					            if($hyphenApprovalString != ""){
					            	$data['approval_string'] = ( isset($hyphenApprovalString) AND $hyphenApprovalString != "" ) ? mysqli_real_escape_string($db, $hyphenApprovalString) : null;
					            	$data['full_approval_string_when_hyphen'] = ( isset($approvableString) AND $approvableString != "" ) ? mysqli_real_escape_string($db, $approvableString) : null;
					            	$data['full_approval_string_when_hyphen_unchanged'] = ( isset($approvableString) AND $approvableString != "" ) ? mysqli_real_escape_string($db, $approvableString) : null;
					            }else{
					            	$data['approval_string'] = ( isset($approvableString) AND $approvableString != "" ) ? mysqli_real_escape_string($db, $approvableString) : null;
					            	$data['full_approval_string_when_hyphen'] = null;
					            	$data['full_approval_string_when_hyphen_unchanged'] = null;
					            }
								$data['EntnommenAus']=mysqli_real_escape_string($db, $EntnommenAus);
								$data['Verweiss']=mysqli_real_escape_string($db, $Verweiss);
								$data['Graduierung']=mysqli_real_escape_string($db, $Graduierung);
								$data['BereichID']=mysqli_real_escape_string($db, $BereichID);
								$data['Kommentar']=mysqli_real_escape_string($db, $Kommentar);
								$data['Unklarheiten']=mysqli_real_escape_string($db, $Unklarheiten);
					            $data['symptom_of_different_remedy'] = ( isset($symptomOfDifferentRemedy) AND $symptomOfDifferentRemedy != "" ) ? mysqli_real_escape_string($db, $symptomOfDifferentRemedy) : null;
								/* quelle_import_test table fields end */
								
					            $query="INSERT INTO temp_quelle_import_test (master_id, Symptomnummer, SeiteOriginalVon, SeiteOriginalBis, Beschreibung, BeschreibungOriginal, BeschreibungPlain, bracketedString, timeString, Fussnote, EntnommenAus, Verweiss, Graduierung, BereichID, Kommentar, Unklarheiten, symptom_of_different_remedy, need_approval, approval_string, full_approval_string_when_hyphen, full_approval_string_when_hyphen_unchanged, is_pre_defined_tags_approval, pruefer_priority, remedy_priority, part_of_symptom_priority, reference_with_no_author_priority, remedy_with_symptom_priority, more_than_one_tag_string_priority, aao_hyphen_priority, hyphen_pruefer_priority, hyphen_reference_priority, reference_priority, direct_order_priority) VALUES (".$masterId.", NULLIF('".$data['Symptomnummer']."', ''),'".$data['SeiteOriginalVon']."','".$data['SeiteOriginalBis']."','".$data['Beschreibung']."','".$data['BeschreibungOriginal']."','".$data['BeschreibungPlain']."','".$data['bracketedString']."','".$data['timeString']."','".$data['Fussnote']."', '".$data['EntnommenAus']."', '".$data['Verweiss']."', '".$data['Graduierung']."', '".$data['BereichID']."', '".$data['Kommentar']."', '".$data['Unklarheiten']."', NULLIF('".$data['symptom_of_different_remedy']."', ''), '".$data['need_approval']."', NULLIF('".$data['approval_string']."', ''), NULLIF('".$data['full_approval_string_when_hyphen']."', ''), NULLIF('".$data['full_approval_string_when_hyphen_unchanged']."', ''), ".$isPreDefinedTagsApproval.", ".$prueferPriority.", ".$remedyPriority.", ".$partOfSymptomPriority.", ".$referenceWithNoAuthorPriority.", ".$remedyWithSymptomPriority.", ".$moreThanOneTagStringPriority.", ".$aaoHyphenPriority.", ".$hyphenPrueferPriority.", ".$hyphenReferencePriority.", ".$referencePriority.", ".$directOrderPriority.")";

					            $db->query($query);
					            $insertedSymtomId = mysqli_insert_id($db);
					            
				            	/* Pruefer Start */
				            	if(!empty($prueferArray)){
			            			foreach ($prueferArray as $pruKey => $pruVal) {
			            				if(isset($prueferArray[$pruKey]['pruefer_id']) AND $prueferArray[$pruKey]['pruefer_id'] != ""){
			            					$isOneUnknownElementInHyphen = (isset($prueferArray[$pruKey]['is_one_unknown_element_in_hyphen']) AND $prueferArray[$pruKey]['is_one_unknown_element_in_hyphen'] != "") ? $prueferArray[$pruKey]['is_one_unknown_element_in_hyphen'] : 0; 
						            		$prueferQuery = "INSERT INTO temp_symptom_pruefer (symptom_id, pruefer_id, is_one_unknown_element_in_hyphen) VALUES ('".$insertedSymtomId."', '".$prueferArray[$pruKey]['pruefer_id']."', '".$isOneUnknownElementInHyphen."')";
								            $db->query($prueferQuery);

								            if($data['need_approval'] == 0){
								            	// When a symptom needs no approval than storing it's pruefer details in temp_approved_pruefer for using in a. a. O. search process
								            	$tempApprovedPrueferQuery = "INSERT INTO temp_approved_pruefer (master_id, symptom_id, pruefer_id, approval_string) VALUES ('".$masterId."', '".$insertedSymtomId."', '".$prueferArray[$pruKey]['pruefer_id']."', NULLIF('".$data['approval_string']."', ''))";
								            	$db->query($tempApprovedPrueferQuery);  
								            }
			            				}else{
			            					if(isset($prueferArray[$pruKey]['suchname']) AND $prueferArray[$pruKey]['suchname'] != ""){
			            						$prueferArray[$pruKey]['suchname'] = mysqli_real_escape_string($db, $prueferArray[$pruKey]['suchname']);
												$prueferInsertQuery = "INSERT INTO temp_pruefer (symptom_id, suchname) VALUES ('".$insertedSymtomId."', '".$prueferArray[$pruKey]['suchname']."')";
			            						$db->query($prueferInsertQuery);
			            						$newPrueferId = mysqli_insert_id($db);
			            						
			            						$prueferQuery = "INSERT INTO temp_symptom_pruefer (symptom_id, pruefer_id, is_new) VALUES ('".$insertedSymtomId."', '".$newPrueferId."', 1)";
								            	$db->query($prueferQuery);
			            					}
			            				}
			            			}
				            	}
				            	/* Pruefer End */
				            	/* Remedy Start */
				            	if(!empty($remedyArray)){
				            		$remedyText = "";
			            			foreach ($remedyArray as $remdKey => $remdVal) {
			            				$remedyArray[$remdKey]['name'] = mysqli_real_escape_string($db, $remedyArray[$remdKey]['name']);
			            				if(isset($needApproval) AND $needApproval == 1){
			            					if(isset($remedyArray[$remdKey]['remedy_id']) AND $remedyArray[$remdKey]['remedy_id'] != ""){
							            		$remedyQuery = "INSERT INTO temp_remedy (symptom_id, main_remedy_id, name) VALUES ('".$insertedSymtomId."', '".$remedyArray[$remdKey]['remedy_id']."', '".$remedyArray[$remdKey]['name']."')";
									            $db->query($remedyQuery);
				            				}else{

				            					// $checkRemedyResult = mysqli_query($db, "SELECT remedy_id, name FROM temp_remedy where name = '".$remedyArray[$remdKey]['name']."'");
												// if(mysqli_num_rows($checkRemedyResult) < 1){
													$remedyQuery = "INSERT INTO temp_remedy (symptom_id, name, is_new) VALUES ('".$insertedSymtomId."', '".$remedyArray[$remdKey]['name']."', 1)";
									            	$db->query($remedyQuery);
												// }

				            				}
			            				}
			            				else{
			            					$remedyText = $remedyText.$remedyArray[$remdKey]['name'].", ";
			            				}
			            			}
			            			if(isset($remedyText) AND $remedyText != ""){
			            				$remedyText = rtrim($remedyText, ", ");
	            						$symptomUpdateQuery="UPDATE temp_quelle_import_test SET Remedy = '".$remedyText."' WHERE id = '".$insertedSymtomId."'";
										// mysqli_query($db, $symptomUpdateQuery);
										$db->query($symptomUpdateQuery);
	            					}
				            	}
				            	/* Remedy End */

				            	/* Reference Start */
				            	if(!empty($referenceArray)){
			            			foreach ($referenceArray as $refKey => $refVal) {
			            				if(isset($referenceArray[$refKey]['reference_id']) AND $referenceArray[$refKey]['reference_id'] != ""){
			            					$isOneUnknownElementInHyphen = (isset($referenceArray[$refKey]['is_one_unknown_element_in_hyphen']) AND $referenceArray[$refKey]['is_one_unknown_element_in_hyphen'] != "") ? $referenceArray[$refKey]['is_one_unknown_element_in_hyphen'] : 0; 
						            		$referenceQuery = "INSERT INTO temp_symptom_reference (symptom_id, reference_id, is_one_unknown_element_in_hyphen) VALUES ('".$insertedSymtomId."', '".$referenceArray[$refKey]['reference_id']."', '".$isOneUnknownElementInHyphen."')";
								            $db->query($referenceQuery);

								            if($data['need_approval'] == 0){
								            	// When a symptom needs no approval than storing it's reference details in temp_approved_reference for using in a. a. O. search process
								            	$tempApprovedReferenceQuery = "INSERT INTO temp_approved_reference (master_id, symptom_id, reference_id, approval_string) VALUES ('".$masterId."', '".$insertedSymtomId."', '".$referenceArray[$refKey]['reference_id']."', NULLIF('".$data['approval_string']."', ''))";
								            	$db->query($tempApprovedReferenceQuery); 
								            }
			            				}else{
			            					if(isset($referenceArray[$refKey]['full_reference']) AND $referenceArray[$refKey]['full_reference'] != ""){
			            						$referenceArray[$refKey]['full_reference'] = mysqli_real_escape_string($db, $referenceArray[$refKey]['full_reference']);
			            						$referenceArray[$refKey]['autor'] = mysqli_real_escape_string($db, $referenceArray[$refKey]['autor']);
			            						$referenceArray[$refKey]['reference'] = mysqli_real_escape_string($db, $referenceArray[$refKey]['reference']);
												$referenceInsertQuery = "INSERT INTO temp_reference (symptom_id, full_reference, autor, reference) VALUES ('".$insertedSymtomId."', '".$referenceArray[$refKey]['full_reference']."', '".$referenceArray[$refKey]['autor']."', '".$referenceArray[$refKey]['reference']."')";
			            						$db->query($referenceInsertQuery);
			            						$newReferenceId = mysqli_insert_id($db);
			            						
			            						$referenceQuery = "INSERT INTO temp_symptom_reference (symptom_id, reference_id, is_new) VALUES ('".$insertedSymtomId."', '".$newReferenceId."', 1)";
								            	$db->query($referenceQuery);
			            					}
			            				}
			            			}
				            	}
				            	/* Reference End */
					            

								if ($Symptomnummer > 0)
									$Symptomnummer += 1;

								
								$Beschreibung = '';
								$Graduierung = '';
								$BereichID = '';
								$Fussnote = '';
								$Verweiss = '';
								$Unklarheiten = '';
								$Kommentar = '';
								$bracketedString = '';
								$timeString = '';
								if($parenthesesStringArray){
									$parenthesesStringArray= array ();
								}
								if($timeStringArray){
									$timeStringArray= array ();
								}
								if($bracketedStringArray){
									$bracketedStringArray= array ();
								}
								if($strongRedStringArray){
									$strongRedStringArray= array ();
								}
								if($strongBlueStringArray){
									$strongBlueStringArray= array ();
								}
								if ($aLiteraturquellen) {
									$aLiteraturquellen = array ();
									$EntnommenAus = '';
								}
								if ($prueferFromParray) {
									$prueferFromParray = array ();
									//$Pruefers = '';
								}
								$prueferIDarray = array();

								$needApproval = 0;
								$remedyArray = array();
								$prueferArray = array();
								$referenceArray = array();
								$prueferPriority = 0;
								$remedyPriority = 0;
								$partOfSymptomPriority = 0;
								$referencePriority = 0;
								$referenceWithNoAuthorPriority = 0;
								$remedyWithSymptomPriority = 0;
								$hyphenPrueferPriority = 0;
								$hyphenReferencePriority = 0;
								$hyphenApprovalString = "";
								$moreThanOneTagStringPriority = 0;
								$directOrderPriority = 0;
								$tagsApprovalString = "";
								$lastBracketedString = "";
								$isPreDefinedTagsApproval = 0;
								$symptomOfDifferentRemedy = "";
								$workingString = "";


							}
							$rownum ++;

							// If we arrive here, it means that no exception was thrown
				    		// i.e. no query has failed, and we can commit the transaction
				    		$db->commit();

						}catch (Exception $e) {
						    // An exception has been thrown
						    // We must rollback the transaction
						    $db->rollback();
						    $isThereAnyTransactionError = 1;

						    /* Delete Temp table data START */
							deleteSourceImportTempData($masterId);
							/* Delete Temp table data END */

						    break;
						}
						/* MySQL Transaction END */	

					}

				}

				// If No Transaction error occur above
				if($isThereAnyTransactionError == 0){
					/* First check if there is any symptom found with the master_id */
					$isAnySymptomResult = mysqli_query($db, "SELECT id FROM temp_quelle_import_test where master_id = '".$masterId."'");
					if(mysqli_num_rows($isAnySymptomResult) > 0){
						
						/* Check is there any unclear symptom found */
						$needApproveSearchResult = mysqli_query($db, "SELECT id FROM temp_quelle_import_test where master_id = '".$masterId."' AND need_approval = 1");
						if(mysqli_num_rows($needApproveSearchResult) > 0){
							$parameterString = '?master='.$masterId;
						}else{
							$parameterString = '';
							/* Inserting Temp table data to Main tables START */
							$masterResult = mysqli_query($db, "SELECT * FROM temp_quelle_import_master where id = '".$masterId."'");
							if(mysqli_num_rows($masterResult) > 0){
								$masterData = mysqli_fetch_assoc($masterResult); 

								try{
									// First of all, let's begin a transaction
									$db->begin_transaction();

									$masterData['import_rule'] = mysqli_real_escape_string($db, $masterData['import_rule']);
									$masterMainInsertQuery="INSERT INTO quelle_import_master (import_rule, ersteller_datum) VALUES ('".$masterData['import_rule']."', '".$date."')";
						            $db->query($masterMainInsertQuery);
						            $mainMasterId = mysqli_insert_id($db);

									// If we arrive here, it means that no exception was thrown
								    // i.e. no query has failed, and we can commit the transaction
								    $db->commit();
								}catch (Exception $e) {
								    // An exception has been thrown
								    // We must rollback the transaction
								    $db->rollback();
								    $isThereAnyTransactionError = 1;
								}

								try{
									// First of all, let's begin a transaction
									$db->begin_transaction();

									/* Insert Symptoms START */
						            $symptomResult = mysqli_query($db, "SELECT * FROM temp_quelle_import_test where master_id = '".$masterId."'");
									if(mysqli_num_rows($symptomResult) > 0){
										while($symptomData = mysqli_fetch_array($symptomResult)){
											$symptomData['Symptomnummer'] = mysqli_real_escape_string($db, $symptomData['Symptomnummer']);
											$symptomData['SeiteOriginalVon'] = mysqli_real_escape_string($db, $symptomData['SeiteOriginalVon']);
											$symptomData['SeiteOriginalBis'] = mysqli_real_escape_string($db, $symptomData['SeiteOriginalBis']);
											$symptomData['Beschreibung'] = mysqli_real_escape_string($db, $symptomData['Beschreibung']);
											$symptomData['BeschreibungOriginal'] = mysqli_real_escape_string($db, $symptomData['BeschreibungOriginal']);
											$symptomData['BeschreibungPlain'] = mysqli_real_escape_string($db, $symptomData['BeschreibungPlain']);
											$symptomData['bracketedString'] = mysqli_real_escape_string($db, $symptomData['bracketedString']);
											$symptomData['timeString'] = mysqli_real_escape_string($db, $symptomData['timeString']);
											$symptomData['Fussnote'] = mysqli_real_escape_string($db, $symptomData['Fussnote']);
											$symptomData['EntnommenAus'] = mysqli_real_escape_string($db, $symptomData['EntnommenAus']);
											$symptomData['Verweiss'] = mysqli_real_escape_string($db, $symptomData['Verweiss']);
											$symptomData['Graduierung'] = mysqli_real_escape_string($db, $symptomData['Graduierung']);
											$symptomData['BereichID'] = mysqli_real_escape_string($db, $symptomData['BereichID']);
											$symptomData['Kommentar'] = mysqli_real_escape_string($db, $symptomData['Kommentar']);
											$symptomData['Unklarheiten'] = mysqli_real_escape_string($db, $symptomData['Unklarheiten']);
											$symptomData['Remedy'] = mysqli_real_escape_string($db, $symptomData['Remedy']);
											$symptomData['symptom_of_different_remedy'] = mysqli_real_escape_string($db, $symptomData['symptom_of_different_remedy']);
											$mainSymptomInsertQuery="INSERT INTO quelle_import_test (master_id, Symptomnummer, SeiteOriginalVon, SeiteOriginalBis, Beschreibung, BeschreibungOriginal, BeschreibungPlain, bracketedString, timeString, Fussnote, EntnommenAus, Verweiss, Graduierung, BereichID, Kommentar, Unklarheiten, Remedy, symptom_of_different_remedy) VALUES (".$mainMasterId.", ".$symptomData['Symptomnummer'].",'".$symptomData['SeiteOriginalVon']."','".$symptomData['SeiteOriginalBis']."','".$symptomData['Beschreibung']."','".$symptomData['BeschreibungOriginal']."','".$symptomData['BeschreibungPlain']."','".$symptomData['bracketedString']."','".$symptomData['timeString']."','".$symptomData['Fussnote']."', '".$symptomData['EntnommenAus']."', '".$symptomData['Verweiss']."', '".$symptomData['Graduierung']."', '".$symptomData['BereichID']."', '".$symptomData['Kommentar']."', '".$symptomData['Unklarheiten']."', '".$symptomData['Remedy']."', '".$symptomData['symptom_of_different_remedy']."')";
									
								            $db->query($mainSymptomInsertQuery);
								            $mainSymtomId = mysqli_insert_id($db);

								            /* Insert Symptom_pruefer relation START */
								            $symptomPrueferResult = mysqli_query($db, "SELECT symptom_id, pruefer_id, is_new FROM temp_symptom_pruefer where symptom_id = '".$symptomData['id']."'");
											if(mysqli_num_rows($symptomPrueferResult) > 0){
												while($symptomPrueferData = mysqli_fetch_array($symptomPrueferResult)){
													$mainSymptomPrueferInsertQuery = "INSERT INTO symptom_pruefer (symptom_id, pruefer_id, ersteller_datum) VALUES ('".$mainSymtomId."', '".$symptomPrueferData['pruefer_id']."', '".$date."')";
									            	$db->query($mainSymptomPrueferInsertQuery);
												}
											}
											/* Insert Symptom_pruefer relation END */

											/* Insert symptom_reference relation START */
								            $symptomReferenceResult = mysqli_query($db, "SELECT symptom_id, reference_id, is_new FROM temp_symptom_reference where symptom_id = '".$symptomData['id']."'");
											if(mysqli_num_rows($symptomReferenceResult) > 0){
												while($symptomReferenceData = mysqli_fetch_array($symptomReferenceResult)){
													$mainSymptomReferenceInsertQuery = "INSERT INTO symptom_reference (symptom_id, reference_id, ersteller_datum) VALUES ('".$mainSymtomId."', '".$symptomReferenceData['reference_id']."', '".$date."')";
									            	$db->query($mainSymptomReferenceInsertQuery);
												}
											}
											/* Insert symptom_reference relation END */
										}
									}
						            /* Insert Symptoms END */

									// If we arrive here, it means that no exception was thrown
								    // i.e. no query has failed, and we can commit the transaction
								    $db->commit();
								}catch (Exception $e) {
								    // An exception has been thrown
								    // We must rollback the transaction
								    $db->rollback();
								    $isThereAnyTransactionError = 1;
								}
							}
							/* Inserting Temp table data to Main tables END */
							
							if($isThereAnyTransactionError == 0){
								/* Delete Temp table data START */
								$isDeleted = deleteSourceImportTempData($masterId);
								if($isDeleted === false)
									$isThereAnyTransactionError = 1;
								/* Delete Temp table data END */
							}
							
						}

					}
					else
					{
						/* If program reach here that means no new symptom are get instered in temp_symptom table, so all imported symptom are may be duplicate either from main table or tamp table or data not get added because of any kind of error or program logic */
						$parameterString = '?error=2';
						$query_delete="DELETE FROM temp_quelle_import_master WHERE id = '".$masterId."'";
						$db->query($query_delete);
					}
				}


				if($isThereAnyTransactionError == 1){
					header('Location: '.$baseUrl.'?error=1');
					exit();
				}
					

			}else{
				echo "Please enter valid text";
			}

			header('Location: '.$baseUrl.$parameterString);
			exit();
			/* Rule 1 End */

		}
		else if(isset($_POST['settings']) && $_POST['settings'] == "setting_2")
		{

			/* Rule 2 Start */
			$CleanedText = str_replace ( '</em><em>', '', $_POST['symptomtext'] );

			// $string = 'Haaaa <em>JJJJ</em><span>Hello..</span><span  class="heading" data-mce-style="letter-spacing: 3.0pt;" style="z-index:2px; font-size:5px; letter-spacing: 3.0pt; color:red;">hhhhhh</span><span style="letter-spacing: 3.0pt; font-size:5px;">Pabo</span> <span style="letter-spacing: 3.0pt;" data-mce-style="letter-spacing: 3.0pt;">Hoffnungslosigkeit.</span> heloww mew <a>hjgsd</a><span style="letter-spacing: 3.0pt;">Hoffnungslosigkeit.</span><span>How are you</span>';

			// $string = '<span >Helllo World</span><span style="font-size:12.0pt;font-family:&quot;Times New Roman&quot;,&quot;serif&quot;;
			// 	mso-fareast-font-family:&quot;Times New Roman&quot;;color:red;mso-ansi-language:EN-US;
			// 	mso-fareast-language:DE;mso-bidi-language:AR-SA">Stupor, with involuntary
			// 	discharge of feces.</span>';

			// $string .= '<span>Helllo World</span><span class="agsh" style="font-size: 12.0pt; mso-ansi-language: EN-US; mso-fareast-language: DE; mso-bidi-language: AR-SA;">PREFIX</span><span class="hecd" style="color:red;">I am Without any style</span><span style="font-size: 12.0pt; mso-ansi-language: EN-US; mso-fareast-language: DE; mso-bidi-language: AR-SA;">PREFIX</span><span style="font-size: 12.0pt; mso-ansi-language: EN-US; mso-fareast-language: DE; mso-bidi-language: AR-SA;">&nbsp;Concussion of brain.<br><strong><span style="color: blue;">Comatose, soporous, stupid states.</span></strong></span><span style="font-size: 12.0pt; mso-ansi-language: EN-US; mso-fareast-language: DE; mso-bidi-language: AR-SA;">SUFEX</span><span class="Hagt" style="color:blue;" title="heow">Last Test</span>';	

			// $count = 0; 
			// do { 
			// 	// $string = preg_replace("#<span[^>]*style=(\"|')[^>]*color:(.+?);[^>]*(\"|')>(.+?)</span>#is", "<clr style='color:$2;'>$4</clr>", $string, -1, $count ); 
			// 	$string = preg_replace("#<span[^>]*style=(\"|')[^>]*letter-spacing:[^>]*>(.+?)</span>#is", "<ss>$2</ss>", $string, -1, $count ); 
			// } while ( $count > 0 );

			// echo $string;
			// exit();

			$CleanedText = str_replace ( array (
				"\r",
				"\t" 
			), '', $CleanedText );
			$CleanedText = trim ( $CleanedText );
			$Lines = explode ( "\n", $CleanedText );

			if (count ( $Lines ) > 0) {
				$rownum = 1;
				$break = false;
				$Symptomnummer = 1;
				$SeiteOriginalVon = '';
				$SeiteOriginalBis = '';
				$PrueferIDs = array ();
				$PrueferID = '';
				$Pruefers = '';
				$Beschreibung = '';
				$Fussnote='';
				$Graduierung='';
				$BereichID='';
				$aLiteraturquellen = array ();
				$EntnommenAus='';
				$Verweiss = '';
				$Unklarheiten = '';
				$Kommentar = '';
				$bracketedString='';
				$timeString='';
				$parenthesesStringArray= array ();
				$timeStringArray= array ();
				$bracketedStringArray= array ();
				$strongRedStringArray= array ();
				$strongBlueStringArray= array ();

				foreach ( $Lines as $iline => $line ) {
					
					/*
					* Replacing Colored sentences's tag to our custom tag "<clr>"
					*/
					// $line = preg_replace("/<span(.*?)style=(\"|')(.*?)letter-spacing:(.+?)>(.+?)<\/span>/is", "<ss>$5</ss>", $line);
					// $line = preg_replace("/<span(.*?)style=(\"|')(.*?)color:(.+?);(.*?)>(.+?)<\/span>/is", "<clr style='color:$4;'>$6</clr>", $line);
					$coloredTextCnt = 0; 
					do { 
						$line = preg_replace("#<span[^>]*style=(\"|')[^>]*color:(.+?);[^>]*(\"|')>(.+?)</span>#is", "<clr style=\"color:$2;\">$4</clr>", $line, -1, $coloredTextCnt ); 
					} while ( $coloredTextCnt > 0 );
					/*
					* Replacing Spaced sentences's tag to our custom tag "<ss>"
					*/
					$letterSpaceCnt = 0; 
					do { 
						$line = preg_replace("#<span[^>]*style=(\"|')[^>]*letter-spacing:[^>]*>(.+?)</span>#is", "<ss>$2</ss>", $line, -1, $letterSpaceCnt ); 
					} while ( $letterSpaceCnt > 0 );
					
					
					$line = strip_tags ( $line, '<b><i><strong><em><u><sup><ss><clr>' );
					$break = false;
					$NewSymptomNr = 0;
					$line = trim ( $line );
					/*$cleanline = trim ( str_replace ( array (
						'&nbsp;',
						', a. a. O.' 
					), array (
						' ',
						'' 
					), strip_tags ( $line ) ) );*/
					$cleanline = trim ( str_replace ( array (
						'&nbsp;' 
					), array (
						' '
					), strip_tags ( $line ) ) );
					
					// Leerzeile
					if (empty ( $cleanline )) {
						$rownum ++;
						continue;
					}
					
					if (mb_strlen ( $cleanline ) < 3) {
						$rownum ++;
						continue;
					}
					// echo $line;
					// exit();
					$FirstChar = mb_substr ( $cleanline, 0, 1 );
					$LastChar = mb_substr ( $cleanline, mb_strlen ( $cleanline ) - 1 );
					$LastTwoChar = mb_substr ( $cleanline, mb_strlen ( $cleanline ) - 2 );

					$code='';
					$param='';
					if($FirstChar == '@'){
						$Beschreibung = '';
						$p = mb_strpos ( $cleanline, ':' );
						if ($p > 0) {
							$code = mb_substr ( $cleanline, 1, $p - 1 );
							$param = mb_substr ( $cleanline, $p + 1 );
						} else {
							$code = mb_substr ( $cleanline, 1 );
							$param = '';
						}
						
						$code = mb_strtoupper ( $code );

						switch ($code) {
							// Graduierung
							case 'G' :
								$Graduierung = $param;
								break;
							
							// Kapitel, setzt in DS "KapitelID"
							// case 'B' :
							case 'K' :
								$BereichID = $param;
								break;
							
							// Seite, setzt in DS "Seite"
							case 'S' :
								$tmp = explode ( '-', $param );
								$SeiteOriginalVon = $tmp [0] + 0;
								if (sizeof ( $tmp ) > 1)
									$SeiteOriginalBis = $tmp [1] + 0;
								else
									$SeiteOriginalBis = $SeiteOriginalVon;
								break;
							
							// Symptom-Nr., setzt in DS "Symptomnummer"
							case 'N' :
								$NewSymptomNr = $param + 0;
								if ($NewSymptomNr == 0) {
									//$NewSymptomNr = 1;
									$Symptomnummer = 0;
								}
								break;
							
							// Literaturquelle, setzt in DS "EntnommenAus"
							case 'L' :
								$aLiteraturquellen [] = $param;
								break;
							
							// Fußnote
							case 'F' :
								$Fussnote = $param;
								break;
							
							// Verweiss
							case 'V' :
								$Verweiss = $param;
								break;
							
							// @U: (Unklarheit, steht wie auch @F und @L VOR dem einen Symptom, welches betroffen ist)
							case 'U' :
								$Unklarheiten = $param;
								break;
							
							// @C: (Kommentar, steht wie auch @F und @L VOR dem einen Symptom, welches betroffen ist)
							case 'C' :
								$Kommentar = $param;
								break;
							
							// @P: Prüfer als Kürzel
							case 'P' :
								// $PrueferID = $this->LookupPruefer ( $param, $rownum );
								// $PrueferID = $param;
								// if ($PrueferID > 0) {
								// 	$PrueferIDs [] = $PrueferID;
								// } 
								$PrueferIDs [] = $param;
								break;
							
							default :
								$break = true;
								break;
						}
						//continue;
					} else if ($FirstChar == '(') {
						/* 
						* parseing symptoms nummer which has parentheses between symptom nummer 
						* Eg : (90) Fauleier-Geschmack im Munde, außer dem Essen. (Fr. Hahnemann.)
						*/
						$p = mb_strpos ( $line, ')' );
						if ($p > 0) {
							$NewSymptomNr = trim ( mb_substr ( $line, 1, $p - 1 ) );
							if (is_numeric ( $NewSymptomNr )) {
								$Beschreibung = trim ( mb_substr ( $line, $p + 1 ) );
								$cleanline = trim ( mb_substr ( $cleanline, $p + 1 ) );
							} else {
								$NewSymptomNr = 0;
								$Beschreibung = $line;
							}
						}
					} else {
						$isSymptomNum = is_numeric ( $FirstChar );
						$Beschreibung = '';
						
						if ($isSymptomNum) {
							/* 
							* parseing symptoms nummer which has space between symptom nummer and symptom string 
							* Eg : 30 Merklich vermindertes Gehör. (n. 30 St.)
							*/
							$p = mb_strpos ( $line, ' ' );
							$num = str_replace ( array (
								':',
								'.', 
								')' 
							), '', mb_substr ( $line, 0, $p ) );
							if( is_numeric($num) ){
								$NewSymptomNr = $num;
								$Beschreibung = trim ( mb_substr ( $line, $p + 1 ) );
								$cleanline = trim ( mb_substr ( $cleanline, $p + 1 ) );
							}else{
								/* 
								* parseing symptoms nummer which are attached with Synptom string 
								* Eg : 10Drückender Schmerz in der Stirne.
								*/
								$charCount = 2;
								$NewSymptomNr = $FirstChar;
								while ( $charCount > 0 ) {
									$checkSymptomNumber = mb_substr ( $line, 0, $charCount );
									if( is_numeric($checkSymptomNumber) ){
										$NewSymptomNr = $checkSymptomNumber;
										$charCount++;
									}else
										$charCount = 0;
								}

								if (mb_substr($line, 0, mb_strlen($NewSymptomNr)) == $NewSymptomNr) {
								    $Beschreibung = trim ( mb_substr($line, mb_strlen($NewSymptomNr)) );
								    $cleanline = trim ( mb_substr($cleanline, mb_strlen($NewSymptomNr)) );
								}else{
									$Beschreibung = $line;
								} 
							}
						} else {
							$NewSymptomNr = 0;
							$Beschreibung = $line;
						}
					}

					if ( $NewSymptomNr > 0 ) {
						$Symptomnummer = $NewSymptomNr;
					}

					if ($break) {
						$Beschreibung = '';
						break;
					}
					
					if ($Beschreibung) {
						/* Creating Plain Symptom text */
						$BeschreibungPlain = trim ( str_replace ( "\t", '', strip_tags ( $Beschreibung ) ) );

						/* Creating Original Symptom text start */
						$Beschreibung = preg_replace("#<b[^>]*></b>#is", "", $Beschreibung ); 
						$Beschreibung = preg_replace("#<strong[^>]*></strong>#is", "", $Beschreibung ); 
						$Beschreibung = preg_replace("#<i[^>]*></i>#is", "", $Beschreibung ); 
						$Beschreibung = preg_replace("#<em[^>]*></em>#is", "", $Beschreibung ); 
						/* Making a common tag for all bold tags - <commonbold> */
						$BeschreibungWithCommonBoldTag = str_replace ( array (
							'<strong',
							'</strong>',
							'<b',
							'</b>' 
						), array (
							"<commonbold",
							"</commonbold>",
							"<commonbold",
							"</commonbold>" 
						), $Beschreibung );

						/* Making a common tag for all Italic tags - <commonitalic> */
						$BeschreibungWithCommonItalicTag = str_replace ( array (
							'<em',
							'</em>'
						), array (
							"<commonitalic",
							"</commonitalic>"
						), $Beschreibung );

						
						$BeschreibungWithCommonItalicTag = preg_replace("#<i[^>]*>(.+?)</i>#is", '<commonitalic>$1</commonitalic>', $BeschreibungWithCommonItalicTag ); 
						
						
						if( htmlentities(mb_substr($BeschreibungWithCommonBoldTag, 0, mb_strlen('<commonbold><clr style="color: blue;">'))) === htmlentities('<commonbold><clr style="color: blue;">') AND htmlentities(mb_substr($BeschreibungWithCommonBoldTag,-mb_strlen('</clr></commonbold>'))) === htmlentities('</clr></commonbold>') )
						{
							/* Extracting Original Symptom text for BOLD BLUE */
							$BeschreibungOriginal = str_replace ( array (
								'<ss>',
								'</ss>' 
							), array (
								"<span class=\"text-sperrschrift\">",
								"</span>" 
							), $Beschreibung );
							$BeschreibungOriginal = strip_tags ( $BeschreibungOriginal, '<sup><span>' );
							$BeschreibungOriginal = '<strong>|</strong> '.trim($BeschreibungOriginal);
							// echo $BeschreibungOriginal;
						}
						else if( htmlentities(mb_substr($BeschreibungWithCommonBoldTag, 0, mb_strlen('<commonbold><clr style="color: red;">'))) === htmlentities('<commonbold><clr style="color: red;">') AND htmlentities(mb_substr($BeschreibungWithCommonBoldTag,-mb_strlen('</clr></commonbold>'))) === htmlentities('</clr></commonbold>') )
						{
							/* Extracting Original Symptom text for BOLD RED */
							$BeschreibungOriginal = str_replace ( array (
								'<ss>',
								'</ss>' 
							), array (
								"<span class=\"text-sperrschrift\">",
								"</span>" 
							), $Beschreibung );
							$BeschreibungOriginal = strip_tags ( $BeschreibungOriginal, '<sup><span>' );
							$BeschreibungOriginal = '<strong>| |</strong> '.trim($BeschreibungOriginal);
							// echo $BeschreibungOriginal;
						}
						else if( htmlentities(mb_substr($BeschreibungWithCommonItalicTag, 0, mb_strlen('<commonitalic><clr'))) === htmlentities('<commonitalic><clr') AND htmlentities(mb_substr($BeschreibungWithCommonItalicTag,-mb_strlen('</clr></commonitalic>'))) === htmlentities('</clr></commonitalic>') )
						{
							/* Extracting Original Symptom text for ITALIC BLUE & RED(Both for now) */
							$BeschreibungOriginal = str_replace ( array (
								'<ss>',
								'</ss>' 
							), array (
								"<span class=\"text-sperrschrift\">",
								"</span>" 
							), $Beschreibung );
							$BeschreibungOriginal = strip_tags ( $BeschreibungOriginal, '<sup><span>' );
							$BeschreibungOriginal = '|| '.trim($BeschreibungOriginal);
							// echo $BeschreibungOriginal;
						}
						else
						{
							/* Extracting Original Symptom text for REST of the patterns */
							$BeschreibungOriginal = str_replace ( array (
								'<ss>',
								'</ss>' 
							), array (
								"<span class=\"text-sperrschrift\">",
								"</span>" 
							), $Beschreibung );
							$BeschreibungOriginal = trim ( strip_tags ( $BeschreibungOriginal, '<sup><span>' ) );
							// echo $BeschreibungOriginal;
						}
						// exit();
						/* Creating Original Symptom text end */
						
						/* Creating Source or as it is Symtom text start */
						$Beschreibung2 = str_replace ( array (
							'<ss>',
							'</ss>' 
						), array (
							"<span class=\"text-sperrschrift\">",
							"</span>" 
						), $Beschreibung );

						$Beschreibung2 = str_replace ( array (
							'<clr',
							'</clr>' 
						), array (
							"<span",
							"</span>" 
						), $Beschreibung2 );
						if ($Beschreibung2 != $Beschreibung) {
							$Beschreibung = $Beschreibung2;
						}
						/* Creating Source or as it is Symtom text end */


						/* Getting parentheses or square brackets datas start */
						$bracketP = false;

						if ($LastChar == ')' or $LastTwoChar ==').' or $LastTwoChar =='),') {
							//echo $FirstChar." ... ".$LastChar;
							// $FirstOccurrence = mb_stripos ( $cleanline, '(' );
							// if($FirstOccurrence != 0){
								$bracketP = mb_strripos ( $cleanline, '(' );
								//echo $FirstChar." ... ".$LastChar." -> ".$bracketP;
								//exit();
								if ($bracketP > 0) {
									
									/* 
									* Cheching is there any nested parentheses string, and taking the appropriate action 
									* Eg: (95) Leeres Aufstoßen. (n. 1/4 St.) (Hornburg, a. a. O. - (n. 1/2 St.)Kummer, a. a. O.) 
									*/
									$rowParenthesesString = mb_substr ( $cleanline, $bracketP );
									$numberOfClosingParentheses=mb_substr_count($rowParenthesesString,")");
									if( $numberOfClosingParentheses > 1 ){
										while( $numberOfClosingParentheses > 1 ){ 
											$remainingStringFromBegining = mb_substr ( $cleanline, 0, mb_strlen($cleanline)-mb_strlen($rowParenthesesString) );
											$lastOccuranceOfParentheses = mb_strripos ( $remainingStringFromBegining, '(' );
											$prePartString = mb_substr ( $remainingStringFromBegining, $lastOccuranceOfParentheses );
											if( mb_substr_count($prePartString,")") > 0 ){
												$numberOfClosingParentheses = $numberOfClosingParentheses + mb_substr_count($prePartString,")");
											}
											$rowParenthesesString = $prePartString.$rowParenthesesString;
											$numberOfClosingParentheses--;
										}
										$parenthesesStringArray[] = $rowParenthesesString;
										$newString = rtrim( mb_substr ( $cleanline, 0, mb_strlen($cleanline)-mb_strlen($rowParenthesesString) ) );
									}
									else{
										/*
										* Checking if it's time data or not
										*/
										if ((mb_substr($cleanline,-mb_strlen('St)'))==='St)') OR (mb_substr($cleanline,-mb_strlen('St.)'))==='St.)') OR (mb_substr($cleanline,-mb_strlen('St. )'))==='St. )') OR (mb_substr($cleanline,-mb_strlen('St.).'))==='St.).') OR (mb_substr($cleanline,-mb_strlen('Tagen.)'))==='Tagen.)') OR (mb_substr($cleanline,-mb_strlen('Tagen.).'))==='Tagen.).') OR (mb_substr($cleanline,-mb_strlen('Tagen)'))==='Tagen)') OR (mb_substr($cleanline,-mb_strlen('Tagen).'))==='Tagen).') OR (mb_substr($cleanline,-mb_strlen('Nacht)'))==='Nacht)') OR (mb_substr($cleanline,-mb_strlen('Tag)'))==='Tag)') OR (mb_substr($cleanline,-mb_strlen('Tag.)'))==='Tag.)') OR (mb_substr($cleanline,-mb_strlen('Tag.).'))==='Tag.).') OR (mb_substr($cleanline,-mb_strlen('hour.).'))==='hour.).') OR (mb_substr($cleanline,-mb_strlen('hour).'))==='hour).') OR (mb_substr($cleanline,-mb_strlen('hour)'))==='hour)') OR (mb_substr($cleanline,-mb_strlen('hour),'))==='hour),') OR (mb_substr($cleanline,-mb_strlen('hour.),'))==='hour.),') OR (mb_substr($cleanline,-mb_strlen('hours)'))==='hours)') OR (mb_substr($cleanline,-mb_strlen('hours).'))==='hours).') OR (mb_substr($cleanline,-mb_strlen('hours.)'))==='hours.)') OR (mb_substr($cleanline,-mb_strlen('hours.).'))==='hours.).') OR (mb_substr($cleanline,-mb_strlen('hours),'))==='hours),') OR (mb_substr($cleanline,-mb_strlen('hours.),'))==='hours.),') OR (mb_substr($cleanline,-mb_strlen('Hour.).'))==='Hour.).') OR (mb_substr($cleanline,-mb_strlen('Hour).'))==='Hour).') OR (mb_substr($cleanline,-mb_strlen('Hour)'))==='Hour)') OR (mb_substr($cleanline,-mb_strlen('Hour),'))==='Hour),') OR (mb_substr($cleanline,-mb_strlen('Hour.),'))==='Hour.),') OR (mb_substr($cleanline,-mb_strlen('Hours)'))==='Hours)') OR (mb_substr($cleanline,-mb_strlen('Hours).'))==='Hours).') OR (mb_substr($cleanline,-mb_strlen('Hours.)'))==='Hours.)') OR (mb_substr($cleanline,-mb_strlen('Hours.).'))==='Hours.).') OR (mb_substr($cleanline,-mb_strlen('Hours),'))==='Hours),') OR (mb_substr($cleanline,-mb_strlen('Hours.),'))==='Hours.),') OR (mb_substr($cleanline,-mb_strlen('minute.).'))==='minute.).') OR (mb_substr($cleanline,-mb_strlen('minute).'))==='minute).') OR (mb_substr($cleanline,-mb_strlen('minute)'))==='minute)') OR (mb_substr($cleanline,-mb_strlen('minute),'))==='minute),') OR (mb_substr($cleanline,-mb_strlen('minute.),'))==='minute.),') OR (mb_substr($cleanline,-mb_strlen('minutes)'))==='minutes)') OR (mb_substr($cleanline,-mb_strlen('minutes.)'))==='minutes.)') OR (mb_substr($cleanline,-mb_strlen('minutes.).'))==='minutes.).') OR (mb_substr($cleanline,-mb_strlen('minutes),'))==='minutes),') OR (mb_substr($cleanline,-mb_strlen('minutes.),'))==='minutes.),') OR (mb_substr($cleanline,-mb_strlen('Minute.).'))==='Minute.).') OR (mb_substr($cleanline,-mb_strlen('Minute).'))==='Minute).') OR (mb_substr($cleanline,-mb_strlen('Minute)'))==='Minute)') OR (mb_substr($cleanline,-mb_strlen('Minute),'))==='Minute),') OR (mb_substr($cleanline,-mb_strlen('Minute.),'))==='Minute.),') OR (mb_substr($cleanline,-mb_strlen('Minutes)'))==='Minutes)') OR (mb_substr($cleanline,-mb_strlen('Minutes.)'))==='Minutes.)') OR (mb_substr($cleanline,-mb_strlen('Minutes.).'))==='Minutes.).') OR (mb_substr($cleanline,-mb_strlen('Minutes),'))==='Minutes),') OR (mb_substr($cleanline,-mb_strlen('Minutes.),'))==='Minutes.),')){
											$timeStringArray[] = rtrim( mb_substr ( $cleanline, $bracketP + 1, - 1 ), ')' );
										}else{
											$parenthesesStringArray[] = rtrim( mb_substr ( $cleanline, $bracketP + 1, - 1 ), ')' );	
										}
										/*
										* Here storing the remaining from the begning to last occurance of "(" for checking if there more parentheses set 
										*/
										$newString = rtrim( mb_substr ( $cleanline, 0, $bracketP ) );
									}
									 
									while ($newString != "") {
										$cleanedRemainingString = rtrim($newString);
										if (mb_substr($newString,-mb_strlen('und'))==='und') 
											$cleanedRemainingString = rtrim( mb_substr($newString, 0, mb_strlen($newString)-mb_strlen('und')));
										else if (mb_substr($newString,-mb_strlen('and'))==='and') 
											$cleanedRemainingString = rtrim( mb_substr($newString, 0, mb_strlen($newString)-mb_strlen('and')));
										else if (mb_substr($newString,-mb_strlen('.'))==='.') 
											$cleanedRemainingString = rtrim( mb_substr($newString, 0, mb_strlen($newString)-mb_strlen('.')));

										$cleanedRemainingString = rtrim($cleanedRemainingString);
										$newLastChar = mb_substr ( $cleanedRemainingString, mb_strlen ( $cleanedRemainingString ) - 1 );
										
										if( $newLastChar == ')' ){
											$newBracketP = mb_strripos ( $cleanedRemainingString, '(' );
											if ($newBracketP > 0) {
												/* 
												* Cheching is there any nested parentheses string, and taking the appropriate action 
												* Eg: (95) Leeres Aufstoßen. (n. (1/4) St.) (Hornburg, a. a. O. - (n. 1/2 St.)Kummer, a. a. O.) 
												*/
												$newRowParenthesesString = mb_substr ( $cleanedRemainingString, $newBracketP );
												$newNumberOfClosingParentheses=mb_substr_count($newRowParenthesesString,")");
												if( $newNumberOfClosingParentheses > 1 ){
													while( $newNumberOfClosingParentheses > 1 ){ 
														$newRemainingStringFromBegining = mb_substr ( $cleanedRemainingString, 0, mb_strlen($cleanedRemainingString)-mb_strlen($newRowParenthesesString) );
														$newLastOccuranceOfParentheses = mb_strripos ( $newRemainingStringFromBegining, '(' );
														$newPrePartString = mb_substr ( $newRemainingStringFromBegining, $newLastOccuranceOfParentheses );
														if( mb_substr_count($newPrePartString,")") > 0 ){
															$newNumberOfClosingParentheses = $newNumberOfClosingParentheses + mb_substr_count($newPrePartString,")");
														}
														$newRowParenthesesString = $newPrePartString.$newRowParenthesesString;
														$newNumberOfClosingParentheses--;
													}
													$parenthesesStringArray[] = $newRowParenthesesString;
													$newString = rtrim( mb_substr ( $cleanedRemainingString, 0, mb_strlen($cleanedRemainingString)-mb_strlen($newRowParenthesesString) ) );
												}
												else{
													/*
													* Checking if it's time data or not
													*/
													if ((mb_substr($cleanedRemainingString,-mb_strlen('St)'))==='St)') OR (mb_substr($cleanedRemainingString,-mb_strlen('St. )'))==='St. )') OR (mb_substr($cleanedRemainingString,-mb_strlen('St.)'))==='St.)') OR (mb_substr($cleanedRemainingString,-mb_strlen('St.).'))==='St.).') OR (mb_substr($cleanedRemainingString,-mb_strlen('Tagen.)'))==='Tagen.)') OR (mb_substr($cleanedRemainingString,-mb_strlen('Tagen.).'))==='Tagen.).') OR (mb_substr($cleanedRemainingString,-mb_strlen('Tagen)'))==='Tagen)') OR (mb_substr($cleanedRemainingString,-mb_strlen('Tagen).'))==='Tagen).') OR (mb_substr($cleanedRemainingString,-mb_strlen('Nacht)'))==='Nacht)') OR (mb_substr($cleanedRemainingString,-mb_strlen('Tag)'))==='Tag)') OR (mb_substr($cleanedRemainingString,-mb_strlen('Tag.)'))==='Tag.)') OR (mb_substr($cleanedRemainingString,-mb_strlen('Tag.).'))==='Tag.).') OR (mb_substr($cleanedRemainingString,-mb_strlen('hour.).'))==='hour.).') OR (mb_substr($cleanedRemainingString,-mb_strlen('hour).'))==='hour).') OR (mb_substr($cleanedRemainingString,-mb_strlen('hour)'))==='hour)') OR (mb_substr($cleanedRemainingString,-mb_strlen('hour),'))==='hour),') OR (mb_substr($cleanedRemainingString,-mb_strlen('hour.),'))==='hour.),') OR (mb_substr($cleanedRemainingString,-mb_strlen('hours)'))==='hours)')  OR (mb_substr($cleanedRemainingString,-mb_strlen('hours).'))==='hours).') OR (mb_substr($cleanedRemainingString,-mb_strlen('hours.)'))==='hours.)') OR (mb_substr($cleanedRemainingString,-mb_strlen('hours.).'))==='hours.).') OR (mb_substr($cleanedRemainingString,-mb_strlen('hours),'))==='hours),') OR (mb_substr($cleanedRemainingString,-mb_strlen('hours.),'))==='hours.),') OR (mb_substr($cleanedRemainingString,-mb_strlen('Hour.).'))==='Hour.).') OR (mb_substr($cleanedRemainingString,-mb_strlen('Hour).'))==='Hour).') OR (mb_substr($cleanedRemainingString,-mb_strlen('Hour)'))==='Hour)') OR (mb_substr($cleanedRemainingString,-mb_strlen('Hour),'))==='Hour),') OR (mb_substr($cleanedRemainingString,-mb_strlen('Hour.),'))==='Hour.),') OR (mb_substr($cleanedRemainingString,-mb_strlen('Hours)'))==='Hours)')  OR (mb_substr($cleanedRemainingString,-mb_strlen('Hours).'))==='Hours).')OR (mb_substr($cleanedRemainingString,-mb_strlen('Hours.)'))==='Hours.)') OR (mb_substr($cleanedRemainingString,-mb_strlen('Hours.).'))==='Hours.).') OR (mb_substr($cleanedRemainingString,-mb_strlen('Hours),'))==='Hours),') OR (mb_substr($cleanedRemainingString,-mb_strlen('Hours.),'))==='Hours.),') OR (mb_substr($cleanedRemainingString,-mb_strlen('minute.).'))==='minute.).') OR (mb_substr($cleanedRemainingString,-mb_strlen('minute).'))==='minute).') OR (mb_substr($cleanedRemainingString,-mb_strlen('minute)'))==='minute)') OR (mb_substr($cleanedRemainingString,-mb_strlen('minute),'))==='minute),') OR (mb_substr($cleanedRemainingString,-mb_strlen('minute.),'))==='minute.),') OR (mb_substr($cleanedRemainingString,-mb_strlen('minutes)'))==='minutes)') OR (mb_substr($cleanedRemainingString,-mb_strlen('minutes).'))==='minutes).') OR (mb_substr($cleanedRemainingString,-mb_strlen('minutes.)'))==='minutes.)') OR (mb_substr($cleanedRemainingString,-mb_strlen('minutes.).'))==='minutes.).') OR (mb_substr($cleanedRemainingString,-mb_strlen('minutes),'))==='minutes),') OR (mb_substr($cleanedRemainingString,-mb_strlen('minutes.),'))==='minutes.),') OR (mb_substr($cleanedRemainingString,-mb_strlen('Minute.).'))==='Minute.).') OR (mb_substr($cleanedRemainingString,-mb_strlen('Minute).'))==='Minute).') OR (mb_substr($cleanedRemainingString,-mb_strlen('Minute)'))==='Minute)') OR (mb_substr($cleanedRemainingString,-mb_strlen('Minute),'))==='Minute),') OR (mb_substr($cleanedRemainingString,-mb_strlen('Minute.),'))==='Minute.),') OR (mb_substr($cleanedRemainingString,-mb_strlen('Minutes)'))==='Minutes)') OR (mb_substr($cleanedRemainingString,-mb_strlen('Minutes).'))==='Minutes).') OR (mb_substr($cleanedRemainingString,-mb_strlen('Minutes.)'))==='Minutes.)') OR (mb_substr($cleanedRemainingString,-mb_strlen('Minutes.).'))==='Minutes.).') OR (mb_substr($cleanedRemainingString,-mb_strlen('Minutes),'))==='Minutes),') OR (mb_substr($cleanedRemainingString,-mb_strlen('Minutes.),'))==='Minutes.),')){
														$timeStringArray[] = mb_substr ( $cleanedRemainingString, $newBracketP + 1, - 1 );
													}else{
														$parenthesesStringArray[] = mb_substr ( $cleanedRemainingString, $newBracketP + 1, - 1 );
													}
													/*
													* Here storing the remaining from the begning to last occurance of "(" for checking if there more parentheses set 
													*/
													$newString = rtrim( mb_substr ( $cleanedRemainingString, 0, $newBracketP ) );
												}

											}
											else
												$newString = "";
										}
										else
											$newString = "";
									}
									$bracketedString = implode(', ', $parenthesesStringArray);
									$timeString = implode(', ', $timeStringArray);
									// echo $bracketedString." - ".$newString;
									// exit();
								}
							// }
						} else if ($LastChar == ']' or $LastTwoChar =='].') {
							// $FirstOccurrence = mb_stripos ( $cleanline, '[' );
							// if($FirstOccurrence != 0){
								$bracketP = mb_strripos ( $cleanline, '[' );
								//echo $FirstChar." ... ".$LastChar." -> ".$bracketP;
								//exit();
								if ($bracketP > 0) {
									/* 
									* Cheching is there any nested bracketed string, and taking the appropriate action 
									* Eg: (95) Leeres Aufstoßen. [n. 1/4 St.] [Hornburg, a. a. O. - [n. 1/2 St.]Kummer, a. a. O.] 
									*/
									$rowBracketedString = mb_substr ( $cleanline, $bracketP );
									$numberOfClosingBrackets=mb_substr_count($rowBracketedString,"]");
									if( $numberOfClosingBrackets > 1 ){
										while( $numberOfClosingBrackets > 1 ){ 
											$remainingStringFromBegining = mb_substr ( $cleanline, 0, mb_strlen($cleanline)-mb_strlen($rowBracketedString) );
											$lastOccuranceOfBracket = mb_strripos ( $remainingStringFromBegining, '[' );
											$prePartString = mb_substr ( $remainingStringFromBegining, $lastOccuranceOfBracket );
											if( mb_substr_count($prePartString,"]") > 0 ){
												$numberOfClosingBrackets = $numberOfClosingBrackets + mb_substr_count($prePartString,"]");
											}
											$rowBracketedString = $prePartString.$rowBracketedString;
											$numberOfClosingBrackets--;
										}
										$bracketedStringArray[] = $rowBracketedString;
										$newString = rtrim( mb_substr ( $cleanline, 0, mb_strlen($cleanline)-mb_strlen($rowBracketedString) ) );
									}
									else{
										// last characters can be ']' or '].' also so rtrim ']'
										$bracketedStringArray[] = rtrim( mb_substr ( $cleanline, $bracketP + 1, - 1 ), ']' );
										$newString = rtrim( mb_substr ( $cleanline, 0, $bracketP ) );
									}
									
									while ($newString != "") {
										$cleanedRemainingString = rtrim($newString);
										if (mb_substr($newString,-mb_strlen('und'))==='und') 
											$cleanedRemainingString = rtrim( mb_substr($newString, 0, mb_strlen($newString)-mb_strlen('und')));
										else if (mb_substr($newString,-mb_strlen('and'))==='and') 
											$cleanedRemainingString = rtrim( mb_substr($newString, 0, mb_strlen($newString)-mb_strlen('and')));
										else if (mb_substr($newString,-mb_strlen('.'))==='.') 
											$cleanedRemainingString = rtrim( mb_substr($newString, 0, mb_strlen($newString)-mb_strlen('.')));

										$cleanedRemainingString = rtrim($cleanedRemainingString);
										$newLastChar = mb_substr ( $cleanedRemainingString, mb_strlen ( $cleanedRemainingString ) - 1 );
										
										if( $newLastChar == ']' ){
											$newBracketP = mb_strripos ( $cleanedRemainingString, '[' );
											if ($newBracketP > 0) {
												/* 
												* Cheching is there any nested bracketed string, and taking the appropriate action 
												* Eg: (95) Leeres Aufstoßen. [n. [1/4] St.] [Hornburg, a. a. O. - [n. 1/2 St.]Kummer, a. a. O.] 
												*/
												$newRowBracketedString = mb_substr ( $cleanedRemainingString, $newBracketP );
												$newNumberOfClosingBrackets=mb_substr_count($newRowBracketedString,"]");
												if( $newNumberOfClosingBrackets > 1 ){
													while( $newNumberOfClosingBrackets > 1 ){ 
														$newRemainingStringFromBegining = mb_substr ( $cleanedRemainingString, 0, mb_strlen($cleanedRemainingString)-mb_strlen($newRowBracketedString) );
														$newLastOccuranceOfBracket = mb_strripos ( $newRemainingStringFromBegining, '[' );
														$newPrePartString = mb_substr ( $newRemainingStringFromBegining, $newLastOccuranceOfBracket );
														if( mb_substr_count($newPrePartString,"]") > 0 ){
															$newNumberOfClosingBrackets = $newNumberOfClosingBrackets + mb_substr_count($newPrePartString,"]");
														}
														$newRowBracketedString = $newPrePartString.$newRowBracketedString;
														$newNumberOfClosingBrackets--;
													}
													$bracketedStringArray[] = $newRowBracketedString;
													$newString = rtrim( mb_substr ( $cleanedRemainingString, 0, mb_strlen($cleanedRemainingString)-mb_strlen($newRowBracketedString) ) );
												}
												else{
													$bracketedStringArray[] = mb_substr ( $cleanedRemainingString, $newBracketP + 1, - 1 );
													$newString = rtrim( mb_substr ( $cleanedRemainingString, 0, $newBracketP ) );
												}

											}
											else
												$newString = "";
										}
										else
											$newString = "";
									}
									$bracketedString = implode(', ', $bracketedStringArray);
									// echo $bracketedString." - ".$newString;
									// exit();
								}
							// }
						}
						
						/* Getting parentheses or square brackets datas end */

						if ($aLiteraturquellen) {
							$EntnommenAus = join ( "\n", $aLiteraturquellen );
						}

						if ($PrueferIDs) {
							$Pruefers = join ( "\n", $PrueferIDs );
						}

						
	 					$data['Symptomnummer']= ( $Symptomnummer != "" and $Symptomnummer != 0 ) ? mysqli_real_escape_string($db, $Symptomnummer) : 'null';
						$data['SeiteOriginalVon']=($SeiteOriginalVon == '') ? 0 : $SeiteOriginalVon;
						$data['SeiteOriginalBis']=($SeiteOriginalBis == '') ? 0 : $SeiteOriginalBis;
						$data['Beschreibung']=mysqli_real_escape_string($db, $Beschreibung);
						$data['BeschreibungOriginal']=mysqli_real_escape_string($db, $BeschreibungOriginal);
						$data['BeschreibungPlain']=mysqli_real_escape_string($db, $BeschreibungPlain);
						$data['bracketedString']=mysqli_real_escape_string($db, $bracketedString);
						$data['timeString']=mysqli_real_escape_string($db, $timeString);
						$data['Fussnote']=mysqli_real_escape_string($db, $Fussnote);
						$data['PrueferID']=mysqli_real_escape_string($db, $Pruefers);
						$data['EntnommenAus']=mysqli_real_escape_string($db, $EntnommenAus);
						$data['Verweiss']=mysqli_real_escape_string($db, $Verweiss);
						$data['Graduierung']=mysqli_real_escape_string($db, $Graduierung);
						$data['BereichID']=mysqli_real_escape_string($db, $BereichID);
						$data['Kommentar']=mysqli_real_escape_string($db, $Kommentar);
						$data['Unklarheiten']=mysqli_real_escape_string($db, $Unklarheiten);

						$query="INSERT INTO quelle_import_test (Symptomnummer, SeiteOriginalVon, SeiteOriginalBis, Beschreibung, BeschreibungOriginal, BeschreibungPlain, bracketedString, timeString, Fussnote, PrueferID, EntnommenAus, Verweiss, Graduierung, BereichID, Kommentar, Unklarheiten) VALUES (".$data['Symptomnummer'].",'".$data['SeiteOriginalVon']."','".$data['SeiteOriginalBis']."','".$data['Beschreibung']."','".$data['BeschreibungOriginal']."','".$data['BeschreibungPlain']."','".$data['bracketedString']."','".$data['timeString']."','".$data['Fussnote']."','".$data['PrueferID']."', '".$data['EntnommenAus']."', '".$data['Verweiss']."', '".$data['Graduierung']."', '".$data['BereichID']."', '".$data['Kommentar']."', '".$data['Unklarheiten']."')";
						// echo $query;
						// exit();
			            $db->query($query);

						if ($Symptomnummer > 0)
							$Symptomnummer += 1;
						
						$Beschreibung = '';
						$Graduierung = '';
						$BereichID = '';
						$Fussnote = '';
						$Verweiss = '';
						$Unklarheiten = '';
						$Kommentar = '';
						$PrueferID='';
						$bracketedString = '';
						$timeString = '';
						if($parenthesesStringArray){
							$parenthesesStringArray= array ();
						}
						if($timeStringArray){
							$timeStringArray= array ();
						}
						if($bracketedStringArray){
							$bracketedStringArray= array ();
						}
						if ($aLiteraturquellen) {
							$aLiteraturquellen = array ();
							$EntnommenAus = '';
						}
						if ($PrueferIDs) {
							$PrueferIDs = array ();
							$Pruefers = '';
						}
					}
					$rownum ++;
				}
			}else{
				echo "Please enter valid text";
			}

			header('Location: '.$baseUrl);
			exit();
			/* Rule 2 End */

		}else{
			header('Location: '.$baseUrl.'?rule_error=1');
			exit();
		}

	}


	/* Deleting Temp source import data */
	if(isset($_POST['deleteing_master_id']) AND $_POST['deleteing_master_id'] != ""){
		/* Delete Temp table data START */
		deleteSourceImportTempData($_POST['deleteing_master_id']);
		/* Delete Temp table data END */
	}

	if(isset($_POST['delete'])){
		$query_delete="DELETE FROM quelle_import_test";
		$db->query($query_delete);
		$query_delete1="DELETE FROM symptom_pruefer";
		$db->query($query_delete1);
		$query_delete2="DELETE FROM symptom_reference";
		$db->query($query_delete2);
		$query_delete3="DELETE FROM quelle_import_master";
		$db->query($query_delete3);
	}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Text Editor</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<!-- Font Awesome -->
  	<link rel="stylesheet" href="plugins/font-awesome/css/fontawesome-all.min.css">
	<style type="text/css">
		.text-sperrschrift {
			letter-spacing: .3em;
		}
		.container {
			padding: 40px;
		}
		.mce-ico.mce-i-space {
		    font-family: FontAwesome;
		}
		.modal-footer{
			text-align: center;
		}
		.small, small {
			font-size: 80%;
		}
		checkbox label, .radio label {
			font-size: 17px;
		}
		small strong.text-danger {
			font-size: 15px;
		}
		.spacer {
			margin-top: 22px;
		}
		.table thead th{
			position: sticky;
			top: -1px;
			background: #EEE;
		}
		h5 { 
			width: 75%;
			border-bottom: 1px solid #000;
			line-height: 0.1em;
			font-size: 25px;
			margin: 0 auto;
			clear: both;
			margin-top: 10px;
			margin-bottom: 20px; 
		} 
		h5 span { 
			background:#fff; 
			padding:0 10px; 
		}
		.btn-order{
			padding: 6px 35px;

		}
		.form-group.new-pruefer label{
			text-align: left;
			display: block;
		}
		.form-group.new-pruefer {
			margin-bottom: 20px;
		}
		td {
			vertical-align: middle !important;
		}
		.direct-order-info{
		    text-align: left;
		    background-color: #8ed1e547;
		    height: 200px;
		    max-height: 200px;
		    overflow: auto;
		}
	</style>
</head>
<body>
	<div class="container">
		<?php 
			if(isset($_GET['error'])){

				switch ($_GET['error']) {
				 	case 1:
				 		$err_msg = "Something went wrong! Could not save the data.";
				 		break;
				 	case 2:
				 		$err_msg = "Imported source already exist in main symptoms or in incomplete source imports.";
				 		break;
				 	
				 	default:
				 		$err_msg = "";
				 		break;
				 } 
		?>	
			<div class="row text-center"><span class="text-danger text-center"><strong><?php echo $err_msg; ?></strong></span></div>
			<div class="spacer"></div>
		<?php } ?>
		<?php
			$unApprovedMasterResult = mysqli_query($db, "SELECT * FROM temp_quelle_import_master");
			$unApprovedMasterCount = mysqli_num_rows($unApprovedMasterResult);
			if( $unApprovedMasterCount > 0){
				while($unApprovedMasterRow = mysqli_fetch_array($unApprovedMasterResult)){
				$unApprovedSymptomResult = mysqli_query($db,"SELECT id FROM temp_quelle_import_test Where need_approval = 1 AND master_id = '".$unApprovedMasterRow['id']."'");
				$unApprovedSymptomCount = mysqli_num_rows($unApprovedSymptomResult);
				if($unApprovedSymptomCount > 0){
		?>
					<div class="row">
						<form id="unclearNotifyForm<?php echo $unApprovedMasterRow['id'] ?>" name="unclearNotifyForm<?php echo $unApprovedMasterRow['id'] ?>" method="POST" action="">
							<div class="alert alert-danger">
								Source imported on <strong><?php echo date('d/m/Y h:i A', strtotime($unApprovedMasterRow['ersteller_datum'])); ?></strong> have <strong><?php echo $unApprovedSymptomCount; ?></strong> unclear symptoms, <a title="Complete this source import" href="<?php echo $baseUrl; ?>?master=<?php echo $unApprovedMasterRow['id']; ?>" class="alert-link">Click Here</a> to complete the import process.
								<input type="hidden" name="deleteing_master_id" id="deleteing_master_id" value="<?php echo $unApprovedMasterRow['id'] ?>">
								<a class="pull-right text-danger" title="Delete this source import" href="javascript:void(0)" onclick="deleteUnclearSourceImport('<?php echo $unApprovedMasterRow['id'] ?>')">
						          	<span class="glyphicon glyphicon-trash"></span>
						        </a>
							</div>
						</form>
					</div>
		<?php
					}
				}
			}
			$showPopup=0;
			if(isset($_GET['master']) AND $_GET['master'] != ""){

				$checkUnapprovedResult = mysqli_query($db, "SELECT id FROM temp_quelle_import_test WHERE need_approval = 1 AND master_id = '".$_GET['master']."'");	
				if(mysqli_num_rows($checkUnapprovedResult) > 0){
					/* If Un Approved data found START */
					$unApprovedResult = mysqli_query($db, "SELECT * FROM temp_quelle_import_test WHERE need_approval = 1 AND is_skipped = 0 AND master_id = '".$_GET['master']."' ORDER BY id ASC LIMIT 1");
					if( mysqli_num_rows($unApprovedResult) > 0){
						$unApprovedRow = mysqli_fetch_assoc($unApprovedResult);

						
						$tagParameter = "";
						if($unApprovedRow['is_pre_defined_tags_approval'] == 1){
							if($unApprovedRow['pruefer_priority'] != 0)
								$tagParameter = "pruefer";
							else if($unApprovedRow['reference_priority'] != 0)
								$tagParameter = "reference";
							else if($unApprovedRow['more_than_one_tag_string_priority'] != 0)
								$tagParameter = "multitag";
						}
						// Checking if it is cleared already in this import
						if($unApprovedRow['is_rechecked'] == 0){
							if($unApprovedRow['full_approval_string_when_hyphen'] != "")
								$sendingApprovalString = $unApprovedRow['full_approval_string_when_hyphen'];
							else
								$sendingApprovalString = $unApprovedRow['approval_string'];
							$checkRtn = isClearedInThisImport($unApprovedRow['id'], $sendingApprovalString, $_GET['master'], $unApprovedRow['is_pre_defined_tags_approval'], $tagParameter);
							if($checkRtn === true)
							{
								echo "<script type='text/javascript'>location.reload();</script>"; 
								exit();
							}
						}

						$showPopup=1;
						$isNoButtonAvailable = 1;
						
						$lowestPriorityValue = 1;
						$noOfQuestion = 0;
						if($unApprovedRow['remedy_priority'] == 0)
							$lowestPriorityValue++;
						else
							$noOfQuestion++;
						if($unApprovedRow['part_of_symptom_priority'] == 0)
							$lowestPriorityValue++;
						else
							$noOfQuestion++;
						if($unApprovedRow['pruefer_priority'] == 0)
							$lowestPriorityValue++;
						else
							$noOfQuestion++;
						if($unApprovedRow['reference_with_no_author_priority'] == 0)
							$lowestPriorityValue++;
						else
							$noOfQuestion++;
						if($unApprovedRow['remedy_with_symptom_priority'] == 0)
							$lowestPriorityValue++;
						else
							$noOfQuestion++;
						if($unApprovedRow['aao_hyphen_priority'] == 0)
							$lowestPriorityValue++;
						else
							$noOfQuestion++;
						if($unApprovedRow['hyphen_pruefer_priority'] == 0)
							$lowestPriorityValue++;
						else
							$noOfQuestion++;
						if($unApprovedRow['hyphen_reference_priority'] == 0)
							$lowestPriorityValue++;
						else
							$noOfQuestion++;
						if($unApprovedRow['more_than_one_tag_string_priority'] == 0)
							$lowestPriorityValue++;
						else
							$noOfQuestion++;
						if($unApprovedRow['reference_priority'] == 0)
							$lowestPriorityValue++;
						else
							$noOfQuestion++;

						// When direct order value is set
						if($unApprovedRow['direct_order_priority'] != 0)
							$lowestPriorityValue = $unApprovedRow['direct_order_priority'];

						// When  symptom edit value is set
						if($unApprovedRow['symptom_edit_priority'] != 0)
							$lowestPriorityValue = $unApprovedRow['symptom_edit_priority'];

						if($unApprovedRow['part_of_symptom_priority'] == $lowestPriorityValue){
							$formAction = "approve-as-part-of-symptom.php";
		      			}else if($unApprovedRow['remedy_priority'] == $lowestPriorityValue){
		      				$formAction = "approve-as-remedy.php";
		      			}else if($unApprovedRow['pruefer_priority'] == $lowestPriorityValue){
		      				$formAction = "approve-as-pruefer.php";
		      			}else if($unApprovedRow['reference_with_no_author_priority'] == $lowestPriorityValue){
		      				$formAction = "approve-as-reference.php";
		      			}else if($unApprovedRow['remedy_with_symptom_priority'] == $lowestPriorityValue){
		      				$formAction = "approve-as-remedy-with-symptom.php";
		      			}else if($unApprovedRow['aao_hyphen_priority'] == $lowestPriorityValue){
		      				$formAction = "approve-aao-hyphen-string.php";
		      			}else if($unApprovedRow['hyphen_pruefer_priority'] == $lowestPriorityValue){
		      				$formAction = "approve-as-hyphen-pruefer-string.php";
		      			}else if($unApprovedRow['hyphen_reference_priority'] == $lowestPriorityValue){
		      				$formAction = "approve-as-hyphen-reference-string.php";
		      			}else if($unApprovedRow['more_than_one_tag_string_priority'] == $lowestPriorityValue){
		      				$formAction = "approve-multi-tag-string.php";
		      			}else if($unApprovedRow['reference_priority'] == $lowestPriorityValue){
		      				$formAction = "approve-as-reference.php";
		      			}else if($unApprovedRow['direct_order_priority'] == $lowestPriorityValue){
		      				$formAction = "direct_order.php";
		      			}else if($unApprovedRow['symptom_edit_priority'] == $lowestPriorityValue){
		      				$formAction = "edit-symptom-text.php";
		      			}
		?>
						<div id="decisionMakingModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
						  	<div class="modal-dialog modal-lg" role="document">
						  		<form name="decisionMakingForm" id="decisionMakingForm" action="<?php echo $formAction; ?>" method="POST" accept-charset="UTF-8">
								    <div class="modal-content">
								      	<div class="modal-header text-center">
								      		<?php 
								      			if(isset($_GET['popup_error']) AND $_GET['popup_error'] != ""){
								      				switch ($_GET['popup_error']) {
								      				 	case '1':
								      				 		$popup_error_msg = "No Direct Order found Or There is something wrong in provided Direct Order.";
								      				 		break;
								      				 	case '2':
								      				 		$popup_error_msg = "It may go wrong or program may messed up this symptom Data. Please correct this symptom manually and import again.";
								      				 		break;
								      				 	case '3':
													 		$popup_error_msg = "Source already exist in main symptoms or in incomplete source imports.";
													 		break;
													 	case '4':
													 		$popup_error_msg = "Source text contain very few characters, Could not update!";
													 		break;
								      				 	case '5':
								      				 		$popup_error_msg = "Something went wrong Could not save the data. Please retry!";
								      				 		break;
								      				 	
								      				 	default:
								      				 		$popup_error_msg = "";
								      				 		break;
								      				} 
								      		?>	
												<span class="text-danger"><strong><?php echo $popup_error_msg; ?></strong></span>
											<?php } ?>
								      		<button type="button" class="close" title="Close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								        	<h4 class="modal-title" id="myModalLabel">Decision Making</h4>
								      	</div>
								      	<div class="modal-body text-center">
								      		<?php if($unApprovedRow['symptom_edit_priority'] != $lowestPriorityValue){ ?>
								      			<a href="javascript:void(0)">Question left: <span class="badge"><?php if($unApprovedRow['direct_order_priority'] == $lowestPriorityValue) { echo 0; }else{ echo ($noOfQuestion == 0) ? 0 : $noOfQuestion-1; } ?></span></a>
								      		<?php } ?>
								      		<?php
								      			if($unApprovedRow['part_of_symptom_priority'] == $lowestPriorityValue){
								      				/* Part Of Symptom checking START */
								      		?>
									      			<h3>Is this part of the symptom?</h3>
									      			<h2 class="text-danger"><?php echo $unApprovedRow['approval_string'] ?></h2>
									      			<div class="spacer"></div>
								      		<?php
								      				/* Part Of Symptom checking END */
								      			}
								      			else if($unApprovedRow['remedy_priority'] == $lowestPriorityValue){
								      				/* Remedy checking START */

								      				// Different logics for dot(.) and Comma(,) or Semicolon(;) START
								      				$isCommaOrSemicolonExist = 0;
								      				$separator = "";
								      				if (mb_strpos($unApprovedRow['approval_string'], ',') !== false) {
														$isCommaOrSemicolonExist = 1;
														$separator = ",";
								      				}
													else if (mb_strpos($unApprovedRow['approval_string'], ';') !== false) {
														$isCommaOrSemicolonExist = 1;
														$separator = ";";
													}
													$approvableStringArr = explode(" ", $unApprovedRow['approval_string']);
													$showSuggestion = 1;
													$remedyApprovalString = $unApprovedRow['approval_string'];
									      			$remedyQuestion = "Is this a Remedy?";
													if($isCommaOrSemicolonExist == 1 AND $separator != ""){
														$explodedValue = explode($separator, $unApprovedRow['approval_string']);
									      				$newTempRemedyArray = array(); 
									      				foreach ($explodedValue as $expKey => $expVal) {
									      					if($expVal == "")
									      						continue;
									      					$newTempRemedyArray[] = $expVal;
									      				}
									      				$expectedRemedyCount = count($newTempRemedyArray);
									      				
									      				if( $expectedRemedyCount > 1){
									      					// $showSuggestion = 0;
									      					$remedyApprovalString = rtrim(implode(",", $explodedValue), ",");
									      					$remedyQuestion = "Are these ".$expectedRemedyCount." Remedies?";
									      				}
									      				else{
									      					$remedyApprovalString = $unApprovedRow['approval_string'];
									      					$remedyQuestion = "Is this a Remedy?";
									      				}

													}else if($isCommaOrSemicolonExist == 0 AND count($approvableStringArr) > 1){

														$explodedValue = explode(".", $unApprovedRow['approval_string']);
									      				$newTempRemedyArray = array(); 
									      				foreach ($explodedValue as $expKey => $expVal) {
									      					if($expVal == "")
									      						continue;
									      					$newTempRemedyArray[] = $expVal;
									      				}
									      				$expectedRemedyCount = count($newTempRemedyArray);
									      				
									      				if( $expectedRemedyCount > 1){
									      					// $showSuggestion = 0;
									      					$remedyApprovalString = rtrim(implode(".,", $explodedValue), ",");
									      					$remedyQuestion = "Are these ".$expectedRemedyCount." Remedies?";
									      				}
									      				else{
									      					$remedyApprovalString = $unApprovedRow['approval_string'];
									      					$remedyQuestion = "Is this a Remedy?";
									      				}

													}
													// Different logics for dot(.) and Comma(,) or Semicolon(;) END
								      				
								      		?>
									      			<h3><?php echo $remedyQuestion; ?></h3>
									      			<?php if($unApprovedRow['is_pre_defined_tags_approval'] == 1){ ?>
							      						<small class="text-danger">(Found in pre define tag <strong>@A</strong>, please check your document in below refered position for better understanding)</small>
							      					<?php }?>
									      			<h2 class="text-danger"><?php echo $remedyApprovalString; ?></h2>
									      			<div class="spacer"></div>
								      		<?php
								      				$remedySuggestionResult = mysqli_query($db, "SELECT * FROM temp_remedy WHERE symptom_id ='".$unApprovedRow['id']."' AND is_new = 0");
													$remedySuggestionCount = mysqli_num_rows($remedySuggestionResult);
													if( $remedySuggestionCount > 0 AND $showSuggestion == 1){
											?>
													<div class="table-responsive">          
													  	<table class="table table-bordered">
														    <thead>
														      	<tr>
															        <th class="text-center">You can select from found similar remedies listed below and press Yes (If it's already there!)</th>
														      	</tr>
														    </thead>
														    <tbody>
														    	<tr>
													      			<td>	
													      			<button title="Reset the radio buttons" class="btn btn-default" type="button" onclick="resetRadio('suggested_remedy[]')">Reset</button>      			
											<?php
																	while($remedySuggestionRow = mysqli_fetch_array($remedySuggestionResult)){
											?>
													      				<div class="radio">
																			<label><input type="checkbox" class="suggested-checkbox" name="suggested_remedy[]" value="<?php echo $remedySuggestionRow['name']; ?>"><?php echo $remedySuggestionRow['name']; ?></label>
																		</div>				
											<?php
																	}
											?>
																	</td>
																</tr>
															</tbody>
									  					</table>
													</div>
													
											<?php
													}
											?>
													<div class="spacer"></div>
													<h5><span>OR</span></h5>
													<div class="row">
														<div class="col-sm-6 col-sm-offset-3 text-left">
															<label>Enter remedies separated by a comma</label>
															<input type="text" name="remedies_comma_separated" id="remedies_comma_separated" class="form-control" placeholder="Comma separated remedies" autocomplete="off">
														</div>
													</div>
													<div class="spacer"></div>
													<div class="row">
														<div class="col-sm-6 col-sm-offset-3 text-center">
															<input type="submit" title="Save the comma separated remedies" class="btn btn-info btn-order" name="comma_separated_remedies_ok" id="comma_separated_remedies_ok" value="Ok">
														</div>
													</div>
													<div class="spacer"></div>
											<?php
													/* Remedy checking END */
								      			}else if($unApprovedRow['pruefer_priority'] == $lowestPriorityValue){
								      				/* Pruefer checking START */
								      				if(isset($_GET['new-pruefer']) AND $_GET['new-pruefer'] == 1)
								      				{
								      					/* Show add new Pruefer popup START */
								      		?>
								      					<h3>Add Pruefer (<span class="text-danger"><?php echo $unApprovedRow['approval_string'] ?></span>)</h3>
								      					<?php if($unApprovedRow['is_pre_defined_tags_approval'] == 1){ ?>
								      						<small class="text-danger">(Found in pre define tag <strong>@P</strong>, please check your document in below refered position for better understanding)</small>
								      					<?php }?>
										      			<div class="spacer"></div>
										      			<div class="row">
										      				<div class="col-sm-2">
										      					<div class="form-group new-pruefer">
																	<label for="titel">Titel</label>
																	<select class="form-control" name="titel" id="titel" autofocus="">
																		<option value="">Titel wählen</option>
																		<option value="Prof.">Prof.</option>
																		<option value="Dr.">Dr.</option>
																		<option value="Mr.">Mr.</option>
																		<option value="Prof. Dr.">Prof. Dr.</option>
																		<option value="Dr. Dr.">Dr. Dr.</option>
																	</select>
																	<span class="error-text"></span>
																</div> 
										      				</div>
										      				<div class="col-sm-5">
										      					<div class="form-group new-pruefer">
																	<label for="vorname">Vorname</label>
																	<input type="text" class="form-control" name="vorname" value="" id="vorname" autocomplete="off">
																	<span class="error-text"></span>
																</div>
										      				</div>
										      				<div class="col-sm-5">
										      					<div class="form-group new-pruefer">
																	<label for="nachname">Nachname*</label>
																	<input type="text" class="form-control" id="nachname" name="nachname" value="" autocomplete="off">
																	<span class="error-text"></span>
																</div>
										      				</div>			
										      			</div>
										      			<div class="row">
										      				<div class="col-sm-6">
										      					<div class="form-group new-pruefer">
																	<label for="suchname">Suchname</label>
																	<input type="text" class="form-control" name="suchname" value="<?php echo (isset($unApprovedRow['approval_string'])) ? $unApprovedRow['approval_string'] : ''; ?>" id="suchname" autocomplete="off">
																	<span class="error-text"></span>
																</div>
										      				</div>
										      				<div class="col-sm-6">
										      					<div class="form-group new-pruefer">
																	<label for="kuerzel">Kürzel (mehrere mit "|" trennen!)</label>
																	<input type="text" class="form-control" name="kuerzel" value="<?php echo (isset($unApprovedRow['approval_string'])) ? $unApprovedRow['approval_string'] : ''; ?>" id="kuerzel" autocomplete="off">
																	<span class="error-text"></span>
																</div>
										      				</div>
										      			</div>
										      			<div class="row">
										      				<div class="col-sm-6">
										      					<div class="form-group new-pruefer">
																	<label for="geburtsjahr">Geburtsjahr/ datum</label>
																	<input type="text" class="form-control hasDatepicker valid" name="geburtsdatum" value="" id="geburtsjahr" data-mask="99/99/9999" aria-invalid="false" autocomplete="off">
																	<span class="error-text"></span>
																</div>
										      				</div>
										      				<div class="col-sm-6">
										      					<div class="form-group new-pruefer">
																	<label for="todesjahr">Todesjahr/ datum</label>
																	<input type="text" class="form-control hasDatepicker valid" name="sterbedatum" value="" id="todesjahr" data-mask="99/99/9999" aria-invalid="false" autocomplete="off">
																	<span class="error-text"></span>
																</div>
										      				</div>
										      			</div>
										      			<div class="row">
										      				<div class="col-sm-12">
										      					<div class="form-group new-pruefer">
																	<label for="kommentar">Kommentar</label>
																	<textarea id="kommentar" name="kommentar" value="" class="form-control texteditor" aria-hidden="true"></textarea>
																	<span class="error-text"></span>
																</div>
										      				</div>
										      			</div>
														<div class="spacer"></div>
								      		<?php
								      					/* Show add new Pruefer popup END */
								      				}else{
								      					/* Asking is it Pruefer popup START */
								      		?>
								      					<h3>Is this a Pruefer?</h3>
								      					<?php if($unApprovedRow['is_pre_defined_tags_approval'] == 1){ ?>
								      						<small class="text-danger">(Found in pre define tag <strong>@P</strong>, please check your document in below refered position for better understanding)</small>
								      					<?php }?>
										      			<h2 class="text-danger"><?php echo $unApprovedRow['approval_string'] ?></h2>
										      			<div class="spacer"></div>
										    <?php
									      				$prueferSuggestionResult = mysqli_query($db, "SELECT pruefer.pruefer_id, pruefer.kuerzel, pruefer.suchname FROM pruefer LEFT JOIN temp_symptom_pruefer ON pruefer.pruefer_id = temp_symptom_pruefer.pruefer_id  WHERE temp_symptom_pruefer.symptom_id ='".$unApprovedRow['id']."' AND temp_symptom_pruefer.is_new = 0");
														$prueferSuggestionCount = mysqli_num_rows($prueferSuggestionResult);
														if( $prueferSuggestionCount > 0){
											?>
														<div class="table-responsive">          
														  	<table class="table table-bordered">
															    <thead>
															      	<tr>
																        <th colspan="3" class="text-center">You can select from found similar pruefer(s) listed below and press Yes (If it's already there!)</th>
															      	</tr>
															    </thead>
															    <tbody>
															    	<tr>
														      			<td colspan="3">	
														      				<button title="Reset the radio button(s)" class="btn btn-default" type="button" onclick="resetRadio('suggested_pruefer')">Reset</button>    
														      			</td>
																	</tr>
																	<tr>
																		<td><strong>Action</strong></td>
																		<td><strong>Suchname</strong></td>
																		<td><strong>Kuerzel (Seperate with "|")</strong></td>
																	</tr>  			
											<?php
																while($prueferSuggestionRow = mysqli_fetch_array($prueferSuggestionResult))
																{
											?>
																	<tr>
																		<td>
													      					<div class="radio">
																				<label><input type="radio" class="suggested-radio" name="suggested_pruefer" value="<?php echo $prueferSuggestionRow['pruefer_id']; ?>"></label>
																			</div>
																		</td>
																		<td><?php echo $prueferSuggestionRow['suchname']; ?></td>
																		<td>
																			<input type="text" class="form-control" name="kuerzel_<?php echo $prueferSuggestionRow['pruefer_id']; ?>" id="kuerzel_<?php echo $prueferSuggestionRow['pruefer_id']; ?>" value="<?php echo $prueferSuggestionRow['kuerzel']; ?>" autocomplete="off" placeholder="Kuerzel (Seperate with '|')">
																		</td>
																	</tr>			
											<?php
																}
											?>
																</tbody>
										  					</table>
														</div>
														<div class="spacer"></div>
									      	<?php
									      				}
								      					/* Asking is it Pruefer popup END */
								      				} 
								      		?>		
								      		<?php
								      				/* Pruefer checking END */
								      			}else if($unApprovedRow['reference_with_no_author_priority'] == $lowestPriorityValue OR $unApprovedRow['reference_priority'] == $lowestPriorityValue){
								      				/* Reference OR Reference With No Author checking START */
								      				if($unApprovedRow['reference_with_no_author_priority'] == $lowestPriorityValue)
								      					$questionText = "Is this a reference with no author?";
								      				else
								      					$questionText = "Is this a new reference?";
								      		?>
								      				<h3><?php echo $questionText; ?></h3>
								      				<?php if($unApprovedRow['is_pre_defined_tags_approval'] == 1){ ?>
							      						<small class="text-danger">(Found in pre define tag <strong>@L</strong>, please check your document in below refered position for better understanding)</small>
							      					<?php }?>
								      				<h2 class="text-danger"><?php echo $unApprovedRow['approval_string'] ?></h2>
								      				<div class="spacer"></div>
								      		<?php
									      			$referenceSuggestionResult = mysqli_query($db, "SELECT reference.reference_id, reference.full_reference, reference.autor, reference.reference FROM reference LEFT JOIN temp_symptom_reference ON reference.reference_id = temp_symptom_reference.reference_id  WHERE temp_symptom_reference.symptom_id ='".$unApprovedRow['id']."' AND temp_symptom_reference.is_new = 0");
													$referenceSuggestionCount = mysqli_num_rows($referenceSuggestionResult);
													if( $referenceSuggestionCount > 0){
											?>
														<div class="table-responsive">          
														  	<table class="table table-bordered">
															    <thead>
															      	<tr>
																        <!-- <th colspan="2" class="text-center">You can select form below listed similar reference(s) and press Yes</th> -->
																        <th colspan="2" class="text-center">You can select from found similar reference(s) listed below and press Yes (If it's already there!)</th>
																        <!-- <th colspan="2" class="text-center">Similar reference(s) already there in the system are listed below:</th> -->
															      	</tr>
															    </thead>
															    <tbody>
															    	<tr>
														      			<td colspan="2">	
														      				<button title="Reset the checkbox(es)" class="btn btn-default" type="button" onclick="resetRadio('suggested_reference')">Reset</button>    
														      			</td>
																	</tr>  			
											<?php
																while($referenceSuggestionRow = mysqli_fetch_array($referenceSuggestionResult)){
											?>
																	<tr>
																		<td>
																			<div class="radio">
																				<label><input title="Check to select this item" type="checkbox" class="suggested-checkbox" name="suggested_reference[]" value="<?php echo $referenceSuggestionRow['reference_id']; ?>"></label>
																			</div>
																		</td>
																		<td><?php echo $referenceSuggestionRow['full_reference']; ?></td>
																	</tr>			
											<?php
																}
											?>
																</tbody>
										  					</table>
														</div>
														<div class="spacer"></div>
									      	<?php
									      			}
								      					
								      		?>	
								      		<?php
								      				/* Reference OR Reference With No Author checking END */
								      			}else if($unApprovedRow['remedy_with_symptom_priority'] == $lowestPriorityValue){
								      				/* Remedy With Symptom checking START */
								      		?>
									      			<h3>Is this a different remedy with symptom text?</h3>
									      			<h2 class="text-danger"><?php echo $unApprovedRow['approval_string'] ?></h2>
									      			<div class="spacer"></div>
								      		<?php
								      				/* Remedy With Symptom checking END */
								      			}else if($unApprovedRow['more_than_one_tag_string_priority'] == $lowestPriorityValue){
								      				/* Multi tag checking START */
								      		?>
									      			<h3>Unknown data found in pre defined tags</h3>
									      			<small class="text-danger">(Please check your document in below refered position for better understanding)</small>
									      			<h2 class="text-danger"><?php echo str_replace("{#^#}", ", ", $unApprovedRow['approval_string']); ?></h2>
									      			<div class="spacer"></div>
								      		<?php
								      				/* Multi tag checking END */
								      			}else if($unApprovedRow['aao_hyphen_priority'] == $lowestPriorityValue){
								      				/* Multiple Unknown data in a. a. O., Hyphen START */
						      				?>
						      						<h3>Multiple unknown data found with a. a. O. or Hyphen( - )</h3>
									      			<small class="text-danger">(Please check your document in below refered position for better understanding)</small>
									      			<h2 class="text-danger"><?php echo str_replace("{#^#}", ", ", $unApprovedRow['approval_string']); ?></h2>
									      			<div class="spacer"></div>
						      				<?php
								      				/* Multiple Unknown data in a. a. O., Hyphen END */
								      			}else if($unApprovedRow['hyphen_pruefer_priority'] == $lowestPriorityValue){
								      				/* Unknown data in a. a. O., Hyphen ask pruefer possiblities START */
								      				if(isset($_GET['new-pruefer']) AND $_GET['new-pruefer'] == 1)
								      				{
								      					/* Show add new Pruefer popup START */
								      					$prePopulatePrueferString = "";
								      					if(isset($unApprovedRow['approval_string']) AND $unApprovedRow['approval_string'] != ""){
								      						$prePopulatePrueferString = str_replace(", a. a. O.", "", $unApprovedRow['approval_string']);
															$prePopulatePrueferString = str_replace(", a.a.O.", "", $prePopulatePrueferString);
															$prePopulatePrueferString = str_replace(",a.a.O.", "", $prePopulatePrueferString);
															$prePopulatePrueferString = str_replace(",a. a. O.", "", $prePopulatePrueferString);
															$prePopulatePrueferString = trim($prePopulatePrueferString);
								      					}
								      					
								      		?>
								      					<h3>Add Pruefer (<span class="text-danger"><?php echo $unApprovedRow['approval_string'] ?></span>)</h3>
								      					<?php if($unApprovedRow['is_pre_defined_tags_approval'] == 1){ ?>
								      						<small class="text-danger">(Found in pre define tag <strong>@P</strong>, please check your document in below refered position for better understanding)</small>
								      					<?php }?>
										      			<div class="spacer"></div>
										      			<div class="row">
										      				<div class="col-sm-2">
										      					<div class="form-group new-pruefer">
																	<label for="titel">Titel</label>
																	<select class="form-control" name="titel" id="titel" autofocus="">
																		<option value="">Titel wählen</option>
																		<option value="Prof.">Prof.</option>
																		<option value="Dr.">Dr.</option>
																		<option value="Mr.">Mr.</option>
																		<option value="Prof. Dr.">Prof. Dr.</option>
																		<option value="Dr. Dr.">Dr. Dr.</option>
																	</select>
																	<span class="error-text"></span>
																</div> 
										      				</div>
										      				<div class="col-sm-5">
										      					<div class="form-group new-pruefer">
																	<label for="vorname">Vorname</label>
																	<input type="text" class="form-control" name="vorname" value="" id="vorname" autocomplete="off">
																	<span class="error-text"></span>
																</div>
										      				</div>
										      				<div class="col-sm-5">
										      					<div class="form-group new-pruefer">
																	<label for="nachname">Nachname*</label>
																	<input type="text" class="form-control" id="nachname" name="nachname" value="" autocomplete="off">
																	<span class="error-text"></span>
																</div>
										      				</div>			
										      			</div>
										      			<div class="row">
										      				<div class="col-sm-6">
										      					<div class="form-group new-pruefer">
																	<label for="suchname">Suchname</label>
																	<input type="text" class="form-control" name="suchname" value="<?php echo (isset($prePopulatePrueferString)) ? $prePopulatePrueferString : ''; ?>" id="suchname" autocomplete="off">
																	<span class="error-text"></span>
																</div>
										      				</div>
										      				<div class="col-sm-6">
										      					<div class="form-group new-pruefer">
																	<label for="kuerzel">Kürzel (mehrere mit "|" trennen!)</label>
																	<input type="text" class="form-control" name="kuerzel" value="<?php echo (isset($prePopulatePrueferString)) ? $prePopulatePrueferString : ''; ?>" id="kuerzel" autocomplete="off">
																	<span class="error-text"></span>
																</div>
										      				</div>
										      			</div>
										      			<div class="row">
										      				<div class="col-sm-6">
										      					<div class="form-group new-pruefer">
																	<label for="geburtsjahr">Geburtsjahr/ datum</label>
																	<input type="text" class="form-control hasDatepicker valid" name="geburtsdatum" value="" id="geburtsjahr" data-mask="99/99/9999" aria-invalid="false" autocomplete="off">
																	<span class="error-text"></span>
																</div>
										      				</div>
										      				<div class="col-sm-6">
										      					<div class="form-group new-pruefer">
																	<label for="todesjahr">Todesjahr/ datum</label>
																	<input type="text" class="form-control hasDatepicker valid" name="sterbedatum" value="" id="todesjahr" data-mask="99/99/9999" aria-invalid="false" autocomplete="off">
																	<span class="error-text"></span>
																</div>
										      				</div>
										      			</div>
										      			<div class="row">
										      				<div class="col-sm-12">
										      					<div class="form-group new-pruefer">
																	<label for="kommentar">Kommentar</label>
																	<textarea id="kommentar" name="kommentar" value="" class="form-control texteditor" aria-hidden="true"></textarea>
																	<span class="error-text"></span>
																</div>
										      				</div>
										      			</div>
														<div class="spacer"></div>
											<?php
								      					/* Show add new Pruefer popup END */
								      				}else{
								      					/* Asking is it Pruefer popup START */
								      		?>
								      					<h3>Is this a Pruefer?</h3>
								      					<?php if($unApprovedRow['is_pre_defined_tags_approval'] == 1){ ?>
								      						<small class="text-danger">(Found in pre define tag <strong>@P</strong>, please check your document in below refered position for better understanding)</small>
								      					<?php }?>
										      			<h2 class="text-danger"><?php echo $unApprovedRow['approval_string'] ?></h2>
										      			<div class="spacer"></div>
										    <?php
									      				$prueferSuggestionResult = mysqli_query($db, "SELECT pruefer.pruefer_id, pruefer.kuerzel, pruefer.suchname FROM pruefer LEFT JOIN temp_symptom_pruefer ON pruefer.pruefer_id = temp_symptom_pruefer.pruefer_id  WHERE temp_symptom_pruefer.symptom_id ='".$unApprovedRow['id']."' AND temp_symptom_pruefer.is_new = 0 AND temp_symptom_pruefer.is_one_unknown_element_in_hyphen = 1");
														$prueferSuggestionCount = mysqli_num_rows($prueferSuggestionResult);
														if( $prueferSuggestionCount > 0){
											?>
														<div class="table-responsive">          
														  	<table class="table table-bordered">
															    <thead>
															      	<tr>
																        <th colspan="3" class="text-center">You can select from found similar pruefer(s) listed below and press Yes (If it's already there!)</th>
															      	</tr>
															    </thead>
															    <tbody>
															    	<tr>
														      			<td colspan="3">	
														      				<button title="Reset the radio button(s)" class="btn btn-default" type="button" onclick="resetRadio('suggested_pruefer')">Reset</button>    
														      			</td>
																	</tr>
																	<tr>
																		<td><strong>Action</strong></td>
																		<td><strong>Suchname</strong></td>
																		<td><strong>Kuerzel (Seperate with "|")</strong></td>
																	</tr>  			
											<?php
																while($prueferSuggestionRow = mysqli_fetch_array($prueferSuggestionResult))
																{
											?>
																	<tr>
																		<td>
													      					<div class="radio">
																				<label><input type="radio" class="suggested-radio" name="suggested_pruefer" value="<?php echo $prueferSuggestionRow['pruefer_id']; ?>"></label>
																			</div>
																		</td>
																		<td><?php echo $prueferSuggestionRow['suchname']; ?></td>
																		<td>
																			<input type="text" class="form-control" name="kuerzel_<?php echo $prueferSuggestionRow['pruefer_id']; ?>" id="kuerzel_<?php echo $prueferSuggestionRow['pruefer_id']; ?>" value="<?php echo $prueferSuggestionRow['kuerzel']; ?>" autocomplete="off" placeholder="Kuerzel (Seperate with '|')">
																		</td>
																	</tr>			
											<?php
																}
											?>
																</tbody>
										  					</table>
														</div>
														<div class="spacer"></div>
									      	<?php
									      				}
								      					/* Asking is it Pruefer popup END */
								      				} 
								      		?>
								      		<?php
								      				/* Unknown data in a. a. O., Hyphen ask pruefer possiblities END */
								      			}else if($unApprovedRow['hyphen_reference_priority'] == $lowestPriorityValue){
								      				/* Unknown data in a. a. O., Hyphen ask reference possiblities START */
								      		?>
								      				<h3>Is this a new reference?</h3>
								      				<?php if($unApprovedRow['is_pre_defined_tags_approval'] == 1){ ?>
							      						<small class="text-danger">(Found in pre define tag <strong>@L</strong>, please check your document in below refered position for better understanding)</small>
							      					<?php }?>
								      				<h2 class="text-danger"><?php echo $unApprovedRow['approval_string'] ?></h2>
								      				<div class="spacer"></div>
								      		<?php
									      			$referenceSuggestionResult = mysqli_query($db, "SELECT reference.reference_id, reference.full_reference, reference.autor, reference.reference FROM reference LEFT JOIN temp_symptom_reference ON reference.reference_id = temp_symptom_reference.reference_id  WHERE temp_symptom_reference.symptom_id ='".$unApprovedRow['id']."' AND temp_symptom_reference.is_new = 0 AND temp_symptom_reference.is_one_unknown_element_in_hyphen = 1");
													$referenceSuggestionCount = mysqli_num_rows($referenceSuggestionResult);
													if( $referenceSuggestionCount > 0){
											?>
														<div class="table-responsive">          
														  	<table class="table table-bordered">
															    <thead>
															      	<tr>
																        <th colspan="2" class="text-center">You can select from found similar reference(s) listed below and press Yes (If it's already there!)</th>
															      	</tr>
															    </thead>
															    <tbody>
															    	<tr>
														      			<td colspan="2">	
														      				<button title="Reset the checkbox(es)" class="btn btn-default" type="button" onclick="resetRadio('suggested_reference')">Reset</button>    
														      			</td>
																	</tr>  			
											<?php
																while($referenceSuggestionRow = mysqli_fetch_array($referenceSuggestionResult)){
											?>
																	<tr>
																		<td>
																			<div class="radio">
																				<label><input title="Check to select this item" type="checkbox" class="suggested-checkbox" name="suggested_reference[]" value="<?php echo $referenceSuggestionRow['reference_id']; ?>"></label>
																			</div>
																		</td>
																		<td><?php echo $referenceSuggestionRow['full_reference']; ?></td>
																	</tr>			
											<?php
																}
											?>
																</tbody>
										  					</table>
														</div>
														<div class="spacer"></div>
									      	<?php
									      			}
								      					
								      		?>
								      		<?php
								      				/* Unknown data in a. a. O., Hyphen ask reference possiblities END */
								      			}else if($unApprovedRow['direct_order_priority'] == $lowestPriorityValue){
								      				/* Direct order checking START */
								      		?>
									      			<h3>Direct Order for (<span class="text-danger"><?php echo str_replace("{#^#}", ", ", $unApprovedRow['approval_string']); ?></span>)</h3>
									      			<?php if($unApprovedRow['is_pre_defined_tags_approval'] == 1){ ?>
							      						<small class="text-danger">(Found in pre define tags, please check your document in below refered position for better understanding)</small>
							      					<?php }?>
							      					<div class="spacer"></div>
							      					<!-- <div class="row"> -->
							      						<div class="well direct-order-info">
										                	<p>Direct order tags list:</p>
										                  	<ul>
																<li>@P:Prüfer</li>
																<li>@A:Remedy</li>
																<li>@AT:Similar remedy, Similar symptom text (e.g. Opi., during the day)</li>
																<li>@TA:Similar symptom text, Similar remedy (e.g. small boils in crops, Sulph.)</li>
																<li>@L:Reference(Literaturquelle)</li>
																<li>@L:No Author, Aepli sen. in Hufeland Journ. YYV. (when there is no author reference)</li>
																<li>@U:Unclear(Unklarheit)</li>
																<li>@F:Footnote(Fußnote)</li>
																<li>@T:Text/Symptom text</li>
																<li>@Z:Time</li>
																<li>@K:Chapter (Kapitel)</li>
																<li>@UK:Subchapter</li>
																<li>@UUK:Sub Subchapter</li>
																<li>@S:Page</li>
																<li>@N:Symptom-Nr.</li>
																<li>@C:Comment(Kommentar)</li>
																<li>@V:Hint(Verweiss)</li>
																<li>@G:Grading/Classification(Graduierung)</li>
															</ul>
										                </div>
							      					<!-- </div> -->
									      			<div class="spacer"></div>
									      			<textarea id="direct_order" name="direct_order" class="form-control" placeholder="Direct order" rows="7"></textarea>
									      			<div class="spacer"></div>
								      		<?php 
								      				/* Direct order checking END */
								      			}else if($unApprovedRow['symptom_edit_priority'] == $lowestPriorityValue){
								      				/* Edit Symptom STRAT */
						      				?>
						      						<h3>Edit Symptom</h3>
						      						<div class="spacer"></div>
									      			<textarea id="symptom_text" name="symptom_text" class="texteditor" placeholder="Symptom text" rows="5"><?php echo $unApprovedRow['Beschreibung']; ?></textarea>
									      			<div class="spacer"></div>
									      			<h4 class="text-left">Comment</h4>
									      			<textarea id="symptom_edit_comment" name="symptom_edit_comment" maxlength="255" class="form-control" placeholder="Comment" rows="4"><?php echo $unApprovedRow['symptom_edit_comment']; ?></textarea>
									      			<div class="spacer"></div>
						      				<?php
								      				/* Edit Symptom END */
								      			}
								      		?>

								      		<div class="table-responsive">
								      			<h4 class="text-left"><u>Document reference</u></h4>          
											  	<table class="table table-bordered">
												    <thead>
												      	<tr>
													        <th class="text-center">Symptom No</th>
													        <th class="text-center">Page (@S)</th>
													        <th class="text-center">Source</th>
													        <th class="text-center">Edit</th>
												      	</tr>
												    </thead>
												    <tbody>
										      			<tr>
											      			<td><?=$unApprovedRow['Symptomnummer']?></td>
															<td>
																<?php
																	if($unApprovedRow['SeiteOriginalVon'] == $unApprovedRow['SeiteOriginalBis'])
																		echo $unApprovedRow['SeiteOriginalVon'];
																	else
																		echo $unApprovedRow['SeiteOriginalVon']."-".$unApprovedRow['SeiteOriginalBis']
																?>
															</td>
															<td><?=$unApprovedRow['Beschreibung']?></td>
															<td><button title="Edit symptom" type="submit" name="edit_symptom" id="edit_symptom" value="Edit"><i class="fas fa-pencil-alt"></i></button></td>
														</tr>
													</tbody>
							  					</table>
											</div>
											<span id="form-msg"></span>
								      	</div>
								      	<div class="modal-footer">
								      		<input type="hidden" name="symptom_id" id="symptom_id" value="<?php echo $unApprovedRow['id']; ?>">
								      		<input type="hidden" name="master_id" id="master_id" value="<?php echo $unApprovedRow['master_id']; ?>">
								      		<?php if($unApprovedRow['reference_with_no_author_priority'] == $lowestPriorityValue){ ?>
								      			<input type="hidden" name="approval_string" id="approval_string" value="<?php echo "No Author, ".trim($unApprovedRow['approval_string']); ?>">
								      		<?php }else{ ?>
								      			<input type="hidden" name="approval_string" id="approval_string" value="<?php echo $unApprovedRow['approval_string']; ?>">
								      		<?php } ?>
								      		<input type="hidden" name="full_approval_string_when_hyphen" id="full_approval_string_when_hyphen" value="<?php echo (isset($unApprovedRow['full_approval_string_when_hyphen']) AND $unApprovedRow['full_approval_string_when_hyphen'] != "") ? $unApprovedRow['full_approval_string_when_hyphen'] : ''; ?>">
								      		<input type="hidden" name="full_approval_string_when_hyphen_unchanged" id="full_approval_string_when_hyphen_unchanged" value="<?php echo (isset($unApprovedRow['full_approval_string_when_hyphen_unchanged']) AND $unApprovedRow['full_approval_string_when_hyphen_unchanged'] != "") ? $unApprovedRow['full_approval_string_when_hyphen_unchanged'] : ''; ?>">
								      		<input type="hidden" name="is_pre_defined_tags_approval" id="is_pre_defined_tags_approval" value="<?php echo $unApprovedRow['is_pre_defined_tags_approval'] ?>">
								        	<!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
								        	<!-- <input type="submit" title="Back to previous symptom" class="btn btn-default" name="back_to_previous" id="back_to_previous" value="Back to previous"> -->
								        	<?php if($unApprovedRow['symptom_edit_priority'] == $lowestPriorityValue) { ?>
								        		<input title="Save" type="submit" class="btn btn-primary" name="symptom_edit_save" id="symptom_edit_save" value="Save">
								        		<input  title="Cancel" type="submit" class="btn btn-default" name="symptom_edit_cancel" id="symptom_edit_cancel" value="Cancel">
								        	<?php }else{ ?>
								        		<?php if($unApprovedRow['direct_order_priority'] == $lowestPriorityValue) { ?>
									        		<input type="submit" class="btn btn-primary" name="submit" id="submit" value="Submit">
									        	<?php }else{ ?>
									        		<?php if(isset($_GET['new-pruefer']) AND $_GET['new-pruefer'] == 1){ ?>
									        			<input type="hidden" name="add_pruefer" id="add_pruefer" value="No">
									        			<button class="btn btn-primary" type="button" onclick="addNewPruefer()">Save</button>
									        		<?php }else{ ?>
									        			<?php if($unApprovedRow['more_than_one_tag_string_priority'] != $lowestPriorityValue AND $unApprovedRow['aao_hyphen_priority'] != $lowestPriorityValue){ ?>
									        				<input type="submit" title="Yes" class="btn btn-primary" name="yes" id="yes" value="Yes">
									        			<?php } ?>
											    		<?php if($lowestPriorityValue != 10){ ?>
											    			<input type="submit" title="No" class="btn btn-danger" name="no" id="no" value="No">
											    		<?php } ?>
									        		<?php } ?>
									        		<input type="submit" title="Direct Order" class="btn btn-info" name="do" id="do" value="DO">
									    		<?php } ?>
									    		<input type="submit" title="Skip for now" class="btn btn-warning" name="later" id="later" value="Later">
										    	<input type="submit" title="Reset current symptom" class="btn btn-default" name="reset_current" id="reset_current" value="Reset">
								        	<?php } ?>
								      	</div>
								    </div>
							    </form>
						  	</div>
						</div>
		<?php
					}
					/* If Un Approved data found END */
				}
				else
				{
					/* If Not Found any Un Approved data START */

					/* Inserting Temp table data to Main tables START */
					$masterResult = mysqli_query($db, "SELECT * FROM temp_quelle_import_master where id = '".$_GET['master']."'");
					if(mysqli_num_rows($masterResult) > 0){
						$masterData = mysqli_fetch_assoc($masterResult); 
						$isAnyError = 0;
						try{
							// First of all, let's begin a transaction
							$db->begin_transaction();

							$masterData['import_rule'] = mysqli_real_escape_string($db, $masterData['import_rule']);
							$masterMainInsertQuery="INSERT INTO quelle_import_master (import_rule, ersteller_datum) VALUES ('".$masterData['import_rule']."', '".$date."')";
				            $db->query($masterMainInsertQuery);
				            $mainMasterId = mysqli_insert_id($db);

							// If we arrive here, it means that no exception was thrown
						    // i.e. no query has failed, and we can commit the transaction
						    $db->commit();
						}catch (Exception $e) {
						    // An exception has been thrown
						    // We must rollback the transaction
						    $db->rollback();
						    $isAnyError = 1;
						}

						if($isAnyError == 0){
							try{
								// First of all, let's begin a transaction
								$db->begin_transaction();

								/* Insert Symptoms START */
					            $symptomResult = mysqli_query($db, "SELECT * FROM temp_quelle_import_test where master_id = '".$_GET['master']."'");
								if(mysqli_num_rows($symptomResult) > 0){
									while($symptomData = mysqli_fetch_array($symptomResult)){
										$symptomData['Symptomnummer'] = mysqli_real_escape_string($db, $symptomData['Symptomnummer']);
										$symptomData['SeiteOriginalVon'] = mysqli_real_escape_string($db, $symptomData['SeiteOriginalVon']);
										$symptomData['SeiteOriginalBis'] = mysqli_real_escape_string($db, $symptomData['SeiteOriginalBis']);
										$symptomData['Beschreibung'] = mysqli_real_escape_string($db, $symptomData['Beschreibung']);
										$symptomData['BeschreibungOriginal'] = mysqli_real_escape_string($db, $symptomData['BeschreibungOriginal']);
										$symptomData['BeschreibungPlain'] = mysqli_real_escape_string($db, $symptomData['BeschreibungPlain']);
										$symptomData['bracketedString'] = mysqli_real_escape_string($db, $symptomData['bracketedString']);
										$symptomData['timeString'] = mysqli_real_escape_string($db, $symptomData['timeString']);
										$symptomData['Fussnote'] = mysqli_real_escape_string($db, $symptomData['Fussnote']);
										$symptomData['EntnommenAus'] = mysqli_real_escape_string($db, $symptomData['EntnommenAus']);
										$symptomData['Verweiss'] = mysqli_real_escape_string($db, $symptomData['Verweiss']);
										$symptomData['Graduierung'] = mysqli_real_escape_string($db, $symptomData['Graduierung']);
										$symptomData['BereichID'] = mysqli_real_escape_string($db, $symptomData['BereichID']);
										$symptomData['Kommentar'] = mysqli_real_escape_string($db, $symptomData['Kommentar']);
										$symptomData['Unklarheiten'] = mysqli_real_escape_string($db, $symptomData['Unklarheiten']);
										$symptomData['Remedy'] = mysqli_real_escape_string($db, $symptomData['Remedy']);
										$symptomData['symptom_of_different_remedy'] = mysqli_real_escape_string($db, $symptomData['symptom_of_different_remedy']);
										$symptomData['symptom_edit_comment'] = mysqli_real_escape_string($db, $symptomData['symptom_edit_comment']);
										$mainSymptomInsertQuery="INSERT INTO quelle_import_test (master_id, Symptomnummer, SeiteOriginalVon, SeiteOriginalBis, Beschreibung, BeschreibungOriginal, BeschreibungPlain, bracketedString, timeString, Fussnote, EntnommenAus, Verweiss, Graduierung, BereichID, Kommentar, Unklarheiten, Remedy, symptom_of_different_remedy, symptom_edit_comment) VALUES (".$mainMasterId.", ".$symptomData['Symptomnummer'].",'".$symptomData['SeiteOriginalVon']."','".$symptomData['SeiteOriginalBis']."','".$symptomData['Beschreibung']."','".$symptomData['BeschreibungOriginal']."','".$symptomData['BeschreibungPlain']."','".$symptomData['bracketedString']."','".$symptomData['timeString']."','".$symptomData['Fussnote']."', '".$symptomData['EntnommenAus']."', '".$symptomData['Verweiss']."', '".$symptomData['Graduierung']."', '".$symptomData['BereichID']."', '".$symptomData['Kommentar']."', '".$symptomData['Unklarheiten']."', '".$symptomData['Remedy']."', '".$symptomData['symptom_of_different_remedy']."', NULLIF('".$symptomData['symptom_edit_comment']."', ''))";
								
							            $db->query($mainSymptomInsertQuery);
							            $mainSymtomId = mysqli_insert_id($db);

							            /* Insert Symptom_pruefer relation START */
							            $symptomPrueferResult = mysqli_query($db, "SELECT symptom_id, pruefer_id, is_new FROM temp_symptom_pruefer where symptom_id = '".$symptomData['id']."'");
										if(mysqli_num_rows($symptomPrueferResult) > 0){
											while($symptomPrueferData = mysqli_fetch_array($symptomPrueferResult)){
												$mainSymptomPrueferInsertQuery = "INSERT INTO symptom_pruefer (symptom_id, pruefer_id, ersteller_datum) VALUES ('".$mainSymtomId."', '".$symptomPrueferData['pruefer_id']."', '".$date."')";
								            	$db->query($mainSymptomPrueferInsertQuery);
											}
										}
										/* Insert Symptom_pruefer relation END */

										/* Insert Reference relation START */
										$symptomReferenceResult = mysqli_query($db, "SELECT symptom_id, reference_id, is_new FROM temp_symptom_reference where symptom_id = '".$symptomData['id']."'");
										if(mysqli_num_rows($symptomReferenceResult) > 0){
											while($symptomReferenceData = mysqli_fetch_array($symptomReferenceResult)){
												$mainSymptomReferenceInsertQuery = "INSERT INTO symptom_reference (symptom_id, reference_id, ersteller_datum) VALUES ('".$mainSymtomId."', '".$symptomReferenceData['reference_id']."', '".$date."')";
								            	$db->query($mainSymptomReferenceInsertQuery);
											}
										}
										/* Insert Reference relation END */

										/* Insert temp_remedy to main remedy table START */
										
										/* Insert temp_remedy to main remedy table END */
									}
								}
					            /* Insert Symptoms END */

								// If we arrive here, it means that no exception was thrown
							    // i.e. no query has failed, and we can commit the transaction
							    $db->commit();
							}catch (Exception $e) {
							    // An exception has been thrown
							    // We must rollback the transaction
							    $db->rollback();
							    $isAnyError = 1;
							}
						}

						if($isAnyError == 0){
							/* Delete Temp table data START */
							deleteSourceImportTempData($_GET['master']);
							/* Delete Temp table data END */
						}       
					}
					/* Inserting Temp table data to Main tables END */
					
					/* If Not Found any Un Approved data END */
				}

			}
			
		?>
		<form action="" method="POST">
			<div class="form-group Text_form_group row">
				<label class="control-label">Select Import Setting<span class="required">*</span></label>
			   	<select class="form-control" name="settings" id="settings">
			   		<option value="">Select</option>
			   		<option value="default_setting">Default Setting [Source: Bold In Original: Double spaced]</option>
			   		<option value="setting_2">Setting 2 [Source: Colored and non colored combiniations In Original: Adding pipes(|) in appropriate symptoms]</option>
			   	</select>	
			   	<p class="text-danger"><?php if(isset($_GET['rule_error'])){ echo 'Please Select a import rule'; } ?></p>
			</div>
			<div class="form-group Text_form_group row">
				<label class="control-label">Text Editor<span class="required">*</span></label>
			   	<textarea id="symptomtext" name="symptomtext" class="texteditor" aria-hidden="true"></textarea>	
			</div>
			<div class="form-group text-center">
				<input type="submit" name="submit" class="btn btn-success" value="Submit">
				<!-- <input type="button" onclick="chck()" name="submit" class="btn btn-success" value="Submit"> -->
			</div>
		</form>
	</div>

	<div class="container-fluid">
		<h2>Submited Symptoms Table</h2>      
		<form action="" method="POST">
			<input type="submit" class="btn btn-danger" name="delete" value="Delete All"><br> 
		</form> 
		<div class="spacer"></div>      
		<div class="">          
		  	<table class="table table-bordered">
			    <thead>
			      	<tr>
				        <th>Symptom No (@N)</th>
				        <th>Page (@S)</th>
				        <th>Source</th>
				        <th>Original</th>
				        <th>Bracketed part</th>
				        <th>Time (@Z)</th>
				        <th>Footer (@F)</th>
				        <th>Prüfer (@P)</th>
				        <th>Reference (@L)</th>
				        <th>Remedy(@A)</th>
				        <th>Symptom Of Different Remedy(@AT/@TA)</th>
				        <th>Symptom edit comment</th>
				        <th>Hint (@V)</th>
				        <th>Graduation (@G)</th>
				        <th>Chapter (@K)</th>
				        <th>Kommentar (@C)</th>
				        <th>Unklarheiten (@U)</th>
			      	</tr>
			    </thead>
			    <tbody>
			    	<?php  
						$result = mysqli_query($db,"SELECT * FROM quelle_import_test");
						while($row = mysqli_fetch_array($result)){   
							?>
							<tr>
								<td><?=$row['Symptomnummer']?></td>
								<td>
									<?php
										if($row['SeiteOriginalVon'] == $row['SeiteOriginalBis'])
											echo $row['SeiteOriginalVon'];
										else
											echo $row['SeiteOriginalVon']."-".$row['SeiteOriginalBis']
									?>
								</td>
								<td><?=$row['Beschreibung']?></td>
								<td><?=$row['BeschreibungOriginal']?></td>
								<td><?=$row['bracketedString']?></td>
								<td><?=$row['timeString']?></td>
								<td><?=$row['Fussnote']?></td>
								<td>
									<?php
										$pruStr = "";
										$prueferResult = mysqli_query($db,"SELECT pruefer.pruefer_id, pruefer.suchname, pruefer.vorname, pruefer.nachname FROM symptom_pruefer JOIN pruefer ON symptom_pruefer.pruefer_id	= pruefer.pruefer_id WHERE symptom_pruefer.symptom_id = '".$row['id']."'");
										while($prueferRow = mysqli_fetch_array($prueferResult)){
											if($prueferRow['suchname'] != "")
												$pruStr .= $prueferRow['suchname'].", ";
											else
												$pruStr .= $prueferRow['vorname']." ".$prueferRow['nachname'].", ";
										}
										$pruStr =rtrim($pruStr, ", ");
										echo $pruStr;
									?>
								</td>
								<td><?=$row['EntnommenAus']?></td>
								<td><?=$row['Remedy']?></td>
								<td><?=($row['symptom_of_different_remedy'] != "" AND $row['symptom_of_different_remedy'] != "null") ? $row['symptom_of_different_remedy'] : ""?></td>
								<td><?=($row['symptom_edit_comment'] != "" AND $row['symptom_edit_comment'] != "null") ? $row['symptom_edit_comment'] : ""?></td>
								<td><?=$row['Verweiss']?></td>
								<td><?=$row['Graduierung']?></td>
								<td><?=$row['BereichID']?></td>
								<td><?=$row['Kommentar']?></td>
								<td><?=$row['Unklarheiten']?></td>
							</tr>
							<?php
						}
			    	?>
			    </tbody>
		  	</table>
		</div>
	</div>
	<script type="text/javascript" src="plugins/jquery/jquery/jquery-3.3.1.js"></script>
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script type="text/javascript" src="plugins/tinymce/jquery.tinymce.min.js"></script>
	<script type="text/javascript" src="plugins/tinymce/jquery.tinymce.config.js"></script>
	<script type="text/javascript" src="plugins/tinymce/tinymce.min.js"></script>
	<!-- <script type="text/javascript" src="plugins/tinymce/datepicker-de.js"></script> -->

	<!-- <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=f4v6lvpu9vq7p1uo9zat0rd1vbspzp9qs46g4zucb9vdjs53"></script> -->
	<script type="text/javascript">
		function chck(){
			var content =  tinyMCE.get('symptomtext');
			var c=content.getContent();
			console.log(c);
			alert(c);
		}

		function resetRadio(name){
		    $(".suggested-checkbox").prop("checked", false);
		    $(".suggested-radio").prop("checked", false);
		    $('.btn-order').removeAttr('disabled');

		    // $("input:radio[name='" + name + "']").each(function (i) {
		    //     var $this = $(this);
		    //     $this.prop("checked", false);
		    // });
		    return false;
		}

		$('.suggested-checkbox').click(function(){
			if($('.suggested-checkbox:checkbox:checked').length > 0)
				$('.btn-order').attr('disabled', 'disabled');
			else
				$('.btn-order').removeAttr('disabled');
		});

		function addNewPruefer(){
			var nachname = $("#nachname").val();
			var error_count = 0;

			if(nachname == ""){
				$("#nachname").addClass('text-danger');
				$("#nachname").next().html('Nachname is mandatory');
				$("#nachname").next().addClass('text-danger');
				error_count++;
			}else{
				$("#nachname").removeClass('text-danger');
				$("#nachname").next().html('');
				$("#nachname").next().removeClass('text-danger');
			}

			if(error_count == 0){
				$("#form-msg").removeClass("text-danger");
				$("#form-msg").html("");
				$("#add_pruefer").val("Yes");
				$("#decisionMakingForm").submit();
			}else{
				$("#form-msg").addClass("text-danger");
				$("#form-msg").html("Please correct all errors");
				$("#add_pruefer").val("No");
				return false;
			}
		}

		function deleteUnclearSourceImport(master_id){
			$("#unclearNotifyForm"+master_id).submit();
		}

		$('#decisionMakingModal').on('hidden.bs.modal', function () {
		    window.location.replace("<?php echo $baseUrl; ?>");
		})
	</script>
	<?php
		if($showPopup == 1){ 
	?>
		<script type="text/javascript">
			$(".bs-example-modal-lg").modal('show');
		</script>
	<?php
		} 
	?>
</body>
</html>
<?php
	ob_end_flush();
?>