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
  // require_once("../functions/inputFuncs.php");
  require_once("../shared/common.php");
  include("../shared/logincheck.php");
  //include("../shared/header.php");
  require_once("../classes/Localize.php");
  require_once("../functions/errorFuncs.php");
  //require_once("../classes/BiblioQuery.php");
  require_once("../classes/ReportBiblios.php");
 // require_once("../classes/ReportBibliosQuery.php");
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
   
  #****************************************************************************
  #*  Validate data
  #****************************************************************************
 
  $reportBiblios = new ReportBiblios();
  $dia1 = $HTTP_POST_VARS["list_day1"];
  $mes1 = $HTTP_POST_VARS["list_month1"];
  $anio1 = $HTTP_POST_VARS["list_year1"]; 
  
  $dia2=$HTTP_POST_VARS["list_day2"];
  $mes2=$HTTP_POST_VARS["list_month2"];
  $anio2=$HTTP_POST_VARS["list_year2"]; 

  $reportBiblios->setFecha1($anio1."-".$mes1."-".$dia1);
  $reportBiblios->setFecha2($anio2."-".$mes2."-".$dia2);

  $_POST["fecha1"]=$reportBiblios->getFecha1();
  $_POST["fecha2"]=$reportBiblios->getFecha2();
  
  /*$validData = $reportBiblios->validateData();
    if (!$validData) {
  	$pageErrors["fecha1"] = $reportBiblios->getDateSptuError();
  	echo "error de fecha list_biblios_run <BR>";
	$_SESSION["postVars"] = $_POST;
  	$_SESSION["pageErrors"] = $pageErrors;
  	header("Location: ../reports/list_new_biblios_form.php");
  	exit();
  } */
  // FIN VALIDATE DATA
  
  #****************************************************************************
  #*  Read query string args
  #****************************************************************************
    
  $tomorrow = mktime (0,0,0,$mes2,$dia2+1,$anio2);
  //echo "El dia despues: $tomorrow <br>";
  $fecha2 = date ("Y-m-d",$tomorrow);
  //echo "El dia despues: $fecha2 <br>";
  $reportBiblios->setFecha2($fecha2);  
  
  $fech1 = $reportBiblios->getFecha1();
  $fech2 = $reportBiblios->getFecha2();
  //echo "fecha1: $fech1";

 if (isset($_POST["flg"])) 
  {
  $flg = $_POST["flg"];
  switch ($flg) {
  	case "biblios": 
	   switch($_POST["impresion"])
	         {
			  case "pdf": include("../reports/display_report_biblios_pdf.php");
			              break;
			  case "html": 
			              include("../shared/header.php");
			              include("../reports/display_report_biblios_html.php");
			              break;
			  case "csv": include("../reports/display_report_biblios_csv.php");
			              break;						  						  
			 }
  	   break; 
  	case "copys": 
	   switch($_POST["impresion"])
	         {
			  case "pdf": include("../reports/display_report_copys_pdf.php"); 
			              break;
			  case "html": 
			              include("../shared/header.php");
			              include("../reports/display_report_copys_html.php"); 
			              break;
			  case "csv": include("../reports/display_report_copys_csv.php"); 
			              break;						  						  
			 }	
  	break;
  	case "bib_aprob": 
	   switch($_POST["impresion"])
	         {
			  case "pdf": include("../reports/display_report_bibAprob_pdf.php"); 
			              break;
			  case "html":include("../shared/header.php");
			              include("../reports/display_report_bibAprob_html.php");
			              break;
			  case "csv": include("../reports/display_report_bibAprob_csv.php");
			              break;						  						  
			 }		
  	break;
	case "copy_aprob": 
	   switch($_POST["impresion"])
	         {
			  case "pdf": include("../reports/display_report_copyAprob_pdf.php"); 
			              break;
			  case "html":include("../shared/header.php");
			              include("../reports/display_report_copyAprob_html.php"); 
			              break;
			  case "csv": include("../reports/display_report_copyAprob_csv.php"); 
			              break;						  						  
			 }	
  	break;    
  	default: 
  	echo "No coinciden los flags"; 
  	break; 
	} 
}
  ?>



