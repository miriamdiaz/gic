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


 if (isset($_SESSION["userid"])) {
   $sess_userid = $_SESSION["userid"];
 } else {
   $sess_userid = "";
 }
 if ($sess_userid == "") { ?>
  <input type="button" onClick="parent.location='../shared/loginform.php?RET=<?php echo $_SERVER["PHP_SELF"];?>'" value="<?php echo $navLoc->getText("login");?>" class="navbutton">
<?php } else { ?>
  <input type="button" onClick="parent.location='../shared/logout.php'" value="<?php echo $navLoc->getText("logout");?>" class="navbutton">
<?php } ?>
<br><br>

<?php if ($nav == "home") { ?>
 &raquo; <?php echo $navLoc->getText("homeHomeLink");?><br>
<?php } else { ?>
 <a href="../home/index.php" class="alt1"><?php echo $navLoc->getText("homeHomeLink");?></a><br>
<?php } ?>
<br>

<?php //ini franco 14/07/05
if (OBIB_OPAC_URL != "")
{ ?>
    <a href="<?php echo OBIB_OPAC_URL;?>"><?php print $headerLoc->getText("footerOPAC"); ?></a> 
<?php } //fin franco ?> <br>
<br>
<?php if ($nav == "advancesearch") { ?>
 &raquo; <?php echo $navLoc->getText("homeAdvancedSearch");?><br>
<?php } else 
{ 
	$rptTitle= $navLoc->getText("homeAdvancedSearch");
	$rptid="criterios";
	$title=$navLoc->getText("homeAdvancedSearch");
$sql="select * from ( ";
$sql.="select  ";
$sql.="SUBSTRING(biblio.title,1,100) as title, ";
$sql.="SUBSTRING(biblio.author,1,100) as author, ";
$sql.="SUBSTRING(biblio.responsibility_stmt,1,100) as responsabilidad_sec, ";
$sql.="biblio.call_nmbr1, ";
$sql.="concat(max(topic1),max(topic2),max(topic3),max(topic4),max(topic5)) as Materia, ";
$sql.="material_type_dm.description as 'material', ";
$sql.="collection_dm.description as 'coleccion', ";
$sql.="max(if(biblio_field.tag=020 and biblio_field.subfield_cd='a',biblio_field.field_data,NULL)) as 'isbn', ";
$sql.="max(if(biblio_field.tag=022 and biblio_field.subfield_cd='a',biblio_field.field_data,NULL)) as 'issn', ";
$sql.="max(if(biblio_field.tag=110 and biblio_field.subfield_cd='a',biblio_field.field_data,NULL)) as 'autor_corporativo', ";
$sql.="max(if(biblio_field.tag=260 and biblio_field.subfield_cd='b',biblio_field.field_data,NULL)) as 'editor', ";
$sql.="max(if(biblio_field.tag=250 and biblio_field.subfield_cd='a',biblio_field.field_data,NULL)) as 'edicion', ";
$sql.="max(if(biblio_field.tag=260 and biblio_field.subfield_cd='c',biblio_field.field_data,NULL)) as 'publicacion', ";
$sql.="max(if(biblio_field.tag=440 and biblio_field.subfield_cd='a',biblio_field.field_data,NULL)) as 'coleccion_usmarc', ";
$sql.="group_concat(distinct(biblio_copy.barcode_nmbr)) as Ejemplares ";
$sql.="from biblio , ";
$sql.="biblio_copy , ";
$sql.="biblio_field , ";
$sql.="material_type_dm , ";
$sql.="collection_dm ";
$sql.="where biblio.bibid=biblio_field.bibid ";
$sql.="and biblio.bibid = biblio_copy.bibid ";
$sql.="and biblio.material_cd=material_type_dm.code ";
$sql.="and biblio.collection_cd=collection_dm.code ";
$sql.="and biblio_field.field_data<>'' ";
$sql.="and( (biblio_field.tag=020 and biblio_field.subfield_cd='a') ";
$sql.="     or (biblio_field.tag=022 and  biblio_field.subfield_cd='a') ";
$sql.="     or (biblio_field.tag=110 and biblio_field.subfield_cd='a') ";
$sql.="     or (biblio_field.tag=260 and biblio_field.subfield_cd='b') ";
$sql.="     or (biblio_field.tag=250 and biblio_field.subfield_cd='a') ";
$sql.="     or (biblio_field.tag=260 and biblio_field.subfield_cd='c') ";
$sql.="     or (biblio_field.tag=440 and biblio_field.subfield_cd='a')) ";
$sql.=" group by biblio.bibid) hola where 1=1";
	echo "<a href=\"../shared/advanced_search.php?reset=Y&rptid=".$rptid."&title=".$title."&sql=".$sql."\">".$rptTitle."</a>";
}	?>

<?
//if(isset($_SESSION["usuarios_online_flg"]))
if(OBIB_USUARIOS_ONLINE_FLG == "Y")
{
?>
<br>
<BR>
<?php if ($nav == "info_usuarios") { ?>
 &raquo; <?php echo $navLoc->getText("homeMemberOnline");?><br>
<?php } else { ?>
 <a href="../home/info_usuarios.php" class="alt1"><?php echo $navLoc->getText("homeMemberOnline");?></a>
<?php } 
}
?>

<?
//if(isset($_SESSION["docentes_online_flg"]))
if(OBIB_DOCENTES_ONLINE_FLG == "Y")
{
?>
<br>
<br>
<?php if ($nav == "adquisicion") { ?>
 &raquo; <?php echo "Adquisiciones Online";?><br>
<?php } else { ?>
 <a href="../home/adquisicion.php" class="alt1"><?php echo "Adquisiciones Online";?></a>
<?php }
}
?>

<?php if ($nav == "reglament") { ?>
<BR>
 &raquo; <?php echo $navLoc->getText("homeReglament");?><br>
<?php } else { ?>
<BR><BR>
<a href="javascript:popSecondaryLarge('../locale/es/Reglament/SIUNPA - Reglamento aprobado 2001.pdf')"><?php echo $navLoc->getText("homeReglament"); ?></a><br>
<?php } ?>


<?php if ($nav == "license") { ?>
<br>
 &raquo; <?php echo $navLoc->getText("homeLicenseLink");?><br>
<?php } else { ?>
<BR>
 <a href="../home/license.php" class="alt1"><?php echo $navLoc->getText("homeLicenseLink");?></a><br>
<?php } ?>
<br>
<a href="javascript:popSecondary('../shared/help.php<?php if (isset($helpPage)) echo "?page=".$helpPage; ?>')"><?php echo $navLoc->getText("help");?></a>
<br>
<br>
<img src="../images/logounpa.jpg" border="0"  align="justify" width='100' height='150'>