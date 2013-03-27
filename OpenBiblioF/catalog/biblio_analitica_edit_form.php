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

  session_cache_limiter(null);

  $tab = "cataloging";
  $nav = "editanalitica";
  $focus_form_field = "barcodeNmbr";  
  $focus_form_name = "editAnaliticaForm";
  require_once("../shared/common.php");
  require_once("../functions/inputFuncs.php");
  require_once("../shared/logincheck.php");
  require_once("../classes/BiblioAnalitica.php");
  require_once("../classes/BiblioAnaliticaQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  require_once("../classes/Staff.php");
  require_once("../classes/StaffQuery.php");
  
  #****************************************************************************
  #*  Retrieving get var
  #****************************************************************************
  if (isset($_GET["bibid"]))
  {
    unset($_SESSION["postVars"]);
    unset($_SESSION["pageErrors"]);
    #****************************************************************************
    #*  Retrieving get var
    #****************************************************************************
    $bibid = $_GET["bibid"];
    $anaid = $_GET["anaid"];

    #****************************************************************************
    #*  Read analitica information
    #****************************************************************************
    $anaQ = new BiblioAnaliticaQuery();
    $anaQ->connect();
    if ($anaQ->errorOccurred()) 
	{
      $anaQ->close();
      displayErrorPage($anaQ);
    }
    if (!$ana = $anaQ->query($bibid,$anaid)) 
	{
      $anaQ->close();
      displayErrorPage($anaQ);
    }
    $postVars["bibid"] = $bibid;
    $postVars["anaid"] = $anaid;
    $postVars["anaTitulo"] = $ana->getAnaliticaTitulo();
    $postVars["anaAutor"] = $ana->getAnaliticaAutor();
    $postVars["anaPaginacion"] = $ana->getAnaliticaPaginacion();
	$postVars["anaMateria"] = $ana->getAnaliticaMateria();
	$postVars["anaUser"] = $ana->getUserCreador();
	$postVars["anaSubTitulo"] = $ana->getAnaliticaSubTitulo();

  } 
  else 
  {
    #**************************************************************************
    #*  load up post vars
    #**************************************************************************
    require("../shared/get_form_vars.php");
    $bibid = $postVars["bibid"];
    $anaid = $postVars["anaid"];
//	  echo "<h1>user".$postVars["anaUser"]."</h1>";
  }

  #**************************************************************************
  #*  disable status code drop down for shelving cart and out status codes
  #**************************************************************************
 // $statusDisabled = FALSE;
  //if (($postVars["statusCd"] == OBIB_STATUS_SHELVING_CART) or ($postVars["statusCd"] == OBIB_STATUS_OUT)) {
    //$statusDisabled = TRUE;
  //}

  require_once("../shared/header.php");
?>


<?php echo $loc->getText("catalogFootnote",array("symbol"=>"<font class=\"small\">*</font>")); ?>


<form name="editAnaliticaForm" method="POST" action="../catalog/biblio_analitica_edit.php">
<table class="primary">
  <tr>
    <th colspan="2" nowrap="yes" align="left">
      <?php echo $loc->getText("biblioAnaliticaEditFormLabel"); ?>:
    </th>
  </tr>
  <tr>
    <td nowrap="true" class="primary" valign="top">
      <sup>*</sup><?php echo $loc->getText("biblioAnaliticaNewTitulo"); ?>:
    </td>
    <td valign="top" class="primary">
      <?php printInputText("anaTitulo",40,150,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary" valign="top">
       <?php echo $loc->getText("biblioAnaliticaNewSubTitulo"); ?>:
    </td>
    <td valign="top" class="primary">
      <?php printInputText("anaSubTitulo",40,150,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary" valign="top">
      <?php echo $loc->getText("biblioAnaliticaNewAutor"); ?>:
    </td>
    <td valign="top" class="primary">
      <?php printInputText("anaAutor",40,100,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary" valign="top">
      <sup>*</sup><?php echo $loc->getText("biblioAnaliticaNewPaginacion"); ?>:
    </td>
    <td valign="top" class="primary">
	      <?php printInputText("anaPaginacion",40,40,$postVars,$pageErrors); ?>
    </td>
  </tr>
  
   <tr>
    <td nowrap="true" class="primary" valign="top">
      <?php echo $loc->getText("biblioAnaliticaNewMateria"); ?>:
    </td>
    <td valign="top" class="primary">
      <?php printInputText("anaMateria",40,40,$postVars,$pageErrors); ?>
    </td>
  </tr>

  <tr>
    <td nowrap="true" class="primary" valign="top">
      <?php echo $loc->getText("biblioAnaliticaUserCreador"); ?>:
    </td>
    <td valign="top" class="primary">
	 <input type="hidden" name="anaUser" value="<?php echo $postVars["anaUser"];?>">
	<?php 

	     $staffQ = new StaffQuery();
		 $staffQ->connect();
		 if ($staffQ->errorOccurred()) 
		 {
		    $staffQ->close();
	    	displayErrorPage($staffQ);
  		 }
		 $staffQ->execSelect($postVars["anaUser"]);
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
    <td align="center" colspan="2" class="primary">
      <input type="submit" value="<?php echo $loc->getText("catalogSubmit"); ?>" class="button">
      <input type="button" onClick="parent.location='../shared/biblio_view.php?bibid=<?php echo $bibid; ?>'" value="<?php echo $loc->getText("catalogCancel"); ?>" class="button" >
    </td>
  </tr>

</table>
<input type="hidden" name="bibid" value="<?php echo $bibid;?>">
<input type="hidden" name="anaid" value="<?php echo $anaid;?>">
</form>


<?php include("../shared/footer.php"); ?>