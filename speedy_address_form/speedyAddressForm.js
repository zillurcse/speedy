$(document).ready(function() {

   var srcPath = $('#srcPath').val();
   var language = $('#language').val(); 
	var showDeveloperInfo = $('#showDeveloperInfo').val();
	
   /* COUNTRIES */
	$("#speedyRcptCountryName").autocomplete({
			delay: 100,
			minLength: 1,
         autoFocus: true, // highlight the first record
			source: function(request, response) {
			$.ajax({
					url: srcPath + 'api/listCountries.php?language=' + language,
					type: 'GET',
					dataType: 'json',
					data: {
						search: request.term
					},
					success: function(data){
						response(data);
					}
				});
			},
			select: function (event, ui) {
					var speedyRcptCountryNameLabel = ui.item.label; // Display the selected text
					var speedyRcptCountryName = ui.item.value; // Save selected id to input
					var speedyRcptCountryId = ui.item.countryId;
					var speedyRcptCountryNameEn = ui.item.nameEn;
					var speedyRcptCountryRequireState = ui.item.requireState;
					var speedyRcptCountryCurrencyCode = ui.item.currencyCode;
					var speedyRcptCountryAddressType = ui.item.addressType;
					var speedyRcptCountryIsoAlpha2 = ui.item.isoAlpha2;
					var speedyRcptCountryIsoAlpha3 = ui.item.isoAlpha3;
					var speedyRcptCountryPostCodeFormats = ui.item.postCodeFormats;
					var speedyRcptCountryDefaultOfficeId = ui.item.defaultOfficeId;
					var speedyRcptCountrySiteNomen = ui.item.siteNomen;
               var speedyRcptCountryStreetTypes = ui.item.streetTypes;
               var speedyRcptCountryComplexTypes = ui.item.complexTypes;
               var speedyRcptDefaultSiteType = ui.item.defaultSiteType; 
               
               // Clear errors and messages
               clearErrorsAndMessages();

               // Clear form fields
               clearFormFields('speedyRcptSiteId,speedyRcptSiteType,speedyRcptSiteName,speedyRcptSiteAddInfo,speedyRcptPostCode,speedyRcptComplexId,speedyRcptComplexType,speedyRcptComplexName,speedyRcptStreetId,speedyRcptStreetType,speedyRcptStreetName,speedyRcptStreetNo,speedyRcptBlockNo,speedyRcptEntranceNo,speedyRcptFloorNo,speedyRcptApartmentNo,speedyRcptPoiId,speedyRcptPoiName,speedyRcptAddressNote,speedyRcptSiteNameForeign,speedyRcptAddressLine1,speedyRcptAddressLine2,pickupOffice,speedyRcptOfficeId,speedyRcptOfficeName,speedyRcptOfficeAddInfo');

               // Change visibility of element
               //changeElementVisibility('pickupOfficeRow', 'none');
            
               if ( document.getElementById('pickupOffice') ) 
                     { document.getElementById('pickupOffice').checked = false; }
               if ( document.getElementById('foreignPickupOffice') ) 
                     { document.getElementById('foreignPickupOffice').checked = false; }
            
               /*
               // Allow the checkbox depending of the country
               if ( speedyRcptCountryId == 100 || speedyRcptCountryId == 642 )
                     {
                     $("#pickupOffice").attr('disabled', true); 
                     }
               else
                     {
                     $("#pickupOffice").attr('disabled', false); 
                     }
               */         
               if ( speedyRcptCountryAddressType == 1 ) 
                     {
                     // Fill in types in select fields     
                     fillTypes(speedyRcptDefaultSiteType, speedyRcptCountryComplexTypes, speedyRcptCountryStreetTypes);	
                     }

               $('#speedyRcptCountryName').val(speedyRcptCountryName); 
               $('#speedyRcptCountryId').val(speedyRcptCountryId); 
               $('#speedyRcptCountryAddressType').val(speedyRcptCountryAddressType); 
					
               if ( speedyRcptCountryRequireState == '' ) 
							{ 
							$("#speedyRcptState").attr('disabled', true); 
							document.getElementById('speedyRcptStateLabel').style.display = 'none';
							}
               else 
							{ 
							$("#speedyRcptState").attr('disabled', false); 
							document.getElementById('speedyRcptStateLabel').style.display = 'block';
							}
					
               // Show specific address form (localaddress / localoffice / foreign)
               if ( speedyRcptCountryAddressType == 1 )
							{ 
                     showAddressForm('localaddress'); 
                     }
               else if ( speedyRcptCountryAddressType == 2 )
							{ 
                     showAddressForm('foreignaddress'); 
                     }
					
               /*
               if ( speedyRcptCountrySiteNomen == 1 )
                     {
                     // Load comlex and street types
                     loadTypes();
                     }
               */      
               // If developers info is included (form_variable_state)
               if ( showDeveloperInfo == 'Y' )
							{
							// Clear info fields
							clearInfoFieldsByPartOfIds('speedyRcptState,speedyRcptSite,speedyRcptOffice,speedyRcptComplex,speedyRcptStreet,speedyRcptBlock,speedyRcptPoi');
							
							var infoFields = {speedyRcptCountryId: speedyRcptCountryId,
													speedyRcptCountryName: speedyRcptCountryName,
													speedyRcptCountryNameEn: speedyRcptCountryNameEn,
													speedyRcptCountryAddressType: speedyRcptCountryAddressType,
													speedyRcptCountryRequireState: speedyRcptCountryRequireState,
													speedyRcptCountryCurrencyCode: speedyRcptCountryCurrencyCode,
													speedyRcptCountryIsoAlpha2: speedyRcptCountryIsoAlpha2,
													speedyRcptCountryIsoAlpha3: speedyRcptCountryIsoAlpha3,
													speedyRcptCountryPostCodeFormats: speedyRcptCountryPostCodeFormats,
													speedyRcptCountryDefaultOfficeId: speedyRcptCountryDefaultOfficeId,
													speedyRcptCountrySiteNomen: speedyRcptCountrySiteNomen};
		
							// Fill info fields
							fillInfoFields(infoFields);
							}
							
					return false;
			}
	});




	/* STATES */
	$("#speedyRcptStateName").focus(function() {
      
         var srcPath = $('#srcPath').val();
			var language = $('#language').val();
			var speedyRcptCountryId = $('#speedyRcptCountryId').val();
			
			$("#speedyRcptStateName").autocomplete({
					delay: 100,
					minLength: 1,
               autoFocus: true, // highlight the first record
					source: function( request, response ) {
					$.ajax({
							url: srcPath + 'api/listStates.php?countryId=' + speedyRcptCountryId + '&language=' + language,
							type: 'GET',
							dataType: 'json',
							data: {
								search: request.term
							},
							success: function(data){
								response(data);
							}
						});
					},
					select: function (event, ui) {
							var speedyRcptStateName = ui.item.label; 
							var speedyRcptStateId = ui.item.value;
							var speedyRcptStateNameEn = ui.item.nameEn; 
							var speedyRcptStateAlpha = ui.item.stateAlpha;
							var speedyRcptStateCountryId = ui.item.countryId;

							// Clear errors and messages
							clearErrorsAndMessages();

							$('#speedyRcptStateId').val(speedyRcptStateId); // display the selected text
							$('#speedyRcptStateName').val(speedyRcptStateName); // save selected id to input

							// If developers info is included (form_variable_state)
							if ( showDeveloperInfo == 'Y' )
									{
									// Clear info fields
									clearInfoFieldsByPartOfIds('speedyRcptSite,speedyRcptOffice,speedyRcptComplex,speedyRcptStreet,speedyRcptBlock,speedyRcptPoi');

									var infoFields = {speedyRcptStateId: speedyRcptStateId,
															speedyRcptStateName: speedyRcptStateName,
															speedyRcptStateNameEn: speedyRcptStateNameEn,
															speedyRcptStateAlpha: speedyRcptStateAlpha,
															speedyRcptStateCountryId: speedyRcptStateCountryId};
									// Fill info fields
									fillInfoFields(infoFields);
									}
									
							return false;
					}
			})

	});




	/* SITES */
	$("#speedyRcptSiteName").focus(function() {
      
         var srcPath = $('#srcPath').val();
			var language = $('#language').val();
			var speedyRcptCountryId = $('#speedyRcptCountryId').val();
			
			$("#speedyRcptSiteName").autocomplete({
					highlightClass: 'ui-autocomplete-match',
					delay: 100,
					minLength: 1,
               autoFocus: true, // highlight the first record
					source: function(request, response) {
					$.ajax({
							url: srcPath + 'api/listSites.php?countryId=' + speedyRcptCountryId + '&language=' + language,
							type: 'GET',
							dataType: 'json',
							data: {
								search: request.term
							},
							success: function(data){
								response(data);
							}
						});
					},

               /*
               change: function (event, ui) {
                  if (!ui.item) {
                     console.log('No');
                     // Clear form fields
							//clearFormFields('speedyRcptSiteType,speedyRcptSiteName,speedyRcptSiteType,speedyRcptSiteAddInfo,speedyRcptPostCode,speedyRcptOfficeId,speedyRcptOfficeName,speedyRcptOfficeAddInfo,speedyRcptComplexId,speedyRcptComplexType,speedyRcptComplexName,speedyRcptStreetId,speedyRcptStreetType,speedyRcptStreetName,speedyRcptStreetNo,speedyRcptBlockNo,speedyRcptEntranceNo,speedyRcptFloorNo,speedyRcptApartmentNo,speedyRcptPoiId,speedyRcptPoiName,speedyRcptAddressNote,speedyRcptSiteNameForeign,speedyRcptAddressLine1,speedyRcptAddressLine2');

                  } else {
                     console.log('Yes');
                  }
               },
               */
               
					select: function (event, ui) {					
							var speedyRcptSiteNameLabel = ui.item.label; 
							var speedyRcptSiteName = ui.item.value;
							var speedyRcptSiteId = ui.item.siteId;
							var speedyRcptSiteCountryId = ui.item.countryId;
							var speedyRcptSiteType = ui.item.type;
							var speedyRcptSitePostCode = ui.item.postCode;
							var speedyRcptSiteRegion = ui.item.region;
							var speedyRcptSiteMunicipality = ui.item.municipality;
							var speedyRcptSiteAddressNomenclature = ui.item.addressNomenclature;
							var speedyRcptSiteX = ui.item.x;
							var speedyRcptSiteY = ui.item.y;
							var speedyRcptSiteServingDays = ui.item.servingDays;
							var speedyRcptSiteServingOfficeId = ui.item.servingOfficeId;

							// Clear errors and messages
							clearErrorsAndMessages();

							// Clear form fields
							clearFormFields('speedyRcptSiteType,speedyRcptSiteName,speedyRcptSiteType,speedyRcptSiteName,speedyRcptSiteAddInfo,speedyRcptPostCode,speedyRcptOfficeId,speedyRcptOfficeName,speedyRcptOfficeAddInfo,speedyRcptComplexId,speedyRcptComplexType,speedyRcptComplexName,speedyRcptStreetId,speedyRcptStreetType,speedyRcptStreetName,speedyRcptStreetNo,speedyRcptBlockNo,speedyRcptEntranceNo,speedyRcptFloorNo,speedyRcptApartmentNo,speedyRcptPoiId,speedyRcptPoiName,speedyRcptAddressNote,speedyRcptSiteNameForeign,speedyRcptAddressLine1,speedyRcptAddressLine2');

							$('#speedyRcptSiteName').val(speedyRcptSiteName); // display the selected text
							$('#speedyRcptSiteId').val(speedyRcptSiteId); // save selected id to input
							$('#speedyRcptSiteType').val(speedyRcptSiteType); 
							$('#speedyRcptSiteAddInfo').val(ui.item.addInfo); 
							
							// Disable address fields by nomen type
							disableFieldsByAddressNomen(speedyRcptSiteAddressNomenclature);

							// Count offices in the selected site
							officesCount(speedyRcptCountryId, speedyRcptSiteId);
							
							// If developers info is included (form_variable_state)
							if ( showDeveloperInfo == 'Y' )
									{
									// Clear info fields
									clearInfoFieldsByPartOfIds('speedyRcptOffice,speedyRcptComplex,speedyRcptStreet,speedyRcptBlock,speedyRcptPoi');

									var infoFields = {speedyRcptSiteId: speedyRcptSiteId,
															speedyRcptSiteCountryId: speedyRcptSiteCountryId,
															speedyRcptSiteType: speedyRcptSiteType,
															speedyRcptSiteName: speedyRcptSiteName,
															speedyRcptSitePostCode: speedyRcptSitePostCode,
															speedyRcptSiteRegion: speedyRcptSiteRegion,
															speedyRcptSiteMunicipality: speedyRcptSiteMunicipality,
															speedyRcptSiteAddressNomenclature: speedyRcptSiteAddressNomenclature,
															speedyRcptSiteX: speedyRcptSiteX,
															speedyRcptSiteY: speedyRcptSiteY,
															speedyRcptSiteServingDays: speedyRcptSiteServingDays,
															speedyRcptSiteServingOfficeId: speedyRcptSiteServingOfficeId};
									// Fill info fields
									fillInfoFields(infoFields);
									}
									
							return false;
					}
			})
			// Two rows label
			.autocomplete('instance')._renderItem = function( ul, item ) {
				return $('<li>')
				  .append('<div>' + item.rowTop + '<br>' + item.rowBottom + '</div>')
				  .appendTo(ul);
			};
	});




	/* OFFICES */
	$("#speedyRcptOfficeName").focus(function() {
         var srcPath = $('#srcPath').val();
			var language = $('#language').val();
			var speedyRcptSiteId = $('#speedyRcptSiteId').val();
			var speedyRcptCountryId = $('#speedyRcptCountryId').val();
			var speedyRcptSiteName = $('#speedyRcptSiteName').val();
			var speedyRcptSiteNameForeign = $('#speedyRcptSiteNameForeign').val();
			var speedyRcptCountryAddressType = $('#speedyRcptCountryAddressType').val();
      	
			$("#speedyRcptOfficeName").autocomplete({
					delay: 100,
					minLength: 1,
               autoFocus: true, // highlight the first record
					source: function(request, response) {
					$.ajax({
							url: srcPath + 'api/listOffices.php?siteId=' + speedyRcptSiteId + '&countryId=' + speedyRcptCountryId + '&language=' + language,
							type: 'GET',
							dataType: 'json',
							data: {
								search: request.term
							},
							success: function(data){
								response(data);
							}
						});
					},
					select: function (event, ui) {
							var speedyRcptOfficeNameLabel = ui.item.label; 
							var speedyRcptOfficeName = ui.item.value;
							var speedyRcptOfficeId = ui.item.id;
							var speedyRcptOfficeSiteId = ui.item.siteId;
							var speedyRcptOfficeSiteName = ui.item.siteName;
							var speedyRcptOfficeFullAddressString = ui.item.fullAddressString;
							var speedyRcptOfficeLocalAddressString = ui.item.localAddressString;
							var speedyRcptOfficeSiteAddressString = ui.item.siteAddressString;
							var speedyRcptOfficeWorkingTimeFrom = ui.item.workingTimeFrom;
							var speedyRcptOfficeWorkingTimeTo = ui.item.workingTimeTo;
							var speedyRcptOfficeWorkingTimeHalfFrom = ui.item.workingTimeHalfFrom;
							var speedyRcptOfficeWorkingTimeHalfTo = ui.item.workingTimeHalfTo;
							var speedyRcptOfficeWorkingTimeDayOffFrom = ui.item.workingTimeDayOffFrom;
							var speedyRcptOfficeWorkingTimeDayOffTo = ui.item.workingTimeDayOffTo;
							var speedyRcptOfficeWidth = ui.item.width;
							var speedyRcptOfficeDepth = ui.item.depth;
							var speedyRcptOfficeHeight = ui.item.height;
							var speedyRcptOfficeMaxParcelWeight = ui.item.maxParcelWeight;
							var speedyRcptOfficeType = ui.item.type;
							var speedyRcptOfficeNearbyOfficeId = ui.item.nearbyOfficeId;
							var speedyRcptOfficePalletOffice = ui.item.palletOffice;
							var speedyRcptOfficeCardPaymentAllowed = ui.item.cardPaymentAllowed;
							var speedyRcptOfficeCashPaymentAllowed = ui.item.cashPaymentAllowed;

							// Clear errors and messages
							clearErrorsAndMessages();

							$('#speedyRcptOfficeName').val(speedyRcptOfficeName); // display the selected text
							$('#speedyRcptOfficeId').val(speedyRcptOfficeId); // save selected id to input
							$('#speedyRcptOfficeAddInfo').val(ui.item.addressString); 
                  
                     if ( speedyRcptCountryAddressType != 1 )
                           {
                           $('#speedyRcptSiteNameForeign').val(speedyRcptOfficeSiteName);
                           }
							
							// If developers info is included (form_variable_state)
							if ( showDeveloperInfo == 'Y' )
									{
									// Clear info fields
									clearInfoFieldsByPartOfIds('speedyRcptComplex,speedyRcptStreet,speedyRcptBlock,speedyRcptPoi');
	
									var infoFields = {speedyRcptOfficeId: speedyRcptOfficeId,
															speedyRcptOfficeName: speedyRcptOfficeName,
															speedyRcptOfficeSiteId: speedyRcptOfficeSiteId,
															speedyRcptOfficeFullAddressString: speedyRcptOfficeFullAddressString,
															speedyRcptOfficeLocalAddressString: speedyRcptOfficeLocalAddressString,
															speedyRcptOfficeSiteAddressString: speedyRcptOfficeSiteAddressString,
															speedyRcptOfficeWorkingTimeFrom: speedyRcptOfficeWorkingTimeFrom,
															speedyRcptOfficeWorkingTimeTo: speedyRcptOfficeWorkingTimeTo,
															speedyRcptOfficeWorkingTimeHalfFrom: speedyRcptOfficeWorkingTimeHalfFrom,
															speedyRcptOfficeWorkingTimeHalfTo: speedyRcptOfficeWorkingTimeHalfTo,
															speedyRcptOfficeWorkingTimeDayOffFrom: speedyRcptOfficeWorkingTimeDayOffFrom,
															speedyRcptOfficeWorkingTimeDayOffTo: speedyRcptOfficeWorkingTimeDayOffTo,
															speedyRcptOfficeWidth: speedyRcptOfficeWidth,
															speedyRcptOfficeDepth: speedyRcptOfficeDepth,
															speedyRcptOfficeHeight: speedyRcptOfficeHeight,
															speedyRcptOfficeMaxParcelWeight: speedyRcptOfficeMaxParcelWeight,
															speedyRcptOfficeType: speedyRcptOfficeType,
															speedyRcptOfficeNearbyOfficeId: speedyRcptOfficeNearbyOfficeId,
															speedyRcptOfficePalletOffice: speedyRcptOfficePalletOffice,
															speedyRcptOfficeCardPaymentAllowed: speedyRcptOfficeCardPaymentAllowed,
															speedyRcptOfficeCashPaymentAllowed: speedyRcptOfficeCashPaymentAllowed};

									// Fill info fields
									fillInfoFields(infoFields);
									}

							return false;
					}
			})
			.autocomplete('instance')._renderItem = function( ul, item ) {
				return $('<li>')
				  .append('<div>' + item.rowTop + '<br>' + item.rowBottom + '</div>')
				  .appendTo(ul);
			};			

	});




	/* COMPLEXES */
	$("#speedyRcptComplexName").focus(function() {
         var srcPath = $('#srcPath').val();
			var language = $('#language').val();
			var speedyRcptSiteId = $('#speedyRcptSiteId').val();
			
			$("#speedyRcptComplexName").autocomplete({
					delay: 100,
					minLength: 1,
               autoFocus: true, // highlight the first record
					source: function(request, response) {
					$.ajax({
							url: srcPath + 'api/listComplexes.php?siteId=' + speedyRcptSiteId + '&language=' + language,
							type: 'GET',
							dataType: 'json',
							data: {
								search: request.term
							},
							success: function(data){
								response(data);
							}
						});
					},
					select: function (event, ui) {
							var speedyRcptComplexNameLabel = ui.item.label; 
							var speedyRcptComplexName = ui.item.value;
							var speedyRcptComplexId = ui.item.id;
							var speedyRcptComplexType = ui.item.type;
							var speedyRcptComplexSiteId = ui.item.siteId;
							var speedyRcptComplexActualId = ui.item.actualId;

							// Clear errors and messages
							clearErrorsAndMessages();

							// Clear form fields
							//clearFormFields('speedyRcptPostCode,speedyRcptComplexId,speedyRcptComplexType,speedyRcptComplexName,speedyRcptStreetId,speedyRcptStreetType,speedyRcptStreetName,speedyRcptStreetNo,speedyRcptBlockNo,speedyRcptEntranceNo,speedyRcptFloorNo,speedyRcptApartmentNo,speedyRcptPoiId,speedyRcptPoiName,speedyRcptAddressNote,speedyRcptSiteNameForeign,speedyRcptAddressLine1,speedyRcptAddressLine2');
                     clearFormFields('speedyRcptComplexId,speedyRcptComplexType,speedyRcptComplexName');
                     
							$('#speedyRcptComplexName').val(speedyRcptComplexName); // display the selected text
							$('#speedyRcptComplexId').val(speedyRcptComplexId); // save selected id to input
							$('#speedyRcptComplexType').val(speedyRcptComplexType); // save selected id to input
							
							// If developers info is included (form_variable_state)
							if ( showDeveloperInfo == 'Y' )
									{
									// Clear info fields
									clearInfoFieldsByPartOfIds('speedyRcptStreet,speedyRcptBlock,speedyRcptPoi');

									var infoFields = {speedyRcptComplexName: speedyRcptComplexName,
															speedyRcptComplexId: speedyRcptComplexId,
															speedyRcptComplexType: speedyRcptComplexType,
															speedyRcptComplexSiteId: speedyRcptComplexSiteId,
															speedyRcptComplexActualId: speedyRcptComplexActualId};

									// Fill info fields
									fillInfoFields(infoFields);
									}

							return false;
					}
			});
	});




	/* STREETS */
	$("#speedyRcptStreetName").focus(function() {
         var srcPath = $('#srcPath').val();
			var language = $('#language').val();
			var speedyRcptSiteId = $('#speedyRcptSiteId').val();
			
			$("#speedyRcptStreetName").autocomplete({
					delay: 100,
					minLength: 1,
               autoFocus: true, // highlight the first record
					source: function(request, response) {
					$.ajax({
							url: srcPath + 'api/listStreets.php?siteId=' + speedyRcptSiteId + '&language=' + language,
							type: 'GET',
							dataType: 'json',
							data: {
								search: request.term
							},
							success: function(data){
								response(data);
							}
						});
					},
					select: function (event, ui) {
							var speedyRcptStreetNameLabel = ui.item.label; 
							var speedyRcptStreetName = ui.item.value;
							var speedyRcptStreetId = ui.item.id;
							var speedyRcptStreetType = ui.item.type;
							var speedyRcptStreetSiteId = ui.item.siteId;
							var speedyRcptStreetActualId = ui.item.actualId;

							// Clear errors and messages
							clearErrorsAndMessages();

							// Clear form fields
							//clearFormFields('speedyRcptPostCode,speedyRcptStreetId,speedyRcptStreetType,speedyRcptStreetName,speedyRcptStreetNo,speedyRcptBlockNo,speedyRcptEntranceNo,speedyRcptFloorNo,speedyRcptApartmentNo,speedyRcptPoiId,speedyRcptPoiName,speedyRcptAddressNote,speedyRcptSiteNameForeign,speedyRcptAddressLine1,speedyRcptAddressLine2');
                     clearFormFields('speedyRcptStreetId,speedyRcptStreetType,speedyRcptStreetName');
                     
							$('#speedyRcptStreetName').val(speedyRcptStreetName); // display the selected text
							$('#speedyRcptStreetId').val(speedyRcptStreetId); // save selected id to input
							$('#speedyRcptStreetType').val(speedyRcptStreetType); 

							// If developers info is included (form_variable_state)
							if ( showDeveloperInfo == 'Y' )
									{
									// Clear info fields
									clearInfoFieldsByPartOfIds('speedyRcptBlock,speedyRcptPoi');
									
									var infoFields = {speedyRcptStreetName: speedyRcptStreetName,
															speedyRcptStreetId: speedyRcptStreetId,
															speedyRcptStreetType: speedyRcptStreetType,
															speedyRcptStreetSiteId: speedyRcptStreetSiteId,
															speedyRcptStreetActualId: speedyRcptStreetActualId};
									// Fill info fields
									fillInfoFields(infoFields);
									}

							return false;
					}
			})
	});




	/* BLOCKS */
	$("#speedyRcptBlockNo").focus(function() {
         var srcPath = $('#srcPath').val();
			var language = $('#language').val();
			var speedyRcptSiteId = $('#speedyRcptSiteId').val();
			
			$("#speedyRcptBlockNo").autocomplete({
					delay: 100,
					minLength: 1,
               autoFocus: true, // highlight the first record
					source: function( request, response ) {
					$.ajax({
							url: srcPath + 'api/listBlocks.php?siteId=' + speedyRcptSiteId + '&language=' + language,
							type: 'GET',
							dataType: 'json',
							data: {
								search: request.term
							},
							success: function(data){
								response(data);
							}
						});
					},
					select: function (event, ui) {
							var speedyRcptBlockNameLabel = ui.item.label; 
							var speedyRcptBlockName = ui.item.value;
							var speedyRcptBlockSiteId = ui.item.siteId;

							// Clear errors and messages
							clearErrorsAndMessages();

							// Clear form fields
							//clearFormFields('speedyRcptPostCode,speedyRcptEntranceNo,speedyRcptFloorNo,speedyRcptApartmentNo,speedyRcptPoiId,speedyRcptPoiName,speedyRcptAddressNote,speedyRcptSiteNameForeign,speedyRcptAddressLine1,speedyRcptAddressLine2');
							clearFormFields('speedyRcptPostCode,speedyRcptSiteNameForeign,speedyRcptAddressLine1,speedyRcptAddressLine2');
                     
							$('#speedyRcptBlockNo').val(speedyRcptBlockName);

							// If developers info is included (form_variable_state)
							if ( showDeveloperInfo == 'Y' )
									{
									// Clear info fields
									clearInfoFieldsByPartOfIds('speedyRcptPoi');
									
									var infoFields = {speedyRcptBlockNo: speedyRcptBlockName,
															speedyRcptBlockSiteId: speedyRcptBlockSiteId};
		
									// Fill info fields
									fillInfoFields(infoFields);
									}
									
							return false;
					}
			});
	});




	/* POI */
	$("#speedyRcptPoiName").focus(function() {
         var srcPath = $('#srcPath').val();
			var language = $('#language').val();
			var speedyRcptSiteId = $('#speedyRcptSiteId').val();
			
			$("#speedyRcptPoiName").autocomplete({
					delay: 100,
					minLength: 1,
               autoFocus: true, // highlight the first record
					source: function( request, response ) {
					$.ajax({
							url: srcPath + 'api/listPois.php?siteId=' + speedyRcptSiteId + '&language=' + language,
							type: 'GET',
							dataType: 'json',
							data: {
								search: request.term
							},
							success: function(data){
								response(data);
							}
						});
					},
					select: function (event, ui) {
							var speedyRcptPoiNameLabel = ui.item.label; 
							var speedyRcptPoiName = ui.item.value;
							var speedyRcptPoiId = ui.item.id;
							var speedyRcptPoiType = ui.item.type;
							var speedyRcptPoiAddress = ui.item.address;
							var speedyRcptPoiSiteId = ui.item.address;
							var speedyRcptPoiX = ui.item.x;
							var speedyRcptPoiY = ui.item.y;

							// Clear errors and messages
							clearErrorsAndMessages();

							$('#speedyRcptPoiId').val(speedyRcptPoiId);
							$('#speedyRcptPoiName').val(speedyRcptPoiName);
							$('#speedyRcptAddressNote').val(speedyRcptPoiAddress);
							
							// Функция зачисваща определени полета при избор на характерен обект
							poiActions('disableFields');

							// If developers info is included (form_variable_state)
							if ( showDeveloperInfo == 'Y' )
									{
									// Clear info fields
									clearInfoFieldsByPartOfIds('speedyRcptOffice,speedyRcptComplex,speedyRcptStreet,speedyRcptBlock');
									
									var infoFields = {speedyRcptPoiId: speedyRcptPoiId,
															speedyRcptPoiName: speedyRcptPoiName,
															speedyRcptPoiSiteId: speedyRcptPoiSiteId,
															speedyRcptPoiType: speedyRcptPoiType,
															speedyRcptPoiAddress: speedyRcptPoiAddress,
															speedyRcptPoiX: speedyRcptPoiX,
															speedyRcptPoiY: speedyRcptPoiY};

									// Fill info fields
									fillInfoFields(infoFields);
									}

							return false;
					}
			})
			.autocomplete('instance')._renderItem = function( ul, item ) {
				return $('<li>')
				  .append('<div>' + item.rowTop + '<br>' + item.rowBottom + '</div>')
				  .appendTo(ul);
			};			
	});



	function split(val) {
		return val.split( /,\s*/ );
	}
	function extractLast(term) {
		return split(term).pop();
	}



	function __highlight(s, t) {
	  var matcher = new RegExp("("+$.ui.autocomplete.escapeRegex(t)+")", "ig" );
	  return s.replace(matcher, "<b>$1</b>");
	}


}); //$().ready(function()




