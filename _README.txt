Speedy Address Widget v.3.4.0 (29 September 2021)
------------------------------------------------
Speedy address form is based on the Speedy REST API: https://api.speedy.bg/web-api.html 


1. System requirements
  - PHP with started 'php_curl.dll' library. (tested with PHP 7.1.23)


2. Description of files
 - speedyAddressForm.php - Main address form.
 - speedyAddressForm.js - Java script functions.
 - speedyAddressFormActions.js - File with main java script function which validate the address from the form. It should be modyfied by the user according your purposes.
 - speedyAddressForm.css - Default widget css.
 - libraryAddressForm.php - Library with some settings.
 - libraryAddressFormBg.php - Language library file with form labels, messages and errors.
 - libraryAddressFormEn.php - Language library file with form labels, messages and errors.
 - languages.php 
 - functionsAddressForm.php - Functions used to access Speedy REST API and simple validations.
 - formVariablesState.php - File with description of variables returned from the API. Used for developers purposes. Can be included by changing the "showDeveloperInfo" variable in the "libraryAddressForm.php" file.
 - speedyCredentials.php - Credentials for Speedy REST API used by files in the "api/" directory. 
   The path to credentials file should be described in the "speedyCredentialsPath" variable in the "libraryAddressForm.php" file;
 - demo.php - Example file with integrated Speedy address form;
 - api/.. - Files for API methods;
 - api/validateAddress.php - File which validate the address in the form via AJAX request;

It is strongly recommended the 'speedyCredentials.php' file to be moved to another directory outside the project! 


3. How to use the form?
 - Set your credentials in the "speedyCredentials.php" file. (It is strongly recommended the 'speedyCredentials.php' file to be moved to another directory outside the project!);
 - In the "speedyAddressForm.php" at the first row set the path to the speedy address form forlder.
 - In the "libraryAddressForm.php" file, set the path to "speedyCredentials.php" file in the "speedyCredentialsPath" variable. Note that the files which are using this credentials are placed in the "api/" directory.
 - Set the default language in the "languages.php" file.
 - Include the "speedy_address_form/speedyAddressForm.php" in your project.
 - Modify the "speedy_address_form/speedyAddressFormActions.js" for your purposes.


4. Change log:

3.4.0. - 27 September 2021
- Improved behavior of the "Pickup office" checkbox, which allows selecting an office in different countries.
- Improved visualization of the autocomplete labels.


3.3.0. - 29 July 2021
- Chnaged file structure and parf of the code for easy implementation in different projects.


3.2.4. - 15 December 2020
- Changed visibility of the "Pickup office" label regardless of the number of the offices in selected city/village. The label is always displayed.


3.2.3. - 25 February 2020
- Fixed bug with validation for Romanian addresses.
- Added new functions 'convertTypesToStrings' and 'allTypesToString' in 'functionsAddressForm.php'.
- Changed 'listTypes.php' and 'listCountries.php' files.
- Added new function 'fillTypes' in 'speedyAddressForm.js'.
- Changed 'speedyAddressForm.js' and 'speedyAddressFormActions.js' files.
- Added new params and labels in 'libraryAddressFormBG.php' and 'libraryAddressFormEN.php'.
- Changed 'api/validateAddress.php' file.


3.2.2. - 20 December 2019
- Renamed files "libraryAddressFormBg.php" and "libraryAddressFormEn.php" to "libraryAddressFormBG.php" and "libraryAddressFormEN.php";
- Fixed bug in "speedyAddressForm.php" related with the libraries file names.


3.2.1. - 04 December 2019
- Added missing label name "New name" in the language libraries (libraryAddressFormBg.php and libraryAddressFormEn.php);


3.2. - 01 December 2019.
- Added "autoFocus: true" option to each autocomplete field to highlight the first record;
- Added role attribute to input fields to prevent autofill address in Chrome;
- Improved behavior of the address type fields "speedyRcptSiteType", "speedyRcptComplexType" and "speedyRcptStreetType";
- Fixed bug with the "speedyRcptBlockNo" field;


3.1. - 01 November 2019.
- The begining of the REST based form;


For any technical questions, please contact us at: api.support@speedy.bg