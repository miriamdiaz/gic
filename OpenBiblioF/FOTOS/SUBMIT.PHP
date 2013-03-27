<?
///// SUBE ARCHIVO
$dir = "."; 
//MIME tipos permitidos: gif, jpeg, png. 
$types = array("image/png","image/x-png","image/gif","image/jpeg","image/pjpeg"); 
//Check to determine if the submit button has been pressed 
if((isset($_POST['submit'])))
    { 
    $tmp_name = $_FILES['upload']['tmp_name']; 
    $new_name = $_FILES['upload']['name']; 
    $path = "uploads";
    $fullpath = "$dir/$path/";
    $fullpath = str_replace("..", "", str_replace("\.", "", str_replace("//", "/", $fullpath)));
    $clean_name = ereg_replace("[^a-z0-9._]", "", str_replace(" ", "_", str_replace("%20", "_", strtolower($new_name) ) ) );
    //Chequear MIME Tipo 
    if (in_array($_FILES['upload']['type'], $types))
	{
	if (file_exists($fullpath.$clean_name)) 
	    {
	    if (!unlink($fullpath.$clean_name))
		{
		echo "<div class='clsError'><span style='color:#000000'>&curren;</span> Ya Existía el archivo <b>$clean_name</b>, no se puede borrar.</div>";
		exit;
		}
	    }
	//Mover el archivo desde el directorio temporal a el directorio de uploads. 
	move_uploaded_file($tmp_name,$fullpath . $clean_name); 
	//echo "<div class='clsExito'><span style='color:#000000'>&curren;</span> <b>$clean_name</b> ({$_FILES['upload']['size']}bytes) ha sido subido correctamente.</div>";
	$subio = true;
	}
	else
	    { 
    	    //Mensaje de Error 
	    //echo "<div class='clsError'><span style='color:#000000'>&curren;</span> <b>{$_FILES['upload']['name']}</b> no puede ser subido debido a que el tipo de archivo es incorrecto, se aceptan PNGs,GIFs o JPGs.</div>"; 
	    $name =  $_FILES['upload']['name']; 
	    $type =  $_FILES['upload']['type']; 
	    $size =  $_FILES['upload']['size']; 
	    $tmp =  $_FILES['upload']['name']; 
	    //echo "<div><b>Nombre:</b> $name<br /><b>Tipo:</b> $type<br /><b>Tama&ntilde;o:</b> $size</div>";
	    } 
    } 
///// FIN SUBEARCHIVO

///// SI SUBIO, INSERTA EN LA BD
if ($subio)
    {
    //echo "entre if";
    include ("../conexiondb.php");				
    $path = "C:/apachefriends/xampp/htdocs/OpenBiblioF/fotos/uploads/";
    $bibid = $_POST["bibid"];
    $arch_origen = $path.$clean_name;
    $arch_dest = $path."OUT-".$clean_name;  // ESTE DEBE EXISTIR, Y NOBODY DEBE TENER PERMISOS DE ESCRITURA Y LECTURA
    $arch_gen = "uploads/"."OUT-".$clean_name;
            chmod($arch_origen,0777);
    	    // Guarda en la BD la foto subida.
	    //echo $arch_origen;
	    $aux = split("\.",$arch_origen);
	    //echo "tipo";
	    $tipo = strtolower($aux[1]);
	    
	    ob_start();
	    switch ($tipo)
		{
		case "jpg":
		    {
		    //echo "jpg-----";		    
		    $image = imagecreatefromjpeg($arch_origen);
		    imagejpeg($image);
		    break;
		    }
		case "jpeg":
		    {
		    //echo "jpeg-----";
		    $image = imagecreatefromjpeg($arch_origen);
		    imagejpeg($image);
		    break;
		    }
		case "gif":
		    {
		    //echo "gif-----";
		    $image = imagecreatefromgif($arch_origen);
		    imagegif($image);
		    break;
		    }
		case "png":
		    {
		    //echo "png-----";
		    $image = imagecreatefrompng($arch_origen);
		    imagepng($image);
		    break;
		    }
		
		}
	    
	    
	    $imagen = ob_get_contents();
	    ob_end_clean();
	    $imagen = str_replace('##','\#\#',mysql_escape_string($imagen));


	    
    $sql = "SELECT foto FROM biblio_fotos WHERE bibid = $bibid ; ";
    $query = mysql_query($sql,$conexion);

    if ( $query ) //echo "<div class='clsError'><span style='color:#000000'>&curren;</span> Error query</div>";
	//else
    	{
        if ( mysql_num_rows( $query ) <= 0 )
            {

		
	   $orden = " INSERT INTO biblio_fotos(bibid,foto) VALUES ( $bibid, '$imagen') ; ";	
	$query = mysql_query($orden,$conexion);    	
    	
	    
         //   if ( !$query ) echo "<div class='clsError'><span style='color:#000000'>&curren;</span> <b>ERROR:</b> No se pudo guardar la Foto en la Base de Datos.</div>";
		//else echo "<div class='clsExito'><span style='color:#000000'>&curren;</span> Se guardo correctamente en la Base de Datos.</div>";
	    unlink($path.$clean_name);
	    }
	    else 
	    	{
	    	$orden = "update biblio_fotos set foto ='$imagen' where bibid=$bibid; ";
	    	$query = mysql_query($orden,$conexion);
	    	}
	    	//else echo "<div class='clsError'><span style='color:#000000'>&curren;</span> <b>ERROR:</b> Ya fue guardada una foto en la Base de Datos para <b>$nombre</b>, seguira usando la anterior.</div>";
	
    }
    //echo "<img src=\"foto.php?bidid=$bibid\">";
    mysql_close( $conexion );
    }
///// FIN INSERTAR EN LA BD

header("location: ../shared/biblio_view.php?bibid=".$_POST["bibid"]."&tab=cataloging");
?>