// Clear specific fields when the POI is seleted
function poiActions(action)
		{
		if ( $("#speedyRcptPoiName").val() != '' && action == 'disableFields' )
				{
				$("#speedyRcptComplexId").val('');
				$("#speedyRcptComplexType").val(textComplex);
				document.getElementById('speedyRcptComplexType').disabled = true;
				$("#speedyRcptComplexName").val('');
				document.getElementById('speedyRcptComplexName').disabled = true;
				$("#speedyRcptStreetId").val('');
				$("#speedyRcptStreetType").val(textStreet);
				document.getElementById('speedyRcptStreetType').disabled = true;
				$("#speedyRcptStreetName").val('');
				document.getElementById('speedyRcptStreetName').disabled = true;
				$("#speedyRcptStreetNo").val('');
				document.getElementById('speedyRcptStreetNo').disabled = true;
				$("#speedyRcptBlockNo").val('');
				document.getElementById('speedyRcptBlockNo').disabled = true;
				$("#speedyRcptEntranceNo").val('');
				document.getElementById('speedyRcptEntranceNo').disabled = true;
				$("#speedyRcptFloorNo").val('');
				document.getElementById('speedyRcptFloorNo').disabled = true;
				$("#speedyRcptApartmentNo").val('');
				document.getElementById('speedyRcptApartmentNo').disabled = true;
				document.getElementById('speedyRcptAddressNote').disabled = true;
				}
		else if ( $("#speedyRcptPoiName").val() == '' && action == 'enableFields') 
				{
				$("#speedyRcptComplexId").val('');
				$("#speedyRcptComplexType").val(textComplex);
				document.getElementById('speedyRcptComplexType').disabled = true;
				document.getElementById('speedyRcptComplexName').disabled = false;
				$("#speedyRcptStreetType").val(textStreet);
				document.getElementById('speedyRcptStreetType').disabled = true;
				document.getElementById('speedyRcptStreetName').disabled = false;
				document.getElementById('speedyRcptStreetNo').disabled = false;
				document.getElementById('speedyRcptBlockNo').disabled = false;
				document.getElementById('speedyRcptEntranceNo').disabled = false;
				document.getElementById('speedyRcptFloorNo').disabled = false;
				document.getElementById('speedyRcptApartmentNo').disabled = false;
				$("#speedyRcptAddressNote").val('');
				document.getElementById('speedyRcptAddressNote').disabled = false;
				}
		}




