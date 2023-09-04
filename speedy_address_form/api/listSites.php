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
	$apiURL = $apiBaseURL.'location/site/';

	//Initiate cURL.
	//$curl = curl_init($apiURL);
	
	//The JSON data.
	$jsonData = array(
		'userName' => $username,
		'password' => $password,
		'countryId' => $countryId,
		'language' => $language,
		'name' => $search,
	);
	//echo "<pre align=left>jsonData:<br>"; print_r($jsonData); echo "</pre>";
	
	#-> API Request
	$jsonResponse = apiRequest($apiURL, $jsonData);			
	
	if ( !$jsonResponse ) 
					{ exit('ERROR'); }
	
	$jsonResponse = json_decode($jsonResponse, true);

	$sitesArray = $jsonResponse['sites'];
	
	$responseArray = array();

	$searchedFieldsArray = array('id', 'countryId', 'type', 'typeEn', 'name', 'nameEn', 'municipality', 'municipalityEn', 'region', 'regionEn', 'postCode', 'addressNomenclature', 'x', 'y', 'servingDays', 'servingOfficeId');
	
	#-> For each row of the result
	foreach ( $sitesArray as $singleArray )
					{
					foreach ( $searchedFieldsArray as $constant )
									{
									${$constant} = $singleArray[$constant];
									}

					#-> Replacment of some variables depending on the language.
					if ( $language == 'EN' )
									{
									$type = $typeEn;
									$name = $nameEn;
									$municipality = $municipalityEn;
									$region = $regionEn;
									}
					
					$fullRegionName = "$textRegion $region";
					$fullPostCode = "$textPostCode ".$postCode;
					
					$fullSiteName = $type.' '.$name; 
					if ( !empty($postCode) )
									{ $fullSiteName .= ", $fullPostCode"; }
					$addInfo = "$textPostCode $postCode";
					$rowTop = "$fullSiteName,";

					$fullSiteName .= ' ';
					
					#-> Depending on the language
					if ( $language != 'EN' ) // BG
									{ 
									#-> If there is a municipality
									if ( !empty($municipality) ) 
													{
													$addInfo .= ", $textMunicipality ".$municipality; 
													$fullSiteName .= "$textMunicipality ".$municipality; 
													} 
									#-> If there is a region
									if ( !empty($region) ) 
													{ 
													$addInfo .= ", $textRegion ".$region;
													$fullSiteName .= ", $textRegion ".$region;
													} 
									$rowBottom = "$textMunicipality $municipality, $textRegion $region";
									}
					else // EN
									{ 
									#-> If there is a municipality
									if ( !empty($municipality) ) 
													{ 
													$addInfo .= ", $municipality $textMunicipality"; 
													$fullSiteName .= "$municipality $textMunicipality"; 
													} 
									#-> If there is a region
									if ( !empty($region) ) 
													{ 
													$addInfo .= ", $region $textRegion"; 
													$fullSiteName .= ", $municipality $textRegion"; 
													} 
									$rowBottom = "$municipality $textMunicipality, $region $textRegion";
									}
					
					
					$responseArray[] = array(
							'value' => $name, 
							'label' => $fullSiteName,
							'siteId' => $id,
							'countryId' => $countryId,
							'type' => $type,
							'addInfo' => $addInfo,
							'postCode' => $postCode,
							'region' => $region,
							'municipality' => $municipality,
							'addressNomenclature' => $addressNomenclature,
							'x' => $x,
							'y' => $y,
							'servingDays' => $servingDays,
							'servingOfficeId' => $servingOfficeId,
							'rowTop' => $rowTop,
							'rowBottom' => $rowBottom,
							);
					//echo "$fullSiteName|$id|$type|$name|$addInfo|$postCode|$addressNomenclature|$servingOfficeId\n";
					}

	echo json_encode($responseArray);	
	
?>