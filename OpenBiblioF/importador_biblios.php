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
$continue = true;
require_once("database_constants.php");
$link = mysql_connect(OBIB_HOST,OBIB_USERNAME,OBIB_PWD);
mysql_select_db(OBIB_DATABASE,$link);

/******************************************************/
/*   DECLARO ARRAY DE ARCHIVOS Y TABLAS AUXILIARES    */
/******************************************************/
$files=array("c:/biblio_files/biblio.txt"=>"biblio",
			 "c:/biblio_files/biblio_fotos.txt"=>"biblio_fotos",
             "c:/biblio_files/biblio_copy.txt"=>"aux_biblio_copy",
			 "c:/biblio_files/biblio_analitica.txt"=>"biblio_analitica",
			 "c:/biblio_files/collection_dm.txt"=>"collection_dm",
			 "c:/biblio_files/material_type_dm.txt"=>"material_type_dm",
			 "c:/biblio_files/biblio_field.txt"=>"biblio_field",
			 "c:/biblio_files/biblio_cod_library.txt"=>"aux_biblio_cod_library",
			 "c:/biblio_files/biblio_index.txt"=>"biblio_index",
			 "c:/biblio_files/biblio_status_dm.txt"=>"biblio_status_dm");
			 
/******************************************************/
/*       REALIZO UN BACKUP UNICO DE LAS TABLAS        */
/******************************************************/			 
foreach($files as $table)
  {
   $file_name = "c:/biblio_backup/".$table."_".date('Y-m-d')."_".time().".backup";
   mysql_query("select * into outfile '$file_name' fields terminated by ';' from $table");
   $error=mysql_error();
   if(!empty($error))
     {
      echo "<li>Ocurrio el siguiente error al realizar el backup de la tabla $table: ".mysql_error()." </li><br>";
	  $continue = false;
	  }
  } 
			 
/****************************************************************/
/*  RECORRO EL ARRAY E IMPORTO CADA ARCHIVO A TABLAS AUXILIARES */
/****************************************************************/				  
if($continue)
{
foreach($files as $file=>$aux_table)
{
mysql_query("delete from $aux_table",$link);
$sql="load data infile '$file'
into table $aux_table
fields terminated by ';'";
mysql_query($sql,$link);
$error=mysql_error();
if(empty($error))
    echo "<li>Se importo exitosamente desde el archivo $file a la tabla $aux_table</li><br>";
else
   {
    echo "<li>Ocurrio el siguiente error al importar desde el archivo $file a la tabla $aux_table: ".mysql_error()." </li><br>";
	$continue = false;
   }
}
}	


/********************************************************************/
/*  HAGO UNA COPIA DE ESTAS TABLAS A TABLAS IDENTICAS SIN INDICES   */
/********************************************************************/
$noindex = array("biblio_copy"=>"aux_biblio_copy_noindex",
                 "biblio_hold"=>"aux_biblio_hold_noindex",
			     "biblio_status_hist"=>"aux_biblio_status_hist_noindex");
