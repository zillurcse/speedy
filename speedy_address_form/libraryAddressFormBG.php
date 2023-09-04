<?php

	$textSettlementBeginType = 'гр./с.';
	$textSettlement = 'Нас. място';
	$textZIP = 'п.к.';
	$textRegion = 'Обл.';
	$textMunicipality = 'Общ.';
	$textBlock = 'Блок';
	$textEntrance = 'Вх.';
	$textFloor = 'Ет.';
	$textApartment = 'Ап.';
	$textPOI = 'Хар. обект';
	$textAddressNote = 'Уточнение';
	$textPostCode = 'п.к.';
	$textComplexBeginType = 'кв./жк';
	$textStreetBeginType = 'ул./бул.';
	$textOffice = 'Офис';
	$textOfficeAddress = 'Адрес';
   $textNewName = 'Ново име';

   $textCountry = 'Държава';
	$textState = 'Щат';
	$textPostalCode = 'Пощ. код';
	$textAddressLine1 = 'Адр. (ред 1)';
	$textAddressLine2 = 'Адр. (ред 2)';

	$textBulgaria = 'България';
	$textPickupOffice = 'До поискване в офис'; //До офис

	$textButtonForm = 'Изпрати';

	$textInfoFieldsCountry = 'Държава';
	$textInfoFieldsState = 'Щат';
	$textInfoFieldsOffice = 'Офис';
	$textInfoFieldsSite = 'Населено място';
	$textInfoFieldsComplex = 'Квартал/жк';
	$textInfoFieldsStreet = 'Улица';
	$textInfoFieldsBlock = 'Блок';
	$textInfoFieldsPoi = 'Характерен обект';
	
	$textFormVariablesState = 'Състояние на променливите:';
	
	$textSlogan = 'Спиди - Експресни куриерски услуги';

   #-> Errors
	$errorDeliveryToSelectedCountry = 'Спиди не доставя пратки до избраната държава.';
	$errorValidateAddress = 'Попълненият адрес не е валиден.';
   $errorMissingOffice = 'Не е избран офис.';
	
   #-> Messages
	$messageValidateAddress = 'Попълненият адрес е валиден.';

   /* Added at 25.02.2020. @since 3.2.3 */
   #-> Types for sites, complexes and streets. 
   $addressDetailsTypesArray = array(
      100 => array('гр./с.', 'кв./жк', 'ул./бул.'),
      642 => array('s./or', '', 'str./bld.')
   );
   $textComplexNameFieldTitle = 'Име на квартал/жилищен комплекс';
   $textStreetNameFieldTitle = 'Име на улица';

   $countriesNamesArray = array(
      100 => 'България',
      642 => 'Румъния'
   );

?>