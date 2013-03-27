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

  require_once("../classes/Localize.php");
  $navLoc = new Localize(OBIB_LOCALE,"navbars");

?>
<input type="button" onClick="parent.location='../shared/logout.php'" value="<?php echo $navLoc->getText("logout");?>" class="navbutton"><br />
<br />

<?php if ($nav == "summary") { ?>
 &raquo; <?php echo $navLoc->getText("adminSummary");?><br>
<?php } else { ?>
 <a href="../admin/index.php" class="alt1"><?php echo $navLoc->getText("adminSummary");?></a><br>
<?php } ?>

<!-- eduardo -->
<?php if ($nav == "novedades") { ?>
 &raquo; Novedades<br>
<?php } else { ?>
 <a href="../novedades/browse.php" class="alt1">Novedades</a><br>
<?php } ?>
<!-- eduardo -->



<?php 
  /*
  Autor: Horacio Alvarez
  Fecha: 05-07-2006
  Descripcion: se agregaron mas permisos.
  */
if($_SESSION["hasAdminBiblioAuth"])
{
if ($nav == "staff") { ?>
 &raquo; <?php echo $navLoc->getText("adminStaff");?><br>
<?php } else { ?>
 <a href="../admin/staff_list.php" class="alt1"><?php echo $navLoc->getText("adminStaff");?></a><br>
<?php } 
}

?>

<!--Name: Horacio Alvarez
    Date: 2006-03-15
	Description: Se agrega el item Tipo de Prestamos -->
<?php if ($nav == "tipo_prestamos") { ?>
 &raquo; <?php echo $navLoc->getText("adminTipoPrestamos");?><br>
<?php } else { ?>
 <a href="../admin/tipo_prestamos_list.php" class="alt1"><?php echo $navLoc->getText("adminTipoPrestamos");?></a><br>
<?php } ?>
<!-- FIN  -->

<!--Name: Horacio Alvarez
    Date: 2006-06-20
	Description: Se agrega el item Tipo de Socios -->
<?php if ($nav == "tipo_socios") { ?>
 &raquo; <?php echo $navLoc->getText("adminTipoSocios");?><br>
<?php } else { ?>
 <a href="../admin/tipo_socios_list.php" class="alt1"><?php echo $navLoc->getText("adminTipoSocios");?></a><br>
<?php } ?>
<!-- FIN  -->

<!--Name: Horacio Alvarez
    Date: 2006-04-01
	Description: Se agrega el item Tipo de Sanciones -->
<?php if ($nav == "tipo_sanciones") { ?>
 &raquo; <?php echo $navLoc->getText("adminTipoSanciones");?><br>
<?php } else { ?>
 <a href="../admin/tipo_sanciones_list.php" class="alt1"><?php echo $navLoc->getText("adminTipoSanciones");?></a><br>
<?php } ?>
<!-- FIN  -->

<?php if ($nav == "settings") { ?>
 &raquo; <?php echo $navLoc->getText("adminSettings");?><br>
<?php } else { ?>
 <a href="../admin/settings_edit_form.php?reset=Y" class="alt1"><?php echo $navLoc->getText("adminSettings");?></a><br>
<?php } ?>

<?php //if ($nav == "materials") { ?>
<!-- &raquo; <?php //echo $navLoc->getText("adminMaterialTypes");?><br>
<?php //} else { ?>
 <a href="../admin/materials_list.php" class="alt1"><?php //echo $navLoc->getText("adminMaterialTypes");?></a><br>
<?php //} ?>

<?php //if ($nav == "collections") { ?>
 &raquo; <?php// echo $navLoc->getText("adminCollections");?><br>
<?php// } //else { ?>
 <a href="../admin/collections_list.php" class="alt1"><?php //echo $navLoc->getText("adminCollections");?></a><br>
<?php //} ?> -->

<?php if ($nav == "themes") { ?>
 &raquo; <?php echo $navLoc->getText("adminThemes");?><br>
<?php } else { ?>
 <a href="../admin/theme_list.php" class="alt1"><?php echo $navLoc->getText("adminThemes");?></a><br>
<?php } ?>

<?php if ($nav == "mails") { ?>
 &raquo; <?php echo $navLoc->getText("adminMails");?><br>
<?php } else { ?>
 <a href="../admin/mails.php" class="alt1"><?php echo $navLoc->getText("adminMails");?></a><br>
<?php } ?>

<?
if($_SESSION["hasExportarAuth"])
  {
?>
<a href="javascript:popSecondary('../exportador_biblios.php')">Exportar</a><br>
<a href="javascript:popSecondary('../exportador_biblios_revistas.php')">Exportar (incluye revistas)</a><br>

<? } ?>

<?
if($_SESSION["hasImportarAuth"])
  {
?>
<a href="javascript:popSecondary('../importador_biblios.html')">Importar</a><br>
<a href="javascript:popSecondary('../importador_biblios_revistas.html')">Importar (Incluye revistas)</a><br>
<? } ?>
<!--
< ?php if ($nav == "translation") { ?>
 &raquo; < ?php echo $navLoc->getText("adminTranslation");?><br>
< ?php } else { ?>
 <a href="../admin/translation_list.php" class="alt1">< ?php echo $navLoc->getText("adminTranslation");?></a><br>
< ?php } ?>
-->

<a href="javascript:popSecondary('../shared/help.php<?php if (isset($helpPage)) echo "?page=".$helpPage; ?>')"><?php echo $navLoc->getText("help");?></a>

