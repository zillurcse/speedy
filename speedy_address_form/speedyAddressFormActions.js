
function validateAddress()
      {
      var srcPath = $('#srcPath').val();

      var isValidAddress = '';
      var language = $('#language').val();
      
      var rcptOfficeId = $("#speedyRcptOfficeId").val();
      var addressType = $("#speedyRcptCountryAddressType").val();
      var countryId = $("#speedyRcptCountryId").val();
      var stateId = $("#speedyRcptStateId").val();
      var siteId = $("#speedyRcptSiteId").val();
      var siteType = $("#speedyRcptSiteType").val();
      var siteName = $("#speedyRcptSiteName").val();
      var postCode = $("#speedyRcptPostCode").val();
      var complexId = $("#speedyRcptComplexId").val();
      var complexType = $("#speedyRcptComplexType").val();
      var complexName = $("#speedyRcptComplexName").val();
      var streetId = $("#speedyRcptStreetId").val();
      var streetType = $("#speedyRcptStreetType").val();
      var streetName = $("#speedyRcptStreetName").val();
      var streetNo = $("#speedyRcptStreetNo").val();
      var blockNo = $("#speedyRcptBlockNo").val();
      var entranceNo = $("#speedyRcptEntranceNo").val();
      var floorNo = $("#speedyRcptFloorNo").val();
      var apartmentNo = $("#speedyRcptApartmentNo").val();
      var poiId = $("#speedyRcptPoiId").val();
      var addressNote = $("#speedyRcptAddressNote").val();
      var siteNameForeign = $("#speedyRcptSiteNameForeign").val();
      var addressLine1 = $("#speedyRcptAddressLine1").val();
      var addressLine2 = $("#speedyRcptAddressLine2").val();

      if ( addressType == 2 )
            { 
            siteName = siteNameForeign; 
            }
      
      /*
      console.log('addressType: ' + addressType + '\n' + 'countryId: ' + countryId + '\n' + 'stateId: ' + stateId + '\n' + 'siteId: ' + siteId + '\n' + 'siteType: ' + siteType + '\n' + 'siteName: ' + siteName + '\n' + 'postCode: ' + postCode + '\n' + 'complexId: ' + complexId 
                  + '\n' + 'complexType: ' + complexType + '\n' + 'complexName: ' + complexName + '\n' + 'streetId: ' + streetId + '\n' + 'streetType: ' + streetType 
                  + '\n' + 'streetNo: ' + streetNo + '\n' + 'blockNo: ' + blockNo + '\n' + 'entranceNo: ' + entranceNo + '\n' + 'floorNo: ' + floorNo + '\n' + 'apartmentNo: ' + apartmentNo + '\n' + 'poiId: ' + poiId + '\n' + 'addressNote: ' + addressNote 
                  + '\n' + 'addressLine1: ' + addressLine1 + '\n' + 'addressLine2: ' + addressLine2 + '\n' +'siteNameForeign: ' + siteNameForeign
                  + '\n' + 'rcptOfficeId: ' + rcptOfficeId + '\n' + 'language: ' + language);
      */

      $.ajax({
            type: 'GET',
            url: srcPath + 'api/validateAddress.php',
            data: {	'rcptOfficeId':rcptOfficeId, 
                     'addressType':addressType, 
                     'countryId':countryId, 
                     'stateId':stateId, 
                     'siteId':siteId, 
                     'siteType':siteType, 
                     'siteName':siteName, 
                     'postCode':postCode, 
                     'complexId':complexId, 
                     'complexType':complexType, 
                     'complexName':complexName,
                     'streetId':streetId, 
                     'streetType':streetType, 
                     'streetName':streetName, 
                     'streetNo':streetNo, 
                     'blockNo':blockNo, 
                     'entranceNo':entranceNo, 
                     'floorNo':floorNo, 
                     'apartmentNo':apartmentNo, 
                     'poiId':poiId, 
                     'addressNote':addressNote, 
                     'addressLine1':addressLine1, 
                     'addressLine2':addressLine2,
                     'language':language},
            async: false,
            success: function(response){

                  var json = $.parseJSON(response);
                  var validationMessage = json['validationMessage'];
                  var validationError = json['validationError'];

                  // If the address is Ok
                  if ( validationError == '' && validationMessage != '' )
                        {
                        isValidAddress = 'Y';
                        }
                  else if ( validationError != '' )
                        {
                        isValidAddress = 'N';
                        $("#errorValidateAddress").val(validationError);
                        }
                  else
                        {
                        isValidAddress = 'N';
                        $("#errorValidateAddress").val('Undefined validation error');
                        }

                  $("#isValidAddress").val(isValidAddress);

                  },

            error: errorHandler
            });
      
      }





function formActions()
      {

      // Clear errors and messages
      clearErrorsAndMessages();

      // Clear address validation
      $("#isValidAddress").val();

      var showValidationMessage = $('#showValidationMessage').val();
      var rcptOfficeId = $("#speedyRcptOfficeId").val();
      var pickupOffice = 0;

      if ( document.getElementById('pickupOffice').checked == true )
            { pickupOffice = 1; } // Pickup from office			
      if ( document.getElementById('foreignPickupOffice').checked == true )
            { pickupOffice = 1; } // Pickup from foreign office		   
         
      // Pickup from office without selected office
      if ( pickupOffice == 1 && rcptOfficeId == '' ) 
            {
            $("#isValidAddress").val('N');
            var validationError = $("#errorMissingOffice").val();
            $("#errorValidateAddress").val(validationError);
            }
      // Pickup from office with office
      else if ( pickupOffice == 1 && rcptOfficeId != '' )   
            {
            $("#isValidAddress").val('Y');
            $("#errorValidateAddress").val();
            }
      // Delivery to an address
      else 
            {
            validateAddress();
            }


      var isValidAddress = $("#isValidAddress").val(); //console.log('isValidAddress: ' + isValidAddress);

      // If the address is not valid
      if ( isValidAddress != 'Y' )
            {
            var errorValidateAddress = $("#errorValidateAddress").val();
            var divErrorRecipient = document.getElementById('divErrorRecipient');
            divErrorRecipient.innerHTML = errorValidateAddress;
            divErrorRecipient.style.display = 'block'; 
            }
            
      // The address is Ok
      else
            {
            if ( showValidationMessage == 'Y' ) 
                  {
                  var divMessageRecipient = document.getElementById('divMessageRecipient');
                  divMessageRecipient.innerHTML = $("#messageValidateAddress").val();
                  divMessageRecipient.style.display = 'block';                    
                  }
                  
                  
            /* 
            .
            .
            .
            THE ADDRESS IS OK, DO SOMETHING
            .
            .
            .
            */	                 
                  
            }

      }











