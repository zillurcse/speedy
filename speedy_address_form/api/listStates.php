<?php
	
	#-> NO DIRECT ACCESS TO THIS FILE 
	define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'); 
	if ( !IS_AJAX ) 
					{ exit(''); }


	#-> Functions, libraries and languages
	include('../functionsAddressForm.php'); 
	include('../libraryAddressForm.php');
	include('../languages.php'); 
	$libraryName = '../'.'libraryAddressForm'.$language.'.php'; 
	include($libraryName);

	$search = '';
	if ( isset($_GET['search']) ) { $search = $_GET['search']; }
	if ( !$search ) { return; }

	$search = urldecode($search);
	$search = validateInputDataAddressForm($search);

	$countryId = $defaultCountryId; 
	if ( isset($_GET['countryId']) )
					{ $countryId = $_GET['countryId']; }
	$countryId = validateIDAddressForm($countryId);

	#-> Credentials
	include($speedyCredentialsPath.'speedyCredentials.php');
	$username = $credentials['username'];
	$password = $credentials['password'];

	#-> API url
	$apiURL = $apiBaseURL."location/state/";

	#-> The JSON data.
	$jsonData = array(
		'userName' => $username,
		'password' => $password,
		'language' => $language,
		'countryId' => $countryId,
		'name' => $search
	);

	#-> API Request
	$jsonResponse = apiRequest($apiURL, $jsonData);			
	if ( !$jsonResponse ) { exit("ERROR"); }
	$jsonResponse = json_decode($jsonResponse, true);

	
	if ( isset($jsonResponse['error']) )
					{
					$error = $jsonResponse['error']['message'];
					echo "$error";
					return($error);
					}

	$statesArray = $jsonResponse['states'];

	$responseArray = array();

	$searchedFieldsArray = array('id', 'name', 'nameEn', 'stateAlpha', 'countryId');
	
	#-> For each row of the result
	foreach ( $statesArray as $singleArray )
					{
					foreach ( $searchedFieldsArray as $constant )
									{
									${$constant} = '';
									if ( isset($singleArray[$constant]) )
													{
													${$constant} = $singleArray[$constant];
													}
									}

					#-> Replacment of some variables depending on the language.
					if ( $language == 'EN' )
									{
									$name = $nameEn;
									}

					$responseArray[] = array(
							'value' => $id, 
							'label' => $name,
							'nameEn' => $nameEn,
							'stateAlpha' => $stateAlpha,
							'countryId' => $countryId,
							);
					//echo "$name|$id\n";
					}

	echo json_encode($responseArray);	
		
?>