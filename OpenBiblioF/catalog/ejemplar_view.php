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
  #*  Checking for get vars.  Go back to form if none found.
  #****************************************************************************
  if (count($_GET) == 0) 
  {
    header("Location: ../catalog/index.php");
    exit();
  }

  #****************************************************************************
  #*  Checking for tab name to show OPAC look and feel if searching from OPAC
  #****************************************************************************
  if (isset($_GET["tab"])) 
  {
    $tab = $_GET["tab"];
	$tab=trim($tab);
  }
  else 
  {
    $tab = "cataloging";
  }

  $nav = "apruebaEjemplar";
  require_once("../shared/common.php");
  require_once("../shared/logincheck.php");
  
  require_once("../classes/Biblio.php");
  require_once("../classes/BiblioQuery.php");
  require_once("../classes/BiblioCopy.php");
  require_once("../classes/BiblioCopyQuery.php");
  require_once("../classes/DmQuery.php");
  require_once("../classes/UsmarcTagDm.php");
  require_once("../classes/UsmarcTagDmQuery.php");
  require_once("../classes/UsmarcSubfieldDm.php");
  require_once("../classes/UsmarcSubfieldDmQuery.php");
  require_once("../functions/marcFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,"shared");
  /*ini franco*/
  require_once("../classes/Staff.php");
  require_once("../classes/StaffQuery.php");
  require_once("../functions/errorFuncs.php");
  
  /*fin franco*/
  #****************************************************************************
  #*  Retrieving get var
  #****************************************************************************
  $bibid = $_GET["bibid"];
  $copyid= $_GET["copyid"];
  $barcodenmbr= $_GET["barcodenmbr"];
  if (isset($_GET["msg"])) 
  {
    $msg = "<font class=\"error\">".stripslashes($_GET["msg"])."</font><br><br>";
  } 
  else
  {
    $msg = "";
  }

 
  #****************************************************************************
  #*  Search database
  #****************************************************************************
  $biblioQ = new BiblioQuery();
  $biblioQ->connect();
  if ($biblioQ->errorOccurred())
  {
    $biblioQ->close();
    displayErrorPage($biblioQ);
  }
  if (!$biblio = $biblioQ->query($bibid)) 
  {
    $biblioQ->close();
    displayErrorPage($biblioQ);
  }

  #**************************************************************************
  #*  Show bibliography info.
  #**************************************************************************

  if ($tab == "opac") 
  {
    require_once("../shared/header_opac.php");
  } 
  else
  {
    require_once("../shared/header.php");
  }

?>

<?php echo $msg ?>

<?php
  #****************************************************************************
  #*  Show copy information
  #****************************************************************************
  $copyCols=10;//antes 5

  $copyQ = new BiblioCopyQuery();
  $copyQ->connect();
  if ($copyQ->errorOccurred()) 
  {
    $copyQ->close();
    displayErrorPage($copyQ);
  }
  if (!$copy = $copyQ->execSelect($bibid)) 
  {
    $copyQ->close();
    displayErrorPage($copyQ);
  }
?>

<h1><?php echo $loc->getText("biblioViewTble2Hdr"); ?>:</h1>
<table class="primary">
  <tr>
    <th align="left" nowrap="yes">
      <?php echo $loc->getText("biblioViewTble2Col1"); ?>
    </th>
    <th align="left" nowrap="yes">
      <?php echo $loc->getText("biblioViewTble2Col2"); ?>
    </th>
    <th align="left" nowrap="yes">
      <?php echo $loc->getText("biblioViewTble2Col3"); ?>
    </th>
    <th align="left" nowrap="yes">
      <?php echo $loc->getText("biblioViewTble2Col4"); ?>
    </th>
    <th align="left" nowrap="yes">
      <?php echo $loc->getText("biblioViewTble2Col5"); ?>
    </th>
    <?php /* ini franco 08/07/05*/ ?>
    <th align="left" nowrap="yes">
      <?php echo $loc->getText("biblioViewTble2Col6"); ?>
    </th>
    <th align="left" nowrap="yes">
      <?php echo $loc->getText("biblioViewTble2Col7"); ?>
    </th>
    <th align="left" nowrap="yes">
      <?php echo $loc->getText("biblioViewTble2Col8"); ?>
    </th>
    <th align="left" nowrap="yes">
      <?php echo $loc->getText("biblioViewTble2Col9"); ?>
    </th>
    <th align="left" nowrap="yes">
      <?php echo $loc->getText("biblioViewTble2Col10"); ?>
    </th>
 </tr>

  <?php
    if ($copyQ->getRowCount() == 0) { ?>
      <tr>
        <td valign="top" colspan="<?php echo $copyCols; ?>" class="primary" colspan="2">
          <?php echo $loc->getText("biblioViewNoCopies"); ?>
        </td>
      </tr>      
    <?php }
    else {
      $row_class = "primary";
      while ($copy = $copyQ->fetchCopy())
	  {
		if($copy->getCopyId() == $copyid)
        {
         //echo $copyQ->getRowCount()." ".$copy->getCopyId()." ".$copyid." ".$tab; 
	    ?>
    <tr>
      <td valign="top" class="<?php echo $row_class;?>">
        <?php echo $copy->getBarcodeNmbr(); ?>
      </td>
      <td valign="top" class="<?php echo $row_class;?>">
        <?php echo $copy->getCopyDesc(); ?>
      </td>
      <td valign="top" class="<?php echo $row_class;?>">
        <?php echo $biblioStatusDm[$copy->getStatusCd()]; ?>
      </td>
      <td valign="top" class="<?php echo $row_class;?>">
        <?php echo $copy->getStatusBeginDt(); ?>
      </td>
      <td valign="top" class="<?php echo $row_class;?>">
        <?php echo $copy->getDueBackDt(); ?>
      </td>
	 <?php /*ini franco 8/07/05 */ ?>
      <td valign="top" class="<?php echo $row_class;?>">
        <?php echo $copy->getTomo(); ?>
      </td>
      <td valign="top" class="<?php echo $row_class;?>">
        <?php echo $copy->getVolumen(); ?>
      </td>
      <td valign="top" class="<?php echo $row_class;?>">
        <?php echo $copy->getProveedor(); ?>
      </td>
      <td valign="top" class="<?php echo $row_class;?>">
        <?php echo "$".$copy->getPrecio(); ?>
      </td>
      <td valign="top" class="<?php echo $row_class;?>">
        <?php echo $copy->getCodLoc(); ?>
      </td>
   	 <?php } /*fin franco  */?>
    </tr>      
  <?php
        # swap row color
        if ($row_class == "primary") 
        {
          $row_class = "alt1";
        }
        else
        {
          $row_class = "primary";
        }
      }
      $copyQ->close();
    } ?>
</table>

<br />

<table align="center">

<td>
<form action="aprobarEjemplar.php" method="get" name="aprobarejemplar">
<input name="bibid" type="hidden" value=" <?php echo $bibid; ?> ">
<input name="copyid" type="hidden" value=" <?php echo $copyid; ?> ">
<input name="barcodenmbr" type="hidden" value=" <?php echo $barcodenmbr?> ">
<input name="aprobar" type="submit" value="aprobar">
</form>
</td>

<td>
<form action="../catalog/aprueba_Ejemplar.php" method="get" name="aprobarejemplar">
<input name="bibid" type="hidden" value=" <?php echo $bibid; ?> ">
<input name="cancelar" type="submit" value="Cancelar">
</form>
</td>
</table>
<?php require_once("../shared/footer.php"); ?>