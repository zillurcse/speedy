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
	$apiURL = $apiBaseURL.'location/poi/';

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

	
	if ( isset($jsonResponse['error']) )
					{
					$error = $jsonResponse['error']['message'];
					echo "$error";
					return($error);
					}
	
	$commonObjectsArray = $jsonResponse['pois'];
	$searchedFieldsArray = array('id', 'siteId', 'type', 'typeEn', 'name', 'nameEn', 'address', 'addressEn', 'x', 'y');
	
	$responseArray = array();

	#-> For each row of the result
	foreach ( $commonObjectsArray as $singleArray )
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
									$type = $typeEn;
									$address = $addressEn;
									}
					
					$rowTop = '';
					$rowBottom = '';

					$fullCommonObjectName = '';
					if ( !empty($type) )
									{ 
									$fullCommonObjectName .= "$type "; 
									$rowTop .= "$type "; 
									}
					if ( !empty($name) )
									{ 
									$fullCommonObjectName .= "$name<br>"; 
									$rowTop .= $name; 
									}
					if ( !empty($address) )
									{ 
									$fullCommonObjectName .= "$address"; 
									$rowBottom .= $address;
									}
					

					$responseArray[] = array(
							'value' => $rowTop, 
							'label' => $fullCommonObjectName,
							'id' => $id,
							'siteId' => $siteId,
							'type' => $type,
							'address' => $address,
							'x' => $x,
							'y' => $y,
							'rowTop' => $rowTop,
							'rowBottom' => $rowBottom,
							);
					}
	
	echo json_encode($responseArray);	

?>