// Clear form fields from the list
function clearFormFields(fieldsList) // input: 'speedyRcptComplexType,speedyRcptComplexName,speedyRcptStreetType,speedyRcptStreetName,speedyRcptStreetNo,speedyRcptBlockNo,speedyRcptEntranceNo,speedyRcptFloorNo,speedyRcptApartmentNo,speedyRcptPoiName,speedyRcptAddressNote,speedyRcptOfficeName,speedyRcptOfficeId,speedyRcptOfficeAddInfo'
		{
      var textSiteType = ''; 
      var textComplexType = ''; 
      var textStreetType = '';
      
      var speedyRcptCountryId = $('#speedyRcptCountryId').val();
      var countriesTypesArray = allAddressDetailsTypesString.split('|'); /* 100;гр./с.;кв./жк;ул./бул.|642;s./or;;str./bld. */
      var numberOfCountries = countriesTypesArray.length; // 
      for ( var y = 0; y < numberOfCountries; y ++ )
            {
            var countryTypesString = countriesTypesArray[y]; // Output: 100;гр./с.;кв./жк;ул./бул.
            var countryTypesArray = countryTypesString.split(';');
            if ( countryTypesArray[0] == speedyRcptCountryId )
                  {
                  textSiteType = countryTypesArray[1]; 
                  textComplexType = countryTypesArray[2]; 
                  textStreetType = countryTypesArray[3]; 
                  }
            }


		var fieldsArray = fieldsList.split(',');
		var numberOfFields = fieldsArray.length;
		for ( var i = 0; i < numberOfFields; i ++ )
				{
				var field = fieldsArray[i]; 
				document.getElementById(field).value = '';
				if ( field == 'speedyRcptSiteType' )
						{ document.getElementById(field).value = textSiteType; } 
            if ( field == 'speedyRcptComplexType' )
						{ document.getElementById(field).value = textComplexType; } 
				if ( field == 'speedyRcptStreetType' )
						{ document.getElementById(field).value = textStreetType; } 
				if ( field == 'pickupOffice' )
						{ document.getElementById(field).checked = false; } 
				}

		}




