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
  $nav = "adquisicion";
  $restrictInDemo = true;
  require_once("../shared/common.php");
//  require_once("../shared/logincheck.php");
  require_once("../classes/AdquisicionQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  #****************************************************************************
  #*  Checking for query string.  Go back to collection list if none found.
  #****************************************************************************
  if (!isset($_GET["code"])){
    header("Location: ../home/adquisicion.php");
    exit();
  }
  $adqid = $_GET["code"];
  $barcode_nmbr = $_GET["barcode_nmbr"];

  #**************************************************************************
  #*  Delete row
  #**************************************************************************
  $adqQ = new AdquisicionQuery();
  $adqQ->connect();
  if ($adqQ->errorOccurred()) {
    $adqQ->close();
    displayErrorPage($adqQ);
  }
  if (!$adqQ->delete($adqid)) {
    $adqQ->close();
    displayErrorPage($adqQ);
  }
  $adqQ->close();

  #**************************************************************************
  #*  Show success page
  #**************************************************************************
  require_once("../shared/header.php");
?>
<? echo "Pedido de adquisición Nro: "; ?>
<?php echo $adqid;?>
<? echo " , eliminado satisfactoriamente"; ?><br><br>
<a href="../home/adquisicion.php?barcode_nmbr=<? echo $barcode_nmbr;?>"><? echo "Volver a Pedidos de Adquisición"; ?></a>

<?php require_once("../shared/footer.php"); ?>
