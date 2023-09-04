<?php

	#-> REST API Request
	#-> -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	function apiRequest($apiURL, $jsonData)
			{
			#-> Initiate cURL.
			$curl = curl_init($apiURL);
			
			#-> Encode the array into JSON.
			$jsonDataEncoded = json_encode($jsonData);
			
			#-> Tell cURL that we want to send a POST request.
			curl_setopt($curl, CURLOPT_POST, 1); // POST
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Stop showing reusults on the screen
			curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5); // The number of seconds to wait while trying to connect. Use 0 to wait indefinitely.
			
			#-> Attach our encoded JSON string to the POST fields.
			curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonDataEncoded);
			
			#-> Set the content type to application/json
			curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
			
			$jsonResponse = curl_exec($curl);
			
			if ( $jsonResponse === FALSE) 
					{
					echo "cURL Error: " . curl_error($curl);
					} 
			
			return($jsonResponse);
			}


	#-> Validate functions
	#-> ---------------------------------------------------------------------------------------------------------------------------------------------------------------
	function validateIDAddressForm($id)
			{
			if ( !is_numeric($id) )	{ $id = 0; }
			return($id);
			}

	function validateInputDataAddressForm($inputData)
			{
			$badStrings = array("'");
			$inputData = str_replace($badStrings, "''", $inputData);
			return($inputData);
			}


   #-> Convert types to strings. Added at 25.02.2020. @since 3.2.3.
   #-> ---------------------------------------------------------------------------------------------------------------------------------------------------------------
   function convertTypesToStrings($inputVarsArray)
         {                
         $complexTypes = $inputVarsArray['complexTypes'];
         $streetTypes = $inputVarsArray['streetTypes'];
         $language = $inputVarsArray['language'];
         $countryId = $inputVarsArray['countryId'];
         $addressDetailsTypesArray = $inputVarsArray['addressDetailsTypesArray'];

         $defaultSiteType = '';
         $defaultComplexType = '';
         $defaultStreetType = '';
         if ( isset($addressDetailsTypesArray[$countryId]) )
                  {
                  $defaultSiteType = $addressDetailsTypesArray[$countryId][0];
                  $defaultComplexType = $addressDetailsTypesArray[$countryId][1];
                  $defaultStreetType = $addressDetailsTypesArray[$countryId][2];
                  } 

                     
         $complexTypesString = '';
         #-> If there are Complex types
         if ( $complexTypes != '' )
                     {
                     $complexTypesArray = $complexTypes;
                     $tempComplexTypesArray = array($defaultComplexType);
                     foreach ( $complexTypesArray as $singleTypeArray )
                                 {
                                 if ( isset($singleTypeArray['name']) && isset($singleTypeArray['nameEn']) )
                                             {
                                             $complexType = ($language == 'BG') ? $singleTypeArray['name'] : $singleTypeArray['nameEn'];	
                                             }
                                 else
                                             {
                                             $complexType = '';
                                             }
                                 $tempComplexTypesArray[] = $complexType;
                                 } 
                     if ( !empty($tempComplexTypesArray) )
                                 { $complexTypesString = implode(';', $tempComplexTypesArray); }                                   
                     }


         $streetTypesString = '';
         #-> If there are Street types
         if ( $streetTypes != '' )
                     {
                     $streetTypesArray = $streetTypes;
                     $tempStreetTypesArray = array($defaultStreetType);
                     foreach ( $streetTypesArray as $singleTypeArray )
                                 {
                                 if ( isset($singleTypeArray['name']) && isset($singleTypeArray['nameEn']) )
                                             {
                                             $streetType = ($language == 'BG') ? $singleTypeArray['name'] : $singleTypeArray['nameEn'];	
                                             }
                                 else
                                             {
                                             $streetType = '';
                                             }
                                 $tempStreetTypesArray[] = $streetType;
                                 } 
                     if ( !empty($tempStreetTypesArray) )
                                 { $streetTypesString = implode(';', $tempStreetTypesArray); }                                   
                     }

         return(array($defaultSiteType, $complexTypesString, $streetTypesString));
         }


   #-> Convert all address details types to one strings. Added at 25.02.2020. @since 3.2.3.
   #-> ---------------------------------------------------------------------------------------------------------------------------------------------------------------
   function allTypesToString($addressDetailsTypesArray)
         {
         $countriesTypesArray = array();
         foreach ( $addressDetailsTypesArray as $countryId => $countryTypesArray )
                  {
                  $typesString = implode(';', $countryTypesArray);
                  $countriesTypesArray[] = $countryId.';'.$typesString;
                  }

         $allAddressDetailsTypesString = implode('|', $countriesTypesArray);
         return($allAddressDetailsTypesString);    
         }
?>