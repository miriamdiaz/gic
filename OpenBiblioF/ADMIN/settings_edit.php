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

  $tab = "admin";
  $nav = "settings";
  $restrictInDemo = true;
  require_once("../shared/common.php");
  require_once("../shared/logincheck.php");

  require_once("../classes/Settings.php");
  require_once("../classes/SettingsQuery.php");
  require_once("../functions/errorFuncs.php");

  #****************************************************************************
  #*  Checking for post vars.  Go back to form if none found.
  #****************************************************************************
  if (count($_POST) == 0) {
    header("Location: ../admin/settings_edit_form.php?reset=Y");
    exit();
  }

  #****************************************************************************
  #*  Validate data
  #****************************************************************************
  $set = new Settings();
  $set->setLibraryName($_POST["libraryName"]);
  $_POST["libraryName"] = $set->getLibraryName();
  $set->setLibraryImageUrl($_POST["libraryImageUrl"]);
  $_POST["libraryImageUrl"] = $set->getLibraryImageUrl();
  $set->setUseImageFlg(isset($_POST["isUseImageSet"]));
  $set->setLibraryHours($_POST["libraryHours"]);
  $_POST["libraryHours"] = $set->getLibraryHours();
  $set->setLibraryPhone($_POST["libraryPhone"]);
  $_POST["libraryPhone"] = $set->getLibraryPhone();
  $set->setLibraryUrl($_POST["libraryUrl"]);
  $_POST["libraryUrl"] = $set->getLibraryUrl();
  $set->setOpacUrl($_POST["opacUrl"]);
  $_POST["opacUrl"] = $set->getOpacUrl();
  $set->setSessionTimeout($_POST["sessionTimeout"]);
  $_POST["sessionTimeout"] = $set->getSessionTimeout();
  $set->setItemsPerPage($_POST["itemsPerPage"]);
  $_POST["itemsPerPage"] = $set->getItemsPerPage();
  $set->setPurgeHistoryAfterMonths($_POST["purgeHistoryAfterMonths"]);
  $_POST["purgeHistoryAfterMonths"] = $set->getPurgeHistoryAfterMonths();
  $set->setBlockCheckoutsWhenFinesDue(isset($_POST["isBlockCheckoutsWhenFinesDue"]));
  $set->setLocale($_POST["locale"]);
  $_POST["locale"] = $set->getLocale();
  $set->setCharset($_POST["charset"]);
  $_POST["charset"] = $set->getCharset();
  $set->setHtmlLangAttr($_POST["htmlLangAttr"]);
  $_POST["htmlLangAttr"] = $set->getHtmlLangAttr();
  $set->setUnidad_academica($_POST["unidad_academica"]);
  /**
  Autor: Horacio Alvarez
  Fecha: 17-04-06
  Descripcion: se agregan los campos unidad academica y domicilio.
  */  
  $_POST["unidad_academica"] = $set->getUnidad_academica();  
  $set->setDomicilio($_POST["domicilio"]);
  $_POST["domicilio"] = $set->getDomicilio();    
  $set->setSmtp($_POST["smtp"]);
  $_POST["smtp"] = $set->getSmtp();  
  $set->setImap($_POST["imap"]);
  $_POST["imap"] = $set->getImap();  
  $set->setUsuariosOnlineFlg(isset($_POST["usuarios_online_flg"]));  
  $set->setDocentesOnlineFlg(isset($_POST["docentes_online_flg"]));

  if (!$set->validateData()) {
    $pageErrors["sessionTimeout"] = $set->getSessionTimeoutError();
    $pageErrors["itemsPerPage"] = $set->getItemsPerPageError();
    $pageErrors["purgeHistoryAfterMonths"] = $set->getPurgeHistoryAfterMonthsError();
	$pageErrors["unidad_academica"] = $set->getUnidad_academicaError();
	$pageErrors["domicilio"] = $set->getDomicilioError();
	$pageErrors["library_cd"] = $set->getLibraryCdError();
    $_SESSION["postVars"] = $_POST;
    $_SESSION["pageErrors"] = $pageErrors;
    header("Location: ../admin/settings_edit_form.php");
    exit();
  }

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
	
  $sql="update settings set logotipo ='$imagen'";
  include ("../conexiondb.php");
  mysql_query($sql);  
  /*******************************************/
  /* VALIDAR Y GUARDAR LA IMAGEN             */
  /*******************************************/    
  


  #**************************************************************************
  #*  Update domain table row
  #**************************************************************************
  $setQ = new SettingsQuery();
  $setQ->connect();
  if ($setQ->errorOccurred()) {
    $setQ->close();
    displayErrorPage($setQ);
  }
  if (!$setQ->update($set)) {
    $setQ->close();
    displayErrorPage($setQ);
  }

  
  $sql="update biblio_cod_library set prestamos_flg='N'";
  $setQ->_query($sql,"Error actualizano la tabla biblio_cod_library");	    
	   
  $length=$_POST["countChecks"];
  for($i=0;$i<$length;$i++)
     if(isset($_POST["library_cd$i"]))
       {
	   $code=$_POST["library_cd$i"];
	   $sql="update biblio_cod_library set prestamos_flg='Y' where code=$code";
	   $setQ->_query($sql,"Error actualizano la tabla biblio_cod_library");
	   }
  $setQ->close();
  #**************************************************************************
  #*  Destroy form values and errors
  #**************************************************************************
  unset($_SESSION["postVars"]);
  unset($_SESSION["pageErrors"]);

  header("Location: ../admin/settings_edit_form.php?reset=Y&updated=Y");
  exit();
?>
