<?php /*../catalog/biblio_copy_new.php*/?>
<?php 
echo " ".$_POST["bibid"]." antes ". $_POST["barcodeNmbr"]." ".$_POST["copyDesc"]
." ". $_POST["copyVolumen"] 
." ".  $_POST["copyTomo"]
." ".  $_SESSION["userid"]
." ".  $_POST["copyProveedor"]  
." ".  $_POST["copyPrecio"]  
." ".$_POST["copyCodLoc"] 
." ".$_POST["list_day"] 
." ".$_POST["list_month"] 
." ".$_POST["list_year"] ;
$fecha=$_POST["list_day"]."-".$_POST["list_month"]."-".$_POST["list_year"] ;
$_POST["fecha"]=$fecha;

?>