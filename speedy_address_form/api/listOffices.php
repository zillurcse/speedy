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

	if ( !isset($_GET['siteId']) )
			{ exit('.'); }

	$search = '';
	if ( isset($_GET['search']) ) { $search = $_GET['search']; }
	if ( !$search ) { return; }

	$search = urldecode($search);
	$search = validateInputDataAddressForm($search);

	$siteId = '';
	$countryId = '';
	if ( isset($_GET['siteId']) )
					{ $siteId = $_GET['siteId']; }
	if ( isset($_GET['countryId']) )
					{ $countryId = $_GET['countryId']; }
	$siteId = validateIDAddressForm($siteId);
	$countryId = validateIDAddressForm($countryId);
	
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
		'siteId' => $siteId,
		'countryId' => $countryId,
		'name' => $search,
		'language' => $language,
	);


	#-> API Request
	$jsonResponse = apiRequest($apiURL, $jsonData);			

	if ( !$jsonResponse )
					{ exit("ERROR in Offices"); }

	$jsonResponse = json_decode($jsonResponse, true);

	
	if ( isset($jsonResponse['error']) )
					{
					$error = $jsonResponse['error']['message'];
					echo "$error";
					return($error);
					}
	
	$officesArray = $jsonResponse['offices'];

	$responseArray = array();

	$searchedFieldsArray = array('id', 'name', 'nameEn', 'siteId', 'address', 'workingTimeFrom', 'workingTimeTo', 'workingTimeHalfFrom', 'workingTimeHalfTo', 'workingTimeDayOffFrom', 'workingTimeDayOffTo', 'maxParcelDimensions',
	'maxParcelWeight', 'type', 'nearbyOfficeId', 'palletOffice', 'cardPaymentAllowed', 'cashPaymentAllowed');


	#-> For each office
	foreach ( $officesArray as $singleArray )
					{
               #-> Foreach constant
					foreach ( $searchedFieldsArray as $constant )
									{
                           #-> If the constant is reruned
                           if ( isset($singleArray[$constant]) )
                                       {
                                       ${$constant} = $singleArray[$constant];
                                       }
                           else
                                       {
                                       ${$constant} = '';
                                       }
									}


					$addressString = '';
					$localAddressString = $address['localAddressString'];
					$siteAddressString = $address['siteAddressString'];
					$fullAddressString = $address['fullAddressString'];
      
               $countryId = $address['countryId'];
               $siteName = $address['siteName'];
      
               #-> В зависимост от държавата 
               if ( $countryId == 100 || $countryId == 642 )
                           {
                           $addressString = $localAddressString;
                           }
               else
                           {
                           $addressString = $siteName.', '.$localAddressString;
                           }

					
					$width = $maxParcelDimensions['width'];
					$depth = $maxParcelDimensions['depth'];
					$height = $maxParcelDimensions['height'];
					
					#-> Replacment of some variables depending on the language.
					if ( $language == 'EN' )
									{
									$name = $nameEn;
									}
					
					//$rowTop = "$id, $name,";
					//$rowBottom = "$addressString";
					$rowTop = "$name [<b>$id</b>]";
					$rowBottom = "<i>$addressString</i>";
					
					$responseArray[] = array(
							'value' => $name, 
							'label' => "$id, $name, $addressString",
							'id' => $id,
							'siteId' => $siteId,
                     'siteName' => $siteName,
							'addressString' => $addressString,
							'fullAddressString' => $fullAddressString,
							'localAddressString' => $localAddressString,
							'siteAddressString' => $siteAddressString,
							'workingTimeFrom' => $workingTimeFrom,
							'workingTimeTo' => $workingTimeTo,
							'workingTimeHalfFrom' => $workingTimeHalfFrom,
							'workingTimeHalfTo' => $workingTimeHalfTo,
							'workingTimeDayOffFrom' => $workingTimeDayOffFrom,
							'workingTimeDayOffTo' => $workingTimeDayOffTo,
							'width' => $width,
							'depth' => $depth,
							'height' => $height,
							'maxParcelWeight' => $maxParcelWeight,
							'type' => $type,
							'nearbyOfficeId' => $nearbyOfficeId,
							'palletOffice' => $palletOffice,
							'cardPaymentAllowed' => $cardPaymentAllowed,
							'cashPaymentAllowed' => $cashPaymentAllowed,
							'rowTop' => $rowTop,
							'rowBottom' => $rowBottom,
							);
					}

	echo json_encode($responseArray);	
		
?>