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
  $restrictToMbrAuth = TRUE;
  $nav = "deletedone";
  $restrictInDemo = true;
  require_once("../shared/common.php");
  require_once("../shared/logincheck.php");
  require_once("../classes/MemberQuery.php");
  require_once("../classes/BiblioStatusHistQuery.php");
  require_once("../classes/MemberAccountQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  $mbrid = $_GET["mbrid"];
  $mbrName = $_GET["name"];

  #**************************************************************************
  #*  Delete library member
  #**************************************************************************
  $mbrQ = new MemberQuery();
  $mbrQ->connect();
  if ($mbrQ->errorOccurred()) {
    $mbrQ->close();
    displayErrorPage($mbrQ);
  }
  if (!$mbrQ->delete($mbrid)) {
    $mbrQ->close();
    displayErrorPage($mbrQ);
  }
  $mbrQ->close();

  #**************************************************************************
  #*  Delete Member History
  #**************************************************************************
  $histQ = new BiblioStatusHistQuery();
  $histQ->connect();
  if ($histQ->errorOccurred()) {
    $histQ->close();
    displayErrorPage($histQ);
  }
  if (!$histQ->deleteByMbrid($mbrid)) {
    $histQ->close();
    displayErrorPage($histQ);
  }
  $histQ->close();

  #**************************************************************************
  #*  Delete Member Account
  #**************************************************************************
  $transQ = new MemberAccountQuery();
  $transQ->connect();
  if ($transQ->errorOccurred()) {
    $transQ->close();
    displayErrorPage($transQ);
  }
  $trans = $transQ->delete($mbrid);
  if ($transQ->errorOccurred()) {
    $transQ->close();
    displayErrorPage($transQ);
  }
  $transQ->close();

  #**************************************************************************
  #*  Show success page
  #**************************************************************************
  require_once("../shared/header.php");
  echo $loc->getText("mbrDelSuccess",array("name"=>$mbrName));
  
?>
<br><br>
<a href="../circ/index.php"><?php echo $loc->getText("mbrDelReturn");?></a>
<?php require_once("../shared/footer.php"); ?>
