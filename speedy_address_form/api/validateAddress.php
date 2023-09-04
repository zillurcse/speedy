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

	#-> Initialize variables
   $validationError = '';
	$validationMessage = '';

   /*
   $constantsArray = array('addressType', 'countryId', 'stateId', 'siteId', 'siteType', 'siteName', 'postCode', 'complexId', 'complexType', 'complexName',
	'streetId', 'streetType', 'streetName', 'streetNo', 'blockNo', 'entranceNo', 'floorNo', 'apartmentNo', 
	'poiId', 'addressNote', 'addressLine1', 'addressLine2');
   */
   
   $addressType = (isset($_GET['addressType'])) ? $_GET['addressType'] : 1;
   if ( $addressType == 2 )
               {
               $constantsArray = array('countryId', 'stateId', 'siteName', 'postCode', 'addressNote', 'addressLine1', 'addressLine2');
               }
	else
               {
               $constantsArray = array('countryId', 'siteId', 'siteType', 'siteName', 'postCode', 'complexId', 'complexType', 'complexName',
					'streetId', 'streetType', 'streetName', 'streetNo', 'blockNo', 'entranceNo', 'floorNo', 'apartmentNo', 
					'poiId', 'addressNote');
               }
               
	$addressArray = array();
	foreach ( $constantsArray as $singleConstant )
					{
					${$singleConstant} = '';
					if ( isset($_GET[$singleConstant]) )
									{ 
									${$singleConstant} = $_GET[$singleConstant]; 
									}
									
					#-> Array with address components				
					$addressArray[$singleConstant] = ${$singleConstant};
					}
	
	#-> Credentials
	include($speedyCredentialsPath.'speedyCredentials.php');
	$username = $credentials['username'];
	$password = $credentials['password'];

	#-> API url
	$apiURL = $apiBaseURL.'validation/address/';

	#-> The JSON data.
	$jsonData = array(
		'userName' => $username,
		'password' => $password,
		'language' => $language,
		'address' => $addressArray
	);
	//echo "<pre align=left>"; print_r($jsonData);echo "</pre>";

	#-> Function with API request
	$jsonResponse = apiRequest($apiURL, $jsonData);			
	if ( !$jsonResponse )
					{ exit("ERROR"); }

	$jsonResponse = json_decode($jsonResponse, true);
	//echo "<pre align=left>"; print_r($jsonResponse);echo "</pre>";
	
	#-> If is defined an error
	if ( isset($jsonResponse['error']) )
					{
					$validationError = $jsonResponse['error']['message'];
					/*
					if ( isset($jsonResponse['error']['context']) )
									{ $validationError .= ' '.$jsonResponse['error']['context']; }
					*/
					}
	else
					{	
					$validationMessage = $jsonResponse['valid'];
					}	

	#-> Return the result
	echo json_encode( 
			array('validationMessage' => $validationMessage, 'validationError' => $validationError) 
	);
	
?>