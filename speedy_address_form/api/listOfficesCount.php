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

	if ( !isset($_GET['siteId']) || !isset($_GET['countryId']) )
			{ exit('.'); }

	$requestType = '';
	if ( isset($_GET['requestType']) )
					{ $requestType = $_GET['requestType']; }

	$officesCount = 0;
	$error = '';

	$countryId = 100; 
	if ( isset($_GET['countryId']) )
					{ $countryId = $_GET['countryId']; }
	$countryId = validateIDAddressForm($countryId);

	$siteId = $_GET['siteId']; 
	$siteId = validateIDAddressForm($siteId);

	#-> Credentials
	include($speedyCredentialsPath.'speedyCredentials.php');
	$username = $credentials['username'];
	$password = $credentials['password'];

	#-> API url
	$apiURL = $apiBaseURL.'location/office/';

	#-> The JSON data.
	$jsonData = array(
		'userName' => $username,
		'password' => $password,
		'countryId' => $countryId,
		'siteId' => $siteId,
	);


	#-> API Request
	$jsonResponse = apiRequest($apiURL, $jsonData);			
	if ( !$jsonResponse )
					{ exit("ERROR"); }

	$jsonResponse = json_decode($jsonResponse, true);

	
	if ( isset($jsonResponse['error']) )
					{
					$error = $jsonResponse['error']['message'];
					}
	else
					{	
					$officesArray = $jsonResponse['offices'];
					#-> For each office
					foreach ( $officesArray as $singleArray )
									{
									$officesCount = $officesCount + 1;
									}
					}	


	echo json_encode( 
			array('officesCount' => $officesCount, 'error' => $error) 
	);
	
?>