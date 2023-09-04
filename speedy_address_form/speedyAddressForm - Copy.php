<?php

   $srcPath = ''; // Define here the path to the address form. It can be 'mainproject/forms/speedy_address_form/', 'test/v1/' or something else
   $srcPath .= 'speedy_address_form/';
   $srcPath = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/' . $srcPath; // Output somthing like: http://www.mydomain.com/mainproject/forms/speedy_address_form/

   define('SRC_PATH', $srcPath);  
   $imagesDirecory = SRC_PATH.'images/';

	#-> Functions and libraries
	include('libraryAddressForm.php');
	include('functionsAddressForm.php');
   
	#-> Get and set language
	include('languages.php'); 

   
	#-> If language is english
	if ( $language == 'EN' )
					{
					include('libraryAddressFormEN.php');
					$languageLink = "<a href=\"?language=Bg\"><img src=\"images/flagBulgaria.png\" border=\"0\"></a>";
					$siteLink = "https://www.speedy.bg/en";
					$languageProcedure = 2;
					}	
	#-> In all other casesa
	else
					{
					include('libraryAddressFormBG.php');
					$languageLink = "<a href=\"?language=En\"><img src=\"images/flagUnitedKingdom.png\" border=\"0\"></a>";
					$siteLink = "https://www.speedy.bg/bg";
					$languageProcedure = 1;
					}	

   #-> Convert all address details types to one strings.
   $allAddressDetailsTypesString = allTypesToString($addressDetailsTypesArray);

   $defaultSiteType = $addressDetailsTypesArray[$defaultCountryId][0];
   $defaultComplexType = $addressDetailsTypesArray[$defaultCountryId][1];
   $defaultStreetType = $addressDetailsTypesArray[$defaultCountryId][2];

?>
<link href="<?php echo SRC_PATH; ?>speedyAddressForm.css" rel="stylesheet" type="text/css" />
<meta name="viewport" content="width=device-width" />
<meta http-equiv="content-language" content="<?php echo strtolower($language); ?>">
<script type="text/javascript">
var textSite = '<?php echo $textSettlementBeginType; ?>';
var textComplex = '<?php echo $textComplexBeginType; ?>';
var textStreet = '<?php echo $textStreetBeginType; ?>';
var allAddressDetailsTypesString = '<?php echo $allAddressDetailsTypesString; ?>';
</script>

<!-- Script -->
<script src='<?php echo SRC_PATH; ?>jquery-3.1.1.min.js' type='text/javascript'></script>
<!-- jQuery UI -->
<link href='<?php echo SRC_PATH; ?>jquery-ui.min.css' rel='stylesheet' type='text/css'>
<script src='<?php echo SRC_PATH; ?>jquery-ui.min.js' type='text/javascript'></script>
<script src='<?php echo SRC_PATH; ?>errorHandler.js'></script>
</head>
<body class="bodyAddressForm">
<div align="center">
<?php

$body10=<<<B10
<div id="speedyAddressForm">
<div align="left"><a href="http://www.speedy.bg"><img src="$imagesDirecory/SpeedyLogo.png" alt="$textSlogan" title="$textSlogan"></a></div>
<form id="addressFormRecipient" name="addressFormRecipient" style="margin: 0px; padding: 0px;" autocomplete="off">
<input type="hidden" id="language" name="language" value="$language">
<input type="hidden" id="speedyRcptCountryAddressType" name="speedyRcptCountryAddressType" value="1">
<input type="hidden" id="speedyRcptSiteId" name="speedyRcptSiteId"/>
<input type="hidden" id="speedyRcptStreetId" name="speedyRcptStreetId"/>
<input type="hidden" id="speedyRcptComplexId" name="speedyRcptComplexId"/>
<input type="hidden" id="speedyRcptAddressNomenclature" name="speedyRcptAddressNomenclature"/>
<input type="hidden" id="speedyRcptPoiId" name="speedyRcptPoiId"/>
<input type="hidden" id="speedyRcptPoiType" name="speedyRcptPoiType"/>
<input type="hidden" id="speedyRcptCountryId" name="speedyRcptCountryId" value="$defaultCountryId"/>
<input type="hidden" id="speedyRcptStateId" name="speedyRcptStateId">
<input type="hidden" id="errorDeliveryToSelectedCountry" value="$errorDeliveryToSelectedCountry">
<input type="hidden" id="errorValidateAddress" name="errorValidateAddress" value="$errorValidateAddress">
<input type="hidden" id="errorMissingOffice" name="errorMissingOffice" value="$errorMissingOffice">   
<input type="hidden" id="messageValidateAddress" name="messageValidateAddress" value="$messageValidateAddress">
<input type="hidden" id="showValidationMessage" name="showValidationMessage" value="$showValidationMessage">
<input type="hidden" id="showDeveloperInfo" name="showDeveloperInfo" value="$showDeveloperInfo">
<input type="hidden" id="isValidAddress" name="isValidAddress">
<input type="hidden" id="srcPath" name="srcPath" value="$srcPath">
B10;
echo $body10;

	#-> Show country label. Do not delete this section. You can change the "showCountryLabel" variable in the "libraryAddressForm.php" file. 
	if ( $showCountryLabel == 'Y' )
					{
$body20=<<<B20
<div class="divAddressRow">
   <div class="divAddresdRowBox"><div class="divForeignAddressFormCountry"><span class="spanRequired">*</span> $textCountry</div><input id="speedyRcptCountryName" name="speedyRcptCountryName" class="speedyForeignAddressFormCountry" value="" autocomplete="off" role="presentation"></div>
   <div class="divAddresdRowBox"><span id="speedyRcptStateLabel" style="display: none;"><div class="divForeignAddressFormState"><span class="spanRequired">*</span> $textState</div><input id="speedyRcptStateName" name="speedyRcptStateName" class="speedyForeignAddressFormState" autocomplete="off" role="presentation"></span></div>
</div>
<div id="divErrorCountry" class="divError" style="display: none;"></div>
B20;
echo $body20;
					}


