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
  $nav = "hist_sancion";
  //require agregado: Horacio Alvarez
  require_once("../classes/StaffQuery.php");
  require_once("../shared/common.php");
  require_once("../functions/inputFuncs.php");
  require_once("../shared/logincheck.php");
  require_once("../classes/MemberSancionHist.php");
  require_once("../classes/MemberSancionHistQuery.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  #****************************************************************************
  #*  Checking for get vars.  Go back to form if none found.
  #****************************************************************************
  if (count($_GET) == 0) {
    header("Location: ../circ/index.php");
    exit();
  }

  #****************************************************************************
  #*  Retrieving get var
  #****************************************************************************
  $mbrid = $_GET["mbrid"];
  if (isset($_GET["name"])) {
      $mbrName = urlencode($_GET["name"]);
  } else {
      $mbrName = "";
  }

  #****************************************************************************
  #*  Search database for member sancion history
  #****************************************************************************
  $histQ = new MemberSancionHistQuery();
  $histQ->connect();
  if ($histQ->errorOccurred()) {
    $histQ->close();
    displayErrorPage($histQ);
  }
  if (!$histQ->queryByMbrid($mbrid)) {
    $histQ->close();
    displayErrorPage($histQ);
  }

  #**************************************************************************
  #*  Show biblio checkout history
  #**************************************************************************
  require_once("../shared/header.php");
?>

<h1><?php print $loc->getText("mbrHistorySancionHead1"); ?></h1>
<table class="primary">
  <tr>
    <th valign="top" nowrap="yes" align="left">
      <?php print $loc->getText("mbrHistoryHdr1"); ?>
    </th>
    <th valign="top" nowrap="yes" align="left">
      <?php print $loc->getText("mbrHistoryHdr2"); ?>
    </th>	
    <th valign="top" nowrap="yes" align="left">
      <?php print $loc->getText("mbrHistorySancionHdr2"); ?>
    </th>
    <th valign="top" nowrap="yes" align="left">
      <?php print $loc->getText("mbrHistorySancionHdr3"); ?>
    </th>
  </tr>

<?php
  if ($histQ->getRowCount() == 0) {
?>
  <tr>
    <td class="primary" align="center" colspan="7">
      <?php print $loc->getText("mbrHistoryNoHist"); ?>
    </td>
  </tr>
<?php
  } else {
    while ($hist = $histQ->fetchRow()) {
?>
  <tr>
    <td class="primary" valign="top" >
      <?php echo $hist->getBarcode_nmbr();?>
    </td>
    <td class="primary" valign="top" >
      <?php echo $hist->getTitle();?>
    </td>	
    <td class="primary" valign="top" >
      <?php echo $hist->getFecha_aplico_sancion();?>
    </td>
    <td class="primary" valign="top" >
      <?php printDomainDescription("tipo_sancion_dm",$hist->getTipo_sancion_cd());?>
    </td>
  </tr>
<?php
    }
  }
  $histQ->close();

?>
</table>

<?php require_once("../shared/footer.php"); ?>
