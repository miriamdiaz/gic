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

  $tab = "circulation";
  $restrictToMbrAuth = TRUE;
  $nav = "edit";
  $restrictInDemo = true;
  require_once("../shared/common.php");
  require_once("../shared/logincheck.php");

  require_once("../classes/Member.php");
  require_once("../classes/MemberQuery.php");
  require_once("../classes/MemberSancionHistQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  #****************************************************************************
  #*  Checking for post vars.  Go back to form if none found.
  #****************************************************************************

  if (count($_POST) == 0) {
    header("Location: ../circ/index.php");
    exit();
  }

  #****************************************************************************
  #*  Validate data
  #****************************************************************************
  $mbrid = $_POST["mbrid"];
    #****************************************************************************
  #*  Getting member
  #****************************************************************************
  $mbrQ = new MemberQuery();
  $mbrQ->connect();
  if ($mbrQ->errorOccurred()) {
    $mbrQ->close();
    displayErrorPage($mbrQ);
  }
  if (!$mbrQ->execSelect($mbrid)) {
    $mbrQ->close();
    displayErrorPage($mbrQ);
  }
  $mbr = $mbrQ->fetchMember();
  $mbrQ->close();
  $mbrName = urlencode($_POST["firstName"]." ".$_POST["lastName"]);

  $mbr->setMbrid($_POST["mbrid"]);
  $mbr->setBarcodeNmbr($_POST["barcodeNmbr"]);
  $_POST["barcodeNmbr"] = $mbr->getBarcodeNmbr();
  $mbr->setLastChangeUserid($_SESSION["userid"]);
  $mbr->setLastName($_POST["lastName"]);
  $_POST["lastName"] = $mbr->getLastName();
  $mbr->setFirstName($_POST["firstName"]);
  $_POST["firstName"] = $mbr->getFirstName();
  //DOS LINEAS AGREGADAS: Horacio Alvarez FECHA: 25-03-06
  $mbr->setLibraryid($_POST["libraryid"]);    
  $_POST["libraryid"] = $mbr->getLibraryid();  
  //DOS LINEAS AGREGADAS: Horacio Alvarez FECHA: 26-03-06
  $mbr->setLimitePrestamos($_POST["limite_prestamos"]);    
  $_POST["limite_prestamos"] = $mbr->getLimitePrestamos();    
  //DOS LINEAS AGREGADAS: Horacio Alvarez FECHA: 08-04-06
  $mbr->setLimiteReservas($_POST["limite_reservas"]);
  $_POST["limite_reservas"] = $mbr->getLimiteReservas();
  $mbr->setAddress1($_POST["address1"]);
  $_POST["address1"] = $mbr->getAddress1();
  $mbr->setAddress2($_POST["address2"]);
  $_POST["address2"] = $mbr->getAddress2();
  $mbr->setCity($_POST["city"]);
  $_POST["city"] = $mbr->getCity();
  $mbr->setState($_POST["state"]);
  $mbr->setZip($_POST["zip"]);
  $_POST["zip"] = $mbr->getZip();
  $mbr->setZipExt($_POST["zipExt"]);
  $_POST["zipExt"] = $mbr->getZipExt();
  $mbr->setHomePhone($_POST["homePhone"]);
  $_POST["homePhone"] = $mbr->getHomePhone();
  $mbr->setWorkPhone($_POST["workPhone"]);
  $_POST["workPhone"] = $mbr->getWorkPhone();
  $mbr->setEmail($_POST["email"]);
  $_POST["email"] = $mbr->getEmail();
  $mbr->setCarrera($_POST["carrera"]);
  $_POST["carrera"] = $mbr->getCarrera();  
  $mbr->setClassification($_POST["classification"]);
  $dia = $_POST["list_day_fechavto"];
  $mes = $_POST["list_month_fechavto"];
  $anio = $_POST["list_year_fechavto"];
  $mbr->setFechaVto($anio."-".$mes."-".$dia);
  $dia = $_POST["list_day_fecha_suspension"];
  $mes = $_POST["list_month_fecha_suspension"];
  $anio = $_POST["list_year_fecha_suspension"];
  $mbr->setFecha_suspension($anio."-".$mes."-".$dia);  
//  $mbr->setSchoolGrade($_POST["schoolGrade"]);
  if(isset($_POST["observaciones"])) $mbr->setObservaciones($_POST["observaciones"]);
  
  $mbr->setCantidadPrestamos($_POST["cantidad_prestamos"]);
  $mbr->setCantidadReservas($_POST["cantidad_reservas"]);
  $inicioSancion = $_POST["inicio_sancion"];
  $oldTipoSacion = $mbr->getTipo_sancion_cd();
  $postTipoSacion = $_POST["tipo_sancion_cd"];
  if($oldTipoSacion != $_POST["tipo_sancion_cd"])
     $inicioSancion = date("Y-m-d");
  $mbr->setTipo_sancion_cd($_POST["tipo_sancion_cd"]);
  $mbr->setInicio_sancion($inicioSancion);
  $mbr->setSancion_activa($_POST["sancion_activa"]);
  $mbr->setCopy_barcode($_POST["copy_barcode"]);
  
  if(isset($_POST["limpiar_sanciones"]))
    {
     if($_POST["tipo_sancion_cd"]>0)
	  {
	   $nueva_sancion=$_POST["tipo_sancion_cd"]-1;
	   $mbr->setTipo_sancion_cd($nueva_sancion);
	  }
	 //$mbr->setInicio_sancion("");
     $mbr->setFecha_suspension("");
	 $mbr->setSancion_activa("n");
	 $mbr->setCopy_barcode("");
	
     /************************************************************/
     /*  SI SE DESEA LIMPIAR TAMBIEN EL HISTORIAL DE SANCIONES,  */
     /*  SE DEBE DESCOMENTAR LA SIGUIENTE PORCIÓN DE CODIGO.     */
     /************************************************************/	 
     /*$mbrHistQ = new MemberSancionHistQuery();
     $mbrHistQ->connect();
     if ($mbrHistQ->errorOccurred()) {
        $mbrHistQ->close();
        displayErrorPage($mbrHistQ);
     }
     $mbrHistQ->limpiarHistorialByMbrid($mbr->getMbrid());*/
	}
  $validData = $mbr->validateData();
  $validData2 = ($oldTipoSacion <= $postTipoSacion);
  if (!$validData || !$validData2) {
    if(!$validData2)
	   $pageErrors["tipo_sancion_cd"] = "No puede retrasar sanciones desde aqui";  
    $pageErrors["barcodeNmbr"] = $mbr->getBarcodeNmbrError();
    $pageErrors["lastName"] = $mbr->getLastNameError();
    $pageErrors["firstName"] = $mbr->getFirstNameError();
	//4 LINEAS AGREGADA: Horacio Alvarez FECHA: 08-04-06
	$pageErrors["address1"] = $mbr->getaddress1Error();
	$pageErrors["libraryid"] = $mbr->getLibraryidError();
	$pageErrors["limite_prestamos"] = $mbr->getLimitePrestamosError();	
	$pageErrors["limite_reservas"] = $mbr->getLimiteReservasError();	
    $pageErrors["zip"] = $mbr->getZipError();
    $pageErrors["zipExt"] = $mbr->getZipExtError();
//    $pageErrors["schoolGrade"] = $mbr->getSchoolGradeError();
	$pageErrors["classification"] = $mbr->getClassificationError();
    $_SESSION["postVars"] = $_POST;
    $_SESSION["pageErrors"] = $pageErrors;
    header("Location: ../circ/mbr_edit_form.php");
    exit();
  }

  #**************************************************************************
  #*  Check for duplicate barcode number
  #**************************************************************************
  $mbrQ = new MemberQuery();
  $mbrQ->connect();
  if ($mbrQ->errorOccurred()) {
    $mbrQ->close();
    displayErrorPage($mbrQ);
  }
  $dupBarcode = $mbrQ->DupBarcode($mbr->getBarcodeNmbr(),$mbr->getMbrid());
  if ($mbrQ->errorOccurred()) {
    $mbrQ->close();
    displayErrorPage($mbrQ);
  }
  if ($dupBarcode) {
    $pageErrors["barcodeNmbr"] = $loc->getText("mbrDupBarcode",array("barcode"=>$mbr->getBarcodeNmbr()));
    $_SESSION["postVars"] = $_POST;
    $_SESSION["pageErrors"] = $pageErrors;
    header("Location: ../circ/mbr_edit_form.php");
    exit();
  }

  #**************************************************************************
  #*  Update library member
  #**************************************************************************
  if (!$mbrQ->update($mbr)) {
    $mbrQ->close();
    displayErrorPage($mbrQ);
  }

  $mbrQ->close();

  #**************************************************************************
  #*  Destroy form values and errors
  #**************************************************************************
  unset($_SESSION["postVars"]);
  unset($_SESSION["pageErrors"]);

  $msg = $loc->getText("mbrEditSuccess");
  $msg = urlencode($msg);
  header("Location: ../circ/mbr_view.php?mbrid=".$mbr->getMbrid()."&reset=Y&msg=".$msg);
  exit();
?>
