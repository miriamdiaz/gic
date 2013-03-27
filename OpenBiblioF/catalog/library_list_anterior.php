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
  $nav = "librarys";

  require_once("../classes/Library.php");
  require_once("../classes/LibraryQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../functions/formatFuncs.php");
  require_once("../shared/common.php");
  require_once("../shared/logincheck.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  
  require_once("../shared/header.php");

  $LQ = new LibraryQuery();
  $LQ->connect();
  if ($LQ->errorOccurred()) 
  {
    $LQ->close();
    displayErrorPage($LQ);
  }
  $LQ->execSelectWithStats("biblio_cod_library");
  if ($LQ->errorOccurred()) 
  {
    $LQ->close();
    displayErrorPage($LQ);
  }
 
?>


<a href="../catalog/library_new_form.php?reset=Y"> <? echo $loc->getText("catalogLibrary_listAddNewLibrary"); ?></a><br>
<h1><? echo $loc->getText("catalogLibrary_list"); ?></h1>
<table class="primary">
  <tr>
    <th colspan="2" valign="top"><? echo $loc->getText("catalogLibrary_listFunction"); ?>
      <font class="small">*</font>
    </th>
    <th valign="top">
      <? echo $loc->getText("catalogLibrary_listDescription"); ?>
    </th>

   


  </tr>
  <?php
    $row_class = "primary";
    while ($lb = $LQ->fetchRow())
	{ ?>
  <tr>
    <td valign="top" class="<?php echo $row_class;?>">
      <a href="../catalog/library_edit_form.php?code=<?php echo $lb->getCode();?>" class="<?php echo $row_class;?>"><? echo $loc->getText("adminCollections_listEdit"); ?></a>
    </td>
    <td valign="top" class="<?php echo $row_class;?>">
      <?php if ($lb->getCount() != 0) { ?>
        <a href="../catalog/library_del_confirm.php?code=<?php echo $lb->getCode();?>&desc=<?php echo urlencode($lb->getDescription());?>" class="<?php echo $row_class;?>"><? echo $loc->getText("adminCollections_listDel"); ?></a>
      <?php } else { echo "borrar"; }?>
    </td>
    <td valign="top" class="<?php echo $row_class;?>">
      <?php echo $lb->getDescription();?>
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
    $LQ->close();
  ?>
</table>
<br>
<table class="primary"><tr><td valign="top" class="noborder"><font class="small"><? echo $loc->getText("adminCollections_ListNote"); ?></font></td>
<td class="noborder"><font class="small"><? echo $loc->getText("catalogLibrary_ListNoteText"); ?><br></font>
</td></tr></table>
<?php include("../shared/footer.php"); ?>


?>
