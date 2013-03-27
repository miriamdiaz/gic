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
  if (count($_GET) == 0) {
    header("Location: ../catalog/index.php");
    exit();
  }

  #****************************************************************************
  #*  Checking for tab name to show OPAC look and feel if searching from OPAC
  #****************************************************************************
  if (isset($_GET["tab"])) {
    $tab = $_GET["tab"];
  } else {
    $tab = "cataloging";
  }

  $nav = "view";
  require_once("../shared/common.php");
  if ($tab != "opac") {
    require_once("../shared/logincheck.php");
  }
  require_once("../classes/Biblio.php");
  require_once("../classes/BiblioQuery.php");
  require_once("../classes/BiblioCopy.php");
  require_once("../classes/BiblioCopyQuery.php");
  require_once("../classes/BiblioAnalitica.php");
  require_once("../classes/BiblioAnaliticaQuery.php");

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
  if (isset($_GET["msg"])) {
    $msg = "<font class=\"error\">".stripslashes($_GET["msg"])."</font><br><br>";
  } else {
    $msg = "";
  }

  #****************************************************************************
  #*  Loading a few domain tables into associative arrays
  #****************************************************************************
  $dmQ = new DmQuery();
  $dmQ->connect();
  if ($dmQ->errorOccurred()) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }
  $dmQ->execSelect("collection_dm");
  $collectionDm = $dmQ->fetchRows();
  $dmQ->execSelect("material_type_dm");
  $materialTypeDm = $dmQ->fetchRows();
  $dmQ->execSelect("biblio_status_dm");
  $biblioStatusDm = $dmQ->fetchRows();
  $dmQ->close();

  $marcTagDmQ = new UsmarcTagDmQuery();
  $marcTagDmQ->connect();
  if ($marcTagDmQ->errorOccurred()) {
    $marcTagDmQ->close();
    displayErrorPage($marcTagDmQ);
  }
  $marcTagDmQ->execSelect();
  if ($marcTagDmQ->errorOccurred()) {
    $marcTagDmQ->close();
    displayErrorPage($marcTagDmQ);
  }
  $marcTags = $marcTagDmQ->fetchRows();
  $marcTagDmQ->close();

  $marcSubfldDmQ = new UsmarcSubfieldDmQuery();
  $marcSubfldDmQ->connect();
  if ($marcSubfldDmQ->errorOccurred()) {
    $marcSubfldDmQ->close();
    displayErrorPage($marcSubfldDmQ);
  }
  $marcSubfldDmQ->execSelect();
  if ($marcSubfldDmQ->errorOccurred()) {
    $marcSubfldDmQ->close();
    displayErrorPage($marcSubfldDmQ);
  }
  $marcSubflds = $marcSubfldDmQ->fetchRows();
  $marcSubfldDmQ->close();


  #****************************************************************************
  #*  Search database
  #****************************************************************************
  $biblioQ = new BiblioQuery();
  $biblioQ->connect();
  if ($biblioQ->errorOccurred()) {
    $biblioQ->close();
    displayErrorPage($biblioQ);
  }
  if (!$biblio = $biblioQ->query($bibid)) {
    $biblioQ->close();
    displayErrorPage($biblioQ);
  }
  $biblioFlds = $biblio->getBiblioFields();

  #**************************************************************************
  #*  Show bibliography info.
  #**************************************************************************
  if ($tab == "opac") {
    require_once("../shared/header_opac.php");
  } else {
    require_once("../shared/header.php");
  }

?>

