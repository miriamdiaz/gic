<?php
/**********************************************************************************
 *   Copyright(C) 2002-2004 David Stevens
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
  require_once("../classes/StaffQuery.php");
  require_once("../classes/Localize.php");
  $headerLoc = new Localize(OBIB_LOCALE,"shared");

// code html tag with language attribute if specified.
echo "<html";
if (OBIB_HTML_LANG_ATTR != "") {
  echo " lang=\"".OBIB_HTML_LANG_ATTR."\"";
}
echo ">\n";

// code character set if specified
if (OBIB_CHARSET != "") { ?>
<META http-equiv="content-type" content="text/html; charset=<?php echo OBIB_CHARSET; ?>">
<?php } ?>

<head>
<style type="text/css">
  <MM:BeginLock translatorClass="MM_SSI" type="ssi" orig="%3C?php include(%22../css/style.php%22);?%3E" fileRef="../css/style.php" depFiles="file:///C|/apachefriends/xampp/htdocs/OpenBiblioF/css/style.php">/*********************************************************
 *  Body Style
 *********************************************************/
body {
  background-color: <?php echo OBIB_PRIMARY_BG;?>
}

/*********************************************************
 *  Font Styles
 *********************************************************/
font.primary {
  color: <?php echo OBIB_PRIMARY_FONT_COLOR;?>;
  font-size: <?php echo OBIB_PRIMARY_FONT_SIZE;?>px;
  font-family: <?php echo OBIB_PRIMARY_FONT_FACE;?>;
}
font.alt1 {
  color: <?php echo OBIB_ALT1_FONT_COLOR;?>;
  font-size: <?php echo OBIB_ALT1_FONT_SIZE;?>px;
  font-family: <?php echo OBIB_ALT1_FONT_FACE;?>;
}
font.alt1tab {
  color: <?php echo OBIB_ALT1_FONT_COLOR;?>;
  font-size: <?php echo OBIB_ALT2_FONT_SIZE;?>px;
  font-family: <?php echo OBIB_ALT2_FONT_FACE;?>;
<?php if (OBIB_ALT2_FONT_BOLD) { ?>
  font-weight: bold;
<?php } else { ?>
  font-weight: normal;
<?php } ?>
}
font.alt2 {
  color: <?php echo OBIB_ALT2_FONT_COLOR;?>;
  font-size: <?php echo OBIB_ALT2_FONT_SIZE;?>px;
  font-family: <?php echo OBIB_ALT2_FONT_FACE;?>;
<?php if (OBIB_ALT2_FONT_BOLD) { ?>
  font-weight: bold;
<?php } else { ?>
  font-weight: normal;
<?php } ?>
}
font.error {
  color: <?php echo OBIB_PRIMARY_ERROR_COLOR;?>;
  font-size: <?php echo OBIB_PRIMARY_FONT_SIZE;?>px;
  font-family: <?php echo OBIB_PRIMARY_FONT_FACE;?>;
  font-weight: bold;
}
font.small {
  font-size: 10px;
  font-family: <?php echo OBIB_PRIMARY_FONT_FACE;?>;
}
a.nav {
  color: <?php echo OBIB_ALT1_FONT_COLOR;?>;
  font-size: 10px;
  font-family: <?php echo OBIB_ALT1_FONT_FACE;?>;
  text-decoration: none;
  background-color: <?php echo OBIB_ALT1_BG;?>;
  border-style: solid;
  border-color: <?php echo OBIB_BORDER_COLOR;?>;
  border-width: <?php echo OBIB_BORDER_WIDTH;?>
}
h1 {
  font-size: 16px;
  font-family: <?php echo OBIB_PRIMARY_FONT_FACE;?>;
  font-weight: normal;
}

/*********************************************************
 *  Link Styles
 *********************************************************/
