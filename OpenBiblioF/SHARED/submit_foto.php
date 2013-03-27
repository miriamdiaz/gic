<?php
/**********************************************************************************
 *   Copyright(C) 2002 David Stevens
 *
 *   This file is part of OpenBiblio.
 *
 *   OpenBiblio is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 *   OpenBiblio is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with OpenBiblio; if not, write to the Free Software
 *   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 **********************************************************************************
 */


  #****************************************************************************
  #*  Checking for tab name to show OPAC look and feel if searching from OPAC
  #****************************************************************************
  if (isset($_GET["tab"])) {
    $tab = $_GET["tab"];
  } else {
    $tab = "cataloging";
  }

  $nav = "view";
  require_once("../shared/common.php");
  if ($tab != "opac") {
    require_once("../shared/logincheck.php");
  }
  require_once("../classes/Biblio.php");
  require_once("../classes/BiblioQuery.php");
  require_once("../classes/BiblioCopy.php");
  require_once("../classes/BiblioCopyQuery.php");
  require_once("../classes/BiblioAnalitica.php");
  require_once("../classes/BiblioAnaliticaQuery.php");
  // \/ AGREGADO PARA NOMBRE LOCALIZACIÒN
  require_once("../functions/inputFuncs.php");
  // /\ 15/02/06 
  require_once("../classes/DmQuery.php");
  require_once("../classes/UsmarcTagDm.php");
  require_once("../classes/UsmarcTagDmQuery.php");
  require_once("../classes/UsmarcSubfieldDm.php");
  require_once("../classes/UsmarcSubfieldDmQuery.php");
  require_once("../functions/marcFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,"shared");
  /*ini franco*/
  require_once("../classes/Staff.php");
  require_once("../classes/StaffQuery.php");
  require_once("../functions/errorFuncs.php");
  
  /*fin franco*/
  #****************************************************************************
  #*  Retrieving post var
  #****************************************************************************
  $bibid = $_POST["bibid"];


  #****************************************************************************
  #*  Search database
  #****************************************************************************
  $biblioQ = new BiblioQuery();
  $biblioQ->connect();
  if ($biblioQ->errorOccurred()) {
    $biblioQ->close();
    displayErrorPage($biblioQ);
  }
  if (!$biblio = $biblioQ->query($bibid)) {
    $biblioQ->close();
    displayErrorPage($biblioQ);
  }
  $image_path_old=$biblio->getImage_path();
  
  /*******************************************/
  /* VALIDAR Y GUARDAR LA IMAGEN             */
  /*******************************************/
  $error="";
  $archivo = $HTTP_POST_FILES['userfile']['name']; 
  $length=strlen($archivo);
  $error=false;
  for($i=0;$i<$length;$i++)
      if($archivo[$i]=='%')
	     $error=true;
  $tipo_archivo = $HTTP_POST_FILES['userfile']['type']; 
  $tamano_archivo = $HTTP_POST_FILES['userfile']['size']; 
  $imagen="";
  if($archivo!="")
     {//ARCHIVO NO VACIO  
      if (!((strpos($tipo_archivo, "gif") || strpos($tipo_archivo, "jpeg")) || strpos($tipo_archivo, "png") && ($tamano_archivo < 100000)) || $error)
          { 
		   $error.="<div align='center'><table><tr><td width='331' class='primary'>La imagen es incorrecta</td></tr><tr><td class='primary'><li>La imagen debe poseer la extension .jpg, .gif o .png</td></tr><tr><td class='primary'><li>La imagen no debe ser mayor de 100 Kb</td><tr><td class='primary'><li>El nombre de la imagen no debe poseer caracteres incorrectos Ej: '%'</td></tr></table></div>";
          }
      else
	      {
		  $nombre_archivo = $HTTP_POST_FILES['userfile']['tmp_name'];
	      ob_start();
	      switch ($tipo_archivo)
		  {
		    case "image/pjpeg":
		    {
		    $image = imagecreatefromjpeg($nombre_archivo);
		    imagejpeg($image);
		    break;
		    }
 		    case "image/gif":
		    {
		    $image = imagecreatefromgif($nombre_archivo);
		    imagegif($image);
		    break;
		    }
		    case "image/x-png":
		    {
		    $image = imagecreatefrompng($nombre_archivo);
		    imagepng($image);
		    break;
		    }
		   }
	       $imagen = ob_get_contents();
	       ob_end_clean();
	       $imagen = str_replace('##','\#\#',mysql_escape_string($imagen));
           $orden = " SELECT * FROM biblio_fotos WHERE bibid = $bibid";	
           $result = mysql_query($orden);				    		
		   if(mysql_num_rows($result) == 0)
	          $orden = " INSERT INTO biblio_fotos (bibid,foto) VALUES ( $bibid, '$imagen')";	
		   else
		      $orden = " UPDATE biblio_fotos SET foto = '$imagen' WHERE bibid = $bibid ";	
	        mysql_query($orden);
              /*******************************************/
              /* ACTUALIZAR EL REGISTRO DE BIBLIO        */
              /*******************************************/
/*              $biblio->setImage_path($nombre_archivo);
              if (!$biblioQ->update($biblio)) 
                  {	 
                   $biblioQ->close();
                   displayErrorPage($biblioQ);
                  }
		      else//ACTUALIZÓ LA BASE CORRECTAMENTE, PROCEDO A BORRAR LA IMAGEN ANTIGUA, SI EXISTE
   		         if(file_exists($image_path_old))
				   if($image_path_old != "../images/logotipo.jpeg") 
		              unlink($image_path_old);			  			    
              $biblioQ->close();*/
              /*******************************************/
              /* FIN ACTUALIZAR EL REGISTRO DE BIBLIO    */
              /*******************************************/			  
/*             }
	      else
	         { 
			  $error.="<div align='center'><table><tr><td class='primary'>Ocurrió un error al guardarse. Intente nuevamente</td></tr></table></div>"; 
              //echo "<div align='center'><table><tr><td><font size='2' face='Verdana'>Ocurrió un error al guardarse. Intente nuevamente</font></td></tr></table></div>"; 
             } */
          }
     }
  else//ARCHIVO VACIO
     {
	  $error.="<div align='center'><br><br><table><tr><td class='primary'>Atencion: No ha cargado ninguna imagen</td></tr>";
	  $error.="<br><table><tr><td class='primary'>Nota: Si ya ha guardado una imagen, quedara la misma</td></tr></div>";
      //echo "<div align='center'><br><br><table><tr><td>Atencion: No ha cargado ninguna imagen</td></tr>";
      //echo "<br><table><tr><td>Nota: Si ya ha guardado una imagen, quedara la misma</td></tr></div>";
     }
  /*******************************************/
  /* FIN VALIDAR Y GUARDAR LA IMAGEN         */
  /*******************************************/
if(!empty($error))  
  {
    $error.="<div align='center'><a href='#' onclick='history.back()'>Volver</a></div>";
    echo $error;
  }
else
    header("location: ../shared/biblio_view.php?bibid=".$_POST["bibid"]."&tab=cataloging&error=".$error);  
?>
