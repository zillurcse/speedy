<?php
	
	#-> NO DIRECT ACCESS TO THIS FILE 
	define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'); 
	if ( !IS_AJAX ) 
					{ exit('.'); }


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
	$apiURL = $apiBaseURL.'location/block/';

	#-> The JSON data.
	$jsonData = array(
		'userName' => $username,
		'password' => $password,
		'siteId' => $siteId,
		'language' => $language,
		'name' => $search,
	);
	//echo "<pre>"; print_r($jsonData); echo "</pre>";	

	#-> API Request
	$jsonResponse = apiRequest($apiURL, $jsonData);			
	
	if ( !$jsonResponse )
					{ exit("ERROR"); }

	$jsonResponse = json_decode($jsonResponse, true);
	//print_r($jsonResponse);
	
	if ( isset($jsonResponse['error']) )
					{
					$error = $jsonResponse['error']['message'];
					echo "$error";
					return($error);
					}
	
	$blocksArray = $jsonResponse['blocks'];
	$searchedFieldsArray = array('name', 'nameEn', 'siteId');
	
	$responseArray = array();

	#-> For each block
	foreach ( $blocksArray as $singleArray )
					{
					foreach ( $searchedFieldsArray as $constant )
									{
									${$constant} = $singleArray[$constant];
									}

					#-> Replacment of some variables depending on the language.
					if ( $language == 'EN' )
									{
									$name = $nameEn;
									}

					$responseArray[] = array(
							'value' => $name, 
							'label' => $name,
							'siteId' => $siteId
							);
					}
	
	echo json_encode($responseArray);	
	
?>