a:link {
  color: <?php echo OBIB_PRIMARY_LINK_COLOR;?>;
}
a:visited {
  color: <?php echo OBIB_PRIMARY_LINK_COLOR;?>;
}
a.primary:link {
  color: <?php echo OBIB_PRIMARY_LINK_COLOR;?>;
}
a.primary:visited {
  color: <?php echo OBIB_PRIMARY_LINK_COLOR;?>;
}
a.alt1:link {
  color: <?php echo OBIB_ALT1_LINK_COLOR;?>;
}
a.alt1:visited {
  color: <?php echo OBIB_ALT1_LINK_COLOR;?>;
}
a.alt2:link {
  color: <?php echo OBIB_ALT2_LINK_COLOR;?>;
}
a.alt2:visited {
  color: <?php echo OBIB_ALT2_LINK_COLOR;?>;
}
a.tab:link {
  color: <?php echo OBIB_ALT2_LINK_COLOR;?>;
  font-size: <?php echo OBIB_ALT2_FONT_SIZE;?>px;
  font-family: <?php echo OBIB_ALT2_FONT_FACE;?>;
<?php if (OBIB_ALT2_FONT_BOLD) { ?>
  font-weight: bold;
<?php } else { ?>
  font-weight: normal;
<?php } ?>
  text-decoration: none
}
a.tab:visited {
  color: <?php echo OBIB_ALT2_LINK_COLOR;?>;
  font-size: <?php echo OBIB_ALT2_FONT_SIZE;?>px;
  font-family: <?php echo OBIB_ALT2_FONT_FACE;?>;
<?php if (OBIB_ALT2_FONT_BOLD) { ?>
  font-weight: bold;
<?php } else { ?>
  font-weight: normal;
<?php } ?>
  text-decoration: none
}
a.tab:hover {text-decoration: underline}

/*********************************************************
 *  Table Styles
 *********************************************************/
table.primary {
  border-collapse: collapse
}
table.border {
  border-style: solid;
  border-color: <?php echo OBIB_BORDER_COLOR;?>;
  border-width: <?php echo OBIB_BORDER_WIDTH;?>
}
th {
  background-color: <?php echo OBIB_ALT2_BG;?>;
  color: <?php echo OBIB_ALT2_FONT_COLOR;?>;
  font-size: <?php echo OBIB_ALT2_FONT_SIZE;?>px;
  font-family: <?php echo OBIB_ALT2_FONT_FACE;?>;
  padding: <?php echo OBIB_PADDING;?>;
  border-style: solid;
<?php if (OBIB_ALT2_FONT_BOLD) { ?>
  font-weight: bold;
<?php } else { ?>
  font-weight: normal;
<?php } ?>
  border-color: <?php echo OBIB_BORDER_COLOR;?>;
  border-width: <?php echo OBIB_BORDER_WIDTH;?>;
  height: 1
}
th.rpt {
  background-color: <?php echo OBIB_PRIMARY_BG;?>;
  color: <?php echo OBIB_PRIMARY_FONT_COLOR;?>;
  font-size: <?php echo (OBIB_PRIMARY_FONT_SIZE - 2);?>px;
  font-family: Arial;
  font-weight: bold;
  padding: <?php echo OBIB_PADDING;?>;
  border-style: solid;
  border-color: <?php echo OBIB_BORDER_COLOR;?>;
  border-width: 1;
  text-align: left;
  vertical-align: bottom;
}
td.primary {
  background-color: <?php echo OBIB_PRIMARY_BG;?>;
  color: <?php echo OBIB_PRIMARY_FONT_COLOR;?>;
  font-size: <?php echo OBIB_PRIMARY_FONT_SIZE;?>px;
  font-family: <?php echo OBIB_PRIMARY_FONT_FACE;?>;
  padding: <?php echo OBIB_PADDING;?>;
  border-style: solid;
  border-color: <?php echo OBIB_BORDER_COLOR;?>;
  border-width: <?php echo OBIB_BORDER_WIDTH;?>
}
td.rpt {
  background-color: <?php echo OBIB_PRIMARY_BG;?>;
  color: <?php echo OBIB_PRIMARY_FONT_COLOR;?>;
  font-size: <?php echo (OBIB_PRIMARY_FONT_SIZE - 2);?>px;
  font-family: Arial;
  padding: <?php echo OBIB_PADDING;?>;
  border-top-style: none;
  border-bottom-style: none;
  border-left-style: solid;
  border-left-color: <?php echo OBIB_BORDER_COLOR;?>;
  border-left-width: 1;
  border-right-style: solid;
  border-right-color: <?php echo OBIB_BORDER_COLOR;?>;
  border-right-width: 1;
  text-align: left;
  vertical-align: top;
}
td.primaryNoWrap {
  background-color: <?php echo OBIB_PRIMARY_BG;?>;
  color: <?php echo OBIB_PRIMARY_FONT_COLOR;?>;
  font-size: <?php echo OBIB_PRIMARY_FONT_SIZE;?>px;
  font-family: <?php echo OBIB_PRIMARY_FONT_FACE;?>;
  padding: <?php echo OBIB_PADDING;?>;
  border-style: solid;
  border-color: <?php echo OBIB_BORDER_COLOR;?>;
  border-width: <?php echo OBIB_BORDER_WIDTH;?>;
  white-space: nowrap
}