// Disable address fields by nomen type
function disableFieldsByAddressNomen(addressNomenclature)
		{
		if ( addressNomenclature == 1 )
				{
				$("#speedyRcptComplexType").attr('disabled', true);
				$("#speedyRcptComplexName").attr('disabled', false);
				$("#speedyRcptStreetId").attr('disabled', true);
				$("#speedyRcptStreetType").attr('disabled', true);
				$("#speedyRcptStreetName").attr('disabled', false);
				$("#speedyRcptStreetNo").attr('disabled', false);
				$("#speedyRcptBlockNo").attr('disabled', false);
				$("#speedyRcptEntranceNo").attr('disabled', false);
				$("#speedyRcptFloorNo").attr('disabled', false);
				$("#speedyRcptApartmentNo").attr('disabled', false);
				$("#speedyRcptPoiName").attr('disabled', false);
				$("#speedyRcptAddressNote").attr('disabled', false);
				$("#speedyRcptOfficeName").attr('disabled', false);
				$("#speedyRcptOfficeId").attr('readonly', true);
				$("#speedyRcptOfficeAddInfo").attr('disabled', true);
				} 
		else
				{
				$("#speedyRcptComplexType").attr('disabled', false);
				$("#speedyRcptComplexName").attr('disabled', false);
				$("#speedyRcptStreetId").attr('disabled', true);
				$("#speedyRcptStreetType").attr('disabled', false);
				$("#speedyRcptStreetName").attr('disabled', false);
				$("#speedyRcptStreetNo").attr('disabled', false);
				$("#speedyRcptBlockNo").attr('disabled', false);
				$("#speedyRcptEntranceNo").attr('disabled', false);
				$("#speedyRcptFloorNo").attr('disabled', false);
				$("#speedyRcptApartmentNo").attr('disabled', false);
				$("#speedyRcptPoiName").attr('disabled', false);
				$("#speedyRcptAddressNote").attr('disabled', false);
				$("#speedyRcptOfficeName").attr('disabled', false);
				$("#speedyRcptOfficeId").attr('readonly', true);
				$("#speedyRcptOfficeAddInfo").attr('disabled', true);
				}		
		}



