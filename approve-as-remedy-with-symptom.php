<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'config.php';
$date = date("Y-m-d H:i:s"); 
include 'functions.php';

if(isset($_POST['no']) AND $_POST['no'] == "No"){
	try {
	    // First of all, let's begin a transaction
	    $db->begin_transaction();

	    $parameterString = "";
		$symptomUpdateQuery="UPDATE temp_quelle_import_test SET remedy_with_symptom_priority = 0 WHERE id = '".$_POST['symptom_id']."'";
		$db->query($symptomUpdateQuery);

		$deleteTempRemedyQuery="DELETE FROM temp_remedy WHERE symptom_id = '".$_POST['symptom_id']."'";
		$db->query($deleteTempRemedyQuery);

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
else if(isset($_POST['yes']) AND $_POST['yes'] == "Yes"){
	$parameterString = "";

	try {
	    // First of all, let's begin a transaction
	    $db->begin_transaction();

		if(isset($_POST['approval_string']) AND $_POST['approval_string'] != ""){

			$workingString = trim($_POST['approval_string']);

			/* Extracting Remedy and Symptom text Separatly START */
			$similarRemedyString = "";
			$similarSymptomString = "";

			if (mb_strpos($workingString, ',') !== false) 
				$separator = ",";
			else
				$separator = ";";
			$isCommaExist = mb_substr_count($workingString,",");
			$isSemicolonExist = mb_substr_count($workingString,";");
			$commaFirstOccurrence = mb_stripos ( $workingString, $separator );
			$beforeTheCommaString = trim( mb_substr ( $workingString, 0, $commaFirstOccurrence ) );
			$afterTheCommaString = trim( ltrim( mb_substr ( $workingString, $commaFirstOccurrence ), $separator ));
			$beforeTheCommaStringInArray = explode(" ", $beforeTheCommaString);
			$afterTheCommaStringInArray = explode(" ", $afterTheCommaString);

			$isDotExistInBeforeTheCommaString = mb_substr_count($beforeTheCommaString,".");
			$isDotExistInAfterTheCommaString = mb_substr_count($afterTheCommaString,".");
			$upperCaseCheckInBeforeTheCommaStr = isThereAnyUppercase($beforeTheCommaString);
			$upperCaseCheckInAfterTheCommaStr = isThereAnyUppercase($afterTheCommaString);

			if($isCommaExist == 1 OR $isSemicolonExist == 1)
			{
				// Only one comma or semicolon in full breketed string START
				if($isDotExistInBeforeTheCommaString != 0 AND count($afterTheCommaStringInArray) > 1)
				{
					$similarRemedyString = $beforeTheCommaString;
					$similarSymptomString = $afterTheCommaString;
				}
				else if ($isDotExistInAfterTheCommaString != 0 AND count($beforeTheCommaStringInArray) > 1) 
				{
					$similarRemedyString = $afterTheCommaString;
					$similarSymptomString = $beforeTheCommaString;
				}
				else if (count($beforeTheCommaStringInArray) > 1 AND $upperCaseCheckInBeforeTheCommaStr === false AND $isDotExist == 0) 
				{
					$similarRemedyString = $afterTheCommaString;
					$similarSymptomString = $beforeTheCommaString;
				}
				else if (count($afterTheCommaStringInArray) > 1 AND $upperCaseCheckInAfterTheCommaStr === false AND $isDotExist == 0) 
				{
					$similarRemedyString = $beforeTheCommaString;
					$similarSymptomString = $afterTheCommaString;
				}
			}
			/* Extracting Remedy and Symptom text Separatly END */

			if($similarRemedyString != "" AND $similarSymptomString != ""){
				// Inserting remedy in Remedy table if it is not already there
				$cleanRemedyString = (mb_substr ( $similarRemedyString, mb_strlen ( $similarRemedyString ) - 1, 1 ) == '.') ? $similarRemedyString : $similarRemedyString.'.';
				$remedyReturnArr = lookupRemedy($cleanRemedyString);
				$similarRemedyString = mysqli_real_escape_string($db, $similarRemedyString);
				$workingString = mysqli_real_escape_string($db, $workingString);
				if(isset($remedyReturnArr['need_approval']) AND $remedyReturnArr['need_approval'] == 1){
					$remedyQuery = "INSERT INTO remedy (name, ersteller_datum) VALUES ('".$similarRemedyString."', '".$date."')";
					$db->query($remedyQuery);
				}

				$symptomUpdateQuery="UPDATE temp_quelle_import_test SET Remedy = '".$similarRemedyString."', symptom_of_different_remedy = '".$workingString."', part_of_symptom_priority = 0, remedy_priority = 0, pruefer_priority = 0, reference_with_no_author_priority = 0, remedy_with_symptom_priority = 0, more_than_one_tag_string_priority = 0, aao_hyphen_priority = 0, hyphen_pruefer_priority = 0, hyphen_reference_priority = 0, reference_priority = 0, direct_order_priority = 0, need_approval = 0 WHERE id = '".$_POST['symptom_id']."'";
				$db->query($symptomUpdateQuery);

				// Deleteing the temp remidies because they are no longer need if it is taking Direct Order.
			    $deleteTempRemedyQuery="DELETE FROM temp_remedy WHERE symptom_id = '".$_POST['symptom_id']."'";
				$db->query($deleteTempRemedyQuery);

				// Deleteing the temp pruefers because they are no longer need if it is taking Direct Order.
				$deleteTempPrueferQuery = "DELETE FROM temp_pruefer WHERE symptom_id = '".$_POST['symptom_id']."'";
				$db->query($deleteTempPrueferQuery);

				$deleteTempSymptomPrueferQuery = "DELETE FROM temp_symptom_pruefer WHERE symptom_id = '".$_POST['symptom_id']."'";
				$db->query($deleteTempSymptomPrueferQuery);

				$deleteTempReferenceQuery = "DELETE FROM temp_reference WHERE symptom_id = '".$_POST['symptom_id']."'";
				$db->query($deleteTempReferenceQuery);

				$deleteTempSymptomReferenceQuery = "DELETE FROM temp_symptom_reference WHERE symptom_id = '".$_POST['symptom_id']."'";
				$db->query($deleteTempSymptomReferenceQuery);
			}
			
		}

		// If there is no more unskipped and unapproved data left than we will make the skipped data as unskipped.
		$unSkippedResult = mysqli_query($db, "SELECT * FROM temp_quelle_import_test Where need_approval = 1 AND is_skipped = 0 AND master_id = '".$_POST['master_id']."'");
		$unSkippedRowCount = mysqli_num_rows($unSkippedResult);
		if( $unSkippedRowCount > 0){
			if(isset($_POST['master_id']) AND $_POST['master_id'] != "")
				$parameterString = "?master=".$_POST['master_id'];
		}else{
			// In this case the rediraction URL will be - Location: $baseUrl 
			$makeUnskippedQuery="UPDATE temp_quelle_import_test SET is_skipped = 0 WHERE master_id = '".$_POST['master_id']."'";
			$db->query($makeUnskippedQuery);

			$leftToApproveResult = mysqli_query($db, "SELECT * FROM temp_quelle_import_test Where need_approval = 1 AND master_id = '".$_POST['master_id']."'");
			$leftToApproveRowCount = mysqli_num_rows($leftToApproveResult);
			if( $leftToApproveRowCount == 0){
				if(isset($_POST['master_id']) AND $_POST['master_id'] != "")
					$parameterString = "?master=".$_POST['master_id'];
			}
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
}
else if(isset($_POST['do']) AND $_POST['do'] == "DO"){
	try {
	    // First of all, let's begin a transaction
	    $db->begin_transaction();

	    $parameterString = "";

	    // Deleteing the temp remidies because they are no longer need if it is taking Direct Order.
	    $deleteTempRemedyQuery="DELETE FROM temp_remedy WHERE symptom_id = '".$_POST['symptom_id']."'";
		$db->query($deleteTempRemedyQuery);

		// Deleteing the temp pruefers because they are no longer need if it is taking Direct Order.
		$deleteTempPrueferQuery = "DELETE FROM temp_pruefer WHERE symptom_id = '".$_POST['symptom_id']."'";
		$db->query($deleteTempPrueferQuery);

		$deleteTempSymptomPrueferQuery = "DELETE FROM temp_symptom_pruefer WHERE symptom_id = '".$_POST['symptom_id']."'";
		$db->query($deleteTempSymptomPrueferQuery);

		$deleteTempReferenceQuery = "DELETE FROM temp_reference WHERE symptom_id = '".$_POST['symptom_id']."'";
		$db->query($deleteTempReferenceQuery);

		$deleteTempSymptomReferenceQuery = "DELETE FROM temp_symptom_reference WHERE symptom_id = '".$_POST['symptom_id']."'";
		$db->query($deleteTempSymptomReferenceQuery);

		$symptomUpdateQuery="UPDATE temp_quelle_import_test SET direct_order_priority = 11 WHERE id = '".$_POST['symptom_id']."'";
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
	
}else if(isset($_POST['later']) AND $_POST['later'] == "Later"){
	try {
	    // First of all, let's begin a transaction
	    $db->begin_transaction();

	    $parameterString = "";
		$symptomUpdateQuery="UPDATE temp_quelle_import_test SET is_skipped = 1, is_rechecked = 0 WHERE id = '".$_POST['symptom_id']."'";
		$db->query($symptomUpdateQuery);

		// If there is no more unskipped and unapproved data left than we will make the skipped data as unskipped.
		$unSkippedResult = mysqli_query($db, "SELECT * FROM temp_quelle_import_test Where need_approval = 1 AND is_skipped = 0 AND master_id = '".$_POST['master_id']."'");
		$unSkippedRowCount = mysqli_num_rows($unSkippedResult);
		if( $unSkippedRowCount > 0){
			if(isset($_POST['master_id']) AND $_POST['master_id'] != "")
				$parameterString = "?master=".$_POST['master_id'];
		}else{
			// In this case the rediraction URL will be - Location: $baseUrl 
			$makeUnskippedQuery="UPDATE temp_quelle_import_test SET is_skipped = 0 WHERE master_id = '".$_POST['master_id']."'";
			$db->query($makeUnskippedQuery);

			$leftToApproveResult = mysqli_query($db, "SELECT * FROM temp_quelle_import_test Where need_approval = 1 AND master_id = '".$_POST['master_id']."'");
			$leftToApproveRowCount = mysqli_num_rows($leftToApproveResult);
			if( $leftToApproveRowCount == 0){
				if(isset($_POST['master_id']) AND $_POST['master_id'] != "")
					$parameterString = "?master=".$_POST['master_id'];
			}
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
}else if(isset($_POST['reset_current']) AND $_POST['reset_current'] == "Reset"){
	try {
	    // First of all, let's begin a transaction
	    $db->begin_transaction();

	    $parameterString = "";
	    $unApprovedResult = mysqli_query($db, "SELECT * FROM temp_quelle_import_test WHERE id = '".$_POST['symptom_id']."'");
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

			ruleReimplementation($_POST['symptom_id'], $_POST['approval_string'], $_POST['master_id'], $_POST['is_pre_defined_tags_approval'], $tagParameter);
		}	

		// If there is no more unskipped and unapproved data left than we will make the skipped data as unskipped.
		$unSkippedResult = mysqli_query($db, "SELECT id FROM temp_quelle_import_test Where need_approval = 1 AND is_skipped = 0 AND master_id = '".$_POST['master_id']."'");
		$unSkippedRowCount = mysqli_num_rows($unSkippedResult);
		if( $unSkippedRowCount > 0){
			if(isset($_POST['master_id']) AND $_POST['master_id'] != "")
				$parameterString = "?master=".$_POST['master_id'];
		}else{
			// In this case the rediraction URL will be - Location: $baseUrl 
			$makeUnskippedQuery="UPDATE temp_quelle_import_test SET is_skipped = 0 WHERE master_id = '".$_POST['master_id']."'";
			$db->query($makeUnskippedQuery);

			$leftToApproveResult = mysqli_query($db, "SELECT id FROM temp_quelle_import_test Where need_approval = 1 AND master_id = '".$_POST['master_id']."'");
			$leftToApproveRowCount = mysqli_num_rows($leftToApproveResult);
			if( $leftToApproveRowCount == 0){
				if(isset($_POST['master_id']) AND $_POST['master_id'] != "")
					$parameterString = "?master=".$_POST['master_id'];
			}
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
}else if(isset($_POST['back_to_previous']) AND $_POST['back_to_previous'] == "Back to previous"){
	try {
	    // First of all, let's begin a transaction
	    $db->begin_transaction();

	    $parameterString = "";
		$unApprovedResult = mysqli_query($db, "SELECT id, approval_string FROM temp_quelle_import_test WHERE need_approval = 1 AND master_id = '".$_POST['master_id']."' AND id < ".$_POST['symptom_id']." ORDER BY id DESC LIMIT 1");
		if( mysqli_num_rows($unApprovedResult) > 0){
			$unApprovedRow = mysqli_fetch_assoc($unApprovedResult);
			if($unApprovedRow['approval_string'] != "")
				ruleReimplementation($unApprovedRow['id'], $unApprovedRow['approval_string'], $_POST['master_id']);
		}

		// If there is no more unskipped and unapproved data left than we will make the skipped data as unskipped.
		$unSkippedResult = mysqli_query($db, "SELECT id FROM temp_quelle_import_test Where need_approval = 1 AND is_skipped = 0 AND master_id = '".$_POST['master_id']."'");
		$unSkippedRowCount = mysqli_num_rows($unSkippedResult);
		if( $unSkippedRowCount > 0){
			if(isset($_POST['master_id']) AND $_POST['master_id'] != "")
				$parameterString = "?master=".$_POST['master_id'];
		}else{
			// In this case the rediraction URL will be - Location: $baseUrl 
			$makeUnskippedQuery="UPDATE temp_quelle_import_test SET is_skipped = 0 WHERE master_id = '".$_POST['master_id']."'";
			$db->query($makeUnskippedQuery);

			$leftToApproveResult = mysqli_query($db, "SELECT id FROM temp_quelle_import_test Where need_approval = 1 AND master_id = '".$_POST['master_id']."'");
			$leftToApproveRowCount = mysqli_num_rows($leftToApproveResult);
			if( $leftToApproveRowCount == 0){
				if(isset($_POST['master_id']) AND $_POST['master_id'] != "")
					$parameterString = "?master=".$_POST['master_id'];
			}
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
}
?>