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
  $nav = "apruebaEjemplar";
  $restrictInDemo = true;
  require_once("../shared/common.php");
  require_once("../shared/logincheck.php");
  require_once("../classes/DmQuery.php");
  require_once("../classes/Dm.php");
  require_once("../classes/BiblioCopyQuery.php");
  require_once("../classes/Query.php");
  require_once("../functions/errorFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  #****************************************************************************
  #*  Checking for query string.  Go back to material type list if none found.
  #****************************************************************************
  if (!isset($_GET["bibid"])){
    header("Location: ../catalog/aprueba_material.php");
    exit();
  }
  $bibid = $_GET["bibid"];
  $copyid= $_GET["copyid"];
  $barcodenmbr = $_GET["barcodenmbr"];
// update aprob _flg  a aprobado. 3/08/05 franco
  $biblioQ = new BiblioCopyQuery();
  $biblioQ->connect();
  if ($biblioQ->errorOccurred()) {
    $biblioQ->close();
    displayErrorPage($biblioQ);
  }
  if (!$biblioQ->updateFlgAprobacion($bibid,$copyid)) {
    $biblioQ->close();
    displayErrorPage($biblioQ);
  }
   $biblioQ->close();
  
  #**************************************************************************
  #*  Show success page
  #**************************************************************************
  require_once("../shared/header.php");
?>
<? echo $loc->getText("catalog_materials_ApruebaEjemplar"); ?>
<?php echo $barcodenmbr;?><? echo $loc->getText("catalog_materials_MaterialAprobado"); ?>
<br><br>
<a href="../catalog/aprueba_ejemplar.php"><? echo $loc->getText("catalog_aprueba_material_Return"); ?></a>

<?php require_once("../shared/footer.php"); ?>