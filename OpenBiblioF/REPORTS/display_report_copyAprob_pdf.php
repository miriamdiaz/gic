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
  require_once("../classes/ReportAprobCopyQuery.php");
  //require_once("../classes/ReportQuery.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  
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

  $biblioQ = new ReportAprobCopyQuery();
  //echo "new";
  $biblioQ->setItemsPerPage(5000);
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
   if (!$biblioQ->viewCopyAprob($currentPageNmbr,$fech1,$fech2)) 
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

 $title= $loc->getText("reportSiunpaHead1");

  $resultados= $loc->getText("biblioSearchListResultTxt",array("itemsl"=>$biblioQ->getRowCount()));
  if ($biblioQ->getRowCount() > 1) {
    $resultados.=" Ordenado por fecha de creaci&oacute;n";
   }

$d=fopen("data.txt","w");
$h=fopen("header.txt","w");

/*****************************************/
/*                   HEADER              */
/*****************************************/
fwrite($h,"Nº;",1024);
fwrite($h,"Titulo;",1024);
fwrite($h,"Cod. Barras;",1024);
fwrite($h,"Precio;",1024);
fwrite($h,"Localización;",1024);
fwrite($h,"F. Creación;",1024);
fwrite($h,"Cargó;",1024);
fwrite($h,"Aprobó;",1024);
fwrite($h,"F. Aprobación;",1024);

/*****************************************/
/*                   DATA                */
/*****************************************/


    while ($biblio = $biblioQ->fetchRowFranco()) 
    {
     $datarowstring="";
	 $datarowstring.= $biblioQ->getCurrentRowNmbr().";";	
	 $titulo=substr($biblio->getTitle(),0,40);
	 $datarowstring.= $titulo.";";	
	 $datarowstring.= $biblio->getBarcodeNmbr().";";	
	 $datarowstring.= $biblio->getPrecio().";";	
	 $datarowstring.= getLocaliz($biblio->getCodLoc(),false).";";	
	 $fecha=substr($biblio->getStatusBeginDt(),0,10);
	 $datarowstring.= $fecha.";";	
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
     $datarowstring.= $staff->getLastName().";";					
	  
			$staffQ = new StaffQuery();
			$staffQ->connect();
			if ($staffQ->errorOccurred()) 
			{
				$staffQ->close();
				displayErrorPage($staffQ);
			}
			$staffQ->execSelect($biblio->getUserId());
			if ($staffQ->errorOccurred()) 
			{
				$staffQ->close();
				displayErrorPage($staffQ);
			}
			$staff = $staffQ->fetchStaff();
     $datarowstring.= $staff->getLastName().";";
	 $fecha=substr($biblio->getFecha(),0,10);
	 $datarowstring.= $fecha.";";
	 
	fwrite($d,$datarowstring."\n",1024);	 				
    }
    $biblioQ->close();
header("Location: pdf.php?title=$title&rptid=AprobEjemplares"); 	
?>
