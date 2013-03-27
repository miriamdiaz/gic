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

  $tab = "adquisiciones";
  $nav = "summary";

  require_once("../shared/common.php");
  include("../shared/logincheck.php");
  include("../shared/header.php");
  require_once("../classes/AdquisicionQuery.php");
  require_once("../classes/Adquisicion.php");
  require_once("../funciones.php");  
  require_once("../classes/Localize.php");
  require_once("../functions/inputFuncs.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

?>

<h1><img src="../images/reports.png" border="0" width="30" height="30" align="top"> <?php echo "Adquisiciones";?></h1>
<?php echo "Módulo destinado a la gestión de adquisiciones de la biblioteca";?>
<br><br>
<form action="index.php" name="info" method="post">
<div align="center">
<table class="primary">
<tr><th colspan="2" align="left">Buscar Pedidos</th></tr>
<tr>
<td class="primary"><?php print "Nro. de Pedido"; ?></td>
<td class="primary"><input type="text" name="adqid" maxlength="5" size="5"></td>
</tr>
<tr>
<td class="primary"><?php print "Concepto"; ?></td>
<td class="primary"><?php printConceptosActivos("concepto_cd","concepto_dm",$postVars,$pageErrors); ?></td>
</tr>
<tr>
<td colspan="2"><div align="center"><br><input type="submit" name="buscar" value="Buscar" class="button"></div></td>
</tr>
</table>
</div>
</form>
<?
if((isset($_POST["buscar"]) || isset($_GET["buscar"])) || isset($_POST["adqid"]) || isset($_POST["cocepto_cd"]))
   {
   ?>
      <div align="center">
	   <table class="primary">
	  <tr>
		<th valign="top" nowrap="yes" align="left" colspan="3">
		  <?php print "Funciones"; ?>
		</th>  
		<th valign="top" nowrap="yes" align="left">
		  <?php print "Nro."; ?>
		</th>	
		<th valign="top" nowrap="yes" align="left">
		  <?php print "Concepto"; ?>
		</th>
		<th valign="top" align="left">
		  <?php print "Estado"; ?>
		</th>			
		<th valign="top" nowrap="yes" align="left">
		  <?php print "Título"; ?>
		</th>
		<th valign="top" nowrap="yes" align="left">
		  <?php print "Autor"; ?>
		</th>
		<th valign="top" nowrap="yes" align="left">
		  <?php print "I.S.B.N"; ?>
		</th>
		<th valign="top" nowrap="yes" align="left">
		  <?php print "Edición"; ?>
		</th>
		<th valign="top" nowrap="yes" align="left">
		  <?php print "Editorial"; ?>
		</th>
		<th valign="top" align="left">
		  <?php print "Biblioteca"; ?>
		</th>
		<th valign="top" align="left">
		  <?php print "Área"; ?>
		</th>	
		<th valign="top" align="left">
		  <?php print "Creado"; ?>
		</th>					
	  </tr>
	  <?
	   
	$where = " 1 = 1 ";
	if(isset($_POST["concepto_cd"]))
	   if(!empty($_POST["concepto_cd"]))
           $where .= " AND concepto_cd = ".$_POST["concepto_cd"];
	
	if(isset($_POST["adqid"]))
	  {
	   if(!empty($_POST["adqid"]))
           $where .= " AND adqid = ".$_POST["adqid"];
	  }
	elseif(isset($_GET["code"]))
	    if(!empty($_POST["code"]))
	       $where .= " AND adqid = ".$_GET["code"];
	
	$adquisicionQ = new AdquisicionQuery();
    $adquisicionQ->connect();
    if ($adquisicionQ->errorOccurred()) {
        $adquisicionQ->close();
        displayErrorPage($adquisicionQ);
    }
    if (!$adquisicionQ->execSelectWhere($where)) {
        //$adquisicionQ->close();
        //displayErrorPage($adquisicionQ);
     }
	 
	  $dmQ = new DmQuery();
	  $dmQ->connect();
	  if ($dmQ->errorOccurred()) {
		//$dmQ->close();
		displayErrorPage($dmQ);
	  }

	  $dmQ->execSelect("concepto_dm");
	  $conceptoDm = $dmQ->fetchRows();
	  $dmQ->execSelect("area_dm");
	  $areaDm = $dmQ->fetchRows();
	  $dmQ->execSelect("biblio_cod_library");
	  $biblio_cod_library = $dmQ->fetchRows();    
	  $dmQ->execSelect("estado_dm");
	  $estadoDm = $dmQ->fetchRows();
	  $dmQ->execSelect("mbr_classify_dm");
	  $mbrClassifyDm = $dmQ->fetchRows();  
	  //$dmQ->close();   	 

    if ($adquisicionQ->getRowCount() == 0) {
       ?>
		  <tr>
			<td class="primary" align="center" colspan="15">
			  <?php print "No se econtraron pedidos"; ?>
			</td>
		  </tr>
		<?php
		  } else {
			while ($adq = $adquisicionQ->fetchAdquisicion()) {
		?>
		  <tr>
			<td class="primary" valign="top" nowrap="yes">
			   <a href="../adquisiciones/adquisiciones_edit_form.php?code=<?php echo $adq->getAdqid();?>&reset=Y" class="<?php echo $row_class;?>"><? echo "Editar"; ?></a>
			</td>
			<td class="primary" valign="top" nowrap="yes">
			  <a href="../adquisiciones/adquisiciones_del_confirm.php?code=<?php echo $adq->getAdqid();?>" class="<?php echo $row_class;?>"><? echo "Eliminar"; ?></a>
			</td>	  
			<td class="primary" valign="top" nowrap="yes">
			  <a href="#" onClick="window.open('../adquisiciones/adquisiciones_status_hist.php?code=<?php echo $adq->getAdqid();?>','secondary','resizable=yes,scrollbars=yes,width=400,height=400')">Historial</a>
			</td>	  			
			<td class="primary" valign="top" nowrap="yes">
			  <?php echo $adq->getAdqid();?>
			</td>	
			<td class="primary" valign="top" nowrap="yes">
			  <?php echo $conceptoDm[$adq->getConceptoCd()];?>
			</td>
			<td class="primary" valign="top" >
			  <?php echo $estadoDm[$adq->getEstadoCd()];?>
			</td>			
			<td class="primary" valign="top">
			  <?php echo $adq->getTitle();?>
			</td>
			<td class="primary" valign="top" >
			  <?php echo $adq->getAuthor();?>
			</td>
			<td class="primary" valign="top" >
			  <?php echo $adq->getIsbn();?>
			</td>
			<td class="primary" valign="top" >
			  <?php echo $adq->getEdicionDt();?>
			</td>
			<td class="primary" valign="top" nowrap="yes">
			  <?php echo $adq->getEditorial();?>
			</td>
			<td class="primary" valign="top" >
			  <?php echo $adq->getLibraryId();?>
			</td>	
			<td class="primary" valign="top" >
			  <?php echo $areaDm[$adq->getAreaCd()];?>
			</td>		
			<td class="primary" valign="top" >
			  <?php echo toDDmmYYYY($adq->getCreatedDt());?>
			</td>							
		  </tr>
		<?php
			}
		}
	$adquisicionQ->close();
	?>
	</table>
	</div>
	<?
   }
?>
<br><br><br><br><br>

<?php include("../shared/footer.php"); ?>
