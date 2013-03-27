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
  $nav = "editmarc";
  require_once("../shared/common.php");
  require_once("../shared/logincheck.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);


  #****************************************************************************
  #*  Retrieving get var
  #****************************************************************************
  $bibid = $_GET["bibid"];
  $fieldid = $_GET["fieldid"];
  $tag = $_GET["tag"];
  $subfieldCd = $_GET["subfieldCd"];

  #**************************************************************************
  #*  Show confirm page
  #**************************************************************************
  require_once("../shared/header.php");
?>
<center>
<form name="delfieldform" method="POST" action="../catalog/biblio_marc_del.php?bibid=<?php echo $bibid;?>&fieldid=<?php echo $fieldid;?>">
  <?php echo $loc->getText("biblioMarcDelConfirmMsg",array("tag"=>$tag,"subfieldCd"=>$subfieldCd)); ?>
  <br><br>
  <input type="submit" value="Delete" class="button">
  <input type="button" onClick="parent.location='../catalog/biblio_marc_list.php?bibid=<?php echo $bibid;?>'" value="Cancel" class="button">
</form>
</center>
<?php include("../shared/footer.php"); ?>
