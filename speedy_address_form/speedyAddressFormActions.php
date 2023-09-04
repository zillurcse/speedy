<?php
   
/*
The file contains only the button, which triggered the Speedy address form.
The function "formActions" is in the "speedyAddressFormActions.js" file, where is the function validateAddress.
You have to change the function 'formActions' according your purposes. 
*/

$body1=<<<B1
<div align="center">
   <div class="speedyAddressFormActions"><input type="button" id="buttonForm" name="buttonForm" value="$textButtonForm" class="inputButtonForm" onClick="formActions()"></div>
</div>
B1;
echo $body1;

?>