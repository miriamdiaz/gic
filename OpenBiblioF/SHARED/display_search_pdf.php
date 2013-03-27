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

  $tab = "home";
  $nav = "run";

  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  include("../reports/run_report.php");

$header=array();
$datarow=array();
$data=array();
$d=fopen("data.txt","w");
$h=fopen("header.txt","w");

      foreach($fieldIds as $fldid) {
		$header[]=$loc->getText($fldid);
		fwrite($h,$loc->getText($fldid).";",1024);
      }

    while ($array = $reportQ->fetchRow()) {
	  $datarow=array();
      $datarowstring="";
      foreach($array as $key => $value) {
		  $datarow[]=$value;
		  $datarowstring.=$value.";";
        }
	  fwrite($d,$datarowstring."\n",1024);
	  $data[]=$datarow;
    }
    $reportQ->close();

$rptid=$_POST["rptid"];
header("Location: pdf.php?title=$title&rptid=$rptid"); 
?>
