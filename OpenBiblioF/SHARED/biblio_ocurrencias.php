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
  #*  Checking for post vars.  Go back to form if none found.
  #****************************************************************************
  if (count($_POST) == 0) {
    header("Location: ../catalog/index.php");
    exit();
  }


  #****************************************************************************
  #*  Checking for tab name to show OPAC look and feel if searching from OPAC
  #****************************************************************************
  $tab = "cataloging";
  //$lookup = "N";
  $nav = "search";

  require_once("../shared/common.php");
  include("../shared/logincheck.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  require_once("../shared/header.php");

  require_once("../conexiondb.php");



///// calcular material
$sqlmat = "select bibid from biblio where ";
//$sqlmat = "select bibid from biblio where ";
if ($_POST["searchType"] == "subject")
    $sqlmaterial = "topic1 like '%".$_POST["searchText"]."%' or topic2 like '%".$_POST["searchText"]."%' or topic3 like '%".$_POST["searchText"]."%' or topic4 like '%".$_POST["searchText"]."%' or topic5 like '%".$_POST["searchText"]."%'";
else if ($_POST["searchType"] == "signatura")
    $sqlmaterial = "call_nmbr1 like '%".$_POST["searchText"]."%' or call_nmbr2 like '%".$_POST["searchText"]."%' or call_nmbr3 like '%".$_POST["searchText"]."%'";
else if ($_POST["searchType"] == "author")
    $sqlmaterial = "author like '%".$_POST["searchText"]."%' or responsibility_stmt like '%".$_POST["searchText"]."%'";
else if ($_POST["searchType"] == "material")
	//$sqlmaterial = "material_cd like '%".$_POST["searchText"]."%'";
	$sqlmaterial = "material_cd like '".$_POST["searchText"]."'";
else if ($_POST["searchType"] == "isbn")
    {
    $sqlmat = "select bibid from biblio_field where field_data like '%".$_POST["searchText"]."%' and tag='20'";
    $sqlmaterial = "";
    }
else
    $sqlmaterial = $_POST["searchType"]." like '%".$_POST["searchText"]."%'";

	
//echo $sqlmat.$sqlmaterial;
$resultado_set = mysql_query($sqlmat.$sqlmaterial,$conexion);
$filas = mysql_numrows($resultado_set);
echo "<b>$filas</b> Materiales Encontrados<br>";


$sqlejemplares = "select copyid from biblio_copy where bibid in ($sqlmat$sqlmaterial)";
$resultado_set = mysql_query($sqlejemplares,$conexion);
$filas = mysql_numrows($resultado_set);
echo "<b>$filas</b> Ejemplares Encontrados<br>";

mysql_close();
?>
<br>
<?php require_once("../shared/footer.php"); ?>
