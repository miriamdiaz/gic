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
  $nav = "newcopy";
  $focus_form_name = "newCopyForm";
  $focus_form_field = "barcodeNmbr";

  #****************************************************************************
  #*  Checking for get vars.  Go back to form if none found.
  #****************************************************************************
  if (count($_GET) == 0) {
    header("Location: ../catalog/index.php");
    exit();
  }

  require_once("../shared/common.php");
  require_once("../functions/inputFuncs.php");
  require_once("../shared/logincheck.php");
  require_once("../shared/get_form_vars.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  #****************************************************************************
  #*  Retrieving get var
  #****************************************************************************
  $bibid = $_GET["bibid"];
  require_once("../shared/header.php");


?>


<?php echo $loc->getText("catalogFootnote",array("symbol"=>"<font>*</font class=\"small\">")); ?>


<form name="newCopyForm" method="POST" action="../catalog/biblio_copy_new.php">
<table class="primary">
  <tr>
    <th colspan="2" nowrap="yes" align="left">
      <?php echo $loc->getText("biblioCopyNewFormLabel"); ?>:
    </th>
  </tr>
  <tr>
    <td nowrap="true" class="primary" valign="top">
      <sup>*</sup> <?php echo $loc->getText("biblioCopyNewBarcode"); ?>:
    </td>
    <td valign="top" class="primary">
      <?php printInputText("barcodeNmbr",20,20,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary" valign="top">
      <?php echo $loc->getText("biblioCopyNewDesc"); ?>:
    </td>
    <td valign="top" class="primary">
      <?php printInputText("copyDesc",60,350,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <?php /*ini franco 06/07/05*/?>
  <tr>
    <td nowrap="true" class="primary" valign="top">
      <?php echo $loc->getText("biblioCopyNewVolumenTomo"); ?>:
    </td>
    <td valign="top" class="primary">
      <?php printInputText("copyVolumen",30,30,$postVars,$pageErrors); ?>
    </td>
  </tr>

  <!--<tr>
    <td nowrap="true" class="primary" valign="top">
      <?php //echo $loc->getText("biblioCopyNewTomo"); ?>:
    </td>
    <td valign="top" class="primary">
      <?php //printInputText("copyTomo",10,10,$postVars,$pageErrors); ?>
    </td>
  </tr>
-->
  <tr>
    <td nowrap="true" class="primary" valign="top">
      <?php echo $loc->getText("biblioCopyUserCreador"); ?>:
    </td>
    <td valign="top" class="primary">
     <?php if(isset($postVars["user_name_creador"])){echo $postVars["user_name_creador"]; } 
              else echo $_SESSION["username"]?>
    </td>
  </tr>

  <tr>
    <td nowrap="true" class="primary" valign="top">
      <?php echo $loc->getText("biblioCopyNewProveedor"); ?>:
    </td>
    <td valign="top" class="primary">
      <?php printInputTextWithSearch("copyProveedor",40,40,$postVars,$pageErrors,"copy_proveedor"); ?>
    </td>
  </tr>

  <tr>
    <td nowrap="true" class="primary" valign="top">
      <?php echo $loc->getText("biblioCopyNewPrecio"); ?>:$
    </td>
    <td valign="top" class="primary">
      <?php printInputText("copyPrecio",10,5,$postVars,$pageErrors); ?>
    </td>
  </tr>

  <tr>
    <td nowrap="true" class="primary" valign="top">
     <sup>*</sup> <?php echo $loc->getText("biblioCopyCodLoc"); ?>:
    </td>
    <td valign="top" class="primary">
       <?php printSelectVacio("copyCodLoc","biblio_cod_library",$postVars) ?>
    </td>
  </tr>

  <tr>
    <td nowrap="true" class="primary" valign="top">
      <?php echo $loc->getText("biblioCopyDateSPTU"); ?>:
    </td>
    <td valign="top" class="primary">
      <?php printSelectDate("fecha",$postVars,$pageErrors);?>
    </td>
  </tr>


  <?php /*fin franco*/?>

 <script language="javascript">
function Validar(form)
    {
    if ((form.copyCodLoc.value == ""))
  		{
  		alert("Atencion: hay que completar todos los campos requeridos."); 
  		return; 
  		}
    form.submit();
    }
</script>
  
  <tr>
    <td align="center" colspan="2" class="primary">
      <input type="button" onClick="Validar(this.form)" value="<?php echo $loc->getText("catalogSubmit"); ?>" class="button">
      <input type="button" onClick="parent.location='../shared/biblio_view.php?bibid=<?php echo $bibid; ?>'" value="<?php echo $loc->getText("catalogCancel"); ?>" class="button">
    </td>
  </tr>

</table>
<input type="hidden" name="bibid" value="<?php echo $bibid;?>">
</form>


<?php include("../shared/footer.php"); ?>