td.title {
  background-color: <?php echo OBIB_TITLE_BG;?>;
  color: <?php echo OBIB_TITLE_FONT_COLOR;?>;
  font-size: <?php echo OBIB_TITLE_FONT_SIZE;?>px;
  font-family: <?php echo OBIB_TITLE_FONT_FACE;?>;
  padding: <?php echo OBIB_PADDING;?>;
<?php if (OBIB_TITLE_FONT_BOLD) { ?>
  font-weight: bold;
<?php } else { ?>
  font-weight: normal;
<?php } ?>
  border-color: <?php echo OBIB_BORDER_COLOR;?>;
  border-width: <?php echo OBIB_BORDER_WIDTH;?>;
  text-align: <?php echo OBIB_TITLE_ALIGN;;?>
}
td.alt1 {
  background-color: <?php echo OBIB_ALT1_BG;?>;
  color: <?php echo OBIB_ALT1_FONT_COLOR;?>;
  font-size: <?php echo OBIB_ALT1_FONT_SIZE;?>px;
  font-family: <?php echo OBIB_ALT1_FONT_FACE;?>;
  padding: <?php echo OBIB_PADDING;?>;
  border-style: solid;
  border-color: <?php echo OBIB_BORDER_COLOR;?>;
  border-width: <?php echo OBIB_BORDER_WIDTH;?>
}
td.tab1 {
  background-color: <?php echo OBIB_ALT1_BG;?>;
  color: <?php echo OBIB_ALT1_FONT_COLOR;?>;
  font-size: <?php echo OBIB_ALT1_FONT_SIZE;?>px;
  font-family: <?php echo OBIB_ALT2_FONT_FACE;?>;
<?php if (OBIB_ALT2_FONT_BOLD) { ?>
  font-weight: bold;
<?php } else { ?>
  font-weight: normal;
<?php } ?>
  padding: <?php echo OBIB_PADDING;?>;
}
td.tab2 {
  background-color: <?php echo OBIB_ALT2_BG;?>;
  color: <?php echo OBIB_ALT2_FONT_COLOR;?>;
  font-size: <?php echo OBIB_ALT2_FONT_SIZE;?>px;
  font-family: <?php echo OBIB_ALT2_FONT_FACE;?>;
<?php if (OBIB_ALT2_FONT_BOLD) { ?>
  font-weight: bold;
<?php } else { ?>
  font-weight: normal;
<?php } ?>
  padding: <?php echo OBIB_PADDING;?>;
}
td.noborder {
  background-color: <?php echo OBIB_PRIMARY_BG;?>;
  color: <?php echo OBIB_PRIMARY_FONT_COLOR;?>;
  font-size: <?php echo OBIB_PRIMARY_FONT_SIZE;?>px;
  font-family: <?php echo OBIB_PRIMARY_FONT_FACE;?>;
  padding: <?php echo OBIB_PADDING;?>;
}
/*********************************************************
 *  Form Styles
 *********************************************************/
