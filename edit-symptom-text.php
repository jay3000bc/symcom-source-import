<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'config.php';
$date = date("Y-m-d H:i:s"); 
include 'functions.php';

/*
* Error meanings
*
* popup_error = 3
* Meaning = Provided source text already exist in the main symptoms table or temp symptom table.
* Message = Source already exist in main symptoms or in incomplete source imports.
*
* popup_error = 4
* Meaning = Provided source text contain very few character to update.
* Message = Source text contain very few characters, Could not update!
*
* popup_error = 5
* Meaning = MySQl Transacation error
* Message = Something went wrong Could not save the data. Please retry! 
*
*/

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

if(isset($_POST['symptom_edit_save']) AND $_POST['symptom_edit_save'] == "Save"){
	try {
	    // First of all, let's begin a transaction
	    $db->begin_transaction();

	    /* Applying program logic in the string STRAT */
	    $parameterString = "";
	    if(isset($_POST['symptom_text']) AND $_POST['symptom_text'] != ""){

	    	$Beschreibung = ""; 
	    	$BeschreibungOriginal = ""; 
	    	$BeschreibungPlain = ""; 
	    	$bracketedString = ""; 
	    	$lastBracketedString = ""; 
	    	$timeString = ""; 
	    	$errorStatus = 0;

    		$line = str_replace ( '</em><em>', '', $_POST['symptom_text'] );
    		$line = str_replace ( array (
				"\r",
				"\t" 
			), '', $line );
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
			$cleanline = trim ( str_replace ( '&nbsp;', ' ', htmlentities(strip_tags ( $line )) ) );
			$cleanline = html_entity_decode($cleanline);

			// Leerzeile
			if (empty ( $cleanline )) {
				$errorStatus = 4;
				//continue;
			}
			
			if (mb_strlen ( $cleanline ) < 3) { //added
				$errorStatus = 4;
				//continue;
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
				$checkSymptomTempResult = mysqli_query($db, "SELECT id FROM temp_quelle_import_test where BeschreibungPlain = '".$BeschreibungPlain."' AND id != '".$_POST['symptom_id']."'");
				if(mysqli_num_rows($checkSymptomTempResult) > 0){
					$isSymptomAlreadyExist = 1;
				}

				if($isSymptomAlreadyExist == 1){
					$errorStatus = 3;
					// continue;
				}
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

				/* In this else case if the bracketed part texts is not null than examining its possibilities START */
				if($errorStatus == 0){
					if($bracketedString != ""){
						$bracketedDataArry = explode('{#^#} ', $bracketedString);
						if(count($bracketedDataArry) > 1)
							$lastBracketedString = trim(array_shift($bracketedDataArry));
						else
							$lastBracketedString = trim($bracketedDataArry[0]);
					}
					$approvableString = ( isset($lastBracketedString) AND $lastBracketedString != "" ) ? $lastBracketedString : null;
					if($approvableString != ""){
						$ruleResult = ruleReimplementation($_POST['symptom_id'], $approvableString, $_POST['master_id'], 0, null);
					}

					// replacing the delimiter {#^#} with comma in bracketedString because otherwise it will there in DB and display table
					$bracketedString = str_replace("{#^#}", ", ", $bracketedString);
					
					$data['Beschreibung']=mysqli_real_escape_string($db, $Beschreibung);
					$data['BeschreibungOriginal']=mysqli_real_escape_string($db, $BeschreibungOriginal);
					$data['BeschreibungPlain']=mysqli_real_escape_string($db, $BeschreibungPlain);
					$data['bracketedString']=mysqli_real_escape_string($db, $bracketedString);
					$data['timeString']=mysqli_real_escape_string($db, $timeString);
					$data['symptom_edit_comment'] = (isset($_POST['symptom_edit_comment']) AND $_POST['symptom_edit_comment'] != "") ? mysqli_real_escape_string($db, $_POST['symptom_edit_comment']) : null;
					
					if($approvableString != ""){
						$symptomUpdateQuery="UPDATE temp_quelle_import_test SET Beschreibung = '".$data['Beschreibung']."', BeschreibungOriginal = '".$data['BeschreibungOriginal']."', BeschreibungPlain = '".$data['BeschreibungPlain']."', bracketedString = '".$data['bracketedString']."', timeString = '".$data['timeString']."', approval_string = NULLIF('".$approvableString."', ''), symptom_edit_comment = '".$data['symptom_edit_comment']."', stand = '".$date."', symptom_edit_priority = 0 WHERE id = '".$_POST['symptom_id']."'";
						$db->query($symptomUpdateQuery);
					}else{
						// Cleaning Previous Data From temp START
						$deleteTempRemedyQuery="DELETE FROM temp_remedy WHERE symptom_id = '".$_POST['symptom_id']."'";
						$db->query($deleteTempRemedyQuery);

						$deleteTempPrueferQuery = "DELETE FROM temp_pruefer WHERE symptom_id = '".$_POST['symptom_id']."'";
						$db->query($deleteTempPrueferQuery);

						$deleteTempSymptomPrueferQuery = "DELETE FROM temp_symptom_pruefer WHERE symptom_id = '".$_POST['symptom_id']."'";
						$db->query($deleteTempSymptomPrueferQuery);

						$deleteTempReferenceQuery = "DELETE FROM temp_reference WHERE symptom_id = '".$_POST['symptom_id']."'";
						$db->query($deleteTempReferenceQuery);

						$deleteTempSymptomReferenceQuery = "DELETE FROM temp_symptom_reference WHERE symptom_id = '".$_POST['symptom_id']."'";
						$db->query($deleteTempSymptomReferenceQuery);
						// Cleaning Previous Data From temp END
						
						$symptomUpdateQuery="UPDATE temp_quelle_import_test SET Beschreibung = '".$data['Beschreibung']."', BeschreibungOriginal = '".$data['BeschreibungOriginal']."', BeschreibungPlain = '".$data['BeschreibungPlain']."', bracketedString = '".$data['bracketedString']."', timeString = '".$data['timeString']."', symptom_edit_comment = '".$data['symptom_edit_comment']."', stand = '".$date."', symptom_edit_priority = 0, part_of_symptom_priority = 0, remedy_priority = 0, pruefer_priority = 0, reference_with_no_author_priority = 0, remedy_with_symptom_priority = 0, more_than_one_tag_string_priority = 0, aao_hyphen_priority = 0, hyphen_pruefer_priority = 0, hyphen_reference_priority = 0, reference_priority = 0, direct_order_priority = 0, need_approval = 0 WHERE id = '".$_POST['symptom_id']."'";
						$db->query($symptomUpdateQuery);
					}

					if(isset($_POST['master_id']) AND $_POST['master_id'] != "")
						$parameterString = "?master=".$_POST['master_id'];
				}
				else{
					if(isset($_POST['master_id']) AND $_POST['master_id'] != "")
						$parameterString = "?master=".$_POST['master_id']."&popup_error=".$errorStatus;
				}
				/* In this else case if the bracketed part texts is not null than examining its possibilities END */
		    }
		    /* Applying program logic in the string END */
	    }
	   

	    // If we arrive here, it means that no exception was thrown
	    // i.e. no query has failed, and we can commit the transaction
	    $db->commit();

		header('Location: '.$baseUrl.$parameterString);
		exit();
	} catch (Exception $e) {
	    // An exception has been thrown
	    // We must rollback the transaction
	    $db->rollback();
	    header('Location: '.$baseUrl.'?error=1');
		exit();
	}
	
}else if(isset($_POST['symptom_edit_cancel']) AND $_POST['symptom_edit_cancel'] == "Cancel"){
	try {
	    // First of all, let's begin a transaction
	    $db->begin_transaction();

	    $parameterString = "";
		$symptomUpdateQuery="UPDATE temp_quelle_import_test SET symptom_edit_priority = 0 WHERE id = '".$_POST['symptom_id']."'";
		$db->query($symptomUpdateQuery);

	    // If we arrive here, it means that no exception was thrown
	    // i.e. no query has failed, and we can commit the transaction
	    $db->commit();

	    if(isset($_POST['master_id']) AND $_POST['master_id'] != "")
			$parameterString = "?master=".$_POST['master_id'];

		header('Location: '.$baseUrl.$parameterString);
		exit();
	} catch (Exception $e) {
	    // An exception has been thrown
	    // We must rollback the transaction
	    $db->rollback();
	    header('Location: '.$baseUrl.'?error=1');
		exit();
	}
}else if(isset($_POST['edit_symptom']) AND $_POST['edit_symptom'] == "Edit"){
	try {
	    // First of all, let's begin a transaction
	    $db->begin_transaction();

	    $parameterString = "";
		$symptomUpdateQuery="UPDATE temp_quelle_import_test SET symptom_edit_priority = 12 WHERE id = '".$_POST['symptom_id']."'";
		$db->query($symptomUpdateQuery);

	    // If we arrive here, it means that no exception was thrown
	    // i.e. no query has failed, and we can commit the transaction
	    $db->commit();

	    if(isset($_POST['master_id']) AND $_POST['master_id'] != "")
			$parameterString = "?master=".$_POST['master_id'];

		header('Location: '.$baseUrl.$parameterString);
		exit();
	} catch (Exception $e) {
	    // An exception has been thrown
	    // We must rollback the transaction
	    $db->rollback();
	    header('Location: '.$baseUrl.'?error=1');
		exit();
	}
}
?>