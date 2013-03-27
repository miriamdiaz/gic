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

  $tab = "admin";
  $nav = "mails";

  require_once("../classes/Theme.php");
  require_once("../classes/ThemeQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../shared/common.php");
  require_once("../classes/Localize.php");
  require_once("../functions/inputFuncs.php");
  require_once("../funciones.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  
  require_once("../shared/logincheck.php");

  require_once("../shared/header.php");

  $themeQ = new ThemeQuery();
  $themeQ->connect();
  if ($themeQ->errorOccurred()) {
    $themeQ->close();
    displayErrorPage($themeQ);
  }
  $themeQ->execSelect();
  if ($themeQ->errorOccurred()) {
    $themeQ->close();
    displayErrorPage($themeQ);
  }

?>
<Script language="JavaScript">
function setearMensaje(object)
{
 var value = object.value;
 var element = document.getElementById("cuerpo");
 if(value == "avencer")
   {
    var str = "<iframe src=por_vencer.php?mostrar=1 scrolling=no width=600 height=500></iframe>";
	element.innerHTML = str;
   }
 else if(value == "vencidos")
   {
    var str = "<iframe src=vencidos.php?mostrar=1 scrolling=no width=600 height=500></iframe>";
	element.innerHTML = str;	
	}
}
</Script>

<form name="mailing_form" method="POST" action="../admin/enviarmails.php">
<table class="primary">
  <tr>
    <th nowrap="yes" align="left" colspan="2">
      Mailing
    </th>
  </tr>
  <tr>
    <td nowrap="true" class="primary"> Asunto 	</td>  
    <td nowrap="true" class="primary">  <input type="text" name="asunto" size="50" maxlength="50"> </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary">  A Tipo de Usuario </td>
    <td nowrap="true" class="primary"> <? printSelectWithPosErrors("classification","mbr_classify_dm",$postVars,$pageErrors); ?> </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary">  Filtro </td>
    <td nowrap="true" class="primary"> Con prestamos a vencer <input type="radio" name="filtro" value="avencer" onClick="setearMensaje(this)" checked> 
	Con prestamos vencidos <input type="radio" name="filtro" value="vencidos" onClick="setearMensaje(this)"></td>
  </tr>  
  <tr>
    <td nowrap="true" class="primary">  Mensaje </td>
    <td nowrap="true" class="primary" id="cuerpo"><iframe src="por_vencer.php?mostrar=1" scrolling="no" width="600" height="500"></iframe></td>
  </tr>    
  <tr>  
    <td nowrap="true" class="primary" colspan="2" align="center"> <input type="submit" value="Enviar Mails" class="button"></td>
  </tr>
</table>
</form>
<br>
<table class="primary"><tr><td valign="top" class="noborder"><font class="small"><? echo $loc->getText("adminTheme_Note"); ?></font></td>
<td class="noborder"><font class="small"><? echo $loc->getText("adminMails_Notetext"); ?></font>
</td></tr></table>
<?php include("../shared/footer.php"); ?>
