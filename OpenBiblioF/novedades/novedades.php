<?php

include ("../conexiondb.php");
echo "<div align=\"center\">\n";
$sql="SELECT id,titulo,descripcion,fecha_alta,fecha_vencimiento FROM novedades WHERE (fecha_vencimiento > CURRENT_DATE) or (fecha_vencimiento is NULL) ORDER BY fecha_alta DESC" ;
$resultado_set = mysql_query($sql,$conexion);
$filas = mysql_num_rows($resultado_set);
echo "<h3>Novedades</h3>\n";
echo "<div>&nbsp;</div>\n";
if ($filas > 0)
	{
	echo "<table class=\"primary\" cellspacing=\"2\" border=\"1\" border-color=\"#000000\" width=\"60%\">\n";
	while($resultado_array = mysql_fetch_array($resultado_set))
		{
    		$auxfecha = split(" ",$resultado_array["fecha_alta"]);
		$auxfecha2 = split("-",$auxfecha[0]);
		echo "<tr><th><span style='font-size: 8px'>$auxfecha2[2]/$auxfecha2[1]/$auxfecha2[0] - </span>\n";
		echo $resultado_array["titulo"]."</th></tr>";
		echo "<tr><td>".nl2br($resultado_array["descripcion"])."<br><br></td></tr>";
		}
	echo "</table>\n";
	}
mysql_close($conexion);

?>
