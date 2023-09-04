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

   
	#-> Credentials
	include($speedyCredentialsPath.'speedyCredentials.php');
	$username = $credentials['username'];
	$password = $credentials['password'];

	$apiURL = $apiBaseURL.'location/country/';

	//Initiate cURL.
	$curl = curl_init($apiURL);
	
	//The JSON data.
	$jsonData = array(
		'userName' => $username,
		'password' => $password,
		'language' => $language,
		'name' => 'BULGARIA'
	);
	
	#-> API Request
	$jsonResponse = apiRequest($apiURL, $jsonData);	
	if ( !$jsonResponse ) { exit('ERROR'); }

	$jsonResponse = json_decode($jsonResponse, true);


	$responseArray = array();
   $defaultSiteType = '';
	$complexTypesString = '';
   $streetTypesString = '';


	if ( isset($jsonResponse['error']) )
					{
					$error = $jsonResponse['error']['message'];
					echo "$error";
					return($error);
					}
	else
					{

					$streetTypes = $jsonResponse['countries'][0]['streetTypes'];
					$complexTypes = $jsonResponse['countries'][0]['complexTypes'];
               
               $inputVarsArray = array(
                  'complexTypes' => $complexTypes,
                  'streetTypes' => $streetTypes,
                  'language' => $language,
                  'countryId' => 100,
                  'addressDetailsTypesArray' => $addressDetailsTypesArray
               );

               #-> Convert types to strings
               list($defaultSiteType, $complexTypesString, $streetTypesString) = convertTypesToStrings($inputVarsArray);
					}



	$responseArray = array(
      'defaultSiteType' => $defaultSiteType,
      'complexTypesString' => $complexTypesString,
      'streetTypesString' => $streetTypesString
   );

	#-> Return response
	echo json_encode($responseArray);	
	
?>