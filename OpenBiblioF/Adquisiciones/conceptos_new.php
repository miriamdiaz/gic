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

  $tab = "adquisiciones";
  $nav = "conceptos";
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
    header("Location: ../adquisiciones/conceptos_new_form.php");
    exit();
  }

  #****************************************************************************
  #*  Validate data
  #****************************************************************************
  $dm = new Dm();
  $dm->setDescription($_POST["description"]);
  $_POST["description"] = $dm->getDescription();
  
  $dia = $_POST["list_day_fecha_vto"];
  $mes = $_POST["list_month_fecha_vto"];
  $anio = $_POST["list_year_fecha_vto"];
  $dm->setFechaVto($anio."-".$mes."-".$dia);  

  #**************************************************************************
  #*  Insert new domain table row
  #**************************************************************************
  $dmQ = new DmQuery();
  $dmQ->connect();
  if ($dmQ->errorOccurred()) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }
  
  if (!$dmQ->insert("concepto_dm",$dm)) {
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
<? echo "El concepto : "; ?><?php echo $dm->getDescription();?><? echo " , se agreg� satisfactoriamente"; ?><br><br>
<a href="../adquisiciones/conceptos_list.php"><? echo "Volver a Conceptos"; ?></a>

<?php require_once("../shared/footer.php"); ?>