input.button {
  background-color: <?php echo OBIB_ALT1_BG;?>;
  border-color: <?php echo OBIB_ALT1_BG;?>;
  border-left-color: <?php echo OBIB_ALT1_BG;?>;
  border-top-color: <?php echo OBIB_ALT1_BG;?>;
  border-bottom-color: <?php echo OBIB_ALT1_BG;?>;
  border-right-color: <?php echo OBIB_ALT1_BG;?>;
  padding: <?php echo OBIB_PADDING;?>;
  font-family: <?php echo OBIB_PRIMARY_FONT_FACE;?>;
  color: <?php echo OBIB_ALT1_FONT_COLOR;?>;
}
input.navbutton {
  background-color: <?php echo OBIB_ALT2_BG;?>;
  border-color: <?php echo OBIB_ALT2_BG;?>;
  border-left-color: <?php echo OBIB_ALT2_BG;?>;
  border-top-color: <?php echo OBIB_ALT2_BG;?>;
  border-bottom-color: <?php echo OBIB_ALT2_BG;?>;
  border-right-color: <?php echo OBIB_ALT2_BG;?>;
  padding: <?php echo OBIB_PADDING;?>;
  font-family: <?php echo OBIB_PRIMARY_FONT_FACE;?>;
  color: <?php echo OBIB_ALT2_FONT_COLOR;?>;
}
input {
  background-color: <?php echo OBIB_PRIMARY_BG;?>;
  border-color: <?php echo OBIB_PRIMARY_BG;?>;
  border-left-color: <?php echo OBIB_PRIMARY_BG;?>;
  border-top-color: <?php echo OBIB_PRIMARY_BG;?>;
  border-bottom-color: <?php echo OBIB_PRIMARY_BG;?>;
  border-right-color: <?php echo OBIB_PRIMARY_BG;?>;
  padding: 0px;
  scrollbar-base-color: <?php echo OBIB_ALT1_BG;?>;
  font-family: <?php echo OBIB_PRIMARY_FONT_FACE;?>;
  color: <?php echo OBIB_PRIMARY_FONT_COLOR;?>;
}
textarea {
  background-color: <?php echo OBIB_PRIMARY_BG;?>;
  border-color: <?php echo OBIB_PRIMARY_BG;?>;
  border-left-color: <?php echo OBIB_PRIMARY_BG;?>;
  border-top-color: <?php echo OBIB_PRIMARY_BG;?>;
  border-bottom-color: <?php echo OBIB_PRIMARY_BG;?>;
  border-right-color: <?php echo OBIB_PRIMARY_BG;?>;
  padding: 0px;
  scrollbar-base-color: <?php echo OBIB_ALT1_BG;?>;
  font-family: <?php echo OBIB_PRIMARY_FONT_FACE;?>;
  color: <?php echo OBIB_PRIMARY_FONT_COLOR;?>;
  font-size: <?php echo OBIB_PRIMARY_FONT_SIZE;?>px;
}
select {
  background-color: <?php echo OBIB_PRIMARY_BG;?>;
  border-color: <?php echo OBIB_PRIMARY_BG;?>;
  border-left-color: <?php echo OBIB_PRIMARY_BG;?>;
  border-top-color: <?php echo OBIB_PRIMARY_BG;?>;
  border-bottom-color: <?php echo OBIB_PRIMARY_BG;?>;
  border-right-color: <?php echo OBIB_PRIMARY_BG;?>;
  padding: 0px;
  scrollbar-base-color: <?php echo OBIB_ALT1_BG;?>;
  font-family: <?php echo OBIB_PRIMARY_FONT_FACE;?>;
  color: <?php echo OBIB_PRIMARY_FONT_COLOR;?>;
}
<MM:EndLock>
</style>
<meta name="description" content="OpenBiblio Library Automation System">
<title><?php echo OBIB_LIBRARY_NAME;?></title>

