<?php
	
	$language = ( isset($_GET['language']) ) ? $_GET['language'] : DEFAULT_LANGUAGE;

	if ( strtoupper($language) != 'EN' ) 
			{ $language = DEFAULT_LANGUAGE; }
		
?>