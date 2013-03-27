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

  $tab = "cataloging";
  $nav = "materials";
  $restrictInDemo = true;
  require_once("../shared/common.php");
  require_once("../shared/logincheck.php");

  require_once("../classes/Dm.php");
  require_once("../classes/DmQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  #****************************************************************************
  #*  Checking for post vars.  Go back to form if none found.
  #****************************************************************************

  if (count($_POST) == 0) {
    header("Location: ../catalog/materials_list.php");
    exit();
  }

  #****************************************************************************
  #*  Validate data
  #****************************************************************************
  $dm = new Dm();
  $dm->setCode($_POST["code"]);
  $_POST["code"] = $dm->getCode();
  $dm->setDescription($_POST["description"]);
  $_POST["description"] = $dm->getDescription();
  
  
  /*******************************************/
  /* VALIDAR Y GUARDAR LA IMAGEN             */
  /*******************************************/
  $error="";
  $archivo = $HTTP_POST_FILES['imageFile']['name']; 
  $length=strlen($archivo);
  $error=false;
  for($i=0;$i<$length;$i++)
      if($archivo[$i]=='%')
	     $error=true;
  $tipo_archivo = $HTTP_POST_FILES['imageFile']['type']; 
  $tamano_archivo = $HTTP_POST_FILES['imageFile']['size']; 
  $imagen="";
  if($archivo!="")
     {//ARCHIVO NO VACIO  
      if (!((strpos($tipo_archivo, "gif") || strpos($tipo_archivo, "jpeg")) || strpos($tipo_archivo, "png") && ($tamano_archivo < 100000)) || $error)
          { 
		   $error.="<div align='center'><table><tr><td width='331' class='primary'>La imagen es incorrecta</td></tr><tr><td class='primary'><li>La imagen debe poseer la extension .jpg, .gif o .png</td></tr><tr><td class='primary'><li>La imagen no debe ser mayor de 100 Kb</td><tr><td class='primary'><li>El nombre de la imagen no debe poseer caracteres incorrectos Ej: '%'</td></tr></table></div>";
          }
      else
	      {
		  $nombre_archivo = $HTTP_POST_FILES['imageFile']['tmp_name'];
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
	      }  
    }
	
  $dm->setImageFile($imagen);
  		
  if(!empty($error)) {
    $pageErrors["imageFile"] = $error;
    $_SESSION["postVars"] = $_POST;
    $_SESSION["pageErrors"] = $pageErrors;
    header("Location: ../catalog/materials_new_form.php");
    exit();	 
	}  
  
  
  if (!$dm->validateData()) {
    $pageErrors["description"] = $dm->getDescriptionError();
    $pageErrors["adultCheckoutLimit"] = $dm->getAdultCheckoutLimitError();
    $pageErrors["juvenileCheckoutLimit"] = $dm->getJuvenileCheckoutLimitError();
    $_SESSION["postVars"] = $_POST;
    $_SESSION["pageErrors"] = $pageErrors;
    header("Location: ../catalog/materials_edit_form.php");
    exit();
  }

  #**************************************************************************
  #*  Update domain table row
  #**************************************************************************
  $dmQ = new DmQuery();
  $dmQ->connect();
  if ($dmQ->errorOccurred()) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }
  if (!$dmQ->update("material_type_dm",$dm)) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }
  $dmQ->close();

  #**************************************************************************
  #*  Destroy form values and errors
  #**************************************************************************
  unset($_SESSION["postVars"]);
  unset($_SESSION["pageErrors"]);

  #**************************************************************************
  #*  Show success page
  #**************************************************************************
  require_once("../shared/header.php");
?>
<? echo $loc->getText("admin_materials_delMaterialType"); ?><?php echo $dm->getDescription();?><? echo $loc->getText("admin_materials_editEnd"); ?><br><br>
<a href="../catalog/materials_list.php"><? echo $loc->getText("admin_materials_Return"); ?></a>

<?php require_once("../shared/footer.php"); ?>
