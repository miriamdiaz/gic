<?php
define("OBIB_HOST",     "localhost");
define("OBIB_DATABASE", "OpenBiblio");
define("OBIB_USERNAME", "openbiblio");
define("OBIB_PWD",      "lagartija4321");
$link = mysql_connect(OBIB_HOST,OBIB_USERNAME,OBIB_PWD);
if ($link == false) 
  $this->_error = "Unable to connect to database";
$rc = mysql_select_db(OBIB_DATABASE, $link);
if ($rc == false)
$this->_error = "2Unable to connect to database";


$row=1;
$fp = fopen ("c:\\cbuarg.csv","r");
$i=0;
$n=0;
while ($data = fgetcsv ($fp, 1000, ";")) 
{ 
  $num = count ($data); 
  print " <br>"; 
  $row++; 
  
  $exists="select * from biblio_copy where barcode_nmbr = '$data[0]'";
  $result_exists=mysql_query($exists,$link);
  $num_rows=mysql_num_rows($result_exists);
  if($num_rows==0)//inserta
  {
	$cod=substr($data[0],0,2);
	echo "$cod <br>";
	$insertar="INSERT INTO biblio_copy (bibid, copyid, copy_desc, barcode_nmbr, status_cd, status_begin_dt, "
			 ."due_back_dt, mbrid, copy_volumen, copy_tomo, copy_user_creador, copy_proveedor, copy_precio, "
			 ."copy_cod_loc, copy_date_sptu, aprob_flg) "
			 ."VALUES ('$data[1]', null,null,'$data[0]','in', sysdate(),"
			 ."null,null,null,null,'30',null,null,"
			 ."'$cod',sysdate(),'1')"; 
	$result = mysql_query($insertar, $link);
	$error=mysql_error($link);
	if ($result == false) 
	{
	 echo " <h1> <FONT COLOR=\"RED\"> Unable to execute query BIBLIO_COPY $data[1] barcode: $data[0]</FONT></h1>";
	 if(!empty($error))
	  echo "<li>Error al ejecutar la siguiente linea: $insertar, Error: ".$error." </li><br>";
	}
	else
	  {
	  echo "BIBLIO_COPY $data[1] barcode: $data[0] <BR>";
	  $insertar2="INSERT INTO auditoria (bibid,copyid,fecha,userid,operacion,nombretabla)"
			    ."VALUES ('$data[0]',NULL,sysdate(),'30','1','biblio_copy')";
	  $result2 = mysql_query($insertar2, $link);
	  if ($result2 == false) 
		echo " <h1> <FONT COLOR=\"RED\"> Unable to execute query AUDITORIA $data[1]</FONT></h1>";
	  else
		echo "AUDITORIA $data[1] <br>";
		$i++;
	  }
  }
  else
    {
	echo "Código de barras: $data[0] ya existe en OpenBiblio <br>";
	$n++;
	}
}
echo "Se insertaron: $i ejemplares <br>";
echo "No se insertaron $n ejemplares <br>";
fclose ($fp);
?>