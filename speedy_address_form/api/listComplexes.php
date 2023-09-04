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

	$siteId = '';
	if ( isset($_GET['siteId']) )
					{ $siteId = $_GET['siteId']; }
	$siteId = validateIDAddressForm($siteId);
	
	#-> Credentials
	include($speedyCredentialsPath.'speedyCredentials.php');
	$username = $credentials['username'];
	$password = $credentials['password'];

	#-> API url
	$apiURL = $apiBaseURL.'location/complex/';

	#-> The JSON data.
	$jsonData = array(
		'userName' => $username,
		'password' => $password,
		'siteId' => $siteId,
		'language' => $language,
		'name' => $search,
	);

	#-> API Request
	$jsonResponse = apiRequest($apiURL, $jsonData);			
	
	if ( !$jsonResponse ) { exit('ERROR in Quarters'); }

	$jsonResponse = json_decode($jsonResponse, true);
	
	$quartersArray = $jsonResponse['complexes'];
	$searchedFieldsArray = array('id', 'siteId', 'type', 'typeEn', 'name', 'nameEn', 'actualName', 'actualNameEn', 'actualId');
	
	$responseArray = array();

	#-> For each quarter/complex
	foreach ( $quartersArray as $singleArray )
					{
					foreach ( $searchedFieldsArray as $constant )
									{
									#-> If is set a type
									if ( isset($singleArray[$constant]) )
													{
													${$constant} = $singleArray[$constant];
													}
									else
													{
													${$constant} = '';
													}
									//echo "$constant: ${$constant}<br>";
									}

               #-> Replacment of some variables depending on the language.
					if ( $language == 'EN' )
									{
									$type = $typeEn;
									$name = $nameEn;
									$actualName = $actualNameEn;
									}

					$fullQuarterName = "$type $name";
					#-> If there is a new name
					if ( $actualName != '' )
									{
									$fullQuarterName .= " ($textNewName $actualName)";
									}

					$responseArray[] = array(
							'value' => $name, 
							'label' => $fullQuarterName,
							'id' => $id,
							'type' => $type,
							'siteId' => $siteId,
							'actualId' => $actualId
							);
					}
	
	echo json_encode($responseArray);	

?>