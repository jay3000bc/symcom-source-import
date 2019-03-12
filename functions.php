<?php
	/*
	* Function for deleting Source import Temp Data by master_id
	* Parameter : master_id
	*/
	function deleteSourceImportTempData($masterId){
		global $db;
		$isDeleted = false;

		/* MySQL Transaction START */
		try{
			// First of all, let's begin a transaction
			$db->begin_transaction();
			/* Delete Temp table data START */
			$tempSymptomResult = mysqli_query($db, "SELECT * FROM temp_quelle_import_test where master_id = '".$masterId."'");
			if(mysqli_num_rows($tempSymptomResult) > 0){
				while($tempSymptomData = mysqli_fetch_array($tempSymptomResult)){

					/* Delete newly added pruefers form temp_pruefer table start */
					$deleteTempPrueferQuery = "DELETE FROM temp_pruefer WHERE symptom_id = '".$tempSymptomData['id']."'";
					$db->query($deleteTempPrueferQuery);
					/* Delete newly added pruefers form temp_pruefer table start */

					$deleteTempSymptomPrueferQuery = "DELETE FROM temp_symptom_pruefer WHERE symptom_id = '".$tempSymptomData['id']."'";
					$db->query($deleteTempSymptomPrueferQuery);

					$deleteTempRemedyQuery="DELETE FROM temp_remedy WHERE symptom_id = '".$tempSymptomData['id']."'";
					$db->query($deleteTempRemedyQuery);

					// Deleting Temp Reference
					$deleteTempReferenceQuery="DELETE FROM temp_reference WHERE symptom_id = '".$tempSymptomData['id']."'";
					$db->query($deleteTempReferenceQuery);

					// Deleting Temp Symptom Reference
					$deleteTempSymptomReferenceQuery="DELETE FROM temp_symptom_reference WHERE symptom_id = '".$tempSymptomData['id']."'";
					$db->query($deleteTempSymptomReferenceQuery);

					// Deleting Temp Approved Reference
					$deleteTempApprovedReferenceQuery="DELETE FROM temp_approved_reference WHERE symptom_id = '".$tempSymptomData['id']."'";
					$db->query($deleteTempApprovedReferenceQuery);

					// Deleting Temp Approved Pruefer
					$deleteTempApprovedPrueferQuery="DELETE FROM temp_approved_pruefer WHERE symptom_id = '".$tempSymptomData['id']."'";
					$db->query($deleteTempApprovedPrueferQuery);
				}
			}

			$deleteTempSymptomQuery = "DELETE FROM temp_quelle_import_test WHERE master_id = '".$masterId."'";
			$db->query($deleteTempSymptomQuery);

			$deleteTempMasterQuery = "DELETE FROM temp_quelle_import_master WHERE id = '".$masterId."'";
			$db->query($deleteTempMasterQuery);
			/* Delete Temp table data END */

			// If we arrive here, it means that no exception was thrown
		    // i.e. no query has failed, and we can commit the transaction
		    $db->commit();
		    $isDeleted = true;
		}catch (Exception $e) {
		    // An exception has been thrown
		    // We must rollback the transaction
		    $db->rollback();
		    $isDeleted = false;
		}
		/* MySQL Transaction END */

		return $isDeleted;
	}


	/*
	* Function for checeking is there any Uppercase letter in the string
	*/
	function isThereAnyUppercase($string){
		$returnVal = false;
		if(preg_match('/[A-Z]/', $string))
		{ 
		    // There is one upper 
		    $returnVal = true;
		}

		return $returnVal;
	}

	/*
	* Function for checeking is the first character of the string is Uppercase letter
	*/
	function isFirstCharacterUppercase($string){
		$isFirstCharUppercase = false;
		$words = preg_split("/\s{1,}/",$string);
		foreach ($words as $word) {
		    $firstChar = mb_substr($word, 0, 1);
		    if(preg_match('/[A-Z]/', $firstChar))
			{ 
			   	// There is one upper 
			    $isFirstCharUppercase = true;
			}else{
				$isFirstCharUppercase = false;
				break;
			}
		}
		return $isFirstCharUppercase;
	}

	function encodeStringIfNeeded($string){
		  if ( false === mb_check_encoding($string, 'UTF-8') ){
		  	echo "yes";
		  	exit();
		  	return $string = utf8_encode($string);  
		  }
		  else 
		  	return $string;
	}

	/*
	* In array functionalities for multidimensional arrays like - pruefer array, remedy array, reference array etc.
	*/
	function custom_in_array($needle, $needleField, $array, $strict = false) {
		if(!empty($array)){
			foreach ($array as $key => $val) {
				if($strict){
					if(isset($array[$key][$needleField]) AND $array[$key][$needleField] === $needle)
						return true;
				}else{
					if(isset($array[$key][$needleField]) AND $array[$key][$needleField] == $needle)
						return true;
				}
		    }	
		}

	    return false;
	}

	/*
	* Checking if it's time data or not
	* function isTimeString
	* Parameters: compareing string, position of opening bracket 
	* Return: False if match not found else returns the extracted string 
	*/
	function isTimeString($cleanline=NULL, $bracketP=NULL, $timeStringEndTagArray){
		//global $timeStringEndTagArray;
		$returnVal=false;

		if($cleanline != NULL AND $bracketP != NULL){

			foreach ($timeStringEndTagArray as $timeStrKey => $timeStrVal) {
				// if (mb_substr($cleanline,-mb_strlen('St)'))==='St)'){
				if (mb_substr($cleanline,-mb_strlen($timeStrVal)) === $timeStrVal){
					$prepareTimeString = rtrim( mb_substr ( $cleanline, $bracketP ), '.' );
					$prepareTimeString = rtrim( $prepareTimeString, ',' );
					$returnVal = $prepareTimeString;
					break;
				}	
			}
			// if ((mb_substr($cleanline,-mb_strlen('St)'))==='St)') OR (mb_substr($cleanline,-mb_strlen('St.)'))==='St.)') OR (mb_substr($cleanline,-mb_strlen('St. )'))==='St. )') OR (mb_substr($cleanline,-mb_strlen('St.).'))==='St.).') OR (mb_substr($cleanline,-mb_strlen('Tagen.)'))==='Tagen.)') OR (mb_substr($cleanline,-mb_strlen('Tagen.).'))==='Tagen.).') OR (mb_substr($cleanline,-mb_strlen('Tagen)'))==='Tagen)') OR (mb_substr($cleanline,-mb_strlen('Tagen).'))==='Tagen).') OR (mb_substr($cleanline,-mb_strlen('Nacht)'))==='Nacht)') OR (mb_substr($cleanline,-mb_strlen('Tag)'))==='Tag)') OR (mb_substr($cleanline,-mb_strlen('Tag.)'))==='Tag.)') OR (mb_substr($cleanline,-mb_strlen('Tag.).'))==='Tag.).') OR (mb_substr($cleanline,-mb_strlen('T)'))==='T)') OR (mb_substr($cleanline,-mb_strlen('T.)'))==='T.)') OR (mb_substr($cleanline,-mb_strlen('T.).'))==='T.).') OR (mb_substr($cleanline,-mb_strlen('Uhr.).'))==='Uhr.).') OR (mb_substr($cleanline,-mb_strlen('Uhr).'))==='Uhr).') OR (mb_substr($cleanline,-mb_strlen('Uhr)'))==='Uhr)') OR (mb_substr($cleanline,-mb_strlen('Uhr),'))==='Uhr),') OR (mb_substr($cleanline,-mb_strlen('Uhr.),'))==='Uhr.),') OR (mb_substr($cleanline,-mb_strlen('hour.).'))==='hour.).') OR (mb_substr($cleanline,-mb_strlen('hour).'))==='hour).') OR (mb_substr($cleanline,-mb_strlen('hour)'))==='hour)') OR (mb_substr($cleanline,-mb_strlen('hour),'))==='hour),') OR (mb_substr($cleanline,-mb_strlen('hour.),'))==='hour.),') OR (mb_substr($cleanline,-mb_strlen('hours)'))==='hours)') OR (mb_substr($cleanline,-mb_strlen('hours).'))==='hours).') OR (mb_substr($cleanline,-mb_strlen('hours.)'))==='hours.)') OR (mb_substr($cleanline,-mb_strlen('hours.).'))==='hours.).') OR (mb_substr($cleanline,-mb_strlen('hours),'))==='hours),') OR (mb_substr($cleanline,-mb_strlen('hours.),'))==='hours.),') OR (mb_substr($cleanline,-mb_strlen('Hour.).'))==='Hour.).') OR (mb_substr($cleanline,-mb_strlen('Hour).'))==='Hour).') OR (mb_substr($cleanline,-mb_strlen('Hour)'))==='Hour)') OR (mb_substr($cleanline,-mb_strlen('Hour),'))==='Hour),') OR (mb_substr($cleanline,-mb_strlen('Hour.),'))==='Hour.),') OR (mb_substr($cleanline,-mb_strlen('Hours)'))==='Hours)') OR (mb_substr($cleanline,-mb_strlen('Hours).'))==='Hours).') OR (mb_substr($cleanline,-mb_strlen('Hours.)'))==='Hours.)') OR (mb_substr($cleanline,-mb_strlen('Hours.).'))==='Hours.).') OR (mb_substr($cleanline,-mb_strlen('Hours),'))==='Hours),') OR (mb_substr($cleanline,-mb_strlen('Hours.),'))==='Hours.),') OR (mb_substr($cleanline,-mb_strlen('minute.).'))==='minute.).') OR (mb_substr($cleanline,-mb_strlen('minute).'))==='minute).') OR (mb_substr($cleanline,-mb_strlen('minute)'))==='minute)') OR (mb_substr($cleanline,-mb_strlen('minute),'))==='minute),') OR (mb_substr($cleanline,-mb_strlen('minute.),'))==='minute.),') OR (mb_substr($cleanline,-mb_strlen('minutes)'))==='minutes)') OR (mb_substr($cleanline,-mb_strlen('minutes.)'))==='minutes.)') OR (mb_substr($cleanline,-mb_strlen('minutes.).'))==='minutes.).') OR (mb_substr($cleanline,-mb_strlen('minutes),'))==='minutes),') OR (mb_substr($cleanline,-mb_strlen('minutes.),'))==='minutes.),') OR (mb_substr($cleanline,-mb_strlen('Minute.).'))==='Minute.).') OR (mb_substr($cleanline,-mb_strlen('Minute).'))==='Minute).') OR (mb_substr($cleanline,-mb_strlen('Minute)'))==='Minute)') OR (mb_substr($cleanline,-mb_strlen('Minute),'))==='Minute),') OR (mb_substr($cleanline,-mb_strlen('Minute.),'))==='Minute.),') OR (mb_substr($cleanline,-mb_strlen('Minutes)'))==='Minutes)') OR (mb_substr($cleanline,-mb_strlen('Minutes.)'))==='Minutes.)') OR (mb_substr($cleanline,-mb_strlen('Minutes.).'))==='Minutes.).') OR (mb_substr($cleanline,-mb_strlen('Minutes),'))==='Minutes),') OR (mb_substr($cleanline,-mb_strlen('Minutes.),'))==='Minutes.),'))
			// {
			// 	// $timeStringArray[] = rtrim( mb_substr ( $cleanline, $bracketP + 1, - 1 ), ')' );
			// 	$prepareTimeString = rtrim( mb_substr ( $cleanline, $bracketP ), '.' );
			// 	$prepareTimeString = rtrim( $prepareTimeString, ',' );
			// 	$returnVal = $prepareTimeString;
			// }
		}

		return $returnVal;
	}

	/*
	* Finding all time data in the symptom string
	* function getAllTimeData
	* Parameters: symptom string 
	* Return: empty array if no time data found else returns the time data array 
	*/
	function getAllTimeData($cleanline=NULL, $timeStringEndTagArray, $returnArray=array()){

		$returnArr = array();
		if($cleanline != NULL){
			$lastOccurance = mb_strripos ( $cleanline, ')' );
			if($lastOccurance !== false){
				$prePartString = mb_substr ( $cleanline, 0, $lastOccurance + 1 );
				$lastOccuranceOfParentheses = mb_strripos ( $prePartString, '(' );
				$extractedTimeString = mb_substr ( $prePartString, $lastOccuranceOfParentheses );
				foreach ($timeStringEndTagArray as $timeStrKey => $timeStrVal) {
					// if (mb_substr($cleanline,-mb_strlen('St)'))==='St)'){
					if (mb_substr($prePartString,-mb_strlen($timeStrVal)) === $timeStrVal){
						$checkForNestedbrackets = isNestedBracket($prePartString, $extractedTimeString, "(", ")");
						if(isset($checkForNestedbrackets['status']) && $checkForNestedbrackets['status'] === TRUE){
							$newTimeString = $checkForNestedbrackets['bracketed_string'];
							$returnArray[] = $newTimeString;
						}else{
							$returnArray[] = $extractedTimeString;
						}
					}
				}
				$remainingStringFromBegining = mb_substr ( $prePartString, 0, mb_strlen($prePartString)-mb_strlen($extractedTimeString) );
				return getAllTimeData($remainingStringFromBegining, $timeStringEndTagArray, $returnArray);
			}
			
			$returnArr = $returnArray;	
		}

		return $returnArr;
	}

	/*
	* Checking is the given bracketed string contains nested brackets
	* Parameters: Full string, bracketed string extracted implementing normal rule,
	*             Opening bracket "(" OR "[", Closing bracket ")" OR "]"
	* Return: An array, key 
	*		   "status" => true OR false,
	*          "bracketed_string" => Bracketed string
	*/
	function isNestedBracket($fullString, $bracketedString, $openingBracket, $closingBracket){
		$returnArr = array(
			'status' => false,
			'bracketed_string' => $bracketedString
		);
		$numberOfClosingBracket=mb_substr_count($bracketedString, $closingBracket);
		if( $numberOfClosingBracket > 1 ){
			while( $numberOfClosingBracket > 1 ){ 
				$remainingStringFromBegining = mb_substr ( $fullString, 0, mb_strlen($fullString)-mb_strlen($bracketedString) );
				$lastOccuranceOfParentheses = mb_strripos ( $remainingStringFromBegining, $openingBracket );
				$prePartString = mb_substr ( $remainingStringFromBegining, $lastOccuranceOfParentheses );
				if( mb_substr_count($prePartString, $closingBracket) > 0 ){
					$numberOfClosingBracket = $numberOfClosingBracket + mb_substr_count($prePartString, $closingBracket);
				}
				$bracketedString = $prePartString.$bracketedString;
				$numberOfClosingBracket--;
			}
			$returnArr = array(
				'status' => true,
				'bracketed_string' => $bracketedString
			);
		}

		return $returnArr;
	}

	/*
	* This function will get called when expected  the string is found with a. a. O.
	*/
	function lookupReferenceInCurrentImport($string, $masterId){
		global $db;

		$returnArr = array(
			'data' => array(),
			'need_approval' => 0,
			'is_multiple' => 0
		);

		$string = trim ( $string );
		$string = (mb_substr ( $string, mb_strlen ( $string ) - 1, 1 ) == ',') ? mb_substr ( $string, 0, mb_strlen ( $string ) - 1 ) : $string;
		$string = trim($string);
		$referenceSearchResult = mysqli_query($db, "SELECT reference.reference_id, reference.full_reference, reference.autor, reference.reference FROM temp_approved_reference JOIN reference ON temp_approved_reference.reference_id = reference.reference_id WHERE reference.autor LIKE '%".$string."%' AND temp_approved_reference.master_id = ".$masterId." ORDER BY temp_approved_reference.symptom_id DESC LIMIT 1");
		if(mysqli_num_rows($referenceSearchResult) > 0){
			$referenceData = mysqli_fetch_assoc($referenceSearchResult);

			if(isset($referenceData['reference_id']) AND $referenceData['reference_id'] != ""){
				$dataArr['reference_id'] = $referenceData['reference_id'];
				$dataArr['full_reference'] = $referenceData['full_reference'];
				$dataArr['autor'] = $referenceData['autor'];
				$dataArr['reference'] = $referenceData['reference'];
				$returnArr['data'][] = $dataArr;
			}
		}

		if(empty($returnArr['data'])){
			$returnArr['need_approval'] = 1;
		}

		return $returnArr;
	}

	function lookupLiteratureReference($string){
		global $db;

		$returnArr = array(
			'data' => array(),
			'need_approval' => 0,
			'is_multiple' => 0
		);
		$isExactMatchFound = 0;

		// $string = str_replace("No Author,", "", $string);
		$string = trim ( $string );
		$additionalQueryCondition = "";
		if(mb_strpos($string, ',') !== false){
			$stringArray = explode(',', $string);
			if(isset($stringArray[0]) AND !empty($stringArray[0])){
				$authorName = trim($stringArray[0]);
				if(strtolower($authorName) != "no author")
					$additionalQueryCondition = " OR autor LIKE '%".$authorName."%'";
			}
			// getting 40% of the string
			$thirtyPercentOftheString =  round((40 / 100) * mb_strlen($string));
			$stringQuery = mb_substr($string, 0, $thirtyPercentOftheString); 
		}else{
			// getting 70% of the string
			$seventyPercentOftheString =  round((70 / 100) * mb_strlen($string));
			$stringQuery = mb_substr($string, 0, $seventyPercentOftheString); 
		}
		$referenceSearchResult = mysqli_query($db, "SELECT reference_id, full_reference, autor, reference FROM reference where full_reference LIKE '%".$stringQuery."%'".$additionalQueryCondition);
		if(mysqli_num_rows($referenceSearchResult) > 0){
			// $referenceData = mysqli_fetch_assoc($referenceSearchResult);
			while($referenceData = mysqli_fetch_array($referenceSearchResult)){
				if($referenceData['full_reference'] == $string){
					$isExactMatchFound = 1;
					$returnArr['data'] = array();
					$dataArr['reference_id'] = $referenceData['reference_id'];
					$dataArr['full_reference'] = $referenceData['full_reference'];
					$dataArr['autor'] = $referenceData['autor'];
					$dataArr['reference'] = $referenceData['reference'];
					$returnArr['data'][] = $dataArr;
					break;
				}else{
					$dataArr['reference_id'] = $referenceData['reference_id'];
					$dataArr['full_reference'] = $referenceData['full_reference'];
					$dataArr['autor'] = $referenceData['autor'];
					$dataArr['reference'] = $referenceData['reference'];
					$returnArr['data'][] = $dataArr;
				}
			}
		}

		if(empty($returnArr['data'])){
				$returnArr['need_approval'] = 1;
		}else{
			if($isExactMatchFound == 0){
				$returnArr['need_approval'] = 1;
				if(count($returnArr['data']) > 1)
					$returnArr['is_multiple'] = 1;
			}
		}
		return $returnArr;
	}

	function lookupRemedyWithSymptom($remedyWithSymptomString, $similarRemedyString, $similarSymptomString){
		global $db;

		$returnArr = array(
			'data' => array(),
			'need_approval' => 0,
			'is_multiple' => 0
		);
		$isExactMatchFound = 0;

		$remedyWithSymptomString = trim ( $remedyWithSymptomString );
		$similarRemedyString = trim ( $similarRemedyString );
		$similarSymptomString = trim ( $similarSymptomString );

		$remedyDataArr = array();
		$remedySearchResult = mysqli_query($db, "SELECT remedy_id, name FROM remedy where name = '".$similarRemedyString."'");
		if(mysqli_num_rows($remedySearchResult) > 0){
			$remedyData = mysqli_fetch_assoc($remedySearchResult);
			$remedyDataArr['remedy_id'] = $remedyData['remedy_id'];
			$remedyDataArr['name'] = $remedyData['name'];
		}else{
			$remedyDataArr['remedy_id'] = null;
			$remedyDataArr['name'] = $similarRemedyString;
		}

		$cleanString = (mb_substr ( $remedyWithSymptomString, mb_strlen ( $remedyWithSymptomString ) - 1, 1 ) == '.') ? mb_substr ( $remedyWithSymptomString, 0, mb_strlen ( $remedyWithSymptomString ) - 1 ) : '';
		
		$remedyWithSymptomSearchResult = mysqli_query($db, "SELECT id, symptom_of_different_remedy, Remedy FROM quelle_import_test WHERE symptom_of_different_remedy LIKE '%".$remedyWithSymptomString."%'");
		if(mysqli_num_rows($remedyWithSymptomSearchResult) > 0){
			// $remedyWithSymptomData = mysqli_fetch_assoc($remedyWithSymptomSearchResult);
			while($remedyWithSymptomData = mysqli_fetch_array($remedyWithSymptomSearchResult)){
				if($remedyWithSymptomData['symptom_of_different_remedy'] == $remedyWithSymptomString){
					$isExactMatchFound = 1;
					$returnArr['data'] = array();
					$dataArr['symptom_id'] = $remedyWithSymptomData['id'];
					$dataArr['symptom_of_different_remedy'] = $remedyWithSymptomData['symptom_of_different_remedy'];
					$dataArr['remedy'][] = $remedyDataArr;
					$returnArr['data'][] = $dataArr;
					break;
				}else{
					$dataArr['symptom_id'] = $remedyWithSymptomData['id'];
					$dataArr['symptom_of_different_remedy'] = $remedyWithSymptomData['symptom_of_different_remedy'];
					$dataArr['remedy'][] = $remedyDataArr;
					$returnArr['data'][] = $dataArr;
				}
			}
		}

		if($cleanString != "" AND $isExactMatchFound == 0)
			return lookupRemedyWithSymptom($cleanString, $similarRemedyString, $similarSymptomString);

		if(empty($returnArr['data'])){
				$returnArr['need_approval'] = 1;
		}else{
			if($isExactMatchFound == 0){-
				$returnArr['need_approval'] = 1;
				if(count($returnArr['data']) > 1)
					$returnArr['is_multiple'] = 1;
			}
		}
		return $returnArr;
	}

	function lookupRemedy($string){
		global $db;

		$returnArr = array(
			'data' => array(),
			'need_approval' => 0,
			'is_multiple' => 0
		);
		$isExactMatchFound = 0;

		$string = trim ( $string );
		if(mb_substr ( $string, mb_strlen ( $string ) - 1, 1 ) == '.'){
			$cleanString = mb_substr ( $string, 0, mb_strlen ( $string ) - 1 );
			$workingString = $string;
		}else{
			$cleanString = "";
			// getting 85% of the string
			$eightyfivePercentOftheString =  round((85 / 100) * mb_strlen($string));
			$workingString = mb_substr($string, 0, $eightyfivePercentOftheString); 
		}
		// $cleanString = (mb_substr ( $string, mb_strlen ( $string ) - 1, 1 ) == '.') ? mb_substr ( $string, 0, mb_strlen ( $string ) - 1 ) : ''; 
		$remedySearchResult = mysqli_query($db, "SELECT remedy_id, name FROM remedy where name LIKE '%".$workingString."%'");
		if(mysqli_num_rows($remedySearchResult) > 0){
			// $remedyData = mysqli_fetch_assoc($remedySearchResult);
			while($remedyData = mysqli_fetch_array($remedySearchResult)){
				
				if(strtolower($remedyData['name']) == strtolower($string)){
					$isExactMatchFound = 1;
					$returnArr['data'] = array();
					$dataArr['remedy_id'] = $remedyData['remedy_id'];
					$dataArr['name'] = $remedyData['name'];
					$returnArr['data'][] = $dataArr;
					break;
				}else{
					$dataArr['remedy_id'] = $remedyData['remedy_id'];
					$dataArr['name'] = $remedyData['name'];
					$returnArr['data'][] = $dataArr;
				}
			}
		}

		if($cleanString != "" AND $isExactMatchFound == 0)
			return lookupRemedy($cleanString);

		if(empty($returnArr['data'])){
			$returnArr['need_approval'] = 1;
		}else{
			if($isExactMatchFound == 0){
				$returnArr['need_approval'] = 1;
				if(count($returnArr['data']) > 1)
					$returnArr['is_multiple'] = 1;
			}
		}
		return $returnArr;
	}

	/*
	* This function will get called when expected  the string is found with a. a. O.
	*/
	function lookupPrueferInCurrentImport($string, $masterId){
		global $db;

		$returnArr = array(
			'data' => array(),
			'need_approval' => 0,
			'is_multiple' => 0
		);
		
		$string = trim($string);
		$string = (mb_substr ( $string, mb_strlen ( $string ) - 1, 1 ) == ',') ? mb_substr ( $string, 0, mb_strlen ( $string ) - 1 ) : $string;
		$string = trim($string);
		$cleanString = (mb_substr ( $string, mb_strlen ( $string ) - 1, 1 ) == '.') ? mb_substr ( $string, 0, mb_strlen ( $string ) - 1 ) : '';

		$prueferSearchResult = mysqli_query($db, "SELECT pruefer.pruefer_id, pruefer.kuerzel, pruefer.suchname FROM temp_approved_pruefer JOIN pruefer ON temp_approved_pruefer.pruefer_id = pruefer.pruefer_id where (pruefer.kuerzel LIKE '%".$string."%' OR pruefer.suchname LIKE '%".$string."%') AND temp_approved_pruefer.master_id = ".$masterId." ORDER BY temp_approved_pruefer.symptom_id DESC LIMIT 1");
		if(mysqli_num_rows($prueferSearchResult) > 0){ 
			$pruferData = mysqli_fetch_assoc($prueferSearchResult);
			if(isset($pruferData['pruefer_id']) AND $pruferData['pruefer_id'] != ""){
				$dataArr['pruefer_id'] = $pruferData['pruefer_id'];
				$dataArr['kuerzel'] = $pruferData['kuerzel'];
				$dataArr['suchname'] = $pruferData['suchname'];
				$returnArr['data'][] = $dataArr;
			}
		}

		if(empty($returnArr['data']) AND $cleanString != "")
			return lookupPrueferInCurrentImport($cleanString, $masterId);

		if(empty($returnArr['data'])){
			$returnArr['need_approval'] = 1;
		}
		
		return $returnArr;
	}

	function lookupPruefer($string) {
		global $db;

		$returnArr = array(
			'data' => array(),
			'need_approval' => 0,
			'is_multiple' => 0
		);
		$isExactMatchFound = 0;
		
		$string = trim($string);
		// checking for comma's existance and taking approptiate action (e.g. W. E. Wislicenus, in einemAufsatze.)
		if (mb_strpos($string, ',') !== false){
			$separator = ",";
			$commaFirstOccurrence = mb_stripos ( $string, $separator );
			$beforeTheCommaString = trim( mb_substr ( $string, 0, $commaFirstOccurrence ) );

			$beforeTheCommaStringInArray = explode(" ", $beforeTheCommaString);
			$lastWord = end($beforeTheCommaStringInArray);

			$workingString = trim($lastWord);
			$string = $beforeTheCommaString;
		}else{
			$workingString = $string;
		}

		if(mb_substr ( $workingString, mb_strlen ( $workingString ) - 1, 1 ) == '.'){
			$cleanString = mb_substr ( $workingString, 0, mb_strlen ( $workingString ) - 1 );
		}else{
			$cleanString = "";
			// getting 80% of the string
			$eightyPercentOftheString =  round((80 / 100) * mb_strlen($workingString));
			$workingString = mb_substr($workingString, 0, $eightyPercentOftheString); 
		}


		// $cleanString = (mb_substr ( $string, mb_strlen ( $string ) - 1, 1 ) == '.') ? mb_substr ( $string, 0, mb_strlen ( $string ) - 1 ) : '';
		// $stringQuery = utf8_decode($workingString);		
		// $comparingString = utf8_decode($string);
		// echo "<br> <br>";
		// var_dump(html_entity_decode($string));
		// $string = html_entity_decode($string);
		// $strings = 'Groß';
		// var_dump(htmlentities(htmlentities($strings)));
		// var_dump($strings);
		// mysqli_query($db, "SET NAMES 'utf8'");
		$prueferSearchResult = mysqli_query($db, "SELECT pruefer_id, kuerzel, suchname FROM pruefer where kuerzel LIKE '%".$workingString."%' OR suchname LIKE '%".$workingString."%'");
		if(mysqli_num_rows($prueferSearchResult) > 0){ 
			// $gettingPruferData = mysqli_fetch_assoc($prueferSearchResult);
			while($pruferData = mysqli_fetch_array($prueferSearchResult)){ 
				$kuerzelArr = explode("|", $pruferData['kuerzel']); 

				if(in_array($string, $kuerzelArr) OR strtolower($pruferData['suchname']) == strtolower($string) ){
					$isExactMatchFound = 1;
					$returnArr['data'] = array();
					$dataArr['pruefer_id'] = $pruferData['pruefer_id'];
					$dataArr['kuerzel'] = $pruferData['kuerzel'];
					$dataArr['suchname'] = $pruferData['suchname'];
					$returnArr['data'][] = $dataArr;
					break;
				}
				else{
					$dataArr['pruefer_id'] = $pruferData['pruefer_id'];
					$dataArr['kuerzel'] = $pruferData['kuerzel'];
					$dataArr['suchname'] = $pruferData['suchname'];
					$returnArr['data'][] = $dataArr;
				}
			}
		}

		if($cleanString != "" AND $isExactMatchFound == 0)
			return lookupPruefer($cleanString);

		if(empty($returnArr['data'])){
			$returnArr['need_approval'] = 1;
		}
		else{
			if($isExactMatchFound == 0){
				$returnArr['need_approval'] = 1;
				if(count($returnArr['data']) > 1)
					$returnArr['is_multiple'] = 1;
			}
		}
		
		return $returnArr;
	}


	/*
	* Checking approval string is this has chances of cleared in this import
	* Parameters: approval string
	* Return: true OR false
	*/
	function isClearedInThisImport($tempSymptomId, $approvalString, $masterId, $isPreDefinedTagsApprovalGet, $tagParameter){
		global $db;
		$returnVal = false;

		// Make it Checked unless user clicks on Later button
		$symptomCheckedUpdateQuery="UPDATE temp_quelle_import_test SET is_rechecked = 1 WHERE id = '".$tempSymptomId."'";
		$db->query($symptomCheckedUpdateQuery);

		/*
		* Here i am breaking the approval string in some conditions following Rule 1 and Rule 2(so far) 
		* because there can be multiple elements to check.E.g: (Caust. Cupr. Puls.)
		* other than some conditions i am taking the full approval string to compare. 
		*/
		$approvalStraingArray = array();
		$lastBracketedString = trim($approvalString);
		$approvalStraingArray[] = $lastBracketedString;

		// Checking the existance of , - . ; and , a. a. O. and , a.a.O.
		$isAaoExist = mb_strpos($lastBracketedString, ', a. a. O.');
		$isAaoWithoutSpaceExist = mb_strpos($lastBracketedString, ', a.a.O.');
		$isAaoWithoutAnySpaceExist = mb_strpos($lastBracketedString, ',a.a.O.');
		$isAaoWithoutFrontSpaceExist = mb_strpos($lastBracketedString, ',a. a. O.');
		$isCommaExist = mb_substr_count($lastBracketedString,",");
		$isHyphenExist = mb_substr_count($lastBracketedString,"-");
		$isDotExist = mb_substr_count($lastBracketedString,".");
		$isSemicolonExist = mb_substr_count($lastBracketedString,";");
		// echo $tempSymptomId." ".$approvalString." ".$masterId." ".$isPreDefinedTagsApprovalGet." ".$tagParameter;
		// exit();

		if($isPreDefinedTagsApprovalGet == 1){
			$approvalStraingArray = array();
			$approvalStraingArray = explode("{#^#}", $lastBracketedString);
		}
		else if($isCommaExist == 0 AND $isSemicolonExist == 0 AND $isHyphenExist == 0 AND $isAaoExist === false AND $isAaoWithoutSpaceExist === false AND $isAaoWithoutAnySpaceExist === false AND $isAaoWithoutFrontSpaceExist === false)
		{
			// No Comma AND No Semicolon AND No Hyphen AND No , a. a. O. START
			$workingString = $lastBracketedString;
			$wordsInLastString = explode(" ", $lastBracketedString);
			if(!empty($wordsInLastString)){
				if(count($wordsInLastString) > 1){
					$approvalStraingArray = array();
					$makeStringToExplode = str_replace('.', '.{#^#}', $workingString);
					$approvalStraingArray = explode("{#^#}", $makeStringToExplode);
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

			$approvalStraingArray = array();
			$approvalStraingArray = explode($separator, $lastBracketedString);
			// With Comma OR Semicolon AND NO Hyphen AND No , a. a. O. END
		}
		else if(($isAaoExist !== false OR $isAaoWithoutSpaceExist !== false OR $isAaoWithoutAnySpaceExist !== false OR $isAaoWithoutFrontSpaceExist !== false) AND $isHyphenExist != 0)
		{
			$approvalStraingArray = array();
			$workingString = trim($lastBracketedString);
			$eachElement = explode(" - ", $workingString);
			foreach ($eachElement as $elementKey => $elementVal) {
				$approvalStringVal = str_replace(", a. a. O.", "{#^#}", $elementVal);
				$approvalStringVal = str_replace(", a.a.O.", "{#^#}", $approvalStringVal);
				$approvalStringVal = str_replace(",a.a.O.", "{#^#}", $approvalStringVal);
				$approvalStringVal = str_replace(",a. a. O.", "{#^#}", $approvalStringVal);
				$approvalPreStraing = trim($approvalStringVal);
				$aaoPosition = mb_strpos($approvalPreStraing, '{#^#}');
				if($aaoPosition !== false){
					$approvalPreStraing = mb_substr($approvalPreStraing, 0, $aaoPosition);
				}
				$approvalPreStraing = str_replace("{#^#}", "", $approvalPreStraing);
				$approvalStraingArray[] = trim($approvalPreStraing);
			} 
		}
		else if($isHyphenExist != 0)
		{
			$approvalStraingArray = array();
			$workingString = trim($lastBracketedString);
			$eachElement = explode(" - ", $workingString);
			foreach ($eachElement as $elementKey => $elementVal) {
				$approvalStringVal = str_replace(", a. a. O.", "{#^#}", $elementVal);
				$approvalStringVal = str_replace(", a.a.O.", "{#^#}", $approvalStringVal);
				$approvalStringVal = str_replace(",a.a.O.", "{#^#}", $approvalStringVal);
				$approvalStringVal = str_replace(",a. a. O.", "{#^#}", $approvalStringVal);
				$approvalPreStraing = trim($approvalStringVal);
				$aaoPosition = mb_strpos($approvalPreStraing, '{#^#}');
				if($aaoPosition !== false){
					$approvalPreStraing = mb_substr($approvalPreStraing, 0, $aaoPosition);
				}
				$approvalPreStraing = str_replace("{#^#}", "", $approvalPreStraing);
				$approvalStraingArray[] = trim($approvalPreStraing);
			} 
		}
		else if($isAaoExist !== false OR $isAaoWithoutSpaceExist !== false OR $isAaoWithoutAnySpaceExist !== false OR $isAaoWithoutFrontSpaceExist !== false)
		{
			$approvalStraingArray = array();
			$approvalStringVal = str_replace(", a. a. O.", "{#^#}", $lastBracketedString);
			$approvalStringVal = str_replace(", a.a.O.", "{#^#}", $approvalStringVal);
			$approvalStringVal = str_replace(",a.a.O.", "{#^#}", $approvalStringVal);
			$approvalStringVal = str_replace(",a. a. O.", "{#^#}", $approvalStringVal);
			$approvalPreStraing = trim($approvalStringVal);
			$aaoPosition = mb_strpos($approvalPreStraing, '{#^#}');
			if($aaoPosition !== false){
				$approvalPreStraing = mb_substr($approvalPreStraing, 0, $aaoPosition);
			}
			$approvalPreStraing = str_replace("{#^#}", "", $approvalPreStraing);
			$approvalStraingArray[] = trim($approvalPreStraing);
		}

		// Checking is it cleared already in this import process
		if(!empty($approvalStraingArray)){
			$isMatchFound = 0;
			foreach ($approvalStraingArray as $approvalStringKey => $approvalStringVal) {
				// getting 80% of the string
				$approvalStringVal = trim($approvalStringVal); 
				if($approvalStringVal != ""){
					$eightyPercentOftheString =  round((80 / 100) * mb_strlen($approvalStringVal));
					$newApprovalString = mb_substr($approvalStringVal, 0, $eightyPercentOftheString);

					$approvalStringSearchResult = mysqli_query($db, "SELECT id FROM temp_quelle_import_test where approval_string LIKE '%".$newApprovalString."%' AND id != '".$tempSymptomId."' AND need_approval = 0");
					if(mysqli_num_rows($approvalStringSearchResult) > 0){
						$isMatchFound = 1;
						break;
					}
				}
			}

			if($isMatchFound == 1){
				// header('Location: '.$baseUrl.'?master='.$masterId);
				// exit();

				// Cleaning Previous Data From temp START
				$deleteTempRemedyQuery="DELETE FROM temp_remedy WHERE symptom_id = '".$tempSymptomId."'";
				$db->query($deleteTempRemedyQuery);

				$deleteTempPrueferQuery = "DELETE FROM temp_pruefer WHERE symptom_id = '".$tempSymptomId."'";
				$db->query($deleteTempPrueferQuery);

				$deleteTempSymptomPrueferQuery = "DELETE FROM temp_symptom_pruefer WHERE symptom_id = '".$tempSymptomId."'";
				$db->query($deleteTempSymptomPrueferQuery);

				$deleteTempReferenceQuery = "DELETE FROM temp_reference WHERE symptom_id = '".$tempSymptomId."'";
				$db->query($deleteTempReferenceQuery);

				$deleteTempSymptomReferenceQuery = "DELETE FROM temp_symptom_reference WHERE symptom_id = '".$tempSymptomId."'";
				$db->query($deleteTempSymptomReferenceQuery);

				// Deleting Temp Approved Reference
				$deleteTempApprovedReferenceQuery="DELETE FROM temp_approved_reference WHERE symptom_id = '".$tempSymptomId."'";
				$db->query($deleteTempApprovedReferenceQuery);

				// Deleting Temp Approved Pruefer
				$deleteTempApprovedPrueferQuery="DELETE FROM temp_approved_pruefer WHERE symptom_id = '".$tempSymptomId."'";
				$db->query($deleteTempApprovedPrueferQuery);
				// Cleaning Previous Data From temp END

				$aLiteraturquellen = array ();
				$EntnommenAus='';
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
				$tagsApprovalString = "";
				$isPreDefinedTagsApproval = 0;
				$symptomOfDifferentRemedy = "";

				/* applying Rules on the approval string again it may get cleared already in this import process START */
				if($isPreDefinedTagsApprovalGet == 1){
					// This section works when there is unknown data in pre defined tags START
					if($isPreDefinedTagsApprovalGet == 1 AND $tagParameter == "pruefer"){
						$isPreDefinedTagsApproval = 1;
						$ckeckPApproval = 0;
						$tagsApproalStringForPrue = "";
						foreach ($approvalStraingArray as $prueferPkey => $prueferPval) {
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
								$aaoHyphenPriority = 0;
								$hyphenPrueferPriority = 0;
								$hyphenReferencePriority = 0;
								$moreThanOneTagStringPriority = 0;
								$prueferPriority = 10;
							}

						}else{
							$needApproval = 0;
						}
					}
					else if($isPreDefinedTagsApprovalGet == 1 AND $tagParameter == "reference"){
						$isPreDefinedTagsApproval = 1;
						$tagsApproalStringForRef = ""; 
						$ckeckRApproval = 0;
						foreach ($approvalStraingArray as $refKey => $refVal) {
							$refVal = trim($refVal);
							$tagsApproalStringForRef .= $refVal."{#^#}";
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
					}
					else if($isPreDefinedTagsApprovalGet == 1 AND $tagParameter == "multitag"){
						$isPreDefinedTagsApproval = 1;
						$tagsApproalStringForRef = ""; 
						$ckeckRApproval = 0;
						foreach ($approvalStraingArray as $refKey => $refVal) {
							$refVal = trim($refVal);
							$tagsApproalStringForRef .= $refVal."{#^#}";
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

						$ckeckPApproval = 0;
						$tagsApproalStringForPrue = "";
						foreach ($approvalStraingArray as $prueferPkey => $prueferPval) {
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

						if($ckeckPApproval == 1 OR $ckeckRApproval == 1){
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
					}
					// This section works when there is unknown data in pre defined tags END
				}
				else if($isCommaExist == 0 AND $isSemicolonExist == 0 AND $isHyphenExist == 0 AND $isAaoExist === false AND $isAaoWithoutSpaceExist === false AND $isAaoWithoutAnySpaceExist === false AND $isAaoWithoutFrontSpaceExist === false)
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

				if ($aLiteraturquellen) {
					$EntnommenAus = join ( "\n", $aLiteraturquellen );
				}

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
	            	$data['full_approval_string_when_hyphen'] = ( isset($approvalString) AND $approvalString != "" ) ? mysqli_real_escape_string($db, $approvalString) : null;
	            	// $data['full_approval_string_when_hyphen_unchanged'] = ( isset($approvalString) AND $approvalString != "" ) ? mysqli_real_escape_string($db, $approvalString) : null;
	            }else{
	            	$data['approval_string'] = ( isset($approvalString) AND $approvalString != "" ) ? mysqli_real_escape_string($db, $approvalString) : null;
	            	$data['full_approval_string_when_hyphen'] = null;
	            	// $data['full_approval_string_when_hyphen_unchanged'] = null;
	            }
	            $data['EntnommenAus'] = mysqli_real_escape_string($db, $EntnommenAus);
				$data['symptom_of_different_remedy'] = ( isset($symptomOfDifferentRemedy) AND $symptomOfDifferentRemedy != "" ) ? mysqli_real_escape_string($db, $symptomOfDifferentRemedy) : null;

				$symptomUpdateQuery="UPDATE temp_quelle_import_test SET need_approval = '".$data['need_approval']."', EntnommenAus = '".$data['EntnommenAus']."', symptom_of_different_remedy = NULLIF('".$data['symptom_of_different_remedy']."', ''), pruefer_priority = ".$prueferPriority.", remedy_priority = ".$remedyPriority.", part_of_symptom_priority = ".$partOfSymptomPriority.", reference_with_no_author_priority = ".$referenceWithNoAuthorPriority.", remedy_with_symptom_priority = ".$remedyWithSymptomPriority.", more_than_one_tag_string_priority = ".$moreThanOneTagStringPriority.", aao_hyphen_priority = ".$aaoHyphenPriority.", hyphen_pruefer_priority = ".$hyphenPrueferPriority.", hyphen_reference_priority = ".$hyphenReferencePriority.", approval_string = NULLIF('".$data['approval_string']."', ''), full_approval_string_when_hyphen = NULLIF('".$data['full_approval_string_when_hyphen']."', ''), reference_priority = ".$referencePriority.", is_rechecked = 1 WHERE id = '".$tempSymptomId."'";
				$db->query($symptomUpdateQuery);

				// If there is no more unskipped and unapproved data left than we will make the skipped data as unskipped START
				$unSkippedResult = mysqli_query($db, "SELECT id FROM temp_quelle_import_test WHERE need_approval = 1 AND is_skipped = 0 AND master_id = '".$masterId."'");
				$unSkippedRowCount = mysqli_num_rows($unSkippedResult);
				// echo "SELECT id FROM temp_quelle_import_test WHERE need_approval = 1 AND is_skipped = 0 AND master_id = '".$masterId."'";
				// echo $unSkippedRowCount;
				if( $unSkippedRowCount == 0){
					$makeUnskippedQuery="UPDATE temp_quelle_import_test SET is_skipped = 0 WHERE master_id = '".$masterId."'";
					$db->query($makeUnskippedQuery);
				}
				// If there is no more unskipped and unapproved data left than we will make the skipped data as unskipped END

				/* Pruefer Start */
            	if(!empty($prueferArray)){
        			foreach ($prueferArray as $pruKey => $pruVal) {
        				if(isset($prueferArray[$pruKey]['pruefer_id']) AND $prueferArray[$pruKey]['pruefer_id'] != ""){
        					$isOneUnknownElementInHyphen = (isset($prueferArray[$pruKey]['is_one_unknown_element_in_hyphen']) AND $prueferArray[$pruKey]['is_one_unknown_element_in_hyphen'] != "") ? $prueferArray[$pruKey]['is_one_unknown_element_in_hyphen'] : 0;
		            		$prueferQuery = "INSERT INTO temp_symptom_pruefer (symptom_id, pruefer_id, is_one_unknown_element_in_hyphen) VALUES ('".$tempSymptomId."', '".$prueferArray[$pruKey]['pruefer_id']."', '".$isOneUnknownElementInHyphen."')";
				            $db->query($prueferQuery);

				            if($data['need_approval'] == 0){
				            	// When a symptom needs no approval than storing it's pruefer details in temp_approved_pruefer for using in a. a. O. search process
				            	$tempApprovedPrueferQuery = "INSERT INTO temp_approved_pruefer (master_id, symptom_id, pruefer_id, approval_string) VALUES ('".$masterId."', '".$tempSymptomId."', '".$prueferArray[$pruKey]['pruefer_id']."', NULLIF('".$approvalString."', ''))";
				            	$db->query($tempApprovedPrueferQuery);  
				            }
        				}else{
        					if(isset($prueferArray[$pruKey]['suchname']) AND $prueferArray[$pruKey]['suchname'] != ""){
        						$prueferArray[$pruKey]['suchname'] = mysqli_real_escape_string($db, $prueferArray[$pruKey]['suchname']);
								$prueferInsertQuery = "INSERT INTO temp_pruefer (symptom_id, suchname) VALUES ('".$tempSymptomId."', '".$prueferArray[$pruKey]['suchname']."')";
        						$db->query($prueferInsertQuery);
        						$newPrueferId = mysqli_insert_id($db);
        						
        						$prueferQuery = "INSERT INTO temp_symptom_pruefer (symptom_id, pruefer_id, is_new) VALUES ('".$tempSymptomId."', '".$newPrueferId."', 1)";
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
        				if(isset($needApproval) AND $needApproval == 1){
        					$remedyArray[$remdKey]['name'] = mysqli_real_escape_string($db, $remedyArray[$remdKey]['name']);
        					if(isset($remedyArray[$remdKey]['remedy_id']) AND $remedyArray[$remdKey]['remedy_id'] != ""){
			            		$remedyQuery = "INSERT INTO temp_remedy (symptom_id, main_remedy_id, name) VALUES ('".$tempSymptomId."', '".$remedyArray[$remdKey]['remedy_id']."', '".$remedyArray[$remdKey]['name']."')";
					            $db->query($remedyQuery);
            				}else{

            					// $checkRemedyResult = mysqli_query($db, "SELECT remedy_id, name FROM temp_remedy where name = '".$remedyArray[$remdKey]['name']."'");
								// if(mysqli_num_rows($checkRemedyResult) < 1){
									$remedyQuery = "INSERT INTO temp_remedy (symptom_id, name, is_new) VALUES ('".$tempSymptomId."', '".$remedyArray[$remdKey]['name']."', 1)";
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
        				$remedyText = mysqli_real_escape_string($db, $remedyText);
						$symptomRemedyUpdateQuery="UPDATE temp_quelle_import_test SET Remedy = '".$remedyText."' WHERE id = '".$tempSymptomId."'";
						// mysqli_query($db, $symptomUpdateQuery);
						$db->query($symptomRemedyUpdateQuery);
					}
            	}
            	/* Remedy End */
            	/* Reference Start */
            	if(!empty($referenceArray)){
        			foreach ($referenceArray as $refKey => $refVal) {
        				if(isset($referenceArray[$refKey]['reference_id']) AND $referenceArray[$refKey]['reference_id'] != ""){
        					$isOneUnknownElementInHyphen = (isset($referenceArray[$refKey]['is_one_unknown_element_in_hyphen']) AND $referenceArray[$refKey]['is_one_unknown_element_in_hyphen'] != "") ? $referenceArray[$refKey]['is_one_unknown_element_in_hyphen'] : 0; 
		            		$referenceQuery = "INSERT INTO temp_symptom_reference (symptom_id, reference_id, is_one_unknown_element_in_hyphen) VALUES ('".$tempSymptomId."', '".$referenceArray[$refKey]['reference_id']."', '".$isOneUnknownElementInHyphen."')";
				            $db->query($referenceQuery);

				            if($data['need_approval'] == 0){
				            	// When a symptom needs no approval than storing it's reference details in temp_approved_reference for using in a. a. O. search process
				            	$tempApprovedReferenceQuery = "INSERT INTO temp_approved_reference (master_id, symptom_id, reference_id, approval_string) VALUES ('".$masterId."', '".$tempSymptomId."', '".$referenceArray[$refKey]['reference_id']."', NULLIF('".$approvalString."', ''))";
				            	$db->query($tempApprovedReferenceQuery); 
				            }
        				}else{
        					if(isset($referenceArray[$refKey]['full_reference']) AND $referenceArray[$refKey]['full_reference'] != ""){
        						$referenceArray[$refKey]['full_reference'] = mysqli_real_escape_string($db, $referenceArray[$refKey]['full_reference']);
        						$referenceArray[$refKey]['autor'] = mysqli_real_escape_string($db, $referenceArray[$refKey]['autor']);
        						$referenceArray[$refKey]['reference'] = mysqli_real_escape_string($db, $referenceArray[$refKey]['reference']);
								$referenceInsertQuery = "INSERT INTO temp_reference (symptom_id, full_reference, autor, reference) VALUES ('".$tempSymptomId."', '".$referenceArray[$refKey]['full_reference']."', '".$referenceArray[$refKey]['autor']."', '".$referenceArray[$refKey]['reference']."')";
        						$db->query($referenceInsertQuery);
        						$newReferenceId = mysqli_insert_id($db);
        						
        						$referenceQuery = "INSERT INTO temp_symptom_reference (symptom_id, reference_id, is_new) VALUES ('".$tempSymptomId."', '".$newReferenceId."', 1)";
				            	$db->query($referenceQuery);
        					}
        				}
        			}
            	}
            	/* Reference End */
				/* applying Rules on the approval string again it may get cleared already in this import process END */


				$returnVal = true;
			}
		}

		return $returnVal;
	}


	function ruleReimplementation($tempSymptomId, $approvalString, $masterId, $isPreDefinedTagsApprovalGet, $tagParameter){
		global $db;
		$returnVal = false;
		
		// Cleaning Previous Data From temp START
		$deleteTempRemedyQuery="DELETE FROM temp_remedy WHERE symptom_id = '".$tempSymptomId."'";
		$db->query($deleteTempRemedyQuery);

		$deleteTempPrueferQuery = "DELETE FROM temp_pruefer WHERE symptom_id = '".$tempSymptomId."'";
		$db->query($deleteTempPrueferQuery);

		$deleteTempSymptomPrueferQuery = "DELETE FROM temp_symptom_pruefer WHERE symptom_id = '".$tempSymptomId."'";
		$db->query($deleteTempSymptomPrueferQuery);

		$deleteTempReferenceQuery = "DELETE FROM temp_reference WHERE symptom_id = '".$tempSymptomId."'";
		$db->query($deleteTempReferenceQuery);

		$deleteTempSymptomReferenceQuery = "DELETE FROM temp_symptom_reference WHERE symptom_id = '".$tempSymptomId."'";
		$db->query($deleteTempSymptomReferenceQuery);

		// Deleting Temp Approved Reference
		$deleteTempApprovedReferenceQuery="DELETE FROM temp_approved_reference WHERE symptom_id = '".$tempSymptomId."'";
		$db->query($deleteTempApprovedReferenceQuery);

		// Deleting Temp Approved Pruefer
		$deleteTempApprovedPrueferQuery="DELETE FROM temp_approved_pruefer WHERE symptom_id = '".$tempSymptomId."'";
		$db->query($deleteTempApprovedPrueferQuery);
		// Cleaning Previous Data From temp END

		$aLiteraturquellen = array ();
		$EntnommenAus='';
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

		// Removing "No Author" form the approval string because i am adding this part for Rule 1 (B1) 
		// reference_with_no_author_priority 
		$lastBracketedString = str_replace("No Author,", "", $approvalString);
		$lastBracketedString = trim($lastBracketedString);
		// Checking the existance of , - . ; and , a. a. O. and , a.a.O.
		$isAaoExist = mb_strpos($lastBracketedString, ', a. a. O.');
		$isAaoWithoutSpaceExist = mb_strpos($lastBracketedString, ', a.a.O.');
		$isAaoWithoutAnySpaceExist = mb_strpos($lastBracketedString, ',a.a.O.');
		$isAaoWithoutFrontSpaceExist = mb_strpos($lastBracketedString, ',a. a. O.');
		$isCommaExist = mb_substr_count($lastBracketedString,",");
		$isHyphenExist = mb_substr_count($lastBracketedString,"-");
		$isDotExist = mb_substr_count($lastBracketedString,".");
		$isSemicolonExist = mb_substr_count($lastBracketedString,";");

		/* applying Rules on the approval string again it may get cleared already in this import process START */
		if($isPreDefinedTagsApprovalGet == 1){
			// This section works when there is unknown data in pre defined tags START
			$approvalStraingArray = explode("{#^#}", $lastBracketedString);
			if($isPreDefinedTagsApprovalGet == 1 AND $tagParameter == "pruefer"){
				$isPreDefinedTagsApproval = 1;
				$ckeckPApproval = 0;
				$tagsApproalStringForPrue = "";
				foreach ($approvalStraingArray as $prueferPkey => $prueferPval) {
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
						$aaoHyphenPriority = 0;
						$hyphenPrueferPriority = 0;
						$hyphenReferencePriority = 0;
						$moreThanOneTagStringPriority = 0;
						$prueferPriority = 10;
					}

				}else{
					$needApproval = 0;
				}
			}
			else if($isPreDefinedTagsApprovalGet == 1 AND $tagParameter == "reference"){
				$isPreDefinedTagsApproval = 1;
				$tagsApproalStringForRef = ""; 
				$ckeckRApproval = 0;
				foreach ($approvalStraingArray as $refKey => $refVal) {
					$refVal = trim($refVal);
					$tagsApproalStringForRef .= $refVal."{#^#}";
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
			}
			else if($isPreDefinedTagsApprovalGet == 1 AND $tagParameter == "multitag"){
				$isPreDefinedTagsApproval = 1;
				$tagsApproalStringForRef = ""; 
				$ckeckRApproval = 0;
				foreach ($approvalStraingArray as $refKey => $refVal) {
					$refVal = trim($refVal);
					$tagsApproalStringForRef .= $refVal."{#^#}";
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

				$ckeckPApproval = 0;
				$tagsApproalStringForPrue = "";
				foreach ($approvalStraingArray as $prueferPkey => $prueferPval) {
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

				if($ckeckPApproval == 1 OR $ckeckRApproval == 1){
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
			}
			// This section works when there is unknown data in pre defined tags END
		}
		else if($isCommaExist == 0 AND $isSemicolonExist == 0 AND $isHyphenExist == 0 AND $isAaoExist === false AND $isAaoWithoutSpaceExist === false AND $isAaoWithoutAnySpaceExist === false AND $isAaoWithoutFrontSpaceExist === false)
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

		if ($aLiteraturquellen) {
			$EntnommenAus = join ( "\n", $aLiteraturquellen );
		}

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
        	$data['full_approval_string_when_hyphen'] = ( isset($approvalString) AND $approvalString != "" ) ? mysqli_real_escape_string($db, $approvalString) : null;
        	// $data['full_approval_string_when_hyphen_unchanged'] = ( isset($approvalString) AND $approvalString != "" ) ? mysqli_real_escape_string($db, $approvalString) : null;
        }else{
        	$data['approval_string'] = ( isset($approvalString) AND $approvalString != "" ) ? mysqli_real_escape_string($db, $approvalString) : null;
        	$data['full_approval_string_when_hyphen'] = null;
        	// $data['full_approval_string_when_hyphen_unchanged'] = null;
        }
	    $data['EntnommenAus'] = mysqli_real_escape_string($db, $EntnommenAus);
		$data['symptom_of_different_remedy'] = ( isset($symptomOfDifferentRemedy) AND $symptomOfDifferentRemedy != "" ) ? mysqli_real_escape_string($db, $symptomOfDifferentRemedy) : null;

		$symptomUpdateQuery="UPDATE temp_quelle_import_test SET need_approval = '".$data['need_approval']."', is_skipped = 0, EntnommenAus = '".$data['EntnommenAus']."', symptom_of_different_remedy = NULLIF('".$data['symptom_of_different_remedy']."', ''), pruefer_priority = ".$prueferPriority.", remedy_priority = ".$remedyPriority.", part_of_symptom_priority = ".$partOfSymptomPriority.", reference_with_no_author_priority = ".$referenceWithNoAuthorPriority.", remedy_with_symptom_priority = ".$remedyWithSymptomPriority.", more_than_one_tag_string_priority = ".$moreThanOneTagStringPriority.", aao_hyphen_priority = ".$aaoHyphenPriority.", hyphen_pruefer_priority = ".$hyphenPrueferPriority.", hyphen_reference_priority = ".$hyphenReferencePriority.", reference_priority = ".$referencePriority.", direct_order_priority = ".$directOrderPriority.", approval_string = NULLIF('".$data['approval_string']."', ''), full_approval_string_when_hyphen = NULLIF('".$data['full_approval_string_when_hyphen']."', ''), is_rechecked = 1 WHERE id = '".$tempSymptomId."'";
		$db->query($symptomUpdateQuery);

		// If there is no more unskipped and unapproved data left than we will make the skipped data as unskipped START
		$unSkippedResult = mysqli_query($db, "SELECT id FROM temp_quelle_import_test WHERE need_approval = 1 AND is_skipped = 0 AND master_id = '".$masterId."'");
		$unSkippedRowCount = mysqli_num_rows($unSkippedResult);
		// echo "SELECT id FROM temp_quelle_import_test WHERE need_approval = 1 AND is_skipped = 0 AND master_id = '".$masterId."'";
		// echo $unSkippedRowCount;
		if( $unSkippedRowCount == 0){
			$makeUnskippedQuery="UPDATE temp_quelle_import_test SET is_skipped = 0 WHERE master_id = '".$masterId."'";
			$db->query($makeUnskippedQuery);
		}
		// If there is no more unskipped and unapproved data left than we will make the skipped data as unskipped END

		/* Pruefer Start */
		if(!empty($prueferArray)){
			foreach ($prueferArray as $pruKey => $pruVal) {
				if(isset($prueferArray[$pruKey]['pruefer_id']) AND $prueferArray[$pruKey]['pruefer_id'] != ""){
					$isOneUnknownElementInHyphen = (isset($prueferArray[$pruKey]['is_one_unknown_element_in_hyphen']) AND $prueferArray[$pruKey]['is_one_unknown_element_in_hyphen'] != "") ? $prueferArray[$pruKey]['is_one_unknown_element_in_hyphen'] : 0;
	        		$prueferQuery = "INSERT INTO temp_symptom_pruefer (symptom_id, pruefer_id, is_one_unknown_element_in_hyphen) VALUES ('".$tempSymptomId."', '".$prueferArray[$pruKey]['pruefer_id']."', '".$isOneUnknownElementInHyphen."')";
		            $db->query($prueferQuery);

		            if($data['need_approval'] == 0){
		            	// When a symptom needs no approval than storing it's pruefer details in temp_approved_pruefer for using in a. a. O. search process
		            	$tempApprovedPrueferQuery = "INSERT INTO temp_approved_pruefer (master_id, symptom_id, pruefer_id, approval_string) VALUES ('".$masterId."', '".$tempSymptomId."', '".$prueferArray[$pruKey]['pruefer_id']."', NULLIF('".$approvalString."', ''))";
		            	$db->query($tempApprovedPrueferQuery);  
		            }
				}else{
					if(isset($prueferArray[$pruKey]['suchname']) AND $prueferArray[$pruKey]['suchname'] != ""){
						$prueferArray[$pruKey]['suchname'] = mysqli_real_escape_string($db, $prueferArray[$pruKey]['suchname']);
						$prueferInsertQuery = "INSERT INTO temp_pruefer (symptom_id, suchname) VALUES ('".$tempSymptomId."', '".$prueferArray[$pruKey]['suchname']."')";
						$db->query($prueferInsertQuery);
						$newPrueferId = mysqli_insert_id($db);
						
						$prueferQuery = "INSERT INTO temp_symptom_pruefer (symptom_id, pruefer_id, is_new) VALUES ('".$tempSymptomId."', '".$newPrueferId."', 1)";
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
	            		$remedyQuery = "INSERT INTO temp_remedy (symptom_id, main_remedy_id, name) VALUES ('".$tempSymptomId."', '".$remedyArray[$remdKey]['remedy_id']."', '".$remedyArray[$remdKey]['name']."')";
			            $db->query($remedyQuery);
					}else{

						// $checkRemedyResult = mysqli_query($db, "SELECT remedy_id, name FROM temp_remedy where name = '".$remedyArray[$remdKey]['name']."'");
						// if(mysqli_num_rows($checkRemedyResult) < 1){
							$remedyQuery = "INSERT INTO temp_remedy (symptom_id, name, is_new) VALUES ('".$tempSymptomId."', '".$remedyArray[$remdKey]['name']."', 1)";
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
				$symptomRemedyUpdateQuery="UPDATE temp_quelle_import_test SET Remedy = '".$remedyText."' WHERE id = '".$tempSymptomId."'";
				// mysqli_query($db, $symptomUpdateQuery);
				$db->query($symptomRemedyUpdateQuery);
			}
		}
		/* Remedy End */
		/* Reference Start */
		if(!empty($referenceArray)){
			foreach ($referenceArray as $refKey => $refVal) {
				if(isset($referenceArray[$refKey]['reference_id']) AND $referenceArray[$refKey]['reference_id'] != ""){
					$isOneUnknownElementInHyphen = (isset($referenceArray[$refKey]['is_one_unknown_element_in_hyphen']) AND $referenceArray[$refKey]['is_one_unknown_element_in_hyphen'] != "") ? $referenceArray[$refKey]['is_one_unknown_element_in_hyphen'] : 0;
	        		$referenceQuery = "INSERT INTO temp_symptom_reference (symptom_id, reference_id, is_one_unknown_element_in_hyphen) VALUES ('".$tempSymptomId."', '".$referenceArray[$refKey]['reference_id']."', '".$isOneUnknownElementInHyphen."')";
		            $db->query($referenceQuery);

		            if($data['need_approval'] == 0){
		            	// When a symptom needs no approval than storing it's reference details in temp_approved_reference for using in a. a. O. search process
		            	$tempApprovedReferenceQuery = "INSERT INTO temp_approved_reference (master_id, symptom_id, reference_id, approval_string) VALUES ('".$masterId."', '".$tempSymptomId."', '".$referenceArray[$refKey]['reference_id']."', NULLIF('".$approvalString."', ''))";
		            	$db->query($tempApprovedReferenceQuery); 
		            }
				}else{
					if(isset($referenceArray[$refKey]['full_reference']) AND $referenceArray[$refKey]['full_reference'] != ""){
						$referenceArray[$refKey]['full_reference'] = mysqli_real_escape_string($db, $referenceArray[$refKey]['full_reference']);
						$referenceArray[$refKey]['autor'] = mysqli_real_escape_string($db, $referenceArray[$refKey]['autor']);
						$referenceArray[$refKey]['reference'] = mysqli_real_escape_string($db, $referenceArray[$refKey]['reference']);
						$referenceInsertQuery = "INSERT INTO temp_reference (symptom_id, full_reference, autor, reference) VALUES ('".$tempSymptomId."', '".$referenceArray[$refKey]['full_reference']."', '".$referenceArray[$refKey]['autor']."', '".$referenceArray[$refKey]['reference']."')";
						$db->query($referenceInsertQuery);
						$newReferenceId = mysqli_insert_id($db);
						
						$referenceQuery = "INSERT INTO temp_symptom_reference (symptom_id, reference_id, is_new) VALUES ('".$tempSymptomId."', '".$newReferenceId."', 1)";
		            	$db->query($referenceQuery);
					}
				}
			}
		}
		/* Reference End */
		/* applying Rules on the approval string again it may get cleared already in this import process END */


		$returnVal = true;
		return $returnVal;
	}  
?>