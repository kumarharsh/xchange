<?php
   // include security image class
   require('includes/security-image.inc.php');
   
   // start PHP session
   session_start();
   
   // get parameters
   isset($_GET['width']) ? $iWidth = (int)$_GET['width'] : $iWidth = 150;
   isset($_GET['height']) ? $iHeight = (int)$_GET['height'] : $iHeight = 30;
   
   // create new image
   $oSecurityImage = new SecurityImage($iWidth, $iHeight);
   if ($oSecurityImage->Create()) {
      // assign corresponding code to session variable 
      // for checking against user entered value
      $_SESSION['code'] = $oSecurityImage->GetCode();
   } else {
      echo 'Image GIF library is not installed.';
   }
?>