$body30=<<<B30
<fieldset id="fieldsetRecipientSite" name="fieldsetRecipientSite" class="fieldsetAddressForm" style="display: block;">
<div class="divAddressRow">
   <div class="divAddresdRowBox"><div class="divAddressFormSite"><span class="spanRequired">*</span> $textSettlement</div><input id="speedyRcptSiteType" name="speedyRcptSiteType" class="speedyAddressSiteType" disabled value="$defaultSiteType"><input id="speedyRcptSiteName" name="speedyRcptSiteName" class="speedyAddressSiteName" maxlength="50" autocomplete="off" role="presentation" onFocusOut="setFieldToDefault('speedyRcptSiteName')"></div>
   <div class="divAddresdRowBox"><input id="speedyRcptSiteAddInfo" name="speedyRcptSiteAddInfo" class="speedyAddressSiteAddInfo" disabled tabindex="-1"></div>
</div>
</fieldset>

<div class="divAddressRow" id="pickupOfficeRow" style="display: block;">
   <div class="divAddresdRowBoxBig"><div class="divPickupOffice"></div><input type="checkbox" id="pickupOffice" name="pickupOffice" disabled class="inputPickupOffice" onChange="pickupOfficeCheckboxActions()"> <label for="pickupOffice">$textPickupOffice</label></div>
</div>
   
   

      
<fieldset id="fieldsetForeignRecipientSite" name="fieldsetForeignRecipientSite" class="fieldsetAddressForm" style="display: block;">
<div class="divAddressRow">
   <div class="divAddresdRowBox"><div class="divForeignAddressFormSite"><span class="spanRequired">*</span> $textSettlement</div><input id="speedyRcptSiteNameForeign" name="speedyRcptSiteNameForeign" class="speedyForeignAddressFormSite" role="presentation"></div>
   <div class="divAddresdRowBox"><div class="divForeignAddressFormPostCode"><span class="spanRequired">*</span> $textPostalCode</div><input id="speedyRcptPostCode" name="speedyRcptPostCode" class="speedyForeignAddressFormPostCode" role="presentation"></div>
</div>
</fieldset>
   
<div class="divAddressRow" id="foreignPickupOfficeRow" style="display: block;">
   <div class="divAddresdRowBoxBig"><div class="divPickupOffice"></div><input type="checkbox" id="foreignPickupOffice" name="foreignPickupOffice" disabled class="inputPickupOffice" onChange="pickupOfficeCheckboxActions()"> <label for="pickupOffice">$textPickupOffice</label></div>
</div>



<fieldset id="fieldsetRecipientOffice" name="fieldsetRecipientOffice" class="fieldsetAddressForm" style="display: none;">
<div class="divAddressRow">
   <div class="divAddresdRowBoxBig"><div class="divAddressFormOffice"><span class="spanRequired">*</span> $textOffice</div><input id="speedyRcptOfficeId" name="speedyRcptOfficeId" class="speedyAddressOfficeId" readonly tabindex="-1"><input id="speedyRcptOfficeName" name="speedyRcptOfficeName" class="speedyAddressOfficeName" maxlength="50" disabled autocomplete="off" role="presentation"></div>
</div>
</fieldset>

<fieldset id="fieldsetForeignRecipientOffice" name="fieldsetForeignRecipientOffice" class="fieldsetAddressForm" style="display: block;">
<div class="divAddressRow">
   <div class="divAddresdRowBoxBig"><div class="divAddressFormOffice">$textOfficeAddress</div><input id="speedyRcptOfficeAddInfo" name="speedyRcptOfficeAddInfo" class="speedyAddressOfficeAddInfo" disabled tabindex="-1"></div>
</div>
<div id="divAddressFormTitleRecipientOffice" style="display: block;" class="divAddressSectionTitle"></div>
</fieldset>