function officeFieldsAction(participant, action)
		{
		if ( participant == 'sender' )
				{
				if ( action == 'enable' )
						{
						$("#sndrOfficeName").attr('disabled', false);
						$("#sndrOfficeId").attr('readonly', true);
						$("#sndrOfficeAddInfo").attr('disabled', true);
						}
				else if ( action == 'disable' )
						{
						$("#sndrOfficeName").attr('disabled', true);
						$("#sndrOfficeId").attr('readonly', true);
						$("#sndrOfficeAddInfo").attr('disabled', true);
						}
				}

		if ( participant == 'recipient' )
				{
				if ( action == 'enable' )
						{
						$("#speedyRcptOfficeName").attr('disabled', false);
						$("#speedyRcptOfficeId").attr('readonly', true);
						$("#speedyRcptOfficeAddInfo").attr('disabled', true);
						}
				else if ( action == 'disable' )
						{
						$("#speedyRcptOfficeName").attr('disabled', true);
						$("#speedyRcptOfficeId").attr('readonly', true);
						$("#speedyRcptOfficeAddInfo").attr('disabled', true);
						}
				}

		}




// Count offices in the selected site
function officesCount(countryId, siteId)
		{
      var srcPath = $('#srcPath').val();         
		var officesCount = '';
		$.ajax({
				type: 'GET',
				url: srcPath + 'api/listOfficesCount.php',
				data: {'countryId':countryId, 'siteId':siteId},
				async: false,
				success: function(response){
						var json = $.parseJSON(response);
						var officesCount = json['officesCount'];
						var error = json['error'];
						if ( error != '' )
								{
								var divErrorRecipient = document.getElementById('divErrorRecipient');
								divErrorRecipient.innerHTML = error;
								divErrorRecipient.style.display = 'block'; 
								}
						else
								{
								// If there are no offices in the city
								if ( officesCount == 0 )
										{
										//changeElementVisibility('pickupOfficeRow', 'none');
										document.getElementById('pickupOffice').disabled = true;
										// Show specific address form
										showAddressForm('localaddress');

										document.getElementById('pickupOffice').checked = false;
										}
								else
										{
										changeElementVisibility('pickupOfficeRow', 'block');
										document.getElementById('pickupOffice').disabled = false;
										}
								}

						},
				error: errorHandler
				});
		}



