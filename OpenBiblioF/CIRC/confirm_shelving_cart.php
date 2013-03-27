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
  $nav = "checkin";
  $restrictInDemo = true;
  require_once("../shared/common.php");
  require_once("../shared/logincheck.php");
  require_once("../classes/Member.php");
  require_once("../classes/MemberQuery.php");
  require_once("../classes/BiblioCopyQuery.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  $barcodeNmbr = $_POST["barcodeNmbr"];


  #****************************************************************************
  #*  Getting checkout count
  #****************************************************************************
  $copyQ = new BiblioCopyQuery();
  $copyQ->connect();
  if ($copyQ->errorOccurred()) {
    $copyQ->close();
    displayErrorPage($copyQ);
  }
  if (!$copy = $copyQ->queryByBarcode($barcodeNmbr)) {
    $copyQ->close();
    displayErrorPage($copyQ);
  }
  #****************************************************************************
  #*  Edit results
  #****************************************************************************
  $foundError = FALSE;
  if ($copyQ->getRowCount() == 0) {
    $foundError = true;
    $pageErrors["barcodeNmbr"] = $loc->getText("shelvingCartErr2");
  }
  
  if(!$foundError)  
     if($copy->getStatusCd()=="in" || $copy->getStatusCd()=="crt")
        {
        $foundError = true;
        $pageErrors["barcodeNmbr"] = $loc->getText("shelvingCartErr3");	 
	    }   
	
  if ($foundError == true) {
    $postVars["barcodeNmbr"] = $barcodeNmbr;
    $_SESSION["postVars"] = $postVars;
    $_SESSION["pageErrors"] = $pageErrors;
    header("Location: ../circ/checkin_form.php");
    exit();
  }	
  
  #****************************************************************************
  #*  Getting member name
  #****************************************************************************
  $mbrQ = new MemberQuery();
  $mbrQ->connect();
  if ($mbrQ->errorOccurred()) {
    $mbrQ->close();
    displayErrorPage($mbrQ);
  }
  $mbrid = $copy->getMbrid();
  if (!$mbrQ->execSelect($mbrid)) {
    $mbrQ->close();
    displayErrorPage($mbrQ);
  }
  $mbr = $mbrQ->fetchMember();
  $mbrQ->close();
  $mbrName = $mbr->getFirstName()." ".$mbr->getLastName();

  
  #**************************************************************************
  #*  Show confirm page
  #**************************************************************************
  require_once("../shared/header.php");
?>
<center>
<form name="confirm_shelvin_cart" method="POST" action="../circ/shelving_cart.php">
<?php echo $loc->getText("shelvingConfirmMsg",array("name"=>$mbrName)); 
  if(isset($_POST["renovar"]))
    echo "<input type='hidden' name='renovar' value='1'>";
?>
<br><br>
      <input type="hidden" name="barcodeNmbr" value="<?php echo $barcodeNmbr;?>">
	  <input type="hidden" name="mbrid" value="<?php echo $mbrid;?>">
      <input type="submit" value="<?php echo $loc->getText("shelvingConfirmMsgAccept"); ?>" class="button">
      <input type="button" onClick="parent.location='../circ/checkin_form.php'" value="<?php echo $loc->getText("circCancel"); ?>" class="button">
</form>
</center>
<?php 
  include("../shared/footer.php");
?>
