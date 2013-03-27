<?
include ("../conexiondb.php");
$result = mysql_query("SELECT image_file FROM material_type_dm WHERE code=".$_GET["code"]);
$row = mysql_fetch_array($result);
header("Content-Type: image/gif");
if(!empty($row[0]))
   {
    echo $row[0];
   }
else
   {
/*    $image = imagecreatefromjpeg("../images/logotipo.jpeg");
    imagejpeg($image);
    $imagen = ob_get_contents();
    ob_end_clean();
    $imagen = str_replace('##','\#\#',mysql_escape_string($imagen));		
	echo $imagen;*/
    $result2 = mysql_query("SELECT logotipo FROM settings");
	$row2 = mysql_fetch_array($result2);
	echo $row2[0];
   }
mysql_close( $conexion );
?>
																														