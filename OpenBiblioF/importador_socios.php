<?
echo "<html>
<head>
<style>
input.button {
  background-color: #CCCC99;
  border-color: #CCCC99;
  border-left-color: #CCCC99;
  border-top-color: #CCCC99;
  border-bottom-color: #CCCC99;
  border-right-color: #CCCC99;
  padding: 2;
  font-family: verdana,arial,helvetica;
  color: #000000;
}
</style>
<title>Importador SIUNPA</title></head>";
/*******************************************/
/*    CONEXION A LA BASE DE DATOS          */
/*******************************************/
if(isset($_POST["aprobado"]))
{
require_once("database_constants.php");
$link = mysql_connect(OBIB_HOST,OBIB_USERNAME,OBIB_PWD);
mysql_select_db(OBIB_DATABASE,$link);

/******************************************************/
/*   DECLARO ARRAY DE ARCHIVOS Y TABLAS AUXILIARES    */
/******************************************************/
$files=array("c:/member.txt"=>"member");
			 
/****************************************************/
/*       REALIZO UN BACKUP UNICO DE LA TABLA        */
/****************************************************/			 
foreach($files as $table)
  {
   mysql_query("select * into outfile 'c:/".$table."_".date('Y-m-d')."_".time().".backup' fields terminated by ';' from $table");
   $error=mysql_error();
   if(!empty($error))
      echo "<li>Ocurrio el siguiente error al realizar el backup de la tabla $table: ".mysql_error()." </li><br>";
  } 
  
/*****************************************************************/
/*  LEO EL ARCHIVO .CSV Y REALIZO INSERCIONES, ACTUALIZACIONES   */
/*****************************************************************/			 
$file=$_FILES["member_file"]["tmp_name"];
$fp = fopen ( $file , "r" );
$first=true;
$notFirst=false;
$error="";
$socios_updated=0;
$socios_inserted=0;
$row=array(
"barcode_nmbr"=>"DNI",
"last_name"=>"APELLIDO",
"first_name"=>"NOMBRE",
"address1"=>"DIRECCION",
"city"=>"CIUDAD",
"state"=>"PROVINCIA",
"home_phone"=>"TELEFONO",
"email"=>"EMAIL",
"classification"=>"CLASIFICACION");

while (( $data_line = fgetcsv ( $fp , 1000 , "," )) !== FALSE ) { //lineas del .CSV
      /****************************************************************/
	  /*  CHECKEO LA MISMA CANTIDAD DE COLUMNAS ENTRE ARCHIVO Y TABLA */
	  /****************************************************************/
	  $linea=implode(" ",$data_line);
	  $data=explode(";",$linea);
      if($first)
	     {
		  $first=false;
	      $i=0;
          foreach($row as $key=>$value)
             {
	          if($value!=$data[$i])
			     {
				  $error="<li>El archivo .CSV no contiene los mismos campos que la tabla Member, cerca de ".$data[$i]."</li><br>";
				  echo $error;
				  break;
				 }
			  $i++;
	         }
	     }
      /****************************************************************/
	  /*  SINO ENCONTRE ERRORES, COMIENZO A ACTUALIZAR LA TABLA       */
	  /****************************************************************/		 
	  if(empty($error) && $notFirst)
	    {      
		 $i=0;
		 $member_array=array();
         foreach($row as $key=>$value)//obtengo un array con los datos de cada linea de socio leida.
              {
		       $member_array[$key]=$data[$i];
			   $i++;
	          }
         $dni=str_replace(".","",$member_array["barcode_nmbr"]);
	     $exists="select * from member where barcode_nmbr='".$dni."'";
	     $result=mysql_query($exists,$link);
	     if(mysql_num_rows($result)>0)//ACTUALIZO
	        {
		     $update="UPDATE member SET ";
		     $i=0;
             foreach($row as $key=>$value)
                  {
				   if($key!="barcode_nmbr")
				    {				  
				    if(is_numeric($data[$i]))
				      $update.=$key."=".$data[$i].", ";
			        else
				      $update.=$key."='".$data[$i]."', ";
					}
			      $i++;
			      }
		     $update.="barcode_nmbr='".$dni."' where barcode_nmbr=".$dni;
		     mysql_query($update,$link);
		     $error=mysql_error();
		     if(!empty($error))
		       echo "<li>Ocurrio el siguiente error al actualizar la tabla de socios: ".$error."</li><br>";
			 else
			   $socios_updated++;
		     }
	     else//INSERTO
	        {
		     $insert="INSERT INTO member SET 	";
		     $i=0;
             foreach($row as $key=>$value)
                  {
				   if($key!="barcode_nmbr")
				    {
			         if(is_numeric($data[$i]))
			            $insert.=$key."=".$data[$i].", ";
			         else
				        $insert.=$key."='".$data[$i]."', ";
					}
				  $i++;
	              }		 
		     $insert.=" barcode_nmbr='$dni', libraryid=5, limite_prestamos=3, limite_reservas=3 ";
			 if($dni!="")
			   {
		       mysql_query($insert,$link);
		       $error=mysql_error();
			   }
		     if(!empty($error))
		        echo "<li>Ocurrio el siguiente error al actualizar la tabla de socios: ".$error."</li><br>";
		     else
			    $socios_inserted++;		 
		     }
	     }
		 $notFirst=true;
}
fclose ( $fp );
}
echo "<center>Se actualizaron $socios_updated socios, y se insertaron $socios_inserted socios.</center>";
echo "<center><input class='button' type='button' name='cerrar' value='Cerrar' onClick='self.close()'></center>";
?>