if($continue)
{
foreach($noindex as $tabla=>$tabla_aux_noindex)
   {
    $file_name = "c:/biblio_backup/".$tabla."_".date('Y-m-d')."_".time().".backup";
    mysql_query("select * into outfile '$file_name' fields terminated by ';' from $tabla");
    $error=mysql_error();
    if(!empty($error))
	  {
      echo "<li>Ocurrio el siguiente error al realizar el backup de la tabla $tabla: ".mysql_error()." </li><br>";
	  $continue = false;
	  }
	  
	mysql_query("delete from $tabla_aux_noindex",$link);     
    $sql="load data infile '$file_name'
    into table $tabla_aux_noindex
    fields terminated by ';'";
    mysql_query($sql,$link);
    $error=mysql_error();
    if(empty($error))
       echo "<li>Se importo exitosamente desde el archivo $file_name a la tabla $tabla_aux_noindex</li><br>";
    else
	   {
       echo "<li>Ocurrio el siguiente error al importar desde el archivo $file_name a la tabla $tabla_aux_noindex: ".mysql_error()." </li><br>";
	   $continue = false;
	   }
	}
}
/********************************************************/
/*  COMIENZA EL PROCESO DE ACTUALIZACION DE LAS TABLAS  */
/*  UTILIZANDO LAS TABLAS AUXILIARES                    */
/********************************************************/
$biblio_copy_inserted = 0;
$biblio_copy_updated = 0;
$biblio_hold_updated = 0;
$biblio_status_hist_updated = 0;
if($continue)
  {
  /******************************************************/
  /*              TABLA BIBLIO COPY                     */
  /******************************************************/
   $query="select * from aux_biblio_copy";
   $result=mysql_query($query,$link);
   $i = 0;
   while(($row=mysql_fetch_array($result)) && $continue)
        {
		 $bibid=$row["bibid"];
		 $copyid=$row["copyid"];
		 $copy_desc=$row["copy_desc"];
		 $barcode_nmbr=$row["barcode_nmbr"];
		 $new_status_cd=$row["status_cd"];
		 $copy_volumen=$row["copy_volumen"];
		 $copy_tomo=$row["copy_tomo"];
		 $copy_user_creador=$row["copy_user_creador"];
		 $copy_proveedor=$row["copy_proveedor"];
		 $copy_proveedor=str_replace("\""," ",$copy_proveedor);
		 $copy_precio=$row["copy_precio"];
		 $copy_cod_loc=$row["copy_cod_loc"];
		 $copy_date_sptu=$row["copy_date_sptu"];
		 $aprob_flg=$row["aprob_flg"];
		 $i++;
		 $exists="select * from aux_biblio_copy_noindex where barcode_nmbr like \"$barcode_nmbr\" ";
		 $result_exists=mysql_query($exists,$link);
		 $num_rows=mysql_num_rows($result_exists);
		 if($num_rows==0 && $barcode_nmbr !="")//inserta
		    {
		     if($copy_precio=="" || empty($copy_precio))
		        $copy_precio = 0;		    	
			 $insert="insert into aux_biblio_copy_noindex ";
			 $insert.="(bibid,copyid,copy_desc,barcode_nmbr,status_cd,status_begin_dt,copy_volumen,copy_tomo,";
			 $insert.="copy_user_creador,copy_proveedor,copy_precio,copy_cod_loc,copy_date_sptu,aprob_flg) ";
			 $insert.="values ($bibid, $copyid, \"$copy_desc\", \"$barcode_nmbr\",\"in\",current_date,\"$copy_volumen\",\"$copy_tomo\",$copy_user_creador,";
			 $insert.="\"$copy_proveedor\",$copy_precio,$copy_cod_loc,\"$copy_date_sptu\",$aprob_flg)";
			 mysql_query($insert,$link);
//			 echo "INSERT: ".$insert."<br>";
			 $error=mysql_error($link);
			 if(!empty($error))
			   {
			    echo "<li>Error al ejecutar la siguiente linea: $exists - $insert, Error: ".$error." </li><br>";
				$continue = false;
			   }
			 else
			   {
			    $biblio_copy_inserted++;
			    $delete = "DELETE FROM aux_biblio_copy_noindex WHERE bibid = $bibid AND copyid = $copyid AND barcode_nmbr != '$barcode_nmbr'";
				mysql_query($delete,$link);
			    $error=mysql_error($link);
//				echo "DELETE: ".$delete."<br>";
			    if(!empty($error))
			      {
			       echo "<li>Error al ejecutar la siguiente linea: $exists - $delete, Error: ".$error." </li><br>";
				   $continue = false;
			      }
			   }
			}
	     else if($barcode_nmbr !="")//actualiza
		    {
			 $row2 = mysql_fetch_array($result_exists);
			 $old_bibid = $row2["bibid"];
			 $old_copyid = $row2["copyid"];
			 $status_cd = $row2["status_cd"];
			 
		     if($copy_precio=="" || empty($copy_precio))
		        $copy_precio = 0;
		     $update="update aux_biblio_copy_noindex ";
			 $update.="set bibid=$bibid ";
			 if(($status_cd != "out" && $status_cd != "hld") && $status_cd != "crt")
			    $update.=", status_cd = \"$new_status_cd\" ";
			 $update.=", copyid=$copyid ";
		     $update.=", copy_desc=\"$copy_desc\" ";
		     $update.=", barcode_nmbr=\"$barcode_nmbr\" ";
		     $update.=", copy_volumen=\"$copy_volumen\" ";
		     $update.=", copy_tomo=\"$copy_tomo\" ";
		     $update.=", copy_user_creador=$copy_user_creador ";
		     $update.=", copy_proveedor=\"$copy_proveedor\" ";
		     $update.=", copy_precio=$copy_precio ";
		     $update.=", copy_cod_loc=$copy_cod_loc ";
		     $update.=", copy_date_sptu=\"$copy_date_sptu\" ";
		     $update.=", aprob_flg=$aprob_flg ";
		     $update.="where barcode_nmbr like \"$barcode_nmbr\" ";
		     mysql_query($update,$link);
		     $error=mysql_error();
		     if(!empty($error))
			    {
		        echo "<li>Error al ejecutar la siguiente linea: $update , Error: ".$error." </li><br>";			
				$continue = false;
				}
			 else	
			    {
				$biblio_copy_updated++;
			    $delete = "DELETE FROM aux_biblio_copy_noindex WHERE bibid = $bibid AND copyid = $copyid AND barcode_nmbr != '$barcode_nmbr'";
				mysql_query($delete,$link);
			    $error=mysql_error($link);
//				echo "DELETE: ".$delete."<br>";
			    if(!empty($error))
			      {
			       echo "<li>Error al ejecutar la siguiente linea: $exists - $delete, Error: ".$error." </li><br>";
				   $continue = false;
			      }				
				  				
				 $update = "UPDATE aux_biblio_hold_noindex SET bibid = $bibid, copyid = $copyid WHERE bibid = $old_bibid AND copyid = $old_copyid ";
		         mysql_query($update,$link);
		         $error=mysql_error();
		         if(!empty($error))
				    {
		            echo "<li>Error al ejecutar la siguiente linea: $update , Error: ".$error." </li><br>";
					$continue = false;
					}
				 else
				    {	
					 $biblio_hold_updated++;
				     $update = "UPDATE aux_biblio_status_hist_noindex SET bibid = $bibid, copyid = $copyid WHERE bibid = $old_bibid AND copyid = $old_copyid ";
		             mysql_query($update,$link);
		             $error=mysql_error();
		             if(!empty($error))
					   {
		                echo "<li>Error al ejecutar la siguiente linea: $update , Error: ".$error." </li><br>";
						$continue = false;
					   }
					 else
					   $biblio_status_hist_updated++;
					}
				}
			}
		}
  }
    
