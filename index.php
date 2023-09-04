<!DOCTYPE html>
<html>
<head>
<link href="index.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Speedy address form</title>
</head>
<body>
<?php

	$language = 'BG';
	if ( isset($_GET['language'])  )
					{ 
					$language = strtoupper($_GET['language']); 
					}
	
	if ( $language == 'BG' )
			{
			$textPageTitle = 'Спиди адресна форма';
			$textDemoImplementation = 'Примерна интеграция'; 
			$textDetailedDemo = 'Детайлна адресна форма за разработчици'; 
			$textSimpleDemo = 'Опростена адресна форма'; 
         $textDownloadForm = 'Сваляне на Спиди адресна форма'; 
			$textAboutForm = 'За формата'; 
			$textLanguageVersion = 'English version'; 
			$languageForChange = 'EN';
			}
	else
			{
			$textPageTitle = 'Speedy address form';
			$textDemoImplementation = 'Demo implementation'; 
			$textDetailedDemo = 'Detailed demo address form for developers'; 
			$textSimpleDemo = 'Simple address form'; 
         $textDownloadForm = 'Download Speedy address form'; 
			$textAboutForm = 'About Speedy address form'; 
			$textLanguageVersion = 'Българска версия'; 
			$languageForChange = 'BG';
			}		

   $textDemoFormMode = $textDetailedDemo;
   $linkDemoFormMode = "?showDeveloperInfo&language=$language";
   if ( isset($_GET['showDeveloperInfo']) )
         {
         $textDemoFormMode = $textSimpleDemo;
         $linkDemoFormMode = "?language=$language";
         }
   
$body10=<<<B10
<div class="divIndexWidgetTitle">$textPageTitle</div>
<div class="divIndexLinks">
   <p><a href="demo.php?language=$language" class="aIndex" target="_blank">$textDemoImplementation</a></p>
   <p><a href="$linkDemoFormMode" class="aIndex">$textDemoFormMode</a></p>
   <p><a href="http://demo.speedy.bg/address_form/downloads/speedy_address_form_v.3.4.0.rar" class="aIndex">$textDownloadForm</a></p>
   <p><a href="_README.txt" class="aIndex" target="_blank">$textAboutForm</a></p>
   <br><p><a href="?language=$languageForChange" class="aIndex">$textLanguageVersion</a></p>
</div>
B10;
echo $body10;

	#-> Speedy address form
   include('speedy_address_form/speedyAddressForm.php');

	#-> Include Speedy address form button
	include('speedy_address_form/speedyAddressFormActions.php');
   
?>
</body>
</html>