<?php echo $msg ?>
<table class="primary">
  <tr>
    <th align="left" colspan="2" nowrap="yes">
      <?php echo $loc->getText("biblioViewTble1Hdr"); ?>:
    </th>
  </tr>
  <tr>	
    <td nowrap="true" class="primary" valign="top">
      <?php echo $loc->getText("biblioViewMaterialType"); ?>:
    </td>
    <td valign="top" class="primary">
      <?php echo $materialTypeDm[$biblio->getMaterialCd()];?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary" valign="top">
      <?php echo $loc->getText("biblioViewCollection"); ?>:
    </td>
    <td valign="top" class="primary">
      <?php echo $collectionDm[$biblio->getCollectionCd()];?>
    </td>
  </tr>
  <tr>
    <td class="primary" valign="top">
      <?php echo $loc->getText("biblioViewCallNmbr"); ?>:
    </td>
    <td valign="top" class="primary">
      <?php echo $biblio->getCallNmbr1(); ?>
      <?php echo $biblio->getCallNmbr2(); ?>
      <?php echo $biblio->getCallNmbr3(); ?>
    </td>
  </tr>
  <tr>
    <td class="primary" valign="top">
      <?php printUsmarcText(245,"a",$marcTags, $marcSubflds, FALSE);?>:
    </td>
    <td valign="top" class="primary">
      <?php if (isset($biblioFlds["245a"])) echo $biblioFlds["245a"]->getFieldData();?>
    </td>
  </tr>
  <tr>
    <td class="primary" valign="top">
      <?php printUsmarcText(245,"b",$marcTags, $marcSubflds, FALSE);?>:
    </td>
    <td valign="top" class="primary">
      <?php if (isset($biblioFlds["245b"])) echo $biblioFlds["245b"]->getFieldData();?>
    </td>
  </tr>
  <tr>
    <td class="primary" valign="top">
      <?php printUsmarcText(100,"a",$marcTags, $marcSubflds, FALSE);?>:
    </td>
    <td valign="top" class="primary">
      <?php if (isset($biblioFlds["100a"])) echo $biblioFlds["100a"]->getFieldData();?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary" valign="top">
      <?php printUsmarcText(245,"c",$marcTags, $marcSubflds, FALSE);?>:
    </td>
    <td valign="top" class="primary">
      <?php if (isset($biblioFlds["245c"])) echo $biblioFlds["245c"]->getFieldData();?>
    </td>
  </tr>
  <?php if($tab != "opac"){?>
  <tr>
    <td nowrap="true" class="primary" valign="top">
      <?php echo $loc->getText("biblioViewOpacFlg"); ?>:
    </td>
    <td valign="top" class="primary">
      <?php if ($biblio->showInOpac()) {
        echo $loc->getText("biblioViewYes");
      } else {
        echo $loc->getText("biblioViewNo");
      }?>
    </td>
  </tr>
 <? /* ini franco*/ ?>
  <tr>
  	<td class="primary" valign="top">
		Usuario:
	</td>
	
	<td valign="top" class="primary">
	<?php 
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
		 echo $staff->getLastName();
    	  ?>
	</td>
	
  </tr>
   <tr>
  	<td class="primary" valign="top">
		Fecha de Ingreso SPTU:
	</td>
	
	<td valign="top" class="primary">
	<?php  echo $biblio->getFechaCatalog(); ?>
	</td>
  </tr>
 <?php }?>
  <tr>
	<td class="primary" valign="top">
		Indice:
	</td>
	<td valign="top" class="primary">
		<?php echo $biblio->getIndice(); ?>
	</td>
  </tr>
  <? /*fin -franco*/?>
</table>
<br>
<table class="primary">
  <tr>
    <th align="left" colspan="2" nowrap="yes">
      <?php echo $loc->getText("biblioViewTble3Hdr"); ?>:
    </th>
  </tr>
  <?php
    $displayCount = 0;
    foreach ($biblioFlds as $key => $field) {
      if (($field->getFieldData() != "") 
        && ($key != "245a")
        && ($key != "245b")
        && ($key != "245c")
        && ($key != "100a")) {
        $displayCount = $displayCount + 1;
  ?>
        <tr>
          <td valign="top" class="primary">
            <?php printUsmarcText($field->getTag(),$field->getSubfieldCd(),$marcTags, $marcSubflds, FALSE);?>:
          </td>
          <td valign="top" class="primary"><?php echo $field->getFieldData(); ?></td>
        </tr>      
  <?php
      }
    }
    if ($displayCount == 0) {
  ?>
        <tr>
          <td valign="top" class="primary" colspan="2">
            <?php echo $loc->getText("biblioViewNoAddInfo"); ?>
          </td>
        </tr>      
  <?php
    }
  ?>

</table>
<br>
<?php
  #****************************************************************************
  #*  Show analitica information
  #****************************************************************************
  if ($tab == "cataloging") { ?>
    <a href="../catalog/biblio_analitica_new_form.php?bibid=<?php echo $bibid;?>&reset=Y">
      <?php echo $loc->getText("biblioViewNewAnalitica"); ?></a><br/>
    <?php
    $anaCols=6;
  } else {
    $anaCols=4;
  }

  $anaQ = new BiblioAnaliticaQuery();
  $anaQ->connect();
  if ($anaQ->errorOccurred()) {
    $anaQ->close();
    displayErrorPage($anaQ);
  }
  if (!$ana = $anaQ->execSelect($bibid)) {
    $anaQ->close();
    displayErrorPage($anaQ);
  }
?>

