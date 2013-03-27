<?
include ("../conexiondb.php");
$result = mysql_query("SELECT foto FROM biblio_fotos WHERE bibid=".$_GET["bibid"]);
header("Content-Type: image/gif");
if($row = mysql_fetch_array($result))
   {
    echo $row[0];
   }
else
   {
    $image = imagecreatefromjpeg("../images/logotipo.jpeg");
    imagejpeg($image);
    $imagen = ob_get_contents();
    ob_end_clean();
    $imagen = str_replace('##','\#\#',mysql_escape_string($imagen));	
	echo $imagen;
   }
mysql_close( $conexion );
?>
																														