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
  $tab = "reports";
  $nav = "reportlistsiunpa"; 
  $lookup = "N";
  require_once("../shared/common.php");
 // include("../shared/logincheck.php");
  require_once("../functions/inputFuncs.php");
  require_once("../classes/Localize.php");
  require_once("../functions/errorFuncs.php");
  require_once("../classes/Staff.php");
  require_once("../classes/StaffQuery.php");
  require_once("../classes/ReportCopysQuery.php");
  //require_once("../classes/ReportQuery.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  
  Header("Content-type: application/vnd.ms-excel; charset=".OBIB_CHARSET.";");
  $hoy=date("d-M-Y");
  Header("Content-disposition: attachment; filename=ListadoDeEjemplares_$hoy.csv");    
  
  if (isset($_POST["tab"])) 
  {
    $tab = $_POST["tab"];
  }
  if (isset($_POST["lookup"])) 
  {
    $lookup = $_POST["lookup"];
  }
  if (isset($_POST["fech1"])) 
  {
    $fech1 = $_POST["fech1"];
  }
   if (isset($_POST["fech2"])) 
  {
    $fech2 = $_POST["fech2"];
	include("../shared/header.php");
  }

 
    $currentPageNmbr = 1;

  #****************************************************************************
  #*  Search database
  #****************************************************************************

  $biblioQ = new ReportCopysQuery();
  //echo "new";
  $biblioQ->setItemsPerPage(OBIB_ITEMS_PER_PAGE);
  $biblioQ->connect();
  if ($biblioQ->errorOccurred()) {
    $biblioQ->close();
    displayErrorPage($biblioQ);
  }
   # checking to see if we are in the opac search or logged in
  if ($tab == "opac") {
    $opacFlg = true;
  } else {
    $opacFlg = false;
  }
  //$fech1 = $reportBiblios->getFecha1();
  //$fech2 = $reportBiblios->getFecha2();

  //echo " En display: fecha1: $fech1  fecha2: $fech2";
   if (!$biblioQ->viewCopys($currentPageNmbr,$fech1,$fech2)) 
  {
    $biblioQ->close();
    displayErrorPage($biblioQ);
  }
  #**************************************************************************
  #*  Show search results
  #**************************************************************************
  
   //require_once("../classes/Localize.php");
   //$loc = new Localize(OBIB_LOCALE,"shared");

  # Display no results message if no results returned from search.
  
   if ($biblioQ->getRowCount() == 0) {
    $biblioQ->close();
    die( $loc->getText("biblioSearchListNoResults"));
  }

 $title= $loc->getText("reportSiunpaHead2");

  $resultados= $loc->getText("biblioSearchListResultTxt",array("itemsl"=>$biblioQ->getRowCount()));
  if ($biblioQ->getRowCount() > 1) {
    $resultados.=" Ordenado por fecha de creaci&oacute;n";
   }

$d=fopen("data.txt","w");
$h=fopen("header.txt","w");

/*****************************************/
/*                   HEADER              */
/*****************************************/
echo "Nº,";
echo "Titulo,";
echo "Cod. Barras,";
echo "Precio,";
echo "Localización,";
echo "Fecha Creación,";
echo "Cargó,";
echo "
";

/*****************************************/
/*                   DATA                */
/*****************************************/


    while ($biblio = $biblioQ->fetchRowFranco()) 
    {
	 echo  $biblioQ->getCurrentRowNmbr().",";	
	 $titulo=substr($biblio->getTitle(),0,60);
	 $titulo=str_replace(",","",$titulo);
	 echo  $titulo.",";	
	 echo  $biblio->getBarcodeNmbr().",";	
	 echo  $biblio->getPrecio().",";	
	 echo  getLocaliz($biblio->getCodLoc(),false).",";	
	 $fecha=substr($biblio->getStatusBeginDt(),0,10);
	 echo  $fecha.",";	
	  
			$staffQ = new StaffQuery();
			$staffQ->connect();
			if ($staffQ->errorOccurred()) 
			{
				$staffQ->close();
				displayErrorPage($staffQ);
			}
			$staffQ->execSelect($biblio->getUserCreador());
			if ($staffQ->errorOccurred()) 
			{
				$staffQ->close();
				displayErrorPage($staffQ);
			}
			$staff = $staffQ->fetchStaff();
     echo  $staff->getLastName().",";
     echo "
";	 				
    }
    $biblioQ->close();	
?>