<h1><?php echo $loc->getText("biblioViewTble4Hdr"); ?>:</h1>
<table class="primary">
  <tr>
    <?php if ($tab == "cataloging") { ?>
      <th colspan="2" nowrap="yes">
        <?php echo $loc->getText("biblioViewTble2ColFunc"); ?>
      </th>
    <?php } ?>
    <th align="left" nowrap="yes">
      <?php echo $loc->getText("biblioViewTble4Col1"); ?>
    </th>
    <th align="left" nowrap="yes">
      <?php echo $loc->getText("biblioViewTble4Col2"); ?>
    </th>
    <th align="left" nowrap="yes">
      <?php echo $loc->getText("biblioViewTble4Col3"); ?>
    </th>
    <th align="left" nowrap="yes">
      <?php echo $loc->getText("biblioViewTble4Col4"); ?>
    </th>
  </tr>
  <?php
    if ($anaQ->getRowCount() == 0) { ?>
      <tr> 
        <td valign="top" colspan="<?php echo $anaCols;?>" class="primary">
          <?php echo $loc->getText("biblioViewNoAnaliticas"); ?>
        </td>
      </tr>      
    <?php } else {
      $row_class = "primary";
      while ($ana = $anaQ->fetchAnalitica()) {
  ?>
    <tr>
      <?php if ($tab == "cataloging") { ?>
        <td valign="top" class="<?php echo $row_class;?>">
          <a href="../catalog/biblio_analitica_edit_form.php?bibid=<?php echo $ana->getBibid();?>&anaid=<?php echo $ana->getAnaid();?>" class="<?php echo $row_class;?>"><?php echo $loc->getText("biblioViewTble2Coledit"); ?></a>
        </td>
        <td valign="top" class="<?php echo $row_class;?>">
          <a href="../catalog/biblio_analitica_del_confirm.php?bibid=<?php echo $ana->getBibid();?>&anaid=<?php echo $ana->getAnaid();?>" class="<?php echo $row_class;?>"><?php echo $loc->getText("biblioViewTble2Coldel"); ?></a>
        </td>
      <?php } ?>
      <td valign="top" class="<?php echo $row_class;?>">
        <?php echo $ana->getAnaliticaTitulo(); ?>
      </td>
      <td valign="top" class="<?php echo $row_class;?>">
        <?php echo $ana->getAnaliticaAutor(); ?>
      </td>
      <td valign="top" class="<?php echo $row_class;?>">
        <?php echo $ana->getAnaliticaPaginacion(); ?>
      </td>
      <td valign="top" class="<?php echo $row_class;?>">
        <?php echo $ana->getAnaliticaMateria(); ?>
      </td>
    </tr>      
  <?php
        # swap row color
        if ($row_class == "primary") {
          $row_class = "alt1";
        } else {
          $row_class = "primary";
        }
      }
      $anaQ->close();
    } ?>
</table>
<br/>
<?php
  #****************************************************************************
  #*  Show copy information
  #****************************************************************************
  if ($tab == "cataloging") { ?>
    <a href="../catalog/biblio_copy_new_form.php?bibid=<?php echo $bibid;?>&reset=Y">
      <?php echo $loc->getText("biblioViewNewCopy"); ?></a><br/>
    <?php
    $copyCols=12;//antes 7
  } else {
    $copyCols=10;//antes 5
  }

  $copyQ = new BiblioCopyQuery();
  $copyQ->connect();
  if ($copyQ->errorOccurred()) {
    $copyQ->close();
    displayErrorPage($copyQ);
  }
  if (!$copy = $copyQ->execSelect($bibid)) {
    $copyQ->close();
    displayErrorPage($copyQ);
  }
?>

<h1><?php echo $loc->getText("biblioViewTble2Hdr"); ?>:</h1>
<table class="primary">
  <tr>
    <?php if ($tab == "cataloging") { ?>
      <th colspan="2" nowrap="yes">
        <?php echo $loc->getText("biblioViewTble2ColFunc"); ?>
      </th>
    <?php } ?>
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
    <?php /* fin franco*/ ?>
  </tr>
  <?php
    if ($copyQ->getRowCount() == 0) { ?>
      <tr>
        <td valign="top" colspan="<?php echo $copyCols; ?>" class="primary">
          <?php echo $loc->getText("biblioViewNoCopies"); ?>
        </td>
      </tr>      
    <?php } else {
      $row_class = "primary";
      while ($copy = $copyQ->fetchCopy()) {
  ?>
    <tr>
      <?php if ($tab == "cataloging") { ?>
        <td valign="top" class="<?php echo $row_class;?>">
          <a href="../catalog/biblio_copy_edit_form.php?bibid=<?php echo $copy->getBibid();?>&copyid=<?php echo $copy->getCopyid();?>" class="<?php echo $row_class;?>"><?php echo $loc->getText("biblioViewTble2Coledit"); ?></a>
        </td>
        <td valign="top" class="<?php echo $row_class;?>">
          <a href="../catalog/biblio_copy_del_confirm.php?bibid=<?php echo $copy->getBibid();?>&copyid=<?php echo $copy->getCopyid();?>" class="<?php echo $row_class;?>"><?php echo $loc->getText("biblioViewTble2Coldel"); ?></a>
        </td>
      <?php } ?>
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
   	 <?php /*fin franco  */?>
    </tr>      
  <?php
        # swap row color
        if ($row_class == "primary") {
          $row_class = "alt1";
        } else {
          $row_class = "primary";
        }
      }
      $copyQ->close();
    } ?>
</table>

<?php require_once("../shared/footer.php"); ?>
