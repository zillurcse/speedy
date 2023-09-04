<?php

	$textSettlementBeginType = 'gr./s.';
	$textSettlement = 'City/village';
	$textZIP = 'Post code';
	$textRegion = 'Reg.';
	$textMunicipality = 'Mun.';
	$textBlock = 'Block';
	$textEntrance = 'Ent.';
	$textFloor = 'Fl.';
	$textApartment = 'Ap.';
	$textPOI = 'POI';
	$textAddressNote = 'Addr. note';
	$textPostCode = 'Post code';
	$textComplexBeginType = 'kv./zhk';
	$textStreetBeginType = 'ul./bul.';
	$textOffice = 'Office';
	$textOfficeAddress = 'Address';
   $textNewName = 'New name';
   
	$textCountry = 'Country';
	$textState = 'State';
	$textPostalCode = 'Post code';
	$textAddressLine1 = 'Addr. row 1';
	$textAddressLine2 = 'Addr. row 2';

	$textBulgaria = 'Bulgaria';
	$textPickupOffice = 'Pickup office'; 

	$textButtonForm = 'Submit';

	$textInfoFieldsCountry = 'Country';
	$textInfoFieldsState = 'State';
	$textInfoFieldsOffice = 'Office';
	$textInfoFieldsSite = 'City/village';
	$textInfoFieldsComplex = 'Quarter';
	$textInfoFieldsStreet = 'Street';
	$textInfoFieldsBlock = 'Block';
	$textInfoFieldsPoi = 'POI';
	
	$textFormVariablesState = 'Form variables state:';

	$textSlogan = 'Speedy - Express delivery service';

	#-> Errors
   $errorDeliveryToSelectedCountry = 'Speedy is not offering deliveries to the selected country.';
	$errorValidateAddress = 'The selected address is not valid.';
   $errorMissingOffice = 'There is no office selected.';

   #-> Messages
   $messageValidateAddress = 'The selected address is valid.';

   /* Added at 25.02.2020. @since 3.2.3 */
   #-> Types for sites, complexes and streets. 
   $addressDetailsTypesArray = array(
      100 => array('gr./s.', 'kv./zhk', 'ul./bul.'),
      642 => array('s./or', '', 'str./bld.')
   );
   $textComplexNameFieldTitle = 'Complex name';
   $textStreetNameFieldTitle = 'Street name';

   $countriesNamesArray = array(
      100 => 'Bulgaria',
      642 => 'Romania'
   );

?>