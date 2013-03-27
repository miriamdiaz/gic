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
  
  require_once("../classes/Localize.php");
  require_once("../classes/Staff.php");
  require_once("../classes/StaffQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../classes/ReportBibliosQuery.php");
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
	//include("../shared/header.php");
  }

  
  #****************************************************************************
  #*  Retrieving post vars and scrubbing the data
  #****************************************************************************

    $currentPageNmbr = 1;
  
  #****************************************************************************
  #*  Search database
  #****************************************************************************

  $biblioQ = new ReportBibliosQuery();
  //echo "new";
//  $biblioQ->setItemsPerPage(OBIB_ITEMS_PER_PAGE);
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
   if (!$biblioQ->viewBiblios($currentPageNmbr,$fech1,$fech2)) 
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
    die($loc->getText("biblioSearchListNoResults"));
    //require_once("../shared/footer.php");
  }

$title=$loc->getText("reportSiunpaHead1");

 $resultados=$loc->getText("biblioSearchListResultTxt",array("itemsl"=>$biblioQ->getRowCount()));
  if ($biblioQ->getRowCount() > 1) {
    $resultados = " Ordenado por fecha de creaci&oacute;n";
 }


$d=fopen("data.txt","w");
$h=fopen("header.txt","w");

/*****************************************/
/*                   HEADER              */
/*****************************************/
fwrite($h,"Nº;",1024);
fwrite($h,"Titulo;",1024);
fwrite($h,"Signatura;",1024);
fwrite($h,"Fecha Creacion;",1024);
fwrite($h,"Cargó;",1024);

/*****************************************/
/*                   DATA                */
/*****************************************/	

    while ($biblio = $biblioQ->fetchRowFranco()) 
    {
	    $datarowstring="";
		$datarowstring.= $biblioQ->getCurrentRowNmbr().";";
		$titulo=substr($biblio->getTitle(),0,70);
        $datarowstring.= $titulo.";";
		$datarowstring.= $biblio->getCallNmbr1().$biblio->getCallNmbr2().$biblio->getCallNmbr3().";";
		$fecha=substr($biblio->getCreateDt(),0,10);
		$datarowstring.= $fecha.";";
		/****************************************/
		/*        TRAE EL NOMBRE DEL OPERADOR   */
		/****************************************/
	        $staffQ = new StaffQuery();
		    $staffQ->connect();
		    if ($staffQ->errorOccurred()) 
			    {
				$staffQ->close();
				displayErrorPage($staffQ);
			    }
			$staffQ->execSelect($biblio->getUserNameCreador());
			if ($staffQ->errorOccurred()) 
			   {
				$staffQ->close();
				displayErrorPage($staffQ);
			    }
			$staff = $staffQ->fetchStaff();
		/****************************************/
		/*        FIN EL NOMBRE DEL OPERADOR   */
		/****************************************/
		$datarowstring.= $staff->getLastName().";";			
		fwrite($d,$datarowstring."\n",1024);
    }
    $biblioQ->close();

header("Location: pdf.php?title=$title&rptid=Materiales"); 

?>

