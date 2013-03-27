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
?>

<table class="primary">
  <tr> 
    <th colspan="2" valign="top" nowrap="yes" align="left"> <?php echo $headerWording;?> 
      <?php print $loc->getText("mbrFldsHeader"); ?> </td> </tr>
  <tr> 
    <td nowrap="true" class="primary"> <?php print $loc->getText("mbrFldsCardNmbr"); ?> 
    </td>
    <td valign="top" class="primary"> <?php printInputText("barcodeNmbr",20,20,$postVars,$pageErrors); ?> 
    </td>
  </tr>
  <tr> 
    <td nowrap="true" class="primary"> <?php print $loc->getText("mbrFldsLastName"); ?> 
    </td>
    <td valign="top" class="primary"> <?php printInputText("lastName",30,50,$postVars,$pageErrors); ?> 
    </td>
  </tr>
  <tr> 
    <td nowrap="true" class="primary"> <?php print $loc->getText("mbrFldsFirstName"); ?> 
    </td>
    <td valign="top" class="primary"> <?php printInputText("firstName",30,50,$postVars,$pageErrors); ?> 
    </td>
  </tr>
  <tr> 
    <td nowrap="true" class="primary"> <?php print $loc->getText("mbrFldsAddr1"); ?> 
    </td>
    <td valign="top" class="primary"> <?php printInputText("address1",40,128,$postVars,$pageErrors); ?> 
    </td>
  </tr>
  <tr> 
    <td nowrap="true" class="primary"> <?php print $loc->getText("mbrFldsAddr2"); ?> 
    </td>
    <td valign="top" class="primary"> <?php printInputText("address2",40,128,$postVars,$pageErrors); ?> 
    </td>
  </tr>
  <tr> 
    <td nowrap="true" class="primary"> <?php print $loc->getText("mbrFldsCity"); ?> 
    </td>
    <td valign="top" class="primary"> <?php printInputText("city",30,50,$postVars,$pageErrors); ?> 
    </td>
  </tr>
  <tr> 
    <td nowrap="true" class="primary"> <?php print $loc->getText("mbrFldsStateZip"); ?> 
    </td>
    <td valign="top" class="primary"> <?php printSelect("state","state_dm",$postVars); ?> 
      <?php printInputText("zip",5,5,$postVars,$pageErrors); ?>-<?php printInputText("zipExt",4,4,$postVars,$pageErrors); ?> 
    </td>
  </tr>
  <!--
  Fila agregada: Horacio Alvarez
  Fecha: 24-03-06
  Descripcion: Select de biblioteca
  -->
  <tr> 
    <td nowrap="true" class="primary"> <?php print $loc->getText("mbrFldsLibraryid"); ?> 
    </td>
    <td valign="top" class="primary"> <?php printSelectWithPosErrors("libraryid","biblio_cod_library",$postVars,$pageErrors); ?> 
    </td>
  </tr>
  <tr> 
    <td nowrap="true" class="primary"> <?php print $loc->getText("mbrFldsHomePhone"); ?> 
    </td>
    <td valign="top" class="primary"> <?php printInputText("homePhone",30,30,$postVars,$pageErrors); ?> 
    </td>
  </tr>
  <tr> 
    <td nowrap="true" class="primary"> <?php print $loc->getText("mbrFldsWorkPhone"); ?> 
    </td>
    <td valign="top" class="primary"> <?php printInputText("workPhone",30,30,$postVars,$pageErrors); ?> 
    </td>
  </tr>
  <tr> 
    <td nowrap="true" class="primary"> <?php print $loc->getText("mbrFldsEmail"); ?> 
    </td>
    <td valign="top" class="primary"> <?php printInputText("email",40,128,$postVars,$pageErrors); ?> 
    </td>
  </tr>  
  <tr> 
    <td nowrap="true" class="primary"> <?php print $loc->getText("mbrFldsObservaciones"); ?> 
    </td>
    <td valign="top" class="primary"> <?php printInputTextAreaFixed("observaciones",20,20,$postVars,$pageErrors);?>
    </td>
  </tr>
  <?php printInputText("cantidad_reservas",30,50,$postVars,$pageErrors,"","","hidden"); ?>
  <?php printInputText("cantidad_prestamos",30,50,$postVars,$pageErrors,"","","hidden"); ?>
  <?php printInputText("inicio_sancion",30,50,$postVars,$pageErrors,"","","hidden"); ?>
  <?php printInputText("sancion_activa",30,50,$postVars,$pageErrors,"","","hidden"); ?>
  <?php printInputText("copy_barcode",30,50,$postVars,$pageErrors,"","","hidden"); ?>
  <?
  /*************************************************************************/
  /*  CHECKEA SI EL OPERADOR TIENE PERMISO PARA LIMPIAR LA ULTIMA SANCION  /*
  /*************************************************************************/
  $sancion = 0;
  if(isset($mbr))
    $sancion = $mbr->getTipo_sancion_cd();
  if($_SESSION["hasLimpiarSancion"] && $sancion!=0)
//if(1==1)
  {
  ?>
    <tr> 
    <td nowrap="true" class="primary"> <?php print $loc->getText("mbrFldsLimpiar"); ?> 
    </td>
    <td valign="top" class="primary"> <?php printCheckBox("limpiar_sanciones","true"); ?> 
    </td>
    </tr>  
  <?
  }
  ?>
  <tr> 
    <td align="center" colspan="2" class="primary"> <input type="submit" value="<?php print $loc->getText("mbrFldsSubmit"); ?>" class="button"> 
      <input type="button" onClick="parent.location='<?php echo $cancelLocation;?>'" value="<?php print $loc->getText("mbrFldsCancel"); ?>" class="button"> 
    </td>
  </tr>
</table>
