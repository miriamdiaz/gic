<?
/*******************************************/
/*    CONEXION A LA BASE DE DATOS          */
/*******************************************/
session_start();
echo "<html>";
echo "<style>input.button {
  background-color: #CCCC99;
  border-color: #CCCC99;
  border-left-color: #CCCC99;
  border-top-color: #CCCC99;
  border-bottom-color: #CCCC99;
  border-right-color: #CCCC99;
  padding: 2;
  font-family: verdana,arial,helvetica;
  color: #000000;
}</style>";
echo "<head><title>Exportador SIUNPA</title></head>";
$autorizado=false;
if(isset($_SESSION["hasExportarAuth"]))
   $autorizado=$_SESSION["hasExportarAuth"];
if($autorizado)
{
require_once("database_constants.php");
$link = mysql_connect(OBIB_HOST,OBIB_USERNAME,OBIB_PWD);
mysql_select_db(OBIB_DATABASE,$link);

/*******************************************/
/*   DECLARO ARRAY DE ARCHIVOS Y TABLAS    */
/*******************************************/
$files=array("c:/biblio.txt"=>"biblio",
             "c:/biblio_copy.txt"=>"biblio_copy",
			 "c:/collection_dm.txt"=>"collection_dm",
			 "c:/material_type_dm.txt"=>"material_type_dm",
			 "c:/biblio_fotos.txt"=>"biblio_fotos",
			 "c:/biblio_field.txt"=>"biblio_field",
			 "c:/biblio_cod_library.txt"=>"biblio_cod_library",
			 "c:/biblio_analitica.txt"=>"biblio_analitica",
			 "c:/biblio_index.txt"=>"biblio_index",
			 "c:/biblio_status_dm.txt"=>"biblio_status_dm");
			 
/*******************************************/
/*  RECORRO EL ARRAY Y EXPORTO CADA TABLA  */
/*******************************************/
foreach($files as $file=>$table_name)
{
$sql="select *
into outfile '$file' fields terminated by ';'
from $table_name";
mysql_query($sql,$link);
$error=mysql_error();
if(empty($error))
    echo "<li>Se exporto exitosamente la tabla $table_name a $file </li><br>";
else
    echo "<li>Ocurrio el siguiente error al exportar la tabla $table_name a $file: ".mysql_error()." </li><br>";
}
echo "<center><input class='button' type='button' name='cerrar' value='Cerrar' onClick='self.close()'></center>";
}
else
echo "<li>No esta autorizado para esta operación.</li>";
echo "</html>";
?>