<script language="JavaScript">
<!--
function popSecondary(url) {
    var SecondaryWin;
    SecondaryWin = window.open(url,"secondary","resizable=yes,scrollbars=yes,width=535,height=400");
    self.name="main";
}
/* 
Name: Horacio Alvarez 
Date: 2006-04-20
Description: cumple la misma fucion que popSecondary solo que este se utiliza unicamente para abrir
el pop up de saldo de prestamos en circ/mbr_view.php
*/
function popSecondaryForSaldosPrestamos(url) {
    var SecondaryWin;
    var checkboxs=document.imprimirSaldoPrestamos.seleccionar;
    var valor="";
	if(checkboxs!=null)
	{
    for(var i=0;i<checkboxs.length;i++)
       {
        if(checkboxs[i].checked)
          url+="&"+checkboxs[i].value+"=true";
       }	
    SecondaryWin = window.open(url,"secondary","resizable=yes,scrollbars=yes,width=535,height=400");
    self.name="main";
	}
	else alert("No existen prestamos realizados");
}
/* 
Name: Horacio Alvarez 
Date: 2006-03-12
Description: cumple la misma fucion que popSecondary, solo que esta recibe como parametros el tamaño deseado del pop-up
*/
function popSecondary(url,width,height) {
    var SecondaryWin;
    SecondaryWin = window.open(url,"secondary","resizable=yes,scrollbars=yes,width="+width+",height="+height);
    self.name="main";
}
function popSecondaryLarge(url) {
    var SecondaryWin;
    SecondaryWin = window.open(url,"secondary","toolbar=yes,resizable=yes,scrollbars=yes,width=700,height=500");
    self.name="main";
}
function backToMain(URL) {
    var mainWin;
    mainWin = window.open(URL,"main");
    mainWin.focus();
    this.close();
}
/*
Autor: Horacio Alvarez
Fecha: 13-06-06
Descripcion: Se encarga de refrescar la pagina de mbr_view en caso
de que se halla seteado automaticamente la segunda infraccion.
*/
function refrescar()
{
var mbrid="";
if(document.imprimirSaldoPrestamos!=null)
   if(document.imprimirSaldoPrestamos.refresca!=null)
     {
	  mbrid=document.imprimirSaldoPrestamos.refresca.value;
      window.location.replace("../circ/mbr_view.php?mbrid="+mbrid+"&reset=Y");
	 }
}
/*
Autor: Horacio Alvarez
Fecha: 13-06-06
Descripcion: Se encarga de levantar un pop-up con en comprobante de infraccion
en caso de que se le halla seteado al socio una suspension por infraccion al devolver
un libro en shelving_cart.php.
*/
function comprobante_sancion()
{
var sancionado_barcode=null;
var sancionado_mbrid=null;
if(document.sancion_shelving_cart!=null)
  {
   sancionado_barcode=document.sancion_shelving_cart.sancionado_barcode;
   sancionado_mbrid=document.sancion_shelving_cart.sancionado_mbrid;
  }
if(sancionado_barcode!=null) 
   window.open("checkin_sancion.php?barcode="+sancionado_barcode.value+"&mbrid="+sancionado_mbrid.value,"secondary","toolbar=no,resizable=yes,scrollbars=yes,width=700,height=500");
}
-->
</script>


</head>
<body bgcolor="<?php echo OBIB_PRIMARY_BG;?>" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" marginheight="0" marginwidth="0" <?php
  if (isset($focus_form_name) && ($focus_form_name != "")) {
  echo 'onLoad="refrescar();comprobante_sancion();self.focus();if(document.'.$focus_form_name.'!=null) if(document.'.$focus_form_name.".".$focus_form_field.'!=null) document.'.$focus_form_name.".".$focus_form_field.'.focus()"';
} ?> >

<!-- **************************************************************************************
     * Library Name and hours
     **************************************************************************************

ORIGINAL DE OPENBILIO 0.5.1
<table  class="primary" width="100%" cellpadding="0" cellspacing="0" border="0">
  <tr bgcolor="<?php echo OBIB_TITLE_BG;?>">
    <td width="100%" class="title" valign="top">
       <?php
         if (OBIB_LIBRARY_IMAGE_URL != "") {
           echo "<img align=\"middle\" src=\"".OBIB_LIBRARY_IMAGE_URL."\" border=\"0\">";
         }
         if (!OBIB_LIBRARY_USE_IMAGE_ONLY) {
           echo " ".OBIB_LIBRARY_NAME;
         }
       ?>
    </td>
    <td valign="top">
      <table class="primary" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td class="title" nowrap="yes"><font class="small"><?php print $headerLoc->getText("headerTodaysDate"); ?></font></td>
          <td class="title" nowrap="yes"><font class="small"><?php print date($headerLoc->getText("headerDateFormat"));?></font></td>
        </tr>
        <tr>
          <td class="title" nowrap="yes"><font class="small"><?php if (OBIB_LIBRARY_HOURS != "") print $headerLoc->getText("headerLibraryHours");?></font></td>
          <td class="title" nowrap="yes"><font class="small"><?php if (OBIB_LIBRARY_HOURS != "") echo OBIB_LIBRARY_HOURS;?></font></td>
        </tr>
        <tr>
          <td class="title" nowrap="yes"><font class="small"><?php if (OBIB_LIBRARY_PHONE != "") print $headerLoc->getText("headerLibraryPhone");?></font></td>
          <td class="title" nowrap="yes"><font class="small"><?php if (OBIB_LIBRARY_PHONE != "") echo OBIB_LIBRARY_PHONE;?></font></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