<fieldset id="fieldsetRecipientAddress" name="fieldsetRecipientAddress" class="fieldsetAddressForm" style="display: blobk;">
<div class="divAddressRow">
   <div class="divAddresdRowBox">
      <select id="speedyRcptComplexType" class="speedyAddressComplexType" disabled>
         <option value="$defaultComplexType">$defaultComplexType</option>\n	
      </select><input id="speedyRcptComplexName" name="speedyRcptComplexName" class="speedyAddressComplexName" title="$textComplexNameFieldTitle" disabled maxlength="50" autocomplete="off" role="presentation" onFocusOut="setFieldToDefault('speedyRcptComplexName')"></div>
   <div class="divAddresdRowBox">
      <select id="speedyRcptStreetType" name="speedyRcptStreetType" class="speedyAddressStreetType" disabled>
         <option value="$defaultStreetType">$defaultStreetType</option>\n	
      </select><input id="speedyRcptStreetName" name="speedyRcptStreetName" class="speedyAddressStreetName" title="$textStreetNameFieldTitle" disabled maxlength="50" autocomplete="off" role="presentation" onFocusOut="setFieldToDefault('speedyRcptStreetName')"><div class="divAddressFormStreetNo">No.</div><input id="speedyRcptStreetNo" name="speedyRcptStreetNo" class="speedyAddressStreetNo" disabled></div>
</div>



<div class="divAddressRow">
   <div class="divAddresdRowBox"><div class="divAddressFormBlockNo">$textBlock</div><input id="speedyRcptBlockNo" name="speedyRcptBlockNo" class="speedyAddressBlockNo" disabled maxlength="40" autocomplete="off" role="presentation"><div class="divAddressFormEntranceNo">$textEntrance</div><input id="speedyRcptEntranceNo" name="speedyRcptEntranceNo" class="speedyAddressEntranceNo" disabled maxlength="10" autocomplete="off" role="text"><div class="divAddressFormFloorNo">$textFloor</div><input id="speedyRcptFloorNo" name="speedyRcptFloorNo" class="speedyAddressFloorNo" disabled maxlength="10" autocomplete="off" role="presentation"><div class="divAddressFormApartmentNo">$textApartment</div><input id="speedyRcptApartmentNo" name="speedyRcptApartmentNo" class="speedyAddressApartmentNo" disabled maxlength="10" autocomplete="off" role="presentation"></div>
   <div class="divAddresdRowBox"><div class="divAddressPoiName">$textPOI</div><input id="speedyRcptPoiName" name="speedyRcptPoiName" class="speedyAddressPoiName" disabled onKeyUp="poiActions('enableFields')" autocomplete="off"></div>
</div>

<div class="divAddressRow">
   <div class="divAddresdRowBoxBig"><div class="divAddressPoiName">$textAddressNote</div><input id="speedyRcptAddressNote" name="speedyRcptAddressNote" class="speedyAddressNote" disabled maxlength="200"></div>
</div>
</fieldset>




<fieldset id="fieldsetRecipientForeignAddress" name="fieldsetRecipientForeignAddress" class="fieldsetAddressForm" style="display: none;">
<div class="divAddressRow">
   <div class="divForeignAddresdRowBoxBig"><div class="divForeignAddressFormLine"><span class="spanRequired">*</span> $textAddressLine1</div><input id="speedyRcptAddressLine1" name="speedyRcptAddressLine1" class="speedyForeignAddressFormLine" role="presentation"></div>
</div>

<div class="divAddressRow">
   <div class="divForeignAddresdRowBoxBig"><div class="divForeignAddressFormLine">$textAddressLine2</div><input id="speedyRcptAddressLine2" name="speedyRcptAddressLine2" class="speedyForeignAddressFormLine" role="presentation"></div>
</div>
</fieldset>


<!--
<div class="divAddressRow">
   <div class="divButtonRow"><div class="divButtonRowLabel"></div><input type="button" id="buttonForm" name="buttonForm" value="$textButtonForm" class="inputButtonForm" onClick="formActions()"></div>
</div>
-->


<div id="divErrorRecipient" name="divErrorRecipient" class="divError" style="display: none;"></div>
<div id="divMessageRecipient" name="divMessageRecipient" class="divOk" style="display: none;"></div>


</form>
</div>
B30;
echo $body30;
?>

<script src='<?php echo SRC_PATH; ?>speedyAddressForm.js?v=2' type='text/javascript'></script>
<script src='<?php echo SRC_PATH; ?>speedyAddressFormActions.js' type='text/javascript'></script>
<script type="text/javascript">
	loadTypes();
</script>

<?php
	
	#-> Include info fields
	if ( $showDeveloperInfo == 'Y' || isset($_GET['showDeveloperInfo']) )
					{
					include('formVariablesState.php');
					if ( isset($_GET['showDeveloperInfo']) )
									{
?>											
<script type="text/javascript">
	$('#showDeveloperInfo').val('Y'); 
</script>
<?php
									}
					}

?>

</div>