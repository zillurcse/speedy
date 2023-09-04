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
	
	#-> Credentials
	include($speedyCredentialsPath.'speedyCredentials.php');
	$username = $credentials['username'];
	$password = $credentials['password'];

	#-> API url
	$apiURL = $apiBaseURL.'location/country/';

	#-> Initiate cURL.
	$curl = curl_init($apiURL);
	
	#-> The JSON data.
	$jsonData = array(
		'userName' => $username,
		'password' => $password,
		'language' => $language,
		'name' => $search,
	);
	//echo "<pre align=left>jsonData:<br>"; print_r($jsonData); echo "</pre>";
	
	#-> API Request
	$jsonResponse = apiRequest($apiURL, $jsonData);			
	if ( !$jsonResponse ) 
					{ exit('ERROR'); }
	
	$jsonResponse = json_decode($jsonResponse, true);
	$countriesArray = $jsonResponse['countries'];
	
	$searchedFieldsArray = array('id', 'name', 'nameEn', 'isoAlpha2', 'isoAlpha3', 'postCodeFormats', 'requireState', 'addressType', 'currencyCode', 'defaultOfficeId', 'siteNomen');
	
	$responseArray = array();
	
   #-> For each country
	foreach ( $countriesArray as $singleArray )
					{
               foreach ( $searchedFieldsArray as $constant )
									{
									#-> If is set the constant
									if ( isset($singleArray[$constant]) )
													{ ${$constant} = $singleArray[$constant]; }
									else
													{ ${$constant} = ''; }
									}

					#-> Replacment of some variables depending on the language.
					if ( $language == 'EN' )
									{ $name = $nameEn; }
      
					$requirePostCode = 0;
					if ( isset($postCodeFormats) && isset($postCodeFormats[0]) && $postCodeFormats[0] != '' )
									{ $requirePostCode = 1; }

 
               $complexTypes = (isset($singleArray['complexTypes'])) ? $singleArray['complexTypes'] : '';
               $streetTypes = (isset($singleArray['streetTypes'])) ? $singleArray['streetTypes'] : '';
               
               $inputVarsArray = array(
                  'complexTypes' => $complexTypes,
                  'streetTypes' => $streetTypes,
                  'language' => $language,
                  'countryId' => $id,
                  'addressDetailsTypesArray' => $addressDetailsTypesArray
               );           

               #-> Convert types to strings
               list($defaultSiteType, $complexTypesString, $streetTypesString) = convertTypesToStrings($inputVarsArray);
               
                           
               $responseArray[] = array(
						'value' => $name, 
						'label' => "$name ($isoAlpha3)",
						'countryId' => $id,
						'nameEn' => $nameEn,
						'isoAlpha2' => $isoAlpha2,
						'isoAlpha3' => $isoAlpha3,
						'postCodeFormats' => $postCodeFormats,
						'requireState' => $requireState,
                  'requirePostCode' => $requirePostCode,
						'addressType' => $addressType,
						'currencyCode' => $currencyCode,
						'defaultOfficeId' => $defaultOfficeId,
						'siteNomen' => $siteNomen,
                  'streetTypes' => $streetTypesString,
                  'complexTypes' => $complexTypesString,
                  'defaultSiteType' => $defaultSiteType
					);
               
               
					}
   
   #-> Return responce
	echo json_encode($responseArray);	

?>