-->

<!-- OPENBIBLIO 0.4.0 -->

<table class="primary" width="100%" cellpadding="0" cellspacing="0" border="0">
  <tr bgcolor="<?php echo OBIB_TITLE_BG;?>">
    <td width="100%" class="title" valign="top">
       <?php
         if (OBIB_LIBRARY_IMAGE_URL != "") {
           echo "<img align=\"middle\" src=\"".OBIB_LIBRARY_IMAGE_URL."\" border=\"0\">";
         }
         if (!OBIB_LIBRARY_USE_IMAGE_ONLY) {
           echo " ".OBIB_LIBRARY_NAME;
         }
       ?>
    </td>
    <td valign="top">
      <table class="primary" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td class="title" nowrap="yes"><font class="small">Fecha:</font></td>
          <td class="title" nowrap="yes"><font class="small"><?php print date("d.m.Y");?></font></td>
        </tr>
        <tr>
          <td class="title" nowrap="yes"><font class="small"><?php if (OBIB_LIBRARY_HOURS != "") echo "Horario:";?></font></td>
          <td class="title" nowrap="yes"><font class="small"><?php if (OBIB_LIBRARY_HOURS != "") echo OBIB_LIBRARY_HOURS;?></font></td>
        </tr>
        <tr>
          <td class="title" nowrap="yes"><font class="small"><?php if (OBIB_LIBRARY_PHONE != "") echo "Teléfono:";?></font></td>
          <td class="title" nowrap="yes"><font class="small"><?php if (OBIB_LIBRARY_PHONE != "") echo OBIB_LIBRARY_PHONE;?></font></td>
        </tr>
		<?
		if(isset($_SESSION["userid"]))
		  {
		    $staffQ = new StaffQuery();
            $staffQ->connect();
            if ($staffQ->errorOccurred()) {
                $staffQ->close();
                displayErrorPage($staffQ);
            }
            $staffQ->execSelect($_SESSION["userid"]);
            if ($staffQ->errorOccurred()) {
                $staffQ->close();
                displayErrorPage($staffQ); 	
	        }
            $staff = $staffQ->fetchStaff(); 
			$operador=$staff->getLastName();
		  }
		?>
        <tr>
          <td class="title" nowrap="yes"><font class="small"><?php if (isset($_SESSION["userid"])) echo "Operador: "; ?></font></td>
          <td class="title" nowrap="yes"><font class="small"><?php if (isset($_SESSION["userid"])) echo $operador; ?></font></td>
        </tr>		
      </table>
    </td>
  </tr>
</table>

<!-- **************************************************************************************
     * Tabs
     **************************************************************************************-->