// Change visibility of element
function changeElementVisibility(id, action)
		{
		document.getElementById(id).style.display = action; 
		}



// Show specific address form
function showAddressForm(addressForm) // localaddress / localoffice / foreign
		{
		if ( addressForm == 'localaddress' )
				{
				changeElementVisibility('fieldsetRecipientSite', 'block');
				changeElementVisibility('fieldsetRecipientAddress', 'block');
				changeElementVisibility('pickupOfficeRow', 'block');
				changeElementVisibility('fieldsetForeignRecipientSite', 'none');
				changeElementVisibility('fieldsetRoreignRecipientAddress', 'none');
				changeElementVisibility('foreignPickupOfficeRow', 'none');
            
				changeElementVisibility('fieldsetRecipientOffice', 'none'); // used for local and foreign addresses
				}
		if ( addressForm == 'localoffice' )
				{
				changeElementVisibility('fieldsetRecipientSite', 'block');
				changeElementVisibility('fieldsetRecipientOffice', 'block');
				changeElementVisibility('fieldsetRecipientAddress', 'none');
				changeElementVisibility('fieldsetRoreignRecipientAddress', 'none');
				}
		if ( addressForm == 'foreignaddress' )
				{
				changeElementVisibility('fieldsetRecipientSite', 'none');
				changeElementVisibility('fieldsetRecipientAddress', 'none');
				changeElementVisibility('pickupOfficeRow', 'none');
				changeElementVisibility('fieldsetForeignRecipientSite', 'block');
				changeElementVisibility('fieldsetRoreignRecipientAddress', 'block');
				changeElementVisibility('foreignPickupOfficeRow', 'block');
            
				changeElementVisibility('fieldsetRecipientOffice', 'none'); // used for local and foreign addresses
				}
		if ( addressForm == 'foreignoffice' )
				{
				changeElementVisibility('fieldsetForeignRecipientSite', 'block');
				changeElementVisibility('fieldsetRecipientOffice', 'block');
				changeElementVisibility('fieldsetRecipientAddress', 'none');
				changeElementVisibility('fieldsetRoreignRecipientAddress', 'none');
            document.getElementById('speedyRcptOfficeName').disabled = false;
				}
		}