if($continue)  
{
  /******************************************************/
  /*              TABLA BIBLIO_COD_LIBRARY              */
  /******************************************************/ 
   $query="select * from aux_biblio_cod_library";
   $result=mysql_query($query,$link);
   $i = 0;
   while(($row=mysql_fetch_array($result)) && $continue)
        {
		 $code=$row["code"];
		 $description=$row["description"];
		 $default_flg=$row["default_flg"];
		 $prestamos_flg=$row["prestamos_flg"];
		 $exists="select * from biblio_cod_library where code = $code ";
		 $result_exists=mysql_query($exists,$link);
		 $num_rows=mysql_num_rows($result_exists);
		 if($num_rows==0)//inserta
		    {
			 $insert="insert into biblio_cod_library ";
			 $insert.="(code, description, default_flg, prestamos_flg) ";
			 $insert.="values ($code, \"$description\", \"$default_flg\",\"$prestamos_flg\")";
			 mysql_query($insert,$link);
			 $error=mysql_error($link);
			 if(!empty($error))
			   {
			    echo "<li>Error al ejecutar la siguiente linea: $exists - $insert, Error: ".$error." </li><br>";
				$continue = false;
			   }
			}
	     else //actualiza
		    {
		     $update="update biblio_cod_library ";
			 $update.="set code=$code ";
		     $update.=", description=\"$description\" ";
		     $update.="where code = $code ";
		     mysql_query($update,$link);
		     $error=mysql_error();
		     if(!empty($error))
			    {
		        echo "<li>Error al ejecutar la siguiente linea: $update , Error: ".$error." </li><br>";			
				$continue = false;
				}
			}
		}  
}
  
  
  /*********************************************************/
  /*  LLENO LAS TABLAS ORIGINALES CON DATOS YA PROCESADOS  */
  /*********************************************************/
if($continue)  
 {
  $noindex = array("aux_biblio_copy_noindex"=>"biblio_copy",
                 "aux_biblio_hold_noindex"=>"biblio_hold",
			     "aux_biblio_status_hist_noindex"=>"biblio_status_hist");
  foreach($noindex as $tabla_aux_noindex=>$tabla)
   {
    if($continue)
	{
    $file_name = "c:/biblio_backup/".$tabla_aux_noindex."_".date('Y-m-d')."_".time().".backup";
    mysql_query("select * into outfile '$file_name' fields terminated by ';' from $tabla_aux_noindex");
    $error=mysql_error();
    if(!empty($error))
	  {
       echo "<li>Ocurrio el siguiente error al realizar el backup de la tabla $tabla: ".mysql_error()." </li><br>";
	   $continue = false;
	  }
	  
	mysql_query("delete from $tabla",$link);     
    $sql="load data infile '$file_name'
    into table $tabla
    fields terminated by ';'";
    mysql_query($sql,$link);
    $error=mysql_error();
    if(empty($error))
       echo "<li>Se importo exitosamente desde el archivo $file_name a la tabla $tabla</li><br>";
    else
	   {
       echo "<li>Ocurrio el siguiente error al importar desde el archivo $file_name a la tabla $tabla: ".mysql_error()." </li><br>";
	   $continue = false;
	   }
	}
	}  
 }
}
  /************************************************************************************************/
  /*  BORRO LOS BIBLIOS COPY CON CODIGOS DE BARRAS QUE NO ESTAN EN LAS TABLAS NUEVAS IMPORTAADAS  */
  /************************************************************************************************/
if($continue)
   { 
    $sql = "DELETE FROM biblio_copy ";
	$sql.= "WHERE barcode_nmbr NOT IN (SELECT barcode_nmbr FROM aux_biblio_copy) ";
	$sql.= "AND mbrid IS NULL ";
    mysql_query($sql,$link);
    $error=mysql_error();
    if(!empty($error))	
	  echo "<li>Ocurrio el siguiente error al intentar borrar los codigos de barras sin uso: ".mysql_error()." </li><br>";
   }
  
echo "<li>Se insertaron $biblio_copy_inserted biblio_copy</li><br>";
echo "<li>Se actualizaron $biblio_copy_updated biblio_copy</li><br>";
echo "<center><input class='button' type='button' name='cerrar' value='Cerrar' onClick='self.close()'></center>";
?>