<table class="primary" width="100%" cellpadding="0" cellspacing="0" border="0">
  <tr>
    <td bgcolor="<?php echo OBIB_TITLE_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <td bgcolor="<?php echo OBIB_BORDER_COLOR;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <td bgcolor="<?php echo OBIB_TITLE_BG;?>" colspan="3"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <td bgcolor="<?php echo OBIB_BORDER_COLOR;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <td bgcolor="<?php echo OBIB_TITLE_BG;?>" colspan="3"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <td bgcolor="<?php echo OBIB_BORDER_COLOR;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <td bgcolor="<?php echo OBIB_TITLE_BG;?>" colspan="3"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <td bgcolor="<?php echo OBIB_BORDER_COLOR;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <td bgcolor="<?php echo OBIB_TITLE_BG;?>" colspan="3"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <td bgcolor="<?php echo OBIB_BORDER_COLOR;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <td bgcolor="<?php echo OBIB_TITLE_BG;?>" colspan="3"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <td bgcolor="<?php echo OBIB_BORDER_COLOR;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <td bgcolor="<?php echo OBIB_TITLE_BG;?>" colspan="3"><img src="../images/shim.gif" width="1" height="1" border="0"></td>	
  </tr>
  <tr bgcolor="<?php echo OBIB_TITLE_BG;?>">
    <td bgcolor="<?php echo OBIB_BORDER_COLOR;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>

    <?php if ($tab == "home") { ?>
      <td  bgcolor="<?php echo OBIB_ALT1_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } else { ?>
      <td  bgcolor="<?php echo OBIB_ALT2_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } ?>

    <td bgcolor="<?php echo OBIB_BORDER_COLOR;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <td bgcolor="<?php echo OBIB_TITLE_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <td bgcolor="<?php echo OBIB_BORDER_COLOR;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>

    <?php if ($tab == "circulation") { ?>
      <td  bgcolor="<?php echo OBIB_ALT1_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } else { ?>
      <td  bgcolor="<?php echo OBIB_ALT2_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } ?>

    <td bgcolor="<?php echo OBIB_BORDER_COLOR;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <td bgcolor="<?php echo OBIB_TITLE_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <td bgcolor="<?php echo OBIB_BORDER_COLOR;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>

    <?php if ($tab == "cataloging") { ?>
      <td  bgcolor="<?php echo OBIB_ALT1_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } else { ?>
      <td  bgcolor="<?php echo OBIB_ALT2_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } ?>

    <td bgcolor="<?php echo OBIB_BORDER_COLOR;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <td bgcolor="<?php echo OBIB_TITLE_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <td bgcolor="<?php echo OBIB_BORDER_COLOR;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>

    <?php if ($tab == "admin") { ?>
      <td  bgcolor="<?php echo OBIB_ALT1_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } else { ?>
      <td  bgcolor="<?php echo OBIB_ALT2_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } ?>

    <td bgcolor="<?php echo OBIB_BORDER_COLOR;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <td bgcolor="<?php echo OBIB_TITLE_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <td bgcolor="<?php echo OBIB_BORDER_COLOR;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>

    <?php if ($tab == "reports") { ?>
      <td  bgcolor="<?php echo OBIB_ALT1_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } else { ?>
      <td  bgcolor="<?php echo OBIB_ALT2_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } ?>
	
    <td bgcolor="<?php echo OBIB_BORDER_COLOR;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <td bgcolor="<?php echo OBIB_TITLE_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <td bgcolor="<?php echo OBIB_BORDER_COLOR;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>

    <?php if ($tab == "adquisiciones") { ?>
      <td  bgcolor="<?php echo OBIB_ALT1_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } else { ?>
      <td  bgcolor="<?php echo OBIB_ALT2_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } ?>	

    <td bgcolor="<?php echo OBIB_BORDER_COLOR;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <td bgcolor="<?php echo OBIB_TITLE_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <td width="2000" bgcolor="<?php echo OBIB_TITLE_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>

  </tr>
  <tr bgcolor="<?php echo OBIB_TITLE_BG;?>">
    <?php if ($tab == "home") { ?>
      <td  bgcolor="<?php echo OBIB_ALT1_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
      <td class="tab1" nowrap="yes"> <?php print $headerLoc->getText("headerHome"); ?></td>
      <td  bgcolor="<?php echo OBIB_ALT1_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } else { ?>
      <td  bgcolor="<?php echo OBIB_ALT2_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
      <td class="tab2" nowrap="yes"> <a href="../home/index.php" class="tab"><?php print $headerLoc->getText("headerHome"); ?></a> </td>
      <td  bgcolor="<?php echo OBIB_ALT2_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } ?>

    <td bgcolor="<?php echo OBIB_BORDER_COLOR;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>

    <?php if ($tab == "circulation") { ?>
      <td  bgcolor="<?php echo OBIB_ALT1_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
      <td class="tab1" nowrap="yes"> <?php print $headerLoc->getText("headerCirculation"); ?></td>
      <td  bgcolor="<?php echo OBIB_ALT1_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } else { ?>
      <td  bgcolor="<?php echo OBIB_ALT2_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
      <td class="tab2" nowrap="yes"> <a href="../circ/index.php" class="tab"><?php print $headerLoc->getText("headerCirculation"); ?></a> </td>
      <td  bgcolor="<?php echo OBIB_ALT2_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } ?>

    <td bgcolor="<?php echo OBIB_BORDER_COLOR;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>

    <?php if ($tab == "cataloging") { ?>
      <td  bgcolor="<?php echo OBIB_ALT1_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
      <td class="tab1" nowrap="yes"> <?php print $headerLoc->getText("headerCataloging"); ?></td>
      <td  bgcolor="<?php echo OBIB_ALT1_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } else { ?>
      <td  bgcolor="<?php echo OBIB_ALT2_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
      <td class="tab2" nowrap="yes"> <a href="../catalog/index.php" class="tab"><?php print $headerLoc->getText("headerCataloging"); ?></a> </td>
      <td  bgcolor="<?php echo OBIB_ALT2_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } ?>

    <td bgcolor="<?php echo OBIB_BORDER_COLOR;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>

    <?php if ($tab == "admin") { ?>
      <td  bgcolor="<?php echo OBIB_ALT1_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
      <td class="tab1" nowrap="yes"> <?php print $headerLoc->getText("headerAdmin"); ?></td>
      <td  bgcolor="<?php echo OBIB_ALT1_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } else { ?>
      <td  bgcolor="<?php echo OBIB_ALT2_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
      <td class="tab2" nowrap="yes"> <a href="../admin/index.php" class="tab"><?php print $headerLoc->getText("headerAdmin"); ?></a> </td>
      <td  bgcolor="<?php echo OBIB_ALT2_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } ?>

    <td bgcolor="<?php echo OBIB_BORDER_COLOR;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>

    <?php if ($tab == "reports") { ?>
      <td  bgcolor="<?php echo OBIB_ALT1_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
      <td class="tab1" nowrap="yes"> <?php print $headerLoc->getText("headerReports"); ?></td>
      <td  bgcolor="<?php echo OBIB_ALT1_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } else { ?>
      <td  bgcolor="<?php echo OBIB_ALT2_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
      <td class="tab2" nowrap="yes"> <a href="../reports/index.php" class="tab"><?php print $headerLoc->getText("headerReports"); ?></a> </td>
      <td  bgcolor="<?php echo OBIB_ALT2_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } ?>
	
    <td bgcolor="<?php echo OBIB_BORDER_COLOR;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>

    <?php if ($tab == "adquisiciones") { ?>
      <td  bgcolor="<?php echo OBIB_ALT1_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
      <td class="tab1" nowrap="yes"> <?php print "Adquisiciones"; ?></td>
      <td  bgcolor="<?php echo OBIB_ALT1_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } else { ?>
      <td  bgcolor="<?php echo OBIB_ALT2_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
      <td class="tab2" nowrap="yes"> <a href="../adquisiciones/index.php" class="tab"><?php print "Adquisiciones"; ?></a> </td>
      <td  bgcolor="<?php echo OBIB_ALT2_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } ?>	

    <td bgcolor="<?php echo OBIB_BORDER_COLOR;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <td width="2000" bgcolor="<?php echo OBIB_TITLE_BG;?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>

  </tr>
  <tr bgcolor="<?php echo OBIB_BORDER_COLOR;?>">
    <td colspan="3" <?php if ($tab == "home") { print " bgcolor='".OBIB_ALT1_BG."'"; } ?>><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <td><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <td colspan="3" <?php if ($tab == "circulation") { print " bgcolor='".OBIB_ALT1_BG."'"; } ?>><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <td><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <td colspan="3" <?php if ($tab == "cataloging") { print " bgcolor='".OBIB_ALT1_BG."'"; } ?>><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <td><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <td colspan="3" <?php if ($tab == "admin") { print " bgcolor='".OBIB_ALT1_BG."'"; } ?>><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <td><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <td colspan="3" <?php if ($tab == "reports") { print " bgcolor='".OBIB_ALT1_BG."'"; } ?>><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <td><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <td colspan="3" <?php if ($tab == "adquisiciones") { print " bgcolor='".OBIB_ALT1_BG."'"; } ?>><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <td><img src="../images/shim.gif" width="1" height="1" border="0"></td>	
    <td><img src="../images/shim.gif" width="1" height="1" border="0"></td>
  </tr>
</table>