function pickupOfficeCheckboxActions(officeLocality)
		{    
      if ( officeLocality == 'localoffice' )
            {
            if ( document.getElementById('pickupOffice').checked == true )
                  {
                  showAddressForm('localoffice'); // localaddress / localoffice / foreign	
                  }
            else
                  {
                  showAddressForm('localaddress');
                  }
            }
      if ( officeLocality == 'foreignoffice' )
            {
            if ( document.getElementById('foreignPickupOffice').checked == true )
                  {
                  showAddressForm('foreignoffice'); // localaddress / localoffice / foreign	
                  }
            else
                  {
                  showAddressForm('foreignaddress');
                  }
            }
         
      // Clear errors and messages
		clearErrorsAndMessages();
      }



// Clear errors and messages
function clearErrorsAndMessages()
		{
		var divErrorRecipient = document.getElementById('divErrorRecipient');
		divErrorRecipient.innerHTML = ''; // errorValidateAddress
		divErrorRecipient.style.display = 'none'; 

		var divMessageRecipient = document.getElementById('divMessageRecipient');
		divMessageRecipient.innerHTML = '';
		divMessageRecipient.style.display = 'none'; 
		}



// Fill info fields
function fillInfoFields(infoFields)
		{
		for ( var infoParam in infoFields )
				{
				var fieldName = 'span_' + infoParam;
				document.getElementById(fieldName).innerHTML = infoFields[infoParam];
				}
		}



// Clear info fields
function clearInfoFieldsByPartOfIds(infoFieldsPartsList) // 'speedyRcptState,speedyRcptSite,...'
		{
		var infoFieldsPartsArray = infoFieldsPartsList.split(',');
		var infoFieldsPartsCount = infoFieldsPartsArray.length;
		
		// For each part of id
		for ( var i = 0; i < infoFieldsPartsCount; i ++ )
				{
				var partSpanName = 'span_' + infoFieldsPartsArray[i];
				
				var elements = document.querySelectorAll('*[id^="' + partSpanName + '"]'); // Get all ids starting with selected part of name
				var elementsArray = Array.prototype.map.call( elements, function( el, i ) {
					 return el.id;
				})

				var elementsCount = elementsArray.length;
				for ( var y = 0; y < elementsCount; y ++ )
						{
						var elementId = elementsArray[y];
						document.getElementById(elementId).innerHTML = ''; // Clear field
						}
				
				}
		}



// Load comlex and street types
function loadTypes()
		{
      var srcPath = $('#srcPath').val();
		var language = $('#language').val();
      var speedyRcptCountryId = $('#speedyRcptCountryId').val();
		$.ajax({
				type: 'GET',
				url: srcPath + 'api/listTypes.php',
				data: {'language':language, 'countryId':speedyRcptCountryId},
				async: false,
				success: function(response){
						var json = $.parseJSON(response);
						var streetTypesString = json['streetTypesString'];
						var complexTypesString = json['complexTypesString'];
                  var defaultSiteType = json['defaultSiteType'];
                  
						// Fill in types in select fields     
                  fillTypes(defaultSiteType, complexTypesString, streetTypesString);					
						},
				error: errorHandler
				});
		}


      
function setFieldToDefault(elementName)
      {

      if ( elementName == 'speedyRcptSiteName' )
            {
            var speedyRcptSiteName = $("#speedyRcptSiteName").val();
            if ( speedyRcptSiteName == '' )
                  {  
                  // Clear form fields
						clearFormFields('speedyRcptSiteType,speedyRcptSiteName,speedyRcptSiteAddInfo,speedyRcptPostCode,speedyRcptOfficeId,speedyRcptOfficeName,speedyRcptOfficeAddInfo,speedyRcptComplexId,speedyRcptComplexType,speedyRcptComplexName,speedyRcptStreetId,speedyRcptStreetType,speedyRcptStreetName,speedyRcptStreetNo,speedyRcptBlockNo,speedyRcptEntranceNo,speedyRcptFloorNo,speedyRcptApartmentNo,speedyRcptPoiId,speedyRcptPoiName,speedyRcptAddressNote,speedyRcptSiteNameForeign,speedyRcptAddressLine1,speedyRcptAddressLine2');
                  }
            }

      if ( elementName == 'speedyRcptComplexName' )
            {
            var speedyRcptComplexName = $("#speedyRcptComplexName").val();
            if ( speedyRcptComplexName == '' )
                  { 
                  // Clear form fields
						clearFormFields('speedyRcptComplexId,speedyRcptComplexType,speedyRcptComplexName');
                  }
            }
      
      if ( elementName == 'speedyRcptStreetName' )
            {
            var speedyRcptStreetName = $("#speedyRcptStreetName").val();
            if ( speedyRcptStreetName == '' )
                  { 
                  // Clear form fields
                  clearFormFields('speedyRcptStreetId,speedyRcptStreetType,speedyRcptStreetName');
                  }
            }
      
      }
      
      
      
// Fill in types in select fields. Added at 25.02.2020. @since 3.2.3.
function fillTypes(defaultSiteType, complexTypesString, streetTypesString)
      {
      $("#speedyRcptSiteType").val(defaultSiteType);
      
      // Clear all options
      document.getElementById('speedyRcptComplexType').options.length = 0;
      document.getElementById('speedyRcptStreetType').options.length = 0;    
      
      // Complex types
      var complexTypesArray = complexTypesString.split(';');
      var complexTypesArrayLength = complexTypesArray.length;
      for ( var i = 0; i < complexTypesArrayLength; i ++ )
            {
            var complexType = complexTypesArray[i];
            var optionComplexType = document.createElement('option');
            optionComplexType.setAttribute('value', complexType);
            optionComplexType.appendChild(document.createTextNode(complexType));
            document.getElementById('speedyRcptComplexType').appendChild(optionComplexType);
            }


      // Street types
      var streetTypesArray = streetTypesString.split(';');
      var streetTypesArrayLength = streetTypesArray.length;
      for ( var y = 0; y < streetTypesArrayLength; y ++ )
            {
            var streetType = streetTypesArray[y];
            var optionStreetType = document.createElement('option');
            optionStreetType.setAttribute('value', streetType);
            optionStreetType.appendChild(document.createTextNode(streetType));
            document.getElementById('speedyRcptStreetType').appendChild(optionStreetType);
            }